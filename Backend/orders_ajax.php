<?php
/**
 * Created by PhpStorm.
 * User: San Nguyen
 * Date: 17.03.2019
 * Time: 16:55
 */

require_once 'dbhelper.php';

add_action( 'wp_ajax_orders_select', 'orders_select' );
add_action( 'wp_ajax_nopriv_orders_select', 'orders_select' );

add_action( 'wp_ajax_get_next_order_id', 'get_next_order_id' );
add_action( 'wp_ajax_nopriv_get_next_order_id', 'get_next_order_id' );

add_action( 'wp_ajax_choose_order_dish_mode', 'choose_order_dish_mode' );
add_action( 'wp_ajax_nopriv_choose_order_dish_mode', 'choose_order_dish_mode' );


function orders_select(){
    $conn = DBHelper::connect();

    $sqlQuery = "SELECT *, DATE_FORMAT(close_time, '%H:%i %d.%m.%y') AS time_c
                 FROM orders";

    $params = array();
    if ($_POST['is_closed'] != null)  $params[] = "is_closed = " . $_POST['is_closed'];
    if ($_POST['tab_num'] != null) $params[] = "tab_num = " . $_POST['tab_num'];
    if ($_POST['name'] != null) {
        $workerQuery =
            "(SELECT tab_num
             FROM workers 
             WHERE CONCAT(first_name, ' ', surname, ' ', COALESCE (father_name, '')) LIKE '%" . $_POST['name'] . "%')";
        $params[] = "tab_num IN " . $workerQuery;
    }
    if ($_POST['order_time_from'] != null)   $params[] = "DATE(order_time) >= '" . $_POST['order_time_from'] . "'";
    if ($_POST['order_time_to'] != null) $params[] = "DATE(order_time) <= '" . $_POST['order_time_to'] . "'";

    $whereQuery = join(' AND ', $params);
    if (count($params) > 0) $whereQuery = " WHERE " . $whereQuery;
    $sqlQuery = $sqlQuery . $whereQuery . " ORDER BY close_time DESC;";

    //
    try {
        $orders = array();
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {


            $portionsQuery = "SELECT tech_card_num, special_wishes, SUM(price) AS price, discount, is_ready, is_served, COUNT(*) AS quantity
                              FROM portions 
                              WHERE order_num = " . $row['unique_num'] .
                             " GROUP BY tech_card_num, special_wishes, price, is_ready, is_served, discount;";
            $portions = array();
            foreach ($conn->query($portionsQuery, PDO::FETCH_ASSOC) as $p) {

                $dishQuery = "SELECT dish_name FROM dishes WHERE tech_card_num = " . $p['tech_card_num'] . ";";
                foreach ($conn->query($dishQuery, PDO::FETCH_ASSOC) as $dish) {
                    $p['dish_name'] = $dish['dish_name'];
                }

                $portions[] = $p;
            }

            $row['portions'] = $portions;


            $personnelQuery = "SELECT CONCAT(surname, ' ', LEFT(first_name, 1), '. ', COALESCE(CONCAT(LEFT(father_name, 1),'.'), '')) AS pib FROM workers WHERE tab_num = " . $row['tab_num'] . ";";
            foreach ($conn->query($personnelQuery, PDO::FETCH_ASSOC) as $person) {
                $row['name'] = $person['pib'];
            }

            $orders[] = $row;
        }
        echo json_encode($orders, JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
        echo $sqlQuery;
    }
    DBHelper::disconnect();
    die;
}

function get_next_order_id(){
    $conn = DBHelper::connect();

    $sqlQuery = "SELECT AUTO_INCREMENT
                 FROM information_schema.TABLES
                 WHERE TABLE_SCHEMA = 'cafe'
                   AND TABLE_NAME = 'orders';";

    $res = array();

    try{
        $stmt = $conn->prepare($sqlQuery);
        $stmt->execute();
        $row = $stmt->fetch();

        $res['next_id'] = $row[0];

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    }catch (Exception $e){
        echo 'Exception: ',  $e->getMessage(), "\n";
        echo $e;
    }

    DBHelper::disconnect();
    die;
}

function choose_order_dish_mode(){
    if($_POST['order_num'] != null){
        session_start();
        $_SESSION["order_num"] = $_POST['order_num'];

        echo 'Success';
    }
}