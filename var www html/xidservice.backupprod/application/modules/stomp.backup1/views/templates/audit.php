<script type="text/javascript">
	var tabel;
	var dt_rp_list;
	var xrpid;
	var tabel2;
	
	var rp_stage;
/* 	$('#date').datetimepicker({
            ignoreReadonly: true, widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('YYYY-MM-DD '); */
	function  <?php echo $modal_id;?>_trigger(fdata){
			tabel = $('#dt_rp_list').DataTable({ 
			"destroy": true,
				"searching": false,
				"serverSide": true, 
				"order": [], 
				"aLengthMenu": [[ 5, 25, 50, -1], [ 10, 25, 50, "All"]],
				"iDisplayLength": 5,
							"ajax": {
								"url": "<?php echo site_url('stomp/xids/getaudit')?>" ,
								"type": "POST",
								"dataType": "JSON",
								"data" : function ( data ) {
									data.loginid_target = $('#loginid_target').val();
									data.approval = $('#approval').val();
								}
							},
							"columns" : [
								{"data":"id_rd",},
								{"data":"loginid_target"},
								{"data":"mn_target"},
								{"data":"position_target"},
								{"data":"reviewer"},
								{"data":"periode"},
								{"data":"adm_initiator"},
								{"data":"appr"}
								
							],
							"columnDefs": [
							{  
								"targets": [ 0 ], //first column / numbering column
								"orderable": false,
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
				
				//var ftype = rdata['ftype'];
				var fparam = {'id' : rdata['id'], "mode" : rdata['mode'],
					'url':'jobbyid', 'reqtype' : 'read_list'};
				loadForm('modal_l2', fparam, true);
				//tabel.fnClearTable();
				
				tabel.ajax.reload();
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
					<h3 class="modal-title">Search Review Data</h3>
				</div>
				<div class="modal-body form">
					<form id="form-filter" class="form-horizontal" style="margin-bottom:2%;">
                    <div class="form-group">
                        <label for="loginid_target" class="col-sm-2 control-label">Target</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="loginid_target">
                        </div>
                    </div>
					<div class="form-group">
                        <label for="approval" class="col-sm-2 control-label">Approval</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="approval">
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
							<th>Login ID Target</th>
							<th>No Handphone Target</th>
							<th>Position Target</th>
							<th>Reviewer</th>
							<th>periode</th>
							<th>Initiator</th>
							<th>Approval</th>
						</tr>
					</thead>
						<tbody  id="vote_buttons" name="vote_buttons">
						</tbody>
				</table>
				</div>	
			</div>
		</div>
	</div>