function toggle_line(td_arr) {
    for (let i = 1; i < td_arr.length; ++i) {
        if (td_arr[i].className.endsWith("unviewed_mode")) {
            td_arr[i].className = td_arr[i].className.replace("unviewed_mode", '');
        } else {
            td_arr[i].className += " unviewed_mode";
        }
    }
}

function edit_line(table, id) {
    if (!write_mode) {
        let tr = document.getElementById(table + "_" + id);
        let td_arr = tr.getElementsByClassName("line_data");
//                        let line_sign = table + "_input_" +  id;

        toggle_line(td_arr);
        write_mode = true;
        write_table = table;
        write_line = id;
    } else {
        let old_tr = document.getElementById(write_table + "_" + write_line);
        let old_td_arr = old_tr.getElementsByClassName("line_data");
        toggle_line(old_td_arr);
        write_mode = false;
        edit_line(table, id);
    }
}


function update_data(table, id) {
    let inputs = document.getElementsByClassName(table + "_input_" + id);
    let submits = document.getElementsByClassName(table + "_submit_" + id);
    if (inputs.length == submits.length) {
        for (let i = 0; i < inputs.length; ++i) {
            if (inputs[i].type == "checkbox") {
                submits[i].value = inputs[i].checked ? 1 : 0;
            } else {
                submits[i].value = inputs[i].value;
            }
        }
    } else {
        console.log("something went wrong!!");
        return false;
    }
}

function add_line(table) {
    if (!write_mode) {
        let tr = document.getElementById(table + "_add");
        let td_add = tr.getElementsByClassName("line_data");

        toggle_line(td_add);
        write_mode = true;
        write_table = table;
        write_line = "add";
    } else {
        let old_tr = document.getElementById(write_table + "_" + write_line);
        let old_td_arr = old_tr.getElementsByClassName("line_data");
//        console.log(write_table + "_" + write_line);
        toggle_line(old_td_arr);
        write_mode = false;
        add_line(table);
    }

}
