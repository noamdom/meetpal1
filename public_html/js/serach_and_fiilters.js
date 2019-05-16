/**------- Contants ------------ */

// search line elem'
const search_line = document.getElementById("searchLine");

//filteres:
const open_filter = document.getElementById("open_filter");
const filter_btn = document.getElementById("filter_btn");
const con_filter_table = document.getElementById("con_filter_table");



/**------- Functions ------------ */

// display filter table:
function prog_filter_view() {
    if (con_filter_table.style.display == "block") {
        con_filter_table.style.display = "none";
        open_filter.childNodes[1].className = "fa fa-caret-down";
    } else {
        con_filter_table.style.display = "block";
        open_filter.childNodes[1].className = "fa fa-caret-up";
    }
}

// filter the table by search line (produst name)
function search(table, col) {
    var input, filter, table, tr, td, i;
    filter = search_line.value.toUpperCase();
    table = document.getElementById(table);
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[col];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    let cname = "c_search";
    setCookie(cname, filter);
}



  
    // filter the table by search line (produst name)
function search_name_or_id(table, name_col, id_col) {
    var input, filter, table, tr, td_name,td_id, i;
    filter = search_line.value.toUpperCase();
    table = document.getElementById(table);
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td_name = tr[i].getElementsByTagName("td")[name_col];
        td_id = tr[i].getElementsByTagName("td")[id_col];
        if (td_name || td_id) {
            if ((td_name.innerHTML.toUpperCase().indexOf(filter) > -1 || td_id.innerHTML.toUpperCase().indexOf(filter) > -1)) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
    
    

    let cname = "c_search";
    setCookie(cname, filter);
}




// filter table by number range
function numbers_filter(tr, col, min, max) {
    let min_range = document.getElementById(min).value;
    let max_range = document.getElementById(max).value;
    let i, td, td_num, flag_num;
    flag_num = true;
    if (min_range || max_range) { // not both empty
        min_range = min_range ? min_range : -Infinity; // min date
        max_range = max_range ? max_range : Infinity; // max date
        td = tr[col];
        if (td) {
            td_num = parseInt(td.innerHTML);
            if (td_num >= min_range && td_num <= max_range) {
                flag_num = true;
                console.log("true");
            } else {
                flag_num = false;
            }
        }
    }
    return flag_num;
}


// filter table by dates range
function date_filter(tr, col, from, to) {
    let from_d = document.getElementById(from).value.substring(2);
    let to_d = document.getElementById(to).value.substring(2);
    let i, td, td_date, flag_date;

    flag_date = true;
    if (to_d || from_d) { // not both empty
        from_d = from_d ? from_d : "01-01-01"; // min date
        to_d = to_d ? to_d : "99-12-30"; // max date
        td = tr[col];
        if (td) {
            td_date = td.innerHTML.split('/').reverse().join('-');
            if (td_date >= from_d && td_date <= to_d) {
                flag_date = true;
            } else {
                flag_date = false;
            }
        }
    }
    return flag_date;
}


// this function filter one col witch fill by data table (by select and not input text)
function filter_col(tr, col, id) {
    let fil_text, j;
    let flag_fil = true;
    let td = tr[col];
    $filters = $(id).select2('data');
    if (td && $filters.length > 0) {
        flag_fil = false;
        for (j = 0; j < $filters.length; ++j) {
            fil_text = $filters[j].text.toUpperCase();
            if (td.innerHTML.toUpperCase().indexOf(fil_text) > -1) { // has match
                flag_fil = true;
                break;
            }
        }
    }
    return flag_fil;
}

/**--------------- Events: ------------------- */



//    window.onload = function () {
//        links_arr[0].className += " link_active";
//        if (search_line.value != "") {
//            search("prods_table", 2);
//        }
//    };
    


