<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sell_model extends MY_Model{
	function __construct()
	{
		parent::__construct();
	}

    public $mainTable = 'wl_sell';

    /**
     * 创建 主表匹配数组
     * @return array|bool
     */
    public function creatData($data){
        return $this->createDateCommon($data,$this->mainTable);
    }
	
	/**
	 * 查看一条供应记录
	 * @param $itemid  int sell表id
	 * @return  array  | FALSE
	 */
	 public function get_one_sell($itemid){
		$this->db->select("sell.*,userid,mode,areaname,content,business,regyear,icp")->from('sell')->where('sell.itemid',$itemid);
		$this->db->join('company','sell.username = company.username','left');
		$this->db->join('area','company.areaid = area.areaid','left');
		$this->db->join('sell_data','sell.itemid = sell_data.itemid','left');
		$query=$this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}else {
			return FALSE;
		}
	} 
	

	
	/**
	 * 获得满足条件的供应商的type信息
	 * @param int $userid
	 * @param string $order
	 * @param int $limit
	 * @param int $offset
	 * @return boolean | array
	 */
	public function get_sell_types($userid,$order,$limit,$offset){
		$this->db->order_by($order,"desc");
		$this->db->select("tid,tname,listorder")->where('userid',$userid);
		$query=$this->db->get('type',$limit,$offset);
		if($query->num_rows()>0){
			return $query->result_array();
		}else {
			return FALSE;
		}
	}
	
	
	/**
	 * 获得满足条件的产品--随机查询
	 * @param int $itemid
	 * @param int $catid
	 * @param int $limit
	 * @return boolean  | array
	 */
	public function get_sells_cate($itemid,$catid,$limit){		
		$sql="SELECT t1.itemid,t1.title,t1.thumb,t1.linkurl";
		$sql.=" FROM `wl_sell` AS t1 JOIN (SELECT ROUND(RAND() * ((SELECT MAX(itemid) FROM `wl_sell`)-(SELECT MIN(itemid) FROM `wl_sell`))+(SELECT MIN(itemid) FROM `wl_sell`)) AS itemid) AS t2";
		$sql.=" WHERE t1.itemid >= t2.itemid and t1.catid = {$catid} and t1.itemid <> {$itemid}";
		$sql.=" ORDER BY t1.itemid LIMIT {$limit}";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result_array();
		}else {
			return FALSE;
		}
	}

    /**
     * 获得满足条件的产品--随机查询
     * @param int $itemid
     * @param int $catid
     * @param int $limit
     * @return boolean  | array
     */
    public function get_sells_cates($limit){
        $sql="SELECT t1.username,t1.subtitle,t1.itemid,t1.title,t1.thumb,t1.linkurl";
        $sql.=" FROM `wl_sell` AS t1 JOIN (SELECT ROUND(RAND() * ((SELECT MAX(itemid) FROM `wl_sell`)-(SELECT MIN(itemid) FROM `wl_sell`))+(SELECT MIN(itemid) FROM `wl_sell`)) AS itemid) AS t2";
        $sql.=" WHERE t1.itemid >= t2.itemid";
        $sql.=" ORDER BY t1.itemid LIMIT {$limit}";
        $query=$this->db->query($sql);
        if($query->num_rows()>0){
            return $query->result_array();
        }else {
            return FALSE;
        }
    }
	
	
	/**
	 * 获得前几个热门产品
	 * @param string $order
	 * @param int $limit
	 * @return boolean  | array
	 */
	public function get_hot_products($order,$limit){
		$this->db->order_by($order,"desc")->select("itemid,title,unit,minprice,currency,minamount,hits,thumb,linkurl");
		$query=$this->db->get('sell',$limit);
		if($query->num_rows()>0){
			return $query->result_array();
		}else {
			return FALSE;
		}
	}
	
	
	/**
	 * 获得某个条件下的信息列表
	 * @param int $catid
	 * @param int $limit
	 * @param string $table
	 * @param string $order
	 * @return boolean  | array
	 */
	public function get_sell_newest($catid = null,$order = null,$limit = null){
		if(!empty($catid)){
			$newestlist = $this->findAll("sell",array("catid"=>$catid),$order,'catid,itemid,title,edittime,adddate,linkurl,company',$limit);
			return $newestlist;
		}else {
			$newestlist = $this->findAll("sell",'',$order,'catid,itemid,title,edittime,adddate,linkurl,company',$limit);
			return $newestlist;
		}
	
	}
	
	
	/**
	 * 查看供销商其他的产品
	 * @param int $itemid
	 * @return array | boolean
	 */
	public function get_other_products($itemid)
	{
		$findsell = $this->find("sell",array("itemid"=>$itemid));
		if($findsell){
			$comlist = $this->findAll("sell",array("username"=>$findsell['username']),'hits desc','','0,6');
			return $comlist;
		}else {
			return FALSE;
		}
	
	}
	

	/**
	 * 查看相关产品
	 * @param array $itemid
	 * @return array | boolean
	 */
	public function get_recommend_pro($itemid)
	{
		$getids = implode(",",$itemid);
		$prolist = $this->findAll("sell","itemid in({$getids})");
		if($prolist){
			$sell_data = $this->findAll("sell_data","itemid in({$getids})");
			foreach($sell_data as $k => $v){
				$prolist[$k]['sell_content'] = $v['content'];
			}
			return $prolist;
		}else{
			return FALSE;
		}
		
	}


    /**
     * 查询sell公共方法
     * @param string $files  查询字段
     * @param string $where  条件
     * @param string $limit  limit
     * @param string $order  排序
     * @param int    $type   1：返回一条一维数据 0:默认返回二维数组
     * @return array 查询结果
     */
    public function getSellCommon($files='*',$where='',$group = "",$order='',$limit='',$type=0){
        $sql = "SELECT ".$files;
        $sql .= " FROM ".$this->mainTable;
        if($where){
            $sql .= " WHERE ".$where;
        }

        if ($group) {
            $sql .= " GROUP BY " . $group;
        }

        if($order){
            $sql .= " ORDER BY ".$order;
        }

        if($limit){
            $sql .= " LIMIT ".$limit;
        }

        $query = $this->db->query($sql);

        if ($query->num_rows > 0) {
            if (!$type) {
                return $query->result_array();
            } else {
                return $query->row_array();
            }
        } else {
            return array();
        }

    }


    /**
     * 连表查询 公共方法
     * @param string $files    查询字段
     * @param array $manTable  主表 array('表名'=>'别名')
     * @param array $link      关联表 array('$_link'=>'别名')
     * @param string $where    查询条件
     * @param string $order    排序
     * @param string $limit    limit
     * @param int $type        1：返回一条一维数据 0:默认返回二维数组
     * @return array
     */
    public function getSellCommonLink($files='*',$manTable,$link,$where='',$order='',$group = "",$limit='',$type=0){

        $manTableName = key($manTable);
        $manTableAlse = $manTable[$manTableName];
        $sql = "SELECT ".$files;
        $sql .= " FROM ".$manTableName." AS ".$manTableAlse;

        if($link){
            while($key = key($link)){
                $sql .= " LEFT JOIN ".$this->_link[$key]['table']." AS ".$link[$key]." ON ".$link[$key].".".$this->_link[$key]['otherKey']." = ".$manTableAlse.".".$this->_link[$key]['selfKey'];
                next($link);
            }
        }

        if($where){
            $sql .= " WHERE ".$where;
        }

        if($order){
            $sql .= " ORDER BY ".$order;
        }
        if ($group) {
            $sql .= " GROUP BY " . $group;
        }

        if($limit){
            $sql .= " LIMIT ".$limit;
        }

        $query = $this->db->query($sql);

        if($query->num_rows>0){
            if(!$type){
                return $query->result_array();
            }else{
                return $query->row_array();
            }
        }else{
            return array();
        }

    }

    /**
     * 关联表
     * @var array
     */
    protected $_link = array(
        'Area'=>array(
            'table'=>'wl_area',
            'selfKey'=>'areaid',
            'otherKey'=>'areaid'
        ),
        'Category'=>array(
            'table'=>'wl_category',
            'selfKey'=>'catid',
            'otherKey'=>'catid'
        ),
        'Company'=>array(
            'table'=>'wl_company',
            'selfKey'=>'username',
            'otherKey'=>'username'
        ),
        'Type'=>array(
            'table'=>'wl_type',
            'selfKey'=>'mycatid',
            'otherKey'=>'tid'
        )
    );

    /**
     * 查询最新产品
     * @param $limit  limit
     * @return array
     */
    public function getLatestProducts($limit){
//        $selllist = $this->getSellCommonLink('t1.username,t1.company,t1.subtitle,t1.itemid,t1.linkurl,t1.thumb,t1.title,t1.minamount,t1.unit,t1.minprice,t1.currency,t1.pptword,t2.areaname',array('wl_sell'=>'t1'),array('Area'=>'t2'),'t1.status=3',
//            ' addtime desc','',$limit);
        $selllist = $this->SelectCommon('t1.username,t1.company,t1.subtitle,t1.title,t1.itemid,t1.linkurl,t1.thumb,t1.title,t1.minamount,t1.unit,t1.minprice,t1.currency,t1.pptword,t2.areaname',
            array('Area'=>'left'),'',array('t1.status'=>'3'),array('addtime'=>'desc'),$limit,'');
        return $selllist;

    }

    public  $_link1 = array(
        'Area'=>array(
            'selfKey'=>'areaid',
            'linkKey'=>'areaid'
        ),
        'Company'=>array(
            'selfKey'=>'username',
            'linkKey'=>'username'
        ),
        'Category'=>array(
            'selfKey'=>'catid',
            'linkKey'=>'catid'
        ),
        'Type'=>array(
            'selfKey'=>'mycatid',
            'linkKey'=>'tid'
        )
    );
    public  $_table = 'sell';




    /**
     * 获取最热门商品
     * @param $limit  limit
     * @return array
     */
    public function getHotProducts($limit){
//        $hotProducts = $this->getSellCommonLink('t1.username,t1.company,t1.itemid,t1.linkurl,t1.thumb,t1.title,t1.minamount,t1.unit,t1.minprice,t1.currency,t1.pptword,t2.areaname',array('wl_sell'=>'t1'),array('Area'=>'t2'),'t1.status=3',
//            'hits desc','',$limit);
        $hotProducts = $this->SelectCommon('t1.username,t1.company,t1.itemid,t1.linkurl,t1.thumb,t1.title,t1.minamount,t1.unit,t1.minprice,t1.currency,t1.pptword,t2.areaname',
            array('Area'=>'left'),'',array('t1.status'=>'3'),array('t1.hits'=>'desc'),$limit);
        return $hotProducts;

    }

    //国家产品
    public function getSellCountry($catid,$limit)
    {
        $sql="SELECT t1.areaname name,count(t1.areaname) num
             FROM wl_area as t1 LEFT JOIN `wl_sell` t2
             ON t1.areaid = t2.areaid
             WHERE t2.catid ={$catid} GROUP BY t1.areaname  ORDER BY num DESC LIMIT {$limit}";
        $query=$this->db->query($sql);
        if($query->num_rows()>0){
            return $query->result_array();
        }else {
            return FALSE;
        }
    }

    /**
     * 商品热度+1
     * @param $itemid
     */
    public function addSellHits($itemid){
        $this->db->set("hits","hits+1",FALSE);
        $this->db->where("itemid",$itemid);
        $this->db->update("sell");
    }

    /**
     * 获取商品相关信息
     * @param $itemid
     * @return array
     */
    public function getSellCompany($itemid,$country){

//        $re = $this->getSellCommonLink('t1.payment,t1.port,t1.itemid,t1.subtitle,t1.title,t1.thumb,t1.keyword,t1.linkurl,t1.unit,t1.minprice,t1.maxprice,t1.currency,t1.username,t1.company,
//        t1.minamount,t1.pptword,t2.userid,t2.markets,t2.business,t2.mode,t2.telephone',array('wl_sell'=>'t1'),array('Company'=>'t2'),"t1.itemid={$itemid}",'','','',1);

        $re = $this->SelectCommon('t1.payment,t1.port,t1.itemid,t1.subtitle,t1.title,t1.thumb,t1.keyword,t1.linkurl,t1.unit,t1.minprice,t1.maxprice,t1.currency,t1.username,t1.company,
        t1.minamount,t1.pptword,t2.userid,t2.markets,t2.business,t2.mode,t2.telephone',array('Company'=>'left'),'',array('t1.itemid'=>$itemid),'','',1);

        $username = $re['username'];

        //rand area
        $country = str_replace(array("\r\n","\r"),"\n",$country);
        $AllCountry = explode("\n",$country);
        //$AllCountry = preg_split('/\r\n/',$country);
        shuffle($AllCountry);

        $re['markets']=$AllCountry[0].",".$AllCountry[1].",".$AllCountry[2];
        $hotProduct = $this->getCompanyHotSell($username);

        $re['hotProduct'] = $hotProduct;
        if($re) {
            $userid = $re['userid'];

            $this->db->select('tname');
            $this->db->where(array('userid' => $userid));
            $query = $this->db->get('type');
            $res = $query->result_array();
            if($res){
                $companySell = '';
                foreach($res as $k=>$v){
                    $companySell .= $v['tname'].",";
                }
                $re['companySell'] = $companySell;

            }
        }


        $attr = array();
        $pptword = $re['pptword'];



        if($pptword){

            $this->benchmark->mark('c');
            $this->load->model('category_option_model','category_option');
            $attr = $this->category_option->getSellOption($pptword,$itemid);

            $attr1 = array();
            foreach($attr as $k=>$v){
                //Phase

                if(!$attr1['Phase']){
                    $attr1['Phase'] = empty($attr1['Phase'])?strstr($v['name'],'hase')?$v['value']:'':$attr1['Phase'];
                }
                //Frequency

                if(!$attr1['Frequency']){
                    $attr1['Frequency'] = empty($attr1['Frequency'])?strstr($v['name'],'requency')?$v['value']:'':$attr1['Frequency'];
                }
                //Payment terms

                if(!$attr1['Payment Terms']){
                    $attr1['Payment Terms'] = empty($attr1['Payment Terms'])?strstr($v['name'],'Payment')?$v['value']:'':$attr1['Payment Terms'];
                }

                //Port

                if(!$attr1['Output Power']){
                    $attr1['Output Power'] = empty($attr1['Output Power'])?strstr($v['name'],'ower')?$v['value']:'':$attr1['Output Power'];
                }

                //Usage

                if(!$attr1['Usage']){
                    $attr1['Usage'] = empty($attr1['Usage'])?strstr($v['name'],'sage')?$v['value']:'':$attr1['Usage'];
                }

                //Voltage

                if(!$attr1['Voltage']){
                    $attr1['Voltage'] = empty($attr1['Voltage'])?strstr($v['name'],'oltage')?$v['value']:'':$attr1['Voltage'];
                }

                //Speed

                if(!$attr1['Speed']){
                    $attr1['Speed'] = empty($attr1['Speed'])?strstr($v['name'],'speed')?$v['value']:'':$attr1['Speed'];
                }

                $attr1[$v['name']] = $v['value'];
                //other

            }



          $re['attr'] = $attr1;
        }

        return $re;
    }



    public function  getHotProductPrice($limit){
        $query = $this->db->query('SELECT t1.title,t1.subtitle,t1.linkurl,t1.thumb,t1.username,t1.minprice,t1.currency,t1.pptword,t1.itemid
                          FROM `wl_sell` AS t1
                          JOIN (SELECT ROUND(RAND() * ((SELECT MAX(itemid) FROM `wl_sell`)-(SELECT MIN(itemid) FROM `wl_sell`))+(SELECT MIN(itemid) FROM `wl_sell`)) AS id) AS t2
                          WHERE t1.itemid >= t2.id and t1.pptword is not NULL LIMIT 0,50');
        $temp =  $query->result_array();
        $this->load->model('category_option_model','category_option');
        foreach($temp as $k=>$v){
            $rattr = $this->category_option->getSellOption($v['pptword'],$v['itemid']);
            $attr1 = array();
            foreach($rattr as $vv){
                //Voltage
                if(!$attr1['Voltage']){
                    $Voltage = empty($attr1['Voltage'])?strstr($vv['name'],'oltage')?$vv['value']:'':$attr1['Voltage'];
                    $attr1['Voltage'] = $Voltage;
                }
                //Power
                if(!$attr1['Power']){
                    $Power= empty($attr1['Power'])?strstr($vv['name'],'ower')?$vv['value']:'':$attr1['Power'];
                    $attr1['Power'] = $Power;
                }
            }
            $temp[$k]['attr'] = $attr1;
        }
        $temp_one = array();
        $i=0;
        foreach($temp as $k =>$v)
        {
            if($i < $limit)
            {
                if(!empty($v['attr']['Voltage']) && !empty($v['attr']['Power']))
                {
                    ++$i;
                    $temp_one[] = $v;
                }
            }
        }
        $num = count($temp_one);
        $temp_num = count($temp);
        if($num<4)
        {
             for($num;$num<4;$num++)
             {
                 $temp_one[$num] = $temp[--$temp_num];
             }
        }
       return $temp_one;
    }

    /**
     * 获取供应商下的热门商品
     * @param $username
     * @return array
     */
    public function getCompanyHotSell($username){
//        $re = $this->getSellCommon('itemid,thumb,linkurl,username,title',"username='{$username}'",'','hits desc','0,4');
        $re = $this->SelectCommon('itemid,thumb,linkurl,username,title','','',array('username'=>$username),array('hits'=>'desc'),'0,4');
        return $re;
    }

    /**
     * subtitle
     * @param $limit
     */
    public function changeTitle($limit){
//        $re = $this->getSellCommonLink('t1.itemid,t1.pptword,t1.catid,t1.mycatid,t2.tname,t3.arrparentid,t3.parentid,t3.catname',array('wl_sell'=>'t1'),array('Type'=>'t2','Category'=>'t3'),'','t1.itemid asc','',$limit);
        $re = $this->SelectCommon('t1.itemid,t1.pptword,t1.catid,t1.mycatid,t2.tname,t3.arrparentid,t3.parentid,t3.catname',array('Type'=>'left','Category'=>'left'),'','',array('t1.itemid'=>'asc'),$limit);
        $this->load->model('category_model','category');
        $this->load->model('category_option_model','category_option');

        foreach($re as $k=>$v){

            //一级分类
            if($v['arrparentid']=='0'){
                $catname = $v['catname'];
            }else{
                $pre =  explode(',',$v['arrparentid']);
                $pid = $pre[1];
                if(!$pid){
                   $pid = 1;
                }
                $ppre = $this->category->getCategoryCommon('catname',"catid={$pid}",'','',1);
                $catname = $ppre['catname'];

            }
            $attr1 = array();
            //获取属性
            if($v['pptword']) {

                $atr = $this->category_option->getSellOption($v['pptword'], $v['itemid']);


                foreach ($atr as $kk => $vv) {
                    $attrTitle = '';
                    //Voltage
                    if (!$attr1['Voltage']) {
                        $attr1['Voltage'] = empty($attr1['Voltage']) ? strstr($vv['name'], 'oltage') ? $vv['value'] : '' : $attr1['Voltage'];
                    }

                    //Power
                    if (!$attr1['Power']) {
                        $attr1['Power'] = empty($attr1['Power']) ? strstr($vv['name'], 'ower') ? $vv['value'] : '' : $attr1['Power'];
                    }

                    //Speed
                    if (!$attr1['Speed']) {
                        $attr1['Speed'] = empty($attr1['Speed']) ? strstr($vv['name'], 'peed') ? $vv['value'] : '' : $attr1['Speed'];
                    }

                    //Usage
                    if (!$attr1['Usage']) {
                        $attr1['Usage'] = empty($attr1['Usage']) ? strstr($vv['name'], 'sage') ? $vv['value'] : '' : $attr1['Usage'];
                    }

                }
                $usage = $attr1['Usage'];
                unset($attr1['Usage']);
            }

            foreach($attr1 as $av){
                $attrTitle .= $av." ";
            }

            if($v['tname']){
                $attrTitle.="".$v['tname']." (".$catname.") ";
            }else{
                $attrTitle .=" ".$catname." ";
            }

            if($usage){
                $attrTitle .= "for ".$usage."";
            }

            $this->db->where('itemid',$v['itemid']);
            $this->db->update('wl_sell',array('subtitle'=>$attrTitle));

        }

    }


    /**
     * 获取userid
     * @param $limit
     */
    public function getUserId($limit){
//        $re = $this->getSellCommonLink('t1.itemid,t1.username,t2.userid',array('wl_sell'=>'t1'),array('Company'=>'t2'),'','t1.itemid asc','',$limit);
        $re = $this->SelectCommon('t1.itemid,t1.username,t2.userid',array('Company'=>'left'),'','',array('t1.itemid'=>'asc'),$limit);
        foreach($re as $k=>$v){
            if($v['userid']) {
                $this->db->where('itemid', $v['itemid']);
                $this->db->update('wl_sell', array('userid' => $v['userid']));
            }
        }
    }


    //产品首页价格
    public function  getHotCategoryPrice($cat_list,$limit){
        $temp = $this->SelectCommon('itemid,title,username,linkurl,pptword,currency,minprice','','',array('catid in'=>$cat_list,'status'=>3,'minprice !='=>'0.00'),array('hits'=>'desc'),"0,20");
        $this->load->model('category_option_model','category_option');
        foreach($temp as $k=>$v){
			if(empty($v['pptword'])){
				$v['pptword']=0;
			}
            $rattr = $this->category_option->getSellOption($v['pptword'],$v['itemid']);

            $attr1 = array();
            foreach($rattr as $vv){
                //Voltage
                if(!$attr1['Voltage']){
                    $attr1['Voltage'] = empty($attr1['Voltage'])?strstr($vv['name'],'oltage')?$vv['value']:'':$attr1['Voltage'];
                }
                //Power
                if(!$attr1['Power']){
                    $attr1['Power'] = empty($attr1['Power'])?strstr($vv['name'],'ower')?$vv['value']:'':$attr1['Power'];
                }
            }
            $temp[$k]['attr'] = $attr1;
        }
        $temp_one = array();
        $i=0;
        foreach($temp as $k =>$v)
        {
            if($i < $limit)
            {
                if(!empty($v['attr']['Voltage']) && !empty($v['attr']['Power']))
                {
                    ++$i;
                    $temp_one[$k] = $v;
                }
            }
        }
        $num = count($temp_one);
        $temp_num = count($temp);
        if($num<4)
        {
            for($num;$num<4;$num++)
            {
                $temp_one[$num] = $temp[--$temp_num];
            }
        }
        return $temp_one;
    }

    //获取随机商品价格
    public function getRandSell(){

        $query = $this->db->query('SELECT t1.title,t1.subtitle,t1.linkurl,t1.thumb,t1.username,t1.minprice,t1.currency,t1.pptword,t1.itemid
                          FROM `wl_sell` AS t1
                          JOIN (SELECT ROUND(RAND() * ((SELECT MAX(itemid) FROM `wl_sell`)-(SELECT MIN(itemid) FROM `wl_sell`))+(SELECT MIN(itemid) FROM `wl_sell`)) AS id) AS t2
                          WHERE t1.itemid >= t2.id and t1.pptword is not NULL LIMIT 0,50');
        $re =  $query->result_array();

        $this->load->model('category_option_model','category_option');
        $res = array();
        foreach($re as $k=>$v) {
            if ($v['pptword']) {
                $rattr = $this->category_option->getSellOption($v['pptword'], $v['itemid']);
                $attr1 = array();
                foreach ($rattr as $vv) {
                    //Voltage
                    if (!$attr1['Voltage']) {
                        $attr1['Voltage'] = empty($attr1['Voltage']) ? strstr($vv['name'], 'oltage') ? $vv['value'] : '' : $attr1['Voltage'];
                    }
                    //Power
                    if (!$attr1['Power']) {
                        $attr1['Power'] = empty($attr1['Power']) ? strstr($vv['name'], 'ower') ? $vv['value'] : '' : $attr1['Power'];
                    }
                }

                if ($attr1['Voltage'] && $attr1['Power']) {
                    $re[$k]['attr'] = $attr1;
                    $re[$k]['price'] = $v['minprice'] > 0 ? $v['currency'] . " " . $v['minprice'] : "Negoti..";
                    $res[] = $re[$k];
                }
            }
        }
        return $res;
    }


}
