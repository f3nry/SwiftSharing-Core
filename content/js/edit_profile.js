$(document).ready(function() {
    var in_transition = false;
    
    $('.block').click(function() {
        if(in_transition) {
            return;
        }
        
        var id = $(this).attr('id');
        var data_id = $(".initial_data").html();
            
        if(!data_id) {
            data_id = $("#current_id").text();
        }
            
        var panel = $('.panel');
        var panel_width = $('.panel').css('left');
        
        if(closed(panel)) {
            updatePanelContent(id);
            
            openPanel(panel);
        } else {
            closePanel(panel, function() {
                if(data_id != id) {      
                    updatePanelContent(id);

                    openPanel(panel);
                    
                    tinyMceInit();
                    hookForm();
                }
            });
        }
        
        hookForm(id);
        tinyMceInit();
            
        return false;    
    });
    
    function openPanel(panel, finish) {
        in_transition = true;
        
        panel.animate({
            left: parseInt(panel.css('left')) + 350
        }, function() {
            panel.css('width', 'auto');
            
            if(finish) {
                finish();
            }
            
            in_transition = false;
        });
    }
    
    function closePanel(panel, finish) {
        in_transition = true;
        
        panel.animate({
            left: 0
        }, function() {
            panel.animate({
                width:350
            }, function() {
                $(".data").html('');
            
                if(finish) {
                    finish();
                }
                
                in_transition = false;
            });
        });
    }
    
    function updatePanelContent(id) {
        $('.data').html(
            $("#" + id + " .content").html()
        );
                
        $("#current_id").text(id);
    }
    
    function closed(panel) {
        return (parseInt(panel.css('left')) == 0) ? true : false;
    }
        
    $('.close').click(function() {
        var panel = $('.panel');
        
        closePanel(panel);
            
        return false; 
    });
    
    function hookForm(id) {        
        $('.data form').unbind();
        
        $('.data form').submit(function(event) {
            if($(this).attr('enctype') == "multipart/form-data") {
                return true;
            }
            
            $('.save').attr('disabled', 'disabled');

            $('.save').val('Saving..');
            
            event.preventDefault();

            var data = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: data,
                success: function(data) {
                    if(data.success) {
                        $('.save').removeAttr('disabled');
                        $('.save').val('Success!');
                        
                        setTimeout(function() {
                            $('.save').val('Save!');
                        }, 2500);
                    } else {
                        alert(data.error);
                        
                        $('.save').removeAttr('disabled');
                        $('.save').val('Save!');
                    }
                },
                error: function(data) {
                    alert('Failed to save, sorry. This incident has been reported and will be fixed shortly.');
                    
                    $('.save').removeAttr('disabled');
                    $('.save').val('Save!');
                },
                dataType: 'json'
            });
            
            return false;
        });
        
        
    }
});