var audio = undefined;
var audio_duration = undefined;
var play_process = undefined;
var lrc_index = 0;
var lrc_obj = undefined;
var lrc = undefined;
var lrc_dict = {
    "TakeMeToYourHeart": [[0, 'Take me to your heart'], [10, 'Michael Learns To Rock'], [17, 'Hiding from the rain and snow'], [20, "Trying to forget but i won't let go"], [25, 'Looking at a crowded street'], [29, 'Listening to my own heart beat'], [32, '...'], [34, 'So many people'], [37, 'All around the world'], [41, 'Tell me where do i find'], [45, 'Someone like you girl'], [47, '...'], [48, 'Take me to your heart'], [50, 'Take me to your soul'], [52, "Give me your hand before i'm old"], [55, '...'], [56, 'Show me what love is'], [58, "Haven't got a clue"], [60, 'Show me that wonders can be true'], [63, '...'], [64, 'They say nothing lasts forever'], [68, "We're only here today"], [73, 'Love is now or never'], [76, 'Bring me far away'], [79, '...'], [80, 'Take me to your heart'], [82, 'Take me to your soul'], [84, 'Give me your hand and hold me'], [87, '...'], [87, 'Show me what love is'], [90, 'Be my guiding star'], [92, "It's easy take me to your heart"], [97, '...'], [132, 'Standing on a mountain high'], [134, 'Looking at the moon through a clear blue sky'], [139, 'I should go and see some friends'], [143, "But they don't really comprehend"], [146, '...'], [147, "Don't need too much talking"], [151, 'Without saying anything'], [155, 'All i need is someone'], [159, 'Who makes me wanna sing'], [162, '...'], [162, 'Take me to your heart'], [164, 'Take me to your soul'], [166, "Give me your hand before i'm old"], [170, '...'], [170, 'Show me what love is'], [172, "Haven't got a clue"], [174, 'Show me that wonders can be true'], [178, '...'], [178, 'They say nothing lasts forever'], [183, "We're only here today"], [187, 'Love is now or never'], [191, 'Bring me far away'], [193, '...'], [194, 'Take me to your heart'], [196, 'Take me to your soul'], [199, 'Give me your hand and hold me'], [201, '...'], [202, 'Show me what love is'], [204, 'Be my guiding star'], [206, "It's easy take me to your heart"], [212, '...'], [213, 'Take me to your heart'], [215, 'Take me to your soul'], [218, 'Give me your hand and hold me'], [221, '...'], [221, 'Show me what love is'], [223, 'Be my guiding star'], [226, "It's easy take me to your heart"], [231, '...']],
    "MyHeartWillGoOn": [[6, 'Celine Dion'], [10, '...'], [18, 'Every night in my dreams'], [24, 'I see you,I feel you'], [29, 'That is how I know you go on'], [39, 'Far across the distance'], [43, 'And spaces between us'], [49, 'You have come to show you go on'], [58, 'Near far'], [63, 'Wherever you are'], [67, 'I believe'], [70, 'That the heart does go on'], [78, 'Once more you open the door'], [86, 'And you  re here in my heart'], [92, 'And my heart will go on and on'], [100, 'Love can touch us one time'], [104, 'And last for a lifetime'], [109, 'And never let go till were one'], [119, 'Love was when I loved you'], [123, 'One true time I hold to'], [129, 'In my life well always go on'], [139, 'Near far'], [143, 'Wherever you are'], [147, 'I believe'], [150, 'That the heart does go on'], [158, 'Once more you open the door'], [166, 'And you  re here in my heart'], [171, 'And my heart will go on and on'], [180, '...'], [196, 'you  re here'], [201, 'Theres nothing I fear'], [206, 'And I know'], [208, 'That my heart will go on'], [216, 'Well stay forever this way'], [226, 'You are safe in my heart'], [230, 'And my heart will go on and on'], [242, '...']]
};

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