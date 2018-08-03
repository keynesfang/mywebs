function create_menu_page() {
    var menu_page_html = "<div id='menu' style='position: fixed; top: 6px; right: 5px; border: 1px inset #fff; padding: 0 10px; border-radius: 5px; z-index: 999;' class='bg-dark'><i class='fa fa-tasks'></i> 菜 单</div>";
    menu_page_html += "<div id='pop_menu' style='position: fixed; top: 40px; right: 5px; padding: 10px; z-index: 999; border-radius: 5px; min-width: 230px; display: none;' class='bg-dark'>";
    menu_page_html += "<div style='position: fixed; top: 25px; right: 10px;' class='text-dark'><i class='fa fa-caret-up'></i></div>";
    menu_page_html += "<table class='w-100'>";
    var bg_color = "bg-primary ";
    var menu_icon = "fa-bookmark";
    var first_title = "";
    var first_link = ""
    $.each(menu_list, function (title, link) {
        if (first_title == "") {
            first_title = title;
            first_link = link;
        }
        if (link == "") {
            menu_icon = "fa-close";
        }
        menu_page_html += "<tr style='border: 1px solid #fff;' class='" + bg_color + "menu_btn' link='" + link + "'><td><i style='padding: 5px 10px;' class='fa " + menu_icon + "'></i> " + title + "</td></tr>";
        bg_color = "";
    });
    menu_page_html += "</table>";
    menu_page_html += "</div>";
    menu_page_html += "<div id='title' class='mb-1 p-2 d-flex text-white' style='position:relative; box-shadow: 0 2px 50px #000; z-index: 998;'>" + first_title + "</div>";
    menu_page_html += "<iframe id='sub_content' class='w-100 border-0 m-0' src='" + first_link + "'></iframe>";
    $("#sub_body").html(menu_page_html);

    top.set_height();

    $("#menu").click(function () {
        $("#pop_menu").toggle(200);
    });

    $(".menu_btn").click(function () {
        var link = $(this).attr("link");
        if (link) {
            $(".menu_btn").removeClass("bg-primary");
            $(this).addClass("bg-primary");
            $("#sub_content").attr("src", link);
            $("#title").text($(this).text());
        }
        $('#pop_menu').toggle(200);
    });
}