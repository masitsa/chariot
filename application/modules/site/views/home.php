<?php
	echo $this->load->view("home/slider", '', TRUE);
	echo $this->load->view("home/about", '', TRUE);
	//echo $this->load->view("home/services", '', TRUE);
	//echo $this->load->view("home/mail", '', TRUE);
	//$this->load->view("home/quote");

?>
<!--<div class="wrapper_green">
<div class="container">	
	<?php
        $this->load->view("home/services");
    ?>
	<?php
		$motto = $contacts[0]->motto;
		if(!empty($motto)){
        	
		}
		//$this->load->view("home/who_we_are");
    ?>
	
	<?php
        //$this->load->view("home/clients");
    ?>
	
</div>	
</div>-->
