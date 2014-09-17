function blockUI(message) {
    $.blockUI({
        message: '<h3 style="font-size:13px"> ' + message + '</h3>',
        css : {
            'border-radius' : '10px',
            'border' : '1px solid gray',
            'padding' : '10px',
            width:          '70%', 
            top:            '40%', 
            left:           '15%'
        }
    });
}
function resetErrorMessage() {
    $("form label.error").text('');
    $(".error_message").html("");
    $("form input.error,form select.error").removeClass("error");
}
$(document).ready(function (){
    $("#wrapper").css("min-height",$(window).height() - 2);
});
