<?php if(!defined('BASEPATH')) exit('You are not allowed to view this script');
class Authentication extends Authentication_Controller
{

	function __construct()
    {
        parent::__construct();
    }

    function login()
    {

    	$this->template->title("User Login")->build('authentication/login');

    }

}?>