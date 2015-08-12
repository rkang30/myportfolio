<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start(); //we need to call PHP's session object to access it through CI
class Eblastnames extends CI_Controller {
 
function __construct()
{
   parent::__construct();
}
 
function index()
{
	$this->load->helper(array('form'));
   if($this->session->userdata('logged_in'))
   {
		$data = array();	
		$session_data = $this->session->userdata('logged_in');
		$data['user'] = $session_data['user'];
		$data['id_developer'] = $session_data['id_developer'];
		$data['developer_name'] = $session_data['developer_name'];
		$data['id_project'] = $session_data['id_project'];
		$data['project_name'] = $session_data['project_name'];
		$data['permission'] = $session_data['permission'];
		
		if((!$this->session->userdata('developers')) || (!$this->session->userdata('projects'))){
			$this -> db -> select('id_developer, developer');
			$this -> db -> from('developers');
			if(isset($data['id_developer']) && ($data['id_developer'] != "") && ($data['permission'] != 1)){
			$this -> db -> where('id_developer', $data['id_developer']);	
			}
			$this -> db -> where('active', 'Y');
			$query = $this -> db -> get();
			$results = $query->result();

			$dev_array = array();
			$prj_array = array();
			$count=0;
			foreach($results as $row)
			{
				 
				$dev_array['developer'][$row->id_developer] = $row->developer;
				
				//select projects
				$this -> db -> select('id_developer, id_project, name');
				$this -> db -> from('projects');
				$this -> db -> where('id_developer', $row->id_developer);
				if(isset($data['id_project']) && ($data['id_project'] != "") && ($data['permission'] == 5)){
				$this -> db -> where('id_project', $data['id_project']);
				}
				$this -> db -> where('active', 'Y');
				$query = $this -> db -> get();
				$p_results = $query->result();
				foreach($p_results as $prow){
					$prj_array['project'][$prow->id_developer][$prow->id_project] = $prow->name;
				}
				
			}
			$this->session->set_userdata('developers', $dev_array);		
			$this->session->set_userdata('projects', $prj_array);		 
		}

		$dev_data = $this->session->userdata('developers');
		$pro_data = $this->session->userdata('projects');
		
		$data['developer_names'] = $dev_data['developer'];
		$data['project_names'] = $pro_data['project'];
	
		if($this->session->flashdata('selected_dev_proj')){
			$flash_session_data = $this->session->flashdata('selected_dev_proj');
			$data['developer'] = $flash_session_data['developer'];
			$data['project'] = $flash_session_data['project'];
			
			if(isset($flash_session_data['new_campaign']) && ($flash_session_data['new_campaign'] != "")){
				$data['new_campaign'] = $flash_session_data['new_campaign'];
				//insert into client_eblast_campaign
				$ins_data = array(
				   'id_developer' => $data['developer'],
				   'id_project' => $data['project'],
				   'campaign_name' => $data['new_campaign']
				);
				$this->db->insert('client_eblast_campaign', $ins_data); 
				if($this->db->affected_rows() == 1){
					$data['new_campaign_added'] = "Successfully registered";
				}
			}
			
		}elseif(($this->uri->rsegment(3) != "") && ($this->uri->rsegment(4) != "")){
			$data['developer'] = $this->uri->rsegment(3);
			$data['project'] = $this->uri->rsegment(4);
		}
		
		//empty developer and/or project
		if($this->session->flashdata('empty_dev_proj')){
			$flash_session_empty_data = $this->session->flashdata('empty_dev_proj');
			if(isset($flash_session_empty_data['developer'])){
				$data['empty']['developer'] = $flash_session_empty_data['developer'];
			}
			if(isset($flash_session_empty_data['project'])){
				$data['empty']['project'] = $flash_session_empty_data['project'];
			}
		}
		
		if(isset($data['developer']) && isset($data['project'])){
			$this -> db -> select('id, campaign_name');
			$this -> db -> from('client_eblast_campaign');
			$this -> db -> where('id_developer', $data['developer']);
			$this -> db -> where('id_project', $data['project']);
			$this -> db -> order_by('id', 'desc');
			$camp_query = $this -> db -> get();
			$data['camp_results'] = $camp_query->result();		
		}		
		
		$this->load->view('eblastname_view', $data);
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
}
 
function logout()
{
   $this->session->unset_userdata('logged_in');
   $this->session->unset_userdata('developers');
   $this->session->unset_userdata('projects');
   //session_destroy();
   redirect('home', 'refresh');
}
 
}
 
?>