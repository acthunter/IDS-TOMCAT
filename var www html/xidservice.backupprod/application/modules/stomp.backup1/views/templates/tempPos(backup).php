<script type="text/javascript">
	 var <?php echo $modal_id;?>_data;
	 var <?php echo $modal_id;?>_fdata;
	function <?php echo $modal_id;?>_trigger(fdata){
		console.log(fdata);
				<?php echo $modal_id;?>_fdata = fdata;
				$.ajax({
				url : "<?php echo site_url('')?>" + fdata['url'],
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function(data){
					<?php echo $modal_id;?>_data = data;
					$('#dt_userreqs').on('click', 'tr:not(:first)', function () {
							var udata = tab_userreqs.row($(this).index()).data();
							var fparam = { 'wfid': <?php echo $modal_id;?>_data['wfid'], 'xadmid': <?php echo $modal_id;?>_data['xadmid'],
								'id' : udata['id'], "ftype" : 'userreq.' + udata['mode'], 
								 'url':'userreq', 'reqtype':'read'};
							loadForm('modal_l2', fparam, true);
					});
					
					console.log(data);
					$('#wfid').val(data['wfid']);

					$('#progressbar').progressbar({value: data['currScore']/data['targetScore'], max: 1});
					$('#stagename').html((data['stage'] == 1)?'Review' : 'Approval');
					
					$('#currActor').html(jsonFlat(data['currActor']));
					$('#apprActor').html(jsonFlat(data['approval']));
					$('#initActor').html(jsonFlat(data['initiator']));
					$('#doneActor').html(arrFlat(data['doneActor']));
					
					$('#mode').val(data['admMode']);
					$('#cscore').val(data['currScore']);
					$('#tscore').val(data['targetScore']);
					$('#div_btn_<?php echo $modal_id;?> button').hide();
					for (val of data["eaction"]){
						$("#<?php echo $modal_id;?>_btn_" + val).show();
					}
					
					 tab_userreqs = $('#dt_userreqs').DataTable({ 
							"searching": false,
							"bPaginate": false,
						"order": [], 
						"ajax" : {
							url : "<?php echo site_url('')?>" + "stomp/xctest/userreq_list",
							data: {"xadmid" : data['xadmid']},
							type: "POST"
						},
						"columns" : [
						{"data":"id"},
						{"data":"curPos"},
						{"data":"xemployee"}
						],
						"columnDefs": [
						{  
							"targets": [ -1 ],
							"orderable": false
						}, 
						],
					});
			 }
			 });
			
		$('#progressbar').click(function(){
			var ctarget = $('#wfinfo');
			if (ctarget.hasClass('infohide'))
				ctarget.removeClass('infohide');
			else
				ctarget.addClass('infohide');
		});		
	
	}
	
	
	function <?php echo $modal_id;?>_reload(){
		 //var h_modal_content_id =  "<?php echo $modal_id;?>_trigger";
		 //var fn = window[h_modal_content_id];
		 //fn(<?php echo $modal_id;?>_fdata);
		 tab_userreqs.ajax.reload();
	}
	
	function <?php echo $modal_id;?>_submit(btype){
		$('#<?php echo $modal_id;?> #reqtype').val(btype);
		var jobdata = <?php echo $modal_id;?>_data;
		
		var isMandatory = ("reject,cancel".indexOf(btype) != -1);
		
		console.log(isMandatory);
		console.log(btype);
		if (true || isMandatory){
			var reason = prompt("Alasan", "");
			if (reason == null || reason.length < 5){
				return;
			}
		}
		
		
		$('#notes').val(reason);
		var fdata = $('#<?php echo $modal_id;?>_form').serialize();
		console.log(jobdata);
		console.log(fdata);
		
		var url = "<?php echo site_url('')?>wf/wfaction" ;
			$.ajax({
				url : url,
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function(data)
				{
					console.log(data);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Submit Fail');
				}
			});
		$('#<?php echo $modal_id;?>_content').modal('hide');
		tab_myjob.ajax.reload();
	}
	function <?php echo $modal_id;?>_addnew(){
		var fparam = {"ftype" : 'userreq.CP',  'url':'userreq', 'reqtype' : 'create',
		"xadmid": <?php echo $modal_id;?>_data['xadmid'],
		"wfid": <?php echo $modal_id;?>_data['wfid']};
		loadForm('modal_l2', fparam, true);
	}
	function jsonFlat(jstr){
		var obj = JSON.parse(jstr);
		var ret = "";
		for (var key in obj) {
			//ret += "<li style='display: inline;' class='auth_" + obj[key] + "'>" + key + "</li>";
			ret += "<li class='auth auth_" + obj[key] + "'>" + key + "</li>";
		}
		return ret ;
	}
	function arrFlat(astr){
		if (astr == null)
			return "";
		var obj = astr.split(",");
		var ret = "";
		for (var key of obj) {
			ret += "<li class='auth'>" + key + "</li>";
		}
		return ret ;
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

</style>
<div id="<?php echo $modal_id;?>_content" class="modal fade">
	<div class="modal-dialog ui-front" style="width: 95%;">
			<div class="modal-content" style="padding: 10px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" style="padding-left: 190px;">Perubahan Posisi(<label>aa</label>)</h3>
				</div>
				<div style="width: 400px;">
					<div class="progressbar" id="progressbar"><span id="stagename" style="position:absolute; margin-left:10px; margin-top:2px"></span></div>
				</div>
				<div>
					
					<form action="#" class="myForm" id="<?php echo $modal_id;?>_form"> 	
						<div id="wfinfo" class="">
						<label for="wfid">Wfid</label>
								<input name="wfid" id="wfid" readonly="true"  type="text" value="">
							
								<label for="mode">Mode</label>
								<input name="mode" id="mode" readonly="true"  type="text" value="">
							
							<br>
							<label for="currActor">Done</label> <ul id="doneActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
								<label for="currActor">Curr</label> <ul id="currActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
							
								<label for="apprActor">Appr</label>  <ul id="apprActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
					
						<label for="initActor">Init</label>  <ul id="initActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
						</div>
							
						
						<table cellpadding="" cellspacing="2" class="tabel" id="dt_userreqs" style="width: 100%"> 			
							<thead>
								<tr>
									<th>adm</th>
									<th>wf</th>
									<th>cActor</th>
								</tr>
							</thead>
						</table>
						<input name="status" id="status" class="form-control" type="hidden" >
						<input name="id" id="id" class="form-control" type="hidden" >
						<input name="reqid" id="reqid" class="form-control" type="hidden" >		
						<input name="notes" id="notes" class="form-control" type="hidden" >		
						<input name="reqtype" id="reqtype" class="form-control" type="hidden" >						
					<div class="modal-footer" id="div_btn_<?php echo $modal_id
					;?>">
						<div class="col-xs-6" style="text-align: left;">
						<button type="button" id="<?php echo $modal_id;?>_btn_add" onclick="<?php echo $modal_id;?>_addnew()" class="btn btn-primary">New</button>
						</div>
						<div class="col-xs-6">
						<button type="button" id="<?php echo $modal_id;?>_btn_submit" onclick="<?php echo $modal_id;?>_submit('submit')" class="btn btn-primary">Submit</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_cancel" onclick="<?php echo $modal_id;?>_submit('cancel')"class="btn btn-warning right">Cancel</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_approve" onclick="<?php echo $modal_id;?>_submit('approve')"class="btn btn-primary right">Approve</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_reject" onclick="<?php echo $modal_id;?>_submit('reject')"class="btn btn-warning right">Reject</button>
						</div>
					</div>
					</form>
				</div>	
			</div>
		</div>
	</div>