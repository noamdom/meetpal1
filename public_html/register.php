<?php
require_once('../private/init.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $events = general_query("Events");
//    $events = mysqli_fetch_assoc($res);


} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $names = check_exist_user('Users', $username);
    if ($names->num_rows !== 0) {
        $server_msg = "username is already exist";
    } else if ($_POST['password1'] !== $_POST['password2']){
        $server_msg = "please confirm password";
    } else {
        register();
        $server_msg = "good";
    }

}
?>
<?php $page_title = 'choose act'; ?>
<?php include SHARED_PATH . '/shared_header.php' ?>

    <style>
        .register-back {
            background: #f9f7f7;
            border: 2px solid #ddcccc;
            height: 400px;
            width: 30%;
            margin-left: 35%;
            margin-top: 30px;
            margin-bottom: 30px;
            border-radius: 20px;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            height: 6%;
            width: 100%;
            background: #f9f7f7;
            color: white;
            text-align: center;
            border: 4px solid #EDE4E4;
        }

        .register-lbl {
            font-size: 50px;
            color: #A1D8D0;
            margin-left: 100px;
            font-family: 'Rockwell';
        }

        .title-register {
            margin-top: 25px;
            margin-bottom: 25px;
        }

        .info {
            margin-top: 50px;
        }

        .insert-register {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .register-title {
            margin-left: 40px;
            margin-right: 20px;
            font-size: 15px;
            color: #B58585;
            font-family: 'Rockwell';
        }

        .input-bar {
            background-color: #EDE8E8;
            color: #B58585;
        }

        .register-btn {
            margin-top: 50px;
            background-color: #B58585;
            color: #EDE8E8;
            width: 200px;
            height: 30px;
            font-family: 'Rockwell';
            margin-left: 90px;
            border: 1px solid #ddcccc;
        }

    </style>

    <main>
        <p>massage: <?php echo $server_msg ?></p>

        <form action="register.php" method="post">
            <div class="register-back">

                <div class="title-register">
                    <label class="register-lbl">Register</label>
                </div>

                <div class="info">
                    <div class="insert-register">
                        <label class="register-title">Username:</label>
                        <input name="username" class="input-bar" type="text"> </input>
                    </div>

                    <div class="insert-register">
                        <label class="register-title">Email:</label>
                        <input name="email" class="input-bar" type="email"> </input>
                    </div>

                    <div class="insert-register">
                        <label class="register-title">Password:</label>
                        <input name='password1' class="input-bar" type="password" pattern="[A-Za-z0-9]+"></input>
                    </div>

                    <div class="insert-register">
                        <label class="register-title">Confirm Password:</label>
                        <input name='password2' class="input-bar" type="password" pattern="[A-Za-z0-9]+"></input>
                    </div>
                    <button class="register-btn" id="register-btn">sign up</button>
                </div>
            </div>
        </form>


    </main>


<?php
include SHARED_PATH . '/shared_footer.php';
