<?php
/**
 * Created by Polina Mahur.
 * User: User
 * Date: 3/27/2019
 * Time: 8:12 PM
 */

require_once 'dbhelper.php';

add_action( 'wp_ajax_delivery_select', 'delivery_select' );
add_action( 'wp_ajax_nopriv_delivery_select', 'delivery_select' );

add_action( 'wp_ajax_delivery_change', 'delivery_change');
add_action( 'wp_ajax_nopriv_delivery_change', 'delivery_change');


function delivery_select(){
    $conn = DBHelper::connect();

    $sqlQuery = "SELECT deliveries.*, providers.company_name
             FROM deliveries INNER JOIN providers ON deliveries.provider_code = providers.code";

    if ($_POST['date_from'] != null && $_POST['date_to'] != null && $_POST['is_paid'] != null && $_POST['is_received'] != null) {
        $sqlQuery = $sqlQuery." WHERE is_received = " . $_POST['is_received'] . " AND purchased = " . $_POST['is_paid'] . "
                                AND DATE_FORMAT(receiving_date,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "'";

    } else if ($_POST['date_from'] != null && $_POST['date_to'] != null && $_POST['is_paid'] != null) {
        $sqlQuery = $sqlQuery." WHERE purchased = " . $_POST['is_paid'] . "
                     AND DATE_FORMAT(receiving_date,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "'";

    } else if ($_POST['date_from'] != null && $_POST['date_to'] != null && $_POST['is_received'] != null) {
        $sqlQuery = $sqlQuery." WHERE is_received = " . $_POST['is_received'] . "
                     AND DATE_FORMAT(receiving_date,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "'";

    } else if ( $_POST['is_paid'] != null && $_POST['is_received'] != null){
        $sqlQuery = $sqlQuery." WHERE is_received = " . $_POST['is_received'] . " AND purchased = " . $_POST['is_paid'] . "";

    } else if($_POST['date_from'] != null && $_POST['date_to'] != null){
        $sqlQuery = $sqlQuery." WHERE DATE_FORMAT(receiving_date,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "'";

    } else if($_POST['is_paid'] != null){
        $sqlQuery = $sqlQuery." WHERE purchased = " . $_POST['is_paid'] . " ";

    } else if($_POST['is_received'] != null){
        $sqlQuery = $sqlQuery." WHERE is_received = " . $_POST['is_received'] . " ";
    }

    $sqlQuery = $sqlQuery." ORDER BY deliveries.order_date;";

    try {
        $deliveries = array();
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $sqlQueryGoods = "SELECT goods_name, unit_price, curr_amount, start_amount, production_date, expiration_date, unit_name
                              FROM goods
                              WHERE delivery_num = ".$row['delivery_num'].";";

            $goods = array();
            foreach ($conn->query($sqlQueryGoods, PDO::FETCH_ASSOC) as $good) {
                $goods[] = $good;
            }

            $row['goods'] = $goods;
            $deliveries[] = $row;
        }
        echo json_encode($deliveries, JSON_UNESCAPED_UNICODE);
        //echo $sqlQuery;
    } catch (Exception $e) {
        echo 'Exception: ',  $e->getMessage(), "\n";
        echo $sqlQuery;
    }

    DBHelper::disconnect();
    die;
}


function delivery_change(){
    $conn = DBHelper::connect();

    $sqlQuery ="UPDATE deliveries SET ";

    if (isset($_POST['receiving_date'])) $sqlQuery = $sqlQuery . "receiving_date = '" . $_POST['receiving_date'] . "' ";
    if (isset($_POST['pay_date'])) $sqlQuery = $sqlQuery . "pay_date = '" . $_POST['pay_date'] . "' ";
//    if (isset($_POST['is_paid'])) $sqlQuery = $sqlQuery . "purchased = '" . $_POST['is_paid'] . "' ";
//    if (isset($_POST['is_received'])) $sqlQuery = $sqlQuery . " is_received = '" . $_POST['is_received'] . "' ";

    $sqlQuery = $sqlQuery . " WHERE delivery_num = '" . $_POST['code'] . "';";
    echo $sqlQuery;
    try {
        $conn->query($sqlQuery);
    } catch (Exception $e) {
        echo 'Exception: ',  $e->getMessage(), "\n";
        echo $sqlQuery;
    }

    DBHelper::disconnect();
    die;
}