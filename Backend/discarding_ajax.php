<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/4/2019
 * Time: 5:37 PM
 */

require_once 'dbhelper.php';

add_action('wp_ajax_discarding_select', 'discarding_select');
add_action('wp_ajax_nopriv_discarding_select', 'discarding_select');

function discarding_select(){
    $conn = DBHelper::connect();

    $sqlQuery = "SELECT discarding.*, CONCAT(workers.first_name, ' ', workers.surname, ' ', COALESCE (workers.father_name, '')) AS resp_person
                 FROM discarding INNER JOIN workers ON discarding.tab_num = workers.tab_num";

    if ($_POST['disc_date'] != null && $_POST['resp_person'] != null) {
        $sqlQuery = $sqlQuery . " WHERE discard_date = '" . $_POST['disc_date'] .
               "' AND CONCAT(first_name, ' ', surname, ' ', COALESCE (father_name, '')) LIKE '%" . $_POST['resp_person']."%'";

    } else if ($_POST['disc_date'] != null) {
        $sqlQuery = $sqlQuery . " WHERE discard_date = '" . $_POST['disc_date']."'";

    } else if ( $_POST['resp_person'] != null) {
        $sqlQuery = $sqlQuery . " WHERE CONCAT(first_name, ' ', surname, ' ', COALESCE (father_name, '')) LIKE '%" . $_POST['resp_person']."%'";
    }

    $sqlQuery = $sqlQuery . " ORDER BY discard_date;";

    try {
        $discardings = array();
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $sqlQueryGoods = "SELECT goods.unique_code AS good_code, goods_name, delivery_num, unit_name, amount, reason, discarding_goods.cost AS cost
                              FROM discarding_goods INNER JOIN goods ON discarding_goods.good_code = goods.unique_code
                              WHERE discard_code = " . $row['unique_code'] . ";";

            $goods = array();
            foreach ($conn->query($sqlQueryGoods, PDO::FETCH_ASSOC) as $good) {
                $goods[] = $good;
            }

            $row['goods'] = $goods;
            $discardings[] = $row;
        }
        echo json_encode($discardings, JSON_UNESCAPED_UNICODE);
        //echo $sqlQuery;
    } catch (Exception $e) {
        echo 'Exception: ', $e->getMessage(), "\n";
        echo $sqlQuery;
    }

    DBHelper::disconnect();
    die;
}