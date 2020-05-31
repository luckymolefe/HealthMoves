<?php
	//Generate Statistics Reports Page
	$basepath = $_SERVER['DOCUMENT_ROOT'].'/'.basename(dirname(__DIR__));
	require_once($basepath.'/model/report_model.php');

	//get all customers, products and orders
	$allCust = $report->countAllCustomers();
	$allproducts = $report->countAllProducts();
	$allorders = $report->countAllOrders();
	//get count all pending and paid orders
	$pending = $report->getPendingOrders();
	$paid = $report->countPaidOrders();
	$alleft = $report->countEftTransactions();
	//get all transaction types
	$alldep = $report->countDepositTransactions();
	$alltransact = $report->countAllCreditTransactions();
	$allcatgry = $report->countAllCategories();
	//get paid and unpaid orders
	$tunover = $report->totalAmount();
	$totalpaid = $report->totalPaidInv();
	$totalunpaid = $report->totalunPaidInv();
	//get yearly sales
	$currYear = $report->curYearSale();
	$prevYear = $report->prevYearSale();
	$curAvg = $report->curAverageSale();
	//get monthly sales
	$curMonth = $report->curMonthSale();
	$prevMonth = $report->prevMonthSale();
	$curMonthlyAvg = $report->MonthlyAvgSale();
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
	}
	.page-heading {
		font-size: 2em;
		color: #777;
		border-bottom: thin solid #ccc;
		text-align: center;
		padding: 0 0 5px 0;
	}
	.panel-text {
		font-size: 1.5em;
		font-weight: bold;
	}
	.panel-stats {
		font-size: 5em;
		color: #034f99;
	}
	.small {
		margin-top: 20px;
		font-size: 2.5em;
		color: #fff !important;
	}
	.amounts {
		margin-top: 20px;
		font-size: 2.2em;
		font-weight: bold;
		color: #00bbcc;
	}
	.container-panel:nth-child(11) {
		background-color: #99ee99 !important;
		color: #fff;
	}
	.container-panel:nth-child(12) {
		background-color: #ee9999 !important;
		color: #fff;
	}
	.container-panel:nth-child(13) {
		background-color: #8888ff !important;
		color: #fff;
	}
	.chart-container {
		position: relative;
		width: 850px;
		max-width: 100%;
		height: 250px;
		margin: 0 auto;
		margin-bottom: 10px;
		background-color: #f5f5f5;
		border: thin solid #f7f7f7;
		color: #555;
		border-radius: 5px;
		padding: 0 10px;
		box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6);
	}
	.bar {
		position: relative;
		width: 100%;
		height: 20px;
		max-width: 100%;
		background-color: tomato; /*#85c1e9*/
		border: thin solid #0c8e7e;
		margin-bottom: 8px;
		border-radius: 5px;
		/*transform: rotateZ(-90deg);*/
		/*display: inline-block;*/
	}
	.bar-level {
		width: 0%;
		max-width: 100%;
		height: 18px;
		background: -webkit-linear-gradient(#0c8e7e, #034f99); /*tomato;*/
		border-radius: 4px;
		border: none;
		color: #fff;
		padding: 1px;
		/*transition-duration: 0.4s;
		transform: width ;*/
		/*border: thin solid red !important;
	    transition: border 500ms ease-in;*/
	}
	/*.expand {
		width: 80%;
		transition: width 1.5s linear ease-in;
		transition-delay: 2s;
	}*/
	
	@keyframes load {
		from { width: 0% } to { width: 50%; }
	}
	/*@import*/
</style>
<h1 class="page-heading"><i class="fa fa-line-chart"></i> Reports</h1>
<div class="container">
	<div class="chart-container">
		<h4><center>Statistical Chart</center></h4>
		<div align="left">Products Level <i style="float: right;"><?php echo round(($allproducts-$paid)); ?>%</i></div>
		<div class="bar">
			<div class="bar-level" style="width:<?php echo round(($allproducts-$paid)); ?>%"></div>
		</div>
		<div align="left">Orders Level <i style="float: right;"><?php echo round(($allorders-$paid)); ?>%</i></div>
		<div class="bar">
			<div class="bar-level" style="width:<?php echo round(($allorders-$paid)); ?>%"></div>
		</div>

	</div>

	<div class="container-panel">
		<div class="panel-text">All Customers</div>
		<div class="panel-stats"><?php echo $allCust; ?></div>
	</div>
	<div class="container-panel">
		<div class="panel-text">All Categories</div>
		<div class="panel-stats"><?php echo $allcatgry; ?></div>
	</div>
	<div class="container-panel">
		<div class="panel-text">Total Products</div>
		<div class="panel-stats"><?php echo $allproducts; ?></div>
	</div>


	<div class="container-panel">
		<div class="panel-text">Total Orders</div>
		<div class="panel-stats"><?php echo $allorders; ?></div>
	</div>
	<div class="container-panel">
		<div class="panel-text">Unpaid Orders</div>
		<div class="panel-stats"><?php echo $pending; ?></div>
	</div>
	<div class="container-panel">
		<div class="panel-text">Paid Orders</div>
		<div class="panel-stats"><?php echo $paid; ?></div>
	</div>
	

	<div class="container-panel">
		<div class="panel-text">Deposit Transactions</div>
		<div class="panel-stats"><?php echo $alldep; ?></div>
	</div>
	<div class="container-panel">
		<div class="panel-text">EFT Transactions</div>
		<div class="panel-stats"><?php echo $alleft; ?></div>
	</div>
	<div class="container-panel">
		<div class="panel-text">Credit Transactions</div>
		<div class="panel-stats"><?php echo $alltransact; ?></div>
	</div>
	
	<!--  -->
	<div class="container-panel">
		<div class="panel-text">Total Amount Value</div>
		<div class="panel-stats small">R<?php echo $tunover->totalAmount; ?></div>
	</div>
	<div class="container-panel">
		<div class="panel-text">Total unPaid</div>
		<div class="panel-stats small">R<?php echo $totalunpaid->totalUnPaid; ?></div>
	</div>
	<div class="container-panel">
		<div class="panel-text">Total Balance</div>
		<div class="panel-stats small">R<?php echo number_format(($tunover->totalAmount - $totalunpaid->totalUnPaid),2); ?></div>
	</div>

	<!-- Display total sums for previous and current for each year and Average current year -->
	<div class="container-panel">
		<div class="panel-text">Total Sales (<?php echo $prevYear->dated; ?>)</div>
		<div class="panel-stats amounts">R<?php echo number_format($prevYear->prevTotalSale); ?></div>
	</div>
	<div class="container-panel">
		<div class="panel-text">Total Sales (<?php echo date('Y'); ?>)</div>
		<div class="panel-stats amounts">R<?php echo number_format($currYear->currTotalSale); ?></div>
	</div>
	<div class="container-panel">
		<div class="panel-text">Average Sales (<?php echo date('Y'); ?>)</div>
		<div class="panel-stats amounts">R<?php echo number_format($curAvg->curAvgSale); ?></div>
	</div>

	<!-- Display Total Sum Monthly Sales -->
	<div class="container-panel">
		<div class="panel-text">Total Sales (<?php echo substr($prevMonth->dated, 0,3); ?>)</div>
		<div class="panel-stats amounts">R<?php echo number_format($prevMonth->prevMonthSale); ?></div>
	</div>
	<div class="container-panel">
		<div class="panel-text">Total Sales (<?php echo date('M'); ?>)</div>
		<div class="panel-stats amounts">R<?php echo number_format($curMonth->curMonthSale); ?></div>
	</div>
	<div class="container-panel">
		<div class="panel-text">Average Sales (<?php echo date('M'); ?>)</div>
		<div class="panel-stats amounts">R<?php echo number_format($curMonthlyAvg->avgMonthlySale); ?></div>
	</div>
	
</div>