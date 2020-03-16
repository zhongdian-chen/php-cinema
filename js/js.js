$(".btn-gp").find("button").hover(function () {
    $(this).addClass("btn-active");
}, function () {
    $(this).removeClass("btn-active")
});

$(".btn").on("click",function () {
    $(this).addClass("actively");
    $(this).siblings().removeClass("actively")
    $(this).siblings().removeClass("btn-active")
});

