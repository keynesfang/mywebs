// 以下函数用于页面表单的各种操作

// 检查各字段是否存在禁则
// query_class_name: 控件所包含的class名
function conflict_check(query_class_name) {
    var hasError = false;
    var dataArr = {};
    // 遍历所有含有参数【query_class_name】所对应的class名的控件；
    $.each($("." + query_class_name), function (idx, itm) {
        var _this = this;
        _this.query_class_name = query_class_name;
        var conflictStr = $(itm).attr("conflict");
        if (typeof(conflictStr) != "undefined" && conflictStr != "") {
            var hasConflict = false;
            var conflictArr = conflictStr.split(",");
            // 遍历当前控件中所要检查的禁则组；
            $.each(conflictArr, function (idx2, conflict_name) {
                if (conflict[conflict_name](_this)) {
                    $(_this).addClass("is-invalid");
                    var invalid_feedback_list = $(_this).attr("invalid_feedback").split("_");
                    $(_this).siblings(".invalid-feedback").text(invalid_feedback_list[idx2]);
                    hasConflict = true;
                    hasError = true;
                    return false; // 跳出当前循环
                }
            });
            if (!hasConflict) {
                $(_this).removeClass("is-invalid");
            }
        }
        var field_name = $(itm).attr("field_name");
        var input_type = $(itm).attr("type");
        var input_value = $(itm).val();
        if (input_type === "password") {
            input_value = $.md5(input_value);
        }
        dataArr[field_name] = $.trim(input_value);
    });
    if (hasError) {
        dataArr = "";
    }
    return dataArr;
}

// 登陆操作
function login(table_name, fields_value_array, callback) {
    if (fields_value_array) {
        var sql = "select * from " + table_name + " where 1=1";
        $.each(fields_value_array, function (field_name, field_value) {
            sql += " and " + field_name + "='" + field_value + "'";
        });
        $.post("../common_logic.php", {
            type: "query_sql_get_data",
            sql: sql
        }, function (result) {
            var data_list = eval("(" + result + ")");
            if (typeof(callback) == "function") {
                callback((data_list.length == 1), data_list); // 登陆成功返回true。
            }
        });
    }
}

// 向数据库插入数据
function insertDataToDB(table_name, fields_value_array, callback) {
    if (fields_value_array) {
        $.post("/function/common_logic.php", {
            type: "add_record_to_database",
            tableName: table_name,
            fields_value_array: fields_value_array
        }, function (result) {
            if (typeof(callback) == "function") {
                callback(!isNaN(result), result); // 插入成功返回true。 result为新插入数据的ID
            }
        });
    }
}