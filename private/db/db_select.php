<?php

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */


    function general_query($table) {
        global $db;
        $sql = "SELECT * FROM $table ";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

function events_by_category($category) {
    global $db;
    $sql = "SELECT * FROM Events where category = '" . $category . "'";
//    echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}



function check_exist_user($table, $username) {
    global $db;
    $sql = "SELECT * FROM $table where username ='" . $username . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}


function user_by_username($username) {
    global $db;
    $sql = "SELECT * FROM Users ";
    $sql .= "WHERE username='" . $username . "'";
//    echo "sql: " . $sql . "<br>";
    $result = mysqli_query($db, $sql);
//    print_r($result);
    confirm_result_set($result);
    $userDet = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $userDet;
}

function my_participating_events($id) {
    global $db;
    $sql = "SELECT name from Events WHERE id in ( SELECT event_id from participants_groups WHERE user_id = " . $id ." )";
    $result = mysqli_query($db, $sql);
//    print_r($result);
    return $result;
}



function my_provider_events($id) {
    global $db;
    $sql = "SELECT name from Events WHERE id in ( SELECT event_id from provider_groups WHERE user_id = " . $id ." )";
//    echo $sql;
    $result = mysqli_query($db, $sql);
//    print_r($result);
    return $result;
}





    