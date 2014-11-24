<?php 
	if(count($contacts) > 0){
		foreach($contacts as $cat){
			$site_name = $cat->site_name;
			$logo = $cat->logo;
			$phone = $cat->phone;
		}
		$facebook = $contacts[0]->facebook;
		$pintrest = $contacts[0]->pintrest;
	}
?>
<head>
    <title><?php echo $site_name;?></title>
    <meta charset="utf-8">
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <![endif]-->
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <link rel="stylesheet" href="<?php echo base_url().'assets/themes/butterfly/'?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url().'assets/themes/butterfly/'?>css/main.css" id="color-switcher-link">
    <link rel="stylesheet" href="<?php echo base_url().'assets/themes/butterfly/'?>css/animations.css">
    <link rel="stylesheet" href="<?php echo base_url().'assets/themes/butterfly/'?>css/fonts.css">
    <script src="<?php echo base_url().'assets/themes/butterfly/'?>js/vendor/modernizr-2.6.2.min.js"></script>

    <!--[if lt IE 9]>
        <script src="<?php echo base_url().'assets/themes/butterfly/'?>js/vendor/html5shiv.min.js"></script>
        <script src="<?php echo base_url().'assets/themes/butterfly/'?>js/vendor/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="<?php echo base_url()."assets/logo/thumbs/".$logo?>">

</head>