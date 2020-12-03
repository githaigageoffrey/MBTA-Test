<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Curl{
	protected $ci;

	public function __construct(){
		$this->ci= & get_instance();
	}

	function fetch_routes(){
		$url = $this->ci->config->item('api_url').$this->ci->config->item('route_url');
		$modified_on = modification_date()?:0;
		if($modified_on){
			$modified_on =date('D, d M Y H:i:s',$modified_on).' GMT';
		}
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    'Accept-Encoding: application/gzip',
		    'x-api-key: '.$this->ci->config->item('api_key'),
		    'If-Modified-Since:'.$modified_on,
		  ),
		));
		$response = curl_exec($curl);
		$header_info = curl_getinfo($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if($err){
			echo "Curl Error : Curl #".$err;
		}else{
			if($header_info['http_code'] == 200){
				if(save_routes($response)){
					return $response;
				}else{
					echo "Error occured getting routes. Try again later";
				}
			}else if($header_info['http_code'] == 304){
				return TRUE;
			}else{
				echo "Curl Http Error Code : Code #".$header_info['http_code'];
			}
		}
	}

	function get(){

	}

}?>