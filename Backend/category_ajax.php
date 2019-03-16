<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/16/2019
 * Time: 8:39 PM
 */


require_once 'dbhelper.php';

//add_action( 'wp_ajax_specify_cat_name', 'specify_cat_name' );
//add_action( 'wp_ajax_nopriv_specify_cat_name', 'specify_cat_name' );

add_action( 'wp_ajax_cat_select', 'cat_select' );
add_action( 'wp_ajax_nopriv_cat_select', 'cat_select' );

//$category_name = '';
//
//function specify_cat_name(){
//    global  $category_name;
//    $category_name = $_POST['category'];
//
//    echo ('SUCCESS');
//    die();
//}

function cat_select(){
    $conn = DBHelper::connect();

    $sqlQuery = "SELECT *
                 FROM dishes
                 WHERE tech_card_num IN (SELECT tech_card_num
                                         FROM dishes_categories
                                         WHERE cat_name LIKE '".$_POST['cat_name']."');";

    $ings = array();
    $dishes = array();

    foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
        $ings_query = "SELECT ingredients.ing_name, ingredients.curr_amount
                       FROM ingredients INNER JOIN dishes_ingredients ON ingredients.ing_name = dishes_ingredients.ing_name
                       WHERE tech_card_num IN (SELECT tech_card_num
                                               FROM dishes
                                               WHERE dishes.tech_card_num = ".$row['tech_card_num']." AND
                                                                dishes.tech_card_num = dishes_ingredients.tech_card_num);";
        try{
            foreach ($conn->query($ings_query, PDO::FETCH_ASSOC) as $ing) {
                $ings[] = $ing;
            }

            $row['ings'] = $ings;
            $dishes[] = $row;
            echo json_encode($dishes, JSON_UNESCAPED_UNICODE);
        }catch (Exception $e){
            echo ($e);
            DBHelper::disconnect();
            die();
        }
    }
    DBHelper::disconnect();
    die;
}