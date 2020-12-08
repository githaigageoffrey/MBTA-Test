<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

function valid_phone($phone=0,$strlen=TRUE,$set_calling_code_prefix=FALSE)
{
	return FALSE;
}

?>