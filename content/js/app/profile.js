$(document).ready(function() {
	$(".modal_link").fancybox({
    	hideOnContentClick: false,
    	showCloseButton: true,
    	titleShow: false,
    	onClosed: function() {
        	$("#add_friend_loader").hide();
    	}
	});

	$(".short_friends_list").fancybox({
    	hideOnContentClick: false,
    	scrolling: 'auto',
    	showCloseButton: true,
    	autoDimensions: false,
    	titleShow: false,
    	onClosed: function() {
        	$("#add_friend_loader").hide();
    	},
    	width:218,
    	height:500
	});
});

function closeModal() {
    $.fancybox.close();
}

function addAsFriend(id) {
    $("#add_friend_loader").show();

    var post_data = {
        'id': id
    };

    $.post('/ajax/friend/request', post_data, function(data) {
        $("#add_friend").html(data).show();
    });
}

function triggerAddFriend(id) {
    var full_name = $("#friend_suggestion_" + id + " .name").text();

    var src = $("#add_friend_template").html();

    src = src.replace("{name}", full_name);
    src = src.replace("{id}", id);

    $("#add_friend").html(src);

    $(".add_friend").trigger('click');

    return false;
}

function removeAsFriend(id) {
    $("#remove_friend_loader").show();

    var post_data = {
        id: id
    };
    
    $.post('/ajax/friend/remove', post_data, function(data) {
        $("#remove_friend").html(data).show().fadeOut(12000);
    });
}

function acceptFriendRequest (x) {
    $.post('/ajax/friend/accept', {
        reqID: x
    }, function(data) {
        $("#req"+x).html(data).show();
    });
}

function denyFriendRequest (x) {
    $.post('/ajax/friend/deny', {
        reqID: x
    }, function(data) {
        $("#req"+x).html(data).show();
    });
}

$('#pmForm').submit(function(){
    $('input[type=submit]', this).attr('disabled', 'disabled');
});

function sendPM ( ) {
    var pmSubject = $("#pmSubject");
    var pmTextArea = $("#pmTextArea");
    var recID = $("#pm_rec_id");
    var url = "ajax/inbox/new";
    
    if (pmSubject.val() == "") {
        $("#interactionResults").html('<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp; Please type a subject.').show().fadeOut(6000);
    } else if (pmTextArea.val() == "") {
        $("#interactionResults").html('<img src="images/round_error.png" alt="Error" width="31" height="30" /> &nbsp; Please type in your message.').show().fadeOut(6000);
    } else {
        $("#pmFormProcessGif").show();
        $.post(url,{
            subject: pmSubject.val(),
            message: pmTextArea.val(),
            to: recID.val()
        } , function(data) {
            $("#interactionResults")
            .html(data)
            .show()
            .fadeOut(5000, function(e) {
                $.fancybox.close();
                $('input[type=submit]').attr('disabled', '');
            });
                
            document.pmForm.pmTextArea.value='';
            document.pmForm.pmSubject.value='';
            $("#pmFormProcessGif").hide();
        });
    }
}

function openFriendRequest(id) {
	$("#friend_request_link").attr("href", "/profile/request/" + id);
	
	$("#friend_request_link").fancybox({
	    hideOnContentClick: false,
	    showCloseButton: true,
	    titleShow: false,
	});
	
	$("#friend_request_link").trigger('click');
}