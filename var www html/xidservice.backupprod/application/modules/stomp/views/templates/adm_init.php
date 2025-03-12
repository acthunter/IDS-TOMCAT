<script type="text/javascript">
	var dt_rp_list;
	var xrpid;
	var tabel2;
	var rp_stage;
	
	function  <?php echo $modal_id;?>_trigger(fdata){
		console.log(fdata);
			$('[name="mmode"]').val(fdata['mode']);
			table2 = $('#dt_rp_list').dataTable({"binfo":false,"searching": false,"paging": false}).fnClearTable();	
	};
function srch()
		{		
			var tabel;
			var url = "<?php echo site_url('stomp/xids/search')?>" ;
			var isi =  $('#srch-term').val();
			if (isi != ""){
			$.ajax({
				url : url,
				type: "POST",
				data: $('[id="search"]').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					$('#div_btn_<?php echo $modal_id;?> button').hide();
				if (data != null){	
					a = data['initiator'];
				tabel = $('#dt_rp_list').DataTable({ 
							"destroy": true,
							"searching": false,
							"processing": true,
							"binfo":false,							
							"paging":false,							
							"serverSide": true, 
							"order": [], 
							"ajax": {
								"url": "<?php echo site_url('stomp/xids/getadm2/')?>" + a,
								"type": "POST",
								"dataType": "JSON",
							},
							"columns" : [
								{"data":"id",
								 width: "20px"},
								{"data":"stage",
								  visible: false,
								  width: "50px"},
								{"data":"mode"},
								{"data":"doneActor"},
								{"data":"currScore"},
								{"data":"cdate"},
								{"data":"name"},
								{"data":"stage"}
							],
							"columnDefs": [
							{  
								"targets": [ -1 ],
								"orderable": false, 
							},
							{  
								"targets": [ 2 ],
								"render": function(data,type, row){
									var step = (row['stage']=='1') ? 'Init' : 'Approve'; 
									return step + ' - ' + pname[data];
								}, 
							},
							{  
								"targets": [ 6 ],
								"render": function(data,type, row){
									var step = (row['name']); 
									return step + '  (' + row['initiator'] +')';
								}, 
							},
							{  
								"targets": [ 7 ],
								"render": function(data,type, row){
									switch (row['stage']){
										case '1':
											var step = 'Request Initiated';
											break;
										case '2':
											var step = 'Request Review';
											break;
										case '3':
											var step = 'Request Complete';
											break;
										default:
											var step = 'Request Canceled';
									}
									//var step = (row['stage']=='1') ? 'Request Initiated' : 'Request Review'; 
									return step;
								}, 
							}

						],
					});
					//tabel.row().remove();
		$('#dt_rp_list').on('click', 'tr:not(:first)', function () {
				//job_click('#modal1', '#modal_xadm', tab_myjob.row($(this).index()).data());
				//tabel.row($(this).index()).remove();
				var rdata = tabel.row($(this).index()).data();
				if(rdata != null){
				var ftype = rdata['ftype'];
				var fparam = {'id' : rdata['id'], "mode" : rdata['mode'],
					'url':'jobbyid', 'reqtype' : 'read'};
				loadForm('modal_l2', fparam, true);
				}
				tabel.ajax.reload();
				
				//rdata = $("#dt_rp_list").DataTable().clear();
		});
		}else{
					alert('user not found');
		}
		tabel.ajax.reload();
				
		
		
		
		
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
			
		}else{
			a = 0;
			tabel = $('#dt_rp_list').DataTable({ 
							"destroy": true,
							"searching": false,
							"processing": true,
							"binfo":false,							
							"paging":false,							
							"serverSide": true, 
							"order": [], 
							"ajax": {
								"url": "<?php echo site_url('stomp/xids/getadm2/')?>" + a,
								"type": "POST",
								"dataType": "JSON",
							},
							"columns" : [
								{"data":"id",
								 width: "20px"},
								{"data":"stage",
								  visible: false,
								  width: "50px"},
								{"data":"mode"},
								{"data":"doneActor"},
								{"data":"currScore"},
								{"data":"cdate"},
								{"data":"name"},
								{"data":"stage"}
							],
							"columnDefs": [
							{  
								"targets": [ -1 ],
								"orderable": false, 
							},
							{  
								"targets": [ 2 ],
								"render": function(data,type, row){
									var step = (row['stage']=='1') ? 'Init' : 'Approve'; 
									return step + ' - ' + pname[data];
								}, 
							},
							{  
								"targets": [ 6 ],
								"render": function(data,type, row){
									var step = (row['name']); 
									return step + '  (' + row['initiator'] +')';
								}, 
							},
							{  
								"targets": [ 7 ],
								"render": function(data,type, row){
									switch (row['stage']){
										case '1':
											var step = 'Request Initiated';
											break;
										case '2':
											var step = 'Request Review';
											break;
										case '3':
											var step = 'Request Complete';
											break;
										default:
											var step = 'Request Canceled';
									}
									//var step = (row['stage']=='1') ? 'Request Initiated' : 'Request Review'; 
									return step;
								}, 
							}

						],
					});
					//tabel.row().remove();
		$('#dt_rp_list').on('click', 'tr:not(:first)', function () {
				//job_click('#modal1', '#modal_xadm', tab_myjob.row($(this).index()).data());
				//tabel.row($(this).index()).remove();
				var rdata = tabel.row($(this).index()).data();
				if(rdata != null){
				var ftype = rdata['ftype'];
				var fparam = {'id' : rdata['id'], "mode" : rdata['mode'],
					'url':'jobbyid', 'reqtype' : 'read'};
				loadForm('modal_l2', fparam, true);
				}
				tabel.ajax.reload();
				//rdata = $("#dt_rp_list").DataTable().clear();
		});
		}

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
<?/* #tabel, #srch {
    padding: 5px;
    text-align: center;
    background-color: #e5eecc;
    border: solid 1px #c3c3c3;
}

#tabel {
    padding: 50px;
    display: none;
} */?>
</style>
<div id="<?php echo $modal_id;?>_content" class="modal fade">
	<div class="modal-dialog ui-front" style="width: 85%;">
			<div class="modal-content" style="padding: 10px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Search Request By Initiator</h3>
				</div>
  <div class="modal-body form" id="tabel">
				<form class="navbar-form" id="search" role="search">
					<div class="input-group add-on">
					  <input class="form-control" placeholder="Search"  name="srch-term" id="srch-term" type="text"style="width: 65%; left: -5%;">
					  <span class="input-group-btn" style="right:36%">
					  <button class="btn btn-info" onclick="srch()" type="button">
                            <i class="glyphicon glyphicon-search" style="height:17px"></i>
                      </button>
					  </span>
					</div>
					<input class="form-control"  name="mmode" id="mmode" type="hidden">
				</form>
					<table cellpadding="" cellspacing="2" class="tabel" id="dt_rp_list" style="width: 100%;" >	
							<thead>
								<tr>
							<th>Request ID</th>
							<th>Tahap</th>
							<th>Proses</th>
							<th>dActor</th>
							<th>score</th>
							<th>Date Requested</th>
							<th>Requested By</th>
							<th>Status</th>
								</tr>
							</thead>
								<tbody>
								</tbody>
					</table>
				</div>	
			</div>
		</div>
	</div>	