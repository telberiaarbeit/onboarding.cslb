jQuery(document).ready(function($){ 
    if($( ".datetimepicker" ).length) {
        $( ".datetimepicker" ).datetimepicker({
            format: 'L',
            locale: "de",
            timeZone: 'Europe/Vienna'
        });            
    }
    if($( "#popup-group-user" ).length) {
        var arg_group_id = [];
        var arg_group = [];
        $('#popup-group-user').on('hidden.bs.modal', function (e) {
            $(this).find('.list-user').html("");
        })
        $('.add-to-task').click(function(){
            var parent_id = $(this).closest('#popup-group-user').attr('data-id');
            var list_added = $('.input-group[data-id="'+parent_id+'"]').find('.current_group').val();
            var text_added = $('.input-group[data-id="'+parent_id+'"]').find('.list-group').text();
            var arg_group_id = list_added.split(",");
            var arg_group = text_added.split(",");

            if(arg_group_id[0] == "") {
                arg_group_id.shift();
            }

            if(arg_group[0] == "") {
                arg_group.shift();
            }
            
            arg_group_id.push($(this).closest('li').data('id'));
            arg_group.push($(this).data('name'));

            $('.input-group[data-id="'+parent_id+'"] .list-group').append('<span><span class="edit-group" data-groupid="'+$(this).closest('li').data('id')+'">'+$(this).data('name')+'</span></span>');

            if($('.input-group[data-id="'+parent_id+'"] .list-group').length > 0) {
                $('.input-group[data-id="'+parent_id+'"] .list-group').addClass('has-group')
            }

            $('.input-group #'+parent_id+'_group').val(arg_group_id.toString());

            $(this).closest('li').css({"pointer-events":"none","opacity":"0.4"});
        });
        
        $(document).on('change','.user-task input', function(e){
            var task_id = $(this).data('task_id');
            var user_id = $(this).val();
            var list_user_val = $('.current_user[id="'+task_id+'_user"]');

            if(list_user_val.val() == 0) {
                list_user_val.val('');
                item_abbreviation = list_user_val.parents('.group-item').find('.input-abbreviation');
                item_abbreviation.attr('value', item_abbreviation.attr('data-val'));
                list_user_val.parents('.group-item').find('.col-md-4.mb-3').removeClass('na-abbreviation');
            }
           

            var list_user_id = list_user_val.val().split(",");
            if(list_user_id[0]=="") {
                list_user_id.shift();
            }
            if($(this).is(':checked')) {
                // Remove checked input N/A
                $('#popup-group-user .na-check .user-task-na input').removeClass('active').prop('checked',false);
                $('.input-group[data-id="'+task_id+'"] .list-group .edit-user-na').remove();
                
                if(list_user_id.indexOf(user_id) < 0) {
                    list_user_id.push(user_id);
                    list_user_val.val(list_user_id.toString());
                }
                $(this).addClass('active');
                $(this).prop('checked',true);
                // $('.user-task input[value="'+user_id+'"]').each(function(){
                //     $(this).prop('checked',true);
                // })
                var name = $(this).data('user_name'); 
                var id_user = $(this).val(); 
                if( $('.input-group[data-id="'+task_id+'"] .edit-user[data-group-id="'+$(this).data('group_id')+'"]').length){
                } else {
                    $('.input-group[data-id="'+task_id+'"] .list-group').append('<span class="edit-user" data-group-id="'+$(this).data('group_id')+'" >'
                    +$(this).data('group_name')+'<i class="far fa-plus"></i></span>');
                }
            } else {
                var index = list_user_id.indexOf(user_id);
                list_user_id.splice(index, 1);
                list_user_val.val(list_user_id.toString()); 
                $(this).prop('checked',false);
                $(this).removeClass('active');
                // $('.user-task input[value="'+user_id+'"]').each(function(){
                //     $(this).prop('checked',false);
                //     $(this).removeClass('active');
                // });
                if($(this).closest('.wrap-select-user').find('.active').length) {

                } else {
                    $('.input-group[data-id="'+task_id+'"] .list-group .edit-user[data-group-id="'+$(this).data('group_id')+'"]').remove();     
                }   
            }
            // $('.input-group[data-id="'+task_id+'"] .list-group').html("");
            if($('#'+task_id+'_user').val().length > 0) {
                $('.input-group[data-id="'+task_id+'"] .list-group').addClass('has-group');
            } else {
                $('.input-group[data-id="'+task_id+'"] .list-group').removeClass('has-group');
            }
            // $('.user-task input.active').each(function(e){
            //     var name = $(this).data('user_name'); 
            //     var id_user = $(this).val(); 
            //     $('.input-group[data-id="'+task_id+'"] .list-group').append('<span class="edit-user" data-group-id="'+$(this).data('group_id')+'" data-group_name="'+$(this).data('group_name')+'" data-id_user="'+id_user+'">'
            //         +name+'<i class="far fa-plus"></i></span>');               
            // })
            //add group name to task
            // var group_name = [];
            // var list_group_id = $('.current_group[id="'+task_id+'_group"]');
            // var arg_group = [];
            // if(($(this).closest('.list-user').find('.active')).length) {
            //     $(this).closest('.list-user').prev().find('.select-group').addClass('active');
            // } else {
            //     $(this).closest('.list-user').prev().find('.select-group').removeClass('active');
            // }
            // $('.select-group.active').each(function(){
            //     group_name.push($(this).data('group_name'));
            //     arg_group.push($(this).data('group_id'));
            // });
            // $('.input-group[data-id="'+task_id+'"] .list-group').text(group_name.toString());
            // $('.current_group[id="'+task_id+'_group"]').val(arg_group.toString());
            // if(group_name.length > 0) {
            //     $('.input-group[data-id="'+task_id+'"] .list-group').addClass('has-group');
            // } else {
            //     $('.input-group[data-id="'+task_id+'"] .list-group').removeClass('has-group');
            // }

        });

        // Event change active checkbox
        $(document).on('change','.user-task-na input', function(e){
            var task_id = $(this).attr('data-task_id');
            console.log(task_id);
            var item_groupp = $('.input-group[data-id="'+task_id+'"] .list-group');
            var list_user_val = $('.current_user[id="'+task_id+'_user"]');
            if($(this).is(':checked')) {
                $('#popup-group-user .list-user .user-task input').removeClass('active').prop('checked',false);
                item_groupp.html('<span class="edit-user edit-user-na" data-group-id="" data-id_user="0">N/A<i class="far fa-plus"></i></span>');
                item_groupp.addClass('has-group');
                list_user_val.attr('value', 0);
                $(this).prop('checked',true).addClass('active');

                item_groupp.parents('.group-item').find('.input-abbreviation').attr('value','N/A');
                item_groupp.parents('.group-item').find('.col-md-4.mb-3').addClass('na-abbreviation');
            } else {
                item_groupp.html('');
                item_groupp.removeClass('has-group');
                list_user_val.attr('value', '');
                $(this).prop('checked',false).removeClass('active');
            }
        });
    }
    if($('#checklist-page')) {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = dd + '.' + mm + '.' + yyyy;
        $(document).on('click','.tab-field input[type="checkbox"]',function(){
            if($(this).is(':checked')) {
                $(this).closest('.group-item').find('.wrap-datetimepicker').addClass('show-name');
                $(this).closest('.group-item').find('.datetimepicker-input').attr('value', today);                    
            } else {
                $(this).closest('.group-item').find('.wrap-datetimepicker').removeClass('show-name');
                $(this).closest('.group-item').find('.datetimepicker-input').removeAttr('value');
            }
        });

        $('.date-field input[type="checkbox"]').change(function(){
            if($(this).is(':checked')) {
                $(this).closest('.group-item').find('.datetimepicker').datetimepicker("show");                 
            } else {
                $(this).closest('.group-item').find('.datetimepicker').datetimepicker("clear");  
                $(this).closest('.group-item').find('.datetimepicker').removeAttr('value');
            } 
        })
        $('.date-field .datetimepicker').on('show.datetimepicker',function(){
            $(this).closest('.group-item').find('input[type="checkbox"]').attr('checked',true);   
        })
        $('.date-field .datetimepicker').on('hide.datetimepicker',function(){
            var moment = $(this).closest('.group-item').find('.datetimepicker').datetimepicker("date");
            $(this).attr('value',moment.format('L'));
        })

        $(".file-group > .input-group > input").on('change', function(e){
            var file = $(this).get(0).files[0]; 
            var preview_image = $(this).closest('.input-group');
            if(file){
                var reader = new FileReader();         
                reader.onload = function(){
                    $(preview_image).append('<img src="'+reader.result+'" class="image-upload">')
                }         
                reader.readAsDataURL(file);
            }
        });

    }        
    $('.label-list-email .open-list').click(function(){
        $(this).closest('.list-email').find(".list-name").slideToggle();
    });
    if($("#list-to-add").length) {
        $('.item-add-email .add-email').click(function(){
            $('#list-to-add').slideToggle();
        });
    }
    if($('.new-task-page').length) {
        $('.add-item').click(function(){
            var current_name = $(this).closest('.item').find('strong').text();
            var current_email = $(this).closest('.item-email').find('.email').text();
            var current_id = $(this).closest('.item').data('id');
            var list_email = ($('input#all-email-added').val()).split(',');
            list_email.push(current_id);
            if(list_email[0] == "") {
                list_email.shift();
            }
            var result = list_email.toString();
            $("#email-added").append( '<li class="item" data-id="'+current_id+'"><strong>'+current_name+'</strong><div class="item-detail"><a href="'+current_email+'" class="email">'+current_email+'</a><button class="remove-item"><i class="fas fa-times"></i></button></div></li>' );
            $('input#all-email-added').val(result);
            $(this).closest('.item').css({"opacity" : "0.6","pointer-events" : "none"});
        });
        $(document).on('click', '.remove-item', function(){
            var current_id = $(this).closest('.item').data('id');
            var id = current_id.toString();
            $('.item-add-email .item[data-id="'+current_id+'"]').css({"opacity" : "1","pointer-events" : "initial"});
            var list_email = ($('input#all-email-added').val()).split(',');
            var index = list_email.indexOf(id);
            list_email.splice(index, 1);
            var final_email = list_email.toString();
            $('input#all-email-added').val(final_email);
            $(this).closest('.item').remove();
            console.log($('input#all-email-added').val());
        })
    }
    if($('.detail-page').length) {
        $('.add-item').click(function(){
            var current_name = $(this).closest('.item').find('strong').text();
            var current_email = $(this).closest('.item-email').find('.email').text();
            var current_id = $(this).closest('.item').data('id');
            var list_email = ($('input#added_email_detail').val()).split(',');
            list_email.push(current_id);
            if(list_email[0] == "") {
                list_email.shift();
            }
            var result = list_email.toString();
            $("#email-added").append( '<li class="item" data-id="'+current_id+'"><strong>'+current_name+'</strong><a href="#" class="email">'+current_email+'</a><span class="task-status"><span class="status">Unvollst??ndig</span></span><button class="send-mail">E-Mail senden <i class="fas fa-envelope"></i></button></li>' );
            $('input#added_email_detail').val(result);
            $(this).closest('.item').css({"opacity" : "0.6","pointer-events" : "none"});
        });
    }
    if($('.dashboard').length) {
        $('.label-filter').click(function(){
            $(this).closest('.filter-dashboard').find('.list-filter').toggle();
        });
        $('.list-filter li').click(function(){
            if($(this).find('ul').length) {
                $(this).siblings().find('ul').slideUp();
                $(this).find('ul').slideToggle();
            }
        });
        if($('.floatingFilter').length) {
            $('.floatingFilter').select2();
        }
    }
    if($('.user-page').length) {
        $(".delete-user-group").click(function(e){
            e.preventDefault();
            $('input[name="group_id"]').val($(this).data('group_id'));
            $('.popup-delete').modal('show');
        });
        $(".delete-user").click(function(e){
            e.preventDefault();
            $('.popup-delete').modal('show');
            var user_id = $(this).attr('id');
            var add_userId = $('.deletebtn').attr('id', user_id);
        });
        $('#create-new-group .close').click(function(){
            $(this).closest('#create-new-group').modal('hide');
        })
        $(document).on('click','.add-to-group',function(event){
            var list_added = $('input[name="list_user"]').val();
            var arg_group_id = list_added.split(",");
    
            if(arg_group_id[0] == "") {
                arg_group_id.shift();
            }
            var current_id = $(this).data('id')
            arg_group_id.push(current_id);
    
            $('input[name="list_user"]').val(arg_group_id.toString());
    
            var current_text = $(this).data('name');
    
            $(this).css({"pointer-events":"none","opacity":"0.4"});
    
            $(this).closest('#form-group').find('ul.list-participants').append('<li>'+current_text+'<span class="remove-item" data-id="'+current_id+'"><i class="far fa-times-circle"></i></span></li>');
        });
        $(document).on('click','.remove-item', function(){
            $('.list-user').slideUp();
            var current_id = $(this).data('id');
            var list_added = $('input[name="list_user"]').val();
            var arg_group_id = list_added.split(",");
            var index = arg_group_id.indexOf(current_id);
            arg_group_id.splice(index, 1);
    
            $('input[name="list_user"]').val(arg_group_id.toString());
    
            $(this).closest('#form-group').find('li[data-id="'+current_id+'"]').removeAttr('style');
            $(this).closest('li').remove();
        })
        // $('#create-new-group').on('hidden.bs.modal', function (e) {
        //     $('input[name="list_user"]').val("");
        //     $('#group_name').val("");
        //     $('#create-new-group .error').remove();
        //     $('.list-user').slideUp();
        //     $('.list-user li').removeAttr('style');
        //     $('.list-participants li').remove();
    
        // })
        $('.label-select').click(function(){
            $(this).next().slideToggle();
        });
    }
    if($('#edit-group').length) {      
        $('.check-user-group').on('change', function(){
            var list_added = [];
            var disable_user = [];
            if($(this).is(':checked')) {
                $(this).addClass('select');
                $(this).removeClass('unselect');
            } else {
                $(this).addClass('unselect');
                $(this).removeClass('select');
            }
            $('.check-user-group.select[data-ondb="0"]').each(function(){
                list_added.push($(this).val());
            });
            $('.check-user-group.unselect[data-ondb="1"]').each(function(){
                disable_user.push($(this).val());
            });
            $('input[name="list_user"]').val(list_added.toString());
            $('input[name="disable_user"]').val(disable_user.toString());
        });
    }

    $('.edit-signature-button').click(function(){
        $(this).closest('.e-signature').find('.edit-signature').removeClass('d-none');
        $(this).hide();
    })

    if($('.selectpicker').length) {
        $('.selectpicker').selectpicker();
    }


}) 