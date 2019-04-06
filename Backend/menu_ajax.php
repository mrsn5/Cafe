<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/16/2019
 * Time: 7:00 PM
 */


require_once 'dbhelper.php';

add_action( 'wp_ajax_categories_select', 'categories_select' );
add_action( 'wp_ajax_nopriv_categories_select', 'categories_select' );

add_action( 'wp_ajax_get_ingredients', 'get_ingredients' );
add_action( 'wp_ajax_nopriv_get_ingredients', 'get_ingredients' );

add_action( 'wp_ajax_dish_add', 'dish_add' );
add_action( 'wp_ajax_nopriv_dish_add', 'dish_add' );

function categories_select(){
    $conn = DBHelper::connect();

    $sqlQuery = "SELECT *
                 FROM categories;";

    $cats = array();
    foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
        $cats[] = $row;
    }
    echo json_encode($cats, JSON_UNESCAPED_UNICODE);
    DBHelper::disconnect();
    die;
}

function get_ingredients(){
    $conn = DBHelper::connect();

    $sqlQuery = "SELECT ing_name, AVG(unit_price / graduation_rule) AS unit_price
                 FROM goods INNER JOIN units ON goods.unit_name = units.unit_name
                 UNION 
                 SELECT ing_name, 0 AS unit_price
                 FROM ingredients";

    $dishes = array();
    foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
        $dishes[] = $row;
    }
    echo json_encode($dishes, JSON_UNESCAPED_UNICODE);
    DBHelper::disconnect();
    die;
}

function dish_add(){
    $conn = DBHelper::connect();

    $sqlQuery =
        str_replace(
            "'NULL'", "NULL",
            "INSERT INTO dishes
        (tech_card_num, calc_card_num, dish_name, weight, price, is_in_menu, department, calories, cooking_time)
        VALUES ("
            .$_POST['tech_num'].", "
            .$_POST['calc_num'].", '"
            .$_POST['dish_name']."', "
            .$_POST['weight'].","
            .$_POST['price'] .", 1, '"
            .$_POST['department']."', "
            .$_POST['calories'].", "
            .$_POST['cooking_time'].");");
    try {
        $conn->query($sqlQuery);

        $conn->query("INSERT INTO dishes_categories (tech_card_num, cat_name) 
                               VALUES (". $_POST['tech_num'] .", '". $_POST['category'] ."');");

        $ings = $_POST['ings'];

        foreach($ings as $ing){
            $conn->query("INSERT INTO dishes_ingredients (tech_card_num, ing_name, amount) 
                               VALUES (". $_POST['tech_num'] .", '". $ing['ing_name'] ."', ". $ing['ing_amount'] .");");
        }

    } catch (Exception $e) {
        echo 'Exception: ', $e->getMessage(), "\n";
        echo $sqlQuery;
    }
    echo "ADDED!";
    DBHelper::disconnect();
    die;
}



