<?php
	//register user page
?>
<!DOCTYPE html>
<html>
<head>
	<title>Healthy Moves | REGISTER</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
		body {
			font-family: helvetica, arial;
		}
		.login-container {
			width: 400px;
			max-width: 100%;
			margin: 0 auto;
			border-radius: 5px;
			background-color: #fff;
			border: thin solid #0c8e7e;
			padding: 10px;
			box-shadow: 1px 1px 6px rgba(0, 0, 0, 0.2);
			margin-top: 30px;
		}
		.input-group {
			padding: 5px 0;
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
		.login-btn {
			width: 150px;
			padding: 12px 10px;
			background-color: #45a89a;
			color: #fff;
			border-radius: 5px;
			font-weight: bold;
			border: none;
			cursor: pointer;
		}
		.login-btn:hover {
			background-color: #80b0a9;
			color: #fff;
		}
		.login-btn:active {
			background-color: #0c8e7e;
			color: #fff;
		}
		.login-heading {
			position: relative;
			top: -10px;
			/*eft: -10px;*/
			background-color: #0c8e7e;
			text-align: center;
			font-size: 1.5em;
			padding: 5px 10px;
			margin-left: -10px;
			margin-right: -10px;
			color: #fff;
		}
		label {
			color: #777;
			font-weight: bold;
		}
		.link {
			color: #777;
			text-align: center;
			padding-top: 15px;
		}
		.logo {
			width: 100px;
		}
		.alert-message {
			width: 32%;
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
		.alert-message.success{
			background: #dff0d8;
			color:#3c763d;
			border: 1px solid #3c763d;
			
		}
	</style>
</head>
<body>
	<?php
		$action = (isset($_GET['action'])) ? $_GET['action'] : '';
		switch ($action) {
			case 'invalid':
				echo '<div class="alert-message error">Invalid email address!</div>';
				break;
			case 'success':
				echo '<div class="alert-message success">Account registered successfully!</div>';
				break;
			case 'null':
				echo '<div class="alert-message error">Please type username and password!</div>';
				break;
			case 'error':
				echo '<div class="alert-message error">Error occured: sorry your registration has failed!</div>';
			break;
		}
	?>
	
	<div class="login-container">
		<div class="login-heading">
			Register
		</div>
		<center><img src="../images/logo.png" class="logo"></center>
		<form action="router.php" method="POST" enctype="application/www-forms-urlencoded">
			<div class="input-group">
				<div><label>Firstname:</label></div>
				<input type="text" name="firstname" class="input-controls" placeholder="Enter firstname" autocomplete="off" autofocus required>
			</div>
			<div class="input-group">
				<div><label>Lastname:</label></div>
				<input type="text" name="lastname" class="input-controls" placeholder="Enter lastname" autocomplete="off" required>
			</div>
			<div class="input-group">
				<div><label>Email:</label></div>
				<input type="email" name="email" class="input-controls" placeholder="Enter email" autocomplete="off" required>
			</div>
			<div class="input-group">
				<div><label>Password:</label></div>
				<input type="password" name="password" class="input-controls" placeholder="Enter your password" autocomplete="off" required>
			</div>
			<div class="input-group">
				<button type="submit" name="register" class="login-btn">Register</button>
			</div>
		</form>
		<div class="link">
			Already have a member? <a href="login.php">Login here</a>
		</div>
		<div>
			<a href="../index.php">&larr; Home</a>
		</div>
	</div>

</body>
</html>