<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Membership extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //load model admin
        $this->load->model('Login_m');
        $this->load->model('Data_master_m');
    	$this->load->library('session');
    }

    public function index(){
        echo "Not Authorize";
    }

    public function cek_mem(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
        extract($_POST);
        $member = $this->Data_master_m->member($url_shopify,$customer_id);
        if ($member == NULL) {
            $data = array(
                'code' => 404,
                'messages' => 'Not Registered as Member'
            );
        }else{
            if ($member->is_member == 0) {
                $data = array(
                    'code' => 0,
                    'messages' => 'Not Registered as Member, please make purchased at least IDR 1,500,000'
                );
            }else{
                $shop = $this->Data_master_m->merchant_row($url_shopify);
                $customer = $this->shopify->api_get($url_shopify,'customers/'.$customer_id.'.json',$shop->token_store);
                $customer = json_decode($customer,false);
                $customer = $customer->customer;
                $data = array(
                    'code' => 1,
                    'point' => $member->points,
                    'id' => $member->id,
                    'total_spent' => number_format($customer->total_spent)
                );
            }
        }

        echo json_encode($data);
    }
}