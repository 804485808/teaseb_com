<?php
class Url_service extends MY_Service{
	function curPageURL(){
		if(strstr($_SERVER['REQUEST_URI'],".html")){
			return False;
		}
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on"){
			$pageURL .= "s";
		}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80"){
			$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
		}else{
			$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		}
		if(eregi("\/$", $pageURL)){
			$pageURL=substr($pageURL,0,-1);
		}
		$pageURL.=".html";
		return strtr($pageURL,array("/index.php"=>""));
	}
}