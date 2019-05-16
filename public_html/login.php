<?php
    require_once('../private/init.php');


    $errors = [];
    $username = '';
    $password = '';
    
     $msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
    unset($_SESSION['msg']);



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//        debug();
        // get post  date:
        $userLogin = isset($_POST['userLogin']) ? $_POST['userLogin'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        echo 'login: ' . $userLogin . '<br>';
        echo 'password: ' . $password . '<br>';
//
//        echo 's_pass:' . password_hash($password, PASSWORD_BCRYPT) . '<br>';

        // get users data:
        $user = user_by_username($userLogin);
        print_r($user);
        if ($user) {
            if ($password === $user['pword']) {
                $server_msg = "connect";
                log_in($user);
                header("location: find-host.php");
            } else {
                $server_msg = "wrong pass";
            }

        } else {
            $server_msg = "wrong username";
        }


//        if ($user) {
////            echo 'db_pass ' . $user['userPass'] . '<br>';
//            if (password_verify($password, $user['userPass'])) {
////            if ($password == $user['userPass']) {
//                log_in($user);
//                header("location: all-products.php");
//                exit;
//            } else {
//                $_SESSION['msg'] =  "שגיאה בשם משתמש או סיסמה";
//                header("location: login.php");
//                exit;
//            }
        } else {
            $server_msg = "wrong input";
    }
?>

<?php $page_title = 'login'; ?>
<?php include SHARED_PATH . '/shared_header.php' ?>

<style>
    .login-back {
        background: #f9f7f7;
        border: 2px solid #ddcccc;
        height:400px;
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

    .sign-in-lbl {
        font-size: 50px;
        color:  #A1D8D0;
        margin-left: 100px;
        font-family: 'Rockwell';
    }

    .title-sign-in {
        margin-top: 25px;
        margin-bottom: 25px;
    }

    .info {
        margin-top:50px;
    }

    .insert-login {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .login-title {
        margin-left: 40px;
        margin-right: 20px;
        font-size: 20px;
        color: #B58585;
        font-family: 'Rockwell';
    }

    .input-bar{
        background-color:  #EDE8E8;
        color: #B58585;
    }

    .login-btn {
        margin-top: 50px;
        background-color:  #B58585;
        color: #EDE8E8;
        width:200px;
        height: 30px;
        font-family: 'Rockwell';
        margin-left: 90px;
        border: 1px solid  #ddcccc;
    }

    .create-user-title {
        color: #B58585;
        font-size: 12px;
        font-family: 'Rockwell';
        margin-left: 70px;
    }

    .create-account {
        color: #B58585;
        font-size: 12px;
        font-family: 'Rockwell';
        font-weight: bold;
    }

    .link-sign-up{
        color:#B58585;
    }
    .link-sign-up:hover {
        opacity: 0.7;
    }

</style>
    <p>massage: <?php echo $server_msg ?></p>

    <form action="login.php" method="post">
        <div class="login-back">
            <div class="title-sign-in">
                <label class="sign-in-lbl" >Sign In</label>
            </div>

            <div class="info">

                <div class="insert-login">
                    <label class="login-title" >Username:</label>
                    <input name="userLogin" class="input-bar" type="text"> </input>
                </div>

                <div class="insert-login">
                    <label class="login-title">Password:</label>
                    <input name="password" class="input-bar" type="password"> </input>
                </div>

                <div>
                    <label class="create-user-title">don't have an account yet?
                        <label class="create-account"><a class="link-sign-up" href="register.php" ><strong>sign up here!</strong></a></label>
                    </label>
                </div>

                <button class="login-btn" id="sign-in-btn">sign in</button>
            </div>
        </div>

</div>

    </form>



<?php
    include SHARED_PATH . '/shared_footer.php';

    