// 有禁则的都返回true，返回false表示没有禁则
var conflict = {
    valueIsNull: function (_this) {
        return !$.trim($(_this).val());

    },
    valueNotSame: function (_this) {
        var field_name = $(_this).attr("field_name");
        var value = "";
        var hasConflict = false;
        $.each($("." + _this.query_class_name + "[field_name='" + field_name + "']"), function (idx, itm) {
            if (idx === 0) {
                value = $(itm).val();
            } else {
                if (value !== $(itm).val()) {
                    hasConflict = true;
                    return false; // 这里不是返回，而是跳出循环
                }
            }
        });
        return hasConflict;
    },
    alreadyExist: function (_this) {
        var hasError = false;
        var field_name = $(_this).attr("field_name");
        var table_name = $(_this).attr("table_name");
        var value = $(_this).val();
        var sql = "select * from " + table_name + " where " + field_name + "='" + value + "'";
        var data = {"type": "query_sql_get_data", "sql": sql};
        $.ajax({
            type: "post",
            url: "../common_logic.php",
            data: data,
            async: false,
            success: function (result) {
                var data_list = eval("(" + result + ")");
                hasError = (data_list.length > 0);
            }
        });
        return hasError;
    },
    notExist: function (_this) {
        var hasError = false;
        var field_name = $(_this).attr("field_name");
        var table_name = $(_this).attr("table_name");
        var value = $(_this).val();
        var sql = "select * from " + table_name + " where " + field_name + "='" + value + "'";
        var data = {"type": "query_sql_get_data", "sql": sql};
        $.ajax({
            type: "post",
            url: "../common_logic.php",
            data: data,
            async: false,
            success: function (result) {
                var data_list = eval("(" + result + ")");
                hasError = (data_list.length != 1);
            }
        });
        return hasError;
    },
    valueLengthTooLong: function (_this) {
        var limit_length = parseInt($(_this).attr("limit_length"));
        var value = $(_this).val();
        return value.length > limit_length;
    }
};
