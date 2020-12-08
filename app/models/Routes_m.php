<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Routes_m extends CI_Model
{

	function __construct()
	{
		parent::__construct();

	}
	/*
	*	Fetch routes from the server via curl
	*/
	function fetch_routes()
	{
		$this->curl->fetch_routes();
	}

	/*
	*	Get all the saved routes
	*	Get subway routes 0 and 1
	*/
	function get_all_routes()
	{
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

	/*
	*	Get the routes and the stops
	*/

	function get_routes_and_stops()
	{
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
		$count = $this->get_stop_counts($arr);
		$arr = $arr+$count;
		return ($arr);
	}

	/*
	*	Count the number stops and determine which subway has more stops
	*/

	function get_stop_counts($arr='')
	{
		if(is_array($arr)){
			return array(
				'count' => array(
					0 => count($arr[0]).' - '.(count($arr[0])>count($arr[1])?"Most":"Least"),
					1 => count($arr[1]).' - '.(count($arr[1])>count($arr[0])?"Most":"Least"),
				),
			);
		}
	}

	/*
	* Get the combination from routes and check if the combination is found in the next subway
	*/
	function get_connection($rail0,$rail1)
	{
		$connection = array();
		foreach ($rail0["to"] as $key => $value) {
			$matches  = preg_grep ('/^'.$value.' (\w+)/i', $rail1["from"]);
			if($matches){
				$connection[] = array(
					"from" => $rail0["from"][$key],
					"via1" => "0",
					"stop" => $matches[0],
					"via2" => "1",
					"to" => $rail1["to"][array_search($matches[0],$rail1["from"],true)],
				);
			}
		}
		return $connection;
	}


	function route_combination()
	{
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
		$rail0 = $arr[0];$rail1 = $arr[1];
		$connection1 = $this->get_connection($arr[0], $arr[1]);
		$connection2 = $this->get_connection($arr[1],$arr[0]);
		return $connection1+$connection2;
	}

	/*
	*	Create a left branch and a right branch
	*	From the tree, move through each town to see which other town is connected to that town.
	* 	Get a loop - list to show all the towns with connection
	*	From the connection, get the towns with a subway route
	*/
	function search_route($from='',$destination='')
	{
		$st_answer = " No Rail Route";
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
		$froms = array();$tos = array();
		foreach ($arr as $key => $value) {
			$froms[] = $value['stops'][0];
			$tos[] = $value['stops'][1];
		}
		$answer = $this->get_route_combination($from,$froms,$tos,$arr,$destination);
		if(!$answer){
			$answer = $st_answer;
		}
		return $from.' to '.$destination.' --> '.$answer;
	}

	function get_route_combination($from='',$froms=array(),$tos=array(),$places=array(),$destination='')
	{
		$results = $this->sequential_search($from,$froms,$tos,array(),$destination);
		$answer = '';
		if($results){
			foreach ($results as $result) {
				$station = $places[$result];
				if($station['type'] == 1 || $station['type']==0){
					if($answer){
						$answer.=" , ".$station['name'];
					}else{
						$answer=$station['name'];
					}
				}
			}
		}
		return $answer;
	}


	/*
	* Loop through the tree combining from and to and carrying forward the connected town
	*
	*/
	function sequential_search($from='',$froms = array(),$tos=array(),$results = array(),$destination='',$places=array(),$unique_key=0)
	{
		$searches = $this->preg_search_in_array($from,$froms);
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

	/*
	*	Modified but slower function to regex search in an array
	*/

	function preg_search_in_array($name="",$data=array())
	{
		$res = array();
		foreach ($data as $key => $value) {
			if(preg_match('/'.$name.'/i', $value)){
				$res[$key] = $value;
			}
		}
		return $res;
	}
}