<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start(); //we need to call PHP's session object to access it through CI
class Passgen extends CI_Controller {
 
function __construct()
{
   parent::__construct();
   $this->load->library('encrypt');
}
 
	function index()
	{
		$msg = 'seE4r6y!QzsUikvc';

		$encrypted_string = $this->encrypt->encode($msg);
		echo $encrypted_string;
	}
 
}
 
?>