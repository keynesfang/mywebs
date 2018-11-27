var widget_menu = {
    init: function (menu_struct, parent_id, id) {
                var parent = $("#" + parent_id);
        var html = "<div id='" + id + "'>";
        $.each(menu_struct.menu_list, function (idx, itm) {
            html += "<h3>" + itm.menu_name + "</h3>";
            html += "<div>";
            html += "<ul class='sub_menu'>";
            $.each(itm.sub_menu_list, function (sub_idx, sub_itm) {
                if (typeof(sub_itm) == "string") {
                    html += "<li><div><span class='ui-icon ui-icon-battery-3'></span>" + sub_itm + "</div></li>";
                } else if (typeof(sub_itm) == "object") {
                    html += "<li func='" + sub_itm.sub_menu_func + "'><div><span class='ui-icon ui-icon-battery-3'></span>" + sub_itm.sub_menu_name + "</div></li>";
                }
            });
            html += "</ul></div>";
        });
        html += "</div>";
        parent.html(html);

        $("#" + id).accordion({
            collapsible: true,
            heightStyle: "content"
        });

        $(".sub_menu").menu({
            select: function (event, ui) {
                var selected_menu_item = $(ui.item[0]);
                if (menu_struct.default_func_valid) {
                    $(".ui-menu-item").removeClass("menu_selected");
                    selected_menu_item.addClass("menu_selected");
                }
                if (typeof(menu_struct.common_func) == "function") {
                    menu_struct.common_func();
                }
                if (typeof(eval(selected_menu_item.attr("func"))) == "function") {
                    eval(selected_menu_item.attr("func"))();
                }
            }
        });
    }
};