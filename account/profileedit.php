<?php
	require_once('router.php');
	$customer->page_protected();
	$profile = $customer->getCustomer($_SESSION['customer']['uid']);
?>
<style type="text/css">
	.content-item {
		width: 600px;
		max-width: 100%;
		margin: 0 auto;
		background-color: #f5f5f5;
		padding: 10px;
		border-radius: 5px;
		margin-top: 15px;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
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
	label {
		color: #777;
		font-weight: bold;
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
	.btn:hover {
		background-color: #80b0a9;
	}
	.btn:active {
		background-color: #0c8e7e;
	}
	textarea {
		resize: none;
	}
</style>
<div class="content-item">
	<div class="heading">Edit Profile</div>
	<form action="router.php" method="POST" enctype="application/x-www-forms-urlencoded">
		<div class="form-group">
			<label>Firstname:</label>
			<input type="hidden" name="uid" value="<?php echo $profile->id; ?>">
			<input type="text" name="firstname" class="form-control" value="<?php echo $profile->firstname; ?>" placeholder="Enter firstname" autofocus required>
		</div>
		<div class="form-group">
			<label>Lastname:</label>
			<input type="text" name="lastname" class="form-control" value="<?php echo $profile->lastname; ?>" placeholder="Enter lastname" required>
		</div>
		<div class="form-group">
			<label>Email:</label>
			<input type="text" name="email" class="form-control" value="<?php echo $profile->email; ?>" placeholder="Enter email" required>
		</div>
		<div class="form-group">
			<label>Cellphone:</label>
			<input type="text" name="phone" class="form-control" value="<?php echo $profile->phone; ?>" placeholder="Enter cellphone" required>
		</div>
		<div class="form-group">
			<label>Address:</label>
			<textarea name="address" class="form-control" rows="4" placeholder="Enter address" required><?php echo $profile->address; ?></textarea>
		</div>
		<div class="form-group">
			<button class="btn" name="updateprofile">Update</button>
			<button type="button" class="btn" onclick="runQuery('settings')">Cancel</button>
		</div>
	</form>
</div>