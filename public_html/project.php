<?php
    require_once('../private/init.php');
    $act = isset($_GET['act']) ? $_GET['act'] : 'add';
    $id = isset($_GET['id']) ? $_GET['id'] : '1';

    $col = isset($_GET['col']) ? $_GET['col'] : 'freedom';
    $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';


    esc_h($id);
    esc_h($act);

    $msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
    unset($_SESSION['msg']);

    if ($act === 'edit') {
        $project = general_id_query('projects', $id);
        $products_set = prods_by_project($id, $col, $order);
    } else {
        
    }
    $phases = general_auery('phases');
    $phase_dic = mysqli_fetch_all($phases);

    $resp = general_auery('resp');
    $syllab = general_auery('syllabus');
    $institutes = general_auery('institutes');

    $phases1 = general_auery('phases');
    $prodsType = general_auery('prodsType');
    $sizes = general_auery('sizes');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        if ($_POST['edit']) {
            insert_new_act_record($act_dic['edit_proj_rec'], $id); // it's saperated from update sql query for small changes
            update_project($id);

//   } else if ($_POST['delete']) {
//        general_delete('projects', $id);
//        
//    } 
        } else if ($_POST['add']) {
            insert_new_act_record($act_dic['add_proj_rec'], null); 
            insert_new_project();
        } else if ($_POST['next']) {
//            $_SESSION['tr_id'] = $_POST['nextId'];
//             mail:
            sendMail($_POST['nextId'], $_POST['nextPhase']);
            insert_new_act_record($act_dic['next_rec'], $_POST['nextId']); 
//             archive issue:
            if ($_POST['nextPhase'] == MAX_PHASE_VAL) {
                upload_files($_POST['nextId']);
            }
//             phase promotion:
            $url = 'project.php?act=edit&id=' . $id;
            $d = $phase_dic[$_POST['nextId']][3];
            update_premote_phase($_POST['nextId'], $_POST['nextPhase'], $url, $d);
        } else if ($_POST['add_prod']) {
             insert_new_act_record($act_dic['add_prod_rec'], 0); 
            echo "add_prod";
            $url = 'project.php?act=edit&id=' . $id;
            insert_new_product($url);
        } else {
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            echo "problemmm!!";
            exit;
        }
    } else if (($_SERVER['REQUEST_METHOD'] === 'GET')) {
        $name = $act === 'edit' ? $project['projName'] : '';
        $unit = $act === 'edit' ? $project['projUnit'] : '';
        $syllabus = $act === 'edit' ? $project['syllabus'] : '';
        $institute = $act === 'edit' ? $project['institute'] : '';
        $deadline = $act === 'edit' ? $project['deadline'] : '';
        $phase = $act === 'edit' ? $project['phase'] : '';
        $fromDate = $act === 'edit' ? $project['fromDate'] : '';
//        $respId = $act === 'edit' ? $project['respId'] : '';
        $projWriter = $act === 'edit' ? $project['projWriter'] : '';
        $projResp = $act === 'edit' ? $project['projResp'] : '';
        $projNote = $act === 'edit' ? $project['projNote'] : '';
    }
?>


<?php $page_title = 'דף מערך' ?>

<?php include ( SHARED_PATH . '/shared_header.php') ?>

<style>
    .table_feild {
        width: 90%;
    }
</style>
<main>





    <?php if ($act === 'edit') { ?>
                                                                                                        <!--        <form  action="project.php?id=<?php echo $id ?>" method ="post">
                                                                                                                    <input type="submit" name="delete" value="מחק מערך">
                                                                                                                </form>-->
        <?php } ?>


    <?php if ($act === 'edit') { ?>
            <h1 class="line" >מערך מספר: <?php echo $id ?> </h1>
            <input class="btn line save_btn" form="proj_data" type="submit" name="edit" value="שמור">
        <?php } else { ?> 
            <h1 class="line" >הוספת מערך</h1>
            <input class="btn line save_btn" form="proj_data" type="submit" name="add" value="הוסף">
        <?php } ?>


    <form id="proj_data"  class="triple-grid-container" action="project.php?id=<?php echo $id ?>" method="post">
        <div class="triple-grid-item">
            <ul>
                <li>
                    <label>
                        <span class='proj_title'>שם המערך</span>
                        <input type='text' id='progName' class='proj_feild' name='projName' value='<?php echo esc_h($name) ?>'>
                    </label>
                </li>
                <li
                    ><label>
                        <span class='proj_title'>שיעור</span>
                        <input type='number' name='projUnit' class='proj_feild' step='1' value='<?php echo esc_h($unit) ?>'>
                    </label>
                </li>
                <li>
                    <label>
                        <span class='proj_title'>תוכנית</span>
                        <select class='proj_feild' name='institute' value=''>
                            <?php write_db_option($institutes, 'instuId', 'instuName', $institute); ?>
                        </select>
                    </label> 
                </li>
                <li>
                    <label>
                        <span class='proj_title'>תוכנית לימודים</span>
                        <select class='proj_feild' name='syllabus' value=''>
                            <?php write_db_option($syllab, 'syllabId', 'syllabName', $syllabus); ?>
                        </select>
                    </label>
                </li>
                <li>
                    <label>
                        <span class='proj_title'>מתאריך</span>
                        <input type='date' class='proj_feild' name='fromDate' value='<?php echo date_format(date_create($fromDate), 'Y-m-d') ?>'>
                    </label>
                </li>
            </ul>
        </div>
        <div class="triple-grid-item">
            <ul>
                <li>    
                    <label>
                        <span class='proj_title'>תאריך סיום</span>
                        <input type='date' class='proj_feild' name='deadline' value='<?php echo date_format(date_create($deadline), 'Y-m-d') ?>' >
                    </label>
                </li>


                <!-- <li>
 
                     <label>
                         <span class='proj_title'>שלב</span>
                         <select class='proj_feild' name='phase' >
                <?php write_db_option($phases, 'phaseId', 'phaseName', $pahse); ?>
                         </select>
                     </label> 
                 </li>    -->
                <!--</div>-->
                <!--<div class="grid-item">-->
                <li>
                    <label>
                        <span class='proj_title'>כותב</span>
                        <input type='text' class='proj_feild' name='projWriter' value='<?php echo esc_h($projWriter) ?>'>
                    </label>
                </li>
                <li>

                    <label>
                        <span class='proj_title'>רכז תוכן</span>
                        <input type='text' class='proj_feild' name='projResp' value='<?php echo esc_h($projResp) ?>'>
                    </label>
                </li>
                <li>

                    <label>
                        <span class='proj_title'>הערות</span>
                        <textarea class='proj_feild' name='projNote' rows="4" cols='30'><?php echo esc_h($projNote) ?></textarea>
                    </label>
                </li>
            </ul>
        </div>
        <!--                <div class="grid-item">-->

        <!--</div>-->
    </form>
    <hr>
    <?php if ($act != 'add') { ?>
            <form action="project.php?act=edit&id=<?php echo $id ?>" method="post">   
                <table id="prods_table">
                    <caption><h2>רשימת עזרים</h2></caption>
                    <thead>
                        <tr>
                            <th><a href="project.php?act=edit&id=<?php echo $id ?>&col=prodId&order=<?php order_dir($col, 'prodId', $order) ?>">מזהה</a></th>
                            <th><a href="project.php?act=edit&id=<?php echo $id ?>&col=prodName&order=<?php order_dir($col, 'prodName', $order) ?>">שם<br>העזר</a></th>
                            <th><a href="project.php?act=edit&id=<?php echo $id ?>&col=prodsTypeName&order=<?php order_dir($col, 'prodsTypeName', $order) ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;סוג&nbsp;&nbsp;&nbsp;&nbsp;</a></th>
                            <th>גודל</th>                
                            <th>סוג<br>נייר</th>
                            <th><a href="project.php?act=edit&id=<?php echo $id ?>&col=colourful&order=<?php order_dir($col, 'colourful', $order) ?>">צבעוני</a></th>
                            <th>דו<br>צדדי</th>
                            <th>חיתוך</th>
                            <th>כמות</th>                
                            <th>הסבר<br>לכמות</th>
                            <th>הערות</th>
                            <!--<th>הפניה<br>לקובץ</th>-->                
                            <th><a href="project.php?act=edit&id=<?php echo $id ?>&col=deadline&order=<?php order_dir($col, 'deadline', $order) ?>">תאריך<br>סיום<br>למערך</a></th>
                            <th>ימים<br>לסיום<br>המערך</th>
                            <!--<th>אחראי</th>-->
                            <!--<th>קובץ</th>-->
                            <th><a href="project.php?act=edit&id=<?php echo $id ?>&col=phaseName&order=<?php order_dir($col, 'phaseName', $order) ?>">שלב</a></th>
                            <th>מועד<br>סיום<br>השלב</th>
            <!--                                    <th>ימים לסיום<br>השלב</th>-->
                            <th>ימים לסיום<br>היצור</th>
                            <th><a href="project.php?act=edit&id=<?php echo $id ?>&col=freedom&order=<?php order_dir($col, 'freedom', $order) ?>">חופש</a></th>
                            <th>פעולה</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($product = mysqli_fetch_assoc($products_set)) { ?>
                            <tr>
                                <td><a href='product.php?act=edit&id=<?php echo esc_u($product['prodId']) ?>'><?php echo $product['prodId'] ?> </a></td>
                                <td><?php echo esc_h($product['prodName']) ?></td>
                                <td><?php echo esc_h($product['prodsTypeName']) ?></td>
                                <td><?php echo esc_h($product['dimensions']) ?></td>
                                <td><?php echo $product['paperType'] ?></td>
                                <td><?php echo draw_bool($product['colourful']) ?></td>
                                <td><?php echo draw_bool($product['bilateral']) ?></td>
                                <td><?php echo draw_bool($product['cut']) ?></td>
                                <td><?php echo $product['quan'] ?></td>
                                <td><?php echo $product['quanDesc'] ?></td>
                                <td><?php echo $product['prodNote'] ?></td>
                                <!--<td><?php echo $product['link'] ?></td>-->
                                <td><?php date_2_screen($product['deadline']) ?></td>
                                <td  <?php is_neg($product['daysToDealine']) ?>>
                                    <?php echo $product['daysToDealine'] ?> </td>
                                <td><?php echo $product['phaseName'] ?></td>
                                <td><?php date_2_screen($product['phaseDateEnd']) ?></td>
                <!--                                        <td <?php is_neg($product['daysToEndPhase']) ?>>
                                <?php echo $product['daysToEndPhase']; ?></td>-->
                                <td <?php is_neg($product['remainJobDays']) ?>>
                                    <?php echo $product['remainJobDays']; ?></td>
                                <td <?php freedom_stat($product['freedom']) ?> >
                                    <?php echo $product['freedom'] ?>
                                </td>
                                <td>
                                    <div tilte="העבר שלב" id="next" value="next" name="next" class="btn" onclick="return confirm_next(<?php echo esc_h($product['prodId']) ?>,<?php echo "'" . esc_h($product['prodName']) . "'" ?>,<?php echo esc_u($product['phase']) ?>)"><i class="fas fa-backward"></i></div>
                                </td>
                            </tr> 
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td><input type="text" class="table_feild" name="prodName" value=""></td>
                            <td>
                                <select class='table_feild' name="type" >
                                    <?php write_db_option($prodsType, 'prodsTypeId', 'prodsTypeName', ''); ?>
                                </select></td>
                            </td>
                            <td><input type="text" class="table_feild" name="paperType" value=""></td>
                            <td>
                                <select class='table_feild' name="size" >
                                    <?php write_db_option($sizes, 'sizeId', 'dimensions', ''); ?>
                                </select></td>
                            </td>
                            <td>
                                <input type="hidden" class="myCheckbox" name="colourful" value="0" />
                                <input type="checkbox" class="" name="colourful" value="1">
                            </td>
                            <td>
                                <input type="hidden" class="" name="bilateral" value="0">
                                <input type="checkbox" class="" name="bilateral" value="1">
                            </td>
                            <td>
                                <input type="hidden" class="" name="cut" value="0">
                                <input type="checkbox" class="" name="cut" value="1">
                            </td>
                            <td><input type="number" class="table_feild" name="quan" value=""></td>
                            <td><input type="text" class="table_feild" name='quanDesc' value=""></td>
                            <td><input type="text" class="table_feild"   name='prodNote' value=""></td>
                            <td><?php date_2_screen($deadline) ?></td>
                            <td  >                         </td>
                            <td>
                                <select class="table_feild"   class='' name='phase' >
                                    <?php write_db_option($phases1, 'phaseId', 'phaseName', ''); ?>
                                </select>
                            </td>
                            <td >  <input type="date" class="table_feild"  name='phaseDateEnd' value="<?php echo date('Y-m-d') ?>" ></td>
                            <td >
                            </td>
                            <td  >

                            </td>
                            <td>
                                <button type='submit' name='add_prod' class="btn" value='add_prod' ><i  class="fas fa-plus-circle" ></i></button>
                            </td>

                        </tr>


                    </tfoot>

                </table>
                <input type ='hidden' name='projectId' value="<?php echo $id ?>">
                <input type ='hidden' name='openDate' value="<?php echo date('Y-m-d') ?>">
                <input type ='hidden' name='startPhaseDate' value="<?php echo date('Y-m-d') ?>">
            </form>

            <div id="confirm_back">
                <form action="project.php?act=edit&id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
                    <div id="confirm_next">
                        <div class="next_head">
                            אישור מעבר שלב
                        </div>
                        <input type="hidden" id="next_id" name="nextId" value="">
                        <input type="hidden" id="next_phase" name="nextPhase" value="">
                        <p id="next_msg"></p>
                        <div id="archive_stat">
                            <p>שים לב, מעתה תוצר זה יוצג במסך 'ארכיון' בלבד.</p>
                            <p>קבצים סופיים:</p> 
                            <input type="file" id='prod_files' name="" multiple>
                        </div>
                        <div class="next_foot">
                            <input class="btn" type="submit" name='next' value="אישור">
                            <button class="btn" id="next_cancel" onclick=" return cancel_next()">ביטול</button>
                        </div>
                </form>
            </div>

            <!--
                        <div id="confirm_back">
                            <form action="project.php?act=edit&id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
                                <div id="confirm_next">
                                    <input type="hidden" id="next_id" name="nextId" value="">
                                    <input type="hidden" id="next_phase" name="nextPhase" value="">
                                    <p id="next_msg"></p>
                                    <div id="archive_stat">
                                        <p>שים לב, מעתה עזר זה יוצג במסך 'ארכיון' בלבד.</p>
                                        <p>קבצים סופיים:</p> 
                                        <input type="file" id='prod_files' name="" multiple>
                                        <input type="submit" name='uploaded'>
                                    </div>
                                    <input type="submit" name='next' value="אישור">
                                    <button id="next_cancel" onclick=" return cancel_next()">ביטול</button>
                            </form>
                        </div>-->


            <?php // } else {   ?>
            <!--<dt>אין עזרים תחת מערך זה</dt>-->
        <?php } ?>



</main>
<script>
<?php
    $phases_name = general_auery('phases');
    $phase_dic = mysqli_fetch_all($phases_name);
    echo " var phase_json=" . json_encode($phase_dic) . ";    \n\n";
?>
</script>
<script src="js/next_phase.js<?php echo '?v=' . mt_rand(); ?>"></script>


<script>

</script>  



<?php
    include ( SHARED_PATH . '/shared_footer.php');
    