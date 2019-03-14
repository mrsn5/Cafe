<?php
/**
 * Created by PhpStorm.
 * User: San Nguyen
 * Date: 13.03.2019
 * Time: 20:06
 */

include 'dbhelper.php';

$conn = DBHelper::connect();

if ($_GET['type'] == 'select') {
    if (isset($_GET['position']) && isset($_GET['name'])) {
        $sqlQuery = "SELECT *
                 FROM workers NATURAL JOIN telephones
                 WHERE position LIKE '" . $_GET['position'] . "'
                       AND CONCAT(first_name, ' ', surname, ' ', father_name) LIKE '%" . $_GET['name'] . "%'
                 ORDER BY tab_num;";
    } else if (isset($_GET['position'])) {
        $sqlQuery = "SELECT *
                 FROM workers NATURAL JOIN telephones
                 WHERE position LIKE '" . $_GET['position'] . "'
                 ORDER BY tab_num;";
    } else if (isset($_GET['name'])) {
        $sqlQuery = "SELECT *
                 FROM workers NATURAL JOIN telephones
                 WHERE CONCAT(first_name, ' ', surname, ' ', father_name) LIKE '%" . $_GET['name'] . "%'
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
}


if ($_GET['type'] == 'add') {
    $sqlQuery =
"INSERT INTO workers 
(tab_num, surname, first_name, father_name, birth_date, address, gender, position, salary, hire_date, fire_date) 
VALUES (".$_GET['tab_num'].", '".$_GET['surname']."', '".$_GET['first_name']."', '".$_GET['father_name']."', 
'".$_GET['birth_date']."', '".$_GET['address']."', '".$_GET['gender']."', '".$_GET['position']."', ".$_GET['salary'].
", CURRENT_DATE, null);";
    $conn->query($sqlQuery);
    echo "ADDED!";
}


DBHelper::disconnect();




