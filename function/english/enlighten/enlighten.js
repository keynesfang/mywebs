function init_enlighten_page() {
    var html = "";
    $.each(enlighten_info, function (idx, itm) {
        var tab_id = "myTab" + idx;
        var id = "collapse_" + idx;
        var id_chn = "collapse_" + idx + "_chn";
        var id_eng = "collapse_" + idx + "_eng";
        var id_video = "collapse_" + idx + "_video";
        var id_video_content = "collapse_" + idx + "_video_content";
        html += "<div class='card border-0'>";
        html += "<div class='card-header' id='headingOne'>";
        html += "<h5 class='mb-0'>";
        html += "<button class='btn btn-link' data-toggle='collapse' data-target='#" + id + "' aria-expanded='true'>";
        html += itm.title;
        html += "</button>";
        html += "</h5>";
        html += "</div>";
        html += "<div id='" + id + "' class='collapse' aria-labelledby='headingOne' data-parent='#accordion'>";
        html += "<div class='card-body p-0'>";
        html += "<ul class='nav nav-tabs' id='" + tab_id + "' role='tablist'>";
        if (itm.title_eng != "") {
            html += "<li class='nav-item'>";
            html += "<a class='nav-link border-top-0 active' data-toggle='tab' href='#" + id_chn + "' role='tab' aria-selected='true'>中文</a>";
            html += "</li>";
            html += "<li class='nav-item'>";
            html += "<a class='nav-link border-top-0' data-toggle='tab' href='#" + id_eng + "' role='tab'  aria-selected='false'>英文</a>";
            html += "</li>";
        }
        if (typeof(itm.video_tab) != "undefined") {
            var action = "";
            if (typeof(itm.video_tab.callback) != "undefined") {
                action = "onclick='" + itm.video_tab.callback[0] + "(\"" + id_video_content + "\",\"" + itm.video_tab.callback[1] + "\", \"../video/resources/\", true, \"" + tab_id + "\");'";
            }
            html += "<li class='nav-item'>";
            html += "<a class='nav-link border-top-0' data-toggle='tab' href='#" + id_video + "' role='tab'  aria-selected='false' " + action + ">" + itm.video_tab.tab_name + "</a>";
            html += "</li>";
        }
        html += "</ul>";
        // tab start
        html += "<div class='tab-content'>";
        // tab 中文
        html += "<div class='tab-pane fade show active text-white' id='" + id_chn + "' role='tabpanel'>";
        html += "<div class='card border-0'>";
        html += "<div class='card-body bg-dark'>";
        html += "<h5 class='card-title chn_font_family'>" + itm.title + "</h5>";
        html += "<p class='card-text'>" + itm.chn + "</p>";
        html += "</div>";
        html += "</div>";
        html += "</div>";
        // tab 中文 end
        // tab 英文
        html += "<div class='tab-pane fade text-white' id='" + id_eng + "' role='tabpanel'>";
        html += "<div class='card border-0'>";
        html += "<div class='card-body bg-dark'>";
        html += "<h5 class='card-title'>" + itm.title_eng + "</h5>";
        html += "<p class='card-text'>" + itm.eng + "</p>";
        html += "</div>";
        html += "</div>";
        html += "</div>";
        // tab 英文 end
        // tab 视频
        if (typeof(itm.video_tab) != "undefined") {
            // tab other
            html += "<div class='tab-pane fade' id='" + id_video + "' role='tabpanel'>";
            html += "<div class='card border-0'>";
            html += "<div class='card-body p-0 w-100' id='" + id_video_content + "'>";
            html += "</div>";
            html += "</div>";
            html += "</div>";
            // tab other end
        }
        // tab 视频 end
        html += "</div>";
        // tab end
        html += "</div>";
        html += "</div>";
        html += "</div>";
    });
    $("#accordion").html(html);
}

var enlighten_course = ["初识字母表", "字母发音启蒙", "单词是怎么形成的", "初识元音与辅音", "长元音与短元音", "第6元音字母'Y'", "元音规则第1条", "元音规则第2条", "元音规则第3条", "元音规则第4条", "元音规则第5条", "元音规则第6条", "元音规则第7条", "混合字母"];

function init_enlighten_study_page() {
    var enlighten_study_nav_html = "" +
        "<ol class='breadcrumb'>" +
        "<li class='breadcrumb-item active'>英语启蒙</li>" +
        "<li class='breadcrumb-item'><a href='./enlighten.php'>预备</a></li>" +
        "<li class='breadcrumb-item active' aria-current='page'>开始</li>" +
        "</ol>";
    $("#enlighten_study_nav").html(enlighten_study_nav_html);
    var enlighten_header_html = "" +
        "<nav style='overflow: scroll;'>" +
        "<ul class='pagination'>";
    for (var i = 1; i <= enlighten_course.length; i++) {
        if (i == enlighten_course_index) {
            enlighten_header_html += "<li class='page-item active'><a class='page-link' style='padding: .1rem .5rem;' href='#'>" + i + "</a></li>";
        } else {
            enlighten_header_html += "<li class='page-item'><a class='page-link' style='padding: .1rem .75rem;' href='./enlighten_study_" + i + ".php'>" + i + "</a></li>";
        }
    }
    enlighten_header_html += "</ul>" +
        "</nav>" +
        "<h5>" + enlighten_course[enlighten_course_index - 1] + " <span class='badge badge-secondary mb-2'>第 " + enlighten_course_index + " 课</span></h5>";
    var enlighten_tab_html = "<ul class='nav nav-tabs' id='myTab' role='tablist'>";
    var enlighten_tab_content_html = "<div class='tab-content'>";
    $.each(enlighten_info_detail, function (idx, itm) {
        var action = "";
        var show_style = "text-white bg-dark py-3 px-2";
        if (typeof(itm.onclick_html) != "undefined") {
            action = " onclick='" + itm.onclick_html + "'";
        }
        if (itm.tab_name == "视频") {
            show_style = "";
        }
        enlighten_tab_html += "<li class='nav-item'>";
        if (idx == 0) {
            enlighten_tab_html += "<a class='nav-link active' data-toggle='tab' href='#" + itm.tab_id + "' role='tab' aria-selected='true' " + action + ">" + itm.tab_name + "</a>";
            enlighten_tab_content_html += "<div class='tab-pane fade show active " + show_style + "' id='" + itm.tab_id + "' role='tabpanel'>";
        } else {
            enlighten_tab_html += "<a class='nav-link' data-toggle='tab' href='#" + itm.tab_id + "' role='tab' aria-selected='false' " + action + ">" + itm.tab_name + "</a>";
            enlighten_tab_content_html += "<div class='tab-pane fade " + show_style + "' id='" + itm.tab_id + "' role='tabpanel'>";
        }
        // enlighten_tab_content_html += itm.content_html;
        enlighten_tab_content_html += "</div>";
        enlighten_tab_html += "</li>";
    });
    enlighten_tab_content_html += "</div>";
    enlighten_tab_html += "</ul>";
    enlighten_header_html += enlighten_tab_html + enlighten_tab_content_html;
    $("#page_content").html(enlighten_header_html);
}