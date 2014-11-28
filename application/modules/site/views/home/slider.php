
    <section id="mainslider">

        <div class="flexslider">
            <ul class="slides">
				<?php
                    if($slides->num_rows() > 0)
                    {
                        foreach($slides->result() as $slide)
                        {
                            $slide_name = $slide->slideshow_name;
                            $description = $slide->slideshow_description;
                            $slide_image = $slide->slideshow_image_name;
                            $description = $this->site_model->limit_text($description, 8);
                            
                            ?>
                            <li>
                                <div class="slide_overlay">
                                  <img src="<?php echo $slideshow_location.$slide_image;?>" alt="<?php echo $slide_name;?>">
                                </div>
                                <div class="slide_description_wrapper">
                                    <div class="slide_description text-left">
                                        <p data-animation="fadeInLeft"><?php echo $slide_name;?></p>
                                        <h3 data-animation="fadeInUp"><?php echo $description;?></h3>
                                    </div>
                                </div> 
                            </li>
                            <?php
                        }
                    }
                ?>
            </ul>
        </div>


    </section>