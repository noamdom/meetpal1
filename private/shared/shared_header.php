<?php
    if (!isset($page_title)) {
        $page_title = '--';
    }
//    if ($page_title != 'login') {
//        require_login();
//    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $page_title; ?></title>
        <link href="css/style.css<?php echo '?v=' . mt_rand(); ?>" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<!--        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />-->
<!--        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->
<!--        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>-->
    </head>
    <body>
    <style>
        .topnav {
            background:  #f9f7f7;
            color: white;
            height: 70px;
            border-bottom: 4px solid #EDE4E4;
        }

        .logo {
            margin-left: 20%;
            margin-right: 35%;
        }

    </style>
        <header>
            <div class="topnav">
                <a href= "find-host.php"><img class= "logo" src="assets/logo.jpeg" width="170" height="60"></a>
                <a href="profile.php"><img class= "profile" src="assets/profile.jpeg" width="40" height="40" ></a>
            </div>

<!--            <nav>-->
<!--                <div class="rowcontainer">       -->
<!--                    <div class="container">-->
<!--                        <a href="http://yozmatorot.org.il/"><img src="img/meetpal-logo.png" alt="logo Orot"></a>-->
<!--                    </div><!--end navigation bar-->
<!--                    <a class="nav_link " href="find-host.php">find-host</a>-->
<!--                    <!---->
<!--                    <a class="nav_link" href="categories.php">categories</a>-->
<!--                    <a class="nav_link" href="choose-act.php">coose-act</a>-->
<!---->
<!--                </div>-->
<!--            </nav>-->
        </header>

        <?php if ($msg) { ?>
                <div id="<?php echo ($page_title == 'login') ? 'wrong_log' : 'msg' ?>">
                    <?php echo $msg; ?>
                    </div>
                <?php } ?>
