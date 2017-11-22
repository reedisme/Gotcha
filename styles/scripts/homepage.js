$(document).ready(function () {
    scroll();
//    $( "#bubble" ).animate({
//        marginTop:"1000px",
//    }, 10000, function() {
//        // Animation complete.
//    });
});

function scroll() {
    var elem  = "#b".concat(Math.floor((Math.random() * 5) + 1));
    $(elem).css("marginTop", "-1000px");
    $(elem).animate({marginTop:"1000px",}, 10000, scroll);
}
