<?php
  
define("DB_SERVER", "localhost");
define("DB_USER", "admintaf_mehilUs");
define("DB_PASS", "]IotQ!Zh&8b4");
define("DB_NAME", "admintaf_mehilta");

//1. create data-base connection

function db_connect() {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($connection, 'utf8');
    return $connection;
}

// 2. prefrom database query
// 3. use returned data (if any)
// 4. release data
// 5. close connection

function db_disconnect($connection) {
    mysqli_close($connection);
}

function confirm_db_connect() {
    if (mysqli_connect_errno()) {
        $msg = "Database connection failed: ";
        $msg .= mysqli_connect_error();
        $msg .= "(" . mysqli_connect_errno() . ")";
        exit($msg);
    }
}

function confirm_result_set($result_set) {
//    print_r($result_set);
    if (!$result_set) {
        exit("Database query failed");
    } else {
//        echo "yyyyy";
    }
}
