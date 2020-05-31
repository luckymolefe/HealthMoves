<?php
	//promotions page -- send promotions message to customers
	require_once('router.php');
	$admin->page_protected();
	// $webmsgs = $admin->getContactMessages();
	// echo file_get_contents('../responsiveemail.html');
?>
<style type="text/css">
	.container-promotions {
		width: 600px;
		max-width: 100%;
		margin: 0 auto;
		background-color: #fff;
		border-radius: 5px;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		padding: 5px 0;
	}
	.massage-list {
		max-width: 100%;
		height: auto;
		max-height: 600px;
		overflow-y: auto;
		padding: 10px;
	}
	.page-heading {
		font-size: 2em;
		color: #0c8e7e;
		border-bottom: thin solid #ccc;
		text-align: center;
		padding: 0 0 5px 0;
	}
	.input-group {
		padding: 5px;
		margin-bottom: 10px;
	}
	.form-input {
		width: 550px;
		max-width: 100%;
		padding: 10px 5px;
		border: thin solid #ccc;
		border-radius: 5px;
	}
	textarea {
		resize: none;
	}
	label {
		color: #777;
	}
	.btn.btn-send {
		width: 150px;
		padding: 12px 0;
	}
	.list-container {
		position: absolute;
		width: 180px;
		background-color: #f5f5f5;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		padding: 5px;
		border-radius: 5px;
	}
	.list-container li {
		list-style: none;
	}
	.panel-head {
		background-color: #0c8e7e;
		color: #fff;
		border-radius: 5px 5px 0 0;
		text-align: center;
		margin: -5px -5px 10px -5px;
	}
	.delete-link {
		color: #dd0000;
		font-weight: bold;
		float: right;
	}
	.item-list {
		color: #0c8e7e;
	}
	@media screen and (max-width: 980px) {
		.list-container {
			position: relative;
		}
	}
</style>
<div class="list-container">
	<div class="panel-head">Promotional Items Sent</div>
	<?php
		$files = scandir($basepath.'/promotions/');
		array_shift($files);
		array_shift($files);
		if(count($files) > 0) {
			foreach($files as $filename) :
	?>
		<li class="item-list"><?php echo $filename; ?><a href="?delete_promo=true&file=<?php echo base64_encode($filename); ?>" class="delete-link">&times;</a></li>
	<?php endforeach; } else { ?>
		<li style="text-align: center;color: #dd0000"><strong>No sales promotions.</strong></li>
	<?php } ?>
</div>

<div class="container-promotions">
	<h1 class="page-heading"><i class="fa fa-gift"></i> Send Promotional Notifications</h1>
	<form action="router.php" method="POST" enctype="multipart/form-data">
		<div class="input-group"><label>**NOTE: Message will be send to all Healthy Moves customers.</label></div>
		<div class="input-group">
			<div><label>Message Title:</label></div>
			<input type="text" class="form-input" name="title" placeholder="Enter title here" required>
		</div>
		<div class="input-group">
			<div><label>Your message can include html tags:</label></div>
			<textarea class="form-input" rows="10" name="message" placeholder="Enter promotional message"></textarea>
		</div>
		<div class="input-group">
			<div>
				<label><input type="checkbox" name="add_media" id="add_media" onclick="addMedia()">Attach promotional image to your message:</label>
			</div>
			<input type="file" class="form-input" id="mediafile" name="mediafile" disabled>
		</div>
		<div class="input-group">
			<button type="submit" class="btn btn-send" name="create_promo" onclick="return sendMessage();">Send</button>
		</div>
	</form>
</div>
