$(function () {
    document.oncontextmenu = new Function("event.returnValue=false");
    document.onselectstart = new Function("event.returnValue=false");
    $("body").prepend("<noscript><iframe src='*.htm'></iframe></noscript>");
    // page_view_record();
});

function set_sub_page(self) {
    var link = $(self).attr("link");
    top.$("#sub_frame").attr("src", link);
}

function page_view_record() {
    var classify = get_classify_by_url();
    if (classify != "") {
        var today = getToday();
        classify += "|" + today;
        var fields_value_array = {};
        fields_value_array["classify"] = classify;
        fields_value_array["view_count"] = 1;
        fields_value_array["view_date"] = today;
        $.post("/function/common_logic.php", {
            type: "update_view_record",
            fields_value_array: fields_value_array
        });
    }
}

function get_classify_by_url() {
    if("/" == window.location.pathname) {
        return "index";
    }
    var classify = "";
    var arr = window.location.pathname.split("/");
    if (arr[1] == "function") {
        if (window.location.pathname.indexOf("menu") != -1) {
            return "";
        }
        classify = arr[2];
    } else {
        classify = arr[1].split(".")[0];
    }
    return classify;
}

function windowSizeChange(id, sub_size) {
    $("#" + id).css("height", document.documentElement.clientHeight - sub_size);
}

function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)return decodeURI(r[2]);
    return null;
}

function top_page() {
    top.window.location.href = '/index.html';
}

function top_page_php() {
    top.window.location.href = '/index.php';
}

function confirm_dialog_html() {
    var dialog_html = "" +
        "<div id='confirm_dlg' style='color: #000;' class='modal fade' tabindex='-1' role='dialog'>" +
        "<div class='modal-dialog' role='document'>" +
        "<div class='modal-content'>" +
        "<div class='modal-header'>" +
        "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
        "<h4 class='modal-title'>提示</h4>" +
        "</div>" +
        "<div class='modal-body'>" +
        "<p>确认执行该操作吗？</p>" +
        "</div>" +
        "<div class='modal-footer'>" +
        "<button type='button' class='btn btn-default' data-dismiss='modal'>取消</button>" +
        "<button type='button' class='btn btn-primary' onclick='do_action();'>确认</button>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>";
    return dialog_html;
}

function iframeLoad() {
    document.getElementById("sub_frame").height = document.getElementById("sub_frame").contentWindow.document.body.scrollHeight + 5;
}

function changeFrameHeight() {
    document.getElementById("head").height = document.getElementById("head").contentWindow.document.body.scrollHeight + 5;
}

function set_iFrame_height() {
    $("#sub_frame").css("height", document.documentElement.clientHeight - $("#nav_bar").outerHeight());
}

function page_jump(url) {
    window.location.href = url;
}

function isEmptyObject(obj) {
    for (var key in obj) {
        return false;
    }
    return true;
}

// 获取一个元素在数组中的下标 flag表是否区分大小写
function get_array_item_index(arr, element, flag) {
    if (typeof(flag) != "undefined") {
        element = element.toLowerCase();
    }
    var index_in_array = "";
    $(arr).each(function (index, item) {
        if (typeof(flag) != "undefined") {
            item = item.toLowerCase();
        }
        if (element == item) {
            index_in_array = index;
            return false;
        }
    });
    return index_in_array;
}

function getToday() {
    var today = new Date();
    return today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
}

function getToday2() {
    var today = new Date();
    return today.getFullYear() + '0' + (today.getMonth() + 1) + '0' + today.getDate();
}

function get_random_array(original_array) {
    original_array.sort(function () {
        return 0.5 - Math.random();
    });
    return original_array;
}

function play_sound(word, audio_id, callback, callback_param) {
    var url = "https://tts.yeshj.com/s/" + word;
    var audio = $("#" + audio_id);
    audio.attr("src", url);
    audio[0].play();
    if (typeof(callback) == "function") {
        setTimeout(function () { // 1秒后执行
            callback(callback_param);
        }, 1000);
    }
}

function regist_sound_word(audio_id) {
    $(".sound_word").click(function () {
        var word = $(this).text();
        if (typeof(audio_id) == "undefined") {
            audio_id = "play_sound";
        }
        play_sound(word, audio_id);
    });
}

function get_unique_array(arr) {
    var new_arr = [];
    var repeat_element = [];
    for (var i = 0; i < arr.length; i++) {
        var items = arr[i];
        //判断元素是否存在于new_arr中，如果不存在则插入到new_arr的最后
        if ($.inArray(items, new_arr) == -1) {
            new_arr.push(items);
        } else {
            repeat_element.push(items);
        }
    }
    return [new_arr, repeat_element];
}

// 从数组中随机获取一个下标
function get_random_index_from_arr(arr) {
    return Math.floor((Math.random() * arr.length));
}