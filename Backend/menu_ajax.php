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

