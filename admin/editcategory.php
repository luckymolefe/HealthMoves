<?php
	//
	require_once('router.php');
	$admin->page_protected();
	if(isset($_GET['edit'])) {
		$cat = $product->getCategoryName($_GET['catId']);
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
	.cat-list {
		color: #777;
		list-style-type: none;
		text-indent: 5px;
	}
</style>

<div class="container">
	<div class="heading">Edit Category</div>
	<form action="router.php" method="POST" enctype="application/x-www-forms-urlencoded">
		<div class="form-group">
			<label>New Category Name:</label>
			<input type="hidden" name="category_id" value="<?php echo $cat->id;?>">
			<input type="text" name="categoryName" class="form-control" value="<?php echo $cat->category_name; ?>" placeholder="Enter new category name" autofocus>
		</div>
		<div class="form-group">
			<button class="btn" name="updatecategory">Update Category</button>
		</div>
	</form>
	<p><a href="javascript:doRequest('addcategory');">&larr; Back</a></p>
</div>