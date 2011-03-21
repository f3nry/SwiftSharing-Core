$(".modal_link").fancybox({
    hideOnContentClick: false,
    scrolling: 'no',
    showCloseButton: true,
    titleShow: false,
    onClosed: function() {
        $("#add_friend_loader").hide();
    }
});

function closeModal() {
    $.fancybox.close();
}

function addAsFriend(id) {
    $("#add_friend_loader").show();

    var post_data = {
        'request': 'requestFriendship',
        'id': id
    };

    $.post('/ajax/friend', post_data, function(data) {
        $("#add_friend").html(data).show().fadeOut(12000);
    });
}

function removeAsFriend(id) {
    $("#remove_friend_loader").show();

    var post_data = {
        request: 'removeFriendship',
        id: id
    };
    $.post('/ajax/friend', post_data, function(data) {
        $("#remove_friend").html(data).show().fadeOut(12000);
    });
}

function acceptFriendRequest (x) {
    $.post('/ajax/friend',
    {
        request: "acceptFriend",
        reqID: x
    },
    function(data) {
        $("#req"+x).html(data).show();
    }
    );
}

function denyFriendRequest (x) {
    $.post('/ajax/friend',
    {
        request: "denyFriend",
        reqID: x
    },
    function(data) {
        $("#req"+x).html(data).show();
    }
    );
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