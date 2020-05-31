<?php
	//Generate Statistics Reports
	require_once('../model/report_model.php');
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
		color: #005555;
		/*transform: scale(0);*/
	}
	.container-panel:hover {
		background-color: #ddd;
		/*background-color: #0c8e7e;*/
		/*color: #fff;*/
		border-bottom: 3px solid #034f99;
		cursor: pointer;
	}
	.page-heading {
		font-size: 2em;
		color: #777;
		border-bottom: thin solid #ccc;
		text-align: center;
		padding: 0 0 5px 0;
	}
	.panel-icon {
		font-size: 6em;
		color: #fff !important;
	}
	.panel-text {
		font-size: 1.5em;
		font-weight: bold;
	}
	.container-panel:nth-child(1) {
		background-color: #99ee99 !important;
		color: #fff;
	}
	.container-panel:nth-child(2) {
		background-color: #8888ff !important;
		color: #fff;
	}
	.container-panel:nth-child(3) {
		background-color: #ee9999 !important;
		color: #fff;
	}
	.input-group {
		padding: 8px 0;
	}
	.input-controls {
		width: 93%;
		height: 30px;
		padding: 5px 10px;
		font-size: 16px;
		border-radius:5px;
		border: 1px solid #80b0a9;
		color: #777;
	}
	label {
		font-weight: bold;
		color: #0c8e7e;
	}
	.divider {
		border-bottom: thin solid #80b0a9;
		margin-bottom: 5px;
	}
	#container-upload {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		margin: 0 auto;
		overflow: auto;
		background: rgba(0, 0 ,0, 0.7);
		text-align: center;
		display: none;
		z-index: 99;
	}
	#upload {
		position: relative;
		top: 80px;
		width: 350px;
		height: 150px;
		max-width: 100%;
		background-color: #aaccdd;
		border-radius: 3px;
		border-bottom: 3px solid #99ee99;
		margin: auto;
		padding: 15px;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
		text-align: left;
		z-index: 2;
	}
	#close {
		float: right;
		color: #999;
		font-size: 1.5em;
		font-weight: bold;
		margin-top: -10px;
		cursor: pointer;
	}
	#close:hover {
		color: #ff0000;
	}
	#close:active {
		color: #dd0000;
	}
</style>
<h1 class="page-heading"><i class="fa fa-hdd-o"></i> Manage Backups</h1>
<div class="container">

	<div class="container-panel" onclick="downloadBackup()">
		<div class="panel-icon"><i class="fa fa-cloud-download"></i></div>
		<div class="panel-text">Download Backup</div>
	</div>
	<div class="container-panel" onclick="uploadBackup('container-upload')">
		<div class="panel-icon"><i class="fa fa-cloud-upload"></i></div>
		<div class="panel-text">Upload Backup</div>
	</div>
	<div class="container-panel" onclick="deleteBackup()">
		<div class="panel-icon"><i class="fa fa-trash"></i></div>
		<div class="panel-text">Delete Backups</div>
	</div>

</div>

<div id="container-upload">
	<div id="upload">
		<span id="close" title="close" onclick="closeWindow('container-upload')">&times;</span>
		<form action="router.php" method="POST" enctype="multipart/form-data">
			<div class="input-group"><label>Upload Backup file:</label></div>
			<div class="divider"></div>
			<div class="input-group">
				<input type="file" class="input-controls" name="backupfile">
			</div>
			<div class="input-group">
				<button type="submit" class="btn" name="backup" value="upload">Upload</button>
			</div>
		</form>
	</div>
</div>