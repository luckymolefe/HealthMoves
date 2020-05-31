<?php
	//
	require_once('router.php');
	$admin->page_protected();
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

</style>
<h1 class="page-heading"><i class="fa fa-cogs"></i> Manage Shop Items</h1>
<div class="container">
	<div class="container-panel" title="Manage categories" onclick="doRequest('addcategory')">
		<div class="panel-icon"><i class="fa fa-list-ol"></i></div>
		<div class="panel-text">Categories</div>
	</div>
	<div class="container-panel" title="Add new products" onclick="doRequest('addproduct')">
		<div class="panel-icon"><i class="fa fa-cubes"></i></div>
		<div class="panel-text">Products Items</div>
	</div>
	<div class="container-panel" title="Manage orders" onclick="doRequest('updateorders')">
		<div class="panel-icon"><i class="fa fa-truck"></i></div>
		<div class="panel-text">Order Items</div>
	</div>
</div>