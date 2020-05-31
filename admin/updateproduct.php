<?php
	//
if(isset($_GET['pid'])) {
	require_once('router.php');
	$admin->page_protected();
	$categories = $product->readAllCategories();
	$row = $product->readProduct($_GET['pid']);
}
else {
	exit();
}

?>
<style type="text/css">
	.container {
		width: 600px;
		max-width: 100%;
		margin: 0 auto;
		background-color: #f5f5f5;
		padding: 10px;
		border-radius: 5px;
		margin-top: 50px;
		box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.5);
	}
	.form-group {
		padding: 10px 0;
	}
	.form-control {
		width: 100%;
		border: thin solid #ccc;
		border-radius: 5px;
		padding: 10px 0px;
		text-indent: 5px;
		color: #777;
	}
	.error {
		color: #ff0000;
	}
	.heading {
		position: relative;
		top: -10px;
		background-color: #45a89a;
		color: #fff;
		font-size: 2em;
		text-align: center;
		border-radius: 5px 5px 0 0;
		padding: 5px 0;
		margin-left: -10px;
		margin-right: -10px;
	}
	.btn {
		width: 150px;
		padding: 15px 0;
		font-weight: bold;
		border: none;
		border-radius: 5px;
		background-color: #45a89a;
		cursor: pointer;
		color: #fff;
	}
	label {
		color: #777;
		font-weight: bold;
	}
</style>

<div class="container">
	<div class="heading">Update Product</div>
	<form action="router.php" method="POST" enctype="application/x-www-forms-urlencoded">
		<div class="form-group">
			<label>Product Name:</label>
			<input type="hidden" name="pid" value="<?php echo $row->id; ?>">
			<input type="text" name="productName" class="form-control" placeholder="Enter product name" value="<?php echo $row->product_name; ?>">
		</div>
		<div class="form-group">
			<label>Product Price:</label>
			<input type="text" name="price" class="form-control" placeholder="Enter product price" value="<?php echo $row->price; ?>">
		</div>
		<div class="form-group">
			<label>Select Category:</label>
			<select name="category" class="form-control">
				<option value="">Select Category</option>
				<?php foreach($categories as $k => $v) : ?>
						<option value="<?php echo $v->id; ?>" <?php if($v->id == $row->category_id) { echo "selected"; } ?> ><?php echo $v->category_name; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="form-group">
			<button type="submit" class="btn" name="updateproduct">Update Product</button>
		</div>
	</form>
</div>