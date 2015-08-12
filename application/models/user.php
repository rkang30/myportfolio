<?php
Class User extends CI_Model
{

	function login($username, $password)
	{
		$this->load->library('encrypt');
		$query = $this->db->get_where('pbm_users', array('user' => $username, 'active' => 'Y'), 1);

		if($query -> num_rows() == 1)
		{
			$results = $query->result();
			foreach($results as $row){
				$enc_password = $row->pass;
				$dec_pass = $this->encrypt->decode($enc_password);
			}//end of foreach
			
			if($password == $dec_pass){
				return $results;
			}else{
				return false;
			}			
			
		}
		else
		{
		 return false;
		}
	}

	
}
?>