<?php require_once('../private/init.php');
$id = isset($_GET['id']) ? $_GET['id'] : '1';
$act = isset($_GET['act']) ? $_GET['act'] : 'add';

esc_h($id);
esc_h($act);

$syllab = general_id_query('syllabus' , $id);
$institutes = general_query('institutes');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     if ($_POST['edit']) {
        $name = $_POST['name'];
        $instu = $_POST['institute'];
        $active = $_POST['active'];
        
        debug();
        update_syllabus($id ,$name, $instu, $active);
        
     }    
} else if (($_SERVER['REQUEST_METHOD'] === 'GET')) {
    $id = $act === 'edit' ? $syllab['id'] : '';
    $name = $act === 'edit' ? $syllab['name'] : '';
    $institute = $act === 'edit' ? $syllab['institute'] : '';
    $active = $act === 'edit' ? $syllab['active'] : '';
}

?>


<?php $page_title = 'תוכניות לימודים' ?>


<?php include ( SHARED_PATH . '/shared_header.php'); ?>


<main>
    
<!--    <form  action="phase.php?id=<?php echo $id ?>" method ="post">
        <input type="submit" name="delete" value="מחק שלב">
    </form>-->


    <form  action="syllabus.php?id=<?php echo $id ?>" method="post">
        <dl>
            <dt>שם תוכנית הלימוד</dt>
            <dd><input type='text' name='name' value='<?php echo esc_h($name) ?>'></dd>
              <dt>תוכנית</dt>
            <dd>
                <select name='institute' value=''>
                    <?php write_db_option($institutes, 'instuId', 'instuName', $institute); ?>
                </select>
            </dd>
            <dt>פעיל</dt>
            <dd>
                <select name='active' value=''>
                    <option value="1" <?php
                            if ($active == 1) {
                                echo ' selected ';
                            }
                    ?>>פעיל</option>
                    <option value="1" <?php
                            if ($active != 1) {
                                echo ' selected ';
                            }
                    ?>>לא פעיל</option>

                </select>
            </dd>

        </dl>
        <?php if ($act === 'edit') { ?>
            <input type="submit" name="edit" value="ערוך">
        <?php }else { ?> 
            <input type="submit" name="add" value="הוסף">
        <?php } ?>
    </form>

</main>

<?php include ( SHARED_PATH . '/shared_footer.php'); 