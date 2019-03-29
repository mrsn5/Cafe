<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/28/2019
 * Time: 10:59 PM
 */

require_once 'dbhelper.php';

add_action('wp_ajax_units_select', 'units_select');
add_action('wp_ajax_nopriv_units_select', 'units_select');

function units_select(){
    $conn = DBHelper::connect();

    $sqlQuery = "SELECT unit_name
                 FROM units;";

    $units = array();
    foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
        $units[] = $row;
    }
    echo json_encode($units, JSON_UNESCAPED_UNICODE);
    DBHelper::disconnect();
    die;
}