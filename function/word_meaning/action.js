function regist_click(class_name, callback) {
    $("." + class_name).click(function () {
        if (typeof(callback) == "function") {
            callback($(this).html());
        }
    });
}

function for_something_show(title) {
    var html = "<div id='show_meaning' style='position: fixed; left: 1%; width: 98%; border-radius: 5px; z-index: 999;' class='bg-info p-2'>";
    html += "<div style='position: relative;'><i class='fa fa-close text-dark' style='position: absolute; right: 10px;' onclick='clear_window();'></i></div>";
    html += "<div id='show_meaning_title' class='text-warning pl-2 pb-1' style='border-bottom: 1px solid #fff;'>" + title + "</div>";
    html += "<div id='show_meaning_content' class='pl-2 mt-2 content'>" + eng_meaning[title].explain + "</div>";
    html += "</div>";
    $("#for_something_show").html(html);
    if (typeof(adjust_show_meaning_pos) == "function") {
        adjust_show_meaning_pos();
    }
}

function clear_window() {
    $("#for_something_show").html("");
}
