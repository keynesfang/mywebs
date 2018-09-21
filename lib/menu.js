function create_menu_page() {
    var menu_page_html = "<div id='menu' style='position: fixed; top: 6px; right: 5px; border: 1px inset #fff; padding: 0 10px; border-radius: 5px; z-index: 999;' class='bg-dark'><i class='fa fa-tasks'></i> 菜 单</div>";
    menu_page_html += "<div id='pop_menu' style='position: fixed; top: 40px; padding: 10px; z-index: 999; border-radius: 5px; display: none; background: rgba(0,0,0,0.5);' class='h-100 w-100'>";
    menu_page_html += "<div style='position: fixed; top: 19px; right: 58px;'><i class='fa fa-caret-up fa-2x' style='color: rgba(0,0,0,0.5);'></i></div>";
    menu_page_html += "<div style='overflow-y: auto; width: 230px; float: right;' class='bg-dark'>";
    menu_page_html += "<table class='w-100'>";
    var bg_color = "bg-primary ";
    var menu_icon = "fa-bookmark";
    var first_title = "";
    var first_link = "";
    var index = 0;
    $.each(menu_list, function (title, link) {
        if (first_title == "") {
            first_title = title;
            first_link = link;
        }
        if (link == "") {
            menu_icon = "fa-close";
        }
        menu_page_html += "<tr id='" + index + "' style='border: 1px solid #fff;' class='" + bg_color + "menu_btn' link='" + link + "'><td><i style='padding: 5px 10px;' class='fa " + menu_icon + "'></i> " + title + "</td></tr>";
        bg_color = "";
        index++;
    });
    menu_page_html += "</table>";
    menu_page_html += "</div>";
    menu_page_html += "</div>";
    menu_page_html += "<div id='title' class='mb-1 p-2 d-flex text-white' style='position:relative; box-shadow: 0 2px 50px #000; z-index: 998;'>" + first_title + "&nbsp;<span id='subtitle' style='font-size: 10px;' class='text-warning pt-1'></span></div>";
    menu_page_html += "<iframe id='sub_content' class='w-100 border-0 m-0' src='" + first_link + "'></iframe>";
    $("#sub_body").html(menu_page_html);

    top.set_height();

    $("#menu").click(function () {
        if (typeof(before_menu_open) == "function") {
            before_menu_open();
        }
        $("#pop_menu").toggle(200);
        return false;
    });

    $(".menu_btn").click(function () {
        var temp_ele = $(this).children("td").children("i");
        if (temp_ele.hasClass("fa-lock")) {
            return false;
        }
        var link = $(this).attr("link");
        if (link) {
            $(".menu_btn").removeClass("bg-primary");
            $(this).addClass("bg-primary");
            $("#sub_content").attr("src", link);
            $("#title").html($(this).text() + "&nbsp;<span id='subtitle' style='font-size: 10px;' class='text-warning pt-1'></span>");
        }
        $('#pop_menu').toggle(200);
        return false;
    });

    $("#pop_menu").click(function () {
        $("#pop_menu").hide(200);
    });
}