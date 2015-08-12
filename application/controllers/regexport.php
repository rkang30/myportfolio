<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start(); //we need to call PHP's session object to access it through CI
class Regexport extends CI_Controller {
 
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
			
			if(isset($flash_session_data['download_reg'])){
				
				$sql = "SELECT * FROM register WHERE id_project=".$data['project']." AND subscribe=1 AND ((email != '') OR (email IS NOT NULL)) AND active='Y'";
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
				header('Content-Disposition: attachment;filename="Client information.xls"'); 
				header('Cache-Control: max-age=0'); 
				header('Refresh: 1; URL='.$this->config->base_url().'regexport/index/'.$data['developer'].'/'.$data['project']);
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
				$objWriter->save('php://output');
				
			}
			
		}elseif(($this->uri->rsegment(3) != "") && ($this->uri->rsegment(4) != "")){
			$data['developer'] = $this->uri->rsegment(3);
			$data['project'] = $this->uri->rsegment(4);
		}
		
		//empty developer project
		if($this->session->flashdata('empty_dev_proj')){
			$flash_session_empty_data = $this->session->flashdata('empty_dev_proj');
			if(isset($flash_session_empty_data['developer'])){
				$data['empty']['developer'] = $flash_session_empty_data['developer'];
			}
			if(isset($flash_session_empty_data['project'])){
				$data['empty']['project'] = $flash_session_empty_data['project'];
			}
		}
		
		$this->load->view('regexport_view', $data);
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