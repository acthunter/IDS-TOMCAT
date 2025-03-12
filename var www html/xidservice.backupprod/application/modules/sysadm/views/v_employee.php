<!DOCTYPE html>
<html>
<head> 
	<style type="text/css">
		.ui-autocomplete { height: 300px; overflow-y: scroll; overflow-x: hidden;}
		.width100 { width: 100px; }
		#vote_buttons {
		cursor:pointer;
		cursor:hand;
		}
		.center_div{
    margin: 0 auto;
    width:80% /* value of your choice which suits your alignment */
	
}
	</style>
</head> 
<body >
<div class="row"  style="width: 101%; background-color: #FFFFFF;">
<div class="container center_div" style="width: 100%;">
<br><br>
	<form action="#" id="modal_form"  style="width: 100%;" role="form" class="form-horizontal"> 				
		<div class="form-group row">
		<div class="col-xs-1"></div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Login ID</label></div>
			<div class="col-xs-2">
			<div class="input-group">	
				<input name="loginid" id="loginid" placeholder="LoginID" class="form-control" onchange="query_npp()" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
				<span id="btn_save" onclick="query_npp()" class="input-group-addon">
					<a href="#"><i class="fa fa-search"></i></a>
				</span>
			</div>
			</div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Login ID syariah</label></div>
			<div class="col-xs-2">
			<div class="input-group">	
				<input name="npp" id="npp" placeholder="NPP"  class="form-control" onchange="query_npp()" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
				<span id="btn_save" onclick="query_npp()" class="input-group-addon">
					<a href="#"><i class="fa fa-search"></i></a>
				</span>
			</div>
			</div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Active</label></div>
			<div class="col-xs-2">
				<select name="active" id="active" placeholder="Active" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
				  <option disabled selected value="null"> -- select an option -- </option>
				  <option value="0">not active</option>
				  <option value="1">active</option>
				</select>									
			</div>			
		</div>
		<div class="form-group row">
		<div class="col-xs-1"></div>			
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Name</label></div>
			<div class="col-xs-2">	
				<input name="Name" id="Name" placeholder="Name" class="form-control" type="text" style="height: 27px; font-size: 90%">
			</div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">DOB</label></div>
			<div class="col-xs-2">	
				<input name="DOB" id="DOB" placeholder="DOB" class="form-control" type="text" style="height: 27px; font-size: 90%">
			</div>			
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Cpwd</label></div>
			<div class="col-xs-2">	
				<select name="cpwd" id="cpwd" placeholder="Cpwd" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
					<option disabled selected value="null"> -- select an option -- </option>
					<option value="0">not active</option>
					<option value="1">active</option>
				</select>			
			</div>			
		</div>
		
		<div class="form-group row">
		<div class="col-xs-1"></div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">WorkOffice</label></div>
			<div class="col-xs-2">	
				<input name="workOffice" id="workOffice" placeholder="WorkOffice" class="form-control" type="text" style="height: 27px; font-size: 90%">
			</div>
		<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Manager</label></div>
			<div class="col-xs-2">	
				<input name="manager" id="manager" placeholder="Manager" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
			</div>									
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Expired</label></div>
			<div class="col-xs-2">	
				<input name="expired" id="expired" placeholder="Expired" class="form-control" type="text" style="height: 27px; font-size: 90%">
			</div>
		</div>

		<div class="form-group row">
		<div class="col-xs-1"></div>								
		<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Email</label></div>
			<div class="col-xs-2">	
				<input name="email" id="email" placeholder="Email" class="form-control" type="text" style="height: 27px; font-size: 90%">
			</div>
		<div class="col-xs-1"><label style="height: 27px; font-size: 90%">AccOffice</label></div>
			<div class="col-xs-2">	
				<input name="accOffice" id="accOffice" placeholder="AccOffice" class="form-control" type="text" style="height: 27px; font-size: 90%">
			</div>
		<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Enabled</label></div>
			<div class="col-xs-2">	
			<select name="enabled" id="enabled" placeholder="Enabled" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
				<option disabled selected value="null"> -- select an option -- </option>
				<option value="0">Disabled</option>
				<option value="1">Enabled</option>
			</select>
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-xs-1"></div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Password</label></div>
				<div class="col-xs-2">	
					<input name="password" id="password" placeholder="Password" class="form-control" type="text" style="height: 27px; font-size: 90%">
				</div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">NPP login</label></div>
				<div class="col-xs-2">	
					<input name="nl" id="nl" placeholder="NPP Login" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
				</div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">PasswordHistory</label></div>
				<div class="col-xs-2">	
					<input name="passwordHistory" id="passwordHistory" placeholder="PasswordHistory" class="form-control" type="text" style="height: 27px; font-size: 90%" readonly>
				</div>
		</div>
		
		<div class="form-group row">
			<div class="col-xs-1"></div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Created</label></div>
				<div class="col-xs-2">	
					<input name="created" id="created" placeholder="Created" class="form-control" type="text" style="height: 27px; font-size: 90%" readonly>
			</div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Base Position ID</label></div>
				<div class="col-xs-2">					        
					<input name="bpi" id="bpi" placeholder="Base Position ID" class="form-control" type="text" style="height: 27px; font-size: 90%">
				</div>									
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Next allowed attempt</label></div>
			    <div class="input-group col-xs-2"style="padding-right: 15px;padding-left: 15px;">
				<span class="input-group-addon">
				  <input type="checkbox" id ="null">
				</span>
				<input name="naa" id="naa" class="form-control" placeholder="Next allowed attempt"  type="text" style=" font-size: 90%">
			  </div>
		</div>
		<div class="form-group">
			<div class="col-xs-1"></div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Mobile Number</label></div>
				<div class="col-xs-2">					        
					<input name="mn" id="mn" placeholder="Mobile Number" class="form-control" type="text" style="height: 27px; font-size: 90%">
				</div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">PasswordExpired</label></div>
				<div class="col-xs-2">	
					<input name="passwordExpired" id="passwordExpired" placeholder="PasswordExpired" class="form-control" type="text" style="height: 27px; font-size: 90%">
				</div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Fail Count</label></div>
				<div class="col-xs-2">					        
					<input name="failcount" id="failcount" placeholder="Fail Count" class="form-control" type="text" style="height: 27px; font-size: 90%">
				</div>
		</div>
		
		<div class="form-group">
			<div class="col-xs-1"></div>								
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Position ID</label></div>
				<div class="col-xs-2">	
					<input name="positionid" id="positionid" placeholder="Position ID" class="form-control" onchange="query_npp()" type="text" style="height: 27px; font-size: 90%">
				</div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Enabled Login</label></div>
				<div class="col-xs-2">		
			<select name="el" id="el" placeholder="Enabled Login" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
				<option disabled selected value="null"> -- select an option -- </option>
				<option value="0">Disabled</option>
				<option value="1">Enabled</option>
			</select>				
				</div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Active Login</label></div>
				<div class="col-xs-2">	
					<input name="al" id="al" placeholder="Active Login" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
				</div>
		</div>
		<div class="form-group">
			<div class="col-xs-1"></div>
				<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Fposition ID</label></div>
					<div class="col-xs-2">	
						<input name="fpositionid" id="fpositionid" placeholder="Fposition ID" class="form-control" type="text" style="height: 27px; font-size: 90%">
					</div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Created Login</label></div>
				<div class="col-xs-2">					        
					<input name="cl" id="cl" placeholder="Created Login" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px" readonly>
				</div>									
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Locked</label></div>
			<div class="col-xs-2">	
				<select name="locked" id="locked" placeholder="Locked" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
					<option disabled selected value="null"> -- select an option -- </option>
					<option value="0">unlocked</option>
					<option value="1">locked</option>
				</select>			
			</div>
		</div>
		
		<div class="form-group">
		<div class="col-xs-1"></div>								
		<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Snpp</label></div>
		<div class="col-xs-2">					        
			<input name="snpp" id="snpp" placeholder="SNPP" class="form-control" type="text" style="height: 27px; font-size: 90%">
		</div>
		<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Expired xLogin</label></div>
		<div class="col-xs-2">
			<input name="expxl" id="expxl" placeholder="Expired xLogin" class=" form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
		</div>
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Login Expired</label></div>
			<div class="col-xs-2">					        
				<input name="lexp" id="lexp" placeholder="Login Expired" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
			</div>
		</div>
		
		<div class="modal-footer" id="div_btn_modal" style="padding-bottom: 0px;padding-top: 12px;border-bottom-width: 0px;margin-bottom: -11px;">
			<div class="col-xs-12" style="text-align: right;">
				<button type="button" id="btn_save" onclick="modal_submit()" class="btn btn-primary">Update</button>
				<button type="reset" class="btn btn-primary">Reset</button><br><br>
			</div>
		</div>
								

	</form>
</div>
</div>
<script type="text/javascript">
var nextallatt;
	$(document).ready(function(){
		$("#loginid").click(function(){
			$("input").val("");
			//$("input[type=select]").val("null");
			$(" select").val("null");
		});
		$('#null').click(function() {
						if(document.getElementById('null').checked) {
							$('#naa').val('');
						} else {
							$('#naa').val(nextallatt);
						}
					});
		
	});
	function query_npp()
		{		
		//alert($('[name="loginid"]').val());
			var url = "<?php echo site_url('query_em')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: { loginid: $('[name="loginid"]').val(), sloginid: $('[name="npp"]').val() },
				dataType: "JSON",
				success: function(data)
				{
					$('[name="npp"]').val(data.sloginid);
					$('[name="email"]').val(data.email);
					$('[name="Name"]').val(data.Name);
					$('[name="DOB"]').val(data.DOB);
					$('[name="accOffice"]').val(data.accOffice);
					$('[name="workOffice"]').val(data.workOffice);
					$('[name="manager"]').val(data.manager);
					$('[name="created"]').val(data.created);
					$('[name="active"]').val(data.active);
					$('[name="cpwd"]').val(data.cpwd);
					$('[name="enabled"]').val(data.enabled);
					$('[name="password"]').val(data.password);
					$('[name="passwordExpired"]').val(data.passwordExpired);
					$('[name="passwordHistory"]').val(data.passwordHistory);
					$('[name="expired"]').val(data.expired);
					$('[name="locked"]').val(data.locked);
					
					$('[name="failcount"]').val(data.failCount);
					$('[name="mn"]').val(data.mobileNumber);
					//USER EXPIRED
					$('[name="nl"]').val(data.NPPxl);
					$('[name="positionid"]').val(data.positionid);
					$('[name="fpositionid"]').val(data.fpositionid);
					$('[name="al"]').val(data.activexl);
					$('[name="el"]').val(data.enabledxl);
					$('[name="cl"]').val(data.createdxl);
					$('[name="bpi"]').val(data.basePositionid);
					$('[name="expxl"]').val(data.expiredxl);
					$('[name="lexp"]').val(data.loginExpired);
					$('[name="snpp"]').val(data.snpp);
					$('[name="naa"]').val(data.nextAllowedAttempt);
					nextallatt = data.nextAllowedAttempt;
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		};
		$(function () {
				$('#DOB').datetimepicker({
                    format: 'YYYY-MM-DD'
                });
                $('#passwordExpired, #expired, #naa, #expxl, #lexp').datetimepicker();
    });
	function modal_submit(){
		var url = "<?php echo site_url('update_employee')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: $('#modal_form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					alert('Data berhasil di update');
					$("#modal_form")[0].reset()
				}
			});
	};
</script>