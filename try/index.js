var controls = {
    header: undefined,
    menu_package: undefined,
    tab_package: undefined
};

var widgets = {
    menu: {
        default_func_valid: true,
        common_func: function () {
            console.log("menu common function");
        },
        menu_list: [
            {
                menu_name: "菜单一",
                sub_menu_list: [
                    {
                        sub_menu_name: "子菜单一",
                        sub_menu_func: "sub_menu_func"
                    }, "子菜单二", "子菜单三", "子菜单四", "子菜单五"]
            },
            {
                menu_name: "菜单二",
                sub_menu_list: ["子菜单一", "子菜单二", "子菜单三", "子菜单四", "子菜单五"]
            },
            {
                menu_name: "菜单三",
                sub_menu_list: ["子菜单一", "子菜单二", "子菜单三", "子菜单四", "子菜单五"]
            },
            {
                menu_name: "菜单四",
                sub_menu_list: ["子菜单一", "子菜单二", "子菜单三", "子菜单四", "子菜单五"]
            }
        ]
    }
};

function addTab() {
    var tabs = $("#tabs");
    var tabTemplate = "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close' role='presentation'>Remove Tab</span></li>";
    var label = "abc",
        id = "tabs-2x",
        li = $( tabTemplate.replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) ),
        tabContentHtml = "lkdjasldkjf";

    tabs.find( ".ui-tabs-nav" ).append( li );
    tabs.append( "<div id='" + id + "'><p>" + tabContentHtml + "</p></div>" );
    tabs.tabs( "refresh" );
}

function sub_menu_func() {
    console.log("sub menu click!");
    addTab();
}

$(function () {
    menu_init(widgets.menu, "menu_package", "test_menu");
    control_assign();
    control_size_adjust();
    $("#tabs").tabs();
    $(window).resize(function () {
        control_size_adjust();
    });
    var tabs = $("#tabs");
    tabs.on( "click", "span.ui-icon-close", function() {
        var panelId = $( this ).closest( "li" ).remove().attr( "aria-controls" );
        $( "#" + panelId ).remove();
        tabs.tabs( "refresh" );
    });

    tabs.on( "keyup", function( event ) {
        if ( event.altKey && event.keyCode === $.ui.keyCode.BACKSPACE ) {
            var panelId = tabs.find( ".ui-tabs-active" ).remove().attr( "aria-controls" );
            $( "#" + panelId ).remove();
            tabs.tabs( "refresh" );
        }
    });
});

function control_assign() {
    $.each(controls, function (id, control) {
        controls[id] = $("#" + id);
    });
}

function control_size_adjust() {
    var document_height = document.documentElement.clientHeight;
    // menu_package
    controls.menu_package.css("height", document_height - controls.header.height() - 10);
    // tab_package
    controls.tab_package
        .css("left", controls.menu_package.outerWidth(true))
        .css("top", controls.header.height())
        .css("height", controls.menu_package.height());
}
