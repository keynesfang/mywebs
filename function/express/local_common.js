function init_title() {
    $(".content_status").hide();
    $(".title").click(function () {
        $(this).next().toggle(100);
    });
}