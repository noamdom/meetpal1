/**----------------------- Contants ---------------- */

// del modal elem'
const confirm_back = document.getElementById("confirm_back");
const del_msg = document.getElementById("del_msg");
const del_id = document.getElementById("del_id");
const del_id_name = document.getElementById("del_id_name");
const del_table = document.getElementById("del_table");


 /**------------------ Functions -------------------- */

// this function pop confirmation windonw of delete line click
function del_line(table, id_name, id) {
    confirm_back.style.display = "block";
    del_msg.innerHTML = " אשר מחיקת שורה " + id + " בטבלת " + table;
    del_id.value = id;
    del_id_name.value = id_name;
    del_table.value = table;
}

// this function close the confirmation window
function cancel_del() {
    confirm_back.style.display = "none";
    return false;
}
