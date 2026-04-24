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
        var status = $(this).data("status");
        var subadmin_id = $(this).data("subadmin_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-subadmin-status',
            data: {status: status, subadmin_id: subadmin_id},
            success: function (resp) {
                var $button = $(".updateSubadminStatus[data-subadmin_id='" + subadmin_id + "']");
                if (resp['status'] == 0) {
                    $button.data("status", "Inactive");
                    $button.removeClass("btn-outline-secondary").addClass("btn-success");
                    $button.text("Activate");
                } else if (resp['status'] == 1) {
                    $button.data("status", "Active");
                    $button.removeClass("btn-success").addClass("btn-outline-secondary");
                    $button.text("Deactivate");
                }
            }
            , error: function () {
                alert("Error Occurred while updating the status.");
            }

        });
    });
    $(document).on("click",".updateCategoryStatus",function (){
        var status =$(this).find("i").data("status");
        var category_id = $(this).data("category-id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-category-status',
            data:{status:status,category_id:category_id},
            success:function (resp){
                if (resp['status'] ==0){
                    $("a[data-category-id='"+category_id+"']").html("<i class='fas fa-toggle-off' style='color: gray' data-status='Inactive'></i>");

                }else if (resp['status'] ==1){
                    $("a[data-category-id='"+category_id+"']").html("<i class='fas fa-toggle-on' style='color: #3f6ed3' data-status='Active'></i>");

                }
            },
            error:function (){
                alert("Error");
            }
        })
    });

    $(document).on("click",".updateProductStatus",function (){
        var status =$(this).find("i").data("status");
        var product_id = $(this).data("product-id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-product-status',
            data:{status:status,product_id:product_id},
            success:function (resp){
                if (resp['status'] ==0){
                    $("a[data-product-id='"+product_id+"']").html("<i class='fas fa-toggle-off' style='color: gray' data-status='Inactive'></i>");

                }else if (resp['status'] ==1){
                    $("a[data-product-id='"+product_id+"']").html("<i class='fas fa-toggle-on' style='color: #3f6ed3' data-status='Active'></i>");

                }
            },
            error:function (){
                alert("Error");
            }
        })
    });

    $(document).on('click','#deleteCategoryImage',function (){
        if (confirm('Are you sure You want to remove this Category Image?')){
            var category_id =$(this).data('category-id');
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')

                },
                type:'post',
                url:'/admin/delete-category-image',
                data:{category_id:category_id},
                success:function (resp){
                    if (resp['status'] == true){
                        alert(resp['message']);
                        $('#categoryImageBlock').remove();
                    }
                } ,error:function (){
                    alert("Error occurred while deleting the image");
                }
            });
        }
    });
    $(document).on('click','#deleteSizeChartImage',function () {
        if (confirm('Are you sure You want to remove The Chart Image?')){
            var category_id = $(this).data('categoryId');
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')

                },
                type:'post',
                url:'/admin/delete-sizechart-image',
                data:{category_id:category_id},
                success:function (resp){
                    if (resp && resp['status'] === true){
                        alert(resp['message']);
                        $('#sizechartImageBlock').remove();
                    } else if (resp && resp['message']) {
                        alert(resp['message']);
                    } else {
                        alert("Error occurred while deleting the image");
                    }
                },error:function (){
                    alert("Error occurred while deleting the image");
                }
            })
        }
    })



    $(document).on("click",".confirmDelete",function (e){
        e.preventDefault();
        let button = $(this);
        let module = button.data("module");
        let moduleId = button.data("id");
        let form = button.closest("form");
        let redirectUrl = "/admin/delete-"+module+"/"+moduleId;


        Swal.fire({
            title:'Are you sure ?',
            text:"you won't be able to revert this!",
            icon:'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'


        }).then((result) =>{
            if (result.isConfirmed){

                if(form.length >0 && form.attr("action") && form.attr("method") === "POST"){
                    if (form.find("input[name='_method']").length === 0){
                        form.append('<input type="hidden" name="_method" value="DELETE">');
                    }
                    form.submit();
                }else
                {
                    // Use redirect if no delete form is present.
                    window.location.href  = redirectUrl;
                }
            }
        });
    });

});
