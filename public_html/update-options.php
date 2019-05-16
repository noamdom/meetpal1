<?php
    require_once('../private/init.php');
//    global $db;

    $session_msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
    unset($_SESSION['msg']);


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['save_line']) {

            general_edit_table();
        } else if ($_POST['add_line']) {

            general_add_to_table();
        } else if ($_POST['del_line']) {

            general_delete_line();
        } else {
//             echo '<pre>';
//            print_r($_POST);
//            echo '</pre>';
            echo "something went wrong!!";
            exit;
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
    }


    $data = array();
?>




<?php $page_title = 'עדכון טבלאות' ?>

<?php include SHARED_PATH . '/shared_header.php' ?>
<style> 
    .unviewed_mode {
        display: none;
    }

    .fa-input {
        font-family: FontAwesome, 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }
</style>

<main >
    <h1>עדכון טבלאות</h1>
    <div>
        <?php echo $session_msg ?>
    </div>
    <div class="grid-table-container" >

        <div class="grid-table-item">
            <h2>שלבים</h2>
            <?php
                $table = 'phases';
                unset($data);
                $data = array();
                $types = data_query($table, 'type');
                while ($t = mysqli_fetch_assoc($types)) {
                    $input = echo_type($t['DATA_TYPE']);
                    $data[$t['COLUMN_NAME']] = array($input, $t['COLUMN_COMMENT']);
                }
                $sylbs = general_auery($table);
                $tblH = true;

                require('general_table.php');
            ?>
        </div>

        <div class="grid-table-item">
            <h2>תוכניות לימוד</h2>
            <?php
                $table = 'syllabus';
                $types = data_query($table, 'type');
                while ($t = mysqli_fetch_assoc($types)) {
                    $input = echo_type($t['DATA_TYPE']);
                    $data[$t['COLUMN_NAME']] = array($input, $t['COLUMN_COMMENT']);
                }
                $sylbs = general_auery('syllabus');
                $tblH = true;
                require('general_table.php');
            ?>
        </div>

        <div class="grid-table-item">
            <h2>תוכניות</h2>
            <?php
                $table = 'institutes';

                unset($data);
                $data = array();
                $types = data_query($table, 'type');
                while ($t = mysqli_fetch_assoc($types)) {
                    $input = echo_type($t['DATA_TYPE']);
                    $data[$t['COLUMN_NAME']] = array($input, $t['COLUMN_COMMENT']);
                }
                $sylbs = general_auery($table);
                $tblH = true;

                require('general_table.php');
            ?>
        </div>


        <div class="grid-table-item">
            <h2>גדלים</h2>
            <?php
                $table = 'sizes';

                unset($data);
                $data = array();
                $types = data_query($table, 'type');
                while ($t = mysqli_fetch_assoc($types)) {
                    $input = echo_type($t['DATA_TYPE']);
                    $data[$t['COLUMN_NAME']] = array($input, $t['COLUMN_COMMENT']);
                }
                $sylbs = general_auery($table);
                $tblH = true;

               require('general_table.php');
            ?>
        </div>

        <div class="grid-table-item">
            <h2>סוגי משתמשים</h2>
            <?php
                $table = 'usersType';

                unset($data);
                $data = array();
                $types = data_query($table, 'type');
                while ($t = mysqli_fetch_assoc($types)) {
                    $input = echo_type($t['DATA_TYPE']);
                    $data[$t['COLUMN_NAME']] = array($input, $t['COLUMN_COMMENT']);
                }
                $sylbs = general_auery($table);
                $tblH = true;

                require('general_table.php');
            ?>
        </div>


        <div class="grid-table-item">
            <h2>סוגי עזרים</h2>
            <?php
                $table = 'prodsType';

                unset($data);
                $data = array();
                $types = data_query($table, 'type');
                while ($t = mysqli_fetch_assoc($types)) {
                    $input = echo_type($t['DATA_TYPE']);
                    $data[$t['COLUMN_NAME']] = array($input, $t['COLUMN_COMMENT']);
                }
                $sylbs = general_auery($table);
                $tblH = true;

               require('general_table.php');
            ?>
        </div>



    </div>


    <div id="confirm_back">
        <form id="del_form" action="update-options.php" method="post">
            <div id="confirm_del">
                <div class="del_head">
                    אישור מחיקת שורה
                </div>

                <input  type="hidden" id="del_table" name="del_table" value="">
                <input  type="hidden" id="del_id_name" name="del_id_name" value="">
                <input  type="hidden" id="del_id" name="del_id" value="">
                <p id="del_msg"></p>
                <h6>שים לב, מחיקת שורה זו עלולה להשפיע באופן בלתי צפוי על כלל המערכת</h6>

                <div class="del_foot">
                    <input class="btn" type="submit" name='del_line' value="אישור">
                    <button class="btn" onclick=" return cancel_del()">ביטול</button>
                </div>
        </form>
    </div>


    <script>

        var write_mode = false;
        var write_table;
        var write_line;

    </script> 
    <script src="js/edit_tables.js<?php echo '?v=' . mt_rand(); ?>"></script>
    <script src="js/del_line.js<?php echo '?v=' . mt_rand(); ?>"></script>



</main>

<?php include SHARED_PATH . '/shared_footer.php' ?>




<?php
    