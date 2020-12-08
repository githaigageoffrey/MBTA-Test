<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
	After receiving the json file from the server
	this function saves them locally in a txt file (file extension can change)
	The first step before saving it to remove any existing of the same type/name
	modify the JSON to add date modified and created
	Modified date used to track if the document has changed
**/
function save_routes($routes ="")
{
    if($routes){
    	if(!is_dir("./logs/")){
    		mkdir("./logs/",0777,TRUE);
    	}
        $file = "./logs/route-file.txt";
        if(is_file($file)){
        	if(!unlink($file)){
	        	return;
	        }
        }
        $modification = array(
        	'modified_on' => time(),
        	'created_on' => time(),
        );
        $routes = json_decode($routes,TRUE);
        $json_data = json_encode(array_merge($modification,$routes));
        file_put_contents($file,$json_data."\n",FILE_APPEND);
        return TRUE;
    }else{
        return FALSE;
    }
}

/***
	Get the saved routes
***/

function get_routes()
{
	if(is_file("./logs/route-file.txt")){
		$data = file_get_contents("./logs/route-file.txt");
		if($data){
			$res = json_decode($data);
			if($res){
				return $res->data;
			}
		}
	}else{
		return FALSE;
	}
}

/***
	Get the saved modification date
***/
function modification_date()
{
	if(is_file("./logs/route-file.txt")){
		$data = file_get_contents("./logs/route-file.txt");
		if($data){
			$res = json_decode($data);
			if($res){
				return $res->modified_on;
			}
		}
	}else{
		return FALSE;
	}
}

/***
	Not currently in use but will be used to check if an entered phone number is valid or not
***/
function valid_phone($phone=0,$strlen=TRUE,$set_calling_code_prefix=FALSE)
{
	return FALSE;
}