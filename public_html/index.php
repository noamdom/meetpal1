<?php require_once('../private/init.php') ?>

<?php $page_title = 'תוכן' ?>

<?php include SHARED_PATH . '/shared_header.php' ?>
<main>
    <p>index </p>
</main>
<?php include SHARED_PATH . '/shared_footer.php' ?>




<?php
    mysqli_free_result($mehilta);
  header("location: all-products.php");
        exit;