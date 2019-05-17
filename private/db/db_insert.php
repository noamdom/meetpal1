<?php

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    function register() {
        global $db;
        $sql = "INSERT INTO Users ";
        $sql .= "(`username`, email , `pword`) ";
        $sql .= "VALUES (";
        $sql .= "'" . db_escape($db,$_POST['username']) . "',";
        $sql .= "'" . $_POST['email'] . "',";
        $sql .= "'" . db_escape($db,$_POST['password1']) . "'";
        $sql .= ") ";
//        echo $sql . '</br>';
        $result = mysqli_query($db, $sql);
        finish_CRUD($result,"find-host.php");
    }


function join_event($event_id, $user_id) {
    global $db;
    $sql = "INSERT into participants_groups ";
    $sql .= "( user_id, event_id ) ";
    $sql .= "VALUES (";
    $sql .= "'" . $user_id . "',";
    $sql .= "'" . $event_id . "'";
    $sql .= ") ";
        echo $sql . '</br>';
    $result = mysqli_query($db, $sql);

    finish_CRUD($result,"profile.php");
}




function new_event($hostID) {
    global $db;
    $sql = "INSERT into Events ";
    $sql .= "( name, date , category , location , description , hostID ) ";
    $sql .= "VALUES (";
    $sql .= "'" . $_POST['name'] . "',";
    $sql .= "'" . $_POST['date']  . " ',";
    $sql .= "'" . $_POST['category'] . "',";
    $sql .= "'" . $_POST['location'] . "',";
    $sql .= "'" . $_POST['description'] . "',";
    $sql .= "'" . $hostID . "'";
    $sql .= ") ";
    echo $sql . '</br>';

    $result = mysqli_query($db, $sql);


    $sql = "SELECT max(id) FROM Events ";
    echo $sql;
    $result = mysqli_query($db, $sql);
    $result1 = mysqli_fetch_array($result);

    $event_id = $result1[0];

    $sql = "INSERT into provider_groups ";
    $sql .= "( user_id, event_id ) ";
    $sql .= "VALUES (";
    $sql .= "'" . $hostID . "',";
    $sql .= "'" . $event_id . "'";
    $sql .= ") ";
    echo $sql . '</br>';
    $result = mysqli_query($db, $sql);
    finish_CRUD($result,"profile.php");

}




    function insert_new_product($target) {
        global $db;
        $sql = "INSERT INTO prods ";
        $sql .= "(`prodName`, `projectId`, type, `size`, `paperType`, `colourful`, `bilateral`, `cut`"
                . ",quan , quanDesc , prodNote , openDate , phase , startPhaseDate, phaseDateEnd) ";
        $sql .= "VALUES (";
        $sql .= "'" . db_escape($db,$_POST['prodName']) . "',";
        $sql .= "'" . $_POST['projectId'] . "',";
        $sql .= "'" . $_POST['type'] . "',";
        $sql .= "'" . $_POST['size'] . "',";
        $sql .= "'" . db_escape($db,$_POST['paperType']) . "',";
        $sql .= "'" . $_POST['colourful'] . "',";
        $sql .= "'" . $_POST['bilateral'] . "',";
        $sql .= "'" . $_POST['cut'] . "',";
        $sql .= "'" . $_POST['quan'] . "',";
        $sql .= "'" . db_escape($db, $_POST['quanDesc']) . "',";
        $sql .= "'" . db_escape($db,$_POST['prodNote']) . "',";
        $sql .= "'" . $_POST['openDate'] . "',";
        $sql .= "'" . $_POST['phase'] . "',";
        $sql .= "'" . $_POST['startPhaseDate'] . "',";
        $sql .= "'" . $_POST['phaseDateEnd'] . "'";
        $sql .= ")";
//        echo $sql;
        $result = mysqli_query($db, $sql);
        $_SESSION['msg'] = "העזר התווסף בהצלחה";
        finish_CRUD($result, $target);
    }









    function insert_phase($phaseName, $startAfter, $during, $toEnd, $description, $phaseNum, $active) {
        global $db;
        $sql = "INSERT INTO phases ";
        $sql .= "(`phaseName`, `startAfter`, `during`, `toEnd`, `description`, `phaseNum`, `active`) ";
        $sql .= "VALUES (";
        $sql .= "'" . $phaseName . "',";
        $sql .= "'" . $startAfter . "',";
        $sql .= "'" . $during . "',";
        $sql .= "'" . $toEnd . "',";
        $sql .= "'" . $description . "',";
        $sql .= "'" . $phaseNum . "',";
        $sql .= "'" . $active . "'";
        $sql .= ")";
        echo "<br>sql: " . $sql . "<br>";
        $result = mysqli_query($db, $sql);
        if ($result) {
//        $new_id = mysqli_insert_id(db);
            header("location: update-options.php");
            exit;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function insert_user() {

        global $db;
        $hashed_password = password_hash($_POST['userPass'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO users ";
        $sql .= "(`userName`, `userLogin`, `userPass`, `userType`, `userPermission`, `userMail`) ";
        $sql .= "VALUES (";
        $sql .= "'" . db_escape($db,$_POST['userName']) . "',";
        $sql .= "'" . db_escape($db,$_POST['userLogin']) . "',";
        $sql .= "'" . $hashed_password . "',";
        $sql .= "'" . $_POST['userType'] . "',";
        $sql .= "'" . $_POST['userPermission'] . "',";
        $sql .= "'" . db_escape($db,$_POST['userMail']) . "'";
        $sql .= ")";
//        echo "<br>sql: " . $sql . "<br>";
        $result = mysqli_query($db, $sql);
        if ($result) {
            header("location: update-options.php");
            exit;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

