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
                $shop = $this->Data_master_m->merchant_row($url_shopify);
                $customer = $this->shopify->api_get($url_shopify,'customers/'.$customer_id.'.json',$shop->token_store);
                $customer = json_decode($customer,false);
                $customer = $customer->customer;

                $data = array(
                    'code' => 0,
                    'total_spent' => number_format($customer->total_spent),
                    'point' => $member->points,
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

    public function redeem(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
        extract($_POST);
        $merchant_row = $this->Data_master_m->merchant_row($url_shopify);
        $reward = $this->Data_master_m->reward($id_reward,$merchant_row->id_merchant);
        $today = date('Y-m-d\TH:i:sP');
        $customer = $this->Data_master_m->member($url_shopify,$customer_id);

        if ($customer->is_member == 1) {
            if ($customer->points > $reward->point) {
                if ($reward->type == 0) {
                    $code = $this->Data_master_m->generateRandomString();
                    $data_reward = array(
                        'code' => $code,
                        'customer_id' => $customer_id,
                        'id_reward' => $id_reward,
                        'create_at' => date('Y-m-d H:i:s')
                    );

                    $this->db->insert('voucher_shipping');

                    $callback = array(
                        "code" => 1,
                        "title" => "Congratulations!",
                        "messages" => "You've successfully redeemed a Shipping Voucher code."
                    );
                }elseif ($reward->type == 1) {
                    $terms = json_decode($reward->terms, true);

                    $data_price_rules = '{
                        "price_rule":{
                            "title":"Membership reward - '.$reward->title.'",
                            "target_type":"line_item",
                            "target_selection":"all",
                            "customer_selection": "prerequisite",
                            "once_per_customer": true,
                            "prerequisite_customer_ids": [
                                '.$customer_id.'
                            ],
                            "allocation_method":"across",
                            "value_type":"percentage",
                            "value":"-'.$terms['persen_discount'].'",
                            "usage_limit": 1,
                            "starts_at": "'.$today.'"
                        }
                    }';

                    $price_rules = $this->shopify->api_post($url_shopify,'price_rules.json',$merchant_row->token_store,$data_price_rules);
                    var_dump($price_rules);
                    die();
                    $price_rules = json_decode($price_rules, TRUE);

                    if (!isset($price_rules['price_rule']['errors'])) {
                        $codena = '{
                            "discount_code":{
                                "code":"points-'.$this->Data_master_m->generateRandomString().'"
                            }
                        }';
                        $discount_code = $this->shopify->api_post($url_shopify,'price_rules/'.$price_rules['price_rule']['id'].'/discount_codes.json',$merchant_row->token_store,$codena);
                        var_dump($discount_code);
                        die();
                        $discount_code = json_decode($discount_code, TRUE);

                        $callback = array(
                            "code" => 1,
                            "title" => "Congratulations!",
                            "messages" => "You've successfully redeemed a Gift, for more info admin will contact you."
                        );
                        json_encode($callback);
                    }else{
                        echo 404; // error price rules gagal dibuat
                    }
                }else{
                    $terms = json_decode($reward->terms, true);
                    if ($terms['min_order'] == 0) {
                        $q_product = '{
                            "product" : {
                                "title" : "'.$terms['gift_name'].'"
                            }
                        }';  
                        $prod = $this->shopify->api_post($merchant_row->url_shopify,'products.json',$merchant_row->token_store,$q_product);
                        
                        $prod = json_decode($prod,true);
                        $prod = $prod['product'];
                        $id_product = $prod['id'];
                        $id_variant = $prod['variants'][0]['id'];

                        $q_order = '{
                            "order" : {
                                "line_items" : [
                                    {
                                        "variant_id" : '.$id_variant.',
                                        "quantity" : 1
                                    }
                                ],
                                "customer" : {
                                    "id" : '.$customer_id.'
                                }
                            }
                        }'; 
                        $ord = $this->shopify->api_post($merchant_row->url_shopify,'orders.json',$merchant_row->token_store,$q_order);

                        $un_product = '{
                            "product" : {
                                "id" : '.$id_product.',
                                "status" : "draft",
                                "published" : false
                            }
                        }';

                        $this->shopify->api_put($merchant_row->url_shopify,'products/'.$id_product.'.json',$merchant_row->token_store,$un_product); 

                        $callback = array(
                            "code" => 1,
                            "title" => "Congratulations!",
                            "messages" => "You've successfully redeemed a Gift, for more info admin will contact you."
                        );
                    }
                }
            }else{
                $callback = array(
                    'code' => 3,
                    'title' => 'Failed',
                    'messages' => 'Sorry you\'ve not enought point to redeem this reward'
                );
            }
        }else{
            $callback = array(
                'code' => 3,
                'title' => 'Failed',
                'messages' => 'Sorry you\'re not registered as member, make purchase more than 1,5 mio to activate as member'
            );
        }
        
    }

    public function apply_shipping(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Content-Type, Accept");
        extract($_POST);
        $merchant_row = $this->Data_master_m->merchant_row($url_shopify);
        $reward = $this->Data_master_m->reward($id_reward,$merchant_row->id_merchant);
        var_dump($reward);
        echo 1;
    }
}