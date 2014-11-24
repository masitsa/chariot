
<!--=== Breadcrumbs ===-->
<div class="breadcrumbs">
	<div class="container">
        <h1 class="color-green pull-left">Gallery</h1>
        <ul class="pull-right breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a> <span class="divider">/</span></li>
            <li class="active">Gallery</li>
        </ul>
    </div><!--/container-->
</div><!--/breadcrumbs-->
<!--=== End Breadcrumbs ===-->

<div class="wrapper_green">
<!--=== Content Part ===-->
<div class="container portfolio-item"> 	
	<div class="row-fluid margin-bottom-20"> 
		<!-- Carousel -->
        <div class="span12">
            <div id="myCarousel" class="carousel slide">
                <div class="carousel-inner">
    
				<?php
                    if(count($slides) > 0)
                    {
						$count = 0;
						
                        foreach($slides as $slide)
                        {
							if($count == 0)
							{
								$active = "active";
							}
							else
							{
								$active = "";
							}
							$count++;
                            $gallery_image = $slide->gallery_image_name;
                            ?>
                            <div class="item <?php echo $active;?>">
                                <img src="<?php echo base_url()."assets/gallery/images/".$gallery_image?>" alt="">
                                <div class="carousel-caption">
                                    <!-- <h4><?php echo $slide_name;?></h4>-->
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>
                    
                </div>
                <div class="carousel-arrow">
                    <a data-slide="prev" href="#myCarousel" class="left carousel-control"><i class="icon-angle-left"></i></a>
                    <a data-slide="next" href="#myCarousel" class="right carousel-control"><i class="icon-angle-right"></i></a>
                </div>
            </div>
        </div><!--/span7-->
        <!-- //End Tabs and Carousel -->
    </div><!--/row-fluid-->

	
</div><!--/container-->	 	
<!--=== End Content Part ===-->
</div>
