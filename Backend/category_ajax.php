<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/16/2019
 * Time: 8:39 PM
 */


require_once 'dbhelper.php';

//add_action( 'wp_ajax_specify_cat_name', 'specify_cat_name' );
//add_action( 'wp_ajax_nopriv_specify_cat_name', 'specify_cat_name' );

add_action('wp_ajax_cat_select', 'cat_select');
add_action('wp_ajax_nopriv_cat_select', 'cat_select');

add_action('wp_ajax_top_list', 'top_list');
add_action('wp_ajax_nopriv_top_list', 'top_list');

add_action('wp_ajax_stop_list', 'stop_list');
add_action('wp_ajax_nopriv_stop_list', 'stop_list');

add_action('wp_ajax_update_dish_in_menu_prop', 'update_dish_in_menu_prop');
add_action('wp_ajax_nopriv_update_dish_in_menu_prop', 'update_dish_in_menu_prop');

//$category_name = '';
//
//function specify_cat_name(){
//    global  $category_name;
//    $category_name = $_POST['category'];
//
//    echo ('SUCCESS');
//    die();
//}

function cat_select()
{
    $sqlQuery = "SELECT *
                 FROM dishes
                 WHERE tech_card_num IN (SELECT tech_card_num
                                         FROM dishes_categories
                                         WHERE cat_name LIKE '" . $_POST['cat_name'] . "')";


    if($_POST['dish_name'] != null){
        $sqlQuery = $sqlQuery. " AND dish_name LIKE '" . $_POST['dish_name'] . "' ";
    }

    if($_POST['in_menu'] != null){
        $sqlQuery = $sqlQuery. " AND is_in_menu = '" . $_POST['in_menu'] . "' ";
    }

    $sqlQuery = $sqlQuery." ORDER BY dish_name;";

    getDishesList($sqlQuery);
}


function top_list()
{
    $sqlQuery = "SELECT *,
                (SELECT MIN(expiration_date)
                 FROM goods
                 WHERE  curr_amount <> 0
                        AND ing_name IN (SELECT ing_name
                                         FROM dishes_ingredients
                                         WHERE dishes.tech_card_num =
                                                                dishes_ingredients.tech_card_num)) 
                                         AS expiration_date
FROM dishes
WHERE (SELECT MIN(expiration_date)
                FROM goods
                WHERE     curr_amount <> 0
                         AND ing_name IN (SELECT ing_name
                                      FROM dishes_ingredients
                                      WHERE dishes.tech_card_num =
                                                     dishes_ingredients.tech_card_num)) IS NOT NULL
ORDER BY expiration_date;";

    getDishesList($sqlQuery);
}


function stop_list(){
    $sqlQuery = "SELECT *
                 FROM dishes
                 WHERE is_ing_available = 0;";

    getDishesList($sqlQuery);
}

function getDishesList($sqlQuery)
{
    $conn = DBHelper::connect();

    $dishes = array();

    foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
        $ings = array();
        $ings_query = "SELECT X.ing_name, units, amount, IF(amount <= COALESCE((SELECT SUM(curr_amount)
                                                               FROM ingredients
                                                               WHERE ing_name = X.ing_name), 0), \"YES\", \"NO\") AS is_available
                       FROM dishes_ingredients X INNER JOIN ingredients ON ingredients.ing_name = X.ing_name
                       WHERE tech_card_num IN (SELECT tech_card_num
                                               FROM dishes
                                               WHERE dishes.tech_card_num = " . $row['tech_card_num'] . ");";
        try {
            foreach ($conn->query($ings_query, PDO::FETCH_ASSOC) as $ing) {
                $ing['is_available'] = ($ing['is_available'] == "YES") ? true : false;
                $ings[] = $ing;
            }

            $row['ings'] = $ings;
            $dishes[] = $row;
        } catch (Exception $e) {
            echo($e);
            DBHelper::disconnect();
            die();
        }
    }

    echo json_encode($dishes, JSON_UNESCAPED_UNICODE);
    DBHelper::disconnect();
    die;
}

function update_dish_in_menu_prop(){
    if($_POST['tech_card_num']){
        $conn = DBHelper::connect();

        $sqlQuery = "UPDATE dishes SET
                     is_in_menu = ".$_POST['in_menu']."
                     WHERE tech_card_num = ".$_POST['tech_card_num'].";";

        try {
            $conn->query($sqlQuery, PDO::FETCH_ASSOC);
        }catch (Exception $e) {
            echo($e);
            DBHelper::disconnect();
            die();
        }

        echo 'Dish '.$_POST['tech_card_num'].' updated';
        DBHelper::disconnect();
        die;
    }
}