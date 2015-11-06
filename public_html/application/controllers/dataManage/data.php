<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class data extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library('image');
        $this->load->model('comm_model','comm');
        $this->load->model('info_model','info');
        $this->load->model('category_model','category');

        header('Content-type:text/html;charset=utf-8');
    }

    public function index(){
        $All = $this->comm->find('info',array('itemid'=>1));
        $allCategoy = $All['category_str'];
        $catArr = explode(',',$allCategoy);
        $this->category($catArr);
    }

    public function category($data,$temp=0,$parentid=0,$arrparentid=0){

            $tempData['catname'] = $data[$temp];
            $inData = $this->category->creatData($tempData);

            if(!$data[$temp]){
                die('处理完毕');
            }
            //topCategory
            if($temp === 0) {
                $re = $this->comm->find('category', array('catname' => "{$data[$temp]}", 'parentid' => $parentid));
                if($re){
                    $this->category($data,$temp+1,$re['catid'],$re['arrparentid']);
//                    echo 1;die;
                }else{
                    //插入
                    $inData['parentid']=0;
                    $inData['arrparentid'] = $arrparentid;
                    $inData['arrchildid'] = '';
                    $ire = $this->db->insert('category',$inData);
                    $new_parentid = mysql_insert_id();
                    if($ire){
                        $tempArrprentid = $arrparentid.",".$new_parentid;
                        $this->db->update('category',array('arrparentid'=>$tempArrprentid,'arrchildid'=>$new_parentid),array('catid'=>$new_parentid));
                       $this->category($data,$temp+1,$new_parentid,$tempArrprentid);
                    }else{
                        echo 'no';die;
                    }
                }
            }else{
                $re = $this->comm->find('category', array('catname' => "{$data[$temp]}", 'parentid' => $parentid));
                if($re){
                    $this->category($data,$temp+1,$re['catid'],$re['arrparentid']);
                }else{
//                    echo $temp."<br>";
//                    echo $parentid."<br>";
//                    echo $arrparentid;die;
                    //插入
                    $inData['parentid']=$parentid;
                    $inData['arrparentid'] = $arrparentid;
                    $ire = $this->db->insert('category',$inData);
                    $new_parentid = mysql_insert_id();
                    if($ire){
                        //arrchildid
                        $this->category_child($new_parentid,$parentid);

                        $tempArrprentid = $arrparentid.",".$new_parentid;
                        $this->db->update('category',array('arrparentid'=>$tempArrprentid),array('catid'=>$new_parentid));
                        $this->category($data,$temp+1,$new_parentid,$tempArrprentid);
                    }else{
                        echo 'no';die;
                    }
                }
            }

    }

    public function category_child($selfId,$parentid){
        $pre = $this->comm->find('category',array('catid'=>$parentid));
        if($pre){
            $arrchildid = $pre['arrchildid'].",".$selfId;
            $ure = $this->db->update('category',array('arrchildid'=>$arrchildid),array('catid'=>$parentid));

                $this->category_child($parentid,$pre['prentid']);

        }else{
            return;
        }
    }
}