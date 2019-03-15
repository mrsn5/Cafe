<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/15/2019
 * Time: 6:27 PM
 */
require_once 'dbhelper.php';

add_action( 'wp_ajax_deliverer_select', 'select_deliverer' );
add_action( 'wp_ajax_nopriv_deliverer_select', 'select_deliverer' );
add_action( 'wp_ajax_deliverer_add', 'deliverer_add' );
add_action( 'wp_ajax_nopriv_deliverer_add', 'deliverer_add' );
add_action( 'wp_ajax_deliverer_change', 'deliverer_change' );
add_action( 'wp_ajax_nopriv_deliverer_change', 'deliverer_change' );

function select_deliverer(){
    $conn = DBHelper::connect();

    if ($_POST['company_name'] != null && $_POST['product'] != null) {
        $sqlQuery = "SELECT *
                     FROM providers
                     WHERE company_name LIKE '" . $_POST['company_name'] . "'
                     AND code IN (SELECT provider_code
                                  FROM deliveries
                                  WHERE delivery_num IN (SELECT delivery_num
                                                         FROM goods
                                                         WHERE ing_name LIKE '" . $_POST['product'] . "'))
                     ORDER BY code;";

    } else if ($_POST['company_name'] != null) {
        $sqlQuery = "SELECT *
                     FROM providers
                     WHERE company_name LIKE '" . $_POST['company_name'] . "'
                     ORDER BY code;";

    } else if ($_POST['product'] != null) {
        $sqlQuery = "SELECT *
                     FROM providers
                     WHERE code IN (SELECT provider_code
                                    FROM deliveries
                                    WHERE delivery_num IN (SELECT delivery_num
                                                         FROM goods
                                                         WHERE ing_name LIKE '" . $_POST['product'] . "'))
                     ORDER BY code;";

    } else {
        $sqlQuery = "SELECT *
                     FROM providers
                     ORDER BY code;";
    }

    $deliverers = array();
    foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
        $deliverers[] = $row;
    }
    echo json_encode($deliverers, JSON_UNESCAPED_UNICODE);
    DBHelper::disconnect();
    die;
}

function deliverer_add() {
    $conn = DBHelper::connect();
    $sqlQuery =
        str_replace(
            "'NULL'", "NULL",
            "INSERT INTO providers
        (code, company_name, address, contact_person_name, contact_person_tel, email, sign_date, break_date, break_reason)
        VALUES ("
            .$_POST['code'].", '" .$_POST['company_name']."', '"
            .$_POST['address']."', '"
            .$_POST['contact_person_name']."','"
            .$_POST['contact_person_tel'] ."', '"
            .$_POST['email']."', CURRENT_DATE,  NULL, NULL);");
    try {
        $conn->query($sqlQuery);

        $res = array();
        $rows = $conn->query("SELECT *
                     FROM providers
                     WHERE code LIKE '".$_POST['code']."'", PDO::FETCH_ASSOC);

        foreach ($rows as $row){
            $res[] = $row;
        }
        echo json_encode($res);

    } catch (Exception $e) {
        echo 'Exception: ',  $e->getMessage(), "\n";
        echo $sqlQuery;
    }
//    echo "ADDED!";
    DBHelper::disconnect();
    die;
}


function deliverer_change() {
    $conn = DBHelper::connect();

    $sqlQuery ="UPDATE providers SET ";

    if (isset($_POST['company_name'])) $sqlQuery = $sqlQuery . "company_name = '" . $_POST['company_name'] . "' ";
    if (isset($_POST['contact_person_name'])) $sqlQuery = $sqlQuery . "contact_person_name = '" . $_POST['contact_person_name'] . "' ";
    if (isset($_POST['contact_person_tel'])) $sqlQuery = $sqlQuery . "contact_person_tel = '" . $_POST['contact_person_tel'] . "' ";
    if (isset($_POST['address'])) $sqlQuery = $sqlQuery . " address = '" . $_POST['address'] . "' ";
    if (isset($_POST['email'])) $sqlQuery = $sqlQuery . " email = '" . $_POST['email'] . "' ";
    if (isset($_POST['break_date'])) $sqlQuery = $sqlQuery . " break_date = '" . $_POST['break_date'] . "' ";
    if (isset($_POST['break_reason'])) $sqlQuery = $sqlQuery . " break_reason = '" . $_POST['break_reason'] . "' ";

    $sqlQuery = $sqlQuery . " WHERE code = '" . $_POST['code'] . "';";
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