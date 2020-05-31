<?php
//Reports Model
require_once('order_model.php');
/**
 * 
 */
class Reports extends Orders {
	private $conn = null;

	public function __construct() {
		global $conn;
		$this->conn = $conn;
	}
	
	public function countAllProducts() {
		$stmt = $this->conn->prepare('SELECT id FROM products');
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function countAllOrders() {
		$stmt = $this->conn->prepare("SELECT order_id FROM orders");
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function getPendingOrders() {
		$stmt = $this->conn->prepare("SELECT order_id FROM orders WHERE order_status = 0");
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function countPaidOrders() {
		$stmt = $this->conn->prepare("SELECT order_id FROM orders WHERE order_status = 1");
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function countAllCustomers() {
		$stmt = $this->conn->prepare("SELECT id FROM customers");
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function countDepositTransactions() {
		$paytype = "bankdeposit";
		$stmt = $this->conn->prepare("SELECT order_id FROM orders WHERE payment_type = ?");
		$stmt->bindValue(1, $paytype);
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function countEftTransactions() {
		$paytype = "eft";
		$stmt = $this->conn->prepare("SELECT order_id FROM orders WHERE payment_type = ?");
		$stmt->bindValue(1, $paytype);
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function countAllCreditTransactions() {
		$paytype = "creditcard";
		$stmt = $this->conn->prepare("SELECT order_id FROM orders WHERE payment_type = ?");
		$stmt->bindValue(1, $paytype);
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function countAllCategories() {
		$stmt = $this->conn->prepare("SELECT id FROM categories");
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function totalAmount() {
		$stmt = $this->conn->prepare("SELECT SUM(order_total) AS totalAmount FROM orders");
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			return $stmt->fetch(PDO::FETCH_OBJ);
		} else {
			return 0;
		}
	}

	public function totalPaidInv() {
		$stmt = $this->conn->prepare("SELECT SUM(order_total) AS totalPaid FROM orders WHERE order_status = 1");
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			return $stmt->fetch(PDO::FETCH_OBJ);
		} else {
			return "0";
		}
	}

	public function totalunPaidInv() {
		$stmt = $this->conn->prepare("SELECT SUM(order_total) AS totalUnPaid FROM orders WHERE order_status = 0");
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			return $stmt->fetch(PDO::FETCH_OBJ);
		} else {
			return 0;
		}
	}
	//get total orders sales of current year
	public function curYearSale() {
		$currYear = date('Y'); //get current year
		$stmt = $this->conn->prepare("SELECT SUM(order_total) AS currTotalSale FROM orders WHERE YEAR(created) = :year");
		$stmt->bindParam('year', $currYear);
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			return $stmt->fetch(PDO::FETCH_OBJ);
		}
		else {
			return false;
		}
	}
	//get total orders sales of previous year
	public function prevYearSale() {
		//$prevYear = date('Y')-1; //get previous year, minus 1year from current year
		$stmt = $this->conn->prepare("SELECT SUM(order_total) AS prevTotalSale, YEAR(NOW()-INTERVAL 1 YEAR) AS dated FROM orders WHERE YEAR(created) = YEAR(NOW() - INTERVAL 1 YEAR)");
		//$stmt->bindParam('year', $prevYear);
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			return $stmt->fetch(PDO::FETCH_OBJ);
		}
		else {
			return false;
		}
	}
	//get Average of orders for current year
	public function curAverageSale() {
		$curYear = date('Y'); //get current year
		$stmt = $this->conn->prepare("SELECT ROUND(AVG(order_total),2) AS curAvgSale FROM orders WHERE YEAR(created) = :year");
		$stmt->bindParam('year', $curYear);
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			return $stmt->fetch(PDO::FETCH_OBJ);
		}
		else {
			return false;
		}
	}
	//get current month total sales
	public function curMonthSale() {
		$curMonth = date('m'); //get current month
		$stmt = $this->conn->prepare("SELECT SUM(order_total) AS curMonthSale FROM orders WHERE MONTH(created) = :month");
		$stmt->bindParam('month', $curMonth);
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			return $stmt->fetch(PDO::FETCH_OBJ);
		}
		else {
			return false;
		}
	}
	//get previous month total sales
	public function prevMonthSale() {
		//$prevMonth = (date('m')-1 == 0) ? 12 : date('m')-1; //get previous year, minus 1month from current MONTH
		$stmt = $this->conn->prepare("SELECT SUM(order_total) AS prevMonthSale, MONTHNAME(NOW() - INTERVAL 1 MONTH) AS dated FROM orders WHERE MONTH(created) = MONTH(NOW() - INTERVAL 1 MONTH)");
		//$stmt->bindParam('month', $prevMonth);
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			return $stmt->fetch(PDO::FETCH_OBJ);
		}
		else {
			return false;
		}
	}
	//get Average monthy total sales
	public function MonthlyAvgSale() {
		$curMonth = date('m'); //get previous month average total
		$stmt = $this->conn->prepare("SELECT ROUND(AVG(order_total),2) AS avgMonthlySale FROM orders WHERE MONTH(created) = :month");
		$stmt->bindParam('month', $curMonth);
		$stmt->execute();
		if($stmt->rowCount() > 0) {
			return $stmt->fetch(PDO::FETCH_OBJ);
		}
		else {
			return false;
		}
	}

}
if(class_exists('Reports')) {
	$report = new Reports();
}
?>