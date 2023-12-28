//const { data } = require("autoprefixer");

$(document).ready(function() {
    //Check admin password is correct or not
    $("#current_password").keyup(function() {

        var current_password = $("#current_password").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/check-admin-password',
            data: {current_password:current_password},
            success: function(resp) {
                //alert(resp);
                if(resp == "false") {
                    $("#check_password").html("<font color=red>Current Password is incorrect</font>");
                } else if(resp == "true") {
                    $("#check_password").html("<font color=green>Current Password is correct</font>");
                }
            }, error: function() {
                alert("Error");
            }
        });
    });

    // Update Admins Status

    $(document).on("click", ".updateAdminStatus", function(){
        var status = $(this).children("i").attr("status");
        var admin_id = $(this).attr("admin_id");
        //alert(admin_id)
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url: '/admin/update-admin-status',
            data:{status:status, admin_id:admin_id},
            success:function(response){
                //alert(response);
                if(response['status'] == 0){
                    $("#admin-"+admin_id).html("<i style='font-size: 2em; color: red;' class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }else if(response['status'] == 1){
                    $("#admin-"+admin_id).html("<i style='font-size: 2em; color: green;' class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },
            error:function(){
                alert("Error")
            }
        });

    })
});
