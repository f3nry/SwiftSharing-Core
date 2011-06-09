<div class="admin_form_header_bar">Chat Management</div>
<div id="leftnav">
	<a href="/admin/chat/">Current Users</a>
	<a href="/admin/chat/add">Add User</a>
</div>
<div id="rightcontent">
	<h2>Chat Feature - Add User</h2>
	<div>
		<p>Start typing, and hit enter. The results will automatically populate below the input box.</p>
		<label>Username:</lable>
		<input type="text" size="40" id="user_search" />
		<div id="search_results"></div>
	</div>
</div>
<div style="clear:both;"></div>
<script type="text/javascript">
$(document).ready(function() {
	$("#user_search").change(function(input) {
		if($("#user_search").val()) {
			$.post('/admin/ajax/search', { username: $("#user_search").val() },
				function(data) {
					var user = null;
				
					$("#search_results").html('');
				
					for(i in data.users) {
						user = data.users[i];
					
						var row = "<div>" + 
							"<a href=\"/admin/chat/add/" + user.id + "\">" + user.firstname + " " + user.lastname + "</a>" +
						"</div>";
					
						$("#search_results").append(row);
					}
				}, 'json'
			);
		}
	});
});
</script>