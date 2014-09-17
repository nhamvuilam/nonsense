var loggedObject = {
    isShowNotification : false,
    notify : function() {
        $.ajax({
            type: 'GET',
            cache: false,
            async: false,
            url: "/user/notify",
            success: function(response) {
                if(response['error_code'] == '0') {//success
                    if(response['num_new'] > 0) {
                        $("#notifications").html('<span>'+response['num_new']+'</span>');
                    }
                    setTimeout("loggedObject.notify()",10000);
                } else if (response['error_code'] == -10) { //redirect
                    location.href = response['data'];
                }
            }
        });
    },
    init : function () {
        loggedObject.notify();
        $("#notifications").bind("click",function () {
            if(loggedObject.isShowNotification) {
                $("#detail_notifications").hide();
                loggedObject.isShowNotification = false;
                return;
            }
            $(this).html("");
            $("#detail_notifications").html('Loading...').show();
            loggedObject.isShowNotification = true;
            $.ajax({
                type: 'GET',
                cache: false,
                async: false,
                url: "/user/get-notifications",
                success: function(response) {
                    $("#detail_notifications").html('');
                    if(response['error_code'] == '0') {//success
                        $.each(response['data'],function () {
                            var temp = "tmpl-message";
                            if(this.type == 101) {
                                temp = "tmpl-notification";
                            }
                            $("#detail_notifications").append(tmpl(temp,this));
                        });
                    } else if (response['error_code'] == -10) { //redirect
                        location.href = response['data'];
                    }
                }
            });
        });
        /*$("html").click(function (){
            if(loggedObject.isShowNotification) {
                $("#detail_notifications").hide();
                loggedObject.isShowNotification = false;
            }
        });*/
        $(document).on("click", "#detail_notifications .row .buttons span", function () {
            var value = $(this).attr("data-ref-value");
            var id = $(this).attr("data-ref-id");
            var type = $(this).attr("data-ref-type");
            blockUI("Please wait...");
            $.ajax({
                type: 'GET',
                cache: false,
                async: false,
                url: "/user/notification-action?id="+id+"&act="+value+"&type="+type,
                success: function(response) {
                    $.unblockUI();
                    if(response['error_code'] == '0') {//success
                        if(response['data'] == '') {
                            location.reload();
                        } else {
                            location.href = response['data'];
                        }
                    } else if (response['error_code'] == -10) { //redirect
                        location.href = response['data'];
                    }
                }
            });
        });
    }
};
$(document).ready(function (){
   loggedObject.init(); 
});