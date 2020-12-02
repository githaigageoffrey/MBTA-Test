<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{

	private $template;
	protected $subways = array(
		0 => "Light Rail",
		1 => "Heavy Rail"
	);
	protected $data;
	function __construct(){
		parent::__construct();
		$this->load->model('routes_m');
		$this->template = "template/default";
		$this->data['subways'] = $this->subways;
	}

	function index(){
		$this->data['title'] = 'Home';
		$this->data["main_content"] = "index";
		$this->load->view($this->template,$this->data);
		$this->routes_m->fetch_routes();
	}

	function question1(){
		$this->data['routes'] = $this->routes_m->get_all_routes();
		$this->data['title'] = 'Question 1';
		$this->data["main_content"] = "question1";
		$this->load->view($this->template,$this->data);
	}

	function question2(){
		$this->data['subway'] = $this->routes_m->get_routes_and_stops();
		$this->data['title'] = 'Question 2';
		$this->data["main_content"] = "question2";
		$this->load->view($this->template,$this->data);
	}

}
?>