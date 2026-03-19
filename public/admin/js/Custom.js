$(document).ready(function () {
        $("#current_pwd").keyup(function () {
                var current_pwd = $("#current_pwd").val();
                    if (!current_pwd) {
                        $("#verifyPwd").html("");
                        return;
                    }
                    $.ajax({
                        headers:{
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        },
                        type:'post',
                        url:'/admin/verify-password',
                        data:{current_pwd:current_pwd},
                        success:function (resp){
                                if (resp == false){
                                    $("#verifyPwd").html("<font color='red'>Current Password is Incorrect</font>");
                                }else if (resp == true){
                                    $("#verifyPwd").html("<font color='green'>Current Password is correct</font>");
                                }
                            },
                            error:function (){
                                alert("Error");
                            }
                    });
        });

        $(document).on('click','#deleteProfileImage',function (){
            if (confirm("Are you sure you want to remove your Profile Image ?")){
                var admin_id = $(this).data('admin-id');
                $.ajax({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'post',
                    url:'/admin/delete-details',
                    data:{admin_id:admin_id},
                    success:function (resp){
                        if (resp && resp.status === true){
                            alert(resp.message);
                            $('#profileImageBlock').remove();
                        } else if (resp && resp.message) {
                            alert(resp.message);
                        } else {
                            alert("Error Occurred while deleting the image.");
                        }
                    },error:function (){
                        alert("Error Occurred while deleting the image.");
                    }
                });
            }
        });


    //update subadmin status

    $(document).on("click",".updateSubadminStatus",function ()
    {
        var status = $(this).children("i").data("status");
        var subadmin_id = $(this).data("subadmin_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-subadmin-status',
            data: {status: status, subadmin_id: subadmin_id},
            success: function (resp) {
                if (resp['status'] == 0) {
                    $("a[data-subadmin_id='" + subadmin_id + "']").html("<i class='fas fa-toggle-off' style='color: gray' data-status='Inactive'></i>");
                } else if (resp['status'] == 1) {
                    $("a[data-subadmin_id='" + subadmin_id + "']").html("<i class='fas fa-toggle-on' style='color: #3f6ed3' data-status='Active'></i>");

                }
            }
            , error: function () {
                alert("Error Occurred while updating the status.");
            }

        });
    });
});
