<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webhooks extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //load model admin
        $this->load->library('shopify');
        $this->load->model('Data_master_m');
    }

    public function index(){
    	echo 'Page not found';
    }

    public function customer_create(){
        header('Content-Type: application/json');
        $data = file_get_contents('php://input');
        $data_default = array(
            'data' => $data,
            'shop' => $_GET['shop'],
            'points' => 0,
            'create_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('member', $data_default);

    }

    public function shop_data_erasure(){
        header('Content-Type: application/json');
        $data = file_get_contents('php://input');

        $this->db->insert('shop_data_erasure', array('data'=>$data));
    }

    public function customer_data_erasure(){
        header('Content-Type: application/json');
        $data = file_get_contents('php://input');
        $this->db->insert('customer_data_erasure', array('data'=>$data));

        echo 'no data collecting';
    }

    public function customer_data_request(){
        header('Content-Type: application/json');
        $data = file_get_contents('php://input');
        $this->db->insert('customer_data_request', array('data'=>$data));
        echo 'no data collecting';
    }

    public function app_uninstall(){
        header('Content-Type: application/json');
        $data = file_get_contents('php://input');
        
        $data = json_decode($data, false);

        $id_store = $data->id;
        $nama_store = $data->name;
        $email_store = $data->email;
        $url_store = $data->domain;
        $phone_store = $data->phone;

        $merchant_row = $this->Data_master_m->merchant_row($url_store);
        
        $to_email = 'app@bolehdicoba.com';
        //Load email library
        $this->load->library('email');
        $this->email->from($merchant_row->email_merchant);
        $this->email->to($to_email);
        $this->email->subject('Uninstalled app: '.$url_store);
        $this->email->message('
            Unique Code Transaction App Uninstalled: '.$url_store.'<br />
            ');
        $this->email->send();
        //Send mail

        $id_appna = $merchant_row->id_app_charges;
        $delete_app_charge = $this->shopify->api_delete($url_store, "recurring_application_charges/".$id_appna.".json", $merchant_row->token_store);

        $this->db->where('id', $merchant_row->id);
        $this->db->delete('merchant_data');
    }
}
?>