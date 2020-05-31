<?php

//all notifications, including specials sales and promotions
// echo "Page will display list of messages send by admin"
require_once('router.php');
$customer->page_protected();

$profile = $customer->getCustomer($_SESSION['customer']['uid']);
$basepath = $basepath."/promotions/";

$files = scandir($basepath);
array_shift($files); //remove (.)
array_shift($files); //remove (..)

if(count($files) > 0) {
	foreach($files as $file) {
		if(is_file($basepath.$file) ) {
			$filedata = file_get_contents($basepath.$file);
			echo $filedata;
			break;
		}
	}
}
else {
	echo "<div class='message'><center>No Messages Available!</center></div>";
}

?>