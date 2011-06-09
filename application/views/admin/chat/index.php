<div class="admin_form_header_bar">Chat Management</div>
<div id="leftnav">
	<a href="/admin/chat/">Current Users</a>
	<a href="/admin/chat/add">Add User</a>
</div>
<div id="rightcontent">
	<h2>Chat Feature - Current Users</h2>
	<div>
		<table style="width:100%">
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Action</th>
			</tr>
			<?php foreach($users as $user): ?>
				<tr>
					<td><?php echo $user['id'] ?></td>
					<td><?php echo $user['username']?></td>
					<td><?php echo $user['firstname'] ?></td>
					<td><?php echo $user['lastname'] ?></td>
					<td><a href="/admin/chat/remove/<?php echo $user['id'] ?>" onclick="return confirm('Are you sure?')">Kill</a></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>
<div style="clear:both;"></div>