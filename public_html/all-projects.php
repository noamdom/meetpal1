<?php
    require_once('../private/init.php');
    $col = isset($_GET['col']) ? $_GET['col'] : 'minFreedom';
    $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

    esc_h($col);
    esc_h($order);

    $msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
    unset($_SESSION['msg']);

    $projects = all_projects_query($col, $order);
    $institutes = general_auery('institutes');
    $syllabus = general_auery('syllabus');
?>


<?php $page_title = 'ריכוז מערכים' ?>

<?php include '../private/shared/shared_header.php' ?>

<main>
    <input type="text" id="searchLine" placeholder="שם מערך או מספר מזהה.." title="Type in a name" value="">
    <button class="btn line" id="open_filter">סינון&nbsp<i class="fa fa-caret-down"></i></button>
    <div id="con_filter_table" >
        <table id="prog_filter_table">
            <thead>
                <tr>
                    <th>תוכנית</th>
                    <th>שיעור</th>
                    <th>תוכנית לימודים</th>
                    <th>מספר<br>עזרים</th>
                    <th>מועד<br>סיום</th>
                    <th>חופש</th>
                    <th>פעולה</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>
                        <select id="instu_fil" style="width:100%" class="filter_select" name="states0[]" multiple="multiple">
                            <?php write_db_option($institutes, 'instuId', 'instuName', ''); ?>
                        </select>
                    </td>

                    <td class="tiny_td">    
                        <div class="date_fil_con">
                            מ&nbsp:&nbsp<input class="date_input" type="number" id="min_lesson"  value="">
                            <br>
                            עד:&nbsp<input class="date_input" type="number" id="max_lesson"  value="">
                        </div>
                    </td>

                    <td>
                        <select id="syllab_fil" style="width:100%" name="states1[]" multiple="multiple">
                            <?php write_db_option($syllabus, 'syllabId', 'syllabName', ''); ?>
                        </select>
                    </td>
                    
                    <td class="tiny_td">    
                        <div class="date_fil_con">
                            מ&nbsp:&nbsp<input class="date_input" type="number" id="min_prods"  value="">
                            <br>
                            עד:&nbsp<input class="date_input" type="number" id="max_prods"  value="">
                        </div>
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

    <!-------------table area------------------->
    <table id="projs_table">
        <caption><h2>ריכוז מערכים</h2></caption>
        <thead>
            <tr>
                <th><a href="all-projects.php?col=projId&order=<?php order_dir($col, 'projId', $order) ?>">מזהה</a></th>
                <th><a href="all-projects.php?col=projName&order=<?php order_dir($col, 'projName', $order) ?>">שם המערך</a></th>
                <th>שיעור</th>
                <th><a href="all-projects.php?col=instuName&order=<?php order_dir($col, 'instuName', $order) ?>">תוכנית</a></th>
                <th><a href="all-projects.php?col=syllabName&order=<?php order_dir($col, 'syllabName', $order) ?>">תוכנית<br>לימודים</a></th>
                <th><a href="all-projects.php?col=projWriter&order=<?php order_dir($col, 'projWriter', $order) ?>">כותב</a></th>
                <th><a href="all-projects.php?col=projResp&order=<?php order_dir($col, 'projWriter', $order) ?>">רכז תוכן</a></th>
                <th>הערות</th>
                <th>מספר<br>עזרים</th>
                <!--<th>תוצר</th>-->
                <!--<th>אחראי</th>-->
                <th>מתאריך</th>
                <th><a href="all-projects.php?col=deadline&order=<?php order_dir($col, 'deadline', $order) ?>">מועד<br>סיום</a></th>
                <!--<th><a href="all-projects.php?col=DateDiff&order=<?php order_dir($col, 'DateDiff', $order) ?>">ימים<br>לסיום</a></th>-->
               <!--<th>המוצר<br>האחרון</th>-->
                <th>חופש</th>
<!--                        <th>מכאן לסיום</th>                
                        <th>חופש<br>לכמות</th>-->
            </tr>
        </thead>
        <tbody>
            <?php
                while ($proj = mysqli_fetch_assoc($projects)) {
                    $deadline = $proj['deadline'];
                    ?>
                    <tr>
                        <td><a href='project.php?act=edit&id=<?php echo esc_u($proj['projId']) ?>'><?php echo esc_h($proj['projId']) ?> </a></td>
                        <td><?php echo esc_h($proj['projName']) ?></td>
                        <td><?php echo esc_h($proj['projUnit']) ?></td>
                        <td><?php echo esc_h($proj['instuName']) ?></td>
                        <td><?php echo esc_h($proj['syllabName']) ?></td>
                        <td><?php echo esc_h($proj['projWriter']) ?></td>
                        <td><?php echo esc_h($proj['projResp']) ?></td>
                        <td><?php echo esc_h($proj['projNote']) ?></td>
                        <td><?php echo esc_h($proj['countProds']) ?></td>
                        <!--<td><?php echo esc_h($proj['respName']) ?></td>-->
                        <td><?php date_2_screen($proj['fromDate']) ?></td>
                        <td><?php date_2_screen($deadline) ?></td>
        <!--                        <td <?php is_neg($proj['DateDiff']) ?>>
                        <?php echo $proj['DateDiff'] ?>   </td>-->
                        <td <?php freedom_stat($proj['minFreedom']) ?>>
                            <?php echo $proj['minFreedom'] ?>   </td>
                    </tr> 
                <?php } ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>

    <script src="js/shared_js.js<?php echo '?v=' . mt_rand(); ?>"></script>
    <script src="js/serach_and_fiilters.js<?php echo '?v=' . mt_rand(); ?>"></script>
    <script>
        /**------- Contants ------------ */


        /**------- Functions ------------ */

// filter the table 
        function filter_table_projs() {

            var table, tr, td, i, j;
            let instu_f = true, sylab_f = true, f_lesson = true, end_d = true, f_prods = true, freedom_f = true;

            search_line.value = "";
            table = document.getElementById("projs_table");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");

                instu_f = filter_col(td, 3, '#instu_fil');
                f_lesson = numbers_filter(td, 2, 'min_lesson', 'max_lesson');
                sylab_f = filter_col(td, 4, '#syllab_fil');
                f_prods = numbers_filter(td, 8, 'min_prods', 'max_prods');
                end_d = date_filter(td, 10, 'from_date_end_proj', 'to_date_end_proj');
                freedom_f = numbers_filter(td, 11, 'min_freedom', 'max_freedom');

                if (instu_f == false || f_lesson == false || sylab_f == false || !f_prods || end_d == false || freedom_f == false) { // has no match
                    tr[i].style.display = "none";
                } else {
                    tr[i].style.display = "";
                }
            }

        }



        /**------- Events: ------------ */
        search_line.addEventListener('keyup', function () {
        search_name_or_id("projs_table", 1, 0);
    }, false);

        filter_btn.addEventListener('click', function () {
            filter_table_projs();
        });

        open_filter.addEventListener('click', function () {
            //clear search line
            search_line.value = "";
            search("projs_table", 1);

            //open filters table
            prog_filter_view();
        }, false);



        $(document).ready(function () {
            links_arr[1].className += " link_active";

            $("#instu_fil").select2();
            $("#syllab_fil").select2();
        }
        );

    </script>

</main>
<?php include SHARED_PATH . '/shared_footer.php' ?>