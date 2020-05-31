<?php
	//Act as a controller routing requests
	$basepath = $_SERVER['DOCUMENT_ROOT'].'/'.basename(dirname(__DIR__));
	//look up for the described file, in this specified directory
	if( array_search('admin_model.php', scandir($basepath.'/model/')) ) {
		require_once($basepath.'/model/admin_model.php');
	} else { echo "Failed to load: <strong>/model/admin_model.php</strong>"; }

	//Admin login request
	if(isset($_POST['login'])) {
		if(empty($_POST['email']) || empty($_POST['password'])) {
			header("Location: login.php?action=null");
			exit();
		}
		$sanitize = array('username' => $_POST['email'], 'password' => $_POST['password']);
		$params = $admin->sanitize($sanitize);
		if(!filter_var($params['username'], FILTER_VALIDATE_EMAIL)) {
			header("Location: login.php?action=invalid");
			exit();
		}
		if($admin->login($params)) {
			header("Location: index.php");
			exit();
		}
		else {
			header("Location: login.php?action=invalid");
			exit();
		}
	}
	//Admin logout request
	if(isset($_GET['logout'])) {
		if($admin->logout()) {
			header("Location: login.php?action=success");
			exit();
		}
	}

	//
	if(isset($_POST['updatepassword'])) {
		if(empty($_POST['newpassword']) || empty($_POST['confirmpassword'])) {
			header("Location: index.php?action=null");
			exit();
		}
		if($_POST['newpassword'] != $_POST['confirmpassword']) {
			header("Location: index.php?action=invalid");
			exit();
		}
		$sanitize = array('password' => $_POST['newpassword']);
		$params = $admin->sanitize($sanitize);
		if($admin->updateSettings($params)) {
			header("Location: index.php?action=success");
			exit();
		}
		else {
			header("Location: index.php?action=failed");
			exit();
		}
	}

	//Admin create new product
	if(isset($_POST['addproduct'])) {
		
		if(empty($_POST['productName']) || empty($_POST['price']) || empty($_POST['category']) || empty($_FILES['mediafile']['name'])) {
			header("Location: index.php?action=null");
			exit();
		}

		$filetypes = array('image/jpg', 'image/jpeg', 'image/png'); //array list of image file types allowed.

		if(!in_array($_FILES['mediafile']['type'], $filetypes)) { //validate file type before upload
			header("Location: index.php?action=invalidfile");
			exit();
		}
		//define path for upload
		$filename = $_FILES['mediafile']['name']; //get file name

		$file_info = explode('.', $filename);
		$file_ext = end($file_info);
		$file_ext = strtolower($file_ext);
		$filename = "IMG_".date('Ymd')."_".rand().".".$file_ext;

		//check if directory exist, create one if not exists
		if(is_dir($basepath.'/images/products')) {
			mkdir($basepath.'/images/products');
		}

		$path = $basepath."/images/products/"; //get directory path for upload
		$uploadpath = $path.$filename; //combine direcotry path and image file name

		if(move_uploaded_file($_FILES['mediafile']['tmp_name'], $uploadpath)) { //upload file to directory
			$sanitize = array('productName' => $_POST['productName'],
							 'price' => $_POST['price'],
							 'description' => $_POST['description'],
							 'category' => $_POST['category'],
							 'urlpath' => $filename
							);
			$params = $admin->sanitize($sanitize);
			if($product->createProduct($params)) {
				header("Location: index.php?action=success");
				exit();
			}
			else {
				header("Location: index.php?action=failed");
				exit();
			}
		}
		else { //if image fail to upload
			header("Location: index.php?action=uploadfailed");
			exit();
		}
		if (!move_uploaded_file($_FILES['mediafile']['tmp_name'], $uploadpath)) { //if failed to move image file to specified directory show message.
			exit("Problem: Could not move file to destination directory.");
		}
	}
	//Admin update product
	if(isset($_POST['updateproduct'])) {
		$sanitize= array('productName' => $_POST['productName'],
						 'price' => $_POST['price'],
						 'category' => $_POST['category'],
						 'pid' => $_POST['pid']
						);
		$params = $admin->sanitize($sanitize);
		if($product->updateProduct($params)) {
			header("Location: index.php?action=success");
			exit();
		}
		else {
			header("Location: index.php?action=fail");
			exit();
		}
	}

	if(isset($_POST['addcategory'])) {
		if(empty($_POST['categoryName'])) {
			header("Location: index.php?action=null");
			exit();
		}
		$sanitize = array('categoryName' => $_POST['categoryName']);
		$params = $admin->sanitize($sanitize);

		if($product->addCategory($params)) {
			header("Location: index.php?action=success");
			exit();
		}
		else {
			header("Location: index.php?action=fail");
			exit();
		}
	}

	if(isset($_POST['updatecategory'])) {
		if(empty($_POST['categoryName'])) {
			header("Location: index.php?action=null");
			exit();
		}
		$sanitize = array('category_name'=> $_POST['categoryName'], 
						  'category_id' => $_POST['category_id']);
		$params = $admin->sanitize($sanitize);
		if($product-> updateCategory($params)) {
			header("Location: index.php?action=success");
			exit();
		}
		else {
			header("Location: index.php?action=fail");
			exit();
		}
	}
	//Admin updating order table, if user paid
	if(isset($_REQUEST['updateorder'])) {
		$orderId = (int)base64_decode($_REQUEST['orderNum']);
		if($order->confirmOrder($orderId)) {
			header("Location: index.php?action=success");
			exit();
		}
		else {
			header("Location: index.php?action=fail");
			exit();
		}
	}

	if(isset($_REQUEST['backup'])) {
		$action = $_REQUEST['backup'];
		$fullpath = $basepath.'/backups/' ;
		switch ($action) {
			case 'download':
				if(!is_dir($fullpath)) {
					mkdir($fullpath);
				}
				$filename = 'backup_'.date('Ymd_his').'.csv';
				$dirpath = $fullpath.'backup_'.date('Ymd_his').'.csv';
				// set headers to force download on csv format
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename='.$filename);

				// we initialize the output with the headers
				$output = "id,patient_id,invoice_id,total_quantity,invoice_total,invoice_status,created\n";
				//get invoice data from model
				// $list = $doctor->invoicesBackups(); Method to select which table data to backup
				foreach ($list as $row) {
					// add new row
				    $output .= $row->id.",".$row->patient_id.",".$row->invoice_id.",".$row->total_quantity.",".$row->invoice_total.",".$row->invoice_status.",".$row->created."\n";
				}
				// export the output as CVS data for download
				echo $output;
				try {
					$fp = fopen($dirpath, 'w');
					fwrite($fp, $output); //write data to file created
					fclose($fp);
				} catch(Exception $e) {
					echo "Error: ".$e->getMessage(); //catch any error thrown on opening and writing of invoice data
				}
				break;
			case 'upload':
				# read data from uploaded file and call method to upload to database from CSV file
				if(!empty($_FILES['backupfile']['name'])) {
					// echo $_FILES['backupfile']['name'];
					$filename = $_FILES['backupfile']['name'];

					$file_info = explode('.', $filename);
					$file_ext = end($file_info);
					$extension = strtolower($file_ext);
					if($extension == 'csv') {
						//try upload data from file to write database
						$file = fopen($filename, 'rb');
						$products = array();
						while ( !feof($file)) {
							//This should read file records into the database recursively
							$product = fgetcsv($file);
							if ($product === false) continue;
								$products[] = $product;
								echo "<div>$product[0] | $product[l] | $product[2]</div>";
						}
						header("Location: index.php?action=done"); //if file is invalid.
						exit();
					}
					else {
						header("Location: index.php?action=invalidbackup"); //if file is invalid.
						exit();
					}
				}
				break;
			case 'delete':
				# read all files in directory and delete recursively
				try{
					$files = scandir($fullpath);
					if(count($files) > 0) :
						foreach($files as $file) :
							if($file != '.' && $file != '..') {
								unlink($fullpath.$file); //delete all backup files
								header("Location: index.php?action=removed");
								exit();
							} else {
								header("Location: index.php?action=failremove"); //if no files to delete
								exit();
							}
						endforeach;
					endif;
				}
				catch(Exception $e) {
					echo "Error: ".$e->getMessage();
				}
			break;
		}
	}

	if(isset($_REQUEST['message']) && $_REQUEST['message'] == 'read') {
		$dated = urldecode($_REQUEST['date']);
		if($admin->updateMessage($dated)) {
			header("Location: index.php?action=success");
			exit();
		}
	}

	if(isset($_REQUEST['create_promo'])) {
		$_FILES['mediafile'] = (isset($_FILES['mediafile'])) ? $_FILES['mediafile'] : null;
		$title = $_REQUEST['title'];
		$message = $_REQUEST['message'];
		$mediafile = $_FILES['mediafile']['name'];
		$dirpath = $basepath.'/images/promotions/';
		$urlpath = $dirpath.$mediafile;
		$imgUrlLink = '/images/promotions/'.$mediafile;
		//check if variables not empty
		if(empty($title) && empty($message) || empty($mediafile)) {
			header("Location: index.php?action=null");
			exit();
		}

		if(!is_dir($dirpath)) {
			mkdir($dirpath); //create directory if not exists
			mkdir($basepath.'/promotions/');
		}

		//delete all images in promotions directory, before uploading new ones
		$delete_file = scandir($dirpath);
		for ($i=0; $i < count($delete_file); $i++) { 
			unlink($dirpath.$delete_file[$i]);
		}
		
		//create email message, encrypt filename with user email
		$filename = date('Ymd_his'); //$admin->data_encrypt(rand(10000, 100000));
		//pass variable data to email template
		$filecontents = $admin->emailTemplate($year=date('Y'), $title, $message, $imgUrlLink);
		//create email file write and save in promotions direcotory
		$fhandle = fopen($basepath.'/promotions/'.$filename.'.html', 'w+');
		fwrite($fhandle, $filecontents);
		fclose($fhandle);

		if(!empty($mediafile)) {
			//upload promotional image
			if(move_uploaded_file($_FILES['mediafile']['tmp_name'], $urlpath)) {
				header("Location: index.php?action=success");
				exit();
			}
		}
		else {
			header("Location: index.php?action=success");
			exit();
		}
	}

	//delete promotional message
	if(isset($_REQUEST['delete_promo'])) {
		$filename = base64_decode($_REQUEST['file']);
		$dirpath = $basepath.'/promotions/';
		$files = scandir($dirpath);
		if(array_search($filename, $files)) {
			unlink($dirpath.$filename);
			header("Location: index.php?action=success");
			exit();
		}
		else {
			header("Location: index.php?action=failed");
			exit();
		}
	}

?>