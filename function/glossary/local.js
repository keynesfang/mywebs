var loading = false; // 是否正在加载中
var per_page_word_cont = 20; // 每次获取的单词数量
var localStorage_bookmark = 0;
var localStorage_word = "";
var is_first_load = true;

function regist_word_event() {
    $(".word_package").off("click");
    $(".word_sound").off("click");
    $(".word_bookmark").off("click");
    $(".word_heart").off("click");

    $(".word_package").click(function () {
        var word = $(this).children(".word_content").text();
        _query_word(this, word);
    });
    $(".word_sound").click(function () {
        var word = $(this).next().text();
        play_voice(word);
        return false;
    });
    $(".word_bookmark").click(function () {
        $(".word_bookmark").removeClass("text-warning");
        $(".word_bookmark").add("text-light");
        $(this).removeClass("text-light");
        $(this).addClass("text-warning");
        var bookmark = $(this).attr("word_type") + "_bookmark";
        var bookmark_index = parseInt($(this).attr("index")) - 1;
        window.localStorage.setItem(bookmark, bookmark_index);
        return false;
    });
    $(".word_heart").click(function () {
        var word_type = $(this).attr("word_type") + "_word";
        var word = $(this).attr("word");
        var index = $(this).attr("index");
        if ($(this).hasClass("text-light")) {
            $(this).removeClass("text-light");
            $(this).addClass("text-danger");
            localStorage_word[word] = index;
        } else {
            $(this).removeClass("text-danger");
            $(this).addClass("text-light");
            delete localStorage_word[word];
        }
        window.localStorage.setItem(word_type, JSON.stringify(localStorage_word));
        return false;
    });
}

function search_word_close() {
    $("#search_caret_up").hide(100)
    $("#search_close").hide(100)
    $("#search_word").hide(100)
}

function search_word() {
    explain_panel = $("#search_word");
    $(".search_word").show(100);
    var word = $("#current_search_word").val();
    if($.trim(word) == "") {
        explain_panel.text("请输入要查询的单词！")
    } else {
        var loading_html = "<div class='fa-3x'><i class='fa fa-spinner fa-spin'></i></div><div class='pb-2'>单词含义查询中！</div>";
        explain_panel.html(loading_html);
        query_word(word, show_word_explain);
    }
}

function _query_word(self, word) {
    explain_panel = $(self).next();
    if (explain_panel.text() == "") {
        var loading_html = "<div class='fa-3x'><i class='fa fa-spinner fa-spin'></i></div><div class='pb-2'>单词含义查询中！</div>";
        explain_panel.html(loading_html);
        query_word(word, show_word_explain);
    }
    explain_panel.slideToggle(200);
}

function show_word_explain(explain_info) {
    var explains = "";
    for (var i = 0; i < explain_info.explains.length; i++) {
        explains += explain_info.explains[i] + "<br>";
    }
    var explain_html = "<div class='p-2' style='font-size: 14px; text-align: left;'>";
    explain_html += "<div id='phonetic' class='font-weight-bold ml-2 mb-1 text-warning'>" + explain_info.phonetic + "</div>";
    explain_html += "<div id='word_explain' class='ml-2'>" + explains + "</div>";
    explain_html += "</div>";
    explain_panel.html(explain_html);
}

function load_word(word_type, direction) {
    // 设置向下滚动加载时的参考
    var current_word_index = current_bottom_word_index;
    var cur_page_word_count = per_page_word_cont;
    // 设置向上滚动加载时的参考
    if (typeof(direction) != "undefined" && direction == "up") {
        var temp_index = current_top_word_index - per_page_word_cont;
        if (temp_index > 0) {
            current_word_index = current_top_word_index = temp_index;
        } else {
            cur_page_word_count = current_top_word_index;
            current_word_index = current_top_word_index = 0;
        }
    }
    $.post("local_logic.php", {
        type: "get_word_by_type",
        current_word_index: current_word_index,
        cur_page_word_count: cur_page_word_count,
        word_type: word_type
    }, function (data) {
        my_new_word_arr = eval("(" + data + ")");
        var new_word_list_html = "";
        var boormark_color = "";
        var heart_color = "";
        $.each(my_new_word_arr, function (idx, info) {
            (is_first_load) ? boormark_color = "text-warning" : boormark_color = "text-light";
            (localStorage_word[info.word]) ? heart_color = "text-danger" : heart_color = "text-light";
            new_word_list_html += "<div id='" + info.id + "' class='word_package bg-dark'>";
            new_word_list_html += "<div class='word_sound bg-primary'><i class='fa fa-volume-up text-warning'></i></div>";
            new_word_list_html += "<span class='word_content px-2'>" + info.word + "</span>";
            new_word_list_html += "<div class='word_heart bg-secondary " + heart_color + "' word_type='" + word_type + "' word='" + info.word + "' index='" + info.id + "'><i class='fa fa-heart'></i></div>";
            new_word_list_html += "<div class='word_bookmark " + boormark_color + "' word_type='" + word_type + "' index='" + info.id + "'><span class='word_bookmark_char'>书签</span> <i class='fa fa-bookmark'></i></div>";
            new_word_list_html += "</div>";
            new_word_list_html += "<div class='word_explain_panel bg-secondary' style='text-align:center; display: none;'></div>";
            is_first_load = false;
        });
        if (direction != "up" && my_new_word_arr.length < per_page_word_cont) {
            down_load_complete = true;
            new_word_list_html += "<div class='bottom_line mt-2' style='text-align: center;'>单词没有了<hr class='mt-1 text-light'></div>";
        }
        loading = false;
        $("#loading_icon").remove();
        if (direction == "up") {
            $("#word_list_package").prepend(new_word_list_html);
        } else {
            $("#word_list_package").append(new_word_list_html);
        }
        $(document).scrollTop(1);
        parent.$("#word_show_count").text($(".word_package").length);
        current_bottom_word_index = parseInt(current_bottom_word_index) + my_new_word_arr.length;
        regist_word_event();
    });
}

function regScrollbar(word_type) {
    $(document).scroll(function () {
        var html = "";
        var scrollBottom = $(document).height() - $(document).scrollTop() - $(window).height();
        if (!down_load_complete) { // 未全部加载完时
            if (scrollBottom < 10 && !loading) { // 滚动条到了该加载的时候，且没有显示加载图标的时候
                loading = true; // 加载中，显示加载图标
                html = "<div id='loading_icon' class='loading_icon' style='text-align: center;'><i class='fa fa-spinner fa-spin'></i></div>";
                $("#word_list_package").append(html);
                load_word(word_type);
            }
        }
        if (current_top_word_index != 0) {
            if ($(document).scrollTop() == 0 && !loading) {
                loading = true; // 加载中，显示加载图标
                html = "<div id='loading_icon' class='loading_icon' style='text-align: center;'><i class='fa fa-spinner fa-spin'></i></div>";
                $("#word_list_package").prepend(html);
                load_word(word_type, "up");
            }
        }
    });
}