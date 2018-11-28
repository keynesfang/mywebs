var widget_tabs = {
    tabs_obj: undefined,
    tabs: undefined,
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
            if (typeof(itm.close_btn) && itm.close_btn) {
                tabs_header_html += widget_tabs.gen_tab_header_html(tab_id, itm.tab_name, true);
            } else {
                tabs_header_html += widget_tabs.gen_tab_header_html(tab_id, itm.tab_name, false);
            }
            tabs_body_html += widget_tabs.gen_tab_body_html(tab_id);
            obj.tab_list[idx].tab_id = tab_id;
        });
        tabs_header_html += "</ul>";
        html += tabs_header_html + tabs_body_html + "</div>";
        parent.html(html);

        // 初始化Tabs控件
        widget_tabs.tabs = $("#" + id);
        widget_tabs.tabs.tabs();
    },

    gen_tab_header_html: function (tab_id, tab_name, closeable) {
        console.log(widget_tabs.tabs_obj);
        var is_tab_exist = false;
        $.each(widget_tabs.tabs_obj.tab_list, function (idx, itm) {
            var exist_tab_id = itm.tab_id || "";
            if(exist_tab_id == tab_id) {
                is_tab_exist = true;
                return false;
            }
        });
        // 如果页面已存在，则不创建。
        if(is_tab_exist) {
            return false;
        }

        var html = "<li><a href='#" + tab_id + "'>" + tab_name + "</a>";
        if (closeable) {
            html += " <span class='ui-icon ui-icon-close' role='presentation'></span>";
        }
        html += "</li>";
        return html;
    },

    gen_tab_body_html: function (tab_id) {
        var html = "<div id='" + tab_id + "'>";
        html += "<p>" + tab_id + "</p>";
        html += "</div>";
        return html;
    },

    addTab: function (tab_header, tab_body) {
        widget_tabs.tabs.find(".ui-tabs-nav").append(tab_header);
        widget_tabs.tabs.append(tab_body);
        widget_tabs.tabs.tabs("refresh");
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
                var menu_id = idx + "_" + sub_idx;
                if (typeof(sub_itm) == "string") {
                    html += "<li><div><span class='ui-icon ui-icon-battery-3'></span>" + sub_itm + "</div></li>";
                } else if (typeof(sub_itm) == "object") {
                    html += "<li menuid='menu" + menu_id + "' func='" + sub_itm.sub_menu_click_func + "'><div><span class='ui-icon ui-icon-battery-3'></span>" + sub_itm.sub_menu_name + "</div></li>";
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
        if (widget_menu.menu_obj.default_click_func_valid) {
            $(".ui-menu-item").removeClass("menu_selected");
            selected_menu_item.addClass("menu_selected");
        }
        // Menu对象中定义的菜单共通方法
        if (typeof(widget_menu.menu_obj.click_func) == "function") {
            widget_menu.menu_obj.click_func();
        }
        // Menu对象中每个子项定义的单击方法
        if (typeof(eval(selected_menu_item.attr("func"))) == "function") {
            var menu_id = selected_menu_item.attr("menuid");
            var menu_name = selected_menu_item.text();
            eval(selected_menu_item.attr("func"))(menu_id, menu_name);
        }
    }
};