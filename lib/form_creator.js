function get_input_form_html(form_data) {
    var html = "<div class='modal-dialog' role='document'><div class='modal-content'><div class='modal-header'>";
    html += "<h5 class='modal-title'>" + form_data.title + " <span class='badge badge-secondary'>" + form_data.sub_title + "</span></h5>";
    html += "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    html += "<div class='modal-body'>";
    $.each(form_data.fields, function (field_name, field_info) {
        field_name = field_name.split("$")[0]; // 这一步的目的是像重复密码测试时，第二个的field_name与前一个是相同的，但结尾多了一个$符号。
        html += "<div class='form-group'>";
        if (field_info.chn) {
            html += "<label>" + field_info.chn + "</label>";
        }
        var input_type = "<input type='" + field_info.type + "'";
        var select_options_html = "";
        if (field_info.type == "select") {
            input_type = "<select";
            $.each(field_info.options.split(","), function (idx, val) {
                select_options_html += "<option value='" + val + "'>" + val + "</option>";
            });
            select_options_html += "</select>";
        }
        html += input_type + " class='form-control " + form_data.form_class + "' field_name='" + field_name + "'";
        $.each(field_info.attributes, function (attr_name, attr_value) {
            html += " " + attr_name + "='" + attr_value + "'";
        });
        html += ">";
        html += select_options_html;
        html += "<div class='invalid-feedback'></div>";
        html += "</div>";
    });
    html += "</div>";
    html += "<div class='modal-footer'><span class='text-danger none-display form_error_message'>" + form_data.error_message + "</span>";
    html += "<button type='button' class='btn btn-primary' onclick='" + form_data.button.action + "(\"" + form_data.table_name + "\"," + " conflict_check(\"" + form_data.form_class + "\"), " + form_data.button.callback + ");'>" + form_data.button.chn + "</button>";
    html += "<button type='button' class='btn btn-secondary' data-dismiss='modal'>返回</button>";
    html += "</div></div></div>";
    $("#formModal").html(html);
}

function get_confirm_form_html(title, content, exe_func, func_arguments) {
    var arguments = "";
    if (typeof(func_arguments) == "string") {
        arguments = func_arguments;
    } else {
        arguments = "";
    }
    var html = "";
    html += "<div class='modal-dialog' role='document'>";
    html += "<div class='modal-content'>";
    html += "<div class='modal-header'>";
    html += "<h5 class='modal-title'>" + title + "</h5>";
    html += "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    html += "<span aria-hidden='true'>&times;</span>";
    html += "</button>";
    html += "</div>";
    html += "<div class='modal-body'>";
    html += "<p>" + content + "</p>";
    html += "</div>";
    html += "<div class='modal-footer'>";
    html += "<button type='button' class='btn btn-primary' onclick='" + exe_func + "(\"" + arguments + "\");'>确定</button>";
    html += "<button type='button' class='btn btn-secondary' data-dismiss='modal'>返回</button>";
    html += "</div>";
    html += "</div>";
    html += "</div>";
    $("#formModal").html(html);
}


function get_notify_form_html(title, content) {
    var html = "";
    html += "<div class='modal-dialog' role='document'>";
    html += "<div class='modal-content'>";
    html += "<div class='modal-header'>";
    html += "<h5 class='modal-title text-danger'>" + title + "</h5>";
    html += "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    html += "<span aria-hidden='true'>&times;</span>";
    html += "</button>";
    html += "</div>";
    html += "<div class='modal-body'>";
    html += "<p>" + content + "</p>";
    html += "</div>";
    html += "<div class='modal-footer'>";
    html += "<button type='button' class='btn btn-secondary' data-dismiss='modal'>返回</button>";
    html += "</div>";
    html += "</div>";
    html += "</div>";
    $("#formModal").html(html);
}