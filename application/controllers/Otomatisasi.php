<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Otomatisasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //load model admin
        $this->load->library('shopify');
        $this->load->model('Data_master_m');
    }

    
    public function product_edit_price(){
        $headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );
        $merchants = $this->Data_master_m->merchant_all();
        $products[] = array();
        foreach ($merchants as $key => $value) {
	   		$harganya[$key] = sprintf("%03d", mt_rand($value['start_code'], $value['end_code']));

	        if ($value['id_variant'] != NULL) {
	        	$queryna[$key] = "{\r\n    \"variant\": {\r\n        \"price\": \"".$harganya[$key]."\",\r\n        \"inventory_policy\": \"deny\",\r\n        \"compare_at_price\": null,\r\n        \"fulfillment_service\": \"manual\",\r\n        \"inventory_management\": null,\r\n        \"taxable\": false\r\n    }\r\n}";
	        
		        $kode_variant[$key] = $value['id_variant'];
		        // $queryna = json_encode($queryna); 
		        $products[$key] = $this->shopify->apina($value['url_shopify'], "/admin/api/2020-01/variants/".$kode_variant[$key].".json", $value['token_store'] , $queryna[$key] ,'PUT');
	        }
        }
        
        

        //$produkna = json_decode($products['response'], TRUE);
        var_dump($products);
    }

    public function product_add(){
        extract($_POST);
        $headerna = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );
        
        $merchant_row = $this->Data_master_m->merchant_row($url_shopify);
        
        $token = $merchant_row->token_store;
        parse_str($_SERVER['QUERY_STRING'], $outputArray);
        

        if ($merchant_row->id_variant == NULL) {
            $harganya = sprintf("%03d", mt_rand(1, 999));
            $queryna = "{\r\n  \"product\": {\r\n    \"title\": \"Unique Code\",\r\n    \"body_html\": \"<strong>Automatic added to cart when customer on the checkout page!</strong>\",\r\n    \"product_type\": \"bdd-hidden-product\",\r\n    \"variants\": [\r\n      {\r\n        \"price\": \"".$harganya."\",\r\n        \"inventory_policy\": \"deny\",\r\n        \"compare_at_price\": null,\r\n        \"fulfillment_service\": \"manual\",\r\n        \"inventory_management\": null,\r\n        \"requires_shipping\": false,\r\n    \t\"taxable\": false\r\n      }\r\n    ]\r\n  }\r\n}";

            $products = $this->shopify->apina($url_shopify, "/admin/api/2019-10/products.json", $token , $queryna ,'POST');
            $produkna = json_decode($products, TRUE);

            $product_handle = '';
            foreach ($produkna as $key => $value) {
                $product_handle = $value['handle'];
                foreach ($value['variants'] as $v => $var) {
                    $datana = array(
                        'id_variant' => $var['id'],
                    );
                    $this->db->where('id', $merchant_row->id);
                    $this->db->update('merchant_data', $datana);
                }
            }
        }else{
            $products = $this->shopify->api_get($merchant_row->url_shopify, "variants/".$merchant_row->id_variant.".json", $token);
            $produkna = json_decode($products, TRUE);
            $produkna = $this->shopify->api_get($merchant_row->url_shopify, "products/".$produkna['variant']['product_id'].".json", $token);
            $produkna = json_decode($produkna, TRUE);
            $product_handle = $produkna['product']['handle'];
        }
        

        $query_assets = "{\r\n  \"asset\": {\r\n    \"key\": \"snippets/bdd-uniquetrans.liquid\",\r\n    \"value\": \"<style>\\r\\n.bdd-preload-hide{\\r\\ndisplay: none !important;\\r\\n}\\r\\n#bdd-preload{\\r\\ndisplay: block;\\r\\nwidth: 100%;\\r\\nheight: 100%;\\r\\nbackground: #00000070;\\r\\nposition: fixed;\\r\\nz-index: 999;\\r\\noverflow: hidden;\\r\\n}\\r\\n\\r\\n.bdd-loader {\\r\\nborder: 16px solid #f3f3f3;\\r\\nborder-radius: 50%;\\r\\nborder-top: 16px solid #3498db;\\r\\nwidth: 120px;\\r\\nheight: 120px;\\r\\n-webkit-animation: spin 2s linear infinite; /* Safari */\\r\\nanimation: spin 2s linear infinite;\\r\\nmargin: auto;\\r\\ndisplay: block;\\r\\ntop: 50%;\\r\\nposition: relative;\\r\\n}\\r\\n\\r\\n@-webkit-keyframes spin {\\r\\n0% { -webkit-transform: rotate(0deg); }\\r\\n100% { -webkit-transform: rotate(360deg); }\\r\\n}\\r\\n\\r\\n@keyframes spin {\\r\\n0% { transform: rotate(0deg); }\\r\\n100% { transform: rotate(360deg); }\\r\\n}\\r\\n.bdd-hide-product{\\r\\ndisplay:none !important;\\r\\n}\\r\\n</style>\\r\\n\\r\\n{% comment %}{% if template contains 'cart' %}\\r\\n<div id='bdd-preload'><span class='bdd-loader'></span></div>\\r\\n{% assign product = all_products['".$product_handle."'] %}\\r\\n\\r\\n{% if cart.item_count != 0 or product != '' or product.variants.first.available == true %}\\r\\n\\r\\n{% assign variant_id = product.variants.first.id %}\\r\\n\\r\\n<script>\\r\\n var cart_items = {{ cart.items | json }};\\r\\n var jml_item = {{ cart.item_count }};\\r\\n var variant_id = {{ variant_id }};var cart_id = [];\\r\\n for (var i=0; i < cart_items.length; i++) {cart_id[i]=cart_items[i].id;} \\r\\n if(cart_id.indexOf(variant_id) != -1 || jml_item == 0){\\r\\n document.getElementById('bdd-preload').classList.add('bdd-preload-hide');\\r\\n}\\r\\n\\r\\n</script>\\r\\n\\r\\n{% else %}\\r\\n<script>\\r\\n var cart_items = {{ cart.items | json }};\\r\\nvar variant_id = 0;\\r\\n</script>\\r\\n{% endif %}\\r\\n{% endif %}{% endcomment %}\"\r\n  }\r\n}";
        

        $assetsna = $this->shopify->apina($url_shopify, "/admin/api/2020-01/themes/".$id_themes."/assets.json", $token , $query_assets ,'PUT');

        $theme_file = $this->shopify->api_get($url_shopify, "themes/".$id_themes."/assets.json?asset[key]=layout/theme.liquid", $token);
        $theme_file = json_decode($theme_file, TRUE);
        $layout_liquid = $theme_file["asset"]["value"];        
        $themefile_arr = explode("\n",$layout_liquid);
        
        //$last_head = array_search('</head>', $themefile_arr);
        $contains = "</head>";
        $last_head = array_keys(array_filter($themefile_arr, function($var) use ($contains){
            return strpos($var, $contains) !== false;
        }));
        $insert_filena = "{% comment %}Unique Code Transaction file{% endcomment %}{% include 'bdd-uniquetrans' %}";
        array_splice( $themefile_arr, $last_head[0], 0, $insert_filena ); 

        $put_code_theme = implode("\n", $themefile_arr);
        
        $put_code_theme = str_replace('"', '\"', $put_code_theme);
        $put_code_theme = str_replace("'", "\'", $put_code_theme);        
        $put_code_theme = preg_replace('/\n|\r$/m', '\\n', $put_code_theme);

        $query_theme_file = '
        {
            "asset": {
                "key": "layout/theme.liquid",
                "value": "'.$put_code_theme.'"
            }
        }';
        
        $edit_theme_file = $this->shopify->api_put($url_shopify, "themes/".$id_themes."/assets.json", $token , $query_theme_file);
        $queryna = json_decode($edit_theme_file); 
        
    }

    function save_coderange(){
        extract($_POST);

        $datana = array(
            'start_code' => $start_code,
            'end_code' => $end_code,
        );

        $this->db->where('id_merchant', $id_merchant);
        $this->db->update('merchant_data', $datana);

        echo 'ok';
    }

    function app_active(){
        extract($_POST);
        
        if ($mode == 'true') {
            $headerna = array(
                "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
            );
            $merchant_row = $this->Data_master_m->merchant_row($url_shopify);
            $token = $merchant_row->token_store;
            $shop = $url_shopify;

            if ($merchant_row->id_script_tags == NULL or $merchant_row->id_script_tags == '') {
                $array = array(
                    'script_tag' => array(
                        'event' => 'onload', 
                        'src' => base_url().'assets/js-shopify/script.js'
                    ),
                );

                $scriptTag = $this->shopify->shopify_call($token, $shop, "/admin/api/2020-01/script_tags.json", $array, 'POST');
                $scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);

                $this->db->where('id_merchant', $merchant_row->id_merchant);
                $this->db->update('merchant_data', array(
                    'id_script_tags' => $scriptTag['script_tag']['id']
                ));
            }
            
            $bdd_filena = $this->shopify->api_get($shop, "themes/".$themesna."/assets.json?asset[key]=snippets/bdd-uniquetrans.liquid", $token);
            $bdd_filena = json_decode($bdd_filena, TRUE);
            $bdd_filena = $bdd_filena["asset"]["value"]; 
            $bdd_filena = explode("\n",$bdd_filena);
            $contains = "id='bdd-preload'";
            $preload_line = array_keys(array_filter($bdd_filena, function($var) use ($contains){
                return strpos($var, $contains) !== false;
            }));
            $index_comment = $preload_line[0] - 1;
            $bdd_filena[$index_comment] = "{% if template contains 'cart' %}";
            array_pop($bdd_filena) ;         
            $bdd_filena[count($bdd_filena)] = '{% endif %}';            
            
            $put_code_theme = implode("\n", $bdd_filena);
        
            $put_code_theme = str_replace('"', '\"', $put_code_theme);
            $put_code_theme = str_replace("'", "\'", $put_code_theme);        
            $put_code_theme = preg_replace('/\n|\r$/m', '\\n', $put_code_theme);

            $query_theme_file = '
            {
                "asset": {
                    "key": "snippets/bdd-uniquetrans.liquid",
                    "value": "'.$put_code_theme.'"
                }
            }';
            
            $edit_theme_file = $this->shopify->api_put($shop, "themes/".$themesna."/assets.json", $token , $query_theme_file);
            $queryna = json_decode($edit_theme_file);

            echo 'Active';
        }else{
            $headerna = array(
                "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
            );
            $merchant_row = $this->Data_master_m->merchant_row($url_shopify);
            $token = $merchant_row->token_store;
            $shop = $url_shopify;
            
            $bdd_filena = $this->shopify->api_get($shop, "themes/".$themesna."/assets.json?asset[key]=snippets/bdd-uniquetrans.liquid", $token);
            $bdd_filena = json_decode($bdd_filena, TRUE);
            $bdd_filena = $bdd_filena["asset"]["value"]; 
            $bdd_filena = explode("\n",$bdd_filena);
            $contains = "id='bdd-preload'";
            $preload_line = array_keys(array_filter($bdd_filena, function($var) use ($contains){
                return strpos($var, $contains) !== false;
            }));
            $index_comment = $preload_line[0] - 1;
            $start_comment = "{% comment %}";
            $end_comment = "{% endcomment %}";
            $bdd_filena[$index_comment] = $start_comment."{% if template contains 'cart' %}";
            array_pop($bdd_filena) ;         
            $bdd_filena[count($bdd_filena)] = '{% endif %}'.$end_comment; 

            $put_code_theme = implode("\n", $bdd_filena);
            $put_code_theme = str_replace('"', '\"', $put_code_theme);
            $put_code_theme = str_replace("'", "\'", $put_code_theme);        
            $put_code_theme = preg_replace('/\n|\r$/m', '\\n', $put_code_theme);

            $query_theme_file = '
            {
                "asset": {
                    "key": "snippets/bdd-uniquetrans.liquid",
                    "value": "'.$put_code_theme.'"
                }
            }';
            
            $edit_theme_file = $this->shopify->api_put($shop, "themes/".$themesna."/assets.json", $token , $query_theme_file);
            $queryna = json_decode($edit_theme_file);
            echo 'non active';
        }
    }

}
?>