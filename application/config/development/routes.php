<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'welcome/modify';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
if (ENVIRONMENT === 'development') {
    $route['teste'] = 'teste/index'; //rota para controller de desenvolvimento
}

$route['dashboard'] = 'dashboard/index';
$route['login'] = 'login/modify';
$route['singup'] = 'singup/modify';
$route['logout'] = 'logout/modify';
$route['reset_password'] = 'reset_password/modify';
$route['new_password/(:any)'] = 'reset_password/modify/$1';
$route['new_password/(.+)'] = 'reset_password/modify/$1';

$route['role'] = 'role_maintence/index';
$route['role/modify'] = 'role_maintence/modify';
$route['role/modify/(:num)'] = 'role_maintence/modify';
$route['role/remove/(:num)'] = 'role_maintence/remove';

$route['behavior'] = 'behavior_maintence/index';
$route['behavior/modify'] = 'behavior_maintence/modify';
$route['behavior/modify/(:num)'] = 'behavior_maintence/modify';
$route['behavior/remove/(:num)'] = 'behavior_maintence/remove';

$route['user'] = 'user_maintence/index';
$route['user/modify'] = 'user_maintence/modify';
$route['user/modify/(:num)'] = 'user_maintence/modify';
$route['user/remove/(:num)'] = 'user_maintence/remove';

$route['element'] = 'element_maintence/index';
$route['element/modify'] = 'element_maintence/modify';
$route['element/modify/(:num)'] = 'element_maintence/modify';
$route['element/remove/(:num)'] = 'element_maintence/remove';

$route['permission'] = 'permission_maintence/index';
$route['permission/modify'] = 'permission_maintence/modify';
$route['permission/modify/(:num)'] = 'permission_maintence/modify';
$route['permission/remove/(:num)'] = 'permission_maintence/remove';

$route['migrate'] = 'migrate/index';
$route['migrate/index'] = 'migrate/index';

