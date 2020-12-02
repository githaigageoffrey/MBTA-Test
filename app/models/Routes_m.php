<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Routes_m extends CI_Model{

	function __construct(){
		parent::__construct();

	}

	function fetch_routes(){
		$this->curl->fetch_routes();
	}

	function get_all_routes(){
		$arr = array();
		if($routes = get_routes()){
			foreach ($routes as $key => $route) {
				$attributes = $route->attributes;
				if($attributes->type == 1 || $attributes->type == 0){
					$arr[] = array(
						'name'=>$attributes->long_name,
						'type'=>$attributes->type,
					);
				}
			}
		}
		return $arr;
	}

	function get_routes_and_stops(){
		$arr = array();
		if($routes = get_routes()){
			foreach ($routes as $key => $route) {
				$attributes = $route->attributes;
				if($attributes->type == 1){
					$arr[$attributes->type][] = $attributes->direction_destinations;
				}else if($attributes->type == 0){
					$arr[$attributes->type][] = $attributes->direction_destinations;
				}
			}
		}
		//print_r($arr[0]);
		$count = array(
			'count' => array(
				0 => count($arr[0]).' - '.(count($arr[0])>count($arr[1])?"Most":"Least"),
				1 => count($arr[1]).' - '.(count($arr[1])>count($arr[0])?"Most":"Least"),
			),
		);
		$arr = $arr+$count;
		//print_r($arr);die;
		return ($arr);
	}
}
?>