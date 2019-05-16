<?php
    require_once('../private/init.php');
    $id = isset($_GET['id']) ? $_GET['id'] : '1';
    $act = isset($_GET['act']) ? $_GET['act'] : 'add';

    esc_h($id);
    esc_h($act);

    $user = null;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['edit']) {



            update_phase($id, $phaseName, $startAfter, $during, $toEnd, $description, $phaseNum, $active);
        } else if ($_POST['add']) {
//            debug("post");
            insert_user();
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $userTypes = general_auery("usersType");

        $userName = $act === 'edit' ? $user['phaseName'] : '';
        $userLogin = $act === 'edit' ? $user['startAfter'] : '';
        $userPass = $act === 'edit' ? $user['during'] : '';
        $userType = $act === 'edit' ? $user['toEnd'] : '';
        $userMail = $act === 'edit' ? $user['description'] : '';
    }
?>


<?php $page_title = 'משתמש' ?>

<?php include ( SHARED_PATH . '/shared_header.php') ?>


<main>


    <div class="log_con"> 
    <form  action="user.php?id=<?php echo $id ?>" method="post">
        <div class="log_content"> 
            <br>
            <br>
            <label>שם:
                <br>
                <br>
            <input type='text' class='log_feild' name='userName' value='<?php echo esc_h($userName) ?>'>
            </label>
            <br>
            <br>

            <label title='ספרות ואותיות אנגליות בלבד'>שם משתמש:
            <br><br>
            <input type='text' class='log_feild' name='userLogin' pattern="[A-Za-z]+" value='<?php echo esc_h($userLogin) ?>' title='ספרות ואותיות אנגליות בלבד'>
            </label>
            <br>
            <br>
            
            <label title="ספרות ואותיות אנגליות בלבד">
             סיסמה:
             <br><br>
            <input type='text' class='log_feild'  name='userPass' pattern="[A-Za-z0-9]+" value='<?php echo esc_h($userPass) ?>' title='ספרות ואותיות אנגליות בלד'>
            </label>
            <br>
            <br>
            <label> 
            סוג משתמש:<br><br>
            <!--<dd><input type='number' name='userType' value='<?php echo esc_h($userType) ?>'></dd>-->
            <select name='userType' class="log_feild" value=''>
                    <?php write_db_option($userTypes, 'userTypeId', 'userTypeName', ''); ?>
                </select>
            </label>
            <br>
            <br>

            <label> 
            אי-מייל:<br><br>
            <input type='email' class="log_feild" name='userMail' value='<?php echo esc_h($userMail) ?>'>
            </label>
            <br>
            <br>
        <?php if ($act === 'edit') { ?>
                <input class="log_submit btn" type="submit" name="edit" value="ערוך">
            <?php } else { ?> 
                <input class="log_submit btn" type="submit" name="add" value="הוסף">
            <?php } ?>
        </div>
    </form>
          </div>

</main>

<?php
    include ( SHARED_PATH . '/shared_footer.php');
    