<?php
	//
	require_once('router.php');
	$admin->page_protected();
?>
<style type="text/css">
	.container {
		width: 600px;
		max-width: 100%;
		margin: 0 auto;
		background-color: #f5f5f5;
		padding: 10px;
		border-radius: 5px;
		margin-top: 50px;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
	}
	.form-group {
		padding: 10px 0;
	}
	.form-control {
		width: 100%;
		border: thin solid #ccc;
		border-radius: 5px;
		padding: 10px 0px;
		text-indent: 5px;
		color: #777;
	}
	.error {
		color: #ff0000;
	}
	.heading {
		position: relative;
		top: -10px;
		background-color: #45a89a;
		color: #fff;
		font-size: 2em;
		text-align: center;
		border-radius: 5px 5px 0 0;
		padding: 5px 0;
		margin-left: -10px;
		margin-right: -10px;
	}
	.btn {
		width: 150px;
		padding: 15px 0;
		font-weight: bold;
		border: none;
		border-radius: 5px;
		background-color: #45a89a;
		cursor: pointer;
		color: #fff;
	}
	label {
		color: #777;
		font-weight: bold;
	}
</style>

<div class="container">
	<div class="heading">Settings</div>
	<form action="router.php" method="POST" enctype="application/x-www-forms-urlencoded">
		<div class="form-group">
			<label>New Password:</label>
			<input type="password" name="newpassword" class="form-control" placeholder="Enter new password" autocomplete="off" autofocus required>
		</div>
		<div class="form-group">
			<label>Confirm New Password:</label>
			<input type="password" name="confirmpassword" class="form-control" placeholder="Enter confirm new password"autocomplete="off" required>
		</div>
		<div class="form-group">
			<button class="btn" name="updatepassword">Change Password</button>
		</div>
	</form>
</div>