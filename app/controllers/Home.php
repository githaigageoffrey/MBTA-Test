<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Authentication_Controller
{

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
		$this->data["destinations"] = $this->destinations;
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
?>