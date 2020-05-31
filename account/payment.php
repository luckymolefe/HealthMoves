<?php
	//
	require_once('router.php');
	$customer->page_protected();
?>
<style type="text/css">
	.container {
		width: 600px;
		max-width: 100%;
		margin: 0 auto;
		background-color: #f5f5f5;
		padding: 10px;
		border-radius: 5px;
		margin-top: 20px;
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
	.date {
		width: 80px !important;
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
	<div class="heading">Add Credit Card</div>
	<form action="router.php" method="POST" enctype="application/x-www-forms-urlencoded">
		<div class="form-group">
			<label>Credit Card Type:</label>
			<select class="form-control" name="cardType">
				<option value="visa">Visa</option>
				<option value="mastercard">Master Card</option>
				<option value="discover">Discover</option>
			</select>
		</div>
		<div class="form-group">
			<label>Credit Card Number:</label>
			<input type="text" name="cc_number" class="form-control" maxlength="19" placeholder="****-****-****-****" autocomplete="off" onkeyup="cardValidation(this)" autofocus >
		</div>
		<div class="form-group">
			<label>Card Expiry Date:</label><br/>
			<input type="text" name="exp_month" class="form-control date" maxlength="2"  placeholder="mm" autocomplete="off" >
			<input type="text" name="exp_year" class="form-control date" maxlength="2"  placeholder="yy" autocomplete="off" >
		</div>
		<div class="form-group">
			<label>Card Verification Value Number <small>(CVV)</small>:</label><br/>
			<input type="text" name="cvv_number" class="form-control date" maxlength="3"  placeholder="---" autocomplete="off" >
		</div>
		<div class="form-group">
			<label>Account Holder</label><br/>
			<input type="text" name="holder_name" class="form-control" placeholder="Enter card holder names" autocomplete="off" >
		</div>
		<div class="form-group">
			<button class="btn" name="saveccard">Save</button>
			<button type="button" class="btn" onclick="runQuery('settings')">Cancel</button>
		</div>
	</form>
</div>