<script type="text/javascript">
	var dt_rp_list;
	var xrpid;
	var rp_stage;
	
	function  <?php echo $modal_id;?>_trigger(fdata){
		console.log(fdata);
		$('#div_btn_<?php echo $modal_id;?> button').hide();
		
		$.ajax({
				url : "<?php echo site_url('')?>" + fdata['url'],
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function(wdata){
					var data = wdata['detail'];
					console.log(wdata);
					
					rp_stage = wdata['stage'];
					var lockInfo = "";
					if (wdata['locked'])
						lockInfo = " locked by " + wdata['lockActor'] + " -- " + wdata['lockDate'];
						
					$('#progressbar').progressbar({value: wdata['currScore']/wdata['targetScore'], max: 1});
					$('#stagename').html(wdata['pname'] + " (" + wdata['currScore'] + "/" + wdata['targetScore'] + ")");
					$('#lockinfo').html(lockInfo);
					
					$('#currActor').html(jsonFlat(wdata['currActor']));
					
					$('#doneActor').html(arrFlat(wdata['doneActor']));
					
					$('#wfid').val(wdata['id']);
					$('#mode').val(wdata['mode']);
					
					$('#<?php echo $modal_id;?>_form #id').val(wdata['id']);
					
					for (val of wdata["eaction"]){
						$("#<?php echo $modal_id;?>_btn_" + val).show();
					}
					
					dt_rp_list = $('#dt_rp_list').DataTable({ 
							//"retrieve": true,
							"processing": true, 
							"serverSide": true, 
							"order": [], 
							"ajax": {
								"url": "<?php echo site_url('stomp/xids/jobitemlist')?>",
								"type": "POST",
								"dataType": "JSON",
								"data" : {'wfid': wdata['id'],'rpid': data['id'], 'mode':'RP'}
							},
							"columns" : [
							{"data":"id"},
							{"data":"type"},
							{"data":"positionid"},
							{"data":"posname"},
							{"data":"status"},
							{"data":"name"},
							{"data":"mobileNumber"},
							],
							"columnDefs": [
							{  
								"targets": [ -1 ],
								"orderable": false, 
							}
							],
					});
					
					$('#dt_rp_list').on('click', 'tr:not(:first)', function () {
							//job_click('#modal1', '#modal_xadm', tab_myjob.row($(this).index()).data());
							var rdata = dt_rp_list.row($(this).index()).data();
							var ftype = rdata['ftype'];
							//var fparam = {'id' : rdata['id'], "mode" : 'RI',
							//	'url':'rpositem', 'reqtype' : 'readitem'};
							//loadForm('modal_l2', fparam, true);
							
							rdata['mode'] = 'RI';
							rdata['url'] = 'rpositem';
							rdata['stage'] = rp_stage;
							loadForm('modal_l2', rdata, true);
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
	};
	
	function query_id()
		{		
			var url = "<?php echo site_url('mposition/temppos/query')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: {"npp": $('#loginid').val()},
				dataType: "JSON",
				success: function(data)
				{
					$('[name="nama"]').val(data.name);
					$('[name="cposid"]').val(data.positionid);
					$('[name="cposname"]').val(data.nama);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
	function <?php echo $modal_id;?>_submit(btype){
		var fdata = {'url': 'wf/wfaction', 'modal_id' : "<?php echo $modal_id;?>", 'btype': btype };
		action_submit(fdata);
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
	<div class="modal-dialog ui-front" style="width: 85%;">
			<div class="modal-content" style="padding: 10px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" style="padding-left: 190px;">User Request</h3>
					<div style="width: 100%;">
					<div class="progressbar" id="progressbar"><span id="stagename" style="position:absolute; margin-left:10px; margin-top:2px"></span></div>
					<span id="lockinfo" style="position:absolute; margin-right:10px; margin-top:2px"></span>
				</div>
				</div>
						<div id="wfinfo" class="infohide">
							<label for="doneActor">Done</label> <ul id="doneActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
								<label for="currActor">Curr</label> <ul id="currActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
						</div>
				<div class="modal-body form">
					<table cellpadding="" cellspacing="2" class="tabel" id="dt_rp_list" style="width: 100%;" >	
							<thead>
								<tr>
									<th>No</th>
									<th>Req ID</th>
									<th>NPP</th>
									<th>Nama</th>
									<th>Posisi ID</th>
									<th>Posisi</th>						
									<th>No HP</th>
								</tr>
							</thead>
								<tbody>
								</tbody>
					</table>
					<form action="#" id="<?php echo $modal_id;?>_form" class="form-horizontal"> 				
						
						<input name="status" id="status" class="form-control" type="hidden" >
						<input name="id" id="id" class="form-control" type="hidden" >
						<input name="mode" id="mode" class="form-control" type="hidden" >
						<input name="wfid" id="wfid" class="form-control" type="hidden" >	
						<input name="reqtype" id="reqtype" class="form-control" type="hidden" >						
						<input name="notes" id="notes" class="form-control" type="hidden" >						
					
					<div class="modal-footer" id="div_btn_<?php echo $modal_id;?>">
						<div class="col-xs-6" style="text-align: left;">
							<button type="button" id="btn_save" onclick="<?php echo $modal_id;?>_submit('create')" class="btn btn-primary">Save</button>
						</div>
						<div class="col-xs-6">
						<button type="button" id="<?php echo $modal_id;?>_btn_submit" onclick="<?php echo $modal_id;?>_submit('submit')" class="btn btn-primary">Submit</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_cancel" onclick="<?php echo $modal_id;?>_submit('cancel')" class="btn btn-primary">Cancel</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_approve" onclick="<?php echo $modal_id;?>_submit('approve')" class="btn btn-primary">Approve</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_reject" onclick="<?php echo $modal_id;?>_submit('reject')" class="btn btn-primary">Reject</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_release" onclick="<?php echo $modal_id;?>_submit('release')" class="btn btn-primary">Release</button>
						</div>
					</div>
					</form>
				</div>	
			</div>
		</div>
	</div>