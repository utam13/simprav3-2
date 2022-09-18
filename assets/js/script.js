const serverloc = "http://"+window.location.hostname+":8080/simpra_v3.2";

jQuery.ajaxSetup({
    cache: false
});

//tampilkan loading indikator
$(document).ajaxStart(function () {
    $("#preloader").css("display", "block");
});

$(document).ajaxComplete(function () {
    $("#preloader").css("display", "none");
});

$(document).on('click','.table tbody tr', function(event) {
    console.log('pilih baris');
    if($(".table tbody tr").hasClass('pilih_baris')){
        $(".table tbody tr").removeClass('pilih_baris');
    } else {
        $(this).addClass('pilih_baris');
    }
    
});

$('.pop').popover({
    trigger: "manual",
    html: true,
    content: function() {
        return $('#popover-content').html();
    }
})
.on("mouseenter", function() {
    var _this = this;
    $(this).popover("show");
    $(".popover").on("mouseleave", function() {
        $(_this).popover('hide');
    });
})
    .on("mouseleave", function() {
    var _this = this;
    setTimeout(function() {
        if (!$(".popover:hover").length) {
        $(_this).popover("hide");
        }
    }, 300);
});