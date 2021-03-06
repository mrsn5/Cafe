<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/28/2019
 * Time: 10:59 PM
 */

require_once 'dbhelper.php';

add_action('wp_ajax_ing_units_select', 'ing_units_select');
add_action('wp_ajax_nopriv_ing_units_select', 'ing_units_select');

add_action('wp_ajax_units_select', 'units_select');
add_action('wp_ajax_nopriv_units_select', 'units_select');

add_action('wp_ajax_ingredient_select', 'ingredient_select');
add_action('wp_ajax_nopriv_ingredient_select', 'ingredient_select');

add_action('wp_ajax_ing_change', 'ing_change');
add_action('wp_ajax_nopriv_ing_change', 'ing_change');

add_action('wp_ajax_ing_add', 'ing_add');
add_action('wp_ajax_nopriv_ing_add', 'ing_add');

add_action('wp_ajax_get_all_goods', 'get_all_goods');
add_action('wp_ajax_nopriv_get_all_goods', 'get_all_goods');

add_action('wp_ajax_get_employee_by_name', 'get_employee_by_name');
add_action('wp_ajax_nopriv_get_employee_by_name', 'get_employee_by_name');

add_action('wp_ajax_iventarization', 'iventarization');
add_action('wp_ajax_nopriv_iventarization', 'iventarization');

add_action('wp_ajax_update_goods_amount', 'update_goods_amount');
add_action('wp_ajax_nopriv_update_goods_amount', 'update_goods_amount');


function ing_units_select()
{
    $conn = DBHelper::connect();

    $sqlQuery = "SELECT column_type
                 FROM information_schema.COLUMNS
                 WHERE TABLE_NAME = 'ingredients'
                   AND COLUMN_NAME = 'units';";
    $enum = null;
    $res = array();
    foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
        preg_match("/^enum\(\'(.*)\'\)$/", $row['COLUMN_TYPE'], $matches);
        $enum = explode("','", $matches[1]);
        $res->units = $enum;
    }

    echo json_encode($enum, JSON_UNESCAPED_UNICODE);
    DBHelper::disconnect();
    die;
}

function units_select()
{
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


function ingredient_select()
{
    $conn = DBHelper::connect();

    if($_POST['run_out_ings'] != null){
        $sqlQuery = 'SELECT *
                     FROM ingredients
                     WHERE curr_amount = 0;';
    }

    else if ($_POST['name'] != null && $_POST['exp_date'] != null) {
        $sqlQuery = "SELECT *
                     FROM ingredients
                     WHERE ing_name = '" . $_POST['name'] . "' 
                       AND '" . $_POST['exp_date'] . "' >= (SELECT MIN(expiration_date)
                                                       FROM goods
                                                       WHERE ing_name = '" . $_POST['name'] . "');";
//                            "IN (SELECT MIN(expiration_date)
//                              FROM goods);";
    } else if ($_POST['name'] != null) {
        $sqlQuery = "SELECT *
                     FROM ingredients
                     WHERE ing_name = '" . $_POST['name'] . "';";
    } else if ($_POST['exp_date'] != null) {
        $sqlQuery = "SELECT *
                     FROM ingredients
                     WHERE '" . $_POST['exp_date'] . "' >= (SELECT MIN(expiration_date)
                                                       FROM goods
                                                       WHERE ing_name = ingredients.ing_name);";
    } else {
        $sqlQuery = "SELECT *
                     FROM ingredients;";
    }

    try {
        $ings = array();
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $sqlQueryGoods = "SELECT delivery_num, unique_code, goods_name, production_date, expiration_date, inventarization_date, curr_amount
                              FROM goods
                              WHERE ing_name = '" . $row['ing_name'] . "';";

            $goods = array();
            foreach ($conn->query($sqlQueryGoods, PDO::FETCH_ASSOC) as $good) {
                $goods[] = $good;
            }

            $row['goods'] = $goods;
            $ings[] = $row;
        }
        echo json_encode($ings, JSON_UNESCAPED_UNICODE);
        //echo $sqlQuery;
    } catch (Exception $e) {
        echo 'Exception: ', $e->getMessage(), "\n";
        echo $sqlQuery;
    }

    DBHelper::disconnect();
    die;
}


function get_run_out_ings(){
    $conn = DBHelper::connect();

    $sqlQuery = '';

    try {
        $ings = array();
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $sqlQueryGoods = "SELECT delivery_num, unique_code, goods_name, production_date, expiration_date, inventarization_date
                              FROM goods
                              WHERE ing_name = '" . $row['ing_name'] . "';";

            $goods = array();
            foreach ($conn->query($sqlQueryGoods, PDO::FETCH_ASSOC) as $good) {
                $goods[] = $good;
            }

            $row['goods'] = $goods;
            $ings[] = $row;
        }
        echo json_encode($ings, JSON_UNESCAPED_UNICODE);
        //echo $sqlQuery;
    } catch (Exception $e) {
        echo 'Exception: ', $e->getMessage(), "\n";
        echo $sqlQuery;
    }

    DBHelper::disconnect();
    die;
}

function ing_change(){
    $conn = DBHelper::connect();

    $sqlQuery = "UPDATE ingredients SET ";

    if (isset($_POST['unit']))
        $sqlQuery = $sqlQuery . "units = '" . $_POST['unit'] . "' ";

    $sqlQuery = $sqlQuery . " WHERE ing_name = '" . $_POST['name'] . "';";
    echo $sqlQuery;

    try {
        $conn->query($sqlQuery);
    } catch (Exception $e) {
        echo 'Exception: ', $e->getMessage(), "\n";
        echo $sqlQuery;
    }

    DBHelper::disconnect();
    die;
}


function ing_add(){
    $conn = DBHelper::connect();

    $sqlQuery =
        str_replace(
            "'NULL'", "NULL",
            "INSERT INTO ingredients
                    (ing_name, units)
                    VALUES ('"
                           . $_POST['ing_name'] . "', '"
                           . $_POST['units'] . "');");
    try {
        $conn->query($sqlQuery);

    } catch (Exception $e) {
        echo 'Exception: ', $e->getMessage(), "\n";
        echo $sqlQuery;
    }
    echo "ADDED!";
    DBHelper::disconnect();
    die;
}


function get_all_goods(){
    $conn = DBHelper::connect();

    $sqlQuery = "SELECT delivery_num, unique_code, goods_name, unit_price, curr_amount, unit_name
                 FROM goods;";

    $goods = array();
    foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
        $goods[] = $row;
    }
    echo json_encode($goods, JSON_UNESCAPED_UNICODE);
    DBHelper::disconnect();
    die;
}


function get_employee_by_name(){
        $conn = DBHelper::connect();

        $sqlQuery = "SELECT tab_num
                     FROM workers
                     WHERE surname = '".$_POST['surname']."'
                       AND first_name = '".$_POST['first_name']."'
                       AND IF(father_name IS NULL , '', father_name) = '".$_POST['father_name']."';";

        $workers = array();
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $workers[] = $row;
        }
        $worker = count($workers) == 0 ? null : $workers[0];

        echo json_encode($worker, JSON_UNESCAPED_UNICODE);
        DBHelper::disconnect();
        die;
}


function iventarization(){
    $conn = DBHelper::connect();

    $sqlQuery = "SELECT unique_code, goods_name, unit_name, start_amount, start_amount*unit_price AS start_cost, 
                                    expected_amount, cost AS expected_cost, ing_name, unit_price
                     FROM goods;";

    $goods = array();
    foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
        $goods[] = $row;
    }

    echo json_encode($goods, JSON_UNESCAPED_UNICODE);
    DBHelper::disconnect();
    die;
}

function update_goods_amount(){
    $conn = DBHelper::connect();

    $goods = $_POST['goods'];

    $sqlQueryUpdate = '';
    try {
        $sqlQueryUpdate = "UPDATE goods SET
                       inventarization_date =  DATE_FORMAT(CURRENT_DATE,'%Y-%m-%d')";

        $conn->query($sqlQueryUpdate, PDO::FETCH_ASSOC);

        if($goods != null){
            foreach ($goods as $good) {
                $sqlQueryUpdate = "UPDATE goods SET
                       curr_amount = ".$good['curr_amount'].",
                       expected_amount = ".$good['curr_amount']."
                       WHERE unique_code = ".$good['good_code'].";";

                $conn->query($sqlQueryUpdate, PDO::FETCH_ASSOC);
            }
        }
    } catch (Exception $e) {
        echo 'Exception: ',  $e->getMessage(), "\n";
        echo $sqlQueryUpdate;
    }

    echo json_encode($goods, JSON_UNESCAPED_UNICODE);
    DBHelper::disconnect();
    die;
}