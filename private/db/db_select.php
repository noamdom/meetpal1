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



function check_exist_user($table, $username) {
    global $db;
    $sql = "SELECT * FROM $table where username ='" . $username . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}





    