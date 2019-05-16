<?php
    require_once('../private/init.php');

    $col = isset($_GET['col']) ? $_GET['col'] : 'deadline';
    $order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

    esc_h($col);
    esc_h($order);

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $search_val = isset($_COOKIE["c_search"]) ? $_COOKIE["c_search"] : '';
        $products = archive_query($col, $order);

        $projects = general_auery('projects');
        $prodsType = general_auery('prodsType');
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['uploaded']) {
            $prod_id = $_POST['prod_id'];
            upload_files($prod_id);

            $search_val = isset($_COOKIE["c_search"]) ? $_COOKIE["c_search"] : '';
            $products = archive_query($col, $order);
        }
    }
?>
<?php $page_title = 'ריכוז עזרים'; ?>
<?php include SHARED_PATH . '/shared_header.php' ?>

<main>
    <br>
    <br>
    <br>
    <br>
    <!------------filter and serach --------->
    <input type="text" id="searchLine" placeholder="חפש עזר... " title="Type in a name" value="">
    <button class="btn line" id="open_filter">סינון&nbsp<i class="fa fa-caret-down"></i></button>
    <div id="con_filter_table" >
        <table id="prog_filter_table">
            <thead>
                <tr>
                    <th>מערך</th>
                    <th>סוג</th>
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
                        <select id="prodsType_fil" style="width:100%" name="states1[]" multiple="multiple">
                            <?php write_db_option($prodsType, 'prodsTypeId', 'prodsTypeName', ''); ?>
                        </select>
                    </td>

                    <td class="tiny_td">
                        <button class="btn" id="filter_btn" >חיפוש</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-------------table area------------------->
    <!--    <br>
        <br>
        <br>
        <br>-->
    <table id="archive_table">
        <caption><h2>ארכיון</h2></caption>
        <thead>
            <tr>
                <th><a href="archive.php?col=prodId&order=<?php order_dir($col, 'prodId', $order) ?>">מזהה</a></th>
                <th><a href="archive.php?col=projName&order=<?php order_dir($col, 'projName', $order) ?>">מערך</a></th>
                <th><a href="archive.php?col=prodName&order=<?php order_dir($col, 'prodName', $order) ?>">שם העזר</a></th>
                <th><a href="archive.php?col=prodsTypeName&order=<?php order_dir($col, 'prodsTypeName', $order) ?>">סוג</a></th>
<!--                <th>סוג</th>-->
                <th>גודל</th>                
                <th>סוג<br>נייר</th>
                <th>צבעוני</th>
                <th>דו<br>צדדי</th>
                <th>חיתוך</th>
                <th>כמות</th>                
                <th>הסבר<br>לכמות</th>
                <th>הערות</th>
                <th>קבצים סופיים</th>
                <th>תאריך<br>פתיחה</th>
                <th><a href="archive.php?col=deadline&order=<?php order_dir($col, 'deadline', $order) ?>">תאריך<br>סיום<br>למערך</a></th>
<!--                <th>ימים<br>לסיום<br>המערך</th>-->
                <th><a href="archive.php?col=phaseName&order=<?php order_dir($col, 'phaseName', $order) ?>">שלב</a></th>
                <!--<th><a href="all-products.php?col=freedom&order=<?php order_dir($col, 'freedom', $order) ?>">חופש</a></th>-->
                <th>פעולה</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = mysqli_fetch_assoc($products)) { ?>
                    <tr>
                        <td><a href='product.php?act=edit&id=<?php echo esc_u($product['prodId']) ?>'><?php echo $product['prodId'] ?> </a></td>
                        <td><a href='project.php?act=edit&id=<?php echo esc_u($product['projId']) ?>'><?php echo $product['projName'] ?> </a></td>
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
                        <td> 
                            <?php
                            $allFiles = scandir('uploads_files/prod_file_' . esc_u($product['prodId']));
                            $files = array_diff($allFiles, array('.', '..'));
                            if ($files) {
                                ?>
                                <!--<ul>-->
                                    <?php foreach ($files as $file) {
                                        ?>
                                            <a href="uploads_files/prod_file_<?php echo esc_u($product['prodId']) . '/' . $file ?>" target="_black">
                                                <?php
                                                $file_name = explode(SEPARATOR, $file);
                                                echo $file_name[1];
                                                ?></a>
<!--                                <i class="fas fa-trash-alt" style="float: left; color: rgba(236,123,125,0.7);"></i>-->
                                        <br>
                                    <?php } ?>
                                <!--</ul>-->
                                <hr>
                            <?php } ?>
                            <form action="archive.php" method="post" enctype="multipart/form-data">
                                <input type="hidden"  name="prod_id" value="<?php echo esc_u($product['prodId']) ?>">
                                <input type="file"  name="prod_file_<?php echo esc_u($product['prodId']) ?>[]" multiple>
                                <input class="btn" type="submit" name='uploaded'>
                            </form>
                        </td>
                        <!--<td><?php echo $product['link'] ?></td>-->
                        <td><?php date_2_screen($product['openDate']) ?></td>
                        <td><?php date_2_screen($product['deadline']) ?></td>
        <!--                        <td  <?php is_neg($product['daysToDealine']) ?>>
                        <?php echo $product['daysToDealine'] ?> </td>-->
                        <!--<td><?php echo $product['respName'] ?></td>-->
                        <!--<td><?php echo $product['file2'] ?></td>-->
                        <td><?php echo $product['phaseName'] ?></td>
                        <!--                    date of begin phase-->
        <!--                        <td><?php date_2_screen($product['startPhaseDate']) ?> </td>-->
                        <!--                    dd-->
                        <!--<td><?php date_2_screen($product['phaseDateEnd']) ?></td>-->
        <!--                        <td <?php is_neg($product['daysToEndPhase']) ?>>
                        <?php echo $product['daysToEndPhase']; ?></td>
                        <td <?php is_neg($product['remainJobDays']) ?>>
                        <?php echo $product['remainJobDays']; ?></td>-->
        <!--                        <td <?php freedom_stat($product['freedom']) ?> >
                        <?php echo $product['freedom'] ?>
                        </td>-->
                        <td>
                            <!--<a href="product.php?act=next&id=<?php echo esc_u($product['prodId']) ?>" >העבר שלב</a>-->
                        </td>
                    </tr> 
                <?php } ?>
        </tbody>
        <tfoot>

        </tfoot>

    </table>

</main>
<script src="js/shared_js.js<?php echo '?v=' . mt_rand(); ?>"></script>
<script src="js/serach_and_fiilters.js<?php echo '?v=' . mt_rand(); ?>"></script>
<script>
    /**------- Contants ------------ */


    /**------- Functions ------------ */

    // filter the table 
    function filter_table_projs() {

        var table, tr, td, i, j;
        let projs_fil = true, prodsType_fil = true;

        search_line.value = "";
        table = document.getElementById("archive_table");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");

            instu_f = filter_col(td, 1, '#projs_fil');
            sylab_f = filter_col(td, 3, '#prodsType_fil');

            if (instu_f == false || sylab_f == false) { // has no match
                tr[i].style.display = "none";
            } else {
                tr[i].style.display = "";
            }
        }

    }


    /**------- Events: ------------ */
    search_line.addEventListener('keyup', function () {
        search("archive_table", 1);
    }, false);

    filter_btn.addEventListener('click', function () {
        filter_table_projs();
    });

    open_filter.addEventListener('click', function () {
        //clear search line
        search_line.value = "";
        search("archive_table", 1);

        //open filters table
        prog_filter_view();
    }, false);


    $(document).ready(function () {
        links_arr[2].className += " link_active";

        $("#projs_fil").select2();
        $("#prodsType_fil").select2();
    }
    );

</script>

<?php mysqli_free_result($products); ?>


<?php
    include SHARED_PATH . '/shared_footer.php';
    