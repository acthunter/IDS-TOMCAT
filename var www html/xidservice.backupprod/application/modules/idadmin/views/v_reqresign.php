<script type="text/javascript">
var counter = 1;
var tabel;
	var tab_myjob;	
var sesslog;
	
$(document).ready(function(){
	sesslog = <?php echo json_encode($_SESSION['pengguna']->loginid) ?>;	
	tabel =	$('#dt_req_list_resign').DataTable({ 
			"destroy": true,
				"searching": false,
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, 
				"autoWidth": false,
				"order": [], 
				
				"aLengthMenu": [[ 10, 25, 50, -1], [ 10, 25, 50, "All"]],
				"iDisplayLength": 10,
				
							"ajax": {
								"url": "<?php echo site_url('idadmin/xmain/getreqresign')?>" ,
								"type": "POST",
								"dataType": "JSON",
								"data" : function ( data ) { 
									data.request = $('#request').val();
									data.status = $('#status').find(":selected").val();
								}
							},
							"columns" : [
								{"data":"id"},
								{"data":"NPP"},
								{"data":"nama"},
								{"data":"posisi"},
								{"data":"kodeunit"},
								{"data":"tgl_request"},
								{"data":"reqmodify"},
								{"data":"assignee"},
								{"data":"stage"},
								{"data":"poscode"}
								
							],
							"rowCallback": function( row, data, index ) {
								if (data['assignee'] === null && data['reqmodify'] === null){
									$('td', row).css('color', 'Indigo');
								}else if (data['reqmodify'] === null){
									$('td', row).css('color', 'SaddleBrown');
								}else{
									if (data['poscode'].indexOf("999888") >= 0){
										$('td', row).css('color', 'Black');									
									}else{
										$('td', row).css('color', 'Red');
									}
									
								}											
							},
							"columnDefs": [
							{  
								"targets": [ 0 ], //first column / numbering column
								"orderable": false,
							},
							{  
								"targets": [ 4 ],
								"className": "text-center"
							},
							{  
								"targets": [ 6 ],
								"className": "text-center",
								"render": function(data,type, row){
									
										if (row['assignee']=== null && row['reqmodify']=== null){
											var step = 'Unprocessed';
										}else if (row['reqmodify']=== null){
												var step = "On Process";
											
											//var step = '<button type="button" class="btn btn-success process_delete" id="btn-process" data-toggle="tooltip" data-placement="top" title="Password Process"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>';
										}else if ((row['poscode'].indexOf("999888")=== -1) && row['stage'] > 0){
											var step = "Unverified";
										
										}else{
											if (row['stage'] > 0){
												var step = "Completed  |    " + row['reqmodify'];
											}else{
												var step = "Cancel  |    " + row['reqmodify'];
											}
										}
																		
									return step;
								}, 
							},
							{  
								"targets": [ 7 ],
								"className": "text-center",
								"render": function(data,type, row){
									
										if (row['assignee']=== null && row['reqmodify']=== null){
											var step = '<button type="button" class="btn btn-warning process_lock" id="btn-process" data-toggle="tooltip" data-placement="top" title="Process Request"><i class="fa fa-check" aria-hidden="true"></i>';
										}else if (row['reqmodify']=== null){
											if(row['assignee'] === sesslog){
												var step = '<button type="button" class="btn btn-success process_delete" id="btn-process" data-toggle="tooltip" data-placement="top" title="Process Request"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>';
											}else{
												var step = "locked ( "+row['assignee']+" )";
											}
											
											//var step = '<button type="button" class="btn btn-success process_delete" id="btn-process" data-toggle="tooltip" data-placement="top" title="Password Process"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>';
			/* 							}else{
											if (row['poscode'].indexOf("999888") >= 0){
												var step = "( "+row['assignee']+" )";										
											}else{
												var step = '<button type="button" class="btn btn-warning process_lock" id="btn-process" data-toggle="tooltip" data-placement="top" title="Process Request"><i class="fa fa-check" aria-hidden="true"></i> </button> <button type="button" class="btn btn-danger cancelreq" id="btn-cancelreq" data-toggle="tooltip" data-placement="top" title="Cancel Request"><i class="fa fa-close" aria-hidden="true"></i> </button> ';
											}
												
										} */
										
										}else if ((row['poscode'].indexOf("999888")=== -1) && row['stage'] > 0){
											var step = '<button type="button" class="btn btn-warning process_lock" id="btn-process" data-toggle="tooltip" data-placement="top" title="Process Request"><i class="fa fa-check" aria-hidden="true"></i> </button> <button type="button" class="btn btn-danger cancelreq" id="btn-cancelreq" data-toggle="tooltip" data-placement="top" title="Cancel Request"><i class="fa fa-close" aria-hidden="true"></i> </button> ';

										
										}else{
											var step = "( "+row['assignee']+" )";											
										}
																		
									return step;
								}, 
							},
							{
								"targets": [ 8 ],
								"visible": false,
							},
							{
								"targets": [ 9 ],
								"visible": false,
							},
							

						]
					});

					$('#btn-filter').click(function(){ //button filter event click
			tabel.search($('#request').val()).draw();
			//tabel.ajax.reload();  //just reload table
		});
					
	$('#dt_req_list_resign tbody').on('click', 'button.process_delete' , function () {
		
		if (sesslog !== ''){
		var rdata = tabel.row( $(this).parents('tr') ).data();
				var rdata = tabel.row( $(this).parents('tr') ).data();
				var fparam = {'loginid' : sesslog, "reqid" : rdata['id']};
				$.ajax({
					url: "<?php echo site_url('process_del')?>",
					type: "POST",
					data: fparam,
					dataType: "JSON",
					success: function(data){
						if (data['status'] == 'success'){
							var text = 'User telah diproses !';
							var type = 'success';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						tabel.ajax.reload( null, false );
						}else{
							var text = 'User tidak dapat diproses !';
							var type = 'error';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						}
					}
				});
		}else{
			alert("Session anda habis, Silahkan relogin kembali"); 
			window.location.reload();
		}

		});
		
	$('#dt_req_list_resign tbody').on('click', 'button.process_lock' , function () {
		var rdata = tabel.row( $(this).parents('tr') ).data();
				var rdata = tabel.row( $(this).parents('tr') ).data();
				var fparam = {'loginid' : sesslog, "reqid" : rdata['id']};
				$.ajax({
					url: "<?php echo site_url('process_lock')?>",
					type: "POST",
					data: fparam,
					dataType: "JSON",
					success: function(data){
						if (data['status'] == 'success'){
							var text = 'User telah diproses !';
							var type = 'success';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						tabel.ajax.reload( null, false );
						}else{
							var text = 'User tidak dapat diproses !';
							var type = 'error';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						}
					}
				});

		});

		$('#dt_req_list_resign tbody').on('click', 'button.cancelreq' , function () {
		var rdata = tabel.row( $(this).parents('tr') ).data();
				var rdata = tabel.row( $(this).parents('tr') ).data();
				var fparam = {'loginid' : sesslog, "reqid" : rdata['id']};
				$.ajax({
					url: "<?php echo site_url('cancelreq')?>",
					type: "POST",
					data: fparam,
					dataType: "JSON",
					success: function(data){
						if (data['status'] == 'success'){
							var text = 'User telah diproses !';
							var type = 'success';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						tabel.ajax.reload( null, false );
						}else{
							var text = 'User tidak dapat diproses !';
							var type = 'error';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						}
					}
				});

		});
	});	
	
$(document).on('change', '#status', function(){
	  status = $(this).val();
	  if(status != '')
	  {
	    tabel.search(status).draw();
	  }
	  else
	  {
	   tabel.ajax.reload();
	  }
	 });
</script>

<style>
.cancelreq{
	margin-left: 6px;
}


</style>

<div class="panel panel-default" style="margin: 0 auto;min-width: 350px;padding: 10px;">
<div class="panel panel-default">
  <div class="panel-body">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
            <div class="input-group" id="adv-search">
                <input type="text" id="request" class="form-control" placeholder="Search Request" />
                <div class="input-group-btn">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary" id="btn-filter"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </div>
                </div>
            </div>
          </div>
        </div>
	</div>
  <div class="panel-body">
		<table cellpadding="" cellspacing="2" class="cell-border" id="dt_req_list_resign" > 			
					<thead>
						<tr>
							<th>ID</th>
							<th>NPP</th>
							<th>Nama</th>
							<th>Posisi</th>
							<th>Kode Unit</th>
							<th>Tgl Efektif </th>
							<th>
								<select name="status" id="status" class="form-control">
									<option value="">Status Search</option>
									<option value="P">unprocessed</option>
									<option value="V">unverified</option>
									<option value="T">on process</option>
									<option value="S">Completed</option>									
									
								</select>
							</th>
							<th>Action </th>
						</tr>
					</thead>
						<tbody  id="vote_buttons" name="vote_buttons">
						</tbody>
					<tfoot>
						<tr>
							<th>ID</th>
							<th>NPP</th>
							<th>Nama</th>
							<th>Posisi</th>
							<th>Kode Unit</th>
							<th>Tgl Efektif </th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</tfoot>
		</table>
  </div>
			
  </div>
</div>
