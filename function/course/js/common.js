$(function () {
   $("p").click(function () {
       $("p").removeClass("mark");
       $(this).addClass("mark");
   });
});