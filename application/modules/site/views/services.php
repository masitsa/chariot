
<!--=== Breadcrumbs ===-->
<div class="breadcrumbs">
	<div class="container">
        <h1 class="pull-left">Our Services</h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo site_url()."site/";?>">Home</a> <span class="divider">/</span></li>
            <li class="active">Services</li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->

<!--=== Content Part ===-->
<div class="wrapper_green" style="padding-top:1%;">	
<div class="container">		
	<div class="row-fluid">
    	<!-- Our Services -->
		<div class="span8">
            <!--<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem Transform is an incredibly beautiful responsive Bootstrap Template for corporate and creative professionals.</p><br>-->

			<div class="row-fluid servive-block">
                <div class="span6">
                    <h4>Photography</h4>
                    <p><i class="icon-bell"></i></p>
                    <p>We have been at it for more than 10 years and are passionate about what we do. Come visit us for a photo shoot or if you prefer we can come to you. We offer the following kinds of photography...</p>
                    <ul class="links-block">
                        <li><i class="icon-link"></i>Event Photography</li>
                        <li><i class="icon-link"></i>Studio Photography</li>
                	</ul>
                </div>
                <div class="span6">
                    <h4>Photo Editing & Printing</h4>
                    <p><i class="icon-bullhorn"></i></p>
                    <p>We take photos and edit them or you can even bring your own to Chariot Photo Studio for editing. We also offer printing services for various photo sizes the most common being...</p>
                    <ul class="links-block">
                        <li><i class="icon-link"></i>Passport Photos</li>
                        <li><i class="icon-link"></i>4 * 6 Photos</li>
                	</ul>
                </div>
            </div><!--/row-fluid-->

			<div class="row-fluid servive-block">
                <div class="span6">
                    <h4>Framing & Montages</h4>
                    <p><i class="icon-lightbulb"></i></p>
                    <p>For those who would like to frame their photos, we offer a variety of frame designs and sizes for your framing needs. We also do montages</p>
                    <ul class="links-block">
                        <li><i class="icon-link"></i>Frames of differnt sizes</li>
                        <li><i class="icon-link"></i>Montages (general & chemilan)</li>
                	</ul>
                </div>
                <div class="span6">
                    <h4>Videography</h4>
                    <p><i class="icon-thumbs-up"></i></p>
                    <p>If you would like to capture an event, be it a wedding or otherwise, on video we are there to fulfill this and offer you the best quality video for your event.</p>
                    <ul class="links-block">
                        <li><i class="icon-link"></i>Wedding Coverage</li>
                        <li><i class="icon-link"></i>Other</li>
                	</ul>
                </div>
            </div><!--/row-fluid-->
        </div><!--/row-fluid-->        
    	<!--//End Our Services -->
        <div class="span4">
        	<?php $data['page'] = 1; echo $this->load->view("order_details", $data);?>
        </div>
    </div><!--/row-fluid-->

	
</div><!--/container-->		
</div><!--/wrapper_green-->		
<!--=== End Content Part ===-->
