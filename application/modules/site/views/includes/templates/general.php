<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> <!--<![endif]-->
	<?php echo $this->load->view('includes/header', '', TRUE);?>
	
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

		<div id="box_wrapper">
			<?php echo $this->load->view('includes/navigation', '', TRUE);?>
            <?php echo $content; ?>
			<?php echo $this->load->view('includes/copyright', '', TRUE);?>
        </div>
		<?php echo $this->load->view('includes/footer', '', TRUE);?>
	</body>
</html>