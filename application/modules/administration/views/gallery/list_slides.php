	<div class="main_items col-sm-10 col-md-10">
    	<?php
        	if(count($slides) > 0){
				?>
                <table class="table table-condensed table-striped table-hover">
                    <tr>
                    	<th>Slide</th>
                    	<th>Status</th>
                    	<th>Actions</th>
                    </tr>
                <?php
				foreach($slides as $cat){
					
					$gallery_id = $cat->gallery_id;
					$gallery_status = $cat->gallery_status;
					$gallery_image_name = $cat->gallery_image_name;
					
					if($gallery_status == 1){
						$status = "active";
					}
					else{
						$status = "deactivated";
					}
					?>
                    <tr>
                    	<td>
                        <img src="<?php echo base_url();?>assets/gallery/images/<?php echo $gallery_image_name?>" width="200" class="img-responsive img-thumbnail">
                        </td>
                    	<td><?php echo $status?></td>
                    	<td>
                        	<a href="<?php echo $gallery_id;?>" class="i_size delete_gallery" title="Delete">
                            	 <button class="btn btn-danger btn-sm" type="button" ><i class="fa fa-trash-o"></i> Delete</button>
                            </a>
                            <?php
								if($gallery_status == 1){
									?>
                                        <a href="<?php echo site_url()."administration/deactivate_gallery/".$gallery_id;?>" class="i_size" title="Deactivate">
                            <button class="btn btn-warning btn-sm" type="button" ><i class="fa fa-thumbs-o-down"></i> Deactivate</button>
                                        </a>
                                    <?php
								}
								else{
									?>
                                        <a href="<?php echo site_url()."administration/activate_gallery/".$gallery_id;?>" class="i_size" title="Activate">
                            <button class="btn btn-info btn-sm" type="button" ><i class="fa fa-thumbs-o-up"></i> Activate</button>
                                        </a>
                                    <?php
								}
							?>
                        </td>
                    </tr>
                    <?php
				}
				?>
                </table>
                <?php
			}
			
			else{
				echo "There are no slides to display :-(";
			}
		?>
    </div><!-- End Content -->
</div>