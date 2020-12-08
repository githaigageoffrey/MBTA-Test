<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Code here is run before ajax controllers
class Ajax_Controller extends Authentication_Controller{
    public function __construct(){
        parent::__construct();
        if($this->ion_auth->logged_in()){
            
        }else{
            if($this->_check_login()){
                
            }else{ 
                $response = array(
                    'status' => 200,
                    'refer' => 'authentication',
                    'message' => 'user already logged in',
                );
                echo json_encode($response);die;
            }
        }
    }
}