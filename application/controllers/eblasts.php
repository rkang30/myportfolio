<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start(); //we need to call PHP's session object to access it through CI
class Eblasts extends CI_Controller {
 
function __construct()
{
   parent::__construct();
}
 
function index()
{
	$this->load->helper(array('form'));
   if($this->session->userdata('logged_in'))
   {
		date_default_timezone_set('America/Toronto');
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
			
			if(isset($flash_session_data['campaign_list'])){
				$data['campaign_list'] = $flash_session_data['campaign_list']; //campaign id
				require('asset/mailchimp_src/Mailchimp.php');
				$mailchimp = new Mailchimp('mailchimp_api_key');
				
				//fetch campaign name	
				$this->db->select('campaign_name');
				$this->db->from('client_eblast_campaign');
				$this->db->where('id', $data['campaign_list']);
				$camp_query = $this -> db -> get();
				$camp_results = $camp_query->result();
				foreach($camp_results as $camprow){
					$camp_name = $camprow->campaign_name;
				}

				$Camplist = $mailchimp->campaigns->getList();
				$campData = $Camplist['data'];
				$num = count($campData);
				
				if($num > 0){
					for($i=0;$i<$num;$i++){
						$cid = $campData[$i]['id'];
						$campaign_name = $campData[$i]['title'];
						
							if($campaign_name == $camp_name){
								
								$summary = $mailchimp->reports->summary($cid);
								$total_sent = $summary['emails_sent'];
								$hard_bounces = $summary['hard_bounces'];
								$soft_bounces = $summary['soft_bounces'];
								$total_bounces = $hard_bounces+$soft_bounces;
								$total_received = $total_sent-($total_bounces);
								$total_reads = $summary['opens'];
								$unique_reads = $summary['unique_opens'];
								$total_clicks = $summary['clicks'];
								$unique_clicks = $summary['unique_clicks'];
								$abuse = $summary['abuse_reports'];
								$forwards = $summary['forwards'];
								$unsubscribes = $summary['unsubscribes'];
								
								//update client_eblast_campaign table							
								$updData = array(
											   'total_recipients' => $total_sent,
											   'successful_deliveries' => $total_received,
											   'total_bounces' => $total_bounces,
											   'times_forwarded' => $forwards,
											   'total_opens' => $total_reads,
											   'unique_opens' => $unique_reads,
											   'total_clicks' => $total_clicks,
											   'unique_clicks' => $unique_clicks,
											   'unsubscribes' => $unsubscribes,
											   'abuse_complaints' => $abuse,
											);

								$this->db->where('campaign_name', $campaign_name);
								$this->db->where('id_developer', $data['developer']);
								$this->db->where('id_project', $data['project']);
								$this->db->update('client_eblast_campaign', $updData); 
								
								$unsubscribes = $mailchimp->reports->unsubscribes($cid);
								$unsubData = $unsubscribes['data'];
								$total = count($unsubData);
								for($k=0;$k<$total;$k++){
									if(isset($unsubData[$k]['member']['email']) && ($unsubData[$k]['member']['email'] != "")){
										$unsubEmail = $unsubData[$k]['member']['email'];
									}else{
										$unsubEmail = "";
									}
									
									if(isset($unsubEmail) && ($unsubEmail != "")){
										//update register table
										$now = date('Y-m-d H:i:s');
										$unsubData = array(
													   'contact' => 'No',
													   'can_email' => 'No',
													   'subscribe' => 0,
													   'modified' => $now
													);	
										$this->db->where('email', $unsubEmail);
										$this->db->where('id_developer', $data['developer']);
										$this->db->where('id_project', $data['project']);
										$this->db->update('register', $unsubData); 								
									}

								}//end of for loop
							
							}//end of if(($campaign_name != "Untitled") && ($campaign_name == $channel['campaign_name']));

					}//end of for loop	
				}// end of $num > 0
				
				//select campaign table again to pass the updated values
				$this->db->select('*');
				$this->db->from('client_eblast_campaign');
				$this->db->where('id', $data['campaign_list']);
				$cl_query = $this->db->get();
				$data['camp_info_result'] = $cl_query->result();						
			
			}//end of isset($flash_session_data['campaign_list'])
			
		}elseif(($this->uri->rsegment(3) != "") && ($this->uri->rsegment(4) != "")){
			$data['developer'] = $this->uri->rsegment(3);
			$data['project'] = $this->uri->rsegment(4);
		}
		
		//empty developer and/or project selected
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
		
		$this->load->view('eblasts_view', $data);
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
