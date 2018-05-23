function vote_data_get(voteId) {
    var sql = "select * from g_vote where id='" + voteId + "'";
    $.post("/function/common_logic.php", {
        type: "query_sql_get_data2",
        sql: sql
    }, function (data) {
        var voteInfo = eval("(" + data + ")");
        voteInfo = voteInfo[0];
        $("#s1").html(voteInfo["s1"]);
        $("#s2").html(voteInfo["s2"]);
        $("#s3").html(voteInfo["s3"]);
        $("#s4").html(voteInfo["s4"]);
    });
}

function add_vote(voteId, fieldName) {
    var condition = "id='" + voteId + "'";
    $.post("/function/common_logic.php", {
        type: "field_value_add_by_num",
        tableName: "g_vote",
        fieldName: fieldName,
        num: 1,
        condition: condition
    }, function () {
        var vote = $("#" + fieldName);
        vote.html(parseInt(vote.html()) + 1);
    });
}