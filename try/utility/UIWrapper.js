var widget_tabs = {
    tabs_obj: undefined,
    init: function (obj) {
        // 根据生成tabs对象，生成HTML
        widget_tabs.tabs_obj = obj;
        var id = obj.id;
        var parent_id = obj.parent_id;
        var parent = $("#" + parent_id);
        var html = "<div id='" + id + "'>";
        var tabs_header_html = "<ul>";
        var tabs_body_html = "";
        $.each(obj.tab_list, function (idx, itm) {
            var tab_id = "tab_" + idx;
            tabs_header_html += "<li><a href='#" + tab_id + "'>" + itm.tab_name + "</a>";
            var btn_html = "";
            if (typeof(itm.close_btn) && itm.close_btn) {
                btn_html = " <span class='ui-icon ui-icon-close' role='presentation'>Remove Tab</span>";
            }
            tabs_header_html += btn_html + "</li>";
            tabs_body_html += "<div id='" + tab_id + "'>";
            tabs_body_html += "<p>" + tab_id + "</p>";
            tabs_body_html += "</div>";
        });
        tabs_header_html += "</ul>";
        html += tabs_header_html + tabs_body_html + "</div>";
        parent.html(html);

        // 初始化Tabs控件
        $("#" + id).tabs();
    }
};

var widget_menu = {
    menu_obj: undefined,
    init: function (obj) {
        // 根据生成Menu对象，生成HTML
        widget_menu.menu_obj = obj;
        var id = obj.id;
        var parent_id = obj.parent_id;
        var parent = $("#" + parent_id);
        var html = "<div id='" + id + "'>";
        $.each(obj.menu_list, function (idx, itm) {
            html += "<h3>" + itm.menu_name + "</h3>";
            html += "<div>";
            html += "<ul class='sub_menu'>";
            $.each(itm.sub_menu_list, function (sub_idx, sub_itm) {
                if (typeof(sub_itm) == "string") {
                    html += "<li><div><span class='ui-icon ui-icon-battery-3'></span>" + sub_itm + "</div></li>";
                } else if (typeof(sub_itm) == "object") {
                    html += "<li func='" + sub_itm.sub_menu_click_func + "'><div><span class='ui-icon ui-icon-battery-3'></span>" + sub_itm.sub_menu_name + "</div></li>";
                }
            });
            html += "</ul></div>";
        });
        html += "</div>";
        parent.html(html);
        // 初始化手风琴控件
        $("#" + id).accordion({
            collapsible: true,
            heightStyle: "content"
        });
        // 初始化菜单控件
        $(".sub_menu").menu({
            select: widget_menu.menu_click
        });
    },

    menu_click: function (event, ui) {
        // 每个菜单的默认执行方法
        var selected_menu_item = $(ui.item[0]);
        if (widget_menu.menu_obj.default_func_valid) {
            $(".ui-menu-item").removeClass("menu_selected");
            selected_menu_item.addClass("menu_selected");
        }
        // Menu对象中定义的菜单共通方法
        if (typeof(widget_menu.menu_obj.click_func) == "function") {
            widget_menu.menu_obj.click_func();
        }
        // Menu对象中每个子项定义的单击方法
        if (typeof(eval(selected_menu_item.attr("func"))) == "function") {
            eval(selected_menu_item.attr("func"))();
        }
    }
};