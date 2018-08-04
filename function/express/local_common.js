$(function () {
    init_title();
    $("#page").css("height", document.documentElement.clientHeight);
    $(".item_content").click(function () {
        $(this).next().toggle(100);
    });
    regist_click("key", for_something_show);
    adjust_show_meaning_pos();
});

function init_title() {
    $(".content_status").hide();
    $(".title").click(function () {
        $(this).next().toggle(100);
    });
}

function adjust_show_meaning_pos() {
    var show_meaning = $("#show_meaning");
    var sub_frame_height = top.$("#sub_frame").height();
    var cur_height = show_meaning.height();
    show_meaning.css("top", (sub_frame_height - cur_height)/2);
}