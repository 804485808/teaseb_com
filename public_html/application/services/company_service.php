<?php
class Company_service extends MY_Service{
	/**
	 * 获得公司列表
	 * @param $limit  string 数目
	 * @param $condition array() or string
	 * @param $sort string 排序
	 * @param $fields string 字段
	 * @return  @$corps array()   or boolean
	 */
	
	function get_corps($conditions="",$sort="",$limit="0,5"){
		$corplist = array();
		$corplist = $this->comm->findAll('company',$conditions,$sort,"",$limit);
		if ($corplist){
			foreach($corplist as $ck=>$co){
				$cates = $this->comm->findAll("type","userid = {$co['userid']}");
				if($cates){
					foreach ($cates as $k=>$v){
						$findcount = $this->comm->findCount('sell',array('mycatid'=>$v['tid'],"username"=>$co['username']));
						$cates[$k]['num'] = $findcount;
					}
					$corplist[$ck]['cates'] = $cates;
				}
				$findarea = $this->comm->find("area",array("areaid"=>$co['areaid']),"","areaname");
				$corps[] = array_merge($findarea,$corplist[$ck]);
			}
		}else {
			$corps = array();
		}
		return $corps;
	}
	/**
	 * 获得公司产品列表
	 * @param $limit  string 数目
	 * @param $condition array() or string
	 * @param $sort string 排序
	 * @param $fields string 字段
	 * @return  @$corp_pros array()   or boolean
	 */
	function get_corp_pros($conditions="",$sort="",$limit="0,5"){
		if($conditions && $limit){
			$findpros = array();
			$limit = explode(",",$limit);
			$page = intval($limit[0]);
			$per_page = intval($limit[1]);
			$findpros = $this->comm->findAll('sell',$conditions,$sort,"","{$page},{$per_page}");
			if ($findpros){
				foreach($findpros as $fk=>$fo){
					$findcorp = $this->comm->find('company',array("username"=>$fo['username']));
					$findarea = $this->comm->find("area",array("areaid"=>$fo['areaid']),"","areaname");
					$corp_pros[] = array_merge($findcorp,$findarea,$findpros[$fk]);
				}
			}else {
				$corp_pros = array();
			}
		}else {
			show_error("condition param is not exsit");
		}
		return $corp_pros;
	}
	/**
	 * 获得公司类别列表
	 * @param $limit  string 数目
	 * @param $condition array() or string
	 * @return  @$cates array()   or boolean
	 */
	function get_corp_cates($conditions="",$limit="0,20"){
		if ($conditions){
			$cates = $this->comm->findAll("type",$conditions,"","",$limit);
			if($cates){
				foreach ($cates as $k=>$v){
					$finduser = $this->comm->find("member",array("userid"=>$v['userid']),"","username");
					$findcount = $this->comm->findCount('sell',array('mycatid'=>$v['tid'],"username"=>$finduser['username']));
					$cates[$k]['num'] = $findcount;
				}
			}else {
				$cates = array();
			}
		}else {
				show_error("condition param is not exsit");
			}
		return $cates;
	}
	/**
	 * 获得公司详细信息列表
	 * @param $userid 用户名id
	 * @return  @$findcorp array()   or boolean
	 */
	function get_corp_detail($userid = null){
		if ($userid){
			$findcorp = array();
			$findcorp = $this->comm->find("company",array("userid"=>$userid));
			$findarea = $this->comm->find("area",array("areaid"=>$findcorp['areaid']),"","areaname");
			$findcorp['areaname'] = $findarea['areaname'];
			$findcorp_data = $this->comm->find("company_data",array("userid"=>$userid));
			$findcorp['content'] = $findcorp_data['content'];
			
		}else {
			show_error("userid param is not exsit");
		}
		return $findcorp;
	}
	
	
	
	
	
	
}