		<input type="hidden" id="selected_project" name="selected_project" value="<?php if(isset($project) && ($project != "")){ echo $project; }else{ echo ''; } ?>"/>
		<input type="hidden" id="user_level" name="user_level" value="<?php if(isset($permission) && ($permission != "")){ echo $permission; }else{ echo ''; } ?>"/>
		<script>
			$(document).ready(function(){
				var data = jQuery.parseJSON('<?php echo json_encode($project_names); ?>');
				$("#developer option:selected").each(function(){
					var devSel = $(this).val();
					var selectedProj = $("#selected_project").val();
					var permission = $("#user_level").val();
					var count = 0;
					
					if(permission != 5){
						$("#project").html('<option value="" selected="selected"> select project </option>');
					}else{
						$("#project").html('');
					}
					
					$.each(data, function(i, v){
						if(i == devSel){
							$.each(v, function(k, l){
								if(selectedProj != ""){
									if(selectedProj == k){
										$("#project").append('<option value="'+k+'" selected="selected">'+l+'</option>');
									}else{
										$("#project").append('<option value="'+k+'">'+l+'</option>');
									}
								}else{
									$("#project").append('<option value="'+k+'">'+l+'</option>');
								  count++;
								}
							});
						}
					});//end of each
				});
				
				$("#developer").change(function(){
					var permission = $("#user_level").val();
					if(permission != 5){
						$("#project").html('<option value="" selected="selected"> select project </option>');
					}else{
						$("#project").html('');
					}			
					$("#developer option:selected").each(function(){
						var devSel = $(this).val();
						$.each(data, function(i, v){
							if(i == devSel){
								$.each(v, function(k, l){
									$("#project").append('<option value="'+k+'">'+l+'</option>');
								});
							}
						});
					});		
					
				});
				
				//selected dev/pro navigation
				showNav("reg_views_link", "home");
				showNav("reg_analys_link", "analytics");
				showNav("eblast_analys_link", "eblasts");
				showNav("eblast_name_link", "eblastnames");
				showNav("eblast_reg_export_link", "regexport");

				$("#developer").change(function(){
					var selDev = $("#developer option:selected").val();
					var selPro = $("#project option:selected").val();
					var devPros = {};
					devPros['developer'] = selDev;
					devPros['project'] = selPro;			
					showNav("reg_views_link", "home");
					showNav("reg_analys_link", "analytics");
					showNav("eblast_analys_link", "eblasts");
					showNav("eblast_name_link", "eblastnames");
					showNav("eblast_reg_export_link", "regexport");
				});
				
				$("#project").change(function(){
					var selDev = $("#developer option:selected").val();
					var selPro = $("#project option:selected").val();
					var devPros = {};
					devPros['developer'] = selDev;
					devPros['project'] = selPro;			
					showNav("reg_views_link", "home");
					showNav("reg_analys_link", "analytics");
					showNav("eblast_analys_link", "eblasts");
					showNav("eblast_name_link", "eblastnames");
					showNav("eblast_reg_export_link", "regexport");
				});			
				
				//search filters
				$(".filter_field1").prop("disabled", true);
				$(".filter_field2").prop("disabled", true);
				$(".filter_field3").prop("disabled", true);
				var filter1 = $("#post_filter1").val();
				var filter2 = $("#post_filter2").val();
				var filter3 = $("#post_filter3").val();
				if(filter1 != ""){
					var item = $("#post_filter1").attr('alt');
					var value = filter1;
					$(".respond1").hide();
					$("#filter1").find('option:selected').prop("selected",false);
					if(value != ""){
						console.log("1: "+item);
						$("#filter1 option[value='"+item+"']").prop("selected",true);
						$("#search_"+item+"1").prop("disabled", false);
						$("#"+item+"1").show();
					}
				}
				if(filter2 != ""){
					var item = $("#post_filter2").attr('alt');
					var value = filter2;
					$(".respond2").hide();
					$("#filter2").find('option:selected').prop("selected",false);
					if(value != ""){
						console.log("2: "+item);
						$("#filter2 option[value='"+item+"']").prop("selected",true);
						$("#search_"+item+"2").prop("disabled", false);
						$("#"+item+"2").show();
					}
				}
				if(filter3 != ""){
					var item = $("#post_filter3").attr('alt');
					var value = filter3;
					$(".respond3").hide();
					$("#filter3").find('option:selected').prop("selected",false);
					if(value != ""){
						console.log("3: "+item);
						$("#filter3 option[value='"+item+"']").prop("selected",true);
						$("#search_"+item+"3").prop("disabled", false);
						$("#"+item+"3").show();
					}
				}
				
				$(".search_opt").change(function(){
					var id = $(this).attr('id');
					showFilter(id);
				});
				
				//toggle description
				$(".line").click(function(){
					var id = $(this).attr('alt');
					openDesc(id);
				});
				
				//limit
				$("#limit").change(function(){
					$("#engine_form").submit();
				});

			}); // end of document ready
			
			//show nav link
			function showNav(obj, path, cat){
				var selDev = $("#developer option:selected").val();
				var selPro = $("#project option:selected").val();
				if((selDev != "") && (selPro != "")){
					$("#"+obj).prop("href", "/"+path+"/index/"+selDev+"/"+selPro);
				}else{
					$("#"+obj).prop("href", "/"+path+"/index");
				}
			}
			
			//search filters
			function showFilter(obj){
				var len = obj.length;
				var n = obj.substr(len-1, 1);
				var selectedOpt = $("#"+obj+" option:selected").val();
				$(".filter_field"+n).each(function(){
					var id = $(this).attr('id');
					if($("#"+id).is("input")){
						$("#"+id).val('');
					}else{
						$("#"+id+" option").prop("selected", false);
					}
				});
				$(".respond"+n).hide();
				$("#"+selectedOpt+n).show();
				$("#search_"+selectedOpt+n).prop("disabled", false);
			}	
			
			function openDesc(obj){
				$(".line").each(function(i){
					var alt = $(this).attr('alt');
					if(alt != obj){
						$(".info"+alt).removeClass('brightGrey');
						$("#desc"+alt).hide();
					}
				});
				$(".info"+obj).toggleClass('brightGrey');
				$("#desc"+obj).toggle("slow");
				$(".regIds").prop("name", "reg_id");
				$("#reg_id"+obj).prop("name", "selected_reg_id");
			}
			
			//campaign name edit,save
			function editCamp(obj){
				var num = obj.length;
				var id = obj.substr(8, num-8);
				var camp_name = $("#campField"+id).html();
				$("#campField"+id).html('<input type="text" id="edit_camp_name'+id+'" name="edit_camp_name'+id+'" value="'+camp_name+'"/>');
				$("#actionWrap"+id).html('<input type="button" id="campSave'+id+'" class="button" name="save_camp'+id+'" value="save" onclick="return saveCamp(this.id);"/>');
			}
			
			function saveCamp(obj){
				var num = obj.length;
				var id = obj.substr(8, num-8);//campaign id
				var subject_line = $("#edit_camp_name"+id).val();
				var action = '<?php echo $base_url; ?>programs/updcampname';
				var dataCarrier = '<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&campaign_id='+id+'&subject_line='+subject_line;
				$.ajax({
					type: "post",
					url: action,
					data:dataCarrier,
					cache: false,
					success: function(html){
						var data = jQuery.parseJSON(html);
						if(data.msg == 'success'){
							var returnedId = data.rtnCampId;
							var returnedSubject = data.rtnSubjLine;
							$("#campField"+returnedId).html(returnedSubject);
							$("#actionWrap"+returnedId).html('<input type="button" id="campEdit'+returnedId+'" class="button" name="edit_camp'+returnedId+'" value="edit" onclick="return editCamp(this.id);"/>');
						}
					}
				});
				
			}
			
			function editReg(obj, devId, proId){
				var len = obj.length-4;
				var regId = obj.substr(4, len);
				$("#button"+regId).html('<input type="button" class="button" id="save'+regId+'" name="save" onclick="return saveReg(this.id, '+devId+', '+proId+');" value="save"/>'); 
				var action = '<?php echo $base_url; ?>programs/getcriteria';
				var dataCarrier = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&id_developer="+devId+"&id_project="+proId;
				$.ajax({ // this is for salutation, first_name, last_name, address, city, postal_code, telephone, email, layout, size, price, age, hear, rent_own, contact_how
					type: "post",
					url: action,
					data: dataCarrier,
					cache: false,
					success: function(html){
						var data = jQuery.parseJSON(html);
						if(data.msg == "success"){
							var returnedCrt = data.returnCriteria;
							var fields = ["salutation", "first_name", "last_name", "address", "city", "postal_code", "realtor", "work_with_realtor", "telephone", "email", "layout", "size", "price", "age", "hear", "rent_own", "contact_how"];
							$.each(returnedCrt, function(k, m){
							//k = key
							var orgn_val = $("#"+k+regId).html();					
								$.each(m, function(t, n){
									//t = type
									if(t == "select"){
										$("#"+k+regId).html('<select id="sel_'+k+regId+'" name="sel_'+k+regId+'"></select>');
										$("#sel_"+k+regId).append('<option value=""> select one </option>');
									}else if(t == "input"){
										$("#"+k+regId).html('<input type="text" id="inp_'+k+regId+'" name="inp_'+k+regId+'" value="'+orgn_val+'"/>');
									}
									
									$.each(n, function(s, v){
									//v = value
										if(t == "select"){
											if(orgn_val == v){
												$("#sel_"+k+regId).append('<option selected="selected" value="'+v+'">'+v+'</option>');
											}else{
												$("#sel_"+k+regId).append('<option value="'+v+'">'+v+'</option>');
											}								
										}
									});
								});
							});

						}//end of msg = success
					}// end of success
				});//end of ajax - layout, size, price, age, hear
				
			  return false;
			}
			
			function saveReg(obj, devId, proId){
				var len = obj.length-4;
				var regId = obj.substr(4, len);
				var action = '<?php echo $base_url; ?>programs/updateReg';
				var carriers = [];
				carriers.push("reg_id="+regId+"&developer="+devId+"&project="+proId);

				var fields = ["salutation", "first_name", "last_name", "address", "city", "postal_code", "realtor", "work_with_realtor", "telephone", "email", "layout", "size", "price", "age", "hear", "rent_own", "contact_how"];
				for(var i=0;i<fields.length;i++){
					var key = fields[i];
					if ($("#inp_"+key+regId).length > 0){
						var value = $("#inp_"+key+regId).val();
						value = value.replace(/\+/g, ''); //remove plus
						value = value.replace(/'/g, "\\'"); //add slashes for '
						value = value.replace(/"/g, '\\"'); //add slashes for "
						carriers.push(key+"="+value);				
					}else if($("#sel_"+key+regId).length > 0){
						var value = $("#sel_"+key+regId+" option:selected").val();
						value = value.replace(/\+/g, ''); //remove plus
						value = value.replace(/'/g, "\\'"); //add slashes for '
						value = value.replace(/"/g, '\\"'); //add slashes for "
						carriers.push(key+"="+value);				
					}

				}//end of for loop		
				var dataStr = carriers.join("&");
					dataStr = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&"+dataStr
				//ajax
				$.ajax({
					type: "post",
					url: action,
					data: dataStr,
					cache: false,
					success: function(html){
						var data = jQuery.parseJSON(html);
						if(data.msg == "success"){
							var retrndRegId = data.rtnRegId;
							var returnDevId = data.rtnDevId;
							var returnProId = data.rtnProId;
							
							//$(".info"+retrndRegId).removeClass("brightGrey");
							var fields = ["salutation", "first_name", "last_name", "address", "city", "postal_code", "realtor", "work_with_realtor", "telephone", "email", "layout", "size", "price", "age", "hear", "rent_own", "contact_how"];
							
							$.each(fields, function(i, el){
								if($("#inp_"+el+retrndRegId).length > 0){
									var value = $("#inp_"+el+retrndRegId).val();
									$("#"+el+retrndRegId).html(value);						
								}else if($("#sel_"+el+retrndRegId).length > 0){
									var value = $("#sel_"+el+retrndRegId+" option:selected").val();
									if((value == "") || (value == "undefined")){
										$("#"+el+retrndRegId).html('');
									}else{
										$("#"+el+retrndRegId).html(value);
									}							
								}
						
							});
							
							//button - change back to edit
							$("#button"+retrndRegId).html('<input type="button" class="button" id="edit'+retrndRegId+'" name="edit" onclick="return editReg(this.id, '+returnDevId+', '+returnProId+');" value="edit"/>');
							
							//$("#desc"+retrndRegId).hide('slow');
							alert("Successfully updated");
						}else{
							var rtnErrors = data.returnErrors;
							var rtndRegId = data.rtnRegId;
							$.each(rtnErrors, function(i, v){
								console.log("index: "+i+" value: "+v);
								if($("#sel_"+i+rtndRegId).length > 0){
									$("#sel_"+i+rtndRegId).css("border", "1px solid red");
								}else if($("#inp_"+i+rtndRegId).length > 0){
									$("#inp_"+i+rtndRegId).css("border", "1px solid red");	
								}
								
							});
						}
					}
				});
				
			  return false;
			}
			
			function delReg(){
				var action = '<?php echo $base_url; ?>programs/removeReg';
				var dataCarrier = $('.reglist:checked').serialize();
				dataCarrier = "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&"+dataCarrier;
				$.ajax({
					type: "post",
					url:action,
					data:dataCarrier,
					cache:false,
					success: function(html){
						var data = jQuery.parseJSON(html);
						if(data.msg == "success"){
							var removedId = data.rtnRegId;
							$.each(removedId, function(i, v){
								$("#row"+v).hide('slow');
							});
							alert("successfully removed");
						}
					}
				});
			  return false;	
			}

			function iconVisiability(){
				var winW = $(window).width();
				if(winW <= 640){
					$("#icon_wrapper .menu-icon").html('<div><div></div></div>');
				}else{
					$("#icon_wrapper .menu-icon").html('&nbsp;');
				}	
			}
			
			$(document).foundation();	
		</script> 
		</div><!-- end of fullheight_wrapper -->
		</form><!-- end of nav engine form -->		
	</section><!-- end of main section -->	

<div class="row">
  <div class="large-18 columns"><p id="copyright-footer">&copy; pb marketing ltd. <?php echo date("Y"); ?></p></div>
</div><!--/.row-->

<div class="back-to-top"><a></a></div>
</body>
</html>