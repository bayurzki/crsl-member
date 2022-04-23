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

    private function dummy_data(){
      $data = '{
        "id": 820982911946154508,
        "email": "jon@doe.ca",
        "closed_at": null,
        "created_at": "2022-04-06T08:09:03-04:00",
        "updated_at": "2022-04-06T08:09:03-04:00",
        "number": 234,
        "note": null,
        "token": "123456abcd",
        "gateway": null,
        "test": true,
        "total_price": "403.00",
        "subtotal_price": "393.00",
        "total_weight": 0,
        "total_tax": "0.00",
        "taxes_included": false,
        "currency": "USD",
        "financial_status": "voided",
        "confirmed": false,
        "total_discounts": "5.00",
        "total_line_items_price": "398.00",
        "cart_token": null,
        "buyer_accepts_marketing": true,
        "name": "#9999",
        "referring_site": null,
        "landing_site": null,
        "cancelled_at": "2022-04-06T08:09:03-04:00",
        "cancel_reason": "customer",
        "total_price_usd": null,
        "checkout_token": null,
        "reference": null,
        "user_id": null,
        "location_id": null,
        "source_identifier": null,
        "source_url": null,
        "processed_at": null,
        "device_id": null,
        "phone": null,
        "customer_locale": "en",
        "app_id": null,
        "browser_ip": null,
        "landing_site_ref": null,
        "order_number": 1234,
        "discount_applications": [
          {
            "type": "manual",
            "value": "5.0",
            "value_type": "fixed_amount",
            "allocation_method": "each",
            "target_selection": "explicit",
            "target_type": "line_item",
            "description": "Discount",
            "title": "Discount"
          }
        ],
        "discount_codes": [

        ],
        "note_attributes": [

        ],
        "payment_gateway_names": [
          "visa",
          "bogus"
        ],
        "processing_method": "",
        "checkout_id": null,
        "source_name": "web",
        "fulfillment_status": "pending",
        "tax_lines": [

        ],
        "tags": "",
        "contact_email": "jon@doe.ca",
        "order_status_url": "https:\/\/jsmith.myshopify.com\/548380009\/orders\/123456abcd\/authenticate?key=abcdefg",
        "presentment_currency": "USD",
        "total_line_items_price_set": {
          "shop_money": {
            "amount": "398.00",
            "currency_code": "USD"
          },
          "presentment_money": {
            "amount": "398.00",
            "currency_code": "USD"
          }
        },
        "total_discounts_set": {
          "shop_money": {
            "amount": "5.00",
            "currency_code": "USD"
          },
          "presentment_money": {
            "amount": "5.00",
            "currency_code": "USD"
          }
        },
        "total_shipping_price_set": {
          "shop_money": {
            "amount": "10.00",
            "currency_code": "USD"
          },
          "presentment_money": {
            "amount": "10.00",
            "currency_code": "USD"
          }
        },
        "subtotal_price_set": {
          "shop_money": {
            "amount": "393.00",
            "currency_code": "USD"
          },
          "presentment_money": {
            "amount": "393.00",
            "currency_code": "USD"
          }
        },
        "total_price_set": {
          "shop_money": {
            "amount": "403.00",
            "currency_code": "USD"
          },
          "presentment_money": {
            "amount": "403.00",
            "currency_code": "USD"
          }
        },
        "total_tax_set": {
          "shop_money": {
            "amount": "0.00",
            "currency_code": "USD"
          },
          "presentment_money": {
            "amount": "0.00",
            "currency_code": "USD"
          }
        },
        "line_items": [
          {
            "id": 866550311766439020,
            "variant_id": 808950810,
            "title": "IPod Nano - 8GB",
            "quantity": 1,
            "sku": "IPOD2008PINK",
            "variant_title": null,
            "vendor": null,
            "fulfillment_service": "manual",
            "product_id": 632910392,
            "requires_shipping": true,
            "taxable": true,
            "gift_card": false,
            "name": "IPod Nano - 8GB",
            "variant_inventory_management": "shopify",
            "properties": [

            ],
            "product_exists": true,
            "fulfillable_quantity": 1,
            "grams": 567,
            "price": "199.00",
            "total_discount": "0.00",
            "fulfillment_status": null,
            "price_set": {
              "shop_money": {
                "amount": "199.00",
                "currency_code": "USD"
              },
              "presentment_money": {
                "amount": "199.00",
                "currency_code": "USD"
              }
            },
            "total_discount_set": {
              "shop_money": {
                "amount": "0.00",
                "currency_code": "USD"
              },
              "presentment_money": {
                "amount": "0.00",
                "currency_code": "USD"
              }
            },
            "discount_allocations": [

            ],
            "duties": [

            ],
            "admin_graphql_api_id": "gid:\/\/shopify\/LineItem\/866550311766439020",
            "tax_lines": [

            ]
          },
          {
            "id": 141249953214522974,
            "variant_id": 808950810,
            "title": "IPod Nano - 8GB",
            "quantity": 1,
            "sku": "IPOD2008PINK",
            "variant_title": null,
            "vendor": null,
            "fulfillment_service": "manual",
            "product_id": 632910392,
            "requires_shipping": true,
            "taxable": true,
            "gift_card": false,
            "name": "IPod Nano - 8GB",
            "variant_inventory_management": "shopify",
            "properties": [

            ],
            "product_exists": true,
            "fulfillable_quantity": 1,
            "grams": 567,
            "price": "199.00",
            "total_discount": "5.00",
            "fulfillment_status": null,
            "price_set": {
              "shop_money": {
                "amount": "199.00",
                "currency_code": "USD"
              },
              "presentment_money": {
                "amount": "199.00",
                "currency_code": "USD"
              }
            },
            "total_discount_set": {
              "shop_money": {
                "amount": "5.00",
                "currency_code": "USD"
              },
              "presentment_money": {
                "amount": "5.00",
                "currency_code": "USD"
              }
            },
            "discount_allocations": [
              {
                "amount": "5.00",
                "discount_application_index": 0,
                "amount_set": {
                  "shop_money": {
                    "amount": "5.00",
                    "currency_code": "USD"
                  },
                  "presentment_money": {
                    "amount": "5.00",
                    "currency_code": "USD"
                  }
                }
              }
            ],
            "duties": [

            ],
            "admin_graphql_api_id": "gid:\/\/shopify\/LineItem\/141249953214522974",
            "tax_lines": [

            ]
          }
        ],
        "fulfillments": [

        ],
        "refunds": [

        ],
        "total_tip_received": "0.0",
        "original_total_duties_set": null,
        "current_total_duties_set": null,
        "payment_terms": null,
        "admin_graphql_api_id": "gid:\/\/shopify\/Order\/820982911946154508",
        "shipping_lines": [
          {
            "id": 271878346596884015,
            "title": "Generic Shipping",
            "price": "10.00",
            "code": null,
            "source": "shopify",
            "phone": null,
            "requested_fulfillment_service_id": null,
            "delivery_category": null,
            "carrier_identifier": null,
            "discounted_price": "10.00",
            "price_set": {
              "shop_money": {
                "amount": "10.00",
                "currency_code": "USD"
              },
              "presentment_money": {
                "amount": "10.00",
                "currency_code": "USD"
              }
            },
            "discounted_price_set": {
              "shop_money": {
                "amount": "10.00",
                "currency_code": "USD"
              },
              "presentment_money": {
                "amount": "10.00",
                "currency_code": "USD"
              }
            },
            "discount_allocations": [

            ],
            "tax_lines": [

            ]
          }
        ],
        "billing_address": {
          "first_name": "Bob",
          "address1": "123 Billing Street",
          "phone": "555-555-BILL",
          "city": "Billtown",
          "zip": "K2P0B0",
          "province": "Kentucky",
          "country": "United States",
          "last_name": "Biller",
          "address2": null,
          "company": "My Company",
          "latitude": null,
          "longitude": null,
          "name": "Bob Biller",
          "country_code": "US",
          "province_code": "KY"
        },
        "shipping_address": {
          "first_name": "Steve",
          "address1": "123 Shipping Street",
          "phone": "555-555-SHIP",
          "city": "Shippington",
          "zip": "40003",
          "province": "Kentucky",
          "country": "United States",
          "last_name": "Shipper",
          "address2": null,
          "company": "Shipping Company",
          "latitude": null,
          "longitude": null,
          "name": "Steve Shipper",
          "country_code": "US",
          "province_code": "KY"
        },
        "customer": {
          "id": 115310627314723954,
          "email": "john@test.com",
          "accepts_marketing": false,
          "created_at": null,
          "updated_at": null,
          "first_name": "John",
          "last_name": "Smith",
          "orders_count": 0,
          "state": "disabled",
          "total_spent": "0.00",
          "last_order_id": null,
          "note": null,
          "verified_email": true,
          "multipass_identifier": null,
          "tax_exempt": false,
          "phone": null,
          "tags": "",
          "last_order_name": null,
          "currency": "USD",
          "accepts_marketing_updated_at": null,
          "marketing_opt_in_level": null,
          "email_marketing_consent": {
            "state": "not_subscribed",
            "opt_in_level": null,
            "consent_updated_at": null
          },
          "sms_marketing_consent": null,
          "admin_graphql_api_id": "gid:\/\/shopify\/Customer\/115310627314723954",
          "default_address": {
            "id": 715243470612851245,
            "customer_id": 115310627314723954,
            "first_name": null,
            "last_name": null,
            "company": null,
            "address1": "123 Elm St.",
            "address2": null,
            "city": "Ottawa",
            "province": "Ontario",
            "country": "Canada",
            "zip": "K2H7A8",
            "phone": "123-123-1234",
            "name": "",
            "province_code": "ON",
            "country_code": "CA",
            "country_name": "Canada",
            "default": true
          }
        }
      }';
      return $data;
    }

    private function dummy_customer(){
      $data = '
      {"id":5927087964342,"email":"tes3@aaa.com","accepts_marketing":false,"created_at":"2022-04-23T23:34:41+07:00","updated_at":"2022-04-23T23:34:41+07:00","first_name":"","last_name":"","orders_count":0,"state":"disabled","total_spent":"0.00","last_order_id":null,"note":"","verified_email":true,"multipass_identifier":null,"tax_exempt":false,"phone":null,"tags":"","last_order_name":null,"currency":"IDR","addresses":[],"accepts_marketing_updated_at":"2022-04-23T23:34:41+07:00","marketing_opt_in_level":null,"tax_exemptions":[],"email_marketing_consent":{"state":"not_subscribed","opt_in_level":"single_opt_in","consent_updated_at":null},"sms_marketing_consent":null,"admin_graphql_api_id":"gid:\/\/shopify\/Customer\/5927087964342"}';

      return $data;
    }

    public function index(){
    	echo 'Page not found';
    }

    public function customer_create(){
        header('Content-Type: application/json');
        $data = file_get_contents('php://input');
        //$data = $this->dummy_customer();
        $data_ = json_decode($data, true);
        $shop = $_GET['shop'];

        $merchant_row = $this->Data_master_m->merchant_row($shop);
        $member = $this->Data_master_m->member($merchant_row->url_shopify,$data_['id']);
        $earn_account = $this->Data_master_m->earn_event($merchant_row->id_merchant,'account');
          
        if ($member == NULL) {
          if ($data_['total_spent'] > 1500000) {
            $is_member = 1;
          }else{
            $is_member = 0;
          }
          $data_default = array(
              'id' => $data_['id'],
              'data' => $data,
              'shop' => $shop,
              'is_member' => $is_member,
              'points' => 0,
              'create_at' => date('Y-m-d H:i:s')
          );

          //$this->db->insert('member', $data_default);

          
          if ($earn_account != NULL) {
            $add_point = $earn_account->point;
            $add_point = $member->points + $add_point;
            $logs = array(
              'id_order' => $data_['id'],
              'id_customer' => $data_['customer']['id'],
              'add_point' => $add_point,
              'total' => $data_['total_price'],
              'sub_total' => $data_['subtotal_price'],
              'discount' => $data_['total_discounts'],
              'shipping' => $data_['total_shipping_price_set']['shop_money']['amount']
            );

            $this->db->where('id',$data_['customer']['id']);
            $this->db->update('member', array(
              'points' => $add_point
            ));

            $data_logs = array(
              'id' => $this->Data_master_m->create_id_logs(),
              'id_merchant' => $merchant_row->id_merchant,
              'event' => 'account',
              'content' => json_encode($logs),
              'create_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('logs', $data_logs); 
          }
        }
    }

    public function order_paid(){
        header('Content-Type: application/json');
        $shop = $_GET['shop'];
        $data = file_get_contents('php://input');
        $data_ = json_decode($data, true);
        error_log($data);
        //$total = $data_['subtotal_price'];
        $total = 238990;
        $merchant_row = $this->Data_master_m->merchant_row($shop);
        $earn = $this->Data_master_m->earn_event($merchant_row->id_merchant,'orders');
        $member = $this->Data_master_m->member($merchant_row->url_shopify,$data_['customer']['id']);
        $data_order = $data_['line_items'];
        if ($member != null) { // akun sudah ada di db
          if ($member->is_member == 1) { // status member aktif
            if ($earn->is_active == 1){ // earn point dengan trigger order aktif
              if ($earn->type == 0) { // type earn flat
                  $add_point = $total;
              }else{ // type earn adjustable
                  $add_point = $total * $earn->point;
                  $add_point = round($add_point);
              }
              $add_point = $member->points + $add_point;
              $logs = array(
                'id_order' => $data_['id'],
                'id_customer' => $data_['customer']['id'],
                'add_point' => $add_point,
                'total' => $data_['total_price'],
                'sub_total' => $data_['subtotal_price'],
                'discount' => $data_['total_discounts'],
                'shipping' => $data_['total_shipping_price_set']['shop_money']['amount']
              );

              $this->db->where('id',$data_['customer']['id']);
              $this->db->update('member', array(
                'points' => $add_point
              ));

              $data_logs = array(
                'id' => $this->Data_master_m->create_id_logs(),
                'id_merchant' => $merchant_row->id_merchant,
                'event' => 'orders',
                'content' => json_encode($logs),
                'create_at' => date('Y-m-d H:i:s')
              );
              $this->db->insert('logs', $data_logs);

              // end
            }
          }else{ // status member tidak aktif
            $get_customer = $this->shopify->api_get($shop,'customers/'.$member->id.'.json',$merchant_row->token_store);
            $get_customer = json_decode($get_customer, TRUE);
            $get_customer = $get_customer['customer'];
            if ($get_customer['total_spent'] > 1500000) { // hitung total spent dari history order
              $this->db->where('id',$get_customer['id']);
              $this->db->update('member', array(
                'is_member' => 1
                )
              );
            }
            // end
          }
        }else{ // akun belum ada di db
          if ($data_['customer']['total_spent'] > 1500000) {
            $is_member = 1;
          }else{
            $is_member = 0;
          }
          // buat akun
          // jika spent > 1500000 set member aktif
          $data_default = array(
              'id' => $data_['id'],
              'data' => json_encode($data_['customer']),
              'is_member' => $is_member,
              'shop' => $_GET['shop'],
              'points' => 0,
              'create_at' => date('Y-m-d H:i:s')
          );
          $this->db->insert('member', $data_default);
          $earn_account = $this->Data_master_m->earn_event($shop,'account');
          if ($earn_account != NULL) {
            $add_point = $earn_account->point;
            $add_point = $member->points + $add_point;
            $logs = array(
              'id_order' => $data_['id'],
              'id_customer' => $data_['customer']['id'],
              'add_point' => $add_point,
              'total' => $data_['total_price'],
              'sub_total' => $data_['subtotal_price'],
              'discount' => $data_['total_discounts'],
              'shipping' => $data_['total_shipping_price_set']['shop_money']['amount']
            );

            $this->db->where('id',$data_['customer']['id']);
            $this->db->update('member', array(
              'points' => $add_point
            ));

            $data_logs = array(
              'id' => $this->Data_master_m->create_id_logs(),
              'id_merchant' => $merchant_row->id_merchant,
              'event' => 'account',
              'content' => json_encode($logs),
              'create_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('logs', $data_logs); 
          }
          // end
        }
        
    }

    public function tess(){
      $data = array(
        array(
          'event' => 'orders',
          'id_merchant' => 1234,
          'nama' => 'Customer Order',
          'type' => 1,
          'point' => 0.0001,
          'ket' => 'Customer get 1 point/ 1000 rupiah paid',
          'is_active' => 0,
          'create_at' => date('Y-m-d H:i:s'),
        ),
        array(
          'event' => 'orders',
          'id_merchant' => 1234,
          'nama' => 'Customer create account',
          'type' => 1,
          'point' => 1,
          'ket' => 'Customer get 1 point when create account',
          'is_active' => 0,
          'create_at' => date('Y-m-d H:i:s'),
        ),
        array(
          'event' => 'orders',
          'id_merchant' => 1234,
          'nama' => 'Customer Birtday',
          'type' => 1,
          'point' => 1,
          'ket' => 'Customer get point in their birtday',
          'is_active' => 0,
          'create_at' => date('Y-m-d H:i:s'),
        )
      );
      echo "<pre>";
      var_dump($this->dummy_data());
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