<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //load model admin
        $this->load->model('Login_m');
        $this->load->model('Data_master_m');
    	$this->load->library('session');
    }

    

    public function index(){
    	$all_merchant = $this->Data_master_m->all_merchant();
    	echo base_url();
    	echo "<pre>";
    	var_dump($all_merchant);
    	echo "</pre>";
    	
    }

    public function install(){
    	$api_key = $this->config->item('shopify_api_key');
	    $scopes = $this->config->item('scopes');

	   	$redirect_uri = $this->config->item('redirect_url');
	   	$redirect_scope = $this->config->item('generate_scope');
	   	$redirect_install_lagi = $this->config->item('install_lagi');
    	if ( !empty($_POST) ) {
    		extract($_POST);
	    	
	    	// Build install/approval URL to redirect to
			$install_url = "https://" . $urlna . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

			// Redirect
			header("Location: " . $install_url);
    	}else{
    		$params = $_GET; // Retrieve all request parameters
	        $hmac = $_GET['hmac']; // Retrieve HMAC request parameter
	        $urlna = $_GET['shop']; 

        	$merchant_row = $this->Data_master_m->merchant_row($urlna);
	        
        	if ($merchant_row == NULL) {
        		$install_url = "https://" . $urlna . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);
        		
				header("Location: " . $install_url);
        	}else{
        		$this->load->library('shopify');

        		$scopena = $this->shopify->shopify_call($merchant_row->token_store, $params['shop'], "/admin/oauth/access_scopes.json", array(), 'GET');
        		
        		$scopena = json_decode($scopena['response'], TRUE);
        		if(isset($scopena['errors'])){
	        		$install_url = "https://" . $urlna . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);
        			echo '<p style="text-align: center;">Please re-install this apps. </p><br />';
	        		echo '<a href="'.$install_url.'" style="text-align: center; background: #177bf7; color: #fff; max-width: 120px; display: block; text-decoration: none; margin: 15px auto; padding: 15px;" target="_top">Re-install App</a>';
        		}else{
        			if (sizeof($scopena['access_scopes']) == 10) {
	        			redirect('config?id='.$merchant_row->id_merchant);
	        		}else{
	        			$re_install = 'https://'.$merchant_row->url_shopify.'/admin/oauth/authorize?client_id='.$api_key.'&scope='.$scopes.'&redirect_uri='.urlencode($redirect_scope);
	        			
	        			if (getallheaders()['sec-fetch-dest'] == 'iframe'){
	        				echo '<p style="text-align: center;">Please update again this app to add new scopes. </p><br />';
	        				echo '<a href="'.$re_install.'" style="text-align: center; background: #177bf7; color: #fff; max-width: 120px; display: block; text-decoration: none; margin: 15px auto; padding: 15px;" target="_top">Update App</a>';
	        			}else{
							header("Location: " . $re_install);
	        			}
	        		}
        		}
        	}
    	}
    }

    public function install_lagi(){

    	$api_key = $this->config->item('shopify_api_key');
		$shared_secret = $this->config->item('shopify_secret');
	    
		$headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );
        parse_str($_SERVER['QUERY_STRING'], $outputArray);
		
    	$params = $_GET; // Retrieve all request parameters
		$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

		$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
		ksort($params); // Sort params lexographically

		$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);
		// Use hmac data to check that the response is from Shopify or not
		if (hash_equals($hmac, $computed_hmac)) {

			// Set variables for our request
			$query = array(
				"client_id" => $api_key, // Your API key
				"client_secret" => $shared_secret, // Your app credentials (secret key)
				"code" => $params['code'] // Grab the access key from the URL
			);

			// Generate access token URL
			$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

			// Configure curl client and execute request
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $access_token_url);
			curl_setopt($ch, CURLOPT_POST, count($query));
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
			$result = curl_exec($ch);
			curl_close($ch);

			// Store the access token
			$result = json_decode($result, true);
			$access_token = $result['access_token'];
	        
	        $merchant_row = $this->Data_master_m->merchant_row($params['shop']);
			
			$this->db->where('id', $merchant_row->id);
			$this->db->update('merchant_data', array(
				'token_store' => $access_token
			));

			redirect('https://'.$params['shop'].'/admin/apps/kode-unik-order-1');

		} else {
			// Someone is trying to be shady!
			die('This request is NOT from Shopify!');
		}
    }

    public function generate_scope(){
    	
    	$api_key = $this->config->item('shopify_api_key');
		$shared_secret = $this->config->item('shopify_secret');
	    
		$headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );
        parse_str($_SERVER['QUERY_STRING'], $outputArray);
		
    	$params = $_GET; // Retrieve all request parameters
		$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

		$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
		ksort($params); // Sort params lexographically

		$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);
		// Use hmac data to check that the response is from Shopify or not
		if (hash_equals($hmac, $computed_hmac)) {

			// Set variables for our request
			$query = array(
				"client_id" => $api_key, // Your API key
				"client_secret" => $shared_secret, // Your app credentials (secret key)
				"code" => $params['code'] // Grab the access key from the URL
			);

			// Generate access token URL
			$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

			// Configure curl client and execute request
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $access_token_url);
			curl_setopt($ch, CURLOPT_POST, count($query));
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
			$result = curl_exec($ch);
			curl_close($ch);

			// Store the access token
			$result = json_decode($result, true);
			$access_token = $result['access_token'];
	        
			redirect('https://'.$params['shop'].'/admin/apps/kode-unik-order-1');

		} else {
			// Someone is trying to be shady!
			die('This request is NOT from Shopify!');
		}
    }

    public function generate_token(){
    	$api_key = $this->config->item('shopify_api_key');
		$shared_secret = $this->config->item('shopify_secret');
	    
		$headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );

    	$params = $_GET; // Retrieve all request parameters
		$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

		$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
		ksort($params); // Sort params lexographically

		$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);
		// Use hmac data to check that the response is from Shopify or not
		if (hash_equals($hmac, $computed_hmac)) {

			// Set variables for our request
			$query = array(
				"client_id" => $api_key, // Your API key
				"client_secret" => $shared_secret, // Your app credentials (secret key)
				"code" => $params['code'] // Grab the access key from the URL
			);

			// Generate access token URL
			$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

			// Configure curl client and execute request
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $access_token_url);
			curl_setopt($ch, CURLOPT_POST, count($query));
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
			$result = curl_exec($ch);
			curl_close($ch);

			// Store the access token
			$result = json_decode($result, true);
			$access_token = $result['access_token'];

			// detail shop
			$shopna = $this->shopify->shopify_call($access_token, $params['shop'], "/admin/api/2020-01/shop.json", array(), 'GET', $headerna);
			$datana = $shopna['response'];
		    $shop = json_decode($datana, JSON_PRETTY_PRINT);
        	
        	$merchant_row = $this->Data_master_m->merchant_row($params['shop']);
        	if ($merchant_row == NULL) {
        		$merchant_data = array(
					'id_merchant' => $shop['shop']['id'],
					'email_merchant' => $shop['shop']['email'],
					'phone_merchant' => $shop['shop']['phone'],
				    'nama_merchant' => $shop['shop']['name'],
				    'alamat_merchant' => $shop['shop']['address1'],
				    'city_merchant' => $shop['shop']['city'],
				    'provinsi_merchant' => $shop['shop']['province'],
				    'country_merchant' => $shop['shop']['country_name'],
				    'url_shopify' => $params['shop'],
				    'token_store' => $access_token,
				    'create_at' => date('Y-m-d H:i:s') 
				);

				$this->db->insert('merchant_data', $merchant_data);

				
        	}else{
        		$data_update = array(
        			'url_shopify' => $params['shop'],
				    'token_store' => $access_token,
				    'create_at' => date('Y-m-d H:i:s')
        		);

        		$this->db->where('id', $merchant_row->id);
        		$this->db->update('merchant_data', $data_update);
        	}			
		    
			redirect('https://'.$params['shop'].'/admin/apps/member-crsl-stagging');

		} else {
			// Someone is trying to be shady!
			die('This request is NOT from Shopify!');
		}

    }

}