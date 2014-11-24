<?php
if(count($slides) > 0){
	
	$slideshow_name = $slides[0]->slideshow_name;
	$slideshow_description = $slides[0]->slideshow_description;
	$slideshow_image_name = $slides[0]->slideshow_image_name;
}

$name = set_value("slideshow_name");
$description = set_value("slideshow_description");
if(
	(!empty($name)) || 
	(!empty($description))
){
	$slideshow_name = $name;
	$slideshow_description = $description;
}
?>
    <div class="main_items col-sm-10 col-md-10">
    	
        <div class="input_form">
        <h3>Update <?php echo $slideshow_name;?></h3>
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
        <input type="hidden" name="slideshow_image_name" value="<?php echo $slideshow_image_name?>"/>
		<div class="form-group">
			<label for="slideshow_name">Title</label>
			<input type="text" class="form-control" name="slideshow_name" placeholder="Enter Title" value="<?php echo $slideshow_name;?>">
		</div>
		<div class="form-group">
			<label for="slideshow_description">Description</label>
			<textarea class="form-control" name="slideshow_description"><?php echo $slideshow_description;?></textarea>
		</div>
		
		<div class="form-group">
			<label class="control-label" for="image">Slideshow Image</label>
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                    <img src="<?php echo base_url();?>assets/slideshow/images/<?php echo $slideshow_image_name?>" class="img-responsive img-thumbnail" alt="<?php echo $slideshow_image_name?>">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                <div>
                    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="userfile"></span>
                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
            </div>
		</div>
		
		<div class="form-group">
			<input type="submit" value="Update Slide" class="login_btn btn btn-success btn-lg">
		</div>
        </div><!-- input form -->
    </div><!-- End Content -->
</div>