<?php
	// Admin Panel
	require_once('router.php');
	$admin->page_protected();
	$allproducts = $product->getAllProducts();
	$msgcount = $admin->getContactMessages();
	$alertCount = ($msgcount != 0) ? '<sup class="alert-notify">'.count($msgcount).'</sup>': '';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Healthy Moves | Admin Welcome</title>
	<meta name="viewpoint" content="width=device-width, initital-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../styles/font-awesome/css/font-awesome.min.css">
	<style type="text/css">
		body {
			font-family: helvetica, arial;
		}
		.container-menu {
			position: fixed;
			top: 0;
			left: 0px;
			width: 300px;
			max-width: 100%;
			height: 700px;
			background-color: #0c8e7e;
			display: inline-block;
			z-index: 1;
		}
		.container-item {
			position: relative;
			top: 0;
			left: 320px;
			width: 1000px;
			max-width: 100%;
			height: 600px;
			overflow-y: auto;
			margin: 0 auto;
			background-color: #ffffff;
			padding: 5px 10px;
			display: inline-block;
			/*box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);*/
		}
		.logo {
			width: 40%;
			border-radius: 10px;
		}
		.menu-heading {
			background-color: #0c8e7e;
			color: #fff;
			font-size: 2em;
			padding: 10px 0;
			text-align: center;
			font-weight: bold;
		}
		.menu-item {
			margin-bottom: 2px;
			background: -webkit-linear-gradient(#45a89a, #78eddf);
			color: #fff;
			padding: 15px 2px;
			cursor: pointer;
			font-weight: bold;
			text-indent: 2px;
		}
		.menu-item.logout:hover {
			background: -webkit-linear-gradient(#a94442, #ff0000) !important;
		}
		.menu-item:hover {
			background: -webkit-linear-gradient(#eee, #bbb);
		}
		.list-item {
			width: 200px;
			height: 200px;
			background-color: #e5e5e5;
			border-radius: 5px;
			box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
			padding: 10px;
			display: inline-block;
			margin-right: 8px;
			margin-bottom: 10px;
		}
		a {
			text-decoration: none;
		}
		.pointer {
			float: right;
			font-weight: bold;
		}
		.contents-heading {
			text-align: center;
			background-color: #0c8e7e;
			color: #fff;
		}
		.alert-message {
			width: 35%;
			max-width: 100%;
			margin: 0px auto;
			background: #f5f5f5;
			color: #777;
			border: 1px solid #ccc;
			border-radius: 5px;
			padding: 15px 10px;
			text-align: left;
			margin-top: 15px;
			margin-bottom: 15px;

		}
		.alert-message.error {
			background: #f2dede;
			color: #a94442;
			border: 1px solid #a94442;
		}
		.alert-message.success {
			background: #dff0d8;
			color:#3c763d;
			border: 1px solid #3c763d;
			
		}
		.loader {
			position: relative;
			top: 150px;
			color: #777;
			font-size: 1.5em;
			margin-left: 40%;
		}
		table {
			width: 100%;
			border: none;
		}
		thead th {
			background-color: #0c8e7e;
			color: #fff;
			padding: 5px;
		}
		tbody tr {
			background-color: #f5f5f5;
			color: #777;
		}
		tbody tr:hover {
			background-color: #ccc;
		}
		tbody td {
			padding: 8px;
		}
		.alert-notify {
			background-color: #d50000;
			padding: 3px 8px;
			border-radius: 50%;
		}
		.btn {
			width: 85px;
			padding: 5px 5px;
			font-weight: bold;
			border: none;
			border-radius: 5px;
			background-color: #45a89a;
			cursor: pointer;
			color: #fff;
		}
		.btn-add {
			width: 100px;
			background-color: #85c1e9;
			padding: 10px;
		}
		.btn-add:hover {
			background-color: #3498db;
		}
		.message {
			color: #dd0000;
			font-weight: bold;
		}
		.fadeOut {
			animation: fadeout 1.25s forwards;
		}
		@keyframes fadeout {
		  /*from { opacity: 1; } to { opacity: 0; display: none;}*/
		  0%  { opacity: 1; }
	  	  100%{opacity: 0; visibility: hidden; }
		}
	</style>
	<script type="text/javascript">
		function doRequest(param, args) {
			switch(param) {
				case 'notifications':
					runRequest(param, null);
				break;
				case 'promotions':
					runRequest(param, null);
				break;
				case 'messages':
					runRequest(param, null);
				break;
				case 'manage':
					runRequest(param, null);
				break;
				case 'addproduct':
					runRequest(param, null);
				break;
				case 'addcategory':
					runRequest(param, null);
				break;
				case 'updateorders':
					runRequest(param, null);
				break;
				case 'reports':
					runRequest(param, null);
				break;
				case 'backups':
					runRequest(param, null);
				break;
				case 'profile':
					runRequest(param, null);
				break;
				case 'updateproduct':
					var args = 'pid='+args;
					runRequest(param, args);
				break;
				case 'editcategory':
					var args = 'edit=true&catId='+args;
					runRequest(param, args);
				break;
			}
		}

		function runRequest(param, args) {
			if(args != '') {
				var url = param+'.php?'+args;
			} else {
				var url = param+'.php';
			}
			var xhr;
			xhr = new XMLHttpRequest();
			document.getElementById('results').innerHTML = "<span class='loader'>Please wait...</span>";
			xhr.open("GET", url, true);
			xhr.onreadystatechange = function() {
				if(xhr.readyState == 4 && xhr.status == 200) {
					document.getElementById('results').innerHTML = xhr.responseText;
				}
				if(xhr.status == 404) {
					document.getElementById('results').innerHTML = "<span class='loader'>ERROR 404: Page not found!</span>";
				}
			}
			xhr.send();
		}

		function confirmLogout() {
			var logout = confirm('Want to logout?');
			if(logout==false) {
				return false;
			}
		}

		function cancelForm() {
			var cancel = confirm('Want to cancel?');
			if(cancel==false) {
				return false;
			}
		}

		function sendMessage() {
			var send = confirm('Send message now?');
			if(send==false) {
				return false;
			}
		}

		function confirmUpdate() {
			var cancel = confirm('Update this order?');
			if(cancel==false) {
				return false;
			}
		}

		function downloadBackup() {
			var download = confirm('Download latest database backup records file?');
			if(download==false) { return false; }
			window.location.href = "router.php?backup=download";
		}
		function uploadBackup(item) {
			var upload = confirm('Do you want to upload backup file to database?');
			if(upload==false) { return false; }
			// window.location.href = "router.php?backup=upload";
			document.getElementById(item).setAttribute('class','');
			document.getElementById(item).style.display = "block";
		}
		function deleteBackup() {
			var remove = confirm('Are you sure want to delete all backup files?');
			if(remove==false) { return false; }
			window.location.href = "router.php?backup=delete";
		}
		function closeWindow(item) {
			// document.getElementById(item).style.display = "none";
			document.getElementById(item).setAttribute('class','fadeOut');
		}
		function viewMessage(elm, param) {
			elm.parentNode.removeChild(elm);
			location.href = "router.php?message=read&date="+param;
		}

		function checkProgress() {
			var elem = document.getElementByClassName('bar-level');
			if(elem[0].style.width < 50) {
				elem[0].style.background =  "red";
			}
		}
		checkProgress();
	</script>
</head>
<body>
	<nav class="container-menu">
		<div><center><a href="index.php"><img src="../images/logo.png" class="logo"></a></center></div>
		<div class="menu-heading">Admin Dashboard</div>
		<a href="javascript:doRequest('notifications');"><div class="menu-item"><i class="fa fa-bell"></i> Notifications<?php echo $alertCount; ?> <span class="pointer">&gt;</span></div></a>
		<a href="javascript:doRequest('manage');"><div class="menu-item"><i class="fa fa-cubes"></i> Manage Products <span class="pointer">&gt;</span></div></a>
		<a href="javascript:doRequest('reports');"><div class="menu-item"><i class="fa fa-line-chart"></i> MIS Reports <span class="pointer">&gt;</span></div></a>
		<a href="javascript:doRequest('backups');"><div class="menu-item"><i class="fa fa-database"></i> Manage Backups <span class="pointer">&gt;</span></div></a>
		<a href="javascript:doRequest('profile');"><div class="menu-item"><i class="fa fa-user-secret"></i> Account Settings <span class="pointer">&gt;</span></div></a>
		<a href="router.php?logout=true" onclick="return confirmLogout()"><div class="menu-item logout"><i class="fa fa-power-off"></i> Logout</div></a>
	</nav>

	<div class="container-item" id="results">
		<?php
			$action = (isset($_GET['action'])) ? $_GET['action'] : '';
			switch ($action) {
				case 'invalid':
					echo '<div class="alert-message error">Your passwords do not match!</div>';
					break;
				case 'success':
					echo '<div class="alert-message success">Record updated successfully!</div>';
					break;
				case 'failed':
					echo '<div class="alert-message error">Sorry failed to update!</div>';
					break;
				case 'null':
					echo '<div class="alert-message error">Please type all required information!</div>';
					break;
				case 'invalidfile':
					echo '<div class="alert-message error">Invalid file upload!</div>';
					break;
				case 'uploadfailed':
					echo '<div class="alert-message error">Failed to upload file!</div>';
					break;
				case 'removed':
					echo '<div class="alert-message success">Backups removed successfully!</div>';
					echo "<script>setTimeout(function(){doRequest('backups', null)}, 2000)</script>"; //delay before load backups panel
				break;
				case 'failremove':
					echo '<div class="alert-message error">Sorry no backups were available!</div>';
					echo "<script>setTimeout(function(){doRequest('backups', null)}, 2000)</script>"; //delay before load backups panel
				break;
				case 'invalidbackup':
					echo '<div class="alert-message error">Invalid backup file upload!</div>';
					echo "<script>setTimeout(function(){doRequest('backups', null)}, 2500)</script>"; //delay before load backups panel
				break;
				case 'done':
					echo '<div class="alert-message success">Backup file uploaded to database successfully!</div>';
				break;
			}
		?>

		<h1 class="contents-heading">Viewing All Products</h1>
		<button type="button" class="btn btn-add" title="Add new product" onclick="doRequest('addproduct', null)"><i class="fa fa-plus"></i> Add New</button>
		<table border="0">
			<thead>
				<th>#ID</th>
				<th>Product Name</th>
				<th>Price</th>
				<th>Category</th>
				<th>Action</th>
			</thead>
			<tbody>
				<?php if($allproducts != false) { ?>
				<?php foreach($allproducts as $row):
					$category = $product->getCategoryName($row->category_id);
				?>
				<tr>
					<td><?php echo $row->id; ?></td>
					<td><?php echo $row->product_name; ?></td>
					<td><?php echo "R ".number_format($row->price, 2); ?></td>
					<td><?php echo $category->category_name; ?></td>
					<td><center><button class="btn" title="edit product" onclick="doRequest('updateproduct',<?php echo $row->id; ?>)">Edit</button></center></td>
				</tr>
				<?php endforeach; ?>
				<?php } else { ?>
					<tr>
						<td colspan="5"><center><span class="message">No products available!</span></center></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<script type="text/javascript">
		//enable/disable file input element on promotions page
		function addMedia() {
			var elmnt = document.getElementById('mediafile');
			if(document.getElementById('add_media').checked) { 
				elmnt.disabled = false;
			} else {
				elmnt.disabled = true;
			}
		}
	</script>
</body>
</html>