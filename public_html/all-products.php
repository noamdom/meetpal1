<?php
    require_once('../private/init.php');

    $col = isset($_GET['col']) ? $_GET['col'] : 'freedom';
    $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';


    $user_id = $_SESSION['user_id'];
    $tr_id = isset($_SESSION['tr_id']) ? $_SESSION['tr_id'] : -1;
    unset($_SESSION['tr_id']);

    $msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
    unset($_SESSION['msg']);


    esc_h($col);
    esc_h($order);

    $phases = general_auery('phases');
    $phase_dic = mysqli_fetch_all($phases);

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $search_val = isset($_COOKIE["c_search"]) ? $_COOKIE["c_search"] : '';
        $user = user_by_id($user_id);
        $permission = user_permission($user['userType']);
        $products = all_prods_query1($col, $order, $permission);
        $instues = general_auery('institutes');
        //$phases = general_auery('phases');
        $prodsType = general_auery('prodsType');
        $sizes = general_auery('sizes');


//                Array();
//        while ($p = mysqli_fetch_assoc($phases)) {
//            echo "----";
//            echo $p['phaseId'];
//            $phase_dic[$p['phaseId']] = $p['phaseName'];
//        }
//        print_r($phase_dic);
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['next']) {
            insert_new_act_record($act_dic['next_rec'], $_POST['nextId']); // it's saperated from update sql query for small changes
            $url = 'all-products.php';
            $_SESSION['tr_id'] = $_POST['nextId'];

            // mail:
            sendMail($_POST['nextId'], $_POST['nextPhase']);
            // 
            // archive issue
            if ($_POST['nextPhase'] == MAX_PHASE_VAL) {
                upload_files($_POST['nextId']);
            }



            // next phase:
            $d = $phase_dic[$_POST['nextId']][3];
            update_premote_phase($_POST['nextId'], $_POST['nextPhase'], $url, $d); //$phase_dic[$_POST['nextPhase']]['during']);
            $a1 = $_POST;
//
        }
    }
?>
<?php $page_title = 'ריכוז עזרים'; ?>
<?php include SHARED_PATH . '/shared_header.php' ?>

<main>
    <div class="tools">
        <input type="text" id="searchLine" placeholder="שם עזר או מספר מזהה.." title="Type in a name" value="<?php echo $search_val ?>">
        <button class="btn line" id="open_filter">סינון&nbsp<i class="fa fa-caret-down"></i></button>
        <div id="con_filter_table" >  
            <table id="prog_filter_table">
                <!--<caption><h2>חיפוש מתקדם</h2></caption>-->
                <thead>
                    <tr>
                        <!--<th>עזר</th>-->
                        <th>מערך</th>
                        <th>תוכנית</th>
                        <th>סוג</th>
                        <th>גודל</th>                
                        <th>שלב</th>
                        <th>תאריך<br>סיום<br>למערך</th>
                        <th>ימים<br>לסיום<br>מהערך</th>
                        <th>חופש</th>
                        <th>פעולה</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>
                            <select id="projs_fil" style="width:100%" class="filter_select" name="states0[]" multiple="multiple">
                                <?php write_db_option($projects, 'projId', 'projName', ''); ?>
                            </select>
                        </td>
                        <td>
                            <select id="instu_fil" style="width:100%" name="states4[]" multiple="multiple">
                                <?php write_db_option($instues, 'instuId', 'instuName', ''); ?>
                            </select>
                        </td>

                        <td>
                            <select id="prodsType_fil" style="width:100%" name="states1[]" multiple="multiple">
                                <?php write_db_option($prodsType, 'prodsTypeId', 'prodsTypeName', ''); ?>
                            </select>
                        </td>
                        <td>
                            <select id="sizes_fil" style="width:100%" name="states2[]" multiple="multiple">
                                <?php write_db_option($sizes, 'sizeId', 'dimensions', ''); ?>
                            </select>
                        </td>
                        <td>
                            <select id="phases_fil" style="width:100%" name="states3[]" multiple="multiple">
                                <?php write_db_option($phases, 'phaseId', 'phaseName', ''); ?>
                            </select>
                        </td>
                        <td class="sml_td">
                            <div class="date_fil_con">
                                מ&nbsp:&nbsp<input class="date_input" type="date" id="from_date_end_proj"  value="">
                                <br>
                                עד:&nbsp<input class="date_input" type="date" id="to_date_end_proj"  value="">
                            </div>
                        </td>
                        <td class="tiny_td">
                            <div class="date_fil_con">
                                מ&nbsp:&nbsp<input class="date_input" type="number" id="min_day_end_proj"  value="">
                                <br>
                                עד:&nbsp<input class="date_input" type="number" id="max_day_end_proj"  value="">
                            </div>
                        </td>
                        <td class="tiny_td">
                            <div class="date_fil_con">
                                מ&nbsp:&nbsp<input class="date_input" type="number" id="min_freedom"  value="">
                                <br>
                                עד:&nbsp<input class="date_input" type="number" id="max_freedom"  value="">
                            </div>
                        </td>
                        <td class="tiny_td">
                            <button class="btn" id="filter_btn" >חיפוש</button>
                        </td>
                    </tr>

                </tbody>

            </table>
        </div>
    </div>

    <table id="prods_table" style="width: 100%;">
        <caption><h2>ריכוז עזרים</h2></caption>
        <thead >
            <tr>
                <th><a href="all-products.php?col=prodId&order=<?php order_dir($col, 'prodId', $order) ?>">מזהה</a></th>
                <th><a href="all-products.php?col=projName&order=<?php order_dir($col, 'projName', $order) ?>">מערך</a></th>
                <th><a href="all-products.php?col=prodName&order=<?php order_dir($col, 'prodName', $order) ?>">שם העזר</a></th>
                <th>תוכנית</th>
                <th><a href="all-products.php?col=prodsTypeName&order=<?php order_dir($col, 'prodsTypeName', $order) ?>">סוג</a></th>
<!--                <th>סוג</th>-->
                <th>תאריך<br>פתיחה</th>
                <th>גודל</th>                
                <th>סוג<br>נייר</th>
                <th>צבעוני</th>
                <th>דו<br>צדדי</th>
                <th>חיתוך</th>
                <th>כמות</th>                
                <th>הסבר<br>לכמות</th>
                <th>הערות</th>
                <!--<th>הפניה<br>לקובץ</th>-->                
                <th>תאריך<br>סיום<br>למערך</th>
                <th>ימים<br>לסיום<br>המערך</th>
                <!--<th>אחראי</th>-->
                <!--<th>קובץ</th>-->
                <th><a href="all-products.php?col=phaseName&order=<?php order_dir($col, 'phaseName', $order) ?>">שלב</a></th>
                <th>תאריך<br>תחילת<br>שלב</th>
                <th>מועד<br>סיום<br>השלב</th>
                <!--<th>ימים לסיום<br>השלב</th>-->
                <!--<th>ימים לסיום<br>היצור</th>-->
                <th><a href="all-products.php?col=freedom&order=<?php order_dir($col, 'freedom', $order) ?>">חופש</a></th>
                <th>פעולה</th>
            </tr>

        </thead>
        <tbody>
            <?php
                while ($product = mysqli_fetch_assoc($products)) {
                    //   if($product['phase']==12) {$product['freedom']=0;} 
                    ?>
                    <tr>
                        <td id="p__<?php echo esc_h($product['prodId']) ?>"><a href='product.php?act=edit&id=<?php echo esc_u($product['prodId']) ?>'><?php echo esc_h($product['prodId']) ?> </a></td>
                        <td><a href='project.php?act=edit&id=<?php echo esc_h($product['projId']) ?>'><?php echo esc_h($product['projName']) ?> </a></td>
                        <td><?php echo esc_h($product['prodName']) ?></td>
                        <td><?php echo esc_h($product['instuName']) ?></td>
                        <td><?php echo esc_h($product['prodsTypeName']) ?></td>
                        <td><?php date_2_screen($product['openDate']) ?></td>
                        <td><?php echo esc_h($product['dimensions']) ?></td>
                        <td><?php echo $product['paperType'] ?></td>
                        <td><?php echo draw_bool($product['colourful']) ?></td>
                        <td><?php echo draw_bool($product['bilateral']) ?></td>
                        <td><?php echo draw_bool($product['cut']) ?></td>
                        <td><?php echo esc_h($product['quan']) ?></td>
                        <td><?php echo esc_h($product['quanDesc']) ?></td>
                        <td><?php echo esc_h($product['prodNote']) ?></td>   
                        <td><?php date_2_screen($product['deadline']) ?></td>
                        <td  <?php is_neg($product['daysToDealine']) ?>>
                            <?php echo $product['daysToDealine'] ?> </td>
                        <td><?php echo esc_h($product['phaseName']) ?></td>
                        <td><?php date_2_screen($product['startPhaseDate']) ?> </td>
                        <td><?php date_2_screen($product['phaseDateEnd']) ?></td>

                        <td <?php freedom_stat($product['freedom']) ?> >
                            <?php echo $product['freedom'] ?>
                        </td>
                        <td>
                            <button title='העבר שלב' class="btn" onclick="return confirm_next(<?php echo esc_h($product['prodId']) . " ,' " . esc_h(json_encode($product['prodName'], JSON_HEX_APOS)) . " ', " . esc_h($product['phase']) ?>)"><i class="fas fa-backward"></i></button>
                        </td>   
                    </tr> 

                <?php } ?>
        </tbody>
        <tfoot>

        </tfoot>

    </table>



    <div id="confirm_back">
        <form id="next_form" action="all-products.php" method="post" enctype="multipart/form-data">
            <div id="confirm_next">
                <div class="next_head">
                    אישור מעבר שלב
                </div>
                <input type="hidden" id="next_id" name="nextId" value="">
                <input type="hidden" id="next_phase" name="nextPhase" value="">
                <p id="next_msg"></p>
                <div id="archive_stat">
                    <p>שים לב, מעתה עזר זה יוצג במסך 'ארכיון' בלבד.</p>
                    <p>קבצים סופיים:</p> 
                    <input type="file" id='prod_files' name="" multiple>
                </div>
                <div class="next_foot">
                    <input class="btn" type="submit" name='next' value="אישור">
                    <button class="btn" id="next_cancel" onclick=" return cancel_next()">ביטול</button>
                </div>
        </form>
    </div>

    <!--    <div id="sss">
            dddd
        </div>-->


</div>

</main>
<script>
<?php
    //  $phases_name = general_auery('phases');
    //  $phase_dic = mysqli_fetch_all($phases_name);    // *AMI       Moved up in the page for previuse use.
    echo " var phase_json=" . json_encode($phase_dic) . ";    \n\n";   //*AMI seems like this variable has no use in the following js
    echo "var tr_id = " . $tr_id . "; \n";
?>
</script>
<script src="js/shared_js.js<?php echo '?v=' . mt_rand(); ?>"></script>
<script src="js/serach_and_fiilters.js<?php echo '?v=' . mt_rand(); ?>"></script>
<script src="js/next_phase.js<?php echo '?v=' . mt_rand(); ?>"></script>

<script>
    /**------- Contants ------------ */


    /**------- Functions ------------ */

// filter the table 
    function filter_table_prods() {
        var input, filter, table, tr, td, i, j, flag;
        let proj_f = true, instu_f = true, size_f = true, type_f = true, phase_f = true, end_d = true, end_days = true, freedom_f = true;

        search_line.value = "";
        table = document.getElementById("prods_table");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");

            proj_f = filter_col(td, 1, '#projs_fil');
            instu_f = filter_col(td, 3, '#instu_fil');
            type_f = filter_col(td, 4, '#prodsType_fil');
            size_f = filter_col(td, 6, '#sizes_fil');
            end_d = date_filter(td, 14, 'from_date_end_proj', 'to_date_end_proj');
            end_days = numbers_filter(td, 15, 'min_day_end_proj', 'max_day_end_proj');
            phase_f = filter_col(td, 16, '#phases_fil');
            freedom_f = numbers_filter(td, 19, 'min_freedom', 'max_freedom');


            if (type_f == false || instu_f == false || phase_f == false || proj_f == false || size_f == false || end_d == false || end_days == false || freedom_f == false) { // has no match
                tr[i].style.display = "none";
            } else {
                tr[i].style.display = "";
            }
        }
    }






    /**------- Events: ------------ */

    search_line.addEventListener('keyup', function () {
        search_name_or_id("prods_table", 2, 0);
    }, false);

    filter_btn.addEventListener('click', function () {
        filter_table_prods();
    });


    open_filter.addEventListener('click', function () {
        //clear search line
        search_line.value = "";
        search("prods_table", 2);

        //open filters table
        prog_filter_view();
    }, false);


    window.onload = function () {
//        search("prods_table", 2);
        if (tr_id >= 0) {
            let jump_to = document.getElementById("p__" + tr_id);
            jump_to.scrollIntoView(false);
        }
    };

    $(document).ready(function () {
        links_arr[0].className += " link_active";
        $("#instu_fil").select2();
        $("#projs_fil").select2();
        $("#sizes_fil").select2();
        $("#prodsType_fil").select2();
        $("#phases_fil").select2();
    }
    );



</script>

<?php mysqli_free_result($products); ?>


<?php
    include SHARED_PATH . '/shared_footer.php';
    