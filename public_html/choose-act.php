<?php
require_once('../private/init.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//
}
?>
<?php $page_title = 'choose act'; ?>
<?php include SHARED_PATH . '/shared_header.php' ?>

    <main>
        <h1>choose act</h1>

        <?php
       $events = general_query("Events");
        $events = mysqli_fetch_assoc($result);
        print_r($events);

//        echo $events;
        ?>
    </main>



<?php
include SHARED_PATH . '/shared_footer.php';
