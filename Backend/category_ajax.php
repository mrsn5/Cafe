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
        $ings_query = "SELECT ing_name, IF(amount <= COALESCE((SELECT SUM(curr_amount)
                                                               FROM ingredients
                                                               WHERE ing_name = X.ing_name), 0), \"YES\", \"NO\") AS is_available
                       FROM dishes_ingredients X
                       WHERE tech_card_num IN (SELECT tech_card_num
                                               FROM dishes
                                               WHERE dishes.tech_card_num = ".$row['tech_card_num'].");";
        try{
            foreach ($conn->query($ings_query, PDO::FETCH_ASSOC) as $ing) {
                $ing['is_available'] = ($ing['is_available'] == "YES") ? true : false;
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