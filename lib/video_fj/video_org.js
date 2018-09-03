var control_name_list = ["play_pause", "fast", "slow", "sound", "speed", "subscription", "lessen"];

var control_btn_info = {
    play_pause: {
        icon: ["play", "pause"]
    },
    fast: {
        icon: ["backward"]
    },
    slow: {
        icon: ["forward"]
    },
    sound: {
        icon: ["volume-up", "volume-off"]
    },
    speed: {
        icon: ["flash"],
        expand_attr: "data-toggle='popover' data-placement='top' data-original-title='播速'"
    },
    subscription: {
        icon: ["cc"],
        expand_attr: "data-toggle='popover' data-placement='top' data-original-title='字幕'"
    },
    lessen: {
        icon: ["times"]
    }
};

var video_control = {
    play_pause: function (self) {
        video_control.toggle_click(self, 'fa-play', video_control.play, video_control.pause);
    },
    play: function (self) {
        $("#video_duration").text("时长：" + parseInt(video.duration) + "秒");
        video_control.exchange_icon(self, "fa-play", "fa-pause");
        video.addEventListener('timeupdate', process_bar_listener, false);
        video.play();
    },
    pause: function (self) {
        video_control.exchange_icon(self, "fa-pause", "fa-play");
        video.removeEventListener('timeupdate', process_bar_listener, false);
        video.pause();
    },
    sound: function (self) {
        if (video_control.class_confirm(self, "fa-volume-up")) {
            video.muted = true;
            video_control.exchange_icon(self, "fa-volume-up", "fa-volume-off");
        } else {
            video.muted = false;
            video_control.exchange_icon(self, "fa-volume-off", "fa-volume-up");
        }
    },
    fast: function () {
        video_control.set_process(-5);
    },
    slow: function () {
        video_control.set_process(5);
    },
    exchange_icon: function (self, before, after) {
        $(self).children("i").removeClass(before);
        $(self).children("i").addClass(after);
    },
    class_confirm: function (self, class_name) {
        return $(self).children("i").hasClass(class_name);
    },
    toggle_click: function (self, class_name, func1, func2) {
        if ($(self).children("i").hasClass(class_name)) {
            func1(self);
        } else {
            func2(self);
        }
    },
    set_subtitles: function (self, index) {
        if ($(self).hasClass("btn-primary")) {
            $(self).removeClass("btn-primary");
            $(self).addClass("btn-secondary");
            video.textTracks[index].mode = 'hidden';
        } else {
            $(self).removeClass("btn-secondary");
            $(self).addClass("btn-primary");
            video.textTracks[index].mode = 'showing';
        }
        $("#subscription_popover").html($(self).parent().html());
        $('[data-toggle="popover"]').popover("hide");
    },
    set_process: function (time) {
        video.currentTime += time;
    },
    lessen: function () {
        $("#expand").toggle();
        $("#video_control_bar").toggle();
    }
};

function create_video(special_buttons) {
    if (window.location.host != "iperson.top") {
        location.href = "https://iperson.top";
    }
    var html = "<div id='video_container' class='w-100 text-center'>";
    var html_subtitle_item = "";
    html += "<button id='expand' class='abs btn btn-outline-light control_btn' onclick='video_control.lessen();'><i class='fa fa-arrows-h'></i></button>";
    html += "<div id='loading' style='text-align: center;'>";
    html += "<div class='fa-3x'>";
    html += "<i class='fa fa-spinner fa-spin'></i>";
    html += "</div>";
    html += "<div class='mt-2'>视频内容加载中！</div>";
    html += "</div>";
    html += "<video id='video' class='w-100' style='max-width: 600px;' webkit-playsinline='true' x5-video-player-type='h5' x5-video-player-fullscreen='true'>";
    html += "<source src='/function/english/video/resources/" + poster + ".mp4' type='video/mp4'>";
    var html_subtitle_item_count = 0;
    if (eng == "y") {
        html += "<track label='English' kind='subtitles' srclang='en' src='/function/english/video/resources/" + poster + "eng.vtt'>";
        html_subtitle_item += "<button class='btn btn-secondary px-1 py-0 subscription_popover' onclick='video_control.set_subtitles(this, \"" + html_subtitle_item_count + "\");'>英文</button> ";
        html_subtitle_item_count++;
    }
    if (chn == "y") {
        html += "<track label='Chinese' kind='subtitles' srclang='cn' src='/function/english/video/resources/" + poster + "chn.vtt'>";
        html_subtitle_item += " <button class='btn btn-secondary px-1 py-0 subscription_popover' onclick='video_control.set_subtitles(this, \"" + html_subtitle_item_count + "\");'>中文</button>";
        html_subtitle_item_count++;
    }
    if (html_subtitle_item_count == 0) {
        html_subtitle_item = "没有字幕";
    }
    $("#subscription_popover").html(html_subtitle_item);
    html += "</video>";
    html += "<div id='video_control_bar' class='w-100 abs'>";
    html += "<div id='video_controls'>";
    html += create_control_buttons(special_buttons);
    html += "</div>";
    html += "</div>";
    html += "<div id='progress' class='abs progress w-100'>";
    html += "<div id='play_process' class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' style='width: 0%'></div>";
    html += "</div>";
    html += "</div>";
    $("#video_page").html(html);
    video = document.getElementById("video");
    video_canvas = document.getElementById("video_canvas");
    load_video();
    set_video_size();
    control_init();
    popover_init();
    process_bar_init();
    control_button_click();
    $("#video").addClass("video_show");
    $("#video_control_bar").addClass("video_show");
    $("#progress").addClass("video_show");
    $(".video_show").hide();
}

function load_video() {
    video.addEventListener('canplaythrough', function () {
        $("#loading").hide();
        $(".video_show").show();
    });
}

function create_control_buttons(special_buttons) {
    var html = "";
    if (typeof(special_buttons) == "undefined") {
        special_buttons = control_name_list;
    }
    $.each(special_buttons, function (idx, btn_name) {
        var expand_attr = "";
        if (typeof(control_btn_info[btn_name].expand_attr) != "undefined") {
            expand_attr = control_btn_info[btn_name].expand_attr;
        }
        html += "<button id='" + btn_name + "' class='abs btn btn-outline-light control_btn' " + expand_attr + "><i class='fa fa-" + control_btn_info[btn_name].icon[0] + "'></i></button>";
    });
    return html;
}

function control_button_click() {
    $(".control_btn").click(function () {
        var btn_name = $(this).attr("id");
        if (typeof(video_control[btn_name]) == "function") {
            $('[data-toggle="popover"]').popover("hide");
            video_control[btn_name](this);
        }
    });
}

function control_init() {
    // if (video.textTracks) {
    //     for (var i = 0; i < video.textTracks.length; i++) {
    //         console.log(video.textTracks[i].language);
    //     }
    // }
    var expand = $("#expand");
    var control_count = control_name_list.length;
    var control_total_width = control_btn_width * control_count;
    var blank_width = parseInt((bar_width - control_total_width) / (control_count + 1));
    var current_left_pos = 0;
    $.each(control_name_list, function (idx, name) {
        control_list[name] = $("#" + name);
        control_list[name].css("left", current_left_pos);
        control_list[name].css("margin-left", blank_width);
        if (idx == control_count - 1) {
            expand.css("left", current_left_pos + $("#video_control_bar").offset().left);
            expand.css("margin-left", blank_width);
        }
        current_left_pos += 40 + blank_width;
    });
    $(".set_process_bar_status").click(function () {
        video_control.set_process_bar_status();
    });
}

function set_video_size() {
    var bar = $("#video_control_bar");
    var progress = $("#progress");
    bar_width = bar.width();
    var bar_left_pos = bar.offset().left;
    bar.css("left", bar_left_pos - bar_width / 2);
    progress.css("left", bar_left_pos - bar_width / 2);
}

function popover_init() {
    $("#subscription").popover({
        html: true,
        content: function () {
            return $('#subscription_popover').html();
        }
    });

    $("#speed").popover({
        html: true,
        content: function () {
            return $('#speed_popover').html();
        }
    });

    $('[data-toggle="popover"]').popover();
    $('[data-toggle="popover"]').click(function () {
        $(this).siblings('[data-toggle="popover"]').popover("hide");
    });
}

function process_bar_init() {
    $("#progress").click(function (e) {
        $('[data-toggle="popover"]').popover("hide");
        var play_process = $("#play_process");
        video_control.exchange_icon($("#play")[0], "fa-play", "fa-pause");
        video_control.play();
        var process_val = (e.pageX - $(this).offset().left) / $(this).width();
        video.currentTime = process_val * video.duration;
    });
}

function process_bar_listener() {
    var play_process = $("#play_process");
    var process_val = (video.currentTime / video.duration) * 100;
    play_process.css("width", process_val + '%');
    play_process.text(Math.floor(process_val) + '%');
    if (video.ended) {
        video_control.exchange_icon($("#play")[0], "fa-pause", "fa-play");
        play_process.css("width", "0%");
        play_process.text('0%');
        video.removeEventListener('timeupdate', process_bar_listener, false);
    }
}

function popover_btn_click(self, class_name) {
    $("." + class_name).removeClass("btn-primary");
    $("." + class_name).addClass("btn-secondary");
    $(self).removeClass("btn-secondary");
    $(self).addClass("btn-primary");
    $("#" + class_name).html($(self).parent().html());
    $('[data-toggle="popover"]').popover("hide");
}