   
        <!-- Jasny -->
        <link href="<?php echo base_url();?>assets/jasny/jasny-bootstrap.css" rel="stylesheet">		
        <script type="text/javascript" src="<?php echo base_url();?>assets/jasny/jasny-bootstrap.js"></script> 
          <div class="padd">
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
				
				if(!empty($error))
				{
					?>
					<div class="alert alert-danger">
						<?php echo $error;?>
					</div>
					<?php
				}
				?>
                <div class="row">
                	<div class="col-md-6">
                        <div class="form-group">
                            <label class="col-lg-6 control-label" for="gallery_name">Title</label>
                            <div class="col-lg-6">
                            	<input type="text" class="form-control" name="gallery_name" placeholder="Title" value="<?php echo set_value("gallery_name");?>">
                            </div>
                        </div>
                        <!-- service type -->
                        <div class="form-group">
                            <label class="col-lg-6 control-label">Service</label>
                            <div class="col-lg-6">
                                <select name="service_id" id="service_id" class="form-control" required>
                                    <?php
                                    if($services->num_rows() > 0)
                                    {
                                        $result = $services->result();
                                        
                                        foreach($result as $res)
                                        {
                                            if($res->service_id == set_value('service_id'))
                                            {
                                                echo '<option value="'.$res->service_id.'" selected="selected">'.$res->service_name.'</option>';
                                            }
                                            else
                                            {
                                                echo '<option value="'.$res->service_id.'">'.$res->service_name.'</option>';
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        <!-- end: service type -->
                        </div> 
					</div>
                	<div class="col-md-6">
                        <label class="control-label" for="image">Gallery Image</label>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                	<img src="<?php echo $gallery_location;?>" class="img-responsive"/>
                                </div>
                                    <div>
                                        <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="gallery_image"></span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                	</div>
                </div>
				
				<div class="form-group center-align">
					<input type="submit" value="Add Gallery Image" class="login_btn btn btn-success btn-lg">
				</div>
				<?php
					form_close();
				?>
		</div>