<?php
class Mob_sendInquiry extends MY_Controller{
    function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $itemid = $this->uri->rsegment(3,0);
        if(!$itemid){
            show_404();
            die();
        }

        $this->load->model('sell_model','sell');
        $product = $this->sell->getSellCommon('*',"itemid='{$itemid}'",'','','',1);
        if(!$product){
            show_404();
            die();
        }

        $data['product'] = $product;

//        $this->load->view('mob/header');
        $this->load->view('sendInquiry',$data);
        $this->load->view('footer');
    }
}