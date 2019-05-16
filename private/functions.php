

<?php

    //  return absloute path to given page
    function url_for($script_path) {
        if ($script_path[0] != '/') {
            $script_path = '/' . $script_path;
        }
        return WWW_ROOT . $script_path;
    }

    function esc_u($str = '') {
        return urlencode($str);
    }

    function dec_u($str = '') {
        return rawurlencode($str);
    }

    function esc_h($str = "") {
        return htmlspecialchars($str, ENT_QUOTES);
    }
    
    function dsc_h($str= "") {
        return htmlspecialchars_decode($str);
    }
    
    function esc_js($str = "") {
        addcslashes(htmlspecialchars_decode($str));
    }

    function db_escape($db, $data) {
        return mysqli_real_escape_string($db, $data);
    }

    function redirect_to($location) {
        header("Location: " . $location);
        exit;
    }

    // debug php
    function debug($str = 'Im here') {
        echo "<br>debug: " . $str . "<br>";
    }

    // debug sql requst
    function sqlS($sql = '') {
        echo "<br>sql: " . $sql . "<br>";
    }

    // fix and set color for negtive number
    function is_neg($num) {
        echo 'dir="ltr"';
        if ($num < 0) {
            echo 'class="red_alert"';
        }
    }

    // set backgrond color depand the number value
    function freedom_stat($num) {
        echo 'dir="ltr" ';
        if ($num < 0) {
            echo 'class="high"';
        } else if ($num == 0) {
            echo 'class="mid"';
        } else {
            echo 'class="low"';
        }
    }

    // set color to bool val
    function draw_bool($bool) {
        if ($bool) {
            echo '<i class="fas fa-check green_alert"></i>';
        } else {
            echo '<i class="fas fa-times red_alert"></i>';
        }
    }

    // set date to screen
    function date_2_screen($date) {
        $S_date = date_format(date_create($date), 'd/m/y');
        echo $S_date;
    }

    // set date tp html input
    function date_2_input($date) {
        $S_date = date_format(date_create($date), 'Y-m-d');
        echo $S_date;
    }

    // set order direction for table: ASC / DESC
    function order_dir($old_col, $col, $old_order) {
        if (($old_col == $col)) {
            if ($old_order == 'ASC') {
                echo 'DESC';
            } else {
                echo 'ASC';
            }
        } else {
            echo 'ASC';
        }
    }

    // this function handle uploads of file to 'uploeds_files' dir
    function upload_files($id) {
        $prod = 'prod_file_' . $id;
        $dir_name = "uploads_files/" . $prod;
//        debug();
//        echo '<pre>' . print_r($_FILES) . '</pre>';
        // check if has suit dir
        if (!empty($_FILES[$prod]['name'][0])) {
            if (!is_dir($dir_name)) {
                mkdir($dir_name);
            }
//                $uploeded = array();
            // upload each file with uniqe name
            foreach ($_FILES[$prod]['name'] as $position => $file_name) {
                // preper details
                $tmp_name = $_FILES[$prod]['tmp_name'][$position];
                $uploaded_file_name = $_FILES[$prod]['name'][$position];
                $save_date = date("mdy-Hms");
                $new_file_name = $dir_name . "/" . $save_date . SEPARATOR . $uploaded_file_name;

                //upload:
                if (move_uploaded_file($tmp_name, $new_file_name)) {
                    $msg = "file uploaded/n";
//                        $uploaded[$save_date . "_" . $uploaded_file_name] = $uploaded_file_name .' הועלה בהצלחה.' ;
                } else {
                    $msg = "something went wrong/n";
                }
            }
        }
    }

    function echo_type($type) {
        switch ($type) {
            case 'int':
                return 'number';
            case 'varchar':
                return;
                'text';
            case 'tinyint':
                return 'checkbox';
        }
    }

    function alert_date($phaseDateEnd) {
        $curdate = date("Y-m-d");
        $endPhase = date_format(date_create($phaseDateEnd), "Y-m-d");
//        echo $curdate;
//        echo '<br>';
//        echo $endPhase;
        if ($curdate >= $endPhase) {
            echo "red_alert";
        }
    }

    function sendMail($id, $nextPhase) {
        $phases = general_auery('phases');
        $p = mysqli_fetch_all($phases, MYSQLI_BOTH);
        $phase_name = $p[$nextPhase - 1][1];
        
        $users = general_auery('users');
        
        
//        $to = 'ndomovich@gmail.com';
        $sbj = 'עדכון מעבר שלב';
        $msg = '<html lg="he"><body dir="RTL"> <h1>עדכון מעבר שלב</h1>';
        $msg .= 'עזר מספר ' . $id . ' עבר לשלב ' . $phase_name;
        
        $msg.="</body></html>";

        $headers = "From: info@mehilta.co.il" . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        while ($user = mysqli_fetch_assoc($users)) {
            $to = $user['userMail'];
            $m=mail($to,$sbj,$msg,$headers);
        }
        

        
    }
    