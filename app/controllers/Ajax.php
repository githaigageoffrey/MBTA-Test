<?php if(!defined('BASEPATH')) exit('You are not allowed to view this script');
class Ajax extends Ajax_Controller
{

	function __construct()
    {
        parent::__construct();
        $this->load->library('cryptojs');
    }

    function login()
    {
    	$response = array();
        if($_POST){
            foreach ($_POST as $key => $value) {
                $_POST[$key] = $this->cryptojs->cryptoJsAesDecrypt($this->session->userdata("pass_key"),$value);
            }
            if(!$this->input->post('identity')){
                $response = array(
                    'status'=>0,
                    'refer'=>site_url('login'),
                    'message' => 'Login failed due to invalid passphrase',
                );
            }
        }
        if(empty($response)){
    		$this->form_validation->set_rules('identity', 'Email Address', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');
            $language_id = isset($_COOKIE['language_id'])?($_COOKIE['language_id']?:''):'';
            if($this->form_validation->run()){
                $identity = $this->input->post('identity');
                $password = $this->input->post('password');
                $remember = $this->input->post('remember');
                if($this->ion_auth->login($identity, $password, $remember)){ 
                    $refer = $this->input->post('refer');
                    $user = $this->ion_auth->get_user_by_identity($identity);
                    $response = array(
                        'status'=>1,
                        'refer'=>site_url(''),
                        'message' => strip_tags($this->ion_auth->messages()),
                    );              
                }else{
                    $response = array(
                        'status'=>0,
                        'message'=>strip_tags($this->ion_auth->errors()),
                    );
                }
            }else{
                $post = array();
                $form_errors = $this->form_validation->error_array();
                foreach ($form_errors as $key => $value) {
                    $post[$key] = $value;
                }
                $response = array(
                    'status' => 0,
                    'message' => 'Form validation errors',
                    'validation_errors' => $post,
                );
            }
        }
        echo json_encode($response);

    }

}?>