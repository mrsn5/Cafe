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

add_action( 'wp_ajax_deliverer_all_ings_select', 'deliverer_all_ings_select' );
add_action( 'wp_ajax_nopriv_deliverer_all_ings_select', 'deliverer_all_ings_select' );

add_action( 'wp_ajax_deliverer_add', 'deliverer_add' );
add_action( 'wp_ajax_nopriv_deliverer_add', 'deliverer_add' );

add_action( 'wp_ajax_deliverer_change', 'deliverer_change' );
add_action( 'wp_ajax_nopriv_deliverer_change', 'deliverer_change' );

add_action( 'wp_ajax_get_deliverer_by_name', 'get_deliverer_by_name' );
add_action( 'wp_ajax_nopriv_get_deliverer_by_name', 'get_deliverer_by_name' );

function select_deliverer(){
    $conn = DBHelper::connect();

//    common parts
    $sqlQueryAllIngs = "NOT EXISTS (SELECT ing_name
                                     FROM dishes_ingredients
                                     WHERE tech_card_num IN (SELECT tech_card_num
                                                             FROM dishes
                                                             WHERE dish_name = '".$_POST['dish_name']."')
                                     AND ing_name NOT IN (SELECT ing_name
                                                          FROM goods
                                                          WHERE delivery_num IN (SELECT delivery_num
                                                                                 FROM deliveries
                                                                                 WHERE provider_code = X.code)))";
    $sqlQueryProvIng = "code IN (SELECT provider_code
                                  FROM deliveries
                                  WHERE delivery_num IN (SELECT delivery_num
                                                         FROM goods
                                                         WHERE ing_name LIKE '" . $_POST['product'] ."'";
    $sqlQueryIngDish = "ing_name IN (SELECT ing_name
                        FROM dishes_ingredients
                        WHERE tech_card_num IN (SELECT tech_card_num
                                                FROM dishes
                                                WHERE dish_name = '".$_POST['dish_name']."'))))";

    //queries
    try{
        if ($_POST['company_name'] != null && $_POST['product'] != null && $_POST['dish_name'] != null) {
            $sqlQuery = "SELECT *
                     FROM providers
                     WHERE company_name LIKE '" . $_POST['company_name'] . "'
                     AND ".$sqlQueryProvIng."
                     AND ".$sqlQueryIngDish."
                     ORDER BY code;";

        }else if($_POST['company_name'] != null && $_POST['product'] != null){
            $sqlQuery = "SELECT *
                     FROM providers
                     WHERE company_name LIKE '" . $_POST['company_name'] . "'
                     AND ".$sqlQueryProvIng."))
                     ORDER BY code;";

        } else if($_POST['product'] != null && $_POST['dish_name'] != null) {
            $sqlQuery = "SELECT *
                     FROM providers
                     WHERE ".$sqlQueryProvIng."
                       AND ".$sqlQueryIngDish."
                     ORDER BY code;";

        }else if($_POST['company_name'] != null && $_POST['dish_name'] != null) {
            $sqlQuery = "SELECT *
                     FROM providers X
                     WHERE company_name LIKE '" . $_POST['company_name'] . "'
                     AND ".$sqlQueryAllIngs."
                     ORDER BY code;";

        } else if ($_POST['company_name'] != null) {
            $sqlQuery = "SELECT *
                     FROM providers
                     WHERE company_name LIKE '" . $_POST['company_name'] . "'
                     ORDER BY code;";

        } else if ($_POST['product'] != null) {
            $sqlQuery = "SELECT *
                     FROM providers
                     WHERE ".$sqlQueryProvIng."))
                     ORDER BY code;";

        }else if ($_POST['dish_name'] != null) {
            $sqlQuery = "SELECT *
                     FROM providers X
                     WHERE ".$sqlQueryAllIngs.";";

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
    }catch (Exception $e){
        echo 'Exception: ',  $e->getMessage(), "\n";
        echo $sqlQuery;
        DBHelper::disconnect();
        die;
    }

    DBHelper::disconnect();
    die;
}

function deliverer_all_ings_select(){
    $conn =  DBHelper::connect();

    try{
        $sqlQuery = "CREATE OR REPLACE VIEW needed_ingredients AS
                 SELECT DISTINCT ing_name
                 FROM dishes_ingredients X
                 WHERE amount > (SELECT curr_amount
                                 FROM ingredients
                                 WHERE ingredients.ing_name = X.ing_name)
                 AND TRUE = ALL (SELECT is_in_menu
                                 FROM dishes
                                 WHERE dishes.tech_card_num = X.tech_card_num);";

        $conn->query($sqlQuery, PDO::FETCH_ASSOC);

        $sqlQuery2 = "SELECT *
                  FROM providers X
                  WHERE NOT EXISTS (SELECT ing_name
                                    FROM needed_ingredients
                                    WHERE ing_name NOT IN (SELECT ing_name
                                                           FROM deliveries INNER JOIN goods 
                                                                     ON goods.delivery_num = deliveries.delivery_num
                                                           WHERE X.code = provider_code))
                  AND break_date IS NULL;";

        $deliverers = array();
        foreach ($conn->query($sqlQuery2, PDO::FETCH_ASSOC) as $row) {
            $deliverers[] = $row;
        }
        echo json_encode($deliverers, JSON_UNESCAPED_UNICODE);
    }catch (Exception $e){
        echo 'Exception: ',  $e->getMessage(), "\n";
        echo $sqlQuery;

    }
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


function get_deliverer_by_name(){
    $conn = DBHelper::connect();

    $sqlQuery = "SELECT code
                 FROM providers
                 WHERE company_name = '".$_POST['company_name']."';";

    $prov = array();
    foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
        $prov[] = $row;
    }
    echo json_encode($prov[0], JSON_UNESCAPED_UNICODE);
    DBHelper::disconnect();
    die;
}