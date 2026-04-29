$(()=>{
    $(".footer_container div").click(function(){
        $(".footer_container div").removeClass("active");
        $(this).addClass("active");
    });
});
