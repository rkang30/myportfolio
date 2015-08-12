<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Verifydata extends CI_Controller {
 
	function __construct()
	{
	   parent::__construct();
	}
	 
	function index()
	{

	   //This method will have the credentials validation
	   $this->load->library('form_validation');
	 
		$this->form_validation->set_rules('developer', 'Developer', 'required');
		$this->form_validation->set_rules('project', 'Project', 'required');
	 
	   if($this->form_validation->run() == FALSE)
	   {
			//Field validation failed.  redirected to home_view page
			if($this->session->userdata('logged_in')){
				$session_data = $this->session->userdata('logged_in');
				$data['user'] = $session_data['user'];
				$data['id_developer'] = $session_data['id_developer'];
				$data['developer_name'] = $session_data['developer_name'];
				$data['id_project'] = $session_data['id_project'];
				$data['project_name'] = $session_data['project_name'];
				$data['permission'] = $session_data['permission'];			
			}
			
			if($this->session->userdata('developers')){
				$dev_data = $this->session->userdata('developers');	
				$data['developer_names'] = $dev_data['developer'];				
			}
			if($this->session->userdata('projects')){
				$pro_data = $this->session->userdata('projects');
				$data['project_names'] = $pro_data['project'];	
			}
		
			$data['developer'] = $this->input->post('developer');
			$data['project'] = $this->input->post('project');
			if(($data['developer'] == '') || ($data['project'] == '')){
				if($data['developer'] == ''){
					$empty_devproj['developer'] = 'Please select developer.';
				}
				if($data['project'] == ''){
					$empty_devproj['project'] = 'Please select project.';
				}
				$this->session->set_flashdata('empty_dev_proj', $empty_devproj);
				redirect('analytics', 'refresh');
			}			
			
			if($this->input->post("view_analytics") == "view"){
				$data['analytics_list'] = $this->input->post("analytics_list");
			}
			
			$this->load->view('analytics_view', $data);
	   }
	   else
	   {
			//Go to private area
			$selected_devproj = array('developer' => $this->input->post('developer'), 'project' => $this->input->post('project'));
			
			if($this->input->post("view_analytics") == "view"){
				$selected_devproj['analytics_list'] = $this->input->post("analytics_list");
			}			
			
			$this->session->set_flashdata('selected_dev_proj', $selected_devproj);		
			redirect('analytics', 'refresh');
	   }
	   
	}
	
}
?>
