<?php
require_once('../private/init.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $participating = my_participating_events($_SESSION['user_id']);
    $provider = my_provider_events($_SESSION['user_id']);


} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//
}
?>
<?php $page_title = 'categories'; ?>
<?php include SHARED_PATH . '/shared_header.php' ?>

    <main>
        <h1>Profile</h1>

        <p>my participting events</p>
        <ul>
            <?php while ($p = mysqli_fetch_array($participating)) {
                echo "<li>" . $p[0] . "</li>";
            } ?>
        </ul>


        <p>my participting events</p>
        <ul>
            <?php while ($p = mysqli_fetch_array($provider)) {
                echo "<li>" . $p[0] . "</li>";
            } ?>
        </ul>





    </main>


<?php
include SHARED_PATH . '/shared_footer.php';
