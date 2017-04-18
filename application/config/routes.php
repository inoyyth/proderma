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
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['home'] = 'dashboard';

$route['user-management'] = 'account';
$route['user-management-add'] = 'account/add';
$route['user-management-edit-(:num)'] = 'account/edit/$1';
$route['user-management-delete-(:num)'] = 'account/delete/$1';
$route['user-management-save'] = 'account/save';
$route['user-management-page'] = 'account/index';
$route['user-management-page/(:any)'] = 'account/index/$1';
$route['user-management-pdf'] = 'account/print_pdf';
$route['user-management-pdf/(:any)'] = 'account/print_pdf/$1';
$route['user-management-excel'] = 'account/print_excel';
$route['user-management-excel/(:any)'] = 'account/print_excel/$1';

$route['master-employee'] = 'md_employee';
$route['master-employee-add'] = 'md_employee/add';
$route['master-employee-edit-(:num)'] = 'md_employee/edit/$1';
$route['master-employee-delete-(:num)'] = 'md_employee/delete/$1';
$route['master-employee-save'] = 'md_employee/save';
$route['master-employee-page'] = 'md_employee/index';
$route['master-employee-page/(:any)'] = 'md_employee/index/$1';
$route['master-employee-pdf'] = 'md_employee/print_pdf';
$route['master-employee-pdf/(:any)'] = 'md_employee/print_pdf/$1';
$route['master-employee-excel'] = 'md_employee/print_excel';
$route['master-employee-excel/(:any)'] = 'md_employee/print_excel/$1';

$route['employee-level'] = 'md_level';
$route['employee-level-add'] = 'md_level/add';
$route['employee-level-edit-(:num)'] = 'md_level/edit/$1';
$route['employee-level-delete-(:num)'] = 'md_level/delete/$1';
$route['employee-level-save'] = 'md_level/save';
$route['employee-level-page'] = 'md_level/index';
$route['employee-level-page/(:any)'] = 'md_level/index/$1';
$route['employee-level-pdf'] = 'md_level/print_pdf';
$route['employee-level-pdf/(:any)'] = 'md_level/print_pdf/$1';
$route['employee-level-excel'] = 'md_level/print_excel';
$route['employee-level-excel/(:any)'] = 'md_level/print_excel/$1';

$route['master-product'] = 'md_product';
$route['master-product-add'] = 'md_product/add';
$route['master-product-edit-(:num)'] = 'md_product/edit/$1';
$route['master-product-delete-(:num)'] = 'md_product/delete/$1';
$route['master-product-save'] = 'md_product/save';
$route['master-product-page'] = 'md_product/index';
$route['master-product-page/(:any)'] = 'md_product/index/$1';
$route['master-product-pdf'] = 'md_product/print_pdf';
$route['master-product-pdf/(:any)'] = 'md_product/print_pdf/$1';
$route['master-product-excel'] = 'md_product/print_excel';
$route['master-product-excel/(:any)'] = 'md_product/print_excel/$1';

$route['master-product-category'] = 'md_product_category';
$route['master-product-category-add'] = 'md_product_category/add';
$route['master-product-category-edit-(:num)'] = 'md_product_category/edit/$1';
$route['master-product-category-delete-(:num)'] = 'md_product_category/delete/$1';
$route['master-product-category-save'] = 'md_product_category/save';
$route['master-product-category-page'] = 'md_product_category/index';
$route['master-product-category-page/(:any)'] = 'md_product_category/index/$1';
$route['master-product-category-pdf'] = 'md_product_category/print_pdf';
$route['master-product-category-pdf/(:any)'] = 'md_product_category/print_pdf/$1';
$route['master-product-category-excel'] = 'md_product_category/print_excel';
$route['master-product-category-excel/(:any)'] = 'md_product_category/print_excel/$1';

$route['master-payment-type'] = 'md_payment_type';
$route['master-payment-type-add'] = 'md_payment_type/add';
$route['master-payment-type-edit-(:num)'] = 'md_payment_type/edit/$1';
$route['master-payment-type-delete-(:num)'] = 'md_payment_type/delete/$1';
$route['master-payment-type-save'] = 'md_payment_type/save';
$route['master-payment-type-page'] = 'md_payment_type/index';
$route['master-payment-type-page/(:any)'] = 'md_payment_type/index/$1';
$route['master-payment-type-pdf'] = 'md_payment_type/print_pdf';
$route['master-payment-type-pdf/(:any)'] = 'md_payment_type/print_pdf/$1';
$route['master-payment-type-excel'] = 'md_payment_type/print_excel';
$route['master-payment-type-excel/(:any)'] = 'md_payment_type/print_excel/$1';

$route['master-customer'] = 'md_customer';
$route['master-customer-add'] = 'md_customer/add';
$route['master-customer-edit-(:num)'] = 'md_customer/edit/$1';
$route['master-customer-delete-(:num)'] = 'md_customer/delete/$1';
$route['master-customer-save'] = 'md_customer/save';
$route['master-customer-page'] = 'md_customer/index';
$route['master-customer-page/(:any)'] = 'md_customer/index/$1';
$route['master-customer-pdf'] = 'md_customer/print_pdf';
$route['master-customer-pdf/(:any)'] = 'md_customer/print_pdf/$1';
$route['master-customer-excel'] = 'md_customer/print_excel';
$route['master-customer-excel/(:any)'] = 'md_customer/print_excel/$1';