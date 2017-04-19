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

$route['default_controller'] = "main";
$route['404_override'] = 'error/error_404';

// $route['danhmuc/(:num)-(:any)/(:num)-(:any)'] = "main/filter/$1/$3";

// $route['danhmuc/(:num)-(:any)'] = "main/filter/$1/0";

// $route['sanpham/(:num)-(:any)'] = "sanpham/chitiet/$1";
// $route['sanpham/(:num)'] = "sanpham/chitiet/$1";
// $route['sanpham/(:num)-'] = "sanpham/chitiet/$1";

// $route['timkiem/(:any)'] = "sanpham/timkiem/$1";
 
$route['danh-muc/(:num)/(:any)/([a-z]+)-(\d+)'] = "danhmuc/index/$1/$4";
$route['danh-muc/(:any)'] = "danhmuc/index/$1";

$route['loai/(:num)/(:any)/([a-z]+)-(\d+)'] = "loaisp/index/$1/$4";
$route['loai/(:num)/(:any)'] = "loaisp/index/$1";

$route['san-pham/([a-z]+)-(\d+)'] = "sanpham/phantrang/$2";
$route['san-pham/(:any)_(:num)'] = "sanpham/index/$2";

$route['san-pham/search/(:any)/([a-z]+)-(\d+)'] = "sanpham/page_search_sanpham/$1/$3";
$route['san-pham/search/(:any)'] = "sanpham/page_search_sanpham/$1";
 
$route['tin-tuc/([a-z]+)-(\d+)'] = "tintuc/phantrang/$2";
$route['tin-tuc/(:any)_(:num)'] = "tintuc/index/$2";

$route['tin-tuc/search/(:any)/([a-z]+)-(\d+)'] = "tintuc/page_search_tintuc/$1/$3";
$route['tin-tuc/search/(:any)'] = "tintuc/page_search_tintuc/$1";

$route['gioi-thieu-cua-hang'] = "thongtin/gioithieu";
$route['lien-he'] = "thongtin/lienhe";
$route['huong-dan-mua-hang'] = "thongtin/huongdanmuahang";


/* End of file routes.php */
/* Location: ./application/config/routes.php */















