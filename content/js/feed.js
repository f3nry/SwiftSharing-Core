var temp_blabs = null;
var temp_blabs_as_string = "";
var totalNUpdates = 0;
var periods = new Array("second", "minute", "hour", "day", "week", "month", "year", "decade");
var lengths = new Array("60","60","24","7","4.35","12","10");
var now = new Date();
var difference = 0;
var i = 0;
var tmpTable = null;

$(document).ready(function() {
    $(".comments").fancybox({
        hideOnContentClick: false,
        scrolling: 'no',
        showCloseButton: true,
        titleShow: false,
        width:400,
        height:300,
        onComplete: function() {
            bindThumbsUp();
        }
    });

    $(".post_photo").fancybox({
        hideOnContentClick: true,
        showCloseButton: true,
        width:500,
        titleShow: true
    })


    if(!$.browser.msie) { //Disable animations for IE
        //Background color, mouseover and mouseout
        var colorOver = '#31b8da';
        var colorOut = '#1f1f1f';

        //Padding, mouseover
        var padLeft = '20px';
        var padRight = '20px';

        //Default Padding
        var defpadLeft = $('#menu li a').css('paddingLeft');
        var defpadRight = $('#menu li a').css('paddingRight');

        //Animate the LI on mouse over, mouse out
        $('#menu li').click(function () {
            //Make LI clickable
            window.location = $(this).find('a').attr('href');

        }).mouseover(function (){

            //mouse over LI and look for A element for transition
            $(this).find('a')
            .animate( {
                paddingLeft: padLeft,
                paddingRight: padRight
            }, {
                queue:false,
                duration:100
            } )
            .animate( {
                backgroundColor: colorOver
            }, {
                queue:false,
                duration:200
            });

        }).mouseout(function () {

            //mouse oout LI and look for A element and discard the mouse over transition
            $(this).find('a')
            .animate( {
                paddingLeft: defpadLeft,
                paddingRight: defpadRight
            }, {
                queue:false,
                duration:100
            } )
            .animate( {
                backgroundColor: colorOut
            }, {
                queue:false,
                duration:200
            });
        });
        
        //Scroll the menu on mouse move above the #sidebar layer
        $('#sidebar').mousemove(function(e) {

            //Sidebar Offset, Top value
            var s_top = parseInt($('#sidebar').offset().top);

            //Sidebar Offset, Bottom value
            var s_bottom = parseInt($('#sidebar').height() + s_top);

            //Roughly calculate the height of the menu by multiply height of a single LI with the total of LIs
            var mheight = parseInt($('#menu li').height() * $('#menu li').length);

            //I used this coordinate and offset values for debuggin
            $('#debugging_mouse_axis').html("X Axis : " + e.pageX + " | Y Axis " + e.pageY);
            $('#debugging_status').html(Math.round(((s_top - e.pageY)/100) * mheight / 2));

            //Calculate the top value
            //This equation is not the perfect, but it 's very close
            var top_value = Math.round(( (s_top - e.pageY) /100) * mheight / 2);

        //Animate the #menu by chaging the top value
        //$('#menu').animate({top: top_value}, { queue:false, duration:500});
        });
    }

    //Send new post to the server
    $("#share").submit(function() {
        var type = 'STATUS';
        
        var submitButton = $(this).find("input[type='submit']");
        var btnText = $(submitButton).attr('value');
        $(submitButton).attr('value', 'Please Wait..');
        $(submitButton).attr('disabled', 'true');
        
        if($("#profile_flag").val() != "") {
            type = 'PROFILE';
        }

        $.post("/ajax/feed/new",
        {
            text: $("#sharetext").val(),
            feed_id: $("#current_feed_id").text(),
            type: type
        },
        function(data) {
            //Reset post field
            $("#sharetext").val('');
				
            //Prepend the new post.
            $("#feed").prepend(data);
				
            //Recalculate the times on the posts.
            recalculateTimes();
				
            //Remove the post at the end of the table. So that our table doesn't grow out of control.
            removeFromEnd(1);
				
            //Update the thumbs up, so that people can thumb up/down the new blab.
            bindThumbsUp();
            
            $(submitButton).removeAttr('disabled');
            $(submitButton).attr('value', btnText);
        });
			
        return false;
    });

    $("#new_comment").submit(function() {
        var data = {
            feed_id: $("#new-comment-feed-id").val(),
            type: "COMMENT",
            text: $("#comment-text").val()
        }

        $.post("/ajax/feed/new", data, function(response) {
            $("#comment-dialog-comments").prepend(response);
            $("#comment-text").val('');
        });
		
        return false;
    });
	
    //Begin async call to update the blabs as new blabs come in.
    updateBlabs();
    bindThumbsUp();
});

function bindThumbsUp() {
    // Whenever a vote is cast
    $('div.thumbsup_template_mini-thumbs input[name=thumbsup_rating]').unbind('click');
    $('div.thumbsup_template_mini-thumbs input[name=thumbsup_rating]').click(function() {

        // Find the id of the thumbsup box in which the vote has been cast
        var $thumbsup_box = $('#'+$(this).closest('div.thumbsup_template_mini-thumbs').attr('id'));

        // Cache all other selector operations for this box
        var $thumbsup_form = $('form', $thumbsup_box);
        var $votes_balance = $('strong.votes_balance', $thumbsup_form);

        // Immediately disable the submit buttons to prevent multiple clicks
        $(':submit', $thumbsup_form).attr('disabled', 'disabled').blur();

        // Disable the form and show a spinner
        $thumbsup_form.addClass('closed');
        $votes_balance.text('···');

        // Collect the POST data to send to the server
        var postdata = {
            thumbsup_id : $('input[name=thumbsup_id]', $thumbsup_form).val(),
            thumbsup_rating: $(this).val()
        };

        // AJAX POST request
        $.post('/likes', postdata, function(item) {
            // Show error message, if any
            if (item.error) {
                alert(item.error);
            }

            // Update the votes balance
            $votes_balance.hide().text(((item.likes > 0) ? '+' : '')+item.likes).fadeIn('slow');

        }, 'json');

        // Block normal non-AJAX form submitting
        return false;
    });
}

//Append any blabs held in temporary variables
function showTempBlabs() {
    //Send the blabs to the table
    $("#feed").prepend(temp_blabs_as_string);
	
    //Reset the temp blabs
    temp_blabs = null;
	
    //Reset the number of temp blabs
    totalNUpdates = 0;
	
    //Hide the link to show temporary blabs, as we have none now.
    $("#pending").hide();
	
    //Recalculate the times on the blabs.
    recalculateTimes();
	
    //Update the blabs so that they are thumb-up-able.
    updateThumbsUp();
}

//Recalculate the times on the blabs.
function recalculateTimes() {
    //Iterate through the blabs
    $("#feed").children().each(function(index, element) {
        //Calculate the new difference
        $("#" + element.id + "_actual_time").text(
            fuzzy_span($("#" + element.id + "_timestamp").text())
        );
    });
}

function fuzzy_span(timestamp)
{
        var local_timestamp = (new Date()).getTime();
        
        // Determine the difference in seconds
        var offset = Math.round(new Date().getTime() / 1000) - timestamp;
        var span = '';

        if (offset <= 60)
        {
                span = 'moments';
        }
        else if (offset < (60 * 20))
        {
                span = 'a few minutes';
        }
        else if (offset < 3600)
        {
                span = 'less than an hour';
        }
        else if (offset < (3600 * 4))
        {
                span = 'a couple of hours';
        }
        else if (offset < 86400)
        {
                span = 'less than a day';
        }
        else if (offset < (86400 * 2))
        {
                span = 'about a day';
        }
        else if (offset < (86400 * 4))
        {
                span = 'a couple of days';
        }
        else if (offset < 604800)
        {
                span = 'less than a week';
        }
        else if (offset < (604800 * 2))
        {
                span = 'about a week';
        }
        else if (offset < 2629744)
        {
                span = 'less than a month';
        }
        else if (offset < (2629744 * 2))
        {
                span = 'about a month';
        }
        else if (offset < (2629744 * 4))
        {
                span = 'a couple of months';
        }
        else if (offset < 31556926)
        {
               span = 'less than a year';
        }
        else if (offset < (31556926 * 2))
        {
               span = 'about a year';
        }
        else if (offset < (31556926 * 4))
        {
               span = 'a couple of years';
        }
        else if (offset < (31556926 * 8))
        {
               span = 'a few years';
        }
        else if (offset < (31556926 * 12))
        {
               span = 'about a decade';
        }
        else if (offset < (31556926 * 24))
        {
               span = 'a couple of decades';
        }
        else if (offset < (31556926 * 64))
        {
               span = 'several decades';
        }
        else
        {
               span = 'a long time';
        }

        if (timestamp <= local_timestamp)
        {
                // This is in the past
                span = span + ' ago';

                return span;
        }
        else
        {
                // This in the future
                return 'in ' + span;
        }
}

//Calculates a pretty difference between the passed timestamp, and now.
function makeAgo(timestamp) {
    //Get current time
    now = new Date();
	
    //Calcuate a numeric difference between now and the timestamp
    difference = Math.round(new Date().getTime() / 1000) - timestamp;
	
    i = 0;
	
    //Find the highest human-readable difference
    for(i = 0; difference >= lengths[i]; i = i + 1) {
        difference = difference / lengths[i];
    }
	
    //Round the difference real quick.
    difference = Math.round(difference);
	
    //The actual human readable periods.
    periods = new Array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	
    //Plural/Singular?
    if(difference != 1) {
        periods[i] += "s";
    }
	
    //Return the human-reable period.
    return difference + " " + periods[i] + " ago";
}

//Get more blabs from the server in the past.
function loadMore() {
    //Grab all blabs.
    var blabs = $('#feed').children();
	
    //Get the ID of the last blab.
    var ID = blabs[blabs.length - 1].id.replace("blab_", "");
    
    var url = "/ajax/feed/past";

    if(ID) {
        var data = {
            lastmsg: ID,
            profile_flag: $("#profile_flag").val(),
            feed_id: $("#current_feed_id").text()
        };

        //Post to the server
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            success: function(html){
                //Append the returned blabs
                $("#feed").append(html);
				
                //Update the thumbs up
                bindThumbsUp();
                
                $(".comments").fancybox({
                    hideOnContentClick: false,
                    scrolling: 'no',
                    showCloseButton: true,
                    titleShow: false,
                    width:400,
                    height:300,
                    onComplete: function() {
                        bindThumbsUp();
                    }
                });

                $(".post_photo").fancybox({
                    hideOnContentClick: true,
                    showCloseButton: true,
                    width:500,
                    titleShow: true
                })
            }
        });
    }
    else {
        $(".morebox").html('The End');
    }

    return false;
}

//Ping the server to check for new blabs posted by users
function updateBlabs() {
    if($("#is_profile").text() == 1) {
        return;
    }

    var blabId = -1;
	
    //Are we looking for the most recent blab, in the table, or in our temp variable?
    if(temp_blabs != null && $("#auto-update").val() != "on") {
        blabId = temp_blabs[0].id.replace("blab_", "");
    } else {
        blabs = $('#feed').children();

	if(blabs.length == 0) {
            return;
        }
        
        blabId = blabs[0].id.replace("blab_", "")
    }
	
    //Post to the server to get more blabs.
    $.post("/ajax/feed/more",
    {
        lastmsg: blabId
    },
    function(data) {
        if(data != "") {
            //Do we need to prepend to the temporary variable?
            if($("#auto-update").val() == "on") {
                $("#feed").prepend(data);
					
                tmpTable = $('<tbody>');
                tmpTable.append(data);
					
                removeFromEnd(tmpTable.children().length);
					
                bindThumbsUp();
            } else {
                tmpTable = $('<tbody>');
					
                tmpTable.append(data);
					
                temp_blabs = tmpTable.children();
                temp_blabs_as_string = data + temp_blabs_as_string;
					
                totalNUpdates = totalNUpdates + tmpTable.children().length;
					
                if(totalNUpdates == 1) {
                    $("#waiting").html("1 new post");
                } else if(totalNUpdates > 1) {
                    $("#waiting").html(totalNUpdates + " new posts");
                }
					
                if(totalNUpdates != 0) {
                    $("#pending").show();
                }
            }
        }
			
        recalculateTimes();
									
        setTimeout(updateBlabs, 4000);
    }
    );
}

//Remove n_blabs number of blabs from the table
function removeFromEnd(n_blabs) {
    blabs = $("#blabs").children();
	
    var total_blabs = blabs.length;
	
    for(i = total_blabs - 1; i >= total_blabs - n_blabs && i >= 0; i--) {
        $(blabs[i]).remove();
    }
}

function postComment(blab_id, content) {
    var data = {
        blab_id: blab_id,
        text: $(content).val()
    }

    $.post('/ajax/feed/comment', data, function(data) {
        alert(data);
    }, 'json');
}

function openBlabComments(id) {
    $.fancybox.showActivity();

    $.get('/feed/' + id + '/comments', {}, function(data) {
        $("#comment-dialog-blab").html(data.blab);
        $("#comment-dialog-comments").html(data.comments);

        $("#new-comment-feed-id").val(id);

        $(".comments").trigger('click');

        bindThumbsUp();
    }, 'json');

    return false;
}

function deleteBlab(id) {
    if(confirm('Are you sure you want to delete that post?')) {
        $.post('/ajax/feed/delete', {id: id}, function(data) {
            if(data.success == 1) {
                $("#blab_" + id).remove();
            } else {
                alert(data.message);boboot
            }
        }, 'json');
    }
}
