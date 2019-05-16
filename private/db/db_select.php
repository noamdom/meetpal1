<?php

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    function porgects_query() {
        global $db;
        $sql = "SELECT * FROM projects ";
        $sql .= "FROM projects LFFT JOIN phases ";
        $sql .= "ON projects.phase=phases.id ";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function general_auery($table) {
        global $db;
        $sql = "SELECT * FROM $table ";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function general_id_query($table, $line) {
        global $db;
        $sql = "SELECT * FROM $table ";
        $sql .= "WHERE projId='" . db_escape($db, $line) . "'";
//    echo "sql: " . $sql . "<br>";
        $result = mysqli_query($db, $sql);
//    print_r($result);
        confirm_result_set($result);
//    debug();
        $project = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $project;
    }

    // return all products except archive phase by premission
    function all_prods_query1($col, $order, $permission) {
        global $db;

        $sql = "SELECT `prodId`, projects.projId, projects.projName , prodsType.prodsTypeName ,
            prodName, openDate, sizes.dimensions, colourful, paperType, bilateral, cut , quan, 
            phase , quanDesc , projects.deadline  , 
            phases.phaseId,  phases.toEnd, phases.during, phases.phaseName,
            startPhaseDate, prodNote, phaseDateEnd,
            
     /*       least( DATE_ADD(`startPhaseDate`, INTERVAL phases.during DAY) , 
                    DATE_ADD(CURRENT_DATE, INTERVAL -1 DAY)) as startPhaseDate, */
                  
                    
            greatest( DATE_ADD(`phaseDateEnd`, INTERVAL phases.during DAY) ,  
                    DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)) as phaseDateEnd2, 
                    
            DATEDIFF(deadline , CURDATE()) AS daysToDealine, 
            
            DATEDIFF(greatest( DATE_ADD(`phaseDateEnd`, INTERVAL phases.during DAY) , 
                    DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)) , CURDATE()) AS daysToEndPhase, 
                    
            DATEDIFF(greatest( DATE_ADD(`phaseDateEnd`, INTERVAL phases.during DAY) , 
                    DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)) , CURDATE()) + phases.toEnd As remainJobDays,
                    
            if(phase<12,DATEDIFF(deadline,DATE_ADD(GREATEST(phaseDateEnd,DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)),
            INTERVAL phases.end2end DAY)),0) AS freedom ,
            
                      institutes.instuId, institutes.instuName
                          FROM `prods` 
                           LEFT JOIN projects ON projectId=projects.projId 
                          LEFT JOIN prodsType on type=prodsType.prodsTypeId 
                           LEFT JOIN sizes ON size=sizes.sizeId 
                           LEFT JOIN institutes ON projects.institute=instuId                                                   
                         LEFT JOIN resp ON resp = resp.RespID 
                 
                          LEFT JOIN phases ON phase = phases.phaseId "
                . "           WHERE phase != " . MAX_PHASE_VAL . " AND phase BETWEEN " . $permission['fromPhase'] . " AND " . $permission['toPhase'] . " AND DATE_ADD(prods.startPhaseDate, INTERVAL phases.during DAY) \n"
                . "           ORDER BY " . $col . " " . $order . "\n";


        $products = mysqli_query($db, $sql);
        confirm_result_set($products);
        return $products;
    }

    function prods_by_project($projectId, $col, $order) {
        global $db;
        $sql = "     SELECT `prodId`, projects.projId, projects.projName , prodsType.prodsTypeName , prodName, openDate,"
                . " sizes.dimensions, colourful, paperType, bilateral, cut , quan, phase , quanDesc , projects.deadline  , \n"
                . "     phases.phaseId,  phases.toEnd, phases.during, phases.phaseName,"
                . " startPhaseDate, prodNote,  "
                . "least( DATE_ADD(`startPhaseDate`, INTERVAL phases.during DAY) ,"
                . "  DATE_ADD(CURRENT_DATE, INTERVAL -1 DAY)) as startPhaseDate, \n "

//                . "greatest( DATE_ADD(`phaseDateEnd`, INTERVAL phases.during DAY) ,  DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)) as phaseDateEnd, \n"
                . " phaseDateEnd, \n"
                . " DATEDIFF(deadline , CURDATE()) AS daysToDealine, \n"
                . " DATEDIFF(greatest( DATE_ADD(`phaseDateEnd`, INTERVAL phases.during DAY) ,"
                . "  DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)) , CURDATE()) AS daysToEndPhase, \n"
                . " DATEDIFF(greatest( DATE_ADD(`phaseDateEnd`, INTERVAL phases.during DAY) , "
                . " DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)) , CURDATE()) + phases.toEnd As remainJobDays, \n"
                . " if(phase<12,DATEDIFF(deadline,DATE_ADD(GREATEST(phaseDateEnd,DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)), INTERVAL phases.end2end DAY)),0) AS freedom "
//                . "       DATEDIFF(deadline , CURDATE()) - DATEDIFF(greatest( DATE_ADD(`phaseDateEnd`, INTERVAL phases.during DAY) ,  DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)) , CURDATE()) + phases.toEnd As freedom \n"
                . "          FROM `prods` \n"
                . "           LEFT JOIN projects ON projectId=projects.projId \n"
                . "          LEFT JOIN prodsType on type=prodsType.prodsTypeId \n"
                . "           LEFT JOIN sizes ON size=sizes.sizeId \n"
                . "          LEFT JOIN resp ON resp = resp.RespID \n"
                . "          LEFT JOIN phases ON phase = phases.phaseId \n"
                . "           WHERE phase != " . MAX_PHASE_VAL . " AND DATE_ADD(prods.startPhaseDate, INTERVAL phases.during DAY)  \n"
                . "  AND prods.projectId=" . $projectId
                . "           ORDER BY " . $col . " " . $order . "\n";
        $products = mysqli_query($db, $sql);
        confirm_result_set($products);
        return $products;
    }

    function prods_by_id_query($id) {
        global $db;
        $sql = "     SELECT `prodId`, projects.projId, projects.projName , prodsType.prodsTypeName , prodName, openDate,"
                . " sizes.dimensions, colourful, paperType, bilateral, cut , quan, phase , quanDesc , projects.deadline  , \n"
                . "     phases.phaseId,  phases.toEnd, phases.during, phases.phaseName,"
                . " startPhaseDate, prodNote, "
                . "least( DATE_ADD(`startPhaseDate`, INTERVAL phases.during DAY) , "
                . " DATE_ADD(CURRENT_DATE, INTERVAL -1 DAY)) as startPhaseDate, \n "
                . " phaseDateEnd, \n"
                . "greatest( DATE_ADD(`phaseDateEnd`, INTERVAL phases.during DAY) , "
                . " DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)) as phaseDateEndToCalc, \n"
                . "       DATEDIFF(deadline , CURDATE()) AS daysToDealine, \n"
                . " DATEDIFF(greatest( DATE_ADD(`phaseDateEnd`, INTERVAL phases.during DAY) ,  "
                . "DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)) , CURDATE()) AS daysToEndPhase, \n"
                . " DATEDIFF(greatest( DATE_ADD(`startPhaseDate`, INTERVAL phases.during DAY) , "
                . " DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)) , CURDATE()) + phases.end2end As remainJobDays, \n"
                . " DATEDIFF(deadline,DATE_ADD(GREATEST(phaseDateEnd,DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)),"
                . "     INTERVAL phases.end2end DAY)) AS freedom \n"
                . "          FROM `prods` \n"
                . "           LEFT JOIN projects ON projectId=projects.projId \n"
                . "          LEFT JOIN prodsType on type=prodsType.prodsTypeId \n"
                . "           LEFT JOIN sizes ON size=sizes.sizeId \n"
                . "          LEFT JOIN resp ON resp = resp.RespID \n"
                . "          LEFT JOIN phases ON phase = phases.phaseId \n"
                . "           WHERE 1 AND prods.prodId=" . $id;

        //  echo $sql;


        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $product = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $product;
    }

    function all_projects_query($col, $order) {
        global $db;


        $sql = "SELECT\n"
                . "    projects.projId,\n"
                . "    projects.projName,\n"
                . "    projects.projUnit,\n"
                . "    projects.syllabus,\n"
                . "    institutes.instuName, \n"
                . "    syllabus.syllabName, \n"
                . "    projects.institute,\n"
                . "    projects.deadline,\n"
                . "    projects.fromDate,\n"
                . "    projects.projWriter,\n"
                . "    projects.projResp,\n"
                . "    projects.projNote,\n"
                . "    ppp.countProds,\n"
                . "    ppp.minFreedom\n"
                . "    \n"
                . "FROM\n"
                . "    projects\n"
                . " LEFT JOIN institutes ON projects.institute = institutes.instuId\n"
                . " LEFT JOIN syllabus on projects.syllabus=syllabus.syllabId\n"
                . " LEFT JOIN(\n"
                . "    SELECT\n"
                . "        projects.projId,\n"
                . "        MIN(if (phase<12,DATEDIFF(deadline,DATE_ADD(GREATEST(phaseDateEnd,DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY))"
                . ",INTERVAL phases.end2end DAY)),0)) AS minFreedom,\n"
                . "    	count(prodId) AS countProds\n"
                . "FROM\n"
                . "    prods\n"
                . "	LEFT JOIN projects ON projectId = projects.projId\n"
                . "    left join phases on prods.phase=phases.phaseId\n"
                . "      WHERE phases.phaseId != 13 "
                . "GROUP BY\n"
                . "    prods.projectId) AS ppp\n"
                . "ON\n"
                . "    projects.projId = ppp.projId"
                . "                    WHERE 1 ORDER BY {$col}  {$order} , projUnit ASC ";
//        sqlS($sql);
        $projects = mysqli_query($db, $sql);
        confirm_result_set($projects);
        return $projects;
    }

    // return all products in archive phase
    function archive_query($col, $order) {
        global $db;
        // note: this quey is same as 'all_prod_qury()' except phases demand. it may change in future
        $sql = "     SELECT `prodId`, projects.projId, projects.projName , prodsType.prodsTypeName , prodName, openDate, sizes.dimensions, colourful, paperType, bilateral, cut , quan, phase , quanDesc , projects.deadline  , \n"
                . "     phases.phaseId,  phases.toEnd, phases.during, phases.phaseName,"
                . " startPhaseDate, prodNote, "
                . "least( DATE_ADD(`startPhaseDate`, INTERVAL phases.during DAY) ,  DATE_ADD(CURRENT_DATE, INTERVAL -1 DAY)) as startPhaseDate, \n "
                . "greatest( DATE_ADD(`phaseDateEnd`, INTERVAL phases.during DAY) ,  DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)) as phaseDateEnd, \n"
                . "       DATEDIFF(deadline , CURDATE()) AS daysToDealine, \n"
                . " DATEDIFF(greatest( DATE_ADD(`phaseDateEnd`, INTERVAL phases.during DAY) ,  DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)) , CURDATE()) AS daysToEndPhase, \n"
                . " DATEDIFF(greatest( DATE_ADD(`phaseDateEnd`, INTERVAL phases.during DAY) ,  DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)) , CURDATE()) + phases.toEnd As remainJobDays, \n"
                . "       DATEDIFF(deadline , CURDATE()) - DATEDIFF(greatest( DATE_ADD(`phaseDateEnd`, INTERVAL phases.during DAY) ,  DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)) , CURDATE()) + phases.toEnd As freedom \n"
                . "          FROM `prods` \n"
                . "           LEFT JOIN projects ON projectId=projects.projId \n"
                . "          LEFT JOIN prodsType on type=prodsType.prodsTypeId \n"
                . "           LEFT JOIN sizes ON size=sizes.sizeId \n"
                . "          LEFT JOIN resp ON resp = resp.RespID \n"
                . "          LEFT JOIN phases ON phase = phases.phaseId \n"
                . "           WHERE phase = " . MAX_PHASE_VAL . " AND DATE_ADD(prods.startPhaseDate, INTERVAL phases.during DAY) \n"
                . "           ORDER BY " . $col . " " . $order . "\n";


        $products = mysqli_query($db, $sql);
        confirm_result_set($products);
        return $products;
    }

    function user_by_username($username) {
        global $db;
        $sql = "SELECT * FROM users ";
        $sql .= "WHERE userLogin='" . db_escape($db, $username) . "'";
//    echo "sql: " . $sql . "<br>";
        $result = mysqli_query($db, $sql);
//    print_r($result);
        confirm_result_set($result);
//    debug();
        $userDet = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $userDet;
    }

    function user_by_id($id) {
        global $db;
        $sql = "SELECT * FROM users ";
        $sql .= "WHERE userId='" . db_escape($db, $id) . "'";
//    echo "sql: " . $sql . "<br>";
        $result = mysqli_query($db, $sql);
//    print_r($result);
        confirm_result_set($result);
//    debug();
        $userDet = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $userDet;
    }

    function user_permission($user_type) {
        global $db;
        $sql = "SELECT toPhase, fromPhase FROM usersType ";
        $sql .= "WHERE userTypeId='" . db_escape($db, $user_type) . "'";
//            echo "sql: " . $sql . "<br>";
        $result = mysqli_query($db, $sql);
//    print_r($result);
        confirm_result_set($result);
//    debug();
        $userPermmission = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $userPermmission;
    }

    function data_query($table, $data) {
        global $db;
        $toSelect = '';

        switch ($data) {
            case 'type':
                $toSelect = 'DATA_TYPE';
                break;
            case 'name':
                $toSelect = 'COLUMN_NAME';
                break;
            case 'comment':
                $toSelect = 'COLUMN_COMMENT';
                break;
        }
//        debug($toSelect);

        $sql = "SELECT\n";
        $sql .= " COLUMN_NAME , DATA_TYPE , COLUMN_COMMENT   \n";
        $sql .= " FROM INFORMATION_SCHEMA.COLUMNS \n";
        $sql .= " WHERE  TABLE_NAME = '{$table}'";
//        sqlS($sql);
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
//        $table_data = mysqli_fetch_assoc($result);
//        mysqli_free_result($result);
//        return $table_data;
        return $result;
    }

    function acts_per_typs() {
        global $db;
        $sql = "SELECT acts_dic.act_name, count(act_id) FROM acts_records \n"
                . "left join acts_dic on acts_dic.act_id = acts_records.actId\n"
                . "group by actId";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function acts_per_user() {
        global $db;
        $sql = "SELECT users.userName , acts_records.userId FROM `acts_records`\n"
                . "left join users on users.userId = acts_records.userId\n"
                . "group by userId";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }
    