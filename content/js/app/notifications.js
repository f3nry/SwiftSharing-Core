var Notifications = function() {
	
}

Notifications.poll = function() {
	$.ajax({
		type: "POST",
		url: "/notifications/poll",
		dataType: "json",
		success: function(data) {
			
			if(data.notifications.length > 0) {
				for(var i in data.notifications) {
					if(data.notifications[i]) {
						Notifications.notify(data.notifications[i]);
					}
				}
			}
			
			setTimeout(Notifications.poll, 2000);
		},
		error: function(data) {
			setTimeout(Notifications.poll, 2000);
		}
	});
}

Notifications.notify = function(notification) {
	var image = "";
	
	if(notification.type == "REQUEST") {
		image = "<img src='/content/images/notifications/request.png' />";
	} else if(notification.type == "COMMENT") {
		image = "<img src='/content/images/notifications/comment.png' />";
	} else if(notification.type == "WALL") {
		image = "<img src='/content/images/notifications/wall_post.png' />";
	} else if(notification.type == "MESSAGE") {
		image = "<img src='/content/images/notifications/message.png' />";
	}
	
	if(notification.text) {
		$.jGrowl(image + notification.text, {
			sticky: true,
			click: function() {
				if(notification.type == "REQUEST") {
					openFriendRequest(notification.ref);
				} else if(notification.type == "COMMENT") {
					openBlabComments(notification.ref);
				} else if(notification.type == "WALL") {
					window.location = '/users/' + notification.to;
				} else if(notification.type == "MESSAGE") {
					window.location = '/inbox/view/' + notification.ref;
				}
			}
		});
	}
}

$(document).ready(function() {
	Notifications.poll();
});