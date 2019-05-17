<?php
require_once('../private/init.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $cate = isset($_GET['cate']) ? $_GET['cate'] : 'yyy';
    $events = events_by_category($cate);


} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $event_id = $_POST['event_id'];
    $user_id = $_SESSION['user_id'];
    join_event($event_id,$user_id);
    $msg = "you joined";
//
}
?>
<?php $page_title = 'choose act'; ?>
<?php include SHARED_PATH . '/shared_header.php' ?>

<style>

    .grid-container {
        display: grid;
        grid-template-columns: auto auto auto;
        width: 70%;
        margin-left: 15%;
    }

    .grid-item {
        width: 92%;
        margin: 3%;
    }

    .Activity-lbl {
        font-size: 50px;
        color:  #A1D8D0;
        margin-left: 40%;
        margin-top: 2%;
        font-family: 'Rockwell';
    }


    .row {
        margin-left: 8%;
        margin-top: 2%;
        height: 10rem;
        width: 100%;
        margin-bottom:5%;
    }

    .activity-back {
        float: left;
        margin-left: 5%;
        background-color: transparent;
        height:10rem;
        /*width: 20%;*/
        border-radius: 10px;
        font-optical-sizing: 62;
    }

    .activity-all {
        align-items: baseline;
        margin-bottom: 4%;
    }

    /* Clearfix (clear floats) */
    .row::after {
        content: "";
        clear: both;
        display: table;
    }

    .act-name{
        font-size: 1.3rem;
        margin-left: 15%;
        color: #B58585;
        font-family: 'Rockwell';

    }

    .act-info {
        margin-top: 3%;
    }

    .info-details {
        text-decoration: underline;
        color:  #A1D8D0;
        font-family: 'Rockwell';
        margin-left: 5%;
        font-size: 1rem;
    }

    .act-info-change{
        color:  #A1D8D0;
        font-family: 'Rockwell';
        font-size: 1rem;
        margin-left: 5%;
        margin-right: 5%;
    }

    .flip-card-front {
        background: #f9f7f7;
        border: 2px solid #ddcccc;
        height: 100%;
        width: 100%;
        border-radius: 10px;
    }

    .flip-card-back {
        background: #f9f7f7;
        border: 2px solid #ddcccc;
        height:100%;
        width: 100%;
        border-radius: 10px;
        transform: rotateY(180deg);
    }


    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 0.8s;
        transform-style: preserve-3d;
    }

    .activity-back:hover .flip-card-inner {
        transform: rotateY(180deg);
    }

    .flip-card-front, .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
    }

    .join-btn {
        background-color:  #B58585;
        color: #EDE8E8;
        width:25%;
        height: 15%;
        font-family: 'Rockwell';
        margin-left: 35%;
        border: 1px solid  #EDE8E8;
    }

    .join-btn:hover {
        opacity:0.7;
    }

    .desc {
        width:90%;
        height: 10%;
        overflow: scroll;
        color:  #A1D8D0;
        font-family: 'Rockwell';
        font-size: 70%;
        margin-left: 5%;
        margin-right: 5%;
    }
</style>


    <main>
        <label class="Activity-lbl" >Activities</label>
        <div class="grid-container">



        <?php while ($event = mysqli_fetch_assoc($events)) { ?>
            <div class="activity-back grid-item">
                <div class="flip-card-inner">

                    <div class="flip-card-front">
                        <label class="act-name"><?php echo $event['name']?> </label>

                        <div class="act-info">
                            <label class="info-details">Address:</label>
                            <label class="act-info-change"><?php echo $event['location']?></label>
                        </div>

                        <div class="act-info">
                            <label class="info-details">Date:</label>
                            <label class="act-info-change"><?php echo $event['date']?></label>
                        </div>

<!--                        <div class="act-info">-->
<!--                            <label class="info-details">Time:</label>-->
<!--                            <label class="act-info-change">to change</label>-->
<!--                        </div>-->

                        <div class="act-info">
                            <label class="info-details">Host:</label>
                            <label class="act-info-change"><?php echo $event['username'] ?> </label>
                        </div>
                    </div>

                    <div class="flip-card-back">
                        <label class="act-name"><?php echo $event['name']?></label>

                        <div class="act-info">
                            <label class="info-details">Description:</label>
                            <p class="act-info-change"><?php echo $event['description']?> </p>
                        </div>

                        <button class="join-btn" onclick="submit_id_event(<?php echo $event['id'] ?>)">Join</button>


                    </div>
                </div>
            </div>
        <?php } ?>


        </div>





        <form name="submit_event" action="choose-act.php" method="post">
            <input type="hidden" name="event_id" id="event_id" value="">
        </form>

    </main>





<script>
    function submit_id_event(event_id) {
        var sumbit = document.getElementById("event_id");
        sumbit.value = event_id;
        alert("you joined to an event");
        document.getElementsByTagName('form')[0].submit()

    }



</script>


<?php
include SHARED_PATH . '/shared_footer.php';
