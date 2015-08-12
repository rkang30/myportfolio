<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start(); //we need to call PHP's session object to access it through CI
class Programs extends CI_Controller {
 
	function __construct()
	{
	   parent::__construct();
	   $this->load->helper(array('url'));
	}
 
	function index()
	{
		//redirect to login if this class is only called
		redirect('login', 'refresh');

	}
	
	function getcriteria(){
		if($this->session->userdata('logged_in')){
			$id_developer = $_POST['id_developer'];
			$id_project = $_POST['id_project'];
			$opt_array = array();
			$this -> db -> select('id, opt_name, opt_value, types');
			$this -> db -> from('search_eng_option');
			$this -> db -> where('id_developer', $id_developer);
			$this -> db -> where('id_project', $id_project);
			$this -> db -> where('active', 'Y');
			$query = $this -> db -> get();
			$results = $query->result();
			foreach($results as $row){
				$id = $row->id;
				$opt_name = $row->opt_name;
				$opt_value = $row->opt_value;
				$types = $row->types;
				$opt_array[$opt_name][$types][$id] = $opt_value;
			}

			$arr = array(
							'msg' => 'success',
							'returnCriteria' => $opt_array
						);

			if (!function_exists('json_encode'))
			{
				$result = $this->json_encode($arr);
			}
						
			$result = json_encode($arr);
			echo $result;
		}else{
			redirect('login', 'refresh');
		}
	}//end of getcriteria()
	
	function updateReg(){
		if($this->session->userdata('logged_in')){
			date_default_timezone_set('America/Toronto');
			$today = date("Y-m-d H:i:s");
			$reg_id = $_POST['reg_id'];
			$developer = $_POST['developer'];
			$project = $_POST['project'];
			$data = array();
			$fields = array("salutation", "first_name", "last_name", "address", "city", "postal_code", "realtor", "work_with_realtor", "telephone", "email", "layout", "size", "price", "age", "hear", "rent_own", "contact_how");
			foreach($fields as $field){
				if(isset($_POST[$field])){
					$value = stripslashes($_POST[$field]);
					$data[$field] = $value;
				}
			}
			//verification
			$errors = "";
			//salutation
			if(isset($salutation)){
				if(strlen($salutation) > 4){
					$errors['salutation'] = "Title is too long";
				}else{
					if(strlen($salutation) > 0 && strlen($salutation) <= 4){
						if(!preg_match('/^[A-Za-z.]+$/', $salutation)){
							$errors['salutation'] = "Invalid title";
						}else{
							if($salutation == "undefined"){
								$salutation = "";
							}
						}
					}	
				}
			}
			//first name, last name
			if(isset($first_name)){
				if(strlen($first_name) > 80){
					$errors['first_name'] = "First name is too long";
				}else{
					if(strlen($first_name) > 0 && strlen($first_name) <= 80){	
						if(!preg_match('/^[A-Za-z- ]+$/', $first_name)){
							$errors['first_name'] = "Invalid name";
						}else{
							if($first_name == "undefined"){
								$first_name = "";
							}
						}			
					}
				}
			}
			
			if(isset($last_name)){
				if(strlen($last_name) > 120){
					$errors['last_name'] = "Last name is too long";
				}else{
					if(strlen($last_name) > 0 && strlen($last_name) <= 120){	
						if(!preg_match('/^[A-Za-z- ]+$/', $last_name)){
							$errors['last_name'] = "Invalid name";
						}else{
							if($last_name == "undefined"){
								$last_name = "";
							}
						}			
					}
				}		
			}

			if(isset($address)){
				if(strlen($address) > 64){
					$errors['address'] = "Address is too long";
				}else{
					if(strlen($address) > 0 && strlen($address) <= 64){
						if(!preg_match('/^(#)?([a-z0-9-,.\' ]+)\s[a-z0-9- ,\'.]+$/i', $address)){
							$errors['address'] = "Invalid address";
						}else{
							if($address == "undefined"){
								$address = "";
							}
						}
					}
				}		
			}

			if(isset($city)){
				if(strlen($city) > 60){
					$errors['city'] = "City name is too long";
				}else{
					if(strlen($city) > 0 && strlen($city) <= 60){
						if(!preg_match('/^[a-z- \']+$/i', $city)){
							$errors['city'] = "Invalid city name";
						}else{
							if($city == "undefined"){
								$city ="";
							}
						}
					}
				}		
			}
			
			if(isset($postal_code)){
				if(strlen($postal_code) > 7){
					$errors['postal_code'] = "Postal code is too long";
				}else{
					if(strlen($postal_code) > 0 && strlen($postal_code) <= 7){
						if(!preg_match('/^[a-z0-9 ]+$/i', $postal_code)){
							$errors['postal_code'] = "Invalid postal code";
						}else{
							if($postal_code == "undefined"){
								$postal_code = "";
							}
						}
					}
				}
			}
			
			if(isset($telephone)){
				if(strlen($telephone) > 20){
					$errors['telephone'] = "Phone number is too long";
				}else{
					if(strlen($telephone) > 0 && strlen($telephone) <= 20){
						if(!preg_match('/^\+?1?\W*([2-9][0-8][0-9])\W*([2-9][0-9]{2})\W*([0-9]{4})(\se?x?t?(\d*))?/', $telephone)){
							$errors['telephone'] = "Invalid phone number";
						}else{
							if($telephone == "undefined"){
								$telephone = "";
							}
						}
					}
				}
			}
			
			if(isset($email)){
				if(strlen($email) > 200){
					$errors['email'] = "Email is too long";
				}else{
					if(strlen($email) > 0 && strlen($email) <= 200){
						if(!preg_match('/^[\w.-]+@[\w.-]+\.[a-z]{2,6}$/i', $email)){
							$errors['email'] = "Invalid email";
						}else{
							if($email == "undefined"){
								$email = "";
							}
						}
					}
				}
			}
			
			if($errors == ""){
				//update register table
				$data['modified'] = $today;
										
				$this->db->where('id_register', $reg_id);
				$result = $this->db->update('register', $data);	
				
			}
			
			if($errors == ""){
				$arr = array(
								'msg' => 'success',
								'rtnRegId' => $reg_id,
								'rtnDevId' => $developer,
								'rtnProId' => $project
							);
			}else{
				$arr = array(
								'msg' => 'fail',
								'rtnRegId' => $reg_id,
								'rtnDevId' => $developer,
								'rtnProId' => $project,							
								'returnErrors' => $errors
							);
			}
			
			if (!function_exists('json_encode'))
			{
				$result = $this->json_encode($arr);
			}
						
			$result = json_encode($arr);
			echo $result;
		}else{
			redirect('login', 'refresh');
		}		
		
	}//end of updateReg
	
	function removeReg(){
		if($this->session->userdata('logged_in')){
			date_default_timezone_set('America/Toronto');
			$today = date("Y-m-d H:i:s");
			$i = 0;
			$reg_ids = array();
			
			$data = array(
				   'subscribe' => 0,
				   'contact' => "No",
				   'modified' => $today,
				   'flag_delete' => "Y",
				   'active' => "N"
				);

			foreach($_POST as $key => $value){
				array_push($reg_ids, $value);
				if($i == 0){
					$this->db->where('id_register', $value);
				}else{
					$this->db->or_where('id_register', $value);
				}
			  $i++;
			}//end of foreach
			$this->db->update('register', $data); 
			
			$arr = array(
							'msg' => 'success',
							'rtnRegId' => $reg_ids
						);
			
			
			if (!function_exists('json_encode'))
			{
				$result = $this->json_encode($arr);
			}
						
			$result = json_encode($arr);
			echo $result;
		}else{
			redirect('login', 'refresh');
		}
	}
	
	function reganalytics(){
		if($this->session->userdata('logged_in')){
			$contactHow = array();
			$Layouts = array();
			$PriceGroup = array();
			$Sizes = array();

			$pjt_id = $_POST["project"];

			$contact_project[0] = array("string", "Contact Type"); 
			$contact_project[1] = array("number", "Num of People"); 
			$layout_project[0] = array("string", "Layout"); 
			$layout_project[1] = array("number", "Num of People"); 
			$price_project[0] = array("string", "Price"); 
			$price_project[1] = array("number", "Num of People"); 
			$size_project[0] = array("string", "Size"); 
			$size_project[1] = array("number", "Num of People"); 


			//select contact in register
			$count=0;
			$this -> db -> select('contact, contact_how, layout, price, size');
			$this -> db -> from('register');
			$this -> db -> where('id_project', $pjt_id);
			$this -> db -> where('active', 'Y');
			$query = $this -> db -> get();
			$results = $query->result();		
			
			foreach($results as $row){
				$contact = $row->contact;
				$contact_how = $row->contact_how;
				$layout = $row->layout;
				$price = $row->price;
				$size = $row->size;
				
				if(($contact == "Yes") && (($contact_how == "") || ($contact_how == null))) $contact_how = ""; 
				if(($contact == "No") && (($contact_how == "") || ($contact_how == null))) $contact_how = "Do not contact";
				if($layout == "" || $layout == null) $layout = "";
				if($price == "" || $price == null) $price = "";
				if($size == "" || $size == null) $size = "";
				
				$contactHow[$count] = ucfirst($contact_how);
				$lay_from = array("bedroom", "den");
				$lay_to = array("Bedroom", "Den");	
				$Layouts[$count] = str_replace($lay_from, $lay_to, $layout);

				$p = $price;
				$prices = explode(" ", $p);
				$num = count($prices);
				if(($p != "") && ($num >= 3)){
					if(strpos($prices[0], ",") > 0){
						$price_front = $prices[0]." - ";
					}else{
						$price_front = substr($prices[0], 0, strlen($prices[0])-3).",".substr($prices[0], -3)." - ";
					}

					if(strpos($prices[2], ",") > 0){
						$price_back = $prices[2];
					}else{
						$price_back = substr($prices[2], 0, strlen($prices[2])-3).",".substr($prices[2], -3);
					}					
					
					$PriceGroup[$count] = $price_front.$price_back;
				}elseif(($p != "") && ($num == 2)){
					$price_head = $prices[0]." ";
					if(strpos($prices[1], ",") > 0){
						$price_tail = $prices[1];
					}else{
						if(substr($prices[1], 0, 1) == "$"){
							$price_tail = substr($prices[1], 0, strlen($prices[1])-3).",".substr($prices[1], -3);
						}else{
							$price_tail = $prices[1];
						}
						
					}
					$PriceGroup[$count] = $price_head.$price_tail;
				}
				
				$Sizes[$count] = $size;

			  $count++;		
			}//end of foreach loop

			//contact method
			$contact_stats = array_count_values($contactHow);
			$cc = 2;
			foreach($contact_stats as $c_key => $c_val){
				if($c_key == "") $c_key = "No Entry";
				$contact_project[$cc] = array($c_key, $c_val); 
			  $cc++;
			}

			//layout
			$layout_stats = array_count_values($Layouts);
			$cl=2;
			foreach($layout_stats as $l_key => $l_val){
				if($l_key == "") $l_key = "No Entry";
				$layout_project[$cl] = array($l_key, $l_val);
			  $cl++;	
			}

			//price	
			$price_stats = array_count_values($PriceGroup);
			$cp=2;
			foreach($price_stats as $p_key => $p_val){
				if($p_key == "") $p_key = "No Entry";
				$price_project[$cp] = array($p_key, $p_val);
			  $cp++;
			}

			//size	
			$size_stats = array_count_values($Sizes);
			$cs=2;
			foreach($size_stats as $s_key => $s_val){
				if($s_key == "") $s_key = "No Entry";
				$size_project[$cs] = array($s_key, $s_val);
			  $cs++;
			}

			$arr = array(
				"returnContact" => $contact_project,
				"returnLayout" => $layout_project,
				"returnPrice" => $price_project,
				"returnSize" => $size_project
			);

			if (!function_exists('json_encode'))
			{
				$result = $this->json_encode($arr);
			}

			$result = json_encode($arr);
			echo $result;
		}else{
			redirect('login', 'refresh');
		}

	}
	
	function regactivity(){
		if($this->session->userdata('logged_in')){
			$pjt_id = $_POST['project'];
			$upd_key="";

			//initiate dt create array
			$createdGroup = array();
			//initiate project id value string
			$project[0] = array("day", "Registered Numbers");

			//select data
			$c = 0;
			$sql="SELECT * FROM register WHERE id_project=".$pjt_id." AND created IS NOT NULL AND created != '0000-00-00 00:00:00' AND created != '0000-00-00' ORDER BY created ASC";
			$query = $this -> db -> query($sql);
			$results = $query->result();
			foreach($results as $row){	
				$created = $row->created;
				if(strpos($created, "-") > 0){
					$createdDate = substr($created, 0, 10);
				}elseif(strpos($created, "/") > 0){
					$dt_array = explode("/", $created);
					$year = $dt_array[2];
					$m = strlen($dt_array[0]);
					$d = strlen($dt_array[1]);
					if($m == 1){
						$month = "0".$dt_array[0];
					}elseif($m == 2){
						$month = $dt_array[0];
					}
					if($d == 1){
						$day = "0".$dt_array[1];
					}elseif($d == 2){
						$day = $dt_array[1];
					}
					
					$createdDate = $year."-".$month."-".$day;
				}

				$createdGroup[$c] = $createdDate;

			  $c++;
			}//end of foreach loop

			$daycounts = array_count_values($createdGroup);

			$count=1;
			foreach($daycounts as $dkey => $dval){
				$project[$count] = array($dkey, $dval);
			  $count++;
			}

			if(count($project) > 1){
			   $upd_key = "good";	
			}else{
			   $upd_key = "fail";
			   $project['numOfRecord'] = 'Empty'; 
			}
			
			if (!function_exists('json_encode'))
			{
				$result = $this->json_encode($project);
			}
			
			$result = json_encode($project);
			echo $result;
		}else{
			redirect('login', 'refresh');
		}
	}
	
	function updcampname(){
		if($this->session->userdata('logged_in')){
			$campaign_id = $_POST['campaign_id'];
			$subject_line = $_POST['subject_line'];
			
			$campdata = array(
				   'campaign_name' => $subject_line
				);
			$this->db->where('id', $campaign_id);
			$this->db->update('client_eblast_campaign', $campdata); 
			
			$arr = array(
							'msg' => 'success',
							'rtnCampId' => $campaign_id,
							'rtnSubjLine' => $subject_line
						);		
			
			if (!function_exists('json_encode'))
			{
				$result = $this->json_encode($arr);
			}
			
			$result = json_encode($arr);
			echo $result;
		}else{
			redirect('login', 'refresh');
		}		
	}
	
	function json_encode($a=false)
	{
		if (is_null($a)) return 'null';
		if ($a === false) return 'false';
		if ($a === true) return 'true';
		if (is_scalar($a))
		{
			if (is_float($a))
			{
				// Always use "." for floats.
				return floatval(str_replace(",", ".", strval($a)));
			}

			if (is_string($a))
			{
				static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
				return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
			}
			else
			return $a;
		}
		$isList = true;
		for ($i = 0, reset($a); $i < count($a); $i++, next($a))
		{
			if (key($a) !== $i)
			{
				$isList = false;
				break;
			}
		}
		$result = array();
		if ($isList)
		{
			foreach ($a as $v) $result[] = json_encode($v);
			return '[' . join(',', $result) . ']';
		}
		else
		{
			foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
			return '{' . join(',', $result) . '}';
		}
	}	
 
}
 
?>