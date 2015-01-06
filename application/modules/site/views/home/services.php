<section id="service" class="light_section">
    <div class="container">
        <div class="row">
           <div class="col-sm-12 text-center to_animate" data-animation="fadeInUp">
                <h2 class="section_header">
                   Our Services
                </h2>                
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div id="girl-carousel" class="owl-carousel">
				<?php
                    if($services->num_rows() > 0)
                    {
                        foreach($services->result() as $service)
                        {
                            $service_name = $service->service_name;
                            $description = $service->service_description;
                            $service_image = $service->service_image_name;
                            $description = $this->site_model->limit_text($description, 8);
                            //var_dump($description); die();
                            ?>
                            <div>
                                <a href="#">
                                    <div class="thumbnail">
                                        <img src="<?php echo $service_location.$service_image;?>" alt="<?php echo $service_name;?>">
                                        <div class="caption">
                                            <p><?php echo $description;?></p>
                                            <p class="text-center team-social">
                                                <a class="socialico-facebook" href="#" title="Facebook" data-toggle="tooltip">#</a>
                                                <a class="socialico-twitter" href="#" title="Twitter" data-toggle="tooltip">#</a>
                                                <a class="socialico-google" href="#" title="Google" data-toggle="tooltip">#</a>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                
                                <h2 style="text-align:center;">
                                	<?php echo $service_name;?>
                                </h2>
                            </div>
                            <?php
                        }
                    }
                ?>

                </div>
            </div>
            
        </div>
    </div>
</section>

	<!-- 
	<div class="row-fluid margin-bottom-30">
    	<div class="span3">
    		<div class="service clearfix">
                <ul class="ch-grid">
                    <li>
                        <div class="ch-item ch-img-1">
                            <div class="ch-info">
                                <h3>Competitive cost</h3>
                                <p>by Andrew Kihara</p>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="desc">
    				<h4>Photography</h4>
                    <p>We have been at it for more than 10 years and are passionate about what we do.</p>
                    <a href="<?php echo site_url()."site/services/"?>"><span>Read More >></span></a>
                </div>
    		</div>	
    	</div>
    	<div class="span3">
    		<div class="service clearfix">
                <ul class="ch-grid">
                    <li>
                        <div class="ch-item ch-img-2">
                            <div class="ch-info">
                                <h3>Best quality</h3>
                                <p>by Angela Wangeci</p>
                            </div>
                        </div>
                    </li>
                </ul>    			
                <div class="desc">
    				<h4>Photo Editing & Printing</h4>
                    <p>We edit and print photos to give them that extra edge that would make them outstanding on your wall or shelf</p>
                    <a href="<?php echo site_url()."site/services/"?>"><span>Read More >></span></a>
                </div>
    		</div>	
    	</div>
    	<div class="span3">
    		<div class="service clearfix">
                <ul class="ch-grid">
                    <li>
                        <div class="ch-item ch-img-3">
                            <div class="ch-info">
                                <h3>Creative & unique</h3>
                                <p>by Bernard Bosek</p>
                            </div>
                        </div>
                    </li>
                </ul>    			
                <div class="desc">
    				<h4>Framing & Montages</h4>
                    <p>We love doing out-of-the box potraits of you done completely by hand. Come visit us to get one to immortalize yourself.</p>
                    <a href="<?php echo site_url()."site/services/"?>"><span>Read More >></span></a>
                </div>
    		</div>	
    	</div>
        <div class="span3">
    		<div class="service clearfix">
                <ul class="ch-grid">
                    <li>
                        <div class="ch-item ch-img-4">
                            <div class="ch-info">
                                <h3>Very reliable</h3>
                                <p>by Beatrice Muthoni</p>
                            </div>
                        </div>
                    </li>
                </ul>    			
                <div class="desc">
    				<h4>Videography</h4>
                    <p>Would you like to capture your wedding on video? Contact us to make a booking. We offer the best quality services and are very reliable.</p>
                    <a href="<?php echo site_url()."site/services/"?>"><span>Read More >></span></a>
                </div>
    		</div>
    	</div>
	</div>-->
	