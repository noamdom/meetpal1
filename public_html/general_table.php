 <table>
            <?php
                while ($line = mysqli_fetch_assoc($sylbs)) {
                    // get id:
                    $vals = array_values($line);
                    $id = $vals[0];
                    ?>
                    <?php if ($tblH) { ?>
                        <thead>
                            <tr>
                                <?php
                                foreach ($line as $key => $value) {
                                    ?>
                                    <th> <?php echo $data[$key][1] ?> </th>
                                <?php } ?>
                                <th>פעולה</th>
                            </tr>    
                        </thead>
                        <tbody>
                            <?php
                            $tblH = false;
                        }
                        ?>
                        <tr id="<?php echo $table . "_" . $id ?>">
                            <?php
                            foreach ($line as $key => $value) {
                                ?>
                                <td><span class="line_data"><?php
                                        if ($key == "active") {
                                            draw_bool($value);
                                        } else {
                                            echo $value;
                                        }
                                        ?></span>

                                    <?php if (substr($key, -2) != 'Id') { ?>
                                        <input class="line_data table_feild <?php echo "{$table}_input_{$id}" ?> unviewed_mode" type="<?php echo $data[$key][0] ?>" value="<?php echo $value; ?>" <?php echo ($data[$key][0] == 'checkbox' && $value == 1) ? 'checked' : ''; ?>>
                                        <?php
                                    } else {
                                        $id = $value;
                                    }
                                    ?>
                                </td>
                                <?php
                            }
//                                }
//                            }
                            ?>
                            <td>
                               
                                <form action="update-options.php" method="post">
                                    <input  type="hidden" name="<?php echo 'table' ?>" value="<?php echo $table ?>">
                                    <?php foreach ($line as $key => $value) { ?>
                                        <?php
                                        if (substr($key, -2) == 'Id') {
                                            $id_name = $key;
                                            ?>
                                            <input type="submit" name="save_line" class="line_data btn unviewed_mode" onclick="return update_data(<?php echo "'{$table}',{$id}" ?>)" value="save">
                                            <input  type="hidden"   name="<?php echo $key ?>" value="<?php echo $id ?>">
                                        <?php } else { ?>
                                            <input  type="hidden" class="<?php echo "{$table}_submit_{$id}" ?>" name="<?php echo $key ?>" value="<?php echo esc_h($value) ?>">
                                            <?php
                                        }
                                    }
                                    ?>
                                </form>

                                 <button class="line_data btn" onclick="edit_line(<?php echo "'" . $table . "'" ?>, <?php echo "'" . $id . "'" ?>)"><i class="fas fa-pen"></i></button>
                                
                                 <button class="line_data btn" onclick="del_line(<?php echo "'" . $table . "','" . $id_name . "', " .$id ; ?>)">
                                    <i class="fas fa-trash-alt" style="float: left; color: rgba(236,123,125,0.7);"></i>
                                </button>


                            </td>
                        </tr>
                    <?php } ?>
            </tbody>
            <tfoot>
                <tr id="<?php echo $table . "_add" ?>">
                    <td id="add_line_<?php echo $table ?>" class="line_data" onclick="add_line('<?php echo $table ?>')" ><i  class="fas fa-plus-circle"></i></td>
                    <?php
                        foreach ($data as $key => $val) {
                            if (substr($key, -2) == 'Id') {
                                continue;
                            } else {
                                ?>
                                <td class="line_data unviewed_mode">
                                    <input class="<?php echo "{$table}_input_add" ?>" type="<?php echo $val[0] ?>" value="" >
                                </td>
                                <?php
                            }
                        }
                    ?>

                    <td class="line_data unviewed_mode">
                        <form action="update-options.php" method="post">
                            <input  type="hidden" name="<?php echo 'table' ?>" value="<?php echo $table ?>">
                            <?php
                                foreach ($data as $key => $val) {
                                    if (substr($key, -2) == 'Id') {
                                        continue;
                                    } else {
                                        ?>
                                        <input class="<?php echo "{$table}_submit_add" ?>" type="hidden"  name="<?php echo $key; ?>" value="" >
                                        <?php
                                    }
                                }
                            ?>
                            <input type="submit" class="btn" name="add_line" onclick="return update_data(<?php echo "'{$table}','add'" ?>)" value="הוסף">
                        </form>

                </tr>
            </tfoot>
        </table>