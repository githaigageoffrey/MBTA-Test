<?php if(!defined('BASEPATH')) exit('You are not allowed to view this script');
class Authentication extends Authentication_Controller
{

	function __construct()
    {
        parent::__construct();
    }

    function login()
    {
    	$this->session->set_userdata('pass_key',random_string('alnum', 32));
    	$this->template->title("User Login")->set_layout('authentication.html')->build('authentication/login');

    }

    function logout()
    {
        unset($_COOKIE);
        $this->ion_auth->logout();
        $this->session->set_flashdata('success', 'You have Successfully Logged Out');
        redirect('login','refresh');
    }

}?>