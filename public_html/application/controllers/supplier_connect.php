<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Supplier_connect extends CI_Controller {
	

    /**
     * 保存inquiry
     */
    public function save(){
        $this->load->model('inquiry_model','inquiry');

        $post = $this->input->post("post");
        $sid = $post['sid'];

        if(!$this->input->cookie($sid)) {
            $tmp = $this->inquiry->saveInquiry();
            //防止重复提交
            if ($tmp) {
                $this->input->set_cookie($sid, $this->input->ip_address(), 60);
                echo 1;
            }else{
                echo 3;
            }
        }else{
            echo 2;
        }
    }
}