<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "site";
$route['404_override'] = '';

/*
*	Site Routes
*/
$route['home'] = 'site/home_page';
$route['flights'] = 'site/flights';
$route['terms'] = 'site/terms';

/*
*	Settings Routes
*/
$route['settings'] = 'admin/settings';
$route['dashboard'] = 'admin/index';

/*
*	Login Routes
*/
$route['login-admin'] = 'login/login_admin';
$route['logout-admin'] = 'login/logout_admin';

/*
*	Users Routes
*/
$route['all-users'] = 'admin/users';
$route['all-users/(:num)'] = 'admin/users/index/$1';
$route['add-user'] = 'admin/users/add_user';
$route['edit-user/(:num)'] = 'admin/users/edit_user/$1';
$route['delete-user/(:num)'] = 'admin/users/delete_user/$1';
$route['activate-user/(:num)'] = 'admin/users/activate_user/$1';
$route['deactivate-user/(:num)'] = 'admin/users/deactivate_user/$1';
$route['reset-user-password/(:num)'] = 'admin/users/reset_password/$1';
$route['admin-profile/(:num)'] = 'admin/users/admin_profile/$1';

/*
*	Admin Routes
*/

//slides
$route['administration/all-slides'] = 'admin/slideshow/index';
$route['administration/all-slides/(:num)'] = 'admin/slideshow/index/$1';//with a page number
$route['administration/add-slide'] = 'admin/slideshow/add_slide';
$route['administration/edit-slide/(:num)/(:num)'] = 'admin/slideshow/edit_slide/$1/$2';
$route['administration/activate-slide/(:num)/(:num)'] = 'admin/slideshow/activate_slide/$1/$2';
$route['administration/deactivate-slide/(:num)/(:num)'] = 'admin/slideshow/deactivate_slide/$1/$2';
$route['administration/delete-slide/(:num)/(:num)'] = 'admin/slideshow/delete_slide/$1/$2';

//services
$route['administration/all-services'] = 'admin/services/index';
$route['administration/all-services/(:num)'] = 'admin/services/index/$1';//with a page number
$route['administration/add-service'] = 'admin/services/add_service';
$route['administration/edit-service/(:num)/(:num)'] = 'admin/services/edit_service/$1/$2';
$route['administration/activate-service/(:num)/(:num)'] = 'admin/services/activate_service/$1/$2';
$route['administration/deactivate-service/(:num)/(:num)'] = 'admin/services/deactivate_service/$1/$2';
$route['administration/delete-service/(:num)/(:num)'] = 'admin/services/delete_service/$1/$2';

//services
$route['administration/all-gallery-images'] = 'admin/gallery/index';
$route['administration/all-gallery-images/(:num)'] = 'admin/gallery/index/$1';//with a page number
$route['administration/add-gallery'] = 'admin/gallery/add_gallery';
$route['administration/edit-gallery/(:num)/(:num)'] = 'admin/gallery/edit_gallery/$1/$2';
$route['administration/activate-gallery/(:num)/(:num)'] = 'admin/gallery/activate_gallery/$1/$2';
$route['administration/deactivate-gallery/(:num)/(:num)'] = 'admin/gallery/deactivate_gallery/$1/$2';
$route['administration/delete-gallery/(:num)/(:num)'] = 'admin/gallery/delete_gallery/$1/$2';

/* End of file routes.php */
/* Location: ./application/config/routes.php */