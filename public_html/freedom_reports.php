<?php
    require_once('../private/init.php');
    global $db;
    $sql = "SELECT `prodId`, projects.projId, projects.projName , prodsType.prodsTypeName ,
            prodName, openDate, sizes.dimensions, colourful, paperType, bilateral, cut , quan, 
            phase , quanDesc , projects.deadline  , 
            phases.phaseId,  phases.toEnd, phases.during, phases.phaseName,
            startPhaseDate, prodNote, phaseDateEnd,
            
                     
                    
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
            . "           ORDER BY freedom ASC \n";

    $products = mysqli_query($db, $sql);
    confirm_result_set($products);
?>
<!DOCTYPE html>
<html lang="he">
    <head>
        <meta charset="UTF-8">
        <title>דו"ח מצב עזרים <?php echo $page_title; ?></title>
        <style>

            table {
                border-collapse: collapse;
                width: 90%;
                margin-right: 5%;
            }


            table,  td, th {
                border: 1px solid #bbb;
                text-align: center;
            }

            th {
                padding:0.1em;
                background-color: rgb(	166, 182, 234);

            }


            td {
                padding:0.35em;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            .high {
                background-color: rgba(236,123,125,0.7);

            }




        </style>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    </head>
    <body dir="rtl">
        <header>

        </header>
        <main>            
            <table id="prods_table">
                <caption><h2>דו"ח עזרים מאחרים </h2></caption>
                <thead >
                    <tr>
                        <th>מזהה</th>
                        <th>מערך</th>
                        <th>שם העזר</th>
                        <th>תוכנית</th>
                        <th>תאריך<br>סיום<br>למערך</th>
                        <th>חופש</th>                        
                    </tr>

                </thead>
                <tbody>
                    <?php
                        while ($product = mysqli_fetch_assoc($products)) {
                            if ($product['freedom'] < 0) {
                                ?>
                                <tr>
                                    <td><?php echo esc_h($product['prodId']) ?></td>
                                    <td><?php echo esc_h($product['projName']) ?></td>
                                    <td><?php echo esc_h($product['prodName']) ?></td>
                                    <td><?php echo esc_h($product['instuName']) ?></td>
                                    <td><?php date_2_screen($product['deadline']) ?></td>
                                    <td <?php freedom_stat($product['freedom']) ?> ><?php echo $product['freedom'] ?>                                  </td>                                    
                                </tr> 

                                <?php
                            }
                        }
                    ?>
                </tbody>
                <tfoot>

                </tfoot>

            </table>


        </main>

        <footer>
            <!--<p>footer</p>-->
        </footer>

    </body>

</html>


<?php
    db_disconnect($db);
    