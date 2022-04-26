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
        $data['id'] = $_GET['id'];
        $data['nav'] = 'member';
        $data['shop'] = $this->Data_master_m->merchant_byid($_GET['id']);
        $webhook = $this->shopify->api_get($data['shop']->url_shopify,'webhooks.json',$data['shop']->token_store);
        $webhook = json_decode($webhook,TRUE);

        $script_tags = $this->shopify->api_get($data['shop']->url_shopify,'script_tags.json',$data['shop']->token_store);
        $script_tags = json_decode($script_tags,TRUE);
        if (sizeof($script_tags['script_tags']) < 1) {
            $scriptna = '{
                "src": "'.base_url().'assets/js-shopify/crsl-member.js",
                "event": "onload",
                "cache": false
            }';

            $this->shopify->api_post($data['shop']->url_shopify,'script_tags.json',$data['shop']->token_store, $scriptna);
        }
        if (sizeof($webhook['webhooks']) < 3) {
            if (base_url() == 'https://crsl-member.com/') {
                $base_url = 'https://bdd.services/crsl-member/';
            }else{
                $base_url = base_url();
            }

            $uninstall = '{
                "webhook": {
                    "topic": "app/uninstalled",
                    "address": "'.$base_url.'webhooks/app_uninstall?shop='.$data['shop']->url_shopify.'",
                    "format": "json"
                }
            }';
            $this->shopify->api_post($data['shop']->url_shopify,'webhooks.json',$data['shop']->token_store, $uninstall);

            $customer_create = '{
                "webhook":{
                    "topic":"customers/create",
                    "address":"'.$base_url.'webhooks/customer_create?shop='.$data['shop']->url_shopify.'",
                    "format":"json"
                }
            }';
            $this->shopify->api_post($data['shop']->url_shopify,'webhooks.json',$data['shop']->token_store,$customer_create);

            $orders_paid = '{
                "webhook":{
                    "topic":"orders/paid",
                    "address":"'.$base_url.'webhooks/order_paid?shop='.$data['shop']->url_shopify.'",
                    "format":"json"
                }
            }';
            $this->shopify->api_post($data['shop']->url_shopify,'webhooks.json',$data['shop']->token_store,$orders_paid);
        }

        $data['member'] = $this->Data_master_m->member_all($data['shop']->url_shopify);
        $this->template->load('template_config','config/index', $data);
    }

    public function member($id){
        $data['id'] = $_GET['id'];
        $data['nav'] = 'member';
        $data['shop'] = $this->Data_master_m->merchant_byid($_GET['id']);
        $data['member'] = $this->Data_master_m->member($data['shop']->url_shopify,$id);
        $this->template->load('template_config','config/member', $data);
    }

    public function settings(){
        $data['id'] = $_GET['id'];
        $data['nav'] = 'setting';
        $data['earns'] = $this->Data_master_m->earns($_GET['id']);
        $this->template->load('template_config','config/settings', $data);
    }

    public function update_earn($id){
        $data['id'] = $_GET['id'];
        $data['nav'] = 'setting';
        $data['earn'] = $this->Data_master_m->earn($id);
        $this->template->load('template_config','config/earn_update', $data);
    }

    public function earn_save(){
        extract($_POST);
        $data = array(
            'point' => $point,
            'is_active' => $is_active,
            'type' => $type,
            'update_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('id',$id);
        $this->db->update('earns',$data);

        redirect('config/settings?id='.$shop_id);
    }

    public function rewards(){
        $data['id'] = $_GET['id'];
        $data['nav'] = 'reward';
        $data['rewards'] = $this->Data_master_m->rewards($_GET['id']);
        $this->template->load('template_config','config/rewards', $data);
    }

    public function reward_form(){
        $data['id'] = $_GET['id'];
        if (isset($_GET['data_id'])) {
            $data['reward'] = $this->Data_master_m->reward($_GET['data_id']);
        }else{
            $data['reward'] = '';
        }
        $data['nav'] = 'reward';
        $this->template->load('template_config','config/reward_form', $data);
    }

    public function form_terms(){
        extract($_POST);
        $data['shop'] = $this->Data_master_m->merchant_byid($_GET['id']);
        $data['id'] = $_GET['id'];
        if ($data_id != 0) {
            $data['reward'] = $this->Data_master_m->reward($data_id);
        }else{
            $data['reward'] = '';
        }
        
        if ($type == 0) {
            $this->load->view('config/reward_terms_shipping',$data);
        }elseif ($type == 1) {
            $this->load->view('config/reward_terms_selling',$data);
        }else{
            $this->load->view('config/reward_terms_not_selling',$data);
        }
    }

    public function get_collection(){
        extract($_POST);
        $shop = $this->Data_master_m->merchant_byid($id);
        $smart = $this->shopify->api_get($shop->url_shopify,'smart_collections',$shop->token_store);
        $smart = json_decode($smart,true);
        $smart = $smart['smart_collections'];

        $custom = $this->shopify->api_get($shop->url_shopify,'custom_collections',$shop->token_store);
        $custom = json_decode($custom,true);
        $custom = $custom['custom_collections'];
        echo json_encode(array_merge($smart,$custom));
    }

    public function reward_save(){
        extract($_POST);
        if ($type == 0) {
            $terms = array(
                'min_order' => $minimum_order,
                'max_discount' => $max_discount
            );
        }elseif ($type == 1) {
            $collection = array();
            if ($condition == 'include') {
                for ($i=0; $i < sizeof($col_inc); $i++) { 
                    $collection[] = $col_inc[$i];
                }

                $collection = json_encode($collection);
                $terms = array(
                    'min_order' => $minimum_order,
                    'max_discount' => $max_discount,
                    'collection' => $collection,
                    'condition' => $condition
                );
            }elseif ($condition == 'exclude'){
                for ($i=0; $i < sizeof($col_exl); $i++) { 
                    $collection[] = $col_exl[$i];
                }

                $collection = json_encode($collection);
                $terms = array(
                    'min_order' => $minimum_order,
                    'max_discount' => $max_discount,
                    'collection' => $collection,
                    'condition' => $condition
                );
            }else{
                $terms = array(
                    'min_order' => $minimum_order,
                    'max_discount' => $max_discount,
                    'condition' => $condition
                );
            }
        }else{
            $terms = array(
                'min_order' => $minimum_order,
                'gift_name' => $gift_name
            );
        }
        // var_dump($terms);
        // die();
        if ($id == 0) {
            $data = array(
                'id_merchant' => $shop_id,
                'title' => $title,
                'type' => $type,
                'terms' => json_encode($terms),
                'point' => $point,
                'multi_use' => $multi_use,
                'create_at' => date('Y-m-d H:i:s', strtotime($create_at))
            );
            $this->db->insert('rewards', $data);
        }else{
            $data = array(
                'id_merchant' => $shop_id,
                'title' => $title,
                'type' => $type,
                'terms' => json_encode($terms),
                'point' => $point,
                'multi_use' => $multi_use,
                'update_at' => date('Y-m-d H:i:s', strtotime($create_at))
            );
            $this->db->where('id',$id);
            $this->db->update('rewards', $data);
        }

        redirect('config/rewards?id='.$shop_id);
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
}
?>