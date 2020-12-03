<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{

	private $template;
	protected $subways = array(
		0 => "Light Rail",
		1 => "Heavy Rail"
	);

	protected $destinations = array(
		1 => 'Ashmont Braintree',
		2 => 'Alewife',
		3 => 'Forest Hills',
		4 => 'Oak Grove',
		5 => 'Bowdoin',
		6 => 'Wonderland',
		7 => "Mattapan",
		8 => "Boston College",
		9 => "Park Street",
		10 => "Cleveland Circle",
		11 => "North Station",
		12 => "Riverside",
		13 => "Heath Street",
		14 => "North Station",
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
		$this->data['connections'] = $this->routes_m->route_combination();
		$this->data['title'] = 'Question 2';
		$this->data["main_content"] = "question2";
		$this->load->view($this->template,$this->data);
	}

	function question3(){
		$error = "";
		$this->data['title'] = 'Question 3';
		$this->data["main_content"] = "question3";
		$this->data["destinations"] = $this->destinations;
		$results = array();
		if($_POST){
			$from = $this->input->post('from');
			$to = $this->input->post('to');
			if($from && $to){
				if($from == $to){
					$error = "Select to different from from";
				}else{
					$results = $this->routes_m->search_route($from,$to);
				}
			}else{
				$error = "Ensure you select from and to";
			}
		}
		$this->data["error"] = $error;
		$this->data["results"] = $results;
		$this->load->view($this->template,$this->data);
	}

}
?>