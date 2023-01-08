<?php

class TablesAndKeys {

	public function __construct() {
        date_default_timezone_set("Africa/Lagos");
        $this->date_time = date("Y-m-d H:i:s");
	} 

	public function getTableNames() {
	    // $tableNames = array(
	    //     'roles' => "roles",
	    //     'roles_and_module_access' => "roles_and_module_access",
	    //     'module_access' => "module_access",
	    //     'module_permission' => "module_permission",
	    //     'roles_and_permissions' => "roles_and_permissions", 
	    // );

	    $tableNames = array(
                  
			'banks' => "banks",
			'carts' => "carts",
	        'company_info' => "company_info",
			'contact_us' => "contact_us",
			'confirmation_link' => "confirmation_link",
			'category_types' => "category_types",
			'categories' => "categories",

	        'devices' => "devices",
	        'departments' => "departments",
	        'designations' => "designations",
	        'employees' => "employees",
	        'employee_bank' => "employee_bank",
	        'employee_family_info' => "employee_family_info",
			'email_templates' => "email_templates",
			'email_subscribers' => "email_subscribers",
	        'error_report' => "error_report",

	        'login' => "login",  
			'locations' => "locations",
	        'initial_report' => "initial_report",
	        'invoice_settings' => "invoice_settings",

			'orders' => "orders",
			'order_history' => "order_history",
			'order_status' => "order_status",
			'order_and_payment_history' => "order_and_payment_history",

			'payments' => "payments",
			'products' => "products",
			'products_status' => "products_status",
			'popular_search' => "popular_search",
			'product_comments' => "product_comments",
			'product_history' => "product_history",
			'products_status_history' => "products_status_history",
			'product_rating' => "product_rating",
			'rating_types' => "rating_types",
			'reset_password_codes' => "reset_password_codes",

			'saved_products' => "saved_products",
			'shipping_addresses' => "shipping_addresses",
			'shipping_fee' => "shipping_fee",
			'sms_account' => "sms_account",
			'sms_response_codes' => "sms_response_codes",
			'sms_templates' => "sms_templates",
			'settings' => "settings",
			'saved_items' => "saved_items",
			'stored_words' => "stored_words",
			'search' => "search",
	        'successful_report' => "successful_report",

	        'tbl_country' => "tbl_country",
	        'tbl_lga' => "tbl_lga",
	        'tbl_states' => "tbl_states",
	        'tbl_country_zones_kg_and_prices' => "tbl_country_zones_kg_and_prices",
	        'tbl_state_zones_kg_and_prices' => "tbl_state_zones_kg_and_prices",
			'temporary_stored_search' => "temporary_stored_search",
			'templates' => "templates",

			'user_history' => "user_history",
			'users' => "users",
			'user_login' => "user_login",
			'user_initial_report' => "user_initial_report",
			'user_error_report' => "user_error_report",
			'user_successful_report' => "user_successful_report",

			'unknown_users' => "unknown_users",
			'viewed_products' => "viewed_products",
			'vouchers' => "vouchers",
			'verification_codes' => "verification_codes",
			'product_discount_history' => "product_discount_history",
			'product_images' => "product_images",
            'login_attempts' => "login_attempts",

			'secret_key' => "sk_test_34b6fcb33366bf95cc84188c4d617baa96c1c86",
			'email_title' => isset($_SERVER['EMAIL_TITLE'])?$_SERVER['EMAIL_TITLE']:null,
			'sendgrid_api' => "SG.Ttivn_EMR36FFTFbFcoPww.UNjt7hDEvKyID6L-CPDhyRL1ZfCYiM9jX24WsTosFt",

			'ebulk_sms_url' => "http://api.ebulksms.com:8080/sendsms.json",    
        	'time_zone' => $_SERVER['TIME_ZONE'],
        );

	    return $tableNames;
	}

	public function getDateTime() {
		return $this->date_time;
	}

}