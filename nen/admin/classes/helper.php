<?php
Class Helper {

	private $registry;

	function __construct($registry) {
		$this->registry = $registry;
	}

	function sortparam ($field, $sort, $by="DESC") {
		return ($field == $sort) ?
			(($by == "ASC") ? "icon-arrow-up" : "icon-arrow-down") : 
			'icon-arrow-down';
	}	
	
	function sortdirect ($field, $sort, $by="DESC") {
		return ($field == $sort) ? 
			(($by == "ASC") ? "DESC" : "ASC") : 
			'ASC';
	}

////////////////////////////////////////////////////
// from param to url
///////////////////////////////////////////////////
// $alink = BASEURLFRONT. $url;
	
	function url($params) {

		$controller = $this->getRequestData($params, 'controller', 'index');

		switch ($controller){
			case 'products':
				$url = $this->routeProducts($params);
				break;
			case 'product':
				$url = $this->routeProduct($params);
				break;
			case 'compare':
				$url = $this->routeCompare($params);
				break;				
			case 'contact':
				$url = $this->routeContact($params);
				break;				
			case 'articles':
				$url = $this->routeArticles($params);
				break;	
			case 'ajax':
				$url = $this->routeAjax($params);
				break;
			case 'login':
				$url = $this->routeLogin($params);
				break;		
			case 'analysis':
				$url = $this->routeAnalysis($params);
				break;					
				
		}
		
/////////////////////////////
//////////////////////////// @TODO ме гюашбюрэ лемърэ спк опх оепемняе б HELPER ADMIN
/////////////////////////////
		
		$alink = BASEURLFRONT. $url;
		
		$sepurl = ($url?"/":"")."?";
		
		if ('ajax' == $controller) {
			if (isset($params['cid']) && $params['cid']) {
				$alink .= $sepurl.'cid='.$params['cid'];
				$sepurl = "&";			
			}
		}
	
		
		if (isset($params['list']) && $params['list']) {
			$alink .= $sepurl.'list='.$params['list'];
			$sepurl = "&";			
		}		
		if (isset($params['sort']) && $params['sort']) {
			$alink .= $sepurl.'sort='.$params['sort'];
			$sepurl = "&";			
		}		
		if (isset($params['by']) && $params['by']) {
			$alink .= $sepurl.'by='.$params['by'];
			$sepurl = "&";			
		}
		if (isset($params['lang']) && $params['lang']) {
			$alink .= $sepurl.'lang='.$params['lang'];
			$sepurl = "&";			
		}		

		return $alink;	
	}
	private function getRequestData ($params, $data, $def) {	
		return (isset($params[$data]) && $params[$data]) ? $params[$data] : $def;
	}
	
	private function routeAnalysis ($params) {
	
		$action	= $this->getRequestData($params, 'action', 'index');	
		$slug		= $this->getRequestData($params, 'slug', '');
		$cid		= $this->getRequestData($params, 'cid', '');
		
		$url = 'Rasshifrovka_izmerenij_Tanita';
		if (isset($params['lang']) && 'lv'==$params['lang']) {
			$url = "Tanita_merijumi_atshifrejums";
		} 
		switch ($action){
			case 'chart':
					if ($cid) {
						$url .= '/'.$slug.'-'.$cid;
					}
				break;
		}		
		
		
		return $url;
	}	
	
	private function routeLogin ($params) {
		$url	= 'login';
		$url .= ('sigin'==$params['action'])? "/sigin" : "";
		return $url;
	}	
	
	private function routeProducts ($params) {

		$action	= $this->getRequestData($params, 'action', 'index');	
		$slug		= $this->getRequestData($params, 'slug', '');
		$cid		= $this->getRequestData($params, 'cid', '');

		$url		= 'katalog';
		if (isset($params['lang']) && 'lv'==$params['lang']) {
			$url		= 'katalogs';		
		}		
		
		switch ($action){
			case 'index':
					if ($cid) {
						$url .= '/'.$slug.'-'.$cid;
					}
				break;
		}
	
		return $url;
	}
	
	private function routeProduct ($params) {

		$action	= $this->getRequestData($params, 'action', 'index');	
		$slug		= $this->getRequestData($params, 'slug', '');
		$cid		= $this->getRequestData($params, 'cid', '');
		
		$url		= 'kupit';
		if (isset($params['lang']) && 'lv'==$params['lang']) {
			$url		= 'pirkt';		
		}
		switch ($action){
			case 'view':
					$url .= '/'.$slug.'-'.$cid;			
				break;				
		}
		return $url;
	}	
	
	private function routeCompare ($params) {
	
		$url = 'Sravnenie_modelej_Tanita';
		if (isset($params['lang']) && 'lv'==$params['lang']) {
			$url = "Tanita_modelu_salidzinajums";
		} 
		return $url;
	}

	private function routeContact ($params) {
		$url = 'Gde_kupit_Tanita';
		if (isset($params['lang']) && 'lv'==$params['lang']) {
			$url = "Kur_iegadaties_Tanita";
		} 		
		return $url;		
	}	
	
	private function routeArticles($params) {

		$action	= $this->getRequestData($params, 'action', 'index');	
		$slug		= $this->getRequestData($params, 'slug', '');
		$cid		= $this->getRequestData($params, 'cid', '');
		
		$url = 'Poleznaya_informaciya';
		if (isset($params['lang']) && 'lv'==$params['lang']) {
			$url = "Noderiga_informacija";
		} 	
		
		switch ($action){
			case 'view':
				$url .= '/'.$slug.'-'.$cid;		
				break;				
		}
		return $url;
	}	

	private function routeAjax($params) {

		$action	= $this->getRequestData($params, 'action', 'index');	
		
		$url = 'ajax/'.$action;
	
		return $url;
	}
}
?>