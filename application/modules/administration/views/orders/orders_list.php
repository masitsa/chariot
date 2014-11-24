	<div class="main_items col-sm-10 col-md-10">
    	<?php
        	if(count($orders) > 0){
				?>
                <table class="table table-condensed table-striped table-hover">
                    <tr>
                    	<th>#</th>
                    	<th>Date</th>
                    	<th>Customer</th>
                    	<th>Phone</th>
                    	<th>Email</th>
                    	<th>Service</th>
                    	<th>Description</th>
                    	<th>Status</th>
                    	<th>Actions</th>
                    </tr>
                <?php
				$count = 0;
				foreach($orders as $cat){
					$count++;
					$order_id = $cat->order_id;
					$order_customer = $cat->order_customer;
					$order_service = $cat->order_service;
					$order_description = $cat->order_description;
					$order_email = $cat->order_email;
					$order_phone = $cat->order_phone;
					$order_date = date('jS M Y ',strtotime($cat->order_date));
					$order_status = $cat->order_status;
					
					if($order_status == 1){
						$status = "Completed";
					}
					else{
						$status = "Incompleted";
					}
					?>
                    <tr>
                    	<td><?php echo $count;?></td>
                    	<td><?php echo $order_date;?></td>
                    	<td><?php echo $order_customer;?></td>
                    	<td><?php echo $order_phone;?></td>
                    	<td><?php echo $order_email;?></td>
                    	<td><?php echo $order_service;?></td>
                    	<td><?php echo $order_description;?></td>
                    	<td><?php echo $status;?></td>
                    	<td>
                            <?php
								if($order_status == 1){
									
								}
								else{
									?>
                                        <a href="<?php echo site_url()."administration/complete_order/".$order_id;?>" class="i_size" title="Activate">
                            <button class="btn btn-info btn-sm" type="button" ><i class="fa fa-thumbs-o-up"></i> Complete Order</button>
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
				echo "There are no orders to display :-(";
			}
		?>
    </div><!-- End Content -->
</div>