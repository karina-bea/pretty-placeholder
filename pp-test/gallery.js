$(function() {
    $("#group_items_panel").sortable({
        opacity: 0.6,
        cursor: 'move',
        update: function() {
            if($('.act').attr('id') != 'all_gallery'){
                    
            }
            var selected_ids = '';
            $(".item_box").each(function() {
                selected_ids += $(this).attr("id")+"-";
            });
                
            var data = {
                action: 'update_gallery',
                image_list: selected_ids,
                gallery_id : $('.act').attr('id')
            };
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data:data,
                success: function(res) {
                }
            });
        }
    });

});


$(document).ready(function(){
    $('.item_box').live("click", function() {
        if($(this).find('.tick_image').length == 0){
            $(this).append("<div class='tick_image'><img src='tick.png' /></div>");
        }else{
            $(this).find('.tick_image').remove();
        }
    });


    $('.group_item').live("click", function() {
        $('.group_item').removeClass("act");
        $(this).addClass("act");

        $('.tick_image').remove();

        var data = {
            action: 'load_gallery',
            gallery_id: $(this).attr("id")
        };
        if (data.gallery_id != "new_gallery"){
            $.ajax({
            type: "POST",
            url: "ajax.php",
            data:data,
            success: function(res) {
                var gallery_items = res;
                gallery_items = gallery_items.split("-");
                $("#group_items_panel").html('');
                for(x=0;x<gallery_items.length;x++){
                    $("#group_items_panel").append("<div id='"+gallery_items[x]+ "' class='item_box'><img src='"+gallery_items[x]+"' /></div>");
                }
                $('.tick_image').remove();
                $('#group_name').val('');
            }
        });   
        } else {
            $("#group_items_panel").html("");
            $("#group_items_panel").append("<input id=\"usernameInput\" type=\"text\"><input type=\"button\" value=\"Search\" onClick=\"getUserInformation()\">")
        }
        
    });

});



var group_elements = function(){
    if($('#group_name').val() == ''){
        alert("Group Name Cannot be Empty");
    }else if($('.tick_image').length == '0'){
        alert("No elements to group");
    }else{
        var selected_ids = '';
        $(".tick_image").each(function() {
            selected_ids += $(this).siblings("img").attr("src")+"-";
        });

        var data = {
            action: 'save_gallery',
            image_list: selected_ids,
            gallery_name : $('#group_name').val()
        };
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data:data,
            success: function(res) {
                if(res == 'invalid'){
                    alert("Group Already Exists");
                }else{
                    $('#group_list').append("<div class='group_item' id='"+res+"' >"+ $('#group_name').val() +"</div>");
                    $('.tick_image').remove();
                    $('#group_name').val('');
                }
            }
        });           
    }	
};

var delete_group = function(){
    if($('.act').attr('id') != 'all_gallery'){
        var group_id =  $('.act').attr('id');  


        var data = {
            action: 'delete_gallery',
            group_id: group_id
        };
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data:data,
            success: function(res) {
                if(res == 'success'){
                    alert("Group Deleted Successfully");



                    var data = {
                        action: 'load_gallery',
                        gallery_id: 'all_gallery'
                    };
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data:data,
                        success: function(res) {
                            var gallery_items = res;
                            gallery_items = gallery_items.split("-");
                            $("#group_items_panel").html('');
                            for(x=0;x<gallery_items.length;x++){
                                $("#group_items_panel").append("<div id='"+gallery_items[x]+ "' class='item_box'><img src='img/"+gallery_items[x]+".jpg' /></div>");
                            }
                            $('.tick_image').remove();
                            $('#group_name').val('');
                            $('.act').remove();
                            $('#all_gallery').addClass('act');
                        }
                    });
                }
            }
        }); 
    }else{
        alert("All items cannot be delete");
    }
};


var delete_images = function(){
    if($('.act').attr('id') != 'all_gallery'){

        if($(".tick_image").length == 0){
            alert("Please select images to remove");
        }else{
            var selected_ids = '';
            $(".tick_image").each(function() {
                $(this).parent().remove();
            });

            var selected_ids = '';
            $(".item_box").each(function() {
                selected_ids += $(this).attr("id")+"-";
            });
            var data = {
                action: 'update_gallery',
                image_list: selected_ids,
                gallery_id : $('.act').attr('id')
            };
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data:data,
                success: function(res) {
                }
            });
        }




    }else{
        alert("All group images cannot be delete");
    }



};