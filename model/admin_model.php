<?php
	//admin model
	$basepath = $_SERVER['DOCUMENT_ROOT'].'/'.basename(dirname(__DIR__));
	if( array_search('connection.php', scandir($basepath.'/config/')) ) {
		require_once($basepath.'/config/connection.php');
		require_once('helper_model.php');
		require_once('order_model.php');
	} else { echo "Failed to load: <strong>/config/connection.php</strong>"; }
	
	/**
	 * 
	 */
	class Admin extends Orders {
		private $conn = null;
		
		public function __construct() {
			global $conn;
			$this->conn = $conn;
			// parent::__construct();
		}

		public function page_protected() {
			if(!isset($_SESSION['admin']['token'])) {
				header("Location: login.php");
				exit();
			}
		}

		public function login($params) {
			$stmt = $this->conn->prepare('SELECT username, password FROM admin WHERE username = ? AND password = ?');
			$stmt->bindValue(1, $params['username']);
			$stmt->bindValue(2,  $this->hash_data($params['password']));
			$stmt->execute();
			if($stmt->rowCount() > 0 ) {
				$row = $stmt->fetch();
				$_SESSION['admin']['token'] = $this->hash_data($row->username.rand(1000, 10000));
				$_SESSION['admin']['username'] = $row->username;
				return true;
			}
			else {
				return false;
			}
		}

		public function logout() {
			unset($_SESSION['admin']);
			return true;
		}
		//Update password
		public function updateSettings($params) {
			$stmt = $this->conn->prepare("UPDATE admin SET password = ?");
			$stmt->bindValue(1, $this->hash_data($params['password']));
			if($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		//get Unread Messages OR messages with status of zero
		public function getContactMessages() {
			$stmt = $this->conn->prepare("SELECT * FROM contact WHERE status = 0 ORDER BY created");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			else {
				return 0;
			}
		}
		//update message status to one/ to mark message as read
		public function updateMessage($dated) {
			$stmt = $this->conn->prepare("UPDATE contact SET status = 1 WHERE created = ?");
			$stmt->bindValue(1, $dated);
			if($stmt->execute()) {
				return true;
			}
			else {
				return false;
			}
		}

		//
		public function getAllCustomers() {
			$stmt = $this->conn->prepare("SELECT * FROM customers");
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return $stmt->fetchAll(PDO::FETCH_OBJ);
			}
			else {
				return false;
			}
		}



	}
	if(class_exists('Admin')) {
		$admin = new Admin();
	}
?>