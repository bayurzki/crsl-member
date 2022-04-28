<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_master_m extends CI_Model{

    function create_id_logs(){
        $q = $this->db->query("SELECT MAX(RIGHT(id,3)) AS kd_max FROM logs WHERE DATE(create_at)=CURDATE()");
        $kd = "";
            if($q->num_rows()>0){
                foreach($q->result() as $k){
                    $tmp = ((int)$k->kd_max)+1;
                    $kd = sprintf("%04s", $tmp);
                }
            }else{
                $kd = "0001";
            }

            date_default_timezone_set('Asia/Jakarta');
            return date('ymd').$kd;
    }

    function merchant_all(){
        $this->db->select('*');
        $this->db->from('merchant_data');
        $this->db->where('merchant_data.uninstall = 0');
        $query = $this->db->get();
        return $query->result_array();
    }

    function merchant_row($url){
        $this->db->select('*');
        $this->db->from('merchant_data');
        $this->db->where('merchant_data.url_shopify', $url);
        $this->db->where('merchant_data.uninstall = 0');
        $query = $this->db->get();
        return $query->row();
    }

    function merchant_byid($id_merchant){
        $this->db->select('*');
        $this->db->from('merchant_data');
        $this->db->where('merchant_data.id_merchant', $id_merchant);
        $this->db->where('merchant_data.uninstall = 0');
        $query = $this->db->get();
        return $query->row();
    }

    function merchant_uninstalled($url){
        $this->db->select('*');
        $this->db->from('uninstall_merchant');
        $this->db->where('uninstall_merchant.url_shopify', $url);
        $query = $this->db->get();
        return $query->result_array();
    }

    function all_merchant(){
        $this->db->select('*');
        $this->db->from('merchant_data');
        $query = $this->db->get();
        return $query->result_array();
    }

    function member_all($shop){
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('data !=', '');
        $this->db->where('shop', $shop);
        $query = $this->db->get();
        return $query->result_array();
    }

    function member($shop,$id){
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('id', $id);
        $this->db->where('shop', $shop);
        $this->db->where('data !=', '');
        $query = $this->db->get();
        return $query->row();
    }

    function earns($id_merchant){
        $this->db->select('*');
        $this->db->from('earns');
        $this->db->where('id_merchant',$id_merchant);
        $query = $this->db->get();
        return $query->result_array();
    }

    function earn_event($id_merchant,$event){
        $this->db->select('*');
        $this->db->from('earns');
        $this->db->where('id_merchant',$id_merchant);
        $this->db->where('event',$event);
        $this->db->where('is_active',1);
        $query = $this->db->get();
        return $query->row();
    }

    function earn($id){
        $this->db->select('*');
        $this->db->from('earns');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    function rewards($id_merchant){
        $this->db->select('*');
        $this->db->from('rewards');
        $this->db->where('id_merchant', $id_merchant);
        $query = $this->db->get();
        return $query->result_array();
    }

    function reward($id,$id_merchant){
        $this->db->select('*');
        $this->db->from('rewards');
        $this->db->where('id',$id);
        $this->db->where('id_merchant',$id_merchant);
        $query = $this->db->get();
        return $query->row();
    }

    function generateRandomString($length = 8) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
