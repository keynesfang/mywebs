// video_area_id: video所属区域ID
// video_index: video序号（目前网站中的视频都是1,2,3这样来命名的）
// video_path: video的相对路径
// has_subtitles: video是否有字幕
// video_width_id: video宽度区域id，有时候如果video所在区域是隐藏的话，直接获取高度会失败，所以才有了这个参数
const evt = "onorientationchange" in window ? "orientationchange" : "resize";

function show_video(video_area_id, video_index, video_path, has_subtitles, video_width_id) {
    var video_id = "video" + video_index;
    var video_area = $("#" + video_area_id);
    var video_width = getVideoWidth(video_area_id, video_width_id);
    var screenHeight = document.documentElement.clientHeight;
    var video_height_style = "";
    if (typeof(video_width_id) == "undefined" || video_width_id == "") {
        video_height_style = " height='" + screenHeight + "'";
    }

    if ($.trim(video_area.html()) == "") {
        var html = "<video fullscreen='not' x5-video-player-type='h5' x5-video-orientation='portrait' x5-video-player-fullscreen='true' id='" + video_id + "' class='video-js-player video-js vjs-default-skin vjs-big-play-centered' origianl_height='unknown' original_width='" + video_width + "' " + video_height_style + " width='" + video_width + "'>" +
            // var html = "<video x5-video-player-type='h5' x5-video-orientation='portrait' x5-video-player-fullscreen='true' id='" + video_id + "' class='video-js vjs-default-skin vjs-big-play-centered' width='" + clientWidth + "' height='" + clientHeight + "'>" +
            "<source src='" + video_path + video_index + ".mp4' type='video/mp4'/>";
        if (has_subtitles) {
            html += "<track kind='subtitles' src='" + video_path + video_index + "_eng.vtt' srclang='EN' label='English'/>" +
                "<track kind='subtitles' src='" + video_path + video_index + "_chn.vtt' srclang='zh-CN' label='简体中文'/>";
        }
        html += "</video>";
        video_area.html(html);

        var player = videojs(video_id, {
            bigPlayButton: true,
            textTrackDisplay: true,
            posterImage: false,
            errorDisplay: false,
            controls: true,
            preload: false,
            controlBar: {
                playToggle: true,
                muteToggle: false,
                captionsButton: false,
                chaptersButton: false,
                subtitlesButton: true,
                fullscreenToggle: true,
                progressControl: {
                    keepTooltipsInside: true
                }
            }
        });
        $(".vjs-subs-caps-button").hide();
    }

    $(".vjs-fullscreen-control").click(function () {
        if (!IsPC()) {
            var video = $(this).parent().parent();
            var nav_bar = parent.$("#nav_bar");
            var fulls = parent.$("#fulls");
            if (video.attr("fullscreen") == "not") {
                fulls.click();
                fulls.hide(500);
                nav_bar.hide(1000);
                parent.$("#sub_frame").css("padding-top", 0);
                video.attr("origianl_height", video.height());
                video.css("z-index", "2").attr("fullscreen", "yes");
            } else {
                var navBarHeight = parent.$("#nav_bar").outerHeight();
                fulls.click();
                fulls.show(1500);
                nav_bar.show(1000);
                parent.$("#sub_frame").css("padding-top", navBarHeight - 2);
                video.attr("fullscreen", "not");
            }
            set_full_srceen_video(video);
        }
    });
}

function getVideoWidth(video_area_id, video_width_id) {
    var video_area = $("#" + video_area_id);
    var video_area_width = video_area.width();
    if (video_area.is(':hidden')) {
        video_area_width = $("#" + video_width_id).width();
    }
    var player_width = parseFloat(video_area_width);
    return player_width;
}

function set_full_srceen_video(video) {
    var screenWidth = window.screen.width;
    var screenHeight = window.screen.height;
    var top = (screenHeight - screenWidth) / 2 + 'px';
    var left = 0 - (screenHeight - screenWidth) / 2 + 'px';
    if (video.attr("fullscreen") == "yes") {
        if (screenWidth > screenHeight) { // 横屏
            video.css("position", "fixed").css("top", "0").css("left", "0").css("width", screenWidth).css("height", screenHeight).css("transform", "none");
        } else {
            video.css("position", "fixed").css("top", top).css("left", left).css("width", screenHeight).css("height", screenWidth).css("transform", "rotate(90deg)");
        }
    } else {
        var original_width = video.attr("original_width");
        video.css("position", "relative").css("top", "0").css("left", "0").css("width", original_width).css("height", video.attr("origianl_height")).css("transform", "none");
    }
}

// 注册屏幕
window.addEventListener(evt, function () {
    var video = $(".video-js-player");
    if (video.attr("fullscreen") == "yes") {
        set_full_srceen_video(video);
    }
}, false);