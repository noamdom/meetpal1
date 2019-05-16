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

//        echo 'login: ' . $userLogin . '<br>';
//        echo 'password: ' . $password . '<br>';
//
//        echo 's_pass:' . password_hash($password, PASSWORD_BCRYPT) . '<br>';

        // get users data:
        $user = user_by_username($userLogin);

        if ($user) {
//            echo 'db_pass ' . $user['userPass'] . '<br>';
            if (password_verify($password, $user['userPass'])) {
//            if ($password == $user['userPass']) {
                log_in($user);
                header("location: all-products.php");
                exit;
            } else {
                $_SESSION['msg'] =  "שגיאה בשם משתמש או סיסמה";
                header("location: login.php");
                exit;
            }
        } else {
            $_SESSION['msg'] =  "שגיאה בשם משתמש או סיסמה";
            header("location: login.php");
                exit;
        }
    }
?>

<?php $page_title = 'login'; ?>
<?php include SHARED_PATH . '/shared_header.php' ?>

<div class="log_con">
    <h1>meetpal</h1>
    <form action="login.php" method="post">
        <div class="log_content">   
            <label>שם משתמש:<br>
                <br>
                <input class="log_feild" type="text" name="userLogin" value="" />
            </label>
            <br>
            <br>
            <label>
                סיסמה:<br>
                <br>
                <input class="log_feild" type="password" name="password" value="" />
            </label>
            <br>
            <br>
            <input class="log_submit btn" type="submit" name="submit" value="אישור"  />
        </div>


    </form>

</div>


<?php
    include SHARED_PATH . '/shared_footer.php';

    