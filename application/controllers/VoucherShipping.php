<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class VoucherShipping extends REST_Controller {
    
   /**
   * Get All Data from this method.
   *
   * @return Response
   */
   public function __construct() {
      parent::__construct();
      $this->load->model('Data_master_m');
      $this->load->database();
   }

   public function index_get($code = 0){
      
      if(!empty($code)){
         $data = $this->Data_master_m->voucher_shipping($code);
         if ($data != NULL) {
            $data = $data;
         }else{
            $data = 0;
         }
      }else{
         $data = $this->Data_master_m->voucher_shipping_all();
         if ($data != NULL) {
            $data = $data;
         }else{
            $data = 0;
         }
      }

      $this->response($data, REST_Controller::HTTP_OK);
   }
}