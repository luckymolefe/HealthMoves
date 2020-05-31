<?php
	//
	require_once('router.php');
	$admin->page_protected();
	$webmsgs = $admin->getContactMessages();
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
		/*transform: scale(0);*/
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
	.notify {
		position: fixed;
		right: 50px;
		width: 60px;
		height: 60px;
		background-color: #fff;
		border-radius: 30px;
		box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);
		cursor: pointer;
		box-sizing: border-box;
	}
	.notify-icon {
		color: #0c8e7e;	
		font-size: 2em;
		line-height: 2;
	}
	.alert-counter {
		position: absolute;
		top: 0px;
		background-color: #d50000;
		color: #fff;
		padding: 3px 8px;
		border-radius: 50%;
	}
	.notify:hover {
		width: 400px;
		height: 60px;
		text-align: left;
		padding: 0 15px;
		border-bottom-left-radius: 0;
		border-bottom-right-radius: 0;
		background-color: #0c8e7e;
	}
	.notify:hover .notify-icon {
		color: #fff;
	}
	.notify:hover .alert-counter {
		position: relative;
		background: transparent;
		font-size: 1.5em;
	}
	.notify:hover .alert-counter:after {
		content: ' Notifications';
	}
	ul {
		position: absolute;
		left: 0;
		top: 60px;
		margin: 0;
		width: 100%;
		max-height: 200px;
		background-color: #fff;
		padding: 10px;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		box-sizing: border-box;
		border-bottom-left-radius: 5px;
		border-bottom-right-radius: 5px;
		display: none;
	}
	.notify:hover ul {
		display: block;
		transition: display 500ms ease-in;
		overflow-y: auto;
	}
	ul li {
		list-style: none;
		border-bottom: 1px solid #ddd;
		padding: 8px 0;
		/*display: flex;*/
		text-overflow: text-wrap;
	}
	ul li:last-child {
		border-bottom: none;
	}
	ul li:hover {
		color: #0c8e7e;
	}
</style>
<h1 class="page-heading"><i class="fa fa-cogs"></i> Manage Notifications</h1>
<div class="container">
	<div class="container-panel" title="View recieved messages" onclick="doRequest('messages')">
		<div class="panel-icon"><i class="fa fa-bell"></i></div>
		<div class="panel-text">Messages</div>
	</div>
	<div class="container-panel" title="Send promotional message" onclick="doRequest('promotions')">
		<div class="panel-icon"><i class="fa fa-gift"></i></div>
		<div class="panel-text">Products Promotions</div>
	</div>
	<div class="notify">
		<i class="fa fa-bell notify-icon"></i><sup class="alert-counter"><?php echo ($webmsgs != 0) ? count($webmsgs) : '0'; ?></sup>
		<ul>
			<?php if($webmsgs != 0) { ?>
			<?php foreach($webmsgs as $msg) : ?>
			<li onclick="doRequest('messages')"><i class="fa fa-info-circle"></i> <?php echo $msg['subject'].': '.$msg['message']; ?></li>
			<?php endforeach; ?>
			<?php } else { ?>
				<li><center><i class="fa fa-warning"></i> No Messages</center></li>
			<?php } ?>
			<!-- <li><i class="fa fa-info-circle"></i> Message 1</li> -->
		</ul>
	</div>
</div>