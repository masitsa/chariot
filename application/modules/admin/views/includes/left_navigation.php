
    <!-- Sidebar -->
    <div class="sidebar sidebar-fixed">
        <div class="sidebar-dropdown"><a href="#">Navigation</a></div>

        <div class="sidebar-inner">
        
            <!--- Sidebar navigation -->
            <!-- If the main navigation has sub navigation, then add the class "has_submenu" to "li" of main navigation. -->
            <ul class="navi">

                <!-- Use the class nred, ngreen, nblue, nlightblue, nviolet or norange to add background color. You need to use this in <li> tag. -->

                <!--<li><a href="<?php echo base_url()."admin";?>"><i class="icon-desktop"></i> Dashboard</a></li>-->

                <li class="has_submenu">
                    <a href="#">
                        <i class="icon-th"></i> Users
                    </a>
                    <ul>
                        <li><a href="<?php echo base_url()."all-users";?>">Administrators</a></li>
                    </ul>
                </li>
				<!-- End: Admin Menu -->

                <!-- Start: Products Menu -->
                <li class="has_submenu">
                    <a href="#">
                        <!-- Menu name with icon -->
                        <i class="icon-th"></i> Website Configuration
                        <!-- Icon for dropdown -->
                    </a>
                    <ul>
                        <li><a href="<?php echo base_url()."administration/all-gallery-images";?>">Gallery Images</a></li>
                        <li><a href="<?php echo base_url()."administration/all-services";?>">Services</a></li>
                        <li><a href="<?php echo base_url()."administration/all-slides";?>">Slideshow Images</a></li>
                    </ul>
                </li>
				<!-- End: Products Menu -->

            </ul>
        </div>
    </div>
    <!-- Sidebar ends -->
