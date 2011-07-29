<div class="admin_form_header_bar">Dashboard</div>
<div class="admin_dashboard_content">
	<div class="admin_dashboard_item">
		<h2>Total Users Today</h2>
		<h1><?php echo Util_Analytics_Engine::getUsersToday() ?></h1>
	</div>
	<div class="admin_dashboard_item">
		<h2>Total Users Active Today</h2>
		<h1><?php echo Util_Analytics_Engine::getUsersActiveToday() ?></h1>
	</div>
	<div class="admin_dashboard_item">
		<h2>Total Visits Today</h2>
		<h1><?php echo Util_Analytics_Engine::getPageViewsToday() ?></h1>
	</div>
</div>