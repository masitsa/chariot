
<!--=== Breadcrumbs ===-->
<div class="breadcrumbs">
	<div class="container">
        <h1 class="color-green pull-left">Order Photos</h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a> <span class="divider">/</span></li>
            <li class="active">Order Photos</li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->

<div class="wrapper_green">
	
<!--=== Content Part ===-->
<div class="container">		
	<div class="row-fluid">
		<div class="span12">
            <?php $data['page'] = 2; echo $this->load->view("order_details", $data);?>
        </div><!--/span9-->
    </div><!--/row-fluid-->  
</div><!--/container-->		
<!--=== End Content Part ===-->

</div>