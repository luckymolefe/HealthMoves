<?php
	//Message list
	require_once('router.php');
	$admin->page_protected();
	$webmsgs = $admin->getContactMessages();
?>
<style type="text/css">
	.container-message {
		width: 800px;
		max-width: 100%;
		margin: 0 auto;
		background-color: #fff;
		border-radius: 5px;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
	}
	.massage-list {
		max-width: 100%;
		height: auto;
		max-height: 600px;
		overflow-y: auto;
		padding: 10px;
	}
	.message-item {
		background-color: #0c8e7e;
		color: #fff;
		border-radius: 5px;
		margin-bottom: 10px;
		padding: 5px;
	}
	.message-item:hover {
		background-color: #45a89a;
		cursor: pointer;
	}
	.page-heading {
		font-size: 2em;
		color: #0c8e7e;
		border-bottom: thin solid #ccc;
		text-align: center;
		padding: 0 0 5px 0;
	}
	.lead {
		font-size: 1.2em;
		font-weight: bold;
	}
</style>
<div class="container-message">
	<h1 class="page-heading"><i class="fa fa-envelope"></i> Messages</h1>
	<div class="massage-list">
		<?php if($webmsgs != 0) { ?>
		<?php foreach($webmsgs as $row) : ?>
		<div class="message-item" onclick="viewMessage(this, '<?php echo urlencode($row['created']); ?>')">
			<div>From: <?php echo $row['name']; ?></div>
			<div><?php echo $row['email']; ?></div>
			<div><?php echo $row['cell_no']; ?></div>
			<p class="lead"><?php echo $row['subject']; ?></p>
			<div><?php echo $row['message']; ?></div>
		</div>
		<?php endforeach; ?>
		<?php  } else { ?>
			<div class="message-item"><center><i class="fa fa-info-circle"></i> No Messages</center></div>
		<?php } ?>
	</div>
</div>