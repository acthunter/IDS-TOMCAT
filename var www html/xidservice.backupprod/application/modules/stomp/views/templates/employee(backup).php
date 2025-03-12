<script type="text/javascript">
	
	function  <?php echo $modal_id;?>_trigger(fdata){
		console.log(fdata);
		$('#div_btn_<?php echo $modal_id;?> button').hide();
		if (fdata['reqtype'] != "new"){
			$.ajax({
					url : "<?php echo site_url('')?>" + fdata['url'],
					type: "POST",
					data: fdata,
					dataType: "JSON",
					success: function(wdata){
						var data = wdata['detail'];
						var rdata = data['data'];
						console.log(wdata);
						
						
						var lockInfo = "";
						if (wdata['locked'])
							lockInfo = " locked by " + wdata['lockActor'] + " -- " + wdata['lockDate'];
							
						$('#progressbar').progressbar({value: wdata['currScore']/wdata['targetScore'], max: 1});
						$('#stagename').html(wdata['pname'] + " (" + wdata['currScore'] + "/" + wdata['targetScore'] + ")");
						$('#lockinfo').html(lockInfo);
						
						$('#currActor').html(jsonFlat(wdata['currActor']));
						
						$('#doneActor').html(arrFlat(wdata['doneActor']));
						
						$('#id').val(wdata['id']);
						$('#wfid').val(data['wfid']);
						$('#mode').val(wdata['mode']);
						$('#nik').val(rdata['nik']);
						$('[name="nama"]').val(rdata.nama);
						$('#address').val(rdata['address']);
						$('#DOB').val(rdata['DOB']);
						
						$('#positionid').val(rdata['positionid']);
						$('#pname').val(rdata['pname']);
						$('#npp').val(rdata['npp']);
						$('#loginid').val(rdata['loginid']);
						
						if (wdata['stage'] != '1'){
							var arr_ro = "tposname,sdate,edate,loginid".split(",");
							console.log(arr_ro);
							for(cid of arr_ro){
								$('#' + cid).attr('readonly', true);
							}
						}
						
						$('#<?php echo $modal_id;?>_form #id').val(data['id']);
						
						for (val of wdata["eaction"]){
							$("#<?php echo $modal_id;?>_btn_" + val).show();
						}
					}
			});
		}
		else {
			$('#<?php echo $modal_id;?>_form #btn_save').show();
		}
		$("#<?php echo $modal_id;?> #pname").autocomplete({  
				minLength: "2",  
				source:   
				function(request, response){  
				console.log('test');
					$.ajax({  
						url: "<?php echo site_url('stomp/xids/pos_search')?>",  
						dataType: 'json',  
						type: 'POST',  
						data: {
							pattern: request.term
						}, 
						success:      
						function(data){  
							response($.map(data, function (item) {
								return {
									value: item.pname,
									rvalue: item
								}
							}))
						},  
					});  
				},
				select: function( event, ui ) {					
					$('#positionid').val(ui.item.rvalue.positionid);
				}	
			});
			
			$(function () {
				$('#DOB').datetimepicker({
					format:'DD-MM-YYYY'
				});
			});
		$('#progressbar').click(function(){
			var ctarget = $('#wfinfo');
			if (ctarget.hasClass('infohide'))
				ctarget.removeClass('infohide');
			else
				ctarget.addClass('infohide');
		});	
	};
		$(function () {
				$('#DOB').datetimepicker({
                    format: 'DD-MM-YYYY'
                });
                $('#passwordExpired, #expired, #naa, #expxl, #lexp').datetimepicker();
    });
	function <?php echo $modal_id;?>_submit(btype){
		var fdata = {'url': 'wf/wfaction', 'modal_id' : "<?php echo $modal_id;?>", 'btype': btype };
		action_submit(fdata);
	}	
	
	function query_npp()
		{		
			var url = "<?php echo site_url('stomp/xids/query_em')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: $('[name="loginid"]').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					$('[name="npp"]').val(data.NPP);
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
					$('[name="naa"]').val(data.nextAllowedAttempt);
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
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
</script>
<style>
	li.auth {text-align: center; width: 60px; float: left;}
	li.auth_1 { background-color: grey;}
	li.auth_2 { background-color: yellow;}
	li.auth_3 { background-color: green;}
	
	.infohide {
		display:none;
	}

	label {
    /* Other styling.. */
    text-align: right;
    clear: both;
    float:left;
    margin-right:15px;
}

</style>
<div class="container">
	<div class="row">
		<div id="<?php echo $modal_id;?>_content" class="modal fade">
			<div class="modal-dialog ui-front" style="width: %;">
				<div class="modal-content" style="padding: 10px;margin-right: 35px;">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<center><h3 class="modal-title" >User Request</h3></center>
					</div>
						<div class="modal-body form" style="right: -11px;">
							<form action="#" id="<?php echo $modal_id;?>_form" role="form" class="form-horizontal" style="overflow-y: scroll; overflow-x: hidden;height:400px;"> 				
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">LoginID</label>
									<div class="col-xs-10">	
										<input name="loginid" id="loginid" placeholder="LoginID" class="form-control" onchange="query_npp()" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">NPP</label>
									<div class="col-xs-10">	
										<input name="npp" id="npp" placeholder="NPP" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Email</label>
									<div class="col-xs-10">	
										<input name="email" id="email" placeholder="Email" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Name</label>
									<div class="col-xs-10">	
										<input name="Name" id="Name" placeholder="Name" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">DOB</label>
									<div class="col-xs-10">	
										<input name="DOB" id="DOB" placeholder="DOB" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">AccOffice</label>
									<div class="col-xs-10">	
										<input name="accOffice" id="accOffice" placeholder="AccOffice" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">WorkOffice</label>
									<div class="col-xs-10">	
										<input name="workOffice" id="workOffice" placeholder="WorkOffice" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Manager</label>
									<div class="col-xs-10">	
										<input name="manager" id="manager" placeholder="Manager" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Created</label>
									<div class="col-xs-10">	
										<input name="created" id="created" placeholder="Created" class="form-control" type="text" style="height: 27px; font-size: 90%" readonly>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Active</label>
									<div class="col-xs-10">	
										<input name="active" id="active" placeholder="Active" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Cpwd</label>
									<div class="col-xs-10">	
										<input name="cpwd" id="cpwd" placeholder="Cpwd" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Enabled</label>
									<div class="col-xs-10">	
										<input name="enabled" id="enabled" placeholder="Enabled" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Password</label>
									<div class="col-xs-10">	
										<input name="password" id="password" placeholder="Password" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">PasswordExpired</label>
									<div class="col-xs-10">	
										<input name="passwordExpired" id="passwordExpired" placeholder="PasswordExpired" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">PasswordHistory</label>
									<div class="col-xs-10">	
										<input name="passwordHistory" id="passwordHistory" placeholder="PasswordHistory" class="form-control" type="text" style="height: 27px; font-size: 90%" readonly>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Expired</label>
									<div class="col-xs-10">	
										<input name="expired" id="expired" placeholder="Expired" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Locked</label>
									<div class="col-xs-10">	
										<input name="locked" id="locked" placeholder="Locked" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Next allowed attempt</label>
									<div class="col-xs-10">					        
										<input name="naa" id="naa" placeholder="Next allowed attempt" class=" form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Fail Count</label>
									<div class="col-xs-10">					        
										<input name="failcount" id="failcount" placeholder="Fail Count" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Mobile Number</label>
									<div class="col-xs-10">					        
										<input name="mn" id="mn" placeholder="Mobile Number" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">NPP login</label>
									<div class="col-xs-10">	
										<input name="nl" id="nl" placeholder="NPP Login" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Position ID</label>
									<div class="col-xs-10">	
										<input name="positionid" id="positionid" placeholder="Position ID" class="form-control" onchange="query_npp()" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Fposition ID</label>
									<div class="col-xs-10">	
										<input name="fpositionid" id="fpositionid" placeholder="Fposition ID" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Active Login</label>
									<div class="col-xs-10">	
										<input name="al" id="al" placeholder="Active Login" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Enabled Login</label>
									<div class="col-xs-10">					        
										<input name="el" id="el" placeholder="Enabled Login" class=" form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Created Login</label>
									<div class="col-xs-10">					        
										<input name="cl" id="cl" placeholder="Created Login" class="form-control" type="text" style="height: 27px; font-size: 90%" readonly>
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Base Position ID</label>
									<div class="col-xs-10">					        
										<input name="bpi" id="bpi" placeholder="Base Position ID" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group">
								<label class="col-xs-1" style="height: 27px; font-size: 90%">Expired xLogin</label>
									<div class="col-xs-10">					        
										<input name="expxl" id="expxl" placeholder="Expired xLogin" class=" form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Login Expired</label>
									<div class="col-xs-10">					        
										<input name="lexp" id="lexp" placeholder="Login Expired" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								<div class="form-group">
									<label class="col-xs-1" style="height: 27px; font-size: 90%">Snpp</label>
									<div class="col-xs-10">					        
										<input name="snpp" id="snpp" placeholder="SNPP" class="form-control" type="text" style="height: 27px; font-size: 90%">
									</div>
								</div>
								
								<input name="id" id="id" class="form-control" type="hidden" >
								<input name="mode" id="mode" class="form-control" value="EM" type="hidden" >
								<input name="wfid" id="wfid" class="form-control" type="hidden" >	
								<input name="reqtype" id="reqtype" class="form-control" type="hidden" >	
								<input name="notes" id="notes" class="form-control" type="hidden" >		
							</form>
						</div>

						<div class="modal-footer">
							<div class="col-xs-3" style="text-align: left;">
								<button type="button" id="btn_save" onclick="<?php echo $modal_id;?>_submit('save')" class="btn btn-primary">Update</button>
							</div>
						</div>						
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>