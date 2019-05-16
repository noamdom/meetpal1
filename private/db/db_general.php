
<?php

    function general_delete($table, $id) {
        global $db;
        $sql = "DELETE FROM $table ";
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
        $sql .= "LIMIT 1";
        echo "sql: " . $sql;
        $result = mysqli_query($db, $sql);
        finish_CRUD($result, 'all-projects.php');
//    if ($result) {
//        header("location: all-projects.php");
//        exit;
//    } else {
//        // delete failed
//        echo mysqli_error($db);
//        db_disconnect($db);
//        exit;
//    }
    }

    function finish_CRUD($result, $target) {
        global $db;
        if ($result) {
//        $new_id = mysqli_insert_id(db);
            header("location: $target");
            exit;
        } else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function sql2screen($db, $sql, $title) {
        $lines = mysqli_query($db, $sql);

        $tblH = true;     //flag for table header 
        $str = "";        //table string

        if (is_null($lines) OR ! $lines) {
            echo "ERROR - שגיאה, נא דווח";
        } elseif (mysqli_num_rows($lines) == 0) {
            echo "<h1> אין שורות מתאימות לחיפוש המבוקש</h1>";
        } else {
            while ($line = mysqli_fetch_assoc($lines)) {
                if ($tblH) {            //set keys as table headers
                    $str .= '<table ID="lines_table"> <thead>  <tr>';
                    $i = 0;
                    foreach ($line as $key => $value) {
                        $str .= "<th >" . $key . "</th>";
                    }
                    $str .= "<th >פעולה</th>";
                    $str .= "</tr></thead><tbody>";
                    $tblH = FALSE;
                }

                $str .= "<tr>";
                foreach ($line as $key => $value) {
                    $str .= "<td >" . $value . "</td>";
                }
                $str .= "<td ><a href='" . $title . ".php?id=" . $line['id'] . "&act=edit'>edit</a></td>";
                $str .= "</tr>";
            }
            echo $str;
            echo "</tbody>";


            echo "</table> ";
        }
    }

    function sql2screen2($db, $sql, $title) {
//        $table_data = types_query($title);
        $lines = mysqli_query($db, $sql);

        $tblH = true;     //flag for table header 
        $str = "";        //table string

        if (is_null($lines) OR ! $lines) {
            echo "ERROR - שגיאה, נא דווח";
        } elseif (mysqli_num_rows($lines) == 0) {
            echo "<h1> אין שורות מתאימות לחיפוש המבוקש</h1>";
        } else {
            while ($line = mysqli_fetch_assoc($lines)) {
                if ($tblH) {            //set keys as table headers
                    $str .= '<table ID="lines_table"> <thead>  <tr>';
                    foreach ($line as $key => $value) {
                        $str .= "<th >" . $key . "</th>";
                    }
                    $str .= "<th >פעולה</th>";
                    $str .= "</tr></thead><tbody>";
                    $tblH = FALSE;
                }

                $str .= "<tr>";
                foreach ($line as $key => $value) {
                    $str .= "<td >" . $value . "</td>";
                }
                $str .= "<td ><a href='" . $title . ".php?id=" . $line['id'] . "&act=edit'>edit</a></td>";
                $str .= "</tr>";
            }
            echo $str;
            echo "</tbody>";


            echo "</table> ";
        }
    }

    //AMI Turns $all_options input into list of HTML <option ..> tags
    function write_db_option($all_options, $val_title, $val2screen, $selected_val) {
        while ($option = mysqli_fetch_assoc($all_options)) {
//        echo $selected_val;
//        print_r($option);
//        if ($option['active'] == 1) {
            $h_option = "<option value='" . $option[$val_title] . "' ";
            if ($selected_val === $option[$val_title]) {
                $h_option .= " selected ";
            }
            $h_option .= ">" . $option[$val2screen] . "</option>";
            echo $h_option;
//        }
        }
    }

    /** ------------- general queary - edit tables ------------- * */
    function general_edit_table() {
        global $db;
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';

        $sql = "UPDATE " . $_POST['table'] . " SET ";
        foreach ($_POST as $key => $value) {
            if (substr($key, -2) == 'Id') {
                $line_id_name = $key;
                continue;
            } else if ($key == 'table' || $key == 'save_line') {
                continue;
            }
            $sql .= $key . "='" . db_escape($db, $value) . "', ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE " . $_POST['table'] . "." . $line_id_name . "=" . $_POST[$line_id_name] . " LIMIT 1";
        echo $sql;


        $msg = "נשמרו שינויים בשורה " . $_POST[$line_id_name] . " בטבלת " . $_POST['table'];
        $_SESSION['msg'] = $msg;
        $result = mysqli_query($db, $sql);
        finish_CRUD($result, 'update-options.php');
    }
    
    function general_add_to_table(){
         global $db;
         echo '<pre>';
            print_r($_POST);
            echo '</pre>';

            $sql = "INSERT INTO " . $_POST['table'] . " (";
            foreach ($_POST as $key => $value) {
                if ($key == 'table' || $key == 'add_line') {
                    continue;
                }
                $sql .= $key . ", ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ") VALUES (";
            foreach ($_POST as $key => $value) {
                if ($key == 'table' || $key == 'add_line') {
                    continue;
                }
                $sql .= "'" . db_escape($db,$value) . "', ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ")";
            echo $sql;
            $msg = "השורה נוספתה בהצלחה, לטבלת " . $_POST['table'];
            $_SESSION['msg'] = $msg;
            $result = mysqli_query($db, $sql);
            finish_CRUD($result, 'update-options.php');
    }
    
    
    function general_delete_line(){
        global $db;
        echo '<pre>';
            print_r($_POST);
            echo '</pre>';

            $sql = "DELETE FROM " . $_POST['del_table'] . " WHERE ";
            $sql .= $_POST['del_table'] . "." . $_POST['del_id_name'] . "=" . $_POST['del_id'];
            $sql .= " LIMIT 1 ";
            echo $sql;
            $msg = "שורה " . $_POST['del_id'] . " נמחקה בהצלחה מטבלת " . $_POST['del_table'];
            $_SESSION['msg'] = $msg;
            $result = mysqli_query($db, $sql);
            finish_CRUD($result, 'update-options.php');
    }
    