<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Code here is run before admin controllers
class Authentication_Controller extends CI_Controller
{
    public $user;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        if (!$this->_check_login()){
            if($this->ion_auth->logged_in()){
                $this->user = $this->ion_auth->get_user();
                $this->session->set_flashdata('success', 'Successfully logged in.');
                redirect('');
            }else{
                $refer = urlencode(($_SERVER['QUERY_STRING']?('?'.$_SERVER['QUERY_STRING']):''));
                // $url = site_url('/login?refer='.$refer);
                // redirect($url,'refresh');
            }
        }else{
            if($this->ion_auth->logged_in()){
                $this->user = $this->ion_auth->get_user();
                if($this->user){
                }else{
                    $this->ion_auth->logout();
                    unset($_SESSION);
                }
            }
            
        }
        $admin_theme_name = 'users';
        if (!defined('ADMIN_THEME'))
        {
            define('ADMIN_THEME', $admin_theme_name);
        }
        // Prepare Asset library
        $this->asset->set_theme($admin_theme_name);
                $this->template->enable_parser(TRUE)
                ->set_theme($admin_theme_name)
                ->set_layout('default.html');
    }

    function _check_login()
    {
        $uri_string = $this->uri->uri_string();
        $access_exempt = array(
            'login',
            'logout',
            'forgot_password',
            'reset_password',
            'confirm_code',
            'signup',
            'join',
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

    function __remove_url_for_this_uris()
    {
        $uri_string = $this->uri->uri_string();
        $access_exempt = array(
            'ajax',
            'forgot_password',
            'reset_password',
            'confirm_code',
            'signup',
            'join',
        );

        foreach ($access_exempt as $key => $value) {
            $access = explode('/', $value);
            if(preg_match('/'.$access[0].'/', $uri_string)){
                remove_subdomain_from_url($this->chamasoft_settings->protocol.''.$this->chamasoft_settings->url); 
            }
        }
    }


    
}