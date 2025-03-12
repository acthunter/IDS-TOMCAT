<script type="text/javascript">
	var tabel;
	var dt_rp_list;
	var xrpid;
	var tabel2;
	
	var rp_stage;
	
	function  <?php echo $modal_id;?>_trigger(fdata){
			tabel = $('#dt_rp_list').DataTable({ 
			"destroy": true,
				"searching": false,
				"serverSide": true, 
				"order": [], 
				"aLengthMenu": [[ 5, 25, 50, -1], [ 10, 25, 50, "All"]],
				"iDisplayLength": 5,
							"ajax": {
								"url": "<?php echo site_url('stomp/xids/getchangepos_fail')?>",
								"type": "POST",
								"dataType": "JSON",
								"data" : function ( data ) {
									data.pemohon = $('#pemohon').val();
									data.date = $('#date').val();
									data.req = $('#req').val();
								}
							},
							"columns" : [
								{"data":"id",},
								{"data":"mode"},
								{"data":"cdate"},
								{"data":"name"},
								{"data":"currActor"},
								{"data":"list_npp"},
								{"data":"",  "width": "15%"},
								{"data":"stage",  "visible":false}
								
							],
							"columnDefs": [
							{  
								"targets": [ 0 ], //first column / numbering column
								"orderable": false,
							},{
								"targets": [-1],
								"data": null,
								"defaultContent": "<button>Click!</button>"
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
									return pname;
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
							{  
								"targets": [ 6 ],
								"render": function(data,type, row){
									return '<button class="no-style btn-warning review" style="background: #c3770acc;">Review</button>  <button class="no-style run">Run</button>';
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
		// $('#dt_rp_list tbody').on( 'click', 'button', function () {
        // var data = table.row( $(this).parents('tr') ).data();
        // alert( data[0] +"'s salary is: "+ data[ 5 ] );
    // } );
		
		$('#dt_rp_list tbody').on('click', 'button.review' , function () {
				
				var rdata = tabel.row( $(this).parents('tr') ).data();
				var fparam = {'id' : rdata['id'], "mode" : rdata['mode'],
					'url':'jobbyid', 'reqtype' : 'read_list'};
				loadForm('modal_l2', fparam, true);
		});
		$('#dt_rp_list tbody').on('click', 'button.run' , function () {
				
				var rdata = tabel.row( $(this).parents('tr') ).data();
				var fparam = {'id' : rdata['id'], "mode" : rdata['mode']};
				$.ajax({
					url: "<?php echo site_url('stomp/xids/runchgpos_fail')?>",
					type: "POST",
					data: fparam,
					dataType: "JSON",
					success: function(data){
						var text = 'Data telah di proses Kembali !';
						var type = 'success';
						new PNotify({
							title: 'Notifikasi',
							text: text,
							type: type,
							styling: 'bootstrap3'
						});
						tabel.ajax.reload( null, false );
					}
				});
				cek();
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

	.no-style{
color: white;
            border-radius: 4px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
-webkit-appearance: button;
cursor: pointer;
background: #4CAF50;
padding: 6px 12px;
font-family: unset !important;
font-size: unset !important;
text-decoration: none;
margin-bottom: unset !important;
-moz-border-radius: unset !important;
-webkit-box-shadow: unset !important;
-moz-box-shadow: unset !important;
box-shadow: unset !important;
-webkit-transition: unset !important;
-moz-transition: unset !important;
-o-transition: unset !important;
transition: unset !important;
	}
	.colortr{
		background-color: rgba(28, 108, 122, 0.86);
		color: white;
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
					<h3 class="modal-title">Request Fail</h3>
				</div>
				<div class="modal-body form">
					<table cellpadding="" cellspacing="2" class="cell-border" id="dt_rp_list" style="width: 100%"> 			
					<thead>
						<tr class="colortr">
							<th>ID</th>
							<th>Proses</th>
							<th>Tanggal Permohonan</th>
							<th>Pemohon</th>
							<th>Status</th>
							<th>NPP Request</th>  
							<th></th>
						</tr>
					</thead>
						<tbody  id="vote_buttons" name="vote_buttons">
						</tbody>
				</table>
				</div>	
			</div>
		</div>
	</div>