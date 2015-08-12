<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login extends CI_Controller {
 
function __construct()
{
   parent::__construct();
}
 
function index()
{
	if($this->session->userdata('logged_in')){
		 //Go to private area
		 redirect('home', 'refresh');
	}else{
	   $this->load->helper(array('form'));
	   $this->load->view('login_view');
	}
}
 
} 
?>