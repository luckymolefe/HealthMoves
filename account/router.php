<?php
	//Act as a controller routing requests
	$basepath = $_SERVER['DOCUMENT_ROOT'].'/'.basename(dirname(__DIR__));
	require_once($basepath.'/model/customer_model.php');
	require_once($basepath.'/model/order_model.php');

	//on customer create account
	if(isset($_POST['register'])) {
		if(empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['password']) ) {
			header("Location: register.php?action=null");
			exit();
		}
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			header("Location: register.php?action=invalid");
			exit();
		}
		$sanitize = array('firstname' => $_POST['firstname'],
						'lastname' => $_POST['lastname'],
						'email' => $_POST['email'],
						'password' => $_POST['password']
						);
		$params = $customer->sanitize($sanitize);
		$response = $customer->register($params);
		if($response) {
			header("Location: register.php?action=success");
			exit();
		}
		else {
			header("Location: register.php?action=error");
			exit();
		}
	}

	//on customer login
	if(isset($_POST['login'])) {
		if(empty($_POST['email']) || empty($_POST['password']) ) {
			header("Location: login.php?action=null");
			exit();
		}
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			header("Location: login.php?action=invalid");
			exit();
		}
		$sanitize = array('email' => $_POST['email'], 'password' => $_POST['password']);
		$params = $customer->sanitize($sanitize);
		if($customer->login($params)) {
			header("Location: index.php");
			exit();
		}
		else {
			header("Location: login.php?action=invalid");
			exit();
		}
	}

	//on customer logout
	if(isset($_GET['logout']) && $_GET['logout'] == "true") {
		if($customer->logout()) {
			header("Location: login.php?action=success");
			exit();
		}
	}

	//on customer update request
	if(isset($_POST['updateprofile'])) {
		$sanitize = array('uid' => $_POST['uid'],
						'firstname' => $_POST['firstname'],
						'lastname' => $_POST['lastname'],
						'email' => $_POST['email'],
						'phone' => $_POST['phone'],
						'address' => nl2br($_POST['address'])
						);
		if(array_search(null, $sanitize)) {
			header("Location: index.php?action=null");
			exit();
		}
		$params = $customer->sanitize($sanitize);
		if($customer->updateAccount($params)) {
			header("Location: index.php?action=updated");
			exit();
		}
		else {
			header("Location: index.php?action=failed");
			exit();
		}
	}
	//
	if(isset($_POST['saveccard'])) {
		$sanitize = array(
			'uid' => $_SESSION['customer']['uid'],
			'cardtype' => $_POST['cardType'],
			'cardNumber' => $_POST['cc_number'],
			'cardExpMonth' => $_POST['exp_month'],
			'cardExpYear' => $_POST['exp_year'],
			'cardValue' => $_POST['cvv_number'],
			'cardHolder' => $_POST['holder_name']
		);
		if(array_search(null, $sanitize)) {
			header("Location: index.php?action=null");
			exit();
		}
		$params = $customer->sanitize($sanitize);

		$pattern = '/^[[:digit:]]{4}(-[[:digit:]]{4}){3}$/';
		if(!preg_match($pattern, $params['cardNumber'])) { //if match did not follow pattern
			header("Location: index.php?action=invalid");
			exit();
		}
		if($customer->addCreditCard($params)) {
			header("Location: index.php?action=success");
			exit();
		}
		else {
			header("Location: index.php?action=failed");
			exit();
		}
	}
	//
	if(isset($_POST['updatecard'])) {
		$sanitize = array(
			'uid' => $_SESSION['customer']['uid'],
			'cardtype' => $_POST['cardType'],
			'cardNumber' => $_POST['cc_number'],
			'cardExpMonth' => $_POST['exp_month'],
			'cardExpYear' => $_POST['exp_year'],
			'cardValue' => $_POST['cvv_number'],
			'cardHolder' => $_POST['holder_name'],
			'timestamp' => urldecode($_POST['timestamp'])
		);
		if(array_search(null, $sanitize)) {
			header("Location: index.php?action=null");
			exit();
		}
		$params = $customer->sanitize($sanitize);
		/*if(!preg_match('/^[a-zA-Z]*$/', $params['cardHolder'])) {
			header("Location: index.php?action=invalid");
			exit();
		} elseif(!preg_match('/^[a-zA-Z]*$/', $params['cardType'])) {
			header("Location: index.php?action=invalid");
			exit();
		} elseif(!preg_match('/^([0-9]\-){4}+([0-9]\-){4}+([0-9]\-){4}+([0-9]\-){4}$/', $params['cardNumber'])) {
			header("Location: index.php?action=invalid");
			exit();
		} elseif(!preg_match('/^[0-9]$/', $params['cardValue'])) {
			header("Location: index.php?action=invalid");
			exit();
		} elseif(!preg_match('/^[0-9]$/', $params['cardExpMonth']) || !preg_match('/^[0-9]$/', $params['cardExpYear'])) {
			header("Location: index.php?action=invalid");
			exit();
		}*/

		$pattern = '/^[[:digit:]]{4}(-[[:digit:]]{4}){3}$/';
		if(!preg_match($pattern, $params['cardNumber'])) {
			header("Location: index.php?action=invalid");
			exit();
		}
		if($customer->updateCreditCard($params)) {
			header("Location: index.php?action=updated");
			exit();
		}
		else {
			header("Location: index.php?action=failed");
			exit();
		}
	}

	//remove card
	if(isset($_REQUEST['removecard'])) {
		$cardNum = $_REQUEST['cardnum'];
		if($customer->removeCard($cardNum)) {
			header("Location: index.php?action=updated");
			exit();
		}
		else {
			header("Location: index.php?action=failed");
			exit();
		}
	}

	//on customer change password
	if(isset($_GET['setting'])) {
		if(empty($_POST['newpassword']) || empty($_POST['confirmpassword']) || empty($_SESSION['customer']['uid'])) {
			header("Location: login.php?action=null");
			exit();
		}
		$sanitize = array('password'=>$_POST['newpassword'], 'uid'=>$_SESSION['customer']['uid']);
		if($customer->updatePassword($params)) {
			header("Location: index.php?action=updated");
			exit();
		}
		else {
			header("Location: index.php?action=failed");
			exit();
		}
	}

?>