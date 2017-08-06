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

$route['master-employee'] = 'md_employee';
$route['master-employee-add'] = 'md_employee/add';
$route['master-employee-edit-(:num)'] = 'md_employee/edit/$1';
$route['master-employee-delete-(:num)'] = 'md_employee/delete/$1';
$route['master-employee-save'] = 'md_employee/save';

$route['employee-level'] = 'md_level';
$route['employee-level-add'] = 'md_level/add';
$route['employee-level-edit-(:num)'] = 'md_level/edit/$1';
$route['employee-level-delete-(:num)'] = 'md_level/delete/$1';
$route['employee-level-save'] = 'md_level/save';

$route['master-product'] = 'md_product';
$route['master-product-add'] = 'md_product/add';
$route['master-product-edit-(:num)'] = 'md_product/edit/$1';
$route['master-product-delete-(:num)'] = 'md_product/delete/$1';
$route['master-product-save'] = 'md_product/save';

$route['master-product-category'] = 'md_product_category';
$route['master-product-category-add'] = 'md_product_category/add';
$route['master-product-category-edit-(:num)'] = 'md_product_category/edit/$1';
$route['master-product-category-delete-(:num)'] = 'md_product_category/delete/$1';
$route['master-product-category-save'] = 'md_product_category/save';

$route['master-product-sub-category'] = 'md_product_sub_category';
$route['master-product-sub-category-add'] = 'md_product_sub_category/add';
$route['master-product-sub-category-edit-(:num)'] = 'md_product_sub_category/edit/$1';
$route['master-product-sub-category-delete-(:num)'] = 'md_product_sub_category/delete/$1';
$route['master-product-sub-category-save'] = 'md_product_sub_category/save';

$route['master-payment-type'] = 'md_payment_type';
$route['master-payment-type-add'] = 'md_payment_type/add';
$route['master-payment-type-edit-(:num)'] = 'md_payment_type/edit/$1';
$route['master-payment-type-delete-(:num)'] = 'md_payment_type/delete/$1';
$route['master-payment-type-save'] = 'md_payment_type/save';

$route['customer'] = 'md_customer';
$route['customer-add'] = 'md_customer/add';
$route['customer-edit-(:num)'] = 'md_customer/edit/$1';
$route['customer-delete-(:num)'] = 'md_customer/delete/$1';
$route['customer-save'] = 'md_customer/save';

$route['lead-customer'] = 'md_customer_lead';
$route['lead-customer-add'] = 'md_customer_lead/add';
$route['lead-customer-edit-(:num)'] = 'md_customer_lead/edit/$1';
$route['lead-customer-delete-(:num)'] = 'md_customer_lead/delete/$1';
$route['lead-customer-save'] = 'md_customer_lead/save';
$route['lead-customer-set-priority-(:num)'] = 'md_customer_lead/setPriority/$1';
$route['lead-customer-undo-priority-(:num)'] = 'md_customer_lead/undoPriority/$1';

$route['lead-customer-priority'] = 'md_customer_lead_priority';
$route['lead-customer-priority-edit-(:num)'] = 'md_customer_lead_priority/edit/$1';
$route['lead-customer-priority-save'] = 'md_customer_lead_priority/save';

$route['mapping-product'] = 't_mapping_product';
$route['mapping-product-edit-(:num)'] = 't_mapping_product/edit/$1';
$route['mapping-product-view-(:num)'] = 't_mapping_product/view/$1';
$route['mapping-product-save'] = 't_mapping_product/save';

$route['mapping-area'] = 't_mapping_area';
$route['mapping-area-edit-(:num)'] = 't_mapping_area/edit/$1';
$route['mapping-area-view-(:num)'] = 't_mapping_area/view/$1';
$route['mapping-area-save'] = 't_mapping_area/save';

$route['master-area'] = 'md_area';
$route['master-area-add'] = 'md_area/add';
$route['master-area-edit-(:num)'] = 'md_area/edit/$1';
$route['master-area-delete-(:num)'] = 'md_area/delete/$1';
$route['master-area-save'] = 'md_area/save';

$route['master-subarea'] = 'md_subarea';
$route['master-subarea-add'] = 'md_subarea/add';
$route['master-subarea-edit-(:num)'] = 'md_subarea/edit/$1';
$route['master-subarea-delete-(:num)'] = 'md_subarea/delete/$1';
$route['master-subarea-save'] = 'md_subarea/save';

$route['backup-database'] = 'backup_db';
$route['backup-database-add'] = 'backup_db/add';
$route['backup-database-edit-(:num)'] = 'backup_db/edit/$1';
$route['backup-database-delete-(:num)'] = 'backup_db/delete/$1';
$route['backup-database-save'] = 'backup_db/save';
$route['backup-database-page'] = 'backup_db/index';
$route['backup-database-page/(:any)'] = 'backup_db/index/$1';
$route['backup-database-pdf'] = 'backup_db/print_pdf';
$route['backup-database-pdf/(:any)'] = 'backup_db/print_pdf/$1';
$route['backup-database-excel'] = 'backup_db/print_excel';
$route['backup-database-excel/(:any)'] = 'backup_db/print_excel/$1';

$route['import-master-list'] = 'import_master_list';
$route['import-master-list-template'] = 'import_master_list/template_excel';
$route['import-master-list-upload'] = 'import_master_list/upload_excel';

$route['sales-order'] = 't_sales_order';
$route['sales-order-add'] = 't_sales_order/add';
$route['sales-order-edit-(:num)'] = 't_sales_order/edit/$1';
$route['sales-order-delete-(:num)'] = 't_sales_order/delete/$1';
$route['sales-order-detail-(:num)'] = 't_sales_order/detail/$1';
$route['sales-order-save'] = 't_sales_order/save';

$route['ojt'] = 't_sales_visit';
$route['ojt-add'] = 't_sales_visit/add';
$route['ojt-detail-(:num)'] = 't_sales_visit/detail/$1';

$route['visit-form'] = 't_visit_form';
$route['visit-form-add'] = 't_visit_form/add';
$route['visit-form-edit-(:num)'] = 't_visit_form/edit/$1';
$route['visit-form-delete-(:num)'] = 't_visit_form/delete/$1';
$route['visit-form-save'] = 't_visit_form/save';

$route['promo-product'] = 't_promo_product';
$route['promo-product-add'] = 't_promo_product/add';
$route['promo-product-edit-(:num)'] = 't_promo_product/edit/$1';
$route['promo-product-delete-(:num)'] = 't_promo_product/delete/$1';
$route['promo-product-detail-(:num)'] = 't_promo_product/detail/$1';
$route['promo-product-save'] = 't_promo_product/save';

$route['sales-delivery'] = 't_sales_delivery';
$route['sales-delivery-add'] = 't_sales_delivery/add';
$route['sales-delivery-edit-(:num)'] = 't_sales_delivery/edit/$1';
$route['sales-delivery-delete-(:num)'] = 't_sales_delivery/delete/$1';
$route['sales-delivery-detail-(:num)'] = 't_sales_delivery/detail/$1';
$route['sales-delivery-save'] = 't_sales_delivery/save';

$route['invoice'] = 't_invoice';
$route['invoice-add'] = 't_invoice/add';
$route['invoice-edit-(:num)'] = 't_invoice/edit/$1';
$route['invoice-delete-(:num)'] = 't_invoice/delete/$1';
$route['invoice-detail-(:num)'] = 't_invoice/detail/$1';
$route['invoice-save'] = 't_invoice/save';

$route['payment-due-date'] = 't_pay_duedate';
$route['payment-due-date-edit-(:num)'] = 't_pay_duedate/edit/$1';
$route['payment-due-date-save'] = 't_pay_duedate/save';

$route['log-pdf'] = 'log_pdf';

$route['form-produksi-add'] = 't_produksi/add';

$route['master-obat-add'] = 'md_obat/add';