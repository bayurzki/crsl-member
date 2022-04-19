<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_master_m extends CI_Model{

    function create_id_messages(){
        $q = $this->db->query("SELECT MAX(RIGHT(id,2)) AS kd_max FROM messages WHERE DATE(create_at)=CURDATE()");
        $kd = "";
            if($q->num_rows()>0){
                foreach($q->result() as $k){
                    $tmp = ((int)$k->kd_max)+1;
                    $kd = sprintf("%03s", $tmp);
                }
            }else{
                $kd = "001";
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
}