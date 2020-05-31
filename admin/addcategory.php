<?php
	//
	require_once('router.php');
	$admin->page_protected();
	$categories = $product->readAllCategories();
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
		padding: 3px 0;
	}
	.cat-list:hover {
		color: #0000ff;
		cursor: pointer;
	}
	.sub-heading {
		font-weight: bold;
		color: #777;
	}
</style>

<div class="container">
	<div class="heading">Add New Category</div>
	<form action="router.php" method="POST" enctype="application/x-www-forms-urlencoded">
		<div class="form-group">
			<label>Category Name:</label>
			<input type="text" name="categoryName" class="form-control" placeholder="Enter category name" autofocus>
		</div>
		<div class="form-group">
			<button class="btn" name="addcategory">Add New Category</button>
		</div>
	</form>
</div>

<div class="container">
	<div class="heading">Available Categories</div>
	<?php if($categories != false) { ?>
		<div class="sub-heading">Click on Category name to edit:</div>
	<?php foreach($categories as $k => $v) : ?>
			<li class="cat-list" onclick="doRequest('editcategory', <?php echo $v->id; ?>)" title="Click to edit this"> <?php echo $v->id; ?>)&nbsp;<?php echo $v->category_name; ?></li>
	<?php endforeach; ?>
	<?php } else { ?>
		<div class="alert-message success">No categories available</div>
	<?php } ?>
</div>