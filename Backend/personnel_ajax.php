<?php

require_once ('dbhelper.php');

add_action( 'wp_ajax_personnel_select', 'select_personnel' );
add_action( 'wp_ajax_nopriv_personnel_select', 'select_personnel' );

add_action( 'wp_ajax_personnel_add', 'personnel_add' );
add_action( 'wp_ajax_nopriv_personnel_add', 'personnel_add' );

add_action( 'wp_ajax_personnel_change', 'personnel_change' );
add_action( 'wp_ajax_nopriv_personnel_change', 'personnel_change' );

add_action( 'wp_ajax_fired_workers_select', 'fired_workers_select' );
add_action( 'wp_ajax_nopriv_fired_workers_select', 'fired_workers_select' );


function select_personnel(){
    $conn = DBHelper::connect();

    if ($_POST['position'] != null && $_POST['name'] != null) {
        $sqlQuery = "SELECT *
             FROM workers 
             WHERE position LIKE '" . $_POST['position'] . "'
                   AND CONCAT(first_name, ' ', surname, ' ', COALESCE (father_name, '')) LIKE '%" . $_POST['name'] . "%'
             
             ORDER BY workers.tab_num;";
    } else if ($_POST['position'] != null) {
        $sqlQuery = "SELECT *
             FROM workers 
             WHERE position LIKE '" . $_POST['position'] . "'
             ORDER BY workers.tab_num;";
    } else if ($_POST['name'] != null) {
        $sqlQuery = "SELECT *
             FROM workers 
             WHERE CONCAT(first_name, ' ', surname, ' ', COALESCE (father_name, '')) LIKE '%" . $_POST['name'] . "%'
             ORDER BY workers.tab_num;";
    } else {
        $sqlQuery = "SELECT *
             FROM workers
             ORDER BY workers.tab_num;";
    }

//    GROUP BY workers.tab_num, surname, first_name, father_name, birth_date, address, gender, position, salary, hire_date, fire_date
    try {
        $personnel = array();
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $sqlQueryTels = "SELECT tel_num
                             FROM telephones
                             WHERE tab_num = ".$row['tab_num'].";";
            $tels = array();
            foreach ($conn->query($sqlQueryTels, PDO::FETCH_ASSOC) as $tel) {
                $tels[] = $tel;
            }

            $row['tels'] = $tels;
            $personnel[] = $row;
        }
        echo json_encode($personnel, JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
        echo $sqlQuery;
    }


    DBHelper::disconnect();
    die;
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
        //add worker
        $conn->query($sqlQuery);

        $tels = $_POST['telephones'];
        if($tels != null){
            foreach ($tels as $tel){
                $conn->query("INSERT INTO telephones (tel_num, tab_num) VALUES ('". $tel ."', '". $_POST['tab_num'] ."');");
            }
        }

    } catch (Exception $e) {
        echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
        echo $sqlQuery;
    }
//    echo "ADDED!";
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

    if (isset($_POST['tels'])) {
        echo "!".$_POST['tels'];
        $tels = $_POST['tels'];

        try {
            if($tels != null){
                $sqlQueryDelTels = "DELETE FROM telephones
                                    WHERE tab_num = '" . $_POST['tab_num'] . "';";
                $conn->query($sqlQueryDelTels);

                foreach ($tels as $tel){
                    $sqlQuery = "INSERT INTO telephones(tel_num, tab_num) VALUES ('". $tel ."', '". $_POST['tab_num'] ."');";
//                    $sqlQuery ="UPDATE telephones SET tel_num = '" . $tel. "' WHERE tab_num = '" . $_POST['tab_num'] . "';";
                    $conn->query($sqlQuery);
                    echo $sqlQuery;
                }
            }
        } catch (Exception $e) {
            echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
            echo $sqlQuery;
        }
    }

    DBHelper::disconnect();
    die;
}

function personnel_change_tels(){
    $conn = DBHelper::connect();

    if (isset($_POST['tels'])) {
        echo "!".$_POST['tels'];
        $tels = $_POST['tels'];

        try {
            if($tels != null){
                $sqlQueryDelTels = "DELETE FROM telephones
                                    WHERE tab_num = '" . $_POST['tab_num'] . "';";
                $conn->query($sqlQueryDelTels);

                foreach ($tels as $tel){
                    $sqlQuery = "INSERT INTO telephones(tel_num, tab_num) VALUES ('". $tel ."', '". $_POST['tab_num'] ."');";
//                    $sqlQuery ="UPDATE telephones SET tel_num = '" . $tel. "' WHERE tab_num = '" . $_POST['tab_num'] . "';";
                    $conn->query($sqlQuery);
                    echo $sqlQuery;
                }
            }
        } catch (Exception $e) {
            echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
            echo $sqlQuery;
            DBHelper::disconnect();
            die;
        }
    }
    DBHelper::disconnect();
    die;
}

function fired_workers_select(){
    $conn = DBHelper::connect();

    $sqlQuery = "SELECT *
                 FROM workers";

    if($_POST['fired'] === 'true'){
        $sqlQuery = $sqlQuery.' WHERE fire_date IS NOT NULL';
    }else{
        $sqlQuery = $sqlQuery.' WHERE fire_date IS NULL';
    }

    $sqlQuery = $sqlQuery.' ORDER BY tab_num;';

    try {
        $personnel = array();
        foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
            $sqlQueryTels = "SELECT tel_num
                             FROM telephones
                             WHERE tab_num = ".$row['tab_num'].";";
            $tels = array();
            foreach ($conn->query($sqlQueryTels, PDO::FETCH_ASSOC) as $tel) {
                $tels[] = $tel;
            }

            $row['tels'] = $tels;
            $personnel[] = $row;
        }
        echo json_encode($personnel, JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
        echo $sqlQuery;
    }
    DBHelper::disconnect();
    die;
}

?>

