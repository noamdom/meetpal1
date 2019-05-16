<?php
    require_once('../private/init.php');





    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $users = general_query('users');
        ob_start();
        $sbj = 'דו"ח עזרים מאחרים';
        include "freedom_reports.php";
        $msg = ob_get_contents();


        $headers = "From: info@mehilta.co.il" . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        while ($user = mysqli_fetch_assoc($users)) {
            if ($user['userMail']) {
                $to = $user['userMail'];
                $m = mail($to, $sbj, $msg, $headers);
            }
        }
        ob_end_clean();
        $msg = '';
    }
?>
<?php $page_title = 'שליחת דוח"ות'; ?>
<?php include SHARED_PATH . '/shared_header.php' ?>

<main>
    <form id="next_form" action="send_reports.php" method="post" enctype="multipart/form-data">
        <input class="btn" type="submit" name='report' value="send">        
    </form>
    <hr>

    <div style="display: inline"
         <div id="piechart_by_act"></div>

        <hr>
        <div id="piechart_by_user"></div>
    </div>

</main>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
<?php
    $acts_count = acts_per_typs();
    $acts_per_type = mysqli_fetch_all($acts_count);
    echo " var acts_per_type_json =" . json_encode($acts_per_type, JSON_NUMERIC_CHECK) . ";    \n\n";

    $user_count = acts_per_user();
    $acts_per_user = mysqli_fetch_all($user_count);
    echo " var acts_per_user_json =" . json_encode($acts_per_user, JSON_NUMERIC_CHECK) . ";    \n\n";
?>
// Load google charts
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart_act);
    google.charts.setOnLoadCallback(drawChart_user);

    var acts_type = [["type", "count"]];
    var acts_user = [["user", "count"]];
    var acts_per_type_gglf = acts_type.concat(acts_per_type_json); // gglf = google_format
    var acts_per_user_gglf = acts_user.concat(acts_per_user_json); // gglf = google_format

// Draw the chart and set the chart values
    function drawChart_act() {
        var data = google.visualization.arrayToDataTable(acts_per_type_gglf);

        // Optional; add a title and set the width and height of the chart
        var options = {'title': 'חלוקת פעולות לפי סוג', 'width': 550, 'height': 400, is3D: true};

        // Display the chart inside the <div> element with id="piechart__by_act"
        var chart = new google.visualization.PieChart(document.getElementById('piechart_by_act'));
        chart.draw(data, options);
    }

    // Draw the chart and set the chart values
    function drawChart_user() {
        var data = google.visualization.arrayToDataTable(acts_per_user_gglf);

        // Optional; add a title and set the width and height of the chart
        var options = {'title': 'חלוקת פעולות לפי משתמשים', 'width': 550, 'height': 400, is3D: true};

        // Display the chart inside the <div> element with id="piechart__by_user"
        var chart = new google.visualization.PieChart(document.getElementById('piechart_by_user'));
        chart.draw(data, options);
    }
</script>





<?php mysqli_free_result($products); ?>


<?php
    include SHARED_PATH . '/shared_footer.php';
    