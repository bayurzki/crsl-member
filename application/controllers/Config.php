<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //load model admin
        $this->load->library('shopify');
        $this->load->model('Data_master_m');
    }

    public function index(){
        $data['shop'] = $this->Data_master_m->merchant_byid($_GET['id']);
        $webhook = $this->shopify->api_get($data['shop']->url_shopify,'webhooks.json',$data['shop']->token_store);
        $webhook = json_decode($webhook,TRUE);

        if (sizeof($webhook['webhooks']) < 2) {
            $customer_create = '{
                "webhook":{
                    "topic":"customers/create",
                    "address":"'.base_url().'webhooks/customer_create?shop='.$data['shop']->url_shopify.'",
                    "format":"json"
                }
            }';
            $this->shopify->api_post($data['shop']->url_shopify,'webhooks.json',$data['shop']->token_store,$customer_create);
        }


        $this->template->load('template_config','config/index', $data);
    }

    public function product(){
    	parse_str($_SERVER['QUERY_STRING'], $outputArray);
        $merchant_row = $this->Data_master_m->merchant_row($outputArray['shop']);
        $token = $merchant_row->token_store;

    	$products = $this->shopify->shopify_call($outputArray['shop'], "/admin/products.json", array(), 'GET');

		// Convert product JSON information into an array
		
		$produkna = json_decode($products['response'], TRUE);
		$data['produkna'] = $produkna['products'];
		
    	$this->template->load('template_config','config/products', $data);
    }

    public function openapp(){
        var_dump($_SERVER);
        die();
        parse_str($_SERVER['QUERY_STRING'], $outputArray);
        $merchant_row = $this->Data_master_m->merchant_row($outputArray['shop']);
        redirect('config/setting_product/'.$merchant_row->id_merchant);
        
    }

    public function app_charges($id_merchant){
        $merchant_row = $this->Data_master_m->merchant_byid($id_merchant);
        $merchant_uninstalled = $this->Data_master_m->merchant_uninstalled($merchant_row->url_shopify);
            if (sizeof($merchant_uninstalled) > 0) {
                $total_pake = 0;
                foreach ($merchant_uninstalled as $key => $value) {
                    $install_date = strtotime($value['installed_at']);
                    $unsinstall_date = strtotime($value['create_at']);

                    $timeDiff = abs($unsinstall_date - $install_date);

                    $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                    $total_pake += $numberDays;
                }

                $total_pake = round($total_pake);
                if ($total_pake > 0 AND $total_pake <= 14) {
                    $free_trial = 14 - $total_pake;
                }else{
                    $free_trial = 14;
                }
            }else{
                $free_trial = 14;
            }
            
            $billed_date = date('Y-m-d', strtotime("+".round($free_trial)." days"));

            $app_charges = array(
                'recurring_application_charge' => array(
                    'name' => 'UniqueTransactions Apps', 
                    'return_url' => 'https://'.$merchant_row->url_shopify.'/admin/apps/kode-unik-order-1/kodeunik-apps/front/save_merchant/'.$merchant_row->url_shopify,
                    "test"=> null,
                    "price" => '4.99',
                    "trial_days" => $free_trial,
                    "billing_on" => $billed_date
                )
            );

            $app_chargesna = $this->shopify->shopify_call($merchant_row->token_store, $merchant_row->url_shopify, "/admin/api/2020-04/recurring_application_charges.json", $app_charges, 'POST');

        $data_app_charges = $app_chargesna['response'];
        $data_app_charges = json_decode($data_app_charges, JSON_PRETTY_PRINT);

        $this->db->where('id', $merchant_row->id);
        $this->db->update('merchant_data', array(
            'id_app_charges'=>$data_app_charges['recurring_application_charge']['id'],
            'app_active_at' => date('Y-m-d H:i:s')

        ));
        return $data_app_charges['recurring_application_charge']['confirmation_url'];
    }

    public function setting_product($id_merchant){
        $headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );

        
        parse_str($_SERVER['QUERY_STRING'], $outputArray);
        $merchant_row = $this->Data_master_m->merchant_byid($id_merchant);
        
        $token = $merchant_row->token_store;
        var_dump("te");
    }

    public function save_variant(){
        extract($_POST);
        $merchant_row = $this->Data_master_m->merchant_row($url_shopify);

        $datana = array(
            'id_variant' => $id_variant,
        );
        $this->db->where('id', $merchant_row->id);
        $this->db->update('merchant_data', $datana);
    }

    public function product_add(){
        $headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );
        $token = 'e1675dacf618bd52eed6fd753e9f16f1';
        parse_str($_SERVER['QUERY_STRING'], $outputArray);

        $queryna = "{\r\n  \"product\": {\r\n    \"title\": \"kode unik151\",\r\n    \"variants\": [{\r\n        \"price\": \"134\"\r\n    }],\r\n    \"tags\": [\r\n      \"hidden-produk\",\r\n      \"hide\",\r\n      \"\\\"Big Air\\\"\"\r\n    ]\r\n  }\r\n}";

        // $queryna = json_encode($queryna); 
        $products = $this->shopify->apina($outputArray['shop'], "/admin/api/2019-10/products.json", $token , $queryna ,'POST');

        //$produkna = json_decode($products['response'], TRUE);
        var_dump($products);
    }

    public function product_edit_price(){
        
        $headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );
        $token = 'e1675dacf618bd52eed6fd753e9f16f1';
        parse_str($_SERVER['QUERY_STRING'], $outputArray);

        $harganya = sprintf("%03d", mt_rand(1, 999));
        $queryna = "{\r\n    \"variant\": {\r\n        \"price\": \"".$harganya."\",\r\n        \"inventory_policy\": \"deny\",\r\n        \"compare_at_price\": null,\r\n        \"fulfillment_service\": \"manual\",\r\n        \"inventory_management\": null,\r\n        \"taxable\": false\r\n    }\r\n}";
        
        $kode_variant = '32137995288664';
        // $queryna = json_encode($queryna); 
        $products = $this->shopify->apina($outputArray['shop'], "/admin/api/2020-01/variants/".$kode_variant.".json", $token , $queryna ,'PUT');

        //$produkna = json_decode($products['response'], TRUE);
        var_dump($products);
    }

    function send_request_mail(){
        extract($_POST);
        $to_email = 'app@bolehdicoba.com';
        //Load email library
        $this->load->library('email');
        $this->email->from($email_merchant);
        $this->email->to($to_email);
        $this->email->subject('Request Installation Unique Code Apps');
        $this->email->message('Shopify URL: '.$url_shopify);
        //Send mail
        if($this->email->send()){
            echo 1;
        }

        $this->db->where('id', $id_appna);
        $this->db->update('merchant_data', array('req_install' => 1));

    }

    function send_contact_mail(){
        extract($_POST);
        $to_email = 'app@bolehdicoba.com';
        //Load email library
        $this->load->library('email');
        $this->email->from($email_merchant);
        $this->email->to($to_email);
        $this->email->subject('Support Contact: '.$url_shopify.' - '.$subjectna);
        $this->email->message('
            Email From: '.$name.'<br />
            Messages:'.$messagesna.' 
            ');
        //Send mail
        $data = array(
            'id' => $this->Data_master_m->create_id_messages(),
            'nama' => $name,
            'app_id' => $id_appna,
            'email' => $email_merchant,
            'url_shopify' => $url_shopify,
            'subject' => $subjectna,
            'textna' => $messagesna,
            'create_at' => date('Y-m-d H:i:s')

        );

        $this->db->insert('messages', $data);

        if($this->email->send()){
            echo 1;

        }

    }
    function add_product_handle(){
        extract($_POST);
        $merchant_row = $this->Data_master_m->merchant_row($url_shopify);
        $token = $merchant_row->token_store;

        $products = $this->shopify->apina($url_shopify, "/admin/api/2019-10/products.json", $token , array() ,'GET');
        $products = json_decode($products, TRUE);
        $products = $products['products'];

        $cek_handle = array_search($product_handle, array_column($products, 'handle'));
        if ($cek_handle != NULL) {
            $product_variant = $this->shopify->apina($url_shopify, "/admin/api/2019-10/products/".$products[$cek_handle]['id'].".json", $token , array() ,'GET');
            $product_variant = json_decode($product_variant, TRUE);
            $product_variant = $product_variant['product']['variants'];
            $this->db->where('id', $merchant_row->id);
            $this->db->update('merchant_data', array(
                'id_variant' => $product_variant[0]['id']
            ));
            echo $product_variant[0]['id'];
        }else{
            echo 0;
        }
    }
}
?>