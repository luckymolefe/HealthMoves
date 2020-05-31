<?php
	//
	require_once('router.php');
	$customer->page_protected();
?>
<style type="text/css">
	.container {
		text-align: center;
	}
	.container-panel {
		width: 250px;
		height: 150px;
		max-width: 100%;
		margin: 0 auto;
		background-color: #eee;
		padding: 10px;
		border-radius: 2px;
		margin: 10px 10px 10px 0;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		border-bottom: 3px solid #0c8e7e;
		display: inline-block;
		text-align: center;
		cursor: pointer;
		color: #005555;
		transform: scale(0);
	}
	.container-panel:hover {
		background-color: #ddd;
		/*background-color: #0c8e7e;*/
		/*color: #fff;*/
		border-bottom: 3px solid #034f99;
	}
	.page-heading {
		font-size: 2em;
		color: #777;
		border-bottom: thin solid #ccc;
		text-align: center;
		padding: 0 0 5px 0;
	}
	.panel-icon {
		font-size: 6.5em;
		color: #034f99;
	}
	.panel-text {
		font-size: 1.5em;
		font-weight: bold;
	}

</style>
<h1 class="page-heading"><i class="fa fa-cogs"></i> Manage Account Settings</h1>
<div class="container">
	<div class="container-panel" title="Edit Profile" onclick="runQuery('profileedit')">
		<div class="panel-icon"><i class="fa fa-id-card"></i></div>
		<div class="panel-text">Profile</div>
	</div>
	<div class="container-panel" title="Add Credit Card" onclick="runQuery('payment')">
		<div class="panel-icon"><i class="fa fa-cc-visa"></i></div>
		<div class="panel-text">Credit Cards</div>
	</div>
	<div class="container-panel" title="Change Passwords" onclick="runQuery('account')">
		<div class="panel-icon"><i class="fa fa-lock"></i></div>
		<div class="panel-text">Passwords</div>
	</div>
</div>