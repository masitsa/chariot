<?php
if(count($product) > 0){
	
	foreach($product as $cat){
		
		$product_id = $cat->product_id;
		$product_code = $cat->product_code;
		$product_description = $cat->product_description;
		$product_name = $cat->product_name;
		$product_selling_price = $cat->product_selling_price;
		$product_buying_price = $cat->product_buying_price;
		$product_balance = $cat->product_balance;
		$product_status = $cat->product_status;
		$product_image_name = $cat->product_image_name;
		$product_date = $cat->product_date;
		$product_year = $cat->product_year;
		$brand_model_id = $cat->brand_model_id;
		$category_id = $cat->category_id;
		
		if($product_status == 1){
			$status = "active";
		}
		else{
			$status = "deactivated";
		}
	}
}

$name = set_value("product_name");
$description = set_value("product_description");
$selling_price = set_value("product_selling_price");
$buying_price = set_value("product_buying_price");
$balance = set_value("product_balance");
$category = set_value("category_id");
$year = set_value("product_year");
if(
	(!empty($name)) || 
	(!empty($code)) || 
	(!empty($description)) || 
	(!empty($selling_price)) || 
	(!empty($buying_price)) || 
	(!empty($balance)) || 
	(!empty($year)) || 
	(!empty($category))
){
	$product_name = set_value("product_name");
	$product_description = set_value("product_description");
	$product_selling_price = set_value("product_selling_price");
	$product_buying_price = set_value("product_buying_price");
	$product_balance = set_value("product_balance");
	$category_id = set_value("category_id");
	$product_year = set_value("product_year");
}
?>
    <div class="main_items col-sm-10 col-md-10">
    	
        <div class="input_form">
        <h3>Update <?php echo $product_name;?></h3>
        <?php
        $error2 = validation_errors(); 
        if(!empty($error2)){?>
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <?php echo validation_errors(); ?>
                    </div>
                </div>
            </div>
    	<?php }
    
    	if(isset($_SESSION['error'])){?>
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <?php echo $_SESSION['error']; $_SESSION['error'] = NULL;?>
                    </div>
                </div>
            </div>
    	<?php }?>
    
    	<?php
		$attributes = array('role' => 'form');

		echo form_open_multipart($this->uri->uri_string(), $attributes);
		?>
        <input type="hidden" name="product_image_name" value="<?php echo $product_image_name?>"/>
		<div class="form-group">
			<label for="product_code">Product Code</label>
			<input type="text" class="form-control" name="product_code" placeholder="Enter Product Code" readonly value="<?php echo $product_code;?>">
		</div>
		<div class="form-group">
			<label for="product_name">Product Name</label>
			<input type="text" class="form-control" name="product_name" placeholder="Enter Product Name" value="<?php echo $product_name;?>">
		</div>
		<div class="form-group">
        	<input type="hidden" name="model_id" value="<?php echo $brand_model_id;?>"/>
			<label for="brand_id">Brand</label>
			<select class="form-control brands" id="brand_id" name="brand_id">
            	<option value="0" selected>----Select Brand----</option>
            	<?php
					if(count($brands) > 0){
						foreach ($brands as $cat){
							$brand_name = $cat->brand_name;
							$brand_id = $cat->brand_id;
							
							if(set_value("brand_id") == $brand_id){
								?>
								<option value="<?php echo $brand_id?>" selected><?php echo $brand_name?></option>
								<?php
							}
							
							else{
								?>
								<option value="<?php echo $brand_id?>"><?php echo $brand_name?></option>
								<?php
							}
						}
					}
				?>
            </select>
		</div>
		<div class="form-group" id="models">
		</div>
		<div class="form-group">
			<label for="product_year">Product Year</label>
			<input type="text" class="form-control" name="product_year" placeholder="Enter Product Year" value="<?php echo $product_year;?>">
		</div>
		<div class="form-group">
			<label for="category_id">Category</label>
			<select class="form-control" name="category_id">
            	<?php
					if(count($children) > 0){
						foreach ($children as $cat){
							$category_name = $cat->category_name;
							$category_id2 = $cat->category_id;
							
							if($category_id == $category_id2){
								?>
								<option value="<?php echo $category_id2?>" selected><?php echo $category_name?></option>
								<?php
							}
							
							else{
								?>
								<option value="<?php echo $category_id2?>"><?php echo $category_name?></option>
								<?php
							}
						}
					}
				?>
            </select>
		</div>
		
		<div class="form-group">
			<label for="product_buying_price">Buying Price</label>
			<input type="text" class="form-control" name="product_buying_price" placeholder="Enter Buying Price" value="<?php echo $product_buying_price;?>">
		</div>
		
		<div class="form-group">
			<label for="product_selling_price">Selling Price</label>
			<input type="text" class="form-control" name="product_selling_price" placeholder="Enter Selling Price" value="<?php echo $product_selling_price;?>">
		</div>
		
		<div class="form-group">
			<label for="product_balance">Balance</label>
			<input type="text" class="form-control" name="product_balance" placeholder="Enter Balance" value="<?php echo $product_balance;?>">
		</div>
		
		<div class="form-group">
			<label for="product_description">Description</label>
			<textarea name="product_description" class="form-control"><?php echo $product_description;?></textarea>
		</div>
		
		<div class="form-group">
			<label class="control-label" for="image">Product Image</label>
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                    <img src="<?php echo base_url();?>assets/products/images/<?php echo $product_image_name?>" class="img-responsive img-thumbnail" alt="<?php echo $product_name?>">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                <div>
                    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="userfile"></span>
                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
            </div>
		</div>
		
		<div class="form-group">
			<label class="control-label" for="image">Gallery Images</label>
			<div class="controls">
				<?php echo form_upload(array( 'name'=>'gallery[]', 'multiple'=>true ));?>
            </div>
        </div>
		
		<div class="form-group">
			<input type="submit" value="Update Product" class="login_btn btn btn-success btn-lg">
		</div>
		<?php
         
		 if(is_array($product_images)){
			 foreach($product_images as $prod){
				 $id = $prod->product_image_id;
				 $image = $prod->product_image_name;
				 $thumb = $prod->product_image_thumb;
				 ?>
                 <div style="float:left">
                	<img src="<?php echo base_url();?>assets/products/gallery/<?php echo $thumb;?>" alt="<?php echo $thumb;?>"/>
                 	<a href="<?php echo site_url("admin/products/delete_gallery_image/".$id."/".$product_id)?>">Delete</a>
                 </div>
		<?php
			 }
		 }
		 
		 ?>
        </div><!-- input form -->
    </div><!-- End Content -->
</div>