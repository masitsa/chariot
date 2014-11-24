<?php 
	if(count($contacts) > 0){
		$facebook = $contacts[0]->facebook;
		$pintrest = $contacts[0]->pintrest;
		$physical = $contacts[0]->physical;
		$email = $contacts[0]->email;
		$phone = $contacts[0]->phone;
	}
?>

<div class="preloader">
    <div class="preloader_image"></div>
</div>


        <!-- libraries -->
        <script src="<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/bootstrap.min.js"></script>
        <script src="<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.appear.js"></script>

        <!-- superfish menu  -->
        <script src="<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.hoverIntent.js"></script>
        <script src="<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/superfish.js"></script>
        
        <!-- page scrolling -->
        <script src="<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.easing.1.3.js"></script>
        <script src='<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.nicescroll.min.js'></script>
        <script src="<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.ui.totop.js"></script>
        <script src="<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.localscroll-min.js"></script>
        <script src="<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.scrollTo-min.js"></script>
        <script src='<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.parallax-1.1.3.js'></script>

        <!-- widgets -->
        <script src="<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.easypiechart.min.js"></script><!-- pie charts -->
        <script src='<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.countTo.js'></script><!-- digits counting -->
        <script src="<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.prettyPhoto.js"></script><!-- lightbox photos -->
        <script src='<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jflickrfeed.min.js'></script><!-- flickr -->
        <script src='<?php echo base_url().'assets/themes/butterfly/';?>twitter/jquery.tweet.min.js'></script><!-- twitter -->

        <!-- sliders, filters, carousels -->
        <script src="<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.isotope.min.js"></script>
        <script src='<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/owl.carousel.min.js'></script>
        <script src='<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.fractionslider.min.js'></script>
        <script src='<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.flexslider-min.js'></script>
        <script src='<?php echo base_url().'assets/themes/butterfly/';?>js/vendor/jquery.bxslider.min.js'></script>

        <!-- custom scripts -->
        <script src="<?php echo base_url().'assets/themes/butterfly/';?>js/plugins.js"></script>
        <script src="<?php echo base_url().'assets/themes/butterfly/';?>js/main.js"></script>


        <!-- Map Scripts -->

        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript">
            var lat;
            var lng;
            var map;
            var styles = [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]},{"featureType":"landscape","stylers":[{"color":"#f2e5d4"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}];

            //type your address after "address="
            jQuery.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address=london, baker street, 221b&sensor=false', function(data) {
                lat = data.results[0].geometry.location.lat;
                lng = data.results[0].geometry.location.lng;
            }).complete(function(){
                dxmapLoadMap();
            });

            function attachSecretMessage(marker, message)
            {
                var infowindow = new google.maps.InfoWindow(
                    { content: message
                    });
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map,marker);
                });
            }

            window.dxmapLoadMap = function()
            {
                var center = new google.maps.LatLng(lat, lng);
                var settings = {
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    zoom: 16,
                    draggable: false,
                    scrollwheel: false,
                    center: center,
                    styles: styles 
                };
                map = new google.maps.Map(document.getElementById('map'), settings);

                var marker = new google.maps.Marker({
                    position: center,
                    title: 'Map title',
                    map: map
                });
                marker.setTitle('Map title'.toString());
            //type your map title and description here
            attachSecretMessage(marker, '<h3>Map title</h3>Map HTML description');
            }
        </script>