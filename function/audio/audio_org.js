var audio = undefined;
var audio_duration = undefined;
var play_process = undefined;
var lrc_index = 0;
var lrc_obj = undefined;
var lrc = undefined;

$(function () {
    audio = document.getElementById("my_audio");
    audio_duration = $("#audio_duration");
    play_process = $("#play_process");
    var song = GetQueryString("song");
    audio.src = "./resource/" + song + ".mp3";
    lrc = lrc_dict[song];
    lrc_obj = $("#lrc");
    var sub_content_height = parent.$("#sub_content").height();
    //$("#song_info").css("height", sub_content_height);
    lrc_obj.css("height", sub_content_height - 55);
    var lrc_html = "";
    $.each(lrc, function (idx, itm) {
        lrc_html += "<div id='" + itm[0] + "' class='lrc'>" + itm[1] + "</div>";
    });
    lrc_obj.html(lrc_html);
    $("#" + lrc[lrc_index][0]).addClass("current_lrc");
    lrc_index++;
    process_bar_init();
});

var audio_control = {
    play_pause: function (self) {
        audio_control.toggle_click(self, 'fa-play', audio_control.play, audio_control.pause);
    },
    play: function (self) {
        // $("#audio_duration").text("时长：" + parseInt(audio.duration) + "秒");
        audio_control.exchange_icon(self, "fa-play", "fa-pause");
        audio.addEventListener('timeupdate', process_bar_listener, false);
        audio.play();
    },
    pause: function (self) {
        audio_control.exchange_icon(self, "fa-pause", "fa-play");
        audio.removeEventListener('timeupdate', process_bar_listener, false);
        audio.pause();
    },
    fast: function () {
        audio_control.set_process(-5);
    },
    slow: function () {
        audio_control.set_process(5);
    },
    set_process: function (time) {
        audio.currentTime += time;
        adjust_lrc_index();
    },
    exchange_icon: function (self, before, after) {
        $(self).removeClass(before);
        $(self).addClass(after);
    },
    class_confirm: function (self, class_name) {
        return $(self).hasClass(class_name);
    },
    toggle_click: function (self, class_name, func1, func2) {
        if ($(self).hasClass(class_name)) {
            func1(self);
        } else {
            func2(self);
        }
    }
};

function adjust_lrc_index() {
    $.each(lrc, function (idx, item) {
        if (audio.currentTime < item[0]) {
            lrc_index = idx - 1;
            $(".lrc").removeClass("current_lrc");
            $("#" + lrc[lrc_index][0]).addClass("current_lrc");
            if (lrc_index > 6) {
                lrc_obj[0].scrollTop = (lrc_index - 6) * 24;
            } else {
                lrc_obj[0].scrollTop = 0;
            }
            return false;
        }
    });
}

function process_bar_init() {
    $("#progress").click(function (e) {
        //audio_control.exchange_icon($("#play")[0], "fa-play", "fa-pause");
        audio_control.play($("#play_pause")[0]);
        var process_val = (e.pageX - $(this).offset().left) / $(this).width();
        audio.currentTime = process_val * audio.duration;
        adjust_lrc_index();
    });
}

function process_bar_listener() {
    if (audio.ended) {
        audio_control.exchange_icon($("#play_pause")[0], "fa-pause", "fa-play");
        play_process.css("width", "0%");
        // play_process.text('0%');
        audio.removeEventListener('timeupdate', process_bar_listener, false);
    }
    var process_val = (audio.currentTime / audio.duration) * 100;
    audio_duration.text(parseInt(audio.duration - audio.currentTime) + "s");
    play_process.css("width", process_val + '%');
    // play_process.text(Math.floor(process_val) + '%');
    if (lrc_index < lrc.length && this.currentTime > lrc[lrc_index][0]) {
        $(".lrc").removeClass("current_lrc");
        $("#" + lrc[lrc_index][0]).addClass("current_lrc");
        lrc_index++;
        if (lrc_index > 6) {
            lrc_obj[0].scrollTop += 24;
        }
    }
}