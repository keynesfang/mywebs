var g_page_data = {
    user_id: "",
    user_name: "",
    family_id: "",
    family_name: "",
    family_surname: "",
    person_id: "",
    person_name: "",
    user_right: ""
};

function init_page_data() {
    $.each(g_page_data, function (item) {
        g_page_data[item] = "";
    });
}

function init_page_cookie() {
    if (typeof($.cookie('user_id')) == "undefined") {
        init_page_data();
        copy_page_data_to_cookie(g_page_data);
    }
}

function clear_page_cookie() {
    if (typeof($.cookie('user_id')) != "undefined") {
        init_page_data();
        copy_page_data_to_cookie(g_page_data);
    }
}

function copy_page_data_to_cookie(page_data) {
    $.each(page_data, function (item, value) {
        $.cookie(item, value);
    });
}

function copy_cookie_to_page_data() {
    $.each(g_page_data, function (item) {
        g_page_data[item] = $.cookie(item);
    });
}