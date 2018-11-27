var controls = {
    header: undefined,
    menu_package: undefined,
    tab_package: undefined,
    tabs: undefined
};

var widgets = {
    tabs: {
        id: "tabs",
        parent_id: "tab_package",
        tab_list: [
            {
                tab_name: "主页"
            },
            {
                tab_name: "子页",
                close_btn: true
            }
        ]
    },
    menu: {
        id: "test_menu",
        parent_id: "menu_package",
        default_func_valid: true,
        click_func: function () {
            console.log("menu common function");
        },
        menu_list: [
            {
                menu_name: "用户管理",
                sub_menu_list: ["用户一览", "新增用户", "权限设置"]
            },
            {
                menu_name: "菜单一",
                sub_menu_list: [
                    {
                        sub_menu_name: "子菜单一",
                        sub_menu_click_func: "sub_menu_click_func"
                    }, "子菜单二", "子菜单三", "子菜单四", "子菜单五"]
            },
            {
                menu_name: "菜单二",
                sub_menu_list: ["子菜单一", "子菜单二", "子菜单三", "子菜单四", "子菜单五"]
            },
            {
                menu_name: "菜单三",
                sub_menu_list: ["子菜单一", "子菜单二", "子菜单三", "子菜单四", "子菜单五"]
            }
        ]
    }
};

function addTab() {
    var tabTemplate = "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close' role='presentation'>Remove Tab</span></li>";
    var label = "abc",
        id = "tabs-2x",
        li = $(tabTemplate.replace(/#\{href\}/g, "#" + id).replace(/#\{label\}/g, label)),
        tabContentHtml = "lkdjasldkjf";

    controls.tabs.find(".ui-tabs-nav").append(li);
    controls.tabs.append("<div id='" + id + "'><p>" + tabContentHtml + "</p></div>");
    controls.tabs.tabs("refresh");
}

function sub_menu_click_func() {
    console.log("sub menu click!");
    addTab();
}

$(function () {
    init_widgets();
    $(window).resize(function () {
        control_size_adjust();
    });
    control_assign();
    control_size_adjust();
    var tabs = $("#tabs");
    tabs.on("click", "span.ui-icon-close", function () {
        var panelId = $(this).closest("li").remove().attr("aria-controls");
        $("#" + panelId).remove();
        tabs.tabs("refresh");
    });

    tabs.on("keyup", function (event) {
        if (event.altKey && event.keyCode === $.ui.keyCode.BACKSPACE) {
            var panelId = tabs.find(".ui-tabs-active").remove().attr("aria-controls");
            $("#" + panelId).remove();
            tabs.tabs("refresh");
        }
    });
});

function init_widgets() {
    $.each(widgets, function (widget) {
        if (typeof(eval("widget_" + widget)) == "object") {
            eval("widget_" + widget).init(widgets[widget]);
        }
    });
}

function control_assign() {
    $.each(controls, function (id) {
        controls[id] = $("#" + id);
    });
}

function control_size_adjust() {
    var document_width = document.documentElement.clientWidth;
    var document_height = document.documentElement.clientHeight;
    // menu_package
    controls.menu_package.css("height", document_height - controls.header.height() - 10);
    // tab_package
    controls.tab_package
        .css("left", controls.menu_package.outerWidth(true))
        .css("top", controls.header.height())
        .css("height", controls.menu_package.height())
        .css("width", document_width - controls.tab_package.position().left);
}
