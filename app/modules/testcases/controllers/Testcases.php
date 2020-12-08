<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Testcases extends Authentication_Controller
{
	/*
	* Unit testing for all the three questions
	* Using codeigniter capability to perform unit testing, use the library unit_test
	* Run through question1 , question 2 and Question 3 to see if the results pass or fail
	* Generate a report to view the test cases
	*/
	protected $data = array();
	function __construct()
	{
		parent::__construct();
		$this->load->library('unit_test');
		$this->load->model('routes_m');
		//$this->unit->use_strict(TRUE);
	}

	function index()
	{
		$question_one = $this->question_one();
		$quest_one_expected_result = '[{"name":"Red Line","type":1},{"name":"Mattapan Trolley","type":0},{"name":"Orange Line","type":1},{"name":"Green Line B","type":0},{"name":"Green Line C","type":0},{"name":"Green Line D","type":0},{"name":"Green Line E","type":0},{"name":"Blue Line","type":1}]';
		$question_one_test_name = 'Question 1: Categorize a rail either light or heavy';
		$this->unit->run($question_one, $quest_one_expected_result, $question_one_test_name);
		$this->template->title("Test Cases Report")->build('report',$this->data);
	}

	function test_case_two()
	{
		$rail_most_stops = $this->question_two_most_stops();
		$most_stop_defination = 'Question 2: Subway with most stops';
		$most_stop_result = '0 : 5 - Most';

		$rail_least_stops = $this->question_two_least_stops();
		$least_stop_defination = 'Question 2: Subway with least stops';
		$least_stop_result = '1 : 3 - Least';

		$rail_stop_connections = $this->question_two_stop_connection();
		$least_stop_connection_defination = 'Question 2: List of stops connecting two or more';
		$least_stop_connection_result = 'Mattapan : Ashmont Braintree : Alewife';


		$this->unit->run($rail_most_stops, $most_stop_result, $most_stop_defination);
		$this->unit->run($rail_least_stops, $least_stop_result, $least_stop_defination);
		$this->unit->run($rail_stop_connections, $least_stop_connection_result, $least_stop_connection_defination);
		$this->template->title("Test Cases Report - Question Two")->build('report',$this->data);
	}


	function test_case_three()
	{
		$test = $this->question_three('Davis','Kendall');
		$test_two = $this->question_three('Ashmont', 'Arlington');

		$expected_result = "Redline";
		$expected_result_two = "Redline, Greenline";


		$description = "Test1: Rail to Connect Between Two towns: Davis to Kendall";
		$description_two = "Test2: Rail to Connect Between Two towns: Ashmont to Arlington";

		$this->unit->run($test, $expected_result, $description);
		$this->unit->run($test_two, $expected_result_two, $description_two);
		$this->template->title("Test Cases Report - Question Three")->build('report',$this->data);
	}

	function question_one()
	{
		$routes = $this->routes_m->get_all_routes();
		return json_encode($routes);
	}

	function question_two_most_stops()
	{
		$stops = $this->routes_m->get_routes_and_stops();
		$counts = $stops['count'];
		foreach ($counts as $key=>$count) {
			if(preg_match('/most/i', $count)){
				return $key.' : '.$count;
			}
		}

	}

	function question_two_least_stops()
	{
		$stops = $this->routes_m->get_routes_and_stops();
		$counts = $stops['count'];
		foreach ($counts as $key=>$count) {
			if(preg_match('/least/i', $count)){
				return $key.' : '.$count;
			}
		}
	}

	function question_two_stop_connection()
	{
		$combinations = $this->routes_m->route_combination();
		//print_r($combinations);
		$routes = "";
		foreach ($combinations as $key => $combination) {
			if($routes){
				$routes.=" , ".$combination['from']." : ".$combination['stop']." : ".$combination['to'];
			}else{
				$routes=$combination['from']." : ".$combination['stop']." : ".$combination['to'];
			}
		}
		return $routes;
	}

	function question_three($from='',$to='')
	{
		return $this->routes_m->search_route($from,$to);
	}
}