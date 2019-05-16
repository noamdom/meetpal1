<?php
    if (!isset($page_title)) {
        $page_title = '--';
    }
    if ($page_title != 'login') {
        require_login();
    }
?>


<!DOCTYPE html>
<html lang="he">
    <head>
        <meta charset="UTF-8">
        <title>מכילתא -  <?php echo $page_title; ?></title>
        <link href="css/style.css<?php echo '?v=' . mt_rand(); ?>" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    </head>
    <body dir="rtl">
        <header>
            <nav>
                <div class="rowcontainer">       
                    <div class="container">
                        <a href="http://yozmatorot.org.il/"><img src="img/logo.png" alt="logo Orot"></a>
                    </div><!--end navigation bar-->
                    <a class="nav_link " href="all-products.php">ריכוז עזרים</a> 
                    <!---->
                    <a class="nav_link" href="all-projects.php">ריכוז מערכים</a>
                    <a class="nav_link" href="archive.php">ארכיון</a>
                    <div class="dropdown">
                        <button class="nav_link dropdown_btn">
                            עריכה <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content dropdown_link">
                            <a class="nav_link dropdown_link" href="project.php?act=add&id=0">הוספת מערך</a>
                            <a class="nav_link dropdown_link" href="product.php?act=add&id=0">הוספת עזר</a>
                            <a class="nav_link dropdown_link" href="user.php?act=add&id=0">הוספת משתמש</a>
                            <a class="nav_link dropdown_link" href="update-options.php">עדכון טבלאות</a>
                        </div>
                    </div>
                    <a class="nav_link" href="logout.php">יציאה</a>
                </div>
            </nav>
        </header>
        <hr class="trans">
        <?php if ($msg) { ?>
                <div id="<?php echo ($page_title == 'login') ? 'wrong_log' : 'msg' ?>">
                    <?php echo $msg; ?>
                    </div>
                <?php } ?>
