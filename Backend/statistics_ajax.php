<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/17/2019
 * Time: 11:32 AM
 */

require_once 'dbhelper.php';

add_action('wp_ajax_average_client_time', 'average_client_time');
add_action('wp_ajax_nopriv_average_client_time', 'average_client_time');

add_action('wp_ajax_orders_amount', 'orders_amount');
add_action('wp_ajax_nopriv_orders_amount', 'orders_amount');

add_action('wp_ajax_average_orders_cost', 'average_orders_cost');
add_action('wp_ajax_nopriv_average_orders_cost', 'average_orders_cost');

add_action('wp_ajax_average_orders_cost_per_person', 'average_orders_cost_per_person');
add_action('wp_ajax_nopriv_average_orders_cost_per_person', 'average_orders_cost_per_person');

add_action('wp_ajax_best_workers_orders_amount', 'best_workers_orders_amount');
add_action('wp_ajax_nopriv_best_workers_orders_amount', 'best_workers_orders_amount');

add_action('wp_ajax_best_workers_income', 'best_workers_income');
add_action('wp_ajax_nopriv_best_workers_income', 'best_workers_income');

add_action('wp_ajax_category_portions_amount', 'category_portions_amount');
add_action('wp_ajax_nopriv_category_portions_amount', 'category_portions_amount');

add_action('wp_ajax_dish_portions_amount', 'dish_portions_amount');
add_action('wp_ajax_nopriv_dish_portions_amount', 'dish_portions_amount');

add_action('wp_ajax_dish_frequency', 'dish_frequency');
add_action('wp_ajax_nopriv_dish_frequency', 'dish_frequency');

add_action('wp_ajax_orders_income', 'orders_income');
add_action('wp_ajax_nopriv_orders_income', 'orders_income');

add_action('wp_ajax_deliveries_cost', 'deliveries_cost');
add_action('wp_ajax_nopriv_deliveries_cost', 'deliveries_cost');

add_action('wp_ajax_x_report', 'x_report');
add_action('wp_ajax_nopriv_x_report', 'x_report');


function average_client_time()
{
    $sqlQuery = "SELECT IFNULL(AVG(TIME_TO_SEC(TIMEDIFF(close_time, order_time))) / 60, 0) AS avg_time
                     FROM orders
                     WHERE DATE_FORMAT(order_time,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "'
                       AND is_closed;";

    makeSingleRoundValQuery($sqlQuery, 'avg_time');
}

function orders_amount()
{
    $sqlQuery = "SELECT COUNT(*) AS orders_amount
                     FROM orders
                     WHERE DATE_FORMAT(order_time,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "'
                       AND is_closed;";

    makeSingleValQuery($sqlQuery);
}


function average_orders_cost()
{
    $sqlQuery = "SELECT IFNULL(AVG(cost), 0) AS avg_cost
                     FROM orders
                     WHERE DATE_FORMAT(order_time,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "'
                       AND is_closed;";

    makeSingleRoundValQuery($sqlQuery, 'avg_cost');
}

function average_orders_cost_per_person()
{
    $sqlQuery = "SELECT IFNULL(SUM(cost) / SUM(n_people), 0) AS avg_cost_per_person
                     FROM orders
                     WHERE DATE_FORMAT(order_time,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "'
                     AND is_paid;";

    makeSingleRoundValQuery($sqlQuery, 'avg_cost_per_person');
}


function best_workers_orders_amount()
{
    $sqlQuery = "SELECT workers.tab_num, CONCAT(first_name, ' ', surname) AS pib, COUNT(orders.unique_num) AS worker_res
                     FROM workers INNER JOIN orders ON workers.tab_num = orders.tab_num
                     WHERE position = 'офіціант'
                       AND fire_date IS NULL
                       AND DATE_FORMAT(close_time,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "'
                     GROUP BY workers.tab_num
                     ORDER BY worker_res DESC
                     LIMIT " . $_POST['first'] . ";";

    makeQuery($sqlQuery);
}


function best_workers_income()
{
    $sqlQuery = "SELECT workers.tab_num, CONCAT(first_name, ' ', surname) AS pib, SUM(cost) AS worker_res
                     FROM workers INNER JOIN orders ON workers.tab_num = orders.tab_num
                     WHERE     position = 'офіціант'
                           AND fire_date IS NULL
                           AND DATE_FORMAT(close_time,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "'
                     GROUP BY workers.tab_num
                     ORDER BY worker_res DESC
                     LIMIT " . $_POST['first'] . ";";

    makeQuery($sqlQuery);
}

function category_portions_amount()
{
    $sqlQuery = "SELECT COUNT(*) AS quantity
                     FROM portions
                     WHERE     tech_card_num IN (SELECT tech_card_num
                                                 FROM dishes_categories
                                                 WHERE cat_name = '" . $_POST['cat_name'] . "');";

    makeSingleValQuery($sqlQuery);
}


function dish_portions_amount()
{
    $sqlQuery = "SELECT COUNT(*) AS quantity
                     FROM portions
                     WHERE     tech_card_num IN (SELECT tech_card_num
                                                 FROM dishes
                                                 WHERE dish_name = '" . $_POST['dish_name'] . "');";

    makeSingleValQuery($sqlQuery);
}

function dish_frequency()
{
    $sqlQuery = "SELECT dish_name, COUNT(unique_num) AS dish_res
                     FROM dishes INNER JOIN portions ON dishes.tech_card_num = portions.tech_card_num
                     WHERE order_num IN (SELECT unique_num
                                         FROM orders
                                         WHERE DATE_FORMAT(order_time,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "')
                     GROUP BY dish_name ";

    if ($_POST['less'] === 'true')
        $sqlQuery = $sqlQuery . "HAVING COUNT(unique_num) <= " . $_POST['n_orders'] . ";";
    else
        $sqlQuery = $sqlQuery . "HAVING COUNT(unique_num) > " . $_POST['n_orders'] . ";";

    makeQuery($sqlQuery);
}

function orders_income()
{
    $sqlQuery = "SELECT unique_num, close_time, CONCAT(first_name, ' ', surname) as pib, cost
                     FROM orders INNER JOIN workers ON orders.tab_num = workers.tab_num
                     WHERE DATE_FORMAT(close_time,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "'
                       AND is_closed AND is_paid;";

    $sqlQueryTotal = "SELECT IFNULL(SUM(cost), 0) AS total
                          FROM orders
                          WHERE DATE_FORMAT(close_time,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "'
                            AND is_closed AND is_paid;";
    tableDataQuery($sqlQuery, $sqlQueryTotal);
}

function deliveries_cost()
{
    $sqlQuery = "SELECT delivery_num, pay_date, receiving_date, company_name, cost
                     FROM deliveries INNER JOIN providers ON deliveries.provider_code = providers.code
                     WHERE DATE_FORMAT(receiving_date,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "'
                       AND is_received AND purchased;";

    $sqlQueryTotal = "SELECT IFNULL(SUM(cost), 0) AS total
                          FROM deliveries
                          WHERE DATE_FORMAT(receiving_date,'%Y-%m-%d') BETWEEN '" . $_POST['date_from'] . "' AND '" . $_POST['date_to'] . "';";

    tableDataQuery($sqlQuery, $sqlQueryTotal);
}

function x_report()
{
    $sqlQuery = "SELECT unique_num, close_time, CONCAT(first_name, ' ', surname) as pib, cost
                     FROM orders INNER JOIN workers ON orders.tab_num = workers.tab_num
                     WHERE DATE_FORMAT(close_time,'%Y-%m-%d') = CURDATE() AND DATE(close_time) <= NOW()
                       AND is_closed AND is_paid
                     ORDER BY close_time;";

    $sqlQueryTotal = "SELECT IFNULL(SUM(cost), 0) AS total
                      FROM orders
                      WHERE DATE_FORMAT(close_time,'%Y-%m-%d') = CURDATE() AND DATE(close_time) <= NOW() AND is_paid = 0b1;";

    tableDataQuery($sqlQuery, $sqlQueryTotal);
}

function makeSingleValQuery($sqlQuery)
{
    $conn = DBHelper::connect();
    try {
        $res = array();
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $res[] = $row;
        }
        echo json_encode($res[0], JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        echo("Error");
        echo($e);
    }

    DBHelper::disconnect();
    die;
}

function makeSingleRoundValQuery($sqlQuery, $val_name)
{
    $conn = DBHelper::connect();
    try {
        $res = array();
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $res[] = $row;
        }
        $res[0][$val_name] = roundValue($res[0][$val_name]);
        echo json_encode($res[0], JSON_UNESCAPED_UNICODE);

    } catch (Exception $e) {
        echo("Error");
        echo($e);
    }
    DBHelper::disconnect();
    die;
}

function makeQuery($sqlQuery)
{
    $conn = DBHelper::connect();
    try {
        $res = array();
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $res[] = $row;
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        echo("Error");
        echo($e);
    }

    DBHelper::disconnect();
    die;
}

function tableDataQuery($sqlQuery, $sqlQueryTotal)
{
    $conn = DBHelper::connect();
    try {
        $res = array();
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $res[] = $row;
        }
        foreach ($conn->query($sqlQueryTotal, PDO::FETCH_ASSOC) as $row) {
            $res[] = $row;
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        echo("Error");
        echo($e);
    }
    DBHelper::disconnect();
    die;
}

function roundValue($value)
{
    return round($value, 2);
}