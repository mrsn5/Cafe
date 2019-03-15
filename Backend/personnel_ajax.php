<?php

require_once 'dbhelper.php';

add_action( 'wp_ajax_personnel_select', 'select_personnel' );
add_action( 'wp_ajax_nopriv_personnel_select', 'select_personnel' );
add_action( 'wp_ajax_personnel_add', 'personnel_add' );
add_action( 'wp_ajax_nopriv_personnel_add', 'personnel_add' );
add_action( 'wp_ajax_personnel_change', 'personnel_change' );
add_action( 'wp_ajax_nopriv_personnel_change', 'personnel_change' );

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

function personnel_change() {
    $conn = DBHelper::connect();

    $sqlQuery ="UPDATE workers SET ";

    if (isset($_POST['first_name'])) $sqlQuery = $sqlQuery . " first_name = '" . $_POST['first_name'] . "' ";
    if (isset($_POST['surname'])) $sqlQuery = $sqlQuery . " surname = '" . $_POST['surname'] . "' ";
    if (isset($_POST['father_name'])) {
        if ($_POST['father_name'] != null) $sqlQuery = $sqlQuery . "father_name = '" . $_POST['father_name'] . "' ";
        else $sqlQuery = $sqlQuery . " father_name = NULL ";
    }
    if (isset($_POST['birth_date'])) $sqlQuery = $sqlQuery . " birth_date = '" . $_POST['birth_date'] . "' ";
    if (isset($_POST['address'])) $sqlQuery = $sqlQuery . " address = '" . $_POST['address'] . "' ";
    if (isset($_POST['gender'])) $sqlQuery = $sqlQuery . " gender = '" . $_POST['gender'] . "' ";
    if (isset($_POST['position'])) $sqlQuery = $sqlQuery . " position = '" . $_POST['position'] . "' ";
    if (isset($_POST['salary'])) $sqlQuery = $sqlQuery . " salary = '" . $_POST['salary'] . "' ";
    if (isset($_POST['fire_date'])) $sqlQuery = $sqlQuery . " fire_date = '" . $_POST['fire_date'] . "' ";

    $sqlQuery = $sqlQuery . " WHERE tab_num = '" . $_POST['tab_num'] . "';";
    echo $sqlQuery;
    try {
        $conn->query($sqlQuery);
    } catch (Exception $e) {
        echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
        echo $sqlQuery;
    }

    if (isset($_POST['tel_num'])) {
        echo "!".$_POST['tel_num'];
        $sqlQuery ="UPDATE telephones SET tel_num = '" . $_POST['tel_num']. "' WHERE tab_num = '" . $_POST['tab_num'] . "';";;
        echo $sqlQuery;
        try {
            $conn->query($sqlQuery);
        } catch (Exception $e) {
            echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
            echo $sqlQuery;
        }
    }

    DBHelper::disconnect();
    die;
}

?>

