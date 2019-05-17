<?php
require_once('../private/init.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {



} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    print_r($_POST);

    new_event($_SESSION['user_id']);
    echo '<br>';



}
?>
<?php $page_title = 'choose act'; ?>
<?php include SHARED_PATH . '/shared_header.php' ?>

    <style>

        .add-activity-back {
            background: #f9f7f7;
            border: 2px solid #ddcccc;
            height:450px;
            width: 30%;
            margin-left: 35%;
            margin-top: 30px;
            margin-bottom: 30px;
            border-radius: 5px;
        }

        .add-activity-lbl {

            font-size: 50px;
            color:  #A1D8D0;
            margin-left: 60px;
            font-family: 'Rockwell';
        }

        .insert-activity {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .activity-title {
            margin-left: 40px;
            margin-right: 20px;
            font-size: 20px;
            color: #B58585;
            font-family: 'Rockwell';
        }

        .info {
            margin-top:50px;
        }

        .input-bar{
            background-color:  #EDE8E8;
            color: #B58585;
        }

        .add-btn {
            margin-top:2%;
            background-color:  #B58585;
            color: #EDE8E8;
            width:200px;
            height: 30px;
            font-family: 'Rockwell';
            margin-left: 90px;
            border: 1px solid  white;
        }

        .add-btn:hover {
            opacity: 0.7;
        }
    </style>

    <main>
        <form action="add-event.php" method="post">
            <div class="add-activity-back">

                <label class="add-activity-lbl" >Add Activity</label>

                <div class="info">
                    <div class="insert-activity">
                        <label class="activity-title">Name:</label>
                        <input name="name" class="input-bar" type="text"> </input>
                    </div>

                    <div class="insert-activity">
                        <label class="activity-title" >Which activity:</label>
                        <select  name = "category" class="input-bar" >
                            <option value="" disabled selected hidden>choose category..</option>
                            <option value="arts">arts</option>
                            <option value="baking">baking</option>
                            <option value="cooking">cooking</option>
                            <option value="design">design</option>
                            <option value="massage">massage</option>
                            <option value="meditation">meditation</option>
                            <option value="music">music</option>
                            <option value="run">run</option>
                            <option value="yoga">yoga</option>
                        </select>
                    </div>

                    <div class="insert-activity">
                        <label class="activity-title">Location:</label>
                        <input name="location" class="input-bar" type="text"> </input>
                    </div>

                    <div class="insert-activity">
                        <label class="activity-title">Date:</label>
                        <input name='date' class="input-bar" type="date" pattern="[A-Za-z0-9]+"></input>
                    </div>


                    <div class="insert-activity">
                        <label class="activity-title">Description:</label>
                        <textarea name='description' class="input-bar" ></textarea>
                    </div>

                    <button onclick="event_added()" class="add-btn">Add Activity</button>
                </div>
            </div>

        </form>


    </main>
<script>
    function event_added() {
        alert("event added successfully");
    }

</script>


<?php
include SHARED_PATH . '/shared_footer.php';
