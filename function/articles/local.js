function article_show_check() {
    article_id = GetQueryString("article_id");
    if($.trim(article_id) == "") {
        location.href = "/index.html";
    }
}

function initPageData()
{
    $.post("../local_logic.php", {
        type: "show_article",
        article_id: article_id
    }, function (data) {
        var article_info = eval("(" + data + ")");
        var head = $(window.frames["head"].document);
        $("#current_title").html(article_info.title);
        head.find("#up").html(article_info.upcount);
        head.find("#down").html(article_info.downcount);
        head.find("#viewcount").html(article_info.viewcount);
        head.find("#article_type").attr("article_type", article_info.tp);
    });
}

function show_article_list(_this) {
    var type = $(_this).attr("article_type");
    top.location.href = "/function/articles/directory.html?type=" + type;
}
