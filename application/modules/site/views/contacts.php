<?php 
	if(count($contacts) > 0){
		foreach($contacts as $cat){
			
			$email = $cat->email;
			$phone = $cat->phone;
			$post = $cat->post;
			$physical = $cat->physical;
			$site_name = $cat->site_name;
			$logo = $cat->logo;
			$facebook = $cat->facebook;
			$blog = $cat->blog;
		}
	}
?>

<!--=== Breadcrumbs ===-->
<div class="breadcrumbs">
	<div class="container">
        <h1 class="color-green pull-left">Our Contacts</h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo site_url()."site/";?>">Home</a> <span class="divider">/</span></li>
            <li class="active">Contact</li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->

<div class="wrapper_green">
<!--=== Content Part ===-->
<div class="container">		
	<div class="row-fluid">
		<div class="span9">
            <!--<div id="map" class="map map-box map-box-space margin-bottom-40">
            </div>--><!---/map-->

            <p style="padding-top: 2%;">Feel free to send us a a message or leave a comment or suggestion. We would be glad to here from you.</p><br />

			<?php 
                if(isset($_SESSION['contact_success']))
                {
                    ?><div class="headline success"><h2><?php echo $_SESSION['contact_success']; ?></h2></div><?php
                    $_SESSION['contact_success'] = NULL;
                }
            ?>
            <div class="errors">
            
            <?php 
                $errors = validation_errors();
                if(isset($errors))
                {
                    echo validation_errors();
                }
            ?>
            </div>
			<form action="<?php echo site_url()."site/contact/";?>" method="POST">
                <label>Name</label>
                <input type="text" name="sender_name" class="span10" />
                <label>Email <span class="color-red">*</span></label>
                <input type="text" name="sender_email" class="span10" />
                <label>Subject</label>
                <input type="text" name="subject" class="span10" />
                <label>Message <span class="color-red">*</span></label>
                <textarea rows="8" name="message" class="span10"></textarea>
                <p><button type="submit" class="btn-u">Send Message</button></p>
            </form>
        </div><!--/span9-->

        <div class="span3">
            <!-- Contacts -->
            <div class="headline"><h3>Contacts</h3></div>
            <ul class="unstyled who margin-bottom-20">
                <li><a href="#"><i class="icon-home"></i><?php echo $physical;?></a></li>
                <li><a href="#"><i class="icon-envelope-alt"></i><?php echo $email;?></a></li>
                <li><a href="#"><i class="icon-phone-sign"></i><?php echo $phone;?></a></li>
            </ul>

            <!-- Business Hours -->
            <div class="headline"><h3>Business Hours</h3></div>
            <ul class="unstyled">
                <li><strong>Monday-Friday:</strong> 9am to 7pm</li>
                <li><strong>Saturday:</strong> 10am to 5pm</li>
                <li><strong>Sunday:</strong> Closed</li>
            </ul>

            <!-- Why we are? -->
            <div class="headline"><h3>Our services?</h3></div>
            <p>What we do...</p>
            <ul class="unstyled">
                <li><i class="icon-ok color-green"></i> Photography</li>
                <li><i class="icon-ok color-green"></i> Photo Editing & Printing</li>
                <li><i class="icon-ok color-green"></i> Framing & Montages</li>
                <li><i class="icon-ok color-green"></i> Videography</li>
            </ul>
        </div><!--/span3-->        
    </div><!--/row-fluid-->        
</div><!--/container-->		    
</div><!--/wrapper_green-->		
<!--=== End Content Part ===-->