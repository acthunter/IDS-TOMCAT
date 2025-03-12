<script type="text/javascript">
	var tabel;
	var dt_rp_list;
	var xrpid;
	var tabel2;
	
	var rp_stage;
	
	function  <?php echo $modal_id;?>_trigger(fdata){
			$('#date').datetimepicker({
            ignoreReadonly: true, widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('YYYY-MM-DD ');
			tabel = $('#dt_rp_list').DataTable({ 
			"destroy": true,
				"searching": false,
				"serverSide": true, 
				"order": [], 
				"aLengthMenu": [[ 5, 25, 50, -1], [ 10, 25, 50, "All"]],
				"iDisplayLength": 5,
							"ajax": {
								"url": "<?php echo site_url('stomp/xids/getadm_test')?>" ,
								"type": "POST",
								"dataType": "JSON",
								"data" : function ( data ) {
									data.pemohon = $('#pemohon').val();
									data.date = $('#date').val();
									data.req = $('#req').val();
								}
							},
							"language": {
							"infoFiltered": " - filtered from _MAX_ records"
						  },
							"columns" : [
								{"data":"id",},
								{"data":"mode"},
								{"data":"cdate"},
								{"data":"name"},
								{"data":"currActor"},
								{"data":"list_npp"},
								{"data":"stage",  "visible":false}
								
							],
							"columnDefs": [
							{  
								"targets": [ 0 ], //first column / numbering column
								"orderable": false,
							},
							{  
								"targets": [ 1 ],
								"render": function(data,type, row){
									var step = (row['stage']=='1') ? 'Init' : 'Approve'; 
									switch (row['mode']){
										case 'UA':
											var pname = 'User Add';
											break;
										case 'CU':
											var pname = 'Change Unit';
											break;
										case 'CP':
											var pname = 'Change Position Permanent';
											break;
										case 'CT':
											var pname = 'Change Position Temprorer';
											break;
										case 'RP':
											var pname = 'Review Position';
											break;
										case 'CI':
											var pname = 'Create Icons';
											break;
										case 'UH':
											var pname = 'Update No HP';
											break;
										default:
											var step = 'Request Canceled';
									}
									return step + ' - ' + pname;
								}, 
							},
							{  
								"targets": [ 3 ],
								"render": function(data,type, row){
									var step = (row['name']); 
									return step + '  (' + row['initiator'] +')';
								}, 
							},
							{  
								"targets": [ 4 ],
								"render": function(data,type, row){
									switch (row['stage']){
										case '1':
											var step = 'Request masuk ke draft';
											break;
										case '2':
											var step = 'Request menunggu persetujuan';
											break;
										case '3':
											var step = 'Request telah di setujui'; 
											break;
										default:
											var step = 'Request Canceled';
									}
									return step;
								}, 
							},

						],
					});		
		$('#btn-filter').click(function(){ //button filter event click
			tabel.ajax.reload();  //just reload table
		});
		$('#btn-reset').click(function(){ //button reset event click
			$('#form-filter')[0].reset();
			tabel.ajax.reload();  //just reload table
		});
		$('#dt_rp_list').on('click', 'tbody tr', function () {
				
				var rdata = tabel.row($(this).index()).data();
				//if (rdata['stage'] != 1){
				//var ftype = rdata['ftype'];
				var fparam = {'id' : rdata['id'], "mode" : rdata['mode'],
					'url':'jobbyid', 'reqtype' : 'read_list'};
				loadForm('modal_l2', fparam, true);
				//tabel.fnClearTable();
				//tabel.ajax.reload();
				//}
				//tabel.fnClearTable();
				
				//tabel.ajax.reload();
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
					<h3 class="modal-title">Search Request</h3>
				</div>
				<div class="modal-body form">
					<form id="form-filter" class="form-horizontal" style="margin-bottom:2%;">
                    <div class="form-group">
                        <label for="pemohon" class="col-sm-2 control-label">Pemohon</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="pemohon">
                        </div>
                    </div>
					<div class="form-group">
                        <label for="date" class="col-sm-2 control-label">Tanggal</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="date"readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="req" class="col-sm-2 control-label">Request</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="req">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </form>					  

					<table cellpadding="" cellspacing="2" class="cell-border" id="dt_rp_list" style="width: 100%"> 			
					<thead>
						<tr>
							<th>ID</th>
							<th>Proses</th>
							<th>Tanggal Permohonan</th>
							<th>Pemohon</th>
							<th>Status</th>
							<th>NPP Request</th>
						</tr>
					</thead>
						<tbody  id="vote_buttons" name="vote_buttons">
						</tbody>
				</table>
				</div>	
			</div>
		</div>
	</div>