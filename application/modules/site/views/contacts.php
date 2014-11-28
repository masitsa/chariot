<?php 

	if($contacts->num_rows() > 0){
		foreach($contacts->result() as $cat){
			
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
<section id="contact" class="light_section">
    <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center to_animate" data-animation="fadeInUp">
                    <h2 class="section_header">
                       Contact Us
                    </h2> 
                </div>
            </div> 

    </div>
</section>

<section id="map" class="grey_section"></section>

<section id="cont" class="light_section">
    <div class="container">
        <div class="row">         
                   
            <div class="widget widget_contact col-sm-6 to_animate">
                <h3>Contact Info</h3>
                <p>Chariot Photo Studio is found on ground floor Kenya Reinsurance Plaza
                <br><br>
                    <i class="rt-icon-device-phone"></i><strong>Phone:</strong> <?php echo $phone;?>
                </p>
                <p>
                    <i class="rt-icon-pencil"></i><strong>Email:</strong> <a href="mailto:<?php echo $email;?>"><?php echo $email;?></a>
                </p>
                <p>
                    <i class="rt-icon-globe-outline"></i><strong>Website: </strong><a href="./"><?php echo site_url();?></a>
                </p>
                <p>
                    <i class="rt-icon-location-arrow-outline"></i><strong>Address:</strong> <?php echo $post;?>
                </p>

            </div>
            <div class="widget col-sm-6 to_animate">
                <form class="contact-form" method="post" action="/">
                    <p class="contact-form-name">
                        <label for="name">Name <span class="required">*</span></label>
                        <input type="text" aria-required="true" size="30" value="" name="name" id="name" class="form-control" placeholder="Name">
                    </p>
                    <p class="contact-form-email">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" aria-required="true" size="30" value="" name="email" id="email" class="form-control" placeholder="Email">
                    </p>
                    <p class="contact-form-subject">
                        <label for="subject">Subject <span class="required">*</span></label>
                        <input type="text" aria-required="true" size="30" value="" name="subject" id="subject" class="form-control" placeholder="Subject">
                    </p>
                    <p class="contact-form-message">
                        <label for="message">Message</label>
                        <textarea aria-required="true" rows="8" cols="45" name="message" id="message" class="form-control" placeholder="Message"></textarea>
                    </p>
                    <p class="contact-form-submit vertical-margin-40">
                        <!-- <input type="submit" value="Send" id="contact_form_submit" name="contact_submit" class="theme_button"> -->
                        <button type="submit" id="contact_form_submit" name="contact_submit" class="type-15">
                         <span>Send!</span>
                         <span></span>
                     </button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>