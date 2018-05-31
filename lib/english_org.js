// 输入一个正常英文句子，返回一个可查单词的英文句子
function get_query_sentence_from_normal(sentence) {
    var reg = new RegExp(/([a-zA-Z]+)/g);
    var query_sentence = sentence.replace(reg, "<query>$1</query>");
    return query_sentence;
}

function regist_word_translate(job, callback) {
    $("query").click(function () {
        var word = $(this).html();
        if (typeof(job) == "function") {
            word = job(word);
        }
        query_word(word, callback);
    });
}

function query_word(word, callback) {
    $.post("/function/common_logic.php", {
        type: "eng_word_translate",
        word: word
    }, function (data) {
        var word_info = {};
        var word_translate = eval("(" + data + ")");
        var basic_translate = word_translate["basic"];
        var us_phonetic = "";
        var uk_phonetic = "";
        var explains = "";
        var phonetic = "";
        if (basic_translate) {
            us_phonetic = basic_translate["us-phonetic"];
            uk_phonetic = basic_translate["uk-phonetic"];
            explains = basic_translate["explains"];
            if (us_phonetic) {
                phonetic += "<span>美 [" + us_phonetic + "]</span>";
            }
            if (uk_phonetic) {
                phonetic += "<span class='ml-2'>英 [" + uk_phonetic + "]</span>";
            }
        } else if (word_translate.translation) {
            explains = word_translate.translation;
        } else {
            explains = ["未查到该词翻译！"];
        }
        word_info.phonetic = phonetic;
        word_info.explains = explains;
        if (typeof(callback) == "function") {
            callback(word_info);
        }
    });
}

function play_voice() {
    var url = "https://tts.yeshj.com/s/" + $("#word_sound").attr("word");
    $("#play_sound").attr("src", url);
    $("#play_sound")[0].play();
}
