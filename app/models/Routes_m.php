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
		$count = array(
			'count' => array(
				0 => count($arr[0]).' - '.(count($arr[0])>count($arr[1])?"Most":"Least"),
				1 => count($arr[1]).' - '.(count($arr[1])>count($arr[0])?"Most":"Least"),
			),
		);
		$arr = $arr+$count;
		return ($arr);
	}

	function route_combination(){
		$arr = array();
		if($routes = get_routes()){
			foreach ($routes as $key => $route) {
				$attributes = $route->attributes;
				if($attributes->type == 1){
					$arr[$attributes->type]["from"][] = str_replace("/", " ",$attributes->direction_destinations[0]);
					$arr[$attributes->type]["to"][] = str_replace("/", " ",$attributes->direction_destinations[1]);
				}else if($attributes->type == 0){
					$arr[$attributes->type]["from"][] = str_replace("/", " ",$attributes->direction_destinations[0]);
					$arr[$attributes->type]["to"][] = str_replace("/", " ",$attributes->direction_destinations[1]);
				}
			}
		}
		$connection1 = array();
		$connection2 = array();
		$rail0 = $arr[0];
		$rail1 = $arr[1];
		foreach ($rail0["to"] as $key => $value) {
			$matches  = preg_grep ('/^'.$value.' (\w+)/i', $rail1["from"]);
			if($matches){
				$connections1[] = array(
					"from" => $rail0["from"][$key],
					"via1" => "0",
					"stop" => $matches[0],
					"via2" => "1",
					"to" => $rail1["to"][array_search($matches[0],$rail1["from"],true)],
				);
			}
		}
		foreach ($rail1["to"] as $key => $value) {
			$matches  = preg_grep ('/^'.$value.' (\w+)/i', $rail0["from"]);
			if($matches){
				$connection2[] = array(
					"from" => $rail1["from"][$key],
					"via1" => "1",
					"stop" => $matches[0],
					"via2" => "0",
					"to" => $rail0["to"][array_search($matches[0],$rail1["from"],true)],
				);
			}
		}
		return $connections1+$connection2;
	}

	function search_route($from='',$to=''){
		if($routes = get_routes()){
			foreach ($routes as $key => $route) {
				$attributes = $route->attributes;
				if($attributes->type == 1){
					$arr[$attributes->type]["from"][] = str_replace("/", " ",$attributes->direction_destinations[0]);
					$arr[$attributes->type]["to"][] = str_replace("/", " ",$attributes->direction_destinations[1]);
				}else if($attributes->type == 0){
					$arr[$attributes->type]["from"][] = str_replace("/", " ",$attributes->direction_destinations[0]);
					$arr[$attributes->type]["to"][] = str_replace("/", " ",$attributes->direction_destinations[1]);
				}
			}
		}
		$rail0 = $arr[0];
		$rail1 = $arr[1];
		echo $from.' ';
		print_r($rail1["from"]);
		$ans = array_search($from, $rail0["from"]);
		if($ans){
			echo $ans;
		}else{
			if($ans = array_search($from, $rail1["from"])){
				echo $ans;
			}else{
				echo "miss";
			}
		}

		die;
	}
}
?>