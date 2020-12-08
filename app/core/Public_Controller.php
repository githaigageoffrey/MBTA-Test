<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Code here is run before frontend controllers
class Public_Controller extends MY_Controller{

    public $default_country;
    public $application_settings;
	public $group;
	public $selected_language_name;
	public $selected_language_id = '1';
	public $languages;

	public function __construct(){
		parent::__construct();
		// Is there a layout file for this module?
		if ($this->template->layout_exists($this->module . '.html')){
			$this->template->set_layout($this->module . '.html');
		}elseif ($this->template->layout_exists('default.html')){// Nope, just use the default layout
			$this->template->set_layout('default.html');
		}
	    // Make sure whatever page the user loads it by, its telling search robots the correct formatted URL
	    $this->template->set_metadata('canonical', site_url($this->uri->uri_string()), 'link');
        //$this->template->enable_parser(TRUE)->set_theme($frontend_theme_name)->set_layout('home.html');
	}
}
