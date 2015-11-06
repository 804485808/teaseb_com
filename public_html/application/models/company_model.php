<?php
/**
 * 公司model
 * @package sample
 * @subpackage classes
 */
class Company_model extends MY_Model{

    function __construct(){
        parent::__construct();
    }
	
	static $table = "company";
	
	public function getCompany($username){
		$company = $this->find(self::$table,array("username"=>$username));
		if(!$company){
			return false;
		}
		$companyType = $this->findAll("type",array("userid"=>$company['userid']));
		$company['companySell'] = '';
		if($companyType){
			$companySell = array();
			foreach($companyType as $v){
				if(stripos($v['tname'],'Ungrouped')===false){
					$companySell[] = $v['tname'];
				}
				
			}
			$companySell = implode(",",$companySell);
			$company['companySell'] = $companySell;
        }
		$country = file_get_contents('./skin/country.txt');
		$country = str_replace(array("\r\n","\r"),"\n",$country);
        $AllCountry = explode("\n",$country);
        shuffle($AllCountry);
        $company['markets']=$AllCountry[0].",".$AllCountry[1].",".$AllCountry[2];
		
		return $company;
	}
}