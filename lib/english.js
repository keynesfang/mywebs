// 输入一个正常英文句子，返回一个可查单词的英文句子
function get_query_sentence_from_normal(sentence) {
    var reg = new RegExp(/([a-zA-Z]+)/g);
    var query_sentence = sentence.replace(reg, "<query>$1</query>");
    return query_sentence;
}
