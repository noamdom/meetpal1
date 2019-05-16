<?php
    require_once('../private/init.php');
    $id = isset($_GET['id']) ? $_GET['id'] : '1';
    $act = isset($_GET['act']) ? $_GET['act'] : 'add';

    $id = esc_h($id);
    $act = esc_h($act);
    
    $msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
    unset($_SESSION['msg']);


    if ($act !== 'add') {
//        $result = mysqli_query($db, $sql);
        $product = prods_by_id_query($id);
    } else {
    }
    $projects = general_auery('projects');
    $prodsType = general_auery('prodsType');
    $sizes = general_auery('sizes');
    $phases = general_auery('phases');
    $phase_dic= mysqli_fetch_all($phases);
    $phases = general_auery('phases');


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['edit']) {
            insert_new_act_record($act_dic['edit_prod_rec'], $id); // it's saperated from update sql query for small changes
            update_product($id);
        } else if ($_POST['add']) {
            insert_new_act_record($act_dic['add_prod_rec'], $id); // it's saperated from update sql query for small changes
            insert_new_product('all-products.php');
            
           
        } else if ($_POST['next']) {
            
            //             mail:
               sendMail($id, $_POST['nextPhase']);
               
               insert_new_act_record($act_dic['next_rec'], $id); // it's saperated from update sql query for small changes
            
            $url = 'product.php?act=edit&id=' . $id;
            $d=$phase_dic[$_POST['nextPhase']-1][3];
            update_premote_phase($id, $_POST['nextPhase'], $url, $d);
        } else {
            header("location: all-products.php");
            exit;
        }
    } else if (($_SERVER['REQUEST_METHOD'] === 'GET')) {

        $name = $act != 'add' ? $product['prodName'] : '';
        $projId = $act === 'edit' ? $product['projId'] : '';
        $prodtype = $act === 'edit' ? $product['prodsTypeId'] : '';

        $size = $act === 'edit' ? $product['size'] : '';
        $paperType = $act == 'edit' ? $product['paperType'] : '';
        $colourful = $act == 'edit' ? $product['colourful'] : '';
        $bilateral = $act == 'edit' ? $product['bilateral'] : '';
        $cut = $act == 'edit' ? $product['cut'] : '';
        $quan = $act == 'edit' ? $product['quan'] : '0';
        $quanDesc = $act == 'edit' ? $product['quanDesc'] : '';
        $prodNote = $act == 'edit' ? $product['prodNote'] : '';
        $openDate = $act == 'edit' ? $product['openDate'] : '';
        $phase = $act != 'add' ? $product['phaseId'] : '';
        $phaseName = $act != 'add' ? $product['phaseName'] : '';

        $startPhaseDate = $act == 'edit' ? $product['startPhaseDate'] : '';
        $phaseDateEnd = $act == 'edit' ? $product['phaseDateEnd'] : '';
        $phaseDateEndToCalc = $act == 'edit' ? $product['phaseDateEndToCalc'] : '';
        $projectsDeadline = $act == 'edit' ? $product['deadline'] : '';
        $daysToDealine = $act == 'edit' ? $product['daysToDealine'] : '';
        $daysToEndPhase = $act == 'edit' ? $product['daysToEndPhase'] : '';
        $remainJobDays = $act == 'edit' ? $product['remainJobDays'] : '';
        $freedom = $act == 'edit' ? $product['freedom'] : '';
        
    }
?>



<?php $page_title = 'דף מוצר' ?>


<?php include ( SHARED_PATH . '/shared_header.php') ?>


<main>
   


    <?php ?>
    <?php if ($act !== 'next') { ?>

            <?php if ($act === 'edit') { ?>
                <h1 class="line">עזר מספר: <?php echo $id ?> </h1>
                <input class="btn line save_btn" form="prod_data" type="submit" name="edit" value="שמור">
            <?php } else { ?> 
                <h1 class="line">הוספת עזר</h1>
                <input class="btn line save_btn" form="prod_data" type="submit" name="add" value="הוסף">
            <?php } ?>
            <?php if ($act !== 'add') { ?>
                <input type="submit" class="btn line" form="nextPhase" name="next" value="<?php echo $act == 'edit' ? 'העבר שלב' : 'אישור'; ?> ">


            <?php } ?>


            <hr>

            <form class="triple-grid-container" id="prod_data" action="product.php?act=edit&id=<?php echo $id ?>" method="post">
                <div class="triple-grid-item">
                    <ul>
                        <li>
                            <label>
                                <span class="proj_title">שם העזר</span>
                                <input type='text' class="proj_feild" name='prodName' value='<?php echo esc_h($name) ?>'>
                            </label>
                        </li>
                        <li><label>
                                <span class="proj_title">מערך</span>

                                <select class="proj_feild" name='projectId' value=''>
                                    <?php write_db_option($projects, 'projId', 'projName', $projId); ?>
                                </select>
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="proj_title">סוג</span>
                                <select class="proj_feild" name='type' value=''>
                                    <?php write_db_option($prodsType, 'prodsTypeId', 'prodsTypeName', $prodtype); ?>
                                </select>
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="proj_title">גודל</span>
                                <select class="proj_feild" name='size' value=''>
                                    <?php write_db_option($sizes, 'sizeId', 'dimensions', $size); ?>
                                </select>
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="proj_title">סוג הנייר</span>
                                <input class="proj_feild" type='text' name='paperType' value='<?php echo esc_h($paperType) ?>'>
                            </label>
                        </li>
                        <li>
                            <label class="">
                                <span class="proj_title">צבעוני</span>
                                <input class="proj_feild" type='checkbox' name='colourful' value='1' <?php
                                if ($colourful) {
                                    echo 'checked';
                                }
                                ?>>
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="proj_title">דו-צדדי</span>
                                <input class="proj_feild" type='checkbox' name='bilateral' value='1' <?php
                                if ($bilateral) {
                                    echo 'checked';
                                }
                                ?>>
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="proj_title">חיתוך</span>
                                <input class="proj_feild" type='checkbox' name='cut' value='1' <?php
                                if ($cut) {
                                    echo 'checked';
                                }
                                ?>>
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="proj_title">כמות</span>
                                <input class="proj_feild" type='number' name='quan' value="<?php echo $quan ?>"
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="proj_title">הסבר לכמות</span>
                                <input class="proj_feild" type='text' name='quanDesc' value="<?php echo esc_h($quanDesc) ?>"
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="proj_title">הערות</span>
                                <textarea class="proj_feild" name='prodNote' rows="4" cols='30'><?php echo esc_h($prodNote) ?></textarea>
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="triple-grid-item">
                    <ul>
                        <li>
                            <label>
                                <span class="proj_title">שלב</span>
                                <select class="proj_feild" name='phase' value=''>
                                    <?php write_db_option($phases, 'phaseId', 'phaseName', $phase); ?>
                                </select>
                            </label>
                        </li>

                        <li>
                            <label>
                                <span class="proj_title">תאריך פתיחת עזר</span>
                                <input class="proj_feild" type='date' name='openDate' value='<?php date_2_input($openDate); ?>'>
                            </label>
                        </li>

                        <li>
                            <label>
                                <span class="proj_title">תאריך תחילת שלב</span>
                                <input class="proj_feild" type='date' name='startPhaseDate' value='<?php date_2_input($startPhaseDate) ?>'>
                            </label>
                        </li>
                        
                        <li>
                            <label>
                                 <?php if ($act != 'add') { ?>
                                <span class="proj_title">סיום שלב מתוכנן</span>
                                 <?php } else { ?>
                                <span class="proj_title">סיום שלב</span>
                                 <?php } ?>
                                <input class="proj_feild <?php alert_date($phaseDateEnd) ?>" type='date' name='phaseDateEnd' value='<?php date_2_input($phaseDateEnd) ?>'>
                            </label>
                        </li>
                        
                        <?php if ($act != 'add') { ?>
                                             
                            <li>
                                <label>
                                    <span class="proj_title">סיום שלב לחישוב</span>
                                    <span class="proj_calc" dir='ltr' ><?php echo date_2_screen($phaseDateEndToCalc) ?> </span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <span class="proj_title">תאריך סיום המערך</span>
                                    <span  class="proj_calc" dir='ltr'><?php echo date_2_screen($projectsDeadline) ?> </span>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <span class="proj_title">ימים לסיום המערך</span>
                                    <span class="proj_calc">
                                    <span <?php is_neg($daysToDealine); ?>>
                                        <?php echo $daysToDealine; ?> </span>
                                    </span>
                                </label>
                            </li>

                            <li>
                                <label>
                                    <span class="proj_title">ימים לסיום היצור</span>
                                    <span class="proj_calc">
                                    <span <?php is_neg($remainJobDays); ?>><?php echo $remainJobDays; ?> </span>
                                    </span>
                                </label>
                            </li>

                            <li>
                                <label>
                                    <span class="proj_title">חופש</span>
                                    <span class="proj_calc">
                                    <span <?php is_neg($freedom); ?>><?php echo $freedom; ?></span>
                                    </span>
                                </label>
                            </li>

                        </ul>
                    <?php } ?>
                </div>

                </div>
                <div class="grid-item">

                </div>
            </form>
            <hr>
            <form action="product.php?id=<?php echo $id ?>" method="post" id="nextPhase">
                <input type="hidden" name="nextPhase" value="<?php
                if ($phase < MAX_PHASE_VAL) {
                    echo $phase + 1;
                } else {
                    echo $phase;
                }
                ?>">
            </form>
        <?php } else if ($act == 'next') { ?>
            <form action="product.php?id=<?php echo $id ?>" method="post" id="nextPhase">
                <input type="hidden" name="nextPhase" value="<?php
                if ($phase < MAX_PHASE_VAL) {
                    echo $phase + 1;
                } else {
                    echo $phase;
                }
                ?>">
            </form>
            <p>נא אשר כי העזר: <?php echo $name ?> יעבור משלב "<?php echo $phaseName ?>" לשלב "<?php echo $phase + 1; ?>"</p>
        <?php } ?>



</main>


<?php
    include ( SHARED_PATH . '/shared_footer.php');
    