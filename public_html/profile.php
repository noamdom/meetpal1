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

<style>

    .top-box {
        background: #f9f7f7;
        border: 1px solid #ddcccc;
        height:80px;
        width: 50%;
        border-radius: 10px;
        margin-left: 20%;
        margin-top : 15px;
    }

    .profile-pic {
        width: 75px;
        height: 75px;
        margin-left: 5%;
        margin-top: 0.3%;
    }

    .profile-lbl {
        font-size: 300%;
        color:  #A1D8D0;
        margin-left:10%;
        font-family: 'Rockwell';
    }

    .user-info {
        margin-left: 15%;
        font-size: 100%;
        color: #B58585;
        font-family: 'Rockwell';
        margin-top: 10%;
    }
    .column-box {
        float: left;
        margin-left: 10%;
        background:  #f9f7f7;
        border: 1px solid #ddcccc;
        height:20rem;
        width: 20%;
        border-radius: 10px;
        font-optical-sizing: 62;
    }

    .row {
        margin-left: 10%;
        margin-top: 2%;
        height:20rem;
        width: 100%;
        margin-bottom:5%;
    }

    /* Clearfix (clear floats) */
    .row::after {
        content: "";
        clear: both;
        display: table;
    }

    .box-lbl {
        font-size: 150%;
        color:  #A1D8D0;
        margin-left: 5%;
        margin-right: 5%;
        font-family: 'Rockwell';
    }

    .activity {
        color: #B58585;
        font-size: 1rem;
        font-family: 'Rockwell';
        margin-left: 2%;
        margin-bottom: 2%;
    }


</style>
    <main>

        <div class="top-box">
            <img src="assets/profile.jpeg" class="profile-pic">
            <label class="profile-lbl">Profile</label>
            <label class="user-info">Welcome <?php echo $_SESSION['username'] ?></label>
        </div>

        <div class="row">
            <div class="column-box">
                <label class="box-lbl" >Participate Activity</label>
                <ul>
                        <li class='activity'>dinner</li>
                </ul>
            </div>

            <div class="column-box" style="height: 15rem;">
                <label class="box-lbl" >Hosting Activitys</label>
                <ul>
                    <?php while ($p = mysqli_fetch_array($provider)) {
                        echo "<li class='activity'>" . $p[0] . "</li>";
                    } ?>
                </ul>
            </div>
        </div>




    </main>


<?php
include SHARED_PATH . '/shared_footer.php';
