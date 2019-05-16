<?php

    function update_project($id) {
        global $db;
        $sql = "UPDATE projects SET ";
        $sql .= "projName='" . db_escape($db,$_POST['projName']) . "', ";
        $sql .= "projUnit='" . $_POST['projUnit'] . "', ";
        $sql .= "syllabus='" . $_POST['syllabus'] . "', ";
        $sql .= "institute='" . $_POST['institute'] . "', ";
        $sql .= "fromDate='" . $_POST['fromDate'] . "', ";
        $sql .= "deadline='" . $_POST['deadline'] . "', ";
        $sql .= "projWriter='" . db_escape($db,$_POST['projWriter']) . "', ";
        $sql .= "projResp='" . db_escape($db,$_POST['projResp']) . "', ";
        $sql .= "projNote='" . db_escape($db,$_POST['projNote']) . "' ";
        $sql .= "WHERE projects.projId='" . db_escape($db, $id) . "' ";
        $sql .= "LIMIT 1";
        echo "sql: " . $sql;
        $result = mysqli_query($db, $sql);
        $url = 'project.php?act=edit&id=' . $id;
        $_SESSION['msg'] = "השינויים נשמרו בהצלחה";
        finish_CRUD($result, $url);
    }

    function update_product($id) {
        global $db;
        $sql = "UPDATE prods SET ";
        $sql .= "prodName='" . db_escape($db,$_POST['prodName']) . "', ";
        $sql .= "projectId='" . $_POST['projectId'] . "', ";
        $sql .= "type='" . $_POST['type'] . "', ";
        $sql .= "size='" . $_POST['size'] . "', ";
        $sql .= "paperType='" . db_escape($db,$_POST['paperType']) . "', ";
        $sql .= "colourful='" . $_POST['colourful'] . "', ";
        $sql .= "bilateral='" . $_POST['bilateral'] . "', ";
        $sql .= "cut='" . $_POST['cut'] . "', ";
        $sql .= "quan='" . $_POST['quan'] . "', ";
        $sql .= "quanDesc='" . db_escape($db,$_POST['quanDesc']) . "', ";
        $sql .= "prodNote='" . db_escape($db,$_POST['prodNote']) . "', ";
        $sql .= "openDate='" . $_POST['openDate'] . "', ";
        $sql .= "phase='" . $_POST['phase'] . "', ";
        $sql .= "startPhaseDate='" . $_POST['startPhaseDate'] . "', ";
        $sql .= "phaseDateEnd='" . $_POST['phaseDateEnd'] . "' ";
        $sql .= "WHERE prods.prodId='" . $id . "' ";
        $sql .= "LIMIT 1 ";
        $result = mysqli_query($db, $sql);
        $url = 'product.php?act=edit&id=' . $id;
        $_SESSION['msg'] = "השינויים נשמרו בהצלחה";
        finish_CRUD($result, $url);
    }

//    function update_phase($id, $phaseName, $startAfter, $during, $toEnd, $description, $phaseNum, $active) {
//        global $db;
//        $sql = "UPDATE phases SET ";
//
//        $sql .= "phaseName='" . $phaseName . "', ";
//        $sql .= "startAfter='" . $startAfter . "', ";
//        $sql .= "during='" . $during . "', ";
//        $sql .= "toEnd='" . $toEnd . "', ";
//        $sql .= "description='" . $description . "', ";
//        $sql .= "phaseNum='" . $phaseNum . "', ";
//        $sql .= "active='" . $active . "' ";
//        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
//        $sql .= "LIMIT 1";
//        echo "<br>sql: " . $sql . "<br>";
//        $result = mysqli_query($db, $sql);
//        if ($result) {
////        $new_id = mysqli_insert_id(db);
//            header("location: update-options.php");
//            exit;
//        } else {
//            echo mysqli_error($db);
//            db_disconnect($db);
//            exit;
//        }
//    }

    function update_syllabus($id, $name, $instu, $active) {
        global $db;
        $sql = "UPDATE syllabus SET ";
        $sql .= "name='" . $name . "', ";
        $sql .= "institute='" . $instu . "', ";
        $sql .= "active='" . $active . "' ";
        debug();
        sqlS($sql);
        $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
        $sql .= "LIMIT 1";
        echo "<br>sql: " . $sql . "<br>";
        $result = mysqli_query($db, $sql);
        finish_CRUD($result, 'update-options.php');
    }

    function update_premote_phase($id, $phase, $target, $duration) {
        global $db;
        $curdate = date("Y-m-d");
        
        $sql = "UPDATE prods SET ";
        $sql .= "phase='" . $phase . "', ";
        $sql .= "startPhaseDate='" . $curdate . "', ";
        $s = isset($duration) ? "+" . $duration . " day" : "+20 day";
        $sql .= "phaseDateEnd='" .  date("Y-m-d",strtotime($s)) . "' ";   // ***AMI This is a patch. needs to add the correct phase length default wich is not available here - without adding a parameter and kill the function declaration
        $sql .= "WHERE prods.prodId='" . $id . "' ";
        $sql .= "LIMIT 1 ";
        $result = mysqli_query($db, $sql);
        $_SESSION['msg'] =  "עזר " . $id . " הועבר שלב בהצלחה.   ";
        
        finish_CRUD($result, $target);
    }
    
    
    