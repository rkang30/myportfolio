<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {
 
function __construct()
{
   parent::__construct();
}
 
function index()
{
	date_default_timezone_set('America/Toronto');
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

		$this -> db -> select('id_developer, developer');
		$this -> db -> from('developers');
		if(isset($data['id_developer']) && ($data['id_developer'] != "") && ($data['permission'] != 1)){
		$this -> db -> where('id_developer', $data['id_developer']);	
		}
		$this -> db -> where('active', 'Y');
		$this->db->order_by("developer", "asc"); 
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
			$this->db->order_by("name", "asc"); 
			$query = $this -> db -> get();
			$p_results = $query->result();
			foreach($p_results as $prow){
				$prj_array['project'][$prow->id_developer][$prow->id_project] = $prow->name;
			}
			
		}
		$this->session->set_userdata('developers', $dev_array);		
		$this->session->set_userdata('projects', $prj_array);
			
		$dev_data = $this->session->userdata('developers');
		$pro_data = $this->session->userdata('projects');
		
		$data['developer_names'] = $dev_data['developer'];
		$data['project_names'] = $pro_data['project'];
	
		if($this->session->flashdata('selected_dev_proj')){
		
			$flash_session_data = $this->session->flashdata('selected_dev_proj');
			$data['developer'] = $flash_session_data['developer'];
			$data['project'] = $flash_session_data['project'];
			$data['limit'] = $flash_session_data['limit'];
			$data['not_list'] = false;
			
			
			if(isset($flash_session_data['add_reg'])){
			
				$data['add_reg'] = $flash_session_data['add_reg'];
				
				//search options - search_eng_option
				$this-> db -> select("*");
				$this-> db -> from("search_eng_option");
				$this-> db -> where("id_project", $data['project']);
				$this-> db -> where("id_developer", $data['developer']);
				$this-> db -> where("active", "Y");
				$search_query = $this -> db -> get();
				$search_results = $search_query->result();
				$data['search_results'] = $search_results;				
				
				$data['not_list'] = true;
				
			}
			
			if(isset($flash_session_data['back_to_default'])){
				$data['limit'] = 0;
			}
			
			if(isset($flash_session_data['add_new_client'])){
				
				$data['salutation'] = $flash_session_data['salutation'];
				$data['first_name'] = $flash_session_data['first_name'];
				$data['last_name'] = $flash_session_data['last_name'];
				$data['address'] = $flash_session_data['address'];
				$data['city'] = $flash_session_data['city'];
				$data['postal_code'] = $flash_session_data['postal_code'];
				$data['telephone'] = $flash_session_data['telephone'];
				$data['email'] = $flash_session_data['email'];
				$data['layout'] = $flash_session_data['layout'];
				$data['size'] = $flash_session_data['size'];
				$data['price'] = $flash_session_data['price'];
				$data['age'] = $flash_session_data['age'];
				$data['hear'] = $flash_session_data['hear'];
				$data['rent_own'] = $flash_session_data['rent_own'];
				$data['contact_how'] = $flash_session_data['contact_how'];
				$data['comments'] = $flash_session_data['comments'];
				$addreg_array = array("salutation", "first_name", "last_name", "address", "city", "postal_code", "telephone", "email", "layout", "size", "price", "age", "hear", "rent_own", "contact_how", "comments");
				$ins_data = array(
				   'id_developer' => $data['developer'],
				   'id_project' => $data['project'],
				   'contact' => 'Yes',
				   'subscribe' => 1,
				   'flag_delete' => 'N',
				   'active' => 'Y'
				);
				$num = count($addreg_array);
				for($i=0;$i<$num;$i++){
					$item = $addreg_array[$i];
					if(isset($data[$item]) && ($data[$item] != "")){
						$ins_data[$item] = $data[$item];
					}
				}
				$ins_data['created'] = date("Y-m-d H:i:s");
				$this->db->insert('register', $ins_data);
				$data['affected_results'] = $this->db->affected_rows();	
				$data['add_new_client'] = $flash_session_data['add_new_client'];
				$data['not_list'] = true;
				
			}
			
			if(isset($flash_session_data['comment_log'])){
				$data['comment_log'] = $flash_session_data['comment_log'];
				$data['paginate'] = $flash_session_data['paginate'];
				$data['reg_id'] = $flash_session_data['reg_id'];
				
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
				//select original comment data
				$this->db->select('id_register, first_name, comments, comment_flag, created');
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
			}
			
			if(isset($flash_session_data['add_comment'])){
				date_default_timezone_set('America/Toronto');
				$now = date("Y-m-d H:i:s");	
				$data['reg_id'] = $flash_session_data['entered_reg_id'];
				$data['add_comment'] = $flash_session_data['add_comment'];
				$data['paginate'] = $flash_session_data['paginate'];
				$data['author'] = $flash_session_data['author'];
				$data['new_comment_log'] = $flash_session_data['new_comment_log'];
				$data['comment_flag'] = $flash_session_data['comment_flag'];
				
				if($data['new_comment_log'] == ""){
					$data['errors']['new_comment_log'] ="Invalid comment";
				}
				
				if($data['comment_flag'] == ""){
					$data['errors']['comment_flag'] ="Select one";
				}
				
				if(!isset($data['errors'])){
					//update comment_flag on register table
					$flagData = array("comment_flag" => $data['comment_flag']);
					$this->db->where("id_register", $data['reg_id']);
					$this->db->update("register", $flagData);				
					
					//insert comment to comment_log table
					$logData = array(
					   'id_register' => $data['reg_id'] ,
					   'id_developer' => $data['developer'],
					   'id_project' => $data['project'],
					   'comment' => $data['new_comment_log'],
					   'author' => $data['author'],
					   'dt_created' => $now,
					   'active' => 'Y',
					);

					$this->db->insert('comment_log', $logData); 
					$data['comment_affected_rows'] = $this->db->affected_rows();					
					
					//reset the new comment log textarea to null to start refresh
					$data['new_comment_log'] = "";
				}
				
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
				$data['comment_flags'] = $comment_flags;				
				
				//select original comment data
				$this->db->select('id_register, first_name, comments, comment_flag, created');
				$this->db->from('register');
				$this->db->where('id_register', $data['reg_id']);
				$query = $this->db->get();
				$data['org_results'] = $query->result();
				print_r($data['org_results']);
				//select log results
				$this->db->select("*");
				$this->db->from("comment_log");
				$this->db->where("id_register", $data['reg_id']);
				$this->db->where("id_developer", $data['developer']);
				$this->db->where("id_project", $data['project']);
				$log_query = $this->db->get();
				$data['log_results'] = $log_query->result();				
				$data['not_list'] = true;				
				$view_file = "comment_view";
			}
			
			if($data['not_list'] === false){
				
				$filter_array = array();
				$search_array = array();
				$filters = array();
				$keyArray = array();
				foreach($flash_session_data as $flk => $flv){
					if((substr($flk,0,7) == "search_") || (substr($flk,0,6) == "filter")){
						$data[$flk] = $flv;
						if(substr($flk,0,6) == "filter"){
							$key = substr($flk,-1);
							$filter_array[$key] = $flv;
						}
						if(substr($flk,0,7) == "search_"){
							$key = substr($flk,-1);
							$compt = substr($flk,7, strlen($flk)-8);
							$search_array[$key][$compt] = $flv;
						  $count++;	
						}
					}	
				}

				if(count($search_array) > 0){
					foreach($search_array as $sk => $sv){
						foreach($sv as $key => $value){
							if($filter_array[$sk] == $key){
								$filters[$sk][$key] = $value;
								$keyArray[$sk] = $key;
							}
						}
					}
				}
				
				//$this->output->enable_profiler(TRUE);
				//select from register
				$common = "SELECT * FROM register WHERE ";
				$wh_sql = "";
				$dup_sql = "";
				if(count($filters) > 0){
					$dup_name = "";

					$dupInfo = array_count_values($keyArray);
					foreach($dupInfo as $duk => $duv){
						if($duv > 1){
							$dup_name = $duk;
						}
					}
					$wh = 0;
					$dh = 0;
					$select_array = array("layout", "size", "price", "age", "hear", "rent_own", "contact_how", "comment_flag");
					foreach($filters as $filk => $filv){
						foreach($filv as $k => $v){
							if($k == $dup_name){	
								if($dh == 0){
									if(in_array($k, $select_array)){
										$dup_sql .= $k."=\"".$v."\"";
									}else{
										$dup_sql .= $k." LIKE \"%".$v."%\"";
									}
								}else{
									if(in_array($k, $select_array)){
										$dup_sql .= " OR ".$k."=\"".$v."\"";
									}else{
										$dup_sql .= " OR ".$k." LIKE \"%".$v."%\"";
									}							
								}
								
							  $dh++;
							}else{
								if($wh == 0){
									if(in_array($k, $select_array)){
										$wh_sql .= $k."=\"".$v."\"";
									}else{
										$wh_sql .= $k." LIKE \"%".$v."%\"";
									}							
								}else{
									if(in_array($k, $select_array)){
										$wh_sql .= " AND ".$k."=\"".$v."\"";
									}else{
										$wh_sql .= " AND ".$k." LIKE \"%".$v."%\"";
									}							
								}	
							 $wh++;	
							}
						}//end of inner foreach
					}//end of foreach
				}//end of filters
				
				if($wh_sql != ""){
					$common .= $wh_sql." AND ";
				}
				
				if($dup_sql != ""){
					$common .= "(".$dup_sql.") AND ";
				}
				
				$common .= "id_project=".$data['project']." AND flag_delete = 'N' ORDER BY created DESC";
				$query = $common." LIMIT ".($data['limit']*50).", 50";
				$search_query = $this->db->query($query);
			
				$results = $search_query->result();
				//echo $this->db->last_query();
				$data['results'] = $results;			

				
				//search options - search_eng_option
				$this-> db -> select("*");
				$this-> db -> from("search_eng_option");
				$this-> db -> where("id_project", $data['project']);
				$this-> db -> where("id_developer", $data['developer']);
				$this-> db -> where("active", "Y");
				$search_query = $this -> db -> get();
				$search_results = $search_query->result();
				$data['search_results'] = $search_results;
							
				//raw info for num of results
				$raw_query = $this->db->query($common);			
				$data['num_results'] = $raw_query->num_rows();
			
			}
						
		}elseif(($this->uri->rsegment(3) != "") && ($this->uri->rsegment(4) != "")){
			
			$data['developer'] = $this->uri->rsegment(3);
			$data['project'] = $this->uri->rsegment(4);
			if($this->uri->rsegment(5) != ""){
				$data['client_id'] = $this->uri->rsegment(5);
			}
			if($this->uri->rsegment(6) != ""){
				$paginate = ($this->uri->rsegment(6))*50;
				$data['limit'] = $this->uri->rsegment(6);
			}else{
				$paginate = 0;
				$data['limit'] = 0;
			}
			
			//first 50 reg
			$this -> db -> select("*");
			$this -> db -> from("register");
			$this -> db -> where("id_project", $data['project']);
			$this -> db -> order_by('created', 'desc');
			$this -> db -> limit(50, $paginate);
			$query = $this -> db -> get();
			$results = $query->result();
			$data['results'] = $results;

			//search options - search_eng_option
			$this-> db -> select("*");
			$this-> db -> from("search_eng_option");
			$this-> db -> where("id_project", $data['project']);
			$this-> db -> where("id_developer", $data['developer']);
			$this-> db -> where("active", "Y");
			$search_query = $this -> db -> get();
			$search_results = $search_query->result();
			$data['search_results'] = $search_results;			
			
			//total raw number
			$this-> db -> select("*");
			$this-> db -> from("register");
			$this-> db -> where("id_project", $data['project']);
			$raw_query = $this -> db -> get();
			$data['num_results'] = $raw_query->num_rows();

		}
		
		$this->load->view("home_view", $data);
   }
   else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
}

public function addreg(){
	$this->load->helper(array('form'));
	if($this->session->userdata('logged_in')){
		$dev_data = $this->session->userdata('developers');
		$pro_data = $this->session->userdata('projects');
		$data['developer_names'] = $dev_data['developer'];
		$data['project_names'] = $pro_data['project'];
		$this->load->view('home_add', $data);
	}else{
     //If no session, redirect to login page
     redirect('login', 'refresh');
	}

}

public function download()
{
	if($this->session->userdata('logged_in'))
	{
		$permission = $this->session->userdata('permission');
		if($permission == 5){
			redirect('home', 'refresh');
		}else{
			$developer = $this->uri->rsegment(3);
			$project = $this->uri->rsegment(4);

			if(($developer != "") && ($project != "")){
				
				$sql = "SELECT * FROM register WHERE id_project=".$project." AND active='Y'";
				$dbc = $this->db->conn_id;
				$result = mysql_query($sql, $dbc);

				/** Error reporting **/
				error_reporting(E_ALL);
				ini_set('memory_limit', '-1');
				ini_set('display_errors', TRUE);
				ini_set('display_startup_errors', TRUE);
				date_default_timezone_set('America/Toronto');

				if (PHP_SAPI == 'cli')
					die('This example should only be run from a Web Browser');

				/** Include PHPExcel **/
				require_once 'asset/Classes/PHPExcel.php';

				// Create new PHPExcel object
				$objPHPExcel = new PHPExcel();

				// Set the active Excel worksheet to sheet 0 
				$objPHPExcel->setActiveSheetIndex(0);  
				// Initialise the Excel row number 
				$rowCount = 1;  

				//fetch field names
				$field_name = array();
				while($fninfo = mysql_fetch_field($result)){
					$field_name[] = $fninfo->name;
				}

				//start of printing column names as names of MySQL fields  
				$column = 'A';
				for ($i = 0; $i < mysql_num_fields($result); $i++)  
				{

				if((($i >= 1) && ($i <= 3)) || (($i >= 13) && ($i <= 15)) || ($i == 19) || ($i == 20) || (($i >= 23) && ($i <= 30)) || (($i >= 32) && ($i <= 51)) || ($i == 53) || ($i == 54)){
						continue;
					}else{
						$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $field_name[$i]);
					}
					
					$column++;
				}
				//end of adding column names  

				//start while loop to get data  
				$rowCount = 2;  
				while($row = mysql_fetch_row($result))  
				{  
					$column = 'A';
					for($j=0; $j<mysql_num_fields($result);$j++)  
					{  
						if(!isset($row[$j]))  
							$value = NULL;  
						elseif ($row[$j] != "")  
							$value = strip_tags($row[$j]);  
						else  
							$value = "";  

						if((($j >= 1) && ($j <= 3)) || (($j >= 13) && ($j <= 15)) || ($j == 19) || ($j == 20) || (($j >= 23) && ($j <= 30)) || (($j >= 32) && ($j <= 51)) || ($j == 53) || ($j == 54)){
							continue;
						}else{
							$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $value);
						}	
						
						$column++;
					}  
					$rowCount++;
				} 

				// Redirect output to a client’s web browser (Excel5) 
				header('Content-Type: application/vnd.ms-excel'); 
				header('Content-Disposition: attachment;filename="Registrant information.xls"'); 
				header('Cache-Control: max-age=0'); 
				header('Refresh: 1; URL='.$this->config->base_url().'home/index/'.$developer.'/'.$project);
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
				$objWriter->save('php://output');				
				
			}else{
				redirect('home', 'refresh');
			}		
			
		}

	}
	else
	{
		//If no session, redirect to login page
		redirect('login', 'refresh');
	}
}
 
public function logout()
{
   $this->session->unset_userdata('logged_in');
   $this->session->unset_userdata('developers');
   $this->session->unset_userdata('projects');
   //session_destroy();
   redirect('home', 'refresh');
}
 
}
 
?>