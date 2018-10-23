function get_ted_info_html() {
    var ted_html = "";
    var is_new_p = true;
    for (var i = 0; i < ted_info.length; i++) {
        if (is_new_p) {
            ted_html += "<p class='mb-2' index='" + i + "'><i class='section fa fa-play-circle mr-2'></i>";
            is_new_p = false;
        }
        if (ted_info[i].eng[0] == "(") {
            is_new_p = true;
            ted_html += "<i class='fa fa-file ml-2 section_translate' index='" + i + "'></i></p>";
            ted_html += "<p class='mb-2' index='" + i + "'><i class='section fa fa-play-circle mr-2'></i>";
            ted_html += " " + get_query_sentence_from_normal(ted_info[i].eng);
            ted_html += "</p>";
            continue;
        }
        ted_html += " <span class='sentence' index='" + i + "'>" + get_query_sentence_from_normal(ted_info[i].eng) + "</span>";
    }
    $("#subtitle_info").html(ted_html);

    $("query").click(function () {
        if ($('#click_mode').is(":checked")) {
            var word = $(this).html();
            if (typeof(top.set_explain_word) == "function") {
                word = top.set_explain_word(word);
            }
            query_word(word, top.query_word_callback);
        } else {
            var index = $(this).parent().attr("index");
            video.currentTime = get_second_from_time(ted_info[index].start);
            video.play();
            check_play_icon();
        }
    });

    $(".section").click(function () {
        var index = $(this).parent().attr("index");
        video.currentTime = get_second_from_time(ted_info[index].start);
        video.play();
        check_play_icon();
    });

    $(".section_translate").click(function () {
        var start = parseInt($(this).parent().attr("index"));
        var end = parseInt($(this).attr("index"));
        var translate = "";
        for(var i=start; i<end; i++) {
            translate += ted_info[i]["chn"];
        }
        $("#section_translate_content").html(translate);
        $("#section_translate").slideDown(500);
    });
}

function get_second_from_time(time) { // 00:05:12 => 312
    var times = time.split(":");
    return (parseInt(times[0]) * 3600 + parseInt(times[1] * 60 + parseInt(times[2])));
}

function check_play_icon() {
    if(video.paused) {
        play_control.removeClass("fa-pause");
        play_control.addClass("fa-play");
    } else {
        play_control.removeClass("fa-play");
        play_control.addClass("fa-pause");
    }
}

function video_play_pause() {
    if(video.paused) {
        video.play();
    } else {
        video.pause();
    }
}

function section_translate_close(self) {
    $(self).parent().slideUp(500);
}