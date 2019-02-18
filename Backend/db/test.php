<?php
/**
 * Created by PhpStorm.
 * User: San Nguyen
 * Date: 18.02.2019
 * Time: 16:50
 */

include 'dbhelper.php';

$conn = DBHelper::connect();

$sqlQuery = "SELECT * FROM workers";
foreach ($conn->query($sqlQuery) as $row) {
    print_r($row);
    echo '<br/>';
}

DBHelper::disconnect();

