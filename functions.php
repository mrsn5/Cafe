<?php
/**
 * Created by PhpStorm.
 * User: San Nguyen
 * Date: 15.03.2019
 * Time: 13:50
 */

include 'Backend/dbhelper.php';

add_action( 'wp_ajax_personnel_select', 'select_personnel' );
add_action( 'wp_ajax_nopriv_personnel_select', 'select_personnel' );
add_action( 'wp_ajax_personnel_add', 'personnel_add' );
add_action( 'wp_ajax_nopriv_personnel_add', 'personnel_add' );

function select_personnel(){
    $conn = DBHelper::connect();

    if ($_POST['position'] != null && $_POST['name'] != null) {
        $sqlQuery = "SELECT *
             FROM workers NATURAL JOIN telephones
             WHERE position LIKE '" . $_POST['position'] . "'
                   AND CONCAT(first_name, ' ', surname, ' ', father_name) LIKE '%" . $_POST['name'] . "%'
             ORDER BY tab_num;";
    } else if ($_POST['position'] != null) {
        $sqlQuery = "SELECT *
             FROM workers NATURAL JOIN telephones
             WHERE position LIKE '" . $_POST['position'] . "'
             ORDER BY tab_num;";
    } else if ($_POST['name'] != null) {
        $sqlQuery = "SELECT *
             FROM workers NATURAL JOIN telephones
             WHERE CONCAT(first_name, ' ', surname, ' ', father_name) LIKE '%" . $_POST['name'] . "%'
             ORDER BY tab_num;";
    } else {
        $sqlQuery = "SELECT *
             FROM workers NATURAL JOIN telephones
             ORDER BY tab_num;";
    }

    $personnel = array();
    foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
        $personnel[] = $row;
    }
    echo json_encode($personnel, JSON_UNESCAPED_UNICODE);


    DBHelper::disconnect();

    die; // даём понять, что обработчик закончил выполнение
}

function personnel_add() {
    $conn = DBHelper::connect();
    $sqlQuery =
        str_replace(
        "'NULL'", "NULL",
        "INSERT INTO workers
        (tab_num, surname, first_name, father_name, birth_date, address, gender, position, salary, hire_date, fire_date)
        VALUES ("
        .$_POST['tab_num'].", '"
        .$_POST['surname']."', '"
        .$_POST['first_name']."', '"
        .$_POST['father_name']."','"
        .$_POST['birth_date'] ."', '"
        .$_POST['address']."', '"
        .$_POST['gender']."', '"
        .$_POST['position']."', "
        .$_POST['salary'].", CURRENT_DATE, NULL);");
    try {
        $conn->query($sqlQuery);
    } catch (Exception $e) {
        echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
        echo $sqlQuery;
    }
    echo "ADDED!";
    DBHelper::disconnect();
    die;
}


?>