<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Curl{
	protected $ci;

	public function __construct(){
		$this->ci= & get_instance();

	}

	function post($post_data=array,$url=""){
		if(is_array($post_data) && !empty($post_data) && $url){

		}else{
			$this->ci->session->set_flashdata('error',"Bad Request. Some data fields are missing");
			return FALSE;
		}
	}

	function get(){

	}

}?>