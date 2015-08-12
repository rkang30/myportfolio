<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Verifyproject extends CI_Controller {
 
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
		if($this->input->post('add_comment') == "add"){
			$this->form_validation->set_rules('new_comment_log', 'Comment Log', 'trim|required|xss_clean');
			$this->form_validation->set_rules('comment_flag', 'Status', 'required');
		}
	 
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

			if($this->input->post('back_to_default') != "reset"){
				foreach($this->input->post() as $pk => $pv){
					if((substr($pk, 0, 7) == "search_") || (substr($pk, 0, 6) == "filter")){
						$data[$pk] = $pv;
					}
				}
			}		
			
			if($this->input->post('reg_cancel') == "cancel"){
				$data['add_reg'] = "cancel_registration";
			}			
			
			if($this->input->post('add_reg') == "add"){
				$data['add_reg'] = "new_client";
			}elseif($this->input->post("add_new_client") == "add"){
				$data['add_reg'] = "new_client";
				$data["salutation"] = $this->input->post("salutation");
				$data["first_name"] = $this->input->post("first_name");
				$data["last_name"] = $this->input->post("last_name");
				$data["address"] = $this->input->post("address");
				$data["city"] = $this->input->post("city");
				$data["postal_code"] = $this->input->post("postal_code");
				$data["telephone"] = $this->input->post("telephone");
				$data["email"] = $this->input->post("email");
				$data["layout"] = $this->input->post("layout");
				$data["size"] = $this->input->post("size");
				$data["price"] = $this->input->post("price");
				$data["age"] = $this->input->post("age");
				$data["hear"] = $this->input->post("hear");
				$data["rent_own"] = $this->input->post("rent_own");
				$data["contact_how"] = $this->input->post("contact_how");
				$data["comments"] = $this->input->post("comments");
			}
			
			if($this->input->post('add_comment') == "add"){
				$data['add_comment'] = "failed";
				$data['new_comment_log'] = $this->input->post('new_comment_log');
				$data['comment_flag'] = $this->input->post('comment_flag');
				$data['reg_id'] = $this->input->post('entered_reg_id');
				$data['paginate'] = $this->input->post('paginate_number');
				
				//select original comment data
				$this->db->select('*');
				$this->db->from('register');
				$this->db->where('id_register', $data['reg_id']);
				$query = $this->db->get();
				$data['org_results'] = $query->result();

				//select log results
				$this->db->select("*");
				$this->db->from("comment_log");
				$this->db->where("id_register", $data['reg_id']);
				$this->db->where("id_developer", $data['developer']);
				$this->db->where("id_project", $data['project']);
				$log_query = $this->db->get();
				$data['log_results'] = $log_query->result();				
				
				//fetch comment log status
				$comment_flags = array();
				$this->db->select("*");
				$this->db->from("search_eng_option");
				$this->db->where("id_project", $data['project']);
				$this->db->where("id_developer", $data['developer']);
				$this->db->where("opt_name", "comment_flag");
				$this->db->where("active", "Y");
				$query = $this->db->get();
				$results = $query->result();
				foreach($results as $flrow){
					array_push($comment_flags, $flrow->opt_value);
				}
				
				$data["comment_flags"] = $comment_flags;				
				
				$data['not_list'] = true;
			}

			$this->load->view('home_view', $data);

	   }
	   else
	   {

			//Go to private area
			$selected_devproj = array('developer' => $this->input->post('developer'), 'project' => $this->input->post('project'), 'limit' => $this->input->post('limit'));

			//passing search filter posted data
			if($this->input->post('show_filter') == 'submit'){
				foreach($this->input->post() as $pk => $pv){
					if((substr($pk, 0, 7) == "search_") || (substr($pk, 0, 6) == "filter")){
						$selected_devproj[$pk] = $pv;
					}
				}
			}
			
			if($this->input->post('back_to_default') == "reset"){
				$selected_devproj['back_to_default'] = 1;
			}			
			
			if($this->input->post('reg_cancel') == "cancel"){
				$selected_devproj['add_reg'] = "cancel_registration";
			}
			
			if($this->input->post('add_reg') == "add"){
				$selected_devproj['add_reg'] = "new_client";
			}elseif($this->input->post("add_new_client") == "add"){
				$selected_devproj['add_reg'] = "new_client";
				$selected_devproj["add_new_client"] = $this->input->post("add_new_client");
				$selected_devproj["salutation"] = $this->input->post("salutation");
				$selected_devproj["first_name"] = $this->input->post("first_name");
				$selected_devproj["last_name"] = $this->input->post("last_name");
				$selected_devproj["address"] = $this->input->post("address");
				$selected_devproj["city"] = $this->input->post("city");
				$selected_devproj["postal_code"] = $this->input->post("postal_code");
				$selected_devproj["telephone"] = $this->input->post("telephone");
				$selected_devproj["email"] = $this->input->post("email");
				$selected_devproj["layout"] = $this->input->post("layout");
				$selected_devproj["size"] = $this->input->post("size");
				$selected_devproj["price"] = $this->input->post("price");
				$selected_devproj["age"] = $this->input->post("age");
				$selected_devproj["hear"] = $this->input->post("hear");
				$selected_devproj["rent_own"] = $this->input->post("rent_own");
				$selected_devproj["contact_how"] = $this->input->post("contact_how");			
				$selected_devproj["comments"] = $this->input->post("comments");			
			}
			
			if($this->input->post('comment_log') == "log"){
				$selected_devproj['comment_log'] = "view_comment_log";
				$selected_devproj['reg_id'] = $this->input->post('selected_reg_id');
				$selected_devproj['paginate'] = $this->input->post('limit');
			}
			
			if($this->input->post('add_comment') == "add"){
				if($this->session->userdata('logged_in')){
					$session_data = $this->session->userdata('logged_in');
				}	
				$selected_devproj['add_comment'] = "add_new_comment";
				$selected_devproj['comment_flag'] = $this->input->post("comment_flag");
				$selected_devproj['paginate'] = $this->input->post('paginate_number');
				$selected_devproj['author'] = $session_data['user'];
				$selected_devproj['new_comment_log'] = $this->input->post("new_comment_log");
				$selected_devproj['entered_reg_id'] = $this->input->post('entered_reg_id');
			}
			
			$this->session->set_flashdata('selected_dev_proj', $selected_devproj);		
			redirect('home', 'refresh');
	   }
	   
	}
	
}
?>
