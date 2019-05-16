<?php

    ob_start(); // output buffring turn on
    date_default_timezone_set('Israel');

    session_start();

    define("PRIVATE_PATH", dirname(__FILE__));
    define("PROJECT_PATH", dirname(PRIVATE_PATH));
    define("PUBLIC_PATH", PROJECT_PATH . '/public_html');
    define("SHARED_PATH", PRIVATE_PATH . '/shared');

// absoulte path to root's web
    $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
    $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
    define("WWW_ROOT", $doc_root);

    define("MAX_PHASE_VAL", 13);
    define("SEPARATOR", '__');

    define("SEPARATOR", '__');
    define("SEPARATOR", '__');
    define("SEPARATOR", '__');

    $act_dic = array(
        "next_rec" => 1,
        "edit_prod_rec" => 2,
        "edit_proj_rec" => 3,
        "add_prod_rec" => 4,
        "add_proj_rec" => 5,
        "edit_user_rec" => 6,
    );


    require_once('functions.php');
    require_once('auth_function.php');
    require_once('db/db_connect.php');
    require_once('db/db_general.php');
    require_once('db/db_insert.php');
    require_once('db/db_select.php');
    require_once('db/db_update.php');

    $db = db_connect();


    