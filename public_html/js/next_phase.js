/**----------------------- Contants ------------ */

// next pahse elem'
const confirm_back = document.getElementById("confirm_back");
const next_msg = document.getElementById("next_msg");
const next_id = document.getElementById("next_id");
//const next_url = document.getElementById("next_url");
const next_phase = document.getElementById("next_phase");
const archive_stat = document.getElementById("archive_stat");
const prod_files = document.getElementById("prod_files");
const next_form = document.getElementById("next_form");


 /**------------------ Functions -------------------- */

// this function pop confirmation windonw of next phase click
function confirm_next(id, prod_name, phase) {
    let idx = parseInt(phase);
    confirm_back.style.display = "block";
    next_msg.innerHTML = "אשר מעבר של <b>" + prod_name + "</b> משלב <u>'" + phase_json[idx - 1][1] + "</u>' לשלב <u>'" + phase_json[idx][1] + "</u>'";
    next_id.value = id;
    next_phase.value = phase + 1;
    if (phase + 1 == 13) {
        archive_stat.style.display = "block";
        prod_files.name = "prod_file_" + id + "[]";
    }
}

// this function close the confirmation window
function cancel_next() {
    confirm_back.style.display = "none";
    archive_stat.style.display = "none";
    return false;
}
