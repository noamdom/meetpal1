<?php
    require_once('../private/init.php');
    $id = isset($_GET['id']) ? $_GET['id'] : '1';
    $act = isset($_GET['act']) ? $_GET['act'] : 'add';

    esc_h($id);
    esc_h($act);

    $user = null;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['edit']) {

        } else if ($_POST['add']) {
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $phases = general_auery('phases');

        }
?>


<?php $page_title = 'sandbox' ?>

<?php include ( SHARED_PATH . '/shared_header.php') ?>


<main>
    <?php 
        
        echo '<pre>';
        print_r ($phases);
        echo '</pre>';
           
        $p = mysqli_fetch_all($phases, MYSQLI_BOTH);
        echo $p[5][1];
        ?>

</main>

<?php
    include ( SHARED_PATH . '/shared_footer.php');
    