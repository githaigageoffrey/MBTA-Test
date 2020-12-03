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

	function search_route($from='',$destination=''){
		$st_answer = " No Rail Route";
		$answer = "";
		if($routes = get_routes()){
			$names = array();
			foreach ($routes as $key => $route) {
				$attributes = $route->attributes;
				$arr[] = array(
					'stops' => $attributes->direction_destinations,
					'name'=>$attributes->long_name,
					'type'=>$attributes->type,
				);
			}
		}
		$froms = array();
		$tos = array();
		foreach ($arr as $key => $value) {
			$froms[] = $value['stops'][0];
			$tos[] = $value['stops'][1];
		}
		// $from = "Mattapan";
		// $destination = "Alewife";
		$results = $this->sequential_search($from,$froms,$tos,array(),$destination);
		if($results){
			foreach ($results as $result) {
				$station = $arr[$result];
				//print_r($station);
				if($station['type'] == 1 || $station['type']==0){
					if($answer){
						$answer.=" --> ".$station['name'];
					}else{
						$answer=$station['name'];
					}
				}
			}
		}
		if(!$answer){
			$answer = $st_answer;
		}
		return $answer;
	}

	function sequential_search($from='',$froms = array(),$tos=array(),$results = array(),$destination='',$places=array(),$unique_key=0){
		//$searches =  preg_grep ('/^'.$from.' (\w+)/i', $froms);
		$searches = $this->preg_search_in_array($from,$froms);
		//print_r($searches);die;
		//$places = array();
		$break = FALSE;
		if($searches){
			foreach ($searches as $key => $value) {
				if(!in_array($key, $results)){
					$res = $tos[$key];
					$results[] = $key;
					if(preg_match('/'.$res.'/i', $destination)){
						$break=true;
						break;
					}else{
						$places[$key] = $res;
					}
				}
			}
		}
		if(array_key_exists($unique_key, $places)){
			unset($places[$unique_key]);
		}
		if($places && $break == FALSE){
			foreach ($places as $place_key => $place_name) {
				return $this->sequential_search($place_name,$froms,$tos,$results,$destination,$places,$place_key);
			}
		}else{
			return $results;
		}
	}

	function preg_search_in_array($name="",$data=array()){
		$res = array();
		foreach ($data as $key => $value) {
			if(preg_match('/'.$name.'/i', $value)){
				$res[$key] = $value;
			}
		}
		return $res;
	}
}
?>