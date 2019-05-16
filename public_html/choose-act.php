<?php
require_once('../private/init.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $events = general_query("Events");
//    $events = mysqli_fetch_assoc($res);


} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//
}
?>
<?php $page_title = 'choose act'; ?>
<?php include SHARED_PATH . '/shared_header.php' ?>

    <main>
        <h1>choose act</h1>
        <?php while ($event = mysqli_fetch_assoc($events)) { ?>
            <div class="card">
                <div class="info-con">
                    <p class="card-title"><?php echo $event['name'] ?> - hen ofer</p>
                    <p class="card-det">date: <?php echo $event['date'] ?></p>
                    <p class="card-det">location: <?php echo $event['location'] ?></p>
                    <p class="card-det">Description: <?php echo $event['description'] ?></p>
                    <br>
                </div>
                <button class="join-btn">Join</button>
            </div>

        <?php } ?>

    </main>


<?php
include SHARED_PATH . '/shared_footer.php';
