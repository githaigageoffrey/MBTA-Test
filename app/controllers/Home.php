<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Authentication_Controller
{

	/*
	* Dynamic data but defined as static. This could also be saved in a database that keeps on being updated
	*
	*/
	protected $subways = array(
		0 => "Light Rail",
		1 => "Heavy Rail"
	);
	protected $data;

	function __construct()
	{
		parent::__construct();
		$this->load->model('routes_m');
		$this->data['subways'] = $this->subways;
	}

	function index()
	{
		$this->routes_m->fetch_routes();
		$this->template->title("Home Page")->build('index');
	}

	function question_one()
	{
		$this->data['routes'] = $this->routes_m->get_all_routes();
		$this->template->title("Question One")->build("question_one",$this->data);
	}

	function question_two()
	{
		$this->data['subway'] = $this->routes_m->get_routes_and_stops();
		$this->data['connections'] = $this->routes_m->route_combination();
		$this->template->title("Question Two")->build("question_two",$this->data);
	}

	function question_three()
	{
		$error = "";
		$results = array();
		if($_POST){
			$from = $this->input->post('from');
			$to = $this->input->post('to');
			if($from && $to){
				if($from == $to){
					$error = "Select destination different from source (From where)";
				}else{
					$results = $this->routes_m->search_route($from,$to);
				}
			}else{
				$error = "Ensure you all fields are entered correctly";
			}
		}
		$this->data["error"] = $error;
		$this->data["results"] = $results;
		$this->template->title("Question Three")->build("question_three",$this->data);
	}

}