var word_times = null;
var sentence_times = null;
var click_count = 0;
var click_word = "";

function get_ted_info_html() {
    var ted_html = "";
    var is_new_p = true;
    for (var i = 0; i < ted_info.length; i++) {
        if (is_new_p) {
            ted_html += "<p class='section mb-2' index='" + i + "'><i class='fa fa-play-circle mr-2'></i>";
            is_new_p = false;
        }
        if (ted_info[i].eng[0] == "(") {
            is_new_p = true;
            ted_html += "<i class='fa fa-file ml-2'></i></p>";
            ted_html += "<p class='section mb-2' index='" + i + "'><i class='fa fa-play-circle mr-2'></i>";
            ted_html += " " + ted_info[i].eng;
            ted_html += "</p>";
            continue;
        }
        ted_html += " <span class='sentence' index='" + i + "'>" + get_query_sentence_from_normal(ted_info[i].eng) + "</span>";
    }
    $("#subtitle_info").html(ted_html);

    // $(".section .sentence").click(function () {
    //     var index = $(this).attr("index");
    //     video.currentTime = get_second_from_time(ted_info[index].start);
    //     video.play();
    // });

    regist_word_translate(top.set_explain_word, top.query_word_callback);
}

function get_second_from_time(time) { // 00:05:12 => 312
    var times = time.split(":");
    return (parseInt(times[0]) * 3600 + parseInt(times[1] * 60 + parseInt(times[2])));
}