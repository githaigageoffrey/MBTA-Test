<?php if(!defined('BASEPATH')) exit('You are not allowed to view this script');
class Authentication extends Authentication_Controller
{

	function __construct()
    {
        parent::__construct();
    }

    /*
    *	Loads the user public authentication pages to login, signup, forgot password process or any other feature to be added.
    */

    function login()
    {
    	if($this->ion_auth->logged_in()){ 
            redirect('');
        }
    	$this->session->set_userdata('pass_key',random_string('alnum', 32));
    	$this->template->title("User Login")->set_layout('authentication.html')->build('authentication/login');
    }

    /*
    *	Unset any cookies set
    *	unset the session
    * 	Redirect the user to login page
    */

    function logout()
    {
        unset($_COOKIE);
        $this->ion_auth->logout();
        $this->session->set_flashdata('success', 'You have Successfully Logged Out');
        redirect('login','refresh');
    }

}?>