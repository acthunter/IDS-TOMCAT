<script type="text/javascript">
	var dt_rev_post;
	var xrpid;
	var rp_stage;
	var tabel;
	
	function  <?php echo $modal_id;?>_trigger(fdata){
		console.log(fdata);
		$('#div_btn_<?php echo $modal_id;?> button').hide();
		$('#btn-csv').show();  
		
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
					
					tabel = $('#dt_rev_post').DataTable({ 
							//"retrieve": true,
							//"processing": true, 
							//"serverSide": true, 
							//"processing": true,
							"sPaginationType": "full_numbers",
							"aLengthMenu": [[ 10, 25, 50, -1], [ 10, 25, 50, "All"]],
							"iDisplayLength": 10,
							"ajax": {
								"url": "<?php echo site_url('stomp/xids/jobitemlist')?>",
								"type": "POST",
								"dataType": "JSON",
								"data" : {'wfid': wdata['id'],'rpid': data['id'], 'mode':'RP'},
								/* "data": function (data) {
									
									// Grab form values containing user options
									var form = {};
									$.each($("form").serializeArray(), function (i, field) {
										form[field.name] = field.value || "";
									});
									// Add options used by Datatables
									var info = { "start": 0, "length": 10, "draw": 1 , 'wfid': wdata['id'],'rpid': data['id'], 'mode':'RP'};
									$.extend(form, info);
									return JSON.stringify(form);
								}, */
							},
							"buttons": [
							   {
								 "extend": 'collection',
								 "text": 'Export',
								 "filter": 'applied',
								 "buttons": [ 'pdfHtml5', 'csvHtml5', 'copyHtml5', 'excelHtml5' ]
							  } 
							 /*  {
								"extend": 'csvHtml5',
								"exportOptions": { "orthogonal": 'export' }
							}, */
						   ],
							"columns" : [
							{"data":"id"},
							{"data":"reqid"},
							{"data":"loginid"},
							{"data":"name"},
							{"data":"posname"},
							{"data":"posnew"},
							{"data":"mobileNumber"},
							{"data":"mobilenew"},
							],
							
							"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
								 if (( aData["posname"] != aData["posnew"] ) && ( aData["mobileNumber"] != aData["mobilenew"] ))
								  { 
									$('td', nRow).css('background-color', '#66CDAA' );
									$('td', nRow).css('color', '#fffff' );
								  }else if (( aData["mobileNumber"] != aData["mobilenew"] )  )
								  {
									$('td', nRow).css('background-color', '#008c90' );
									$('td', nRow).css('color', '#fffff' );
								  } else if (( aData["posname"] != aData["posnew"] ) )
								  { 
									$('td', nRow).css('background-color', '#FF7F50' );
									$('td', nRow).css('color', '#fffff' );
								  } else {
									  $('td', nRow).css('background-color', '#fffff' ); 
								  }
									
							},
							"columnDefs": [
							{  "targets": [ 7 ],"visible": false, },
							{  "targets": [ 0 ],"visible": false, },
							{  "targets": [ 1 ],"visible": false, }
							],
							
					});
					if (fdata['reqtype'] == "read_list"){
						$('[id="div_btn_<?php echo $modal_id;?>"]').hide();
						
					}else{
					$('#dt_rev_post').on('click', 'tr:not(:first)', function () {
							//job_click('#modal1', '#modal_xadm', tab_myjob.row($(this).index()).data());
							
							var rdata = tabel.row($(this).index()).data();
							var ftype = rdata['ftype'];
							//var fparam = {'id' : rdata['id'], "mode" : 'RI',
							//	'url':'rpositem', 'reqtype' : 'readitem'};
							//loadForm('modal_l2', fparam, true);
							
							rdata['mode'] = 'RI';
							rdata['reqtype'] = 'readitem';
							rdata['url'] = 'rpositem';
							rdata['stage'] = rp_stage;
							loadForm('modal_l2', rdata, true);
							$('#modal_l2').on('hidden.bs.modal', function () {
								tabel.ajax.reload(null, false);
							})
					});
					dt_rev_post.ajax.reload( null, false );
					$('[id="div_btn_<?php echo $modal_id;?>"]').show();
					}
				}
		});
		
		$('#btn-csv').on('click', function(){
        tabel.button( '0-1' ).trigger();
		//dt_rev_post.button().trigger();
    });  
	
		$('#progressbar').click(function(){
			var ctarget = $('#wfinfo');
			if (ctarget.hasClass('infohide'))
				ctarget.removeClass('infohide');
			else
				ctarget.addClass('infohide');
		});	
	};
	
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
	#<?php echo $modal_id;?>_form{
		padding: 0px;
		background: none;
		border: none;
	}

</style>
<div id="<?php echo $modal_id;?>_content" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog ui-front" style="width: 85%;">
			<div class="modal-content" style="padding: 10px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" style="padding-left: 40%;">Review Posisi</h3>
				</div>
				<div class="modal-body form">
					<table cellpadding="" cellspacing="2" class="tabel" id="dt_rev_post" style="width: 100%;" >	
							<thead>
								<tr>
									<th>No</th>
									<th>Req ID</th>
									<th>NPP</th>
									<th>Nama</th>
									<th>Posisi Semula</th>
									<th>Posisi Baru</th>										
									<th>No HP</th>
									<th>No HP Baru</th>
								</tr>
							</thead>
								<tbody>
								</tbody>
					</table>
					<form action="#" id="<?php echo $modal_id;?>_form" class="form-horizontal" style="box-shadow: none;"> 				
						
						<input name="status" id="status" class="form-control" type="hidden" >
						<input name="id" id="id" class="form-control" type="hidden" >
						<input name="mode" id="mode" class="form-control" type="hidden" >
						<input name="wfid" id="wfid" class="form-control" type="hidden" >	
						<input name="reqtype" id="reqtype" class="form-control" type="hidden" >						
						<input name="notes" id="notes" class="form-control" type="hidden" >						
					
					<div class="modal-footer" id="div_btn_<?php echo $modal_id;?>" >
						<div class="col-xs-6" style="text-align: left;">
							<button type="button" id="btn_save" onclick="<?php echo $modal_id;?>_submit('create')" class="btn btn-primary">Save</button>
						</div>
						<div class="col-xs-6">
						<button type="button" id="btn-csv" class="btn btn-info">Export CSV</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_submit" onclick="<?php echo $modal_id;?>_submit('submit')" class="btn btn-success">Submits</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_cancel" onclick="<?php echo $modal_id;?>_submit('batal')" class="btn btn-danger">Cancel</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_approve" onclick="<?php echo $modal_id;?>_submit('approve')" class="btn btn-success">Approve</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_reject" onclick="<?php echo $modal_id;?>_submit('reject')" class="btn btn-danger">Reject</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_release" onclick="<?php echo $modal_id;?>_submit('release')" class="btn btn-warning">Release</button>
						</div>
					</div>
					</form>
				</div>	
			</div>
		</div>
	</div>