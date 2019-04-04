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

add_action( 'wp_ajax_add_new_order', 'add_new_order' );
add_action( 'wp_ajax_nopriv_add_new_order', 'add_new_order' );

function orders_select(){
    $conn = DBHelper::connect();

    $sqlQuery = "SELECT *, DATE_FORMAT(order_time, '%H:%i %d.%m.%y') AS time_c
                 FROM orders";

    $params = array();
    if ($_POST['unique_num'] != null)  $params[] = "unique_num = " . $_POST['unique_num'];
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

//function get_next_order_id(){
//    $conn = DBHelper::connect();
//
//    $sqlQuery = "SELECT AUTO_INCREMENT
//                 FROM information_schema.TABLES
//                 WHERE TABLE_SCHEMA = 'cafe'
//                   AND TABLE_NAME = 'orders';";
//
//    $res = array();
//
//    try{
//        $stmt = $conn->prepare($sqlQuery);
//        $stmt->execute();
//        $row = $stmt->fetch();
//
//        $res['next_id'] = $row[0];
//
//        echo json_encode($res, JSON_UNESCAPED_UNICODE);
//    }catch (Exception $e){
//        echo 'Exception: ',  $e->getMessage(), "\n";
//        echo $e;
//    }
//
//    DBHelper::disconnect();
//    die;
//}



function add_new_order(){
    $conn = DBHelper::connect();
    $sqlQuery =
        str_replace(
            "'NULL'", "NULL",
            "INSERT INTO orders
        (order_time, table_num, is_paid, cost, n_people, tab_num)
        VALUES ('"
            .$_POST['order_time']."', "
            .$_POST['table_num'].", "
            .$_POST['is_paid'].", "
            .$_POST['cost'].","
            .$_POST['n_people'].", "
            .$_POST['tab_num'].");");
    try {
        $conn->query($sqlQuery);
        $last_id = $conn->lastInsertId();

        $portions = $_POST['portions'];
        if($portions != null){
            foreach ($portions as $portion){
//                echo $portion['price'];
                for ($i = 0; $i < $portion['quantity']; $i++) {
                    $special_wishes = $portion['special_wishes'] == '' ? 'NULL' : $portion['special_wishes'];

                    $sqlQuery =
                        str_replace(
                            "'NULL'", "NULL",
                            "INSERT INTO portions
                                (price, special_wishes, order_num, tech_card_num)
                                VALUES (".$portion['price'].",
                                      '" .$special_wishes."', 
                                       " .$last_id.", 
                                       " .$portion['tech_card_num'].");");
                    $conn->query($sqlQuery);
                }
            }
        }

        $res = array();
        $res['last_id'] = $last_id;
        echo json_encode($res, JSON_UNESCAPED_UNICODE);

    } catch (Exception $e) {
        echo 'Exception: ',  $e->getMessage(), "\n";
        echo $sqlQuery;
    }
    DBHelper::disconnect();
    die;
}