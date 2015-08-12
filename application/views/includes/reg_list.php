<div class="row">
	<div class="medium-18 columns">
		<table width="100%" cellspacing="0" cellpadding="15" style="border-top:1px solid #333333;margin:0;">
			<tr><td style="line-height: 1rem;padding:0;">&nbsp;</td></tr>
		</table>
		<table width="100%" cellspacing="0" cellpadding="15" border="1">
		<thead>
			<tr>
				<th width="5%" id="func_title" class="hide-for-small">del</th>
				<th width="20%">full name</th>
				<th width="10%">city</th>
				<th width="10%" class="hide-for-small">postal code</th>
				<th width="20%">hear</th>
				<th width="10%" class="hide-for-small">contact</th>
				<th width="10%" class="hide-for-small">contact how</th>
				<th width="15%">created</th>
			</tr>
		</thead>
		<tbody>	
			<?php
				if(isset($results) && (count($results) > 0)){
				foreach($results as $row){
					$reg_id = $row->id_register;
					$salutation = $row->salutation;
					$first_name = $row->first_name;
					$last_name = $row->last_name;
					$address = $row->address;
					$city = $row->city;
					$province = $row->province;
					$postal_code = $row->postal_code;
					$realtor = $row->realtor;
					$work_with_realtor = $row->work_with_realtor;
					$telephone = $row->telephone;
					$email = $row->email;
					$layout = $row->layout;
					$size = $row->size;
					$price = $row->price;
					$age = $row->age;
					$rent_own = $row->rent_own;
					$hear = $row->hear;
					$contact = $row->contact;
					$contact_how = $row->contact_how;
					$comments = '';
					$comment_flag = $row->comment_flag;
					$org_comments = $row->comments;
					//select comment log
					$this->db->select('comment');
					$this->db->from('comment_log');
					$this->db->where('id_register', $reg_id);
					$this->db->order_by('dt_created', 'desc');
					$this->db->limit(1);
					$query = $this->db->get();
					if($query->num_rows() == 1){
						$comment_result = $query->result();
						foreach($comment_result as $cmtresult){
							$comments = $cmtresult->comment;
						}
					}else{
						$comments = $org_comments;
					}
					$created = $row->created;
			?>
				<tr id="row<?php echo $reg_id; ?>">
					<td class="line info<?php echo $reg_id; if(isset($client_id) && ($client_id == $reg_id)){ echo ' brightGrey'; } ?> hide-for-small" id="itemlist"><input type="checkbox" class="reglist" id="reg<?php echo $reg_id; ?>" alt="edit" name="reg<?php echo $reg_id; ?>" value="<?php echo $reg_id; ?>"/></td>
					<td class="line info<?php echo $reg_id; if(isset($client_id) && ($client_id == $reg_id)){ echo ' brightGrey'; } ?>" alt="<?php echo $reg_id; ?>"><?php 
							if(isset($comment_flag)){ 
								if($comment_flag == "need to follow up"){ 
									echo '<img src="'.$base_url.'asset/images/follow-flag.png" alt="need to follow up" style="width:16px;height:17px;" border="0"/> '; 
								}elseif($comment_flag == "no need to follow up"){ 
									echo '<img src="'.$base_url.'asset/images/nofollow-flag.png" alt="no need to follow up" style="width:16px;height:17px;" border="0"/> ';
								}
							}//end of  if(isset($comment_flag))
							
							echo $first_name." ".$last_name; ?></td>
					<td class="line info<?php echo $reg_id; if(isset($client_id) && ($client_id == $reg_id)){ echo ' brightGrey'; } ?>" alt="<?php echo $reg_id; ?>"><?php echo $city; ?></td>
					<td class="line info<?php echo $reg_id; if(isset($client_id) && ($client_id == $reg_id)){ echo ' brightGrey'; } ?> hide-for-small" alt="<?php echo $reg_id; ?>"><?php echo $postal_code; ?></td>
					<td class="line info<?php echo $reg_id; if(isset($client_id) && ($client_id == $reg_id)){ echo ' brightGrey'; } ?>" alt="<?php echo $reg_id; ?>"><?php echo $hear; ?></td>
					<td class="line info<?php echo $reg_id; if(isset($client_id) && ($client_id == $reg_id)){ echo ' brightGrey'; } ?> hide-for-small" alt="<?php echo $reg_id; ?>"><?php echo $contact; ?></td>
					<td class="line info<?php echo $reg_id; if(isset($client_id) && ($client_id == $reg_id)){ echo ' brightGrey'; } ?> hide-for-small" alt="<?php echo $reg_id; ?>"><?php echo $contact_how; ?></td>
					<td class="line info<?php echo $reg_id; if(isset($client_id) && ($client_id == $reg_id)){ echo ' brightGrey'; } ?>" alt="<?php echo $reg_id; ?>"><?php echo $created; ?></td>
				</tr>
				<tr id="desc<?php echo $reg_id; ?>" class="<?php if(isset($client_id) && ($client_id == $reg_id)){ echo ''; }else{ echo 'reg_details'; }?>">
					<td class="desc_item" colspan="8">
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td id="errorMsg"></td>
							</tr>
							<tr>
								<td class="desc_item">
									<div class="row">
										<div class="medium-7 columns">
										<br>
											<div class="row">
												<div class="small-6 columns"><span class="right-left">title: </span></div>
												<div class="small-12 columns" id="salutation<?php echo $reg_id; ?>"><?php echo $salutation; ?></div>
											</div>										
											<div class="row">
												<div class="small-6 columns"><span class="right-left">first name: </span></div>
												<div class="small-12 columns" id="first_name<?php echo $reg_id; ?>"><?php echo $first_name; ?></div>
											</div>
											<div class="row">
												<div class="small-6 columns"><span class="right-left">last name: </span></div>
												<div class="small-12 columns" id="last_name<?php echo $reg_id; ?>"><?php echo $last_name; ?></div>
											</div>
											<div class="row">
												<div class="small-6 columns"><span class="right-left">address: </span></div>
												<div class="small-12 columns" id="address<?php echo $reg_id; ?>"><?php echo $address; ?></div>
											</div>
											<div class="row">
												<div class="small-6 columns"><span class="right-left">city: </span></div>
												<div class="small-12 columns" id="city<?php echo $reg_id; ?>"><?php echo $city; ?></div>
											</div>
											<div class="row">
												<div class="small-6 columns"><span class="right-left">postal code: </span></div>
												<div class="small-12 columns" id="postal_code<?php echo $reg_id; ?>"><?php echo $postal_code; ?></div>
											</div>
											<div class="row">
												<div class="small-6 columns"><span class="right-left">realtor: </span></div>
												<div class="small-12 columns" id="realtor<?php echo $reg_id; ?>"><?php echo $realtor; ?></div>
											</div>
											<div class="row">
												<div class="small-6 columns"><span class="right-left">work with realtor: </span></div>
												<div class="small-12 columns" id="work_with_realtor<?php echo $reg_id; ?>"><?php echo $work_with_realtor; ?></div>
											</div>												
										</div>									
										<div class="medium-7 columns">
                    <br class="hide-for-small">
											<div class="row">
												<div class="small-6 columns"><span class="right-left">tel:</span></div>
												<div class="small-12 columns" id="telephone<?php echo $reg_id; ?>"><?php echo $telephone; ?></div>
											</div>										
											<div class="row">
												<div class="small-6 columns"><span class="right-left">email: </span></div>
												<div class="small-12 columns" id="email<?php echo $reg_id; ?>"><?php echo $email; ?></div>
											</div>
											<div class="row">
												<div class="small-6 columns"><span class="right-left">layout: </span></div>
												<div class="small-12 columns" id="layout<?php echo $reg_id; ?>"><?php echo $layout; ?></div>
											</div>
											<div class="row">
												<div class="small-6 columns"><span class="right-left">size: </span></div>
												<div class="small-12 columns" id="size<?php echo $reg_id; ?>"><?php echo $size; ?></div>
											</div>
											<div class="row">
												<div class="small-6 columns"><span class="right-left">price: </span></div>
												<div class="small-12 columns" id="price<?php echo $reg_id; ?>"><?php echo $price; ?></div>
											</div>
											<div class="row">
												<div class="small-6 columns"><span class="right-left">age: </span></div>
												<div class="small-12 columns" id="age<?php echo $reg_id; ?>"><?php echo $age; ?></div>
											</div>
											<div class="row">
												<div class="small-6 columns"><span class="right-left">hear: </span></div>
												<div class="small-12 columns" id="hear<?php echo $reg_id; ?>"><?php echo $hear; ?></div>
											</div>											
											<div class="row">
												<div class="small-6 columns"><span class="right-left">rent/own: </span></div>
												<div class="small-12 columns" id="rent_own<?php echo $reg_id; ?>"><?php echo $rent_own; ?></div>
											</div>
											<div class="row">
												<div class="small-6 columns"><span class="right-left">contact method: </span></div>
												<div class="small-12 columns" id="contact_how<?php echo $reg_id; ?>"><?php echo $contact_how; ?></div>
											</div>	
										</div>
										<div class="medium-4 columns">
                    <br>
											<div class="row">
												<div class="medium-18 columns"><strong>Comments:</strong><br><?php if(isset($comments) && ($comments != '')){ echo $comments; }else{ echo '&nbsp;'; } ?><br><br></div>
												<div class="medium-18 columns">
                        <div class="row">
														<div class="medium-18 columns" id="button<?php echo $reg_id; ?>">
															<input type="button" class="button" id="edit<?php echo $reg_id; ?>" name="edit" onclick="return editReg(this.id, <?php echo $developer; ?>, <?php echo $project; ?>);" value="edit"/>
														</div>
													</div>
													<div class="row">
														<div class="medium-18 columns" id="logWrap<?php echo $reg_id; ?>">
															<input type="submit" class="button" name="comment_log" value="log"/>
															<input type="hidden" class="regIds" id="reg_id<?php echo $reg_id; ?>" name="<?php if(isset($client_id) && ($client_id == $reg_id)){ echo 'selected_reg_id'; }else{ echo 'reg_id'; } ?>" value="<?php echo $reg_id; ?>"/>
														</div>
                       </div>
													
													</div>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php	
				}//end of foreach
			}
			?>
		</tbody>		
		</table>
	</div>
</div>
<div class="row">
	<div class="medium-15 columns">
		<div class="row">
			<div class="medium-3 medium-centered columns">
				<select id="limit" name="limit">
				<?php 
					$num = ceil($num_results/50);
					for($i=0;$i<$num;$i++){
						if($limit == $i){
				?>
							<option selected="selected" value="<?php echo $i; ?>"><?php echo $i+1; ?></option>
				<?php
						}else{
				?>
							<option value="<?php echo $i; ?>"><?php echo $i+1; ?></option>
				<?php			
						}

					}	
				?>
				</select>	
			</div>
		</div>
	</div>
	<div class="medium-3 columns" style="text-align:right;">
		<?php 
		$session_data = $this->session->userdata('logged_in');
		$permission = $session_data['permission'];
		if($permission == 5){
			echo '&nbsp;';
		}else{
		?>
			<a href="<?php echo $base_url; ?>home/download/<?php echo $developer; ?>/<?php echo $project; ?>"><img src="<?php echo $base_url; ?>asset/images/excel_download.png" alt="download" border="0"/></a>
		<?php	
		}
		?>
	</div>
</div>