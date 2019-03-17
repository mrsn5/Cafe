<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/17/2019
 * Time: 11:32 AM
 */

require_once 'dbhelper.php';


add_action( 'wp_ajax_average_client_time', 'average_client_time' );
add_action( 'wp_ajax_nopriv_average_client_time', 'average_client_time' );

add_action( 'wp_ajax_orders_amount', 'orders_amount' );
add_action( 'wp_ajax_nopriv_orders_amount', 'orders_amount' );

add_action( 'wp_ajax_average_orders_cost', 'average_orders_cost' );
add_action( 'wp_ajax_nopriv_average_orders_cost', 'average_orders_cost' );

add_action( 'wp_ajax_average_orders_cost_per_person', 'average_orders_cost_per_person' );
add_action( 'wp_ajax_nopriv_average_orders_cost_per_person', 'average_orders_cost_per_person' );

add_action( 'wp_ajax_best_workers_orders_amount', 'best_workers_orders_amount' );
add_action( 'wp_ajax_nopriv_best_workers_orders_amount', 'best_workers_orders_amount' );

add_action( 'wp_ajax_best_workers_income', 'best_workers_income' );
add_action( 'wp_ajax_nopriv_best_workers_income', 'best_workers_income' );

add_action( 'wp_ajax_category_portions_amount', 'category_portions_amount' );
add_action( 'wp_ajax_nopriv_category_portions_amount', 'category_portions_amount' );


function average_client_time(){
    $conn = DBHelper::connect();

//    if ($_POST['date_from'] != null && $_POST['date_to'] != null) {
    try{
        $sqlQuery = "SELECT IFNULL(AVG(TIME_TO_SEC(TIMEDIFF(close_time, order_time))) / 60, 0) AS avg_time
                     FROM orders
                     WHERE DATE_FORMAT(order_time,'%Y-%m-%d') BETWEEN '".$_POST['date_from']."' AND '".$_POST['date_to']."'
                       AND is_closed;";

        $res = array(); // $conn->query($sqlQuery, PDO::FETCH_ASSOC);
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $res[] = $row;
        }
        $res[0]['avg_time'] = round($res[0]['avg_time'], 2);

        echo json_encode($res[0], JSON_UNESCAPED_UNICODE);

    }catch (Exception $e) {
        echo ("Error");
        echo($e);
    }
     //    }

    DBHelper::disconnect();
    die;
}

function orders_amount(){
    $conn = DBHelper::connect();

    try{
        $sqlQuery = "SELECT COUNT(*) AS orders_amount
                     FROM orders
                     WHERE DATE_FORMAT(order_time,'%Y-%m-%d') BETWEEN '".$_POST['date_from']."' AND '".$_POST['date_to']."'
                       AND is_closed;";

        $res = array(); // $conn->query($sqlQuery, PDO::FETCH_ASSOC);
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $res[] = $row;
        }

        echo json_encode($res[0], JSON_UNESCAPED_UNICODE);

    }catch (Exception $e) {
        echo ("Error");
        echo($e);
    }
    DBHelper::disconnect();
    die;
}


function average_orders_cost(){
    $conn = DBHelper::connect();

    try{
        $sqlQuery = "SELECT IFNULL(AVG(cost), 0) AS avg_cost
                     FROM orders
                     WHERE DATE_FORMAT(order_time,'%Y-%m-%d') BETWEEN '".$_POST['date_from']."' AND '".$_POST['date_to']."'
                       AND is_closed;";

        $res = array(); // $conn->query($sqlQuery, PDO::FETCH_ASSOC);
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $res[] = $row;
        }
        $res[0]['avg_cost'] = roundValue($res[0]['avg_cost']);

        echo json_encode($res[0], JSON_UNESCAPED_UNICODE);

    }catch (Exception $e) {
        echo ("Error");
        echo($e);
    }
    DBHelper::disconnect();
    die;
}

function average_orders_cost_per_person(){
    $conn = DBHelper::connect();

    try{
        $sqlQuery = "SELECT IFNULL(SUM(cost) / SUM(n_people), 0) AS avg_cost_per_person
                     FROM orders
                     WHERE DATE_FORMAT(order_time,'%Y-%m-%d') BETWEEN '".$_POST['date_from']."' AND '".$_POST['date_to']."'
                     AND is_paid;";

        $res = array(); // $conn->query($sqlQuery, PDO::FETCH_ASSOC);
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $res[] = $row;
        }
        $res[0]['avg_cost_per_person'] = roundValue($res[0]['avg_cost_per_person']);

        echo json_encode($res[0], JSON_UNESCAPED_UNICODE);

    }catch (Exception $e) {
        echo ("Error");
        echo($e);
    }
    DBHelper::disconnect();
    die;
}


function best_workers_orders_amount(){
    $conn = DBHelper::connect();

    try{
        $sqlQuery = "SELECT workers.tab_num, CONCAT(first_name, ' ', surname) AS pib, COUNT(orders.unique_num) AS worker_res
                     FROM workers INNER JOIN orders ON workers.tab_num = orders.tab_num
                     WHERE position = 'офіціант'
                       AND fire_date IS NULL
                       AND DATE_FORMAT(close_time,'%Y-%m-%d') BETWEEN '".$_POST['date_from']."' AND '".$_POST['date_to']."'
                     GROUP BY workers.tab_num
                     ORDER BY worker_res DESC
                     LIMIT ".$_POST['first'].";";

        $res = array(); // $conn->query($sqlQuery, PDO::FETCH_ASSOC);
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $res[] = $row;
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);

    }catch (Exception $e) {
        echo ("Error");
        echo($e);
    }
    DBHelper::disconnect();
    die;
}


function best_workers_income(){
    $conn = DBHelper::connect();

    try{
        $sqlQuery = "SELECT workers.tab_num, CONCAT(first_name, ' ', surname) AS pib, SUM(cost) AS worker_res
                     FROM workers INNER JOIN orders ON workers.tab_num = orders.tab_num
                     WHERE     position = 'офіціант'
                           AND fire_date IS NULL
                           AND DATE_FORMAT(close_time,'%Y-%m-%d') BETWEEN '".$_POST['date_from']."' AND '".$_POST['date_to']."'
                     GROUP BY workers.tab_num
                     ORDER BY worker_res DESC
                     LIMIT ".$_POST['first'].";";

        $res = array(); // $conn->query($sqlQuery, PDO::FETCH_ASSOC);
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $res[] = $row;
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);

    }catch (Exception $e) {
        echo ("Error");
        echo($e);
    }
    DBHelper::disconnect();
    die;
}

function category_portions_amount(){
    $conn = DBHelper::connect();

    try{
        $sqlQuery = "SELECT COUNT(unique_num) AS n_portions
                     FROM (portions INNER JOIN dishes ON dishes.tech_card_num = portions.tech_card_num) 
                                 INNER JOIN dishes_categories ON dishes.tech_card_num = dishes_categories.tech_card_num
                     WHERE order_num IN (SELECT unique_num
                                         FROM orders
                                         WHERE is_paid = TRUE)
      AND dishes_categories.cat_name = '".$_POST['cat_name']."';";

        $res = array(); // $conn->query($sqlQuery, PDO::FETCH_ASSOC);
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $res[] = $row;
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);

    }catch (Exception $e) {
        echo ("Error");
        echo($e);
    }
    DBHelper::disconnect();
    die;
}

function roundValue($value){
    return round($value, 2);
}