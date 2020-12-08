<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Code here is run before user is granted access to private controllers
class Authentication_Controller extends CI_Controller
{
    public $user;//present the user globally to other controllers
    
    public function __construct()
    {
        parent::__construct();

        if (!$this->_check_login()){
            /**
                check to confirm user current page is in the allowed pages for public access before login
            **/
            if($this->ion_auth->logged_in()){
                /**
                    check if the user is logged in
                **/
                $this->user = $this->ion_auth->get_user();
                $this->session->set_flashdata('success', 'Successfully logged in.');
                redirect('');
            }else{
                $refer = urlencode(($_SERVER['QUERY_STRING']?('?'.$_SERVER['QUERY_STRING']):''));
                $url = site_url('/login?refer='.$refer);
                redirect($url,'refresh');
            }
        }else{
            /***
                User in internal pages and is logged in
            ***/
            if($this->ion_auth->logged_in()){
                $this->user = $this->ion_auth->get_user();
                if($this->user){
                }else{
                    $this->ion_auth->logout();
                    unset($_SESSION);
                }
            }
            
        }
        //initialize the layout to use in the project
        $admin_theme_name = 'users';
        if (!defined('ADMIN_THEME'))
        {
            define('ADMIN_THEME', $admin_theme_name);
        }

        // Prepare Asset library
        $this->asset->set_theme($admin_theme_name);
        //loading the default layout
        $this->template->enable_parser(TRUE)->set_theme($admin_theme_name)->set_layout('default.html');
    }

    function _check_login()
    {
        //listing urls that a user is allowed to access while not logged in
        $uri_string = $this->uri->uri_string();
        $access_exempt = array(
            'login',
            'logout',
            'forgot_password',
            'reset_password',
            'signup',
        );
        foreach ($access_exempt as $key => $value){
            $access = explode('/', $value);
            if(preg_match('/'.$access[0].'/', $uri_string))
            {
                return TRUE;
            }
         }
        if(!$this->ion_auth->logged_in()){      
            return FALSE;
        }
        return TRUE;
    }
 
}