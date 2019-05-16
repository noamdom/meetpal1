<?php
require_once('../private/init.php');
$id = isset($_GET['id']) ? $_GET['id'] : '1';
$act = isset($_GET['act']) ? $_GET['act'] : 'add';

esc_h($id);
esc_h($act);

$phase = general_id_query('phases' , $id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['edit']) {
        $phaseName = $_POST['phaseName'];
        $startAfter = $_POST['startAfter'];
        $during = $_POST['during'];
        $toEnd = $_POST['toEnd'];
        $description = $_POST['description'];
        $phaseNum = $_POST['phaseNum'];
        $active = $_POST['active'];

       
        update_phase($id, $phaseName, $startAfter, $during, $toEnd, $description, $phaseNum, $active);
    } 
    else if ($_POST['add']) {
        
        $phaseName = $_POST['phaseName'];
        $startAfter = $_POST['startAfter'];
        $during = $_POST['during'];
        $toEnd = $_POST['toEnd'];
        $description = $_POST['description'];
        $phaseNum = $_POST['phaseNum'];
        $active = $_POST['active'];

        insert_phase($phaseName, $startAfter, $during, $toEnd, $description, $phaseNum, $active);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $phaseName = $act === 'edit' ? $phase['phaseName'] : '';
    $startAfter = $act === 'edit' ? $phase['startAfter'] : '';
    $during = $act === 'edit' ? $phase['during'] : '';
    $toEnd = $act === 'edit' ? $phase['toEnd'] : '';
    $description = $act === 'edit' ? $phase['description'] : '';
    $phaseNum = $act === 'edit' ? $phase['phaseNum'] : '';
    $active = $act === 'edit' ? $phase['active'] : '';
}
?>


<?php $page_title = 'שלב' ?>

<?php include ( SHARED_PATH . '/shared_header.php') ?>


<main>
    
<!--    <form  action="phase.php?id=<?php echo $id ?>" method ="post">
        <input type="submit" name="delete" value="מחק שלב">
    </form>-->


    <form  action="phase.php?id=<?php echo $id ?>" method="post">
        <dl>
            <dt>שם השלב</dt>
            <dd><input type='text' name='phaseName' value='<?php echo esc_h($phaseName) ?>'></dd>
            <dt>מתחיל אחרי</dt>
            <dd>
                <select name='startAfter' value=''>
                    <option value="1" <?php
                    if ($startAfter == '1') {
                        echo ' selected ';
                    }
                    ?>>Volvo</option>
                    <option value="2" <?php
                    if ($startAfter == '2') {
                        echo ' selected ';
                    }
                    ?>>Saab</option>
                    <option value="3" <?php
                            if ($startAfter == '3') {
                                echo ' selected ';
                            }
                    ?>>Mercedes</option>
                </select>
            </dd>
            <dt>משך</dt>
            <dd><input type='number' name='during' value='<?php echo $during ?>'></dd>
            <dt> לסיום</dt>
            <dd><input type='number' name='toEnd' value='<?php echo $toEnd ?>'></dd>
            <dt>תאור</dt>
            <dd><input type='text' name='description' value='<?php echo $description ?>' ></dd>
            <dt>מספר שלב</dt>
            <dd><input type='number' name='phaseNum' value='<?php echo $phaseNum ?>' ></dd>
            <dt> פעיל </dt>
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