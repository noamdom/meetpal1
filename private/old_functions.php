<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */





function pords_query() {
    global $db;
    $sql = "SELECT * FROM prods ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}



function phases_query() {
    global $db;
    $sql = "SELECT * FROM phases ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}



function project_by_id_query($id) {
    global $db;
    $sql = "SELECT * FROM projects ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";
//    echo "sql: " . $sql . "<br>";
    $result = mysqli_query($db, $sql);
//    print_r($result);
    confirm_result_set($result);
    $project = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $project;
}




function phase_by_id_query($id) {
    global $db;
    $sql = "SELECT * FROM phases ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "'";
//    echo "sql: " . $sql . "<br>";
    $result = mysqli_query($db, $sql);
//    print_r($result);
    confirm_result_set($result);
    $phase = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $phase;
}


function resp_query() {
    global $db;
    $sql = "SELECT * FROM resp ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}



function delete_project($id) {
    global $db;
    $sql = "DELETE FROM projects ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    echo "sql: " . $sql;
    $result = mysqli_query($db, $sql);
    if ($result) {
        header("location: all-projects.php");
        exit;
    } else {
        // delete failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    }
}
