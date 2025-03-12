<html>
<head> 
	<style type="text/css">
		.ui-autocomplete {
			height: 300px;
			overflow-y: scroll;
			overflow-x: hidden;
		}
		.width100 { width: 100px; }
		#vote_buttons {
			cursor:pointer;
			cursor:hand;
		}
		.high { color: red; }
        .low { color: black; }
		tr.row_selected td { background-color: grey !important; }
	</style>
</head> 
<body>
	<script type="text/javascript">
		var tab;
		$(document).ready(function() { 
			
			var dt_dtl_req;
			tab = $('#dt_suspect').DataTable({
				destroy: true,
				"processing": true, 
				"serverSide": true,
				"bInfo" : false,
				"language": {
					"infoFiltered": " - filtered from _MAX_ records"
				},				
				"ajax": {
					"url": "<?php echo site_url('dpass/xdpass/getpass')?>",
					"type": "POST",
				},
				"columns": [				
					{"data" : "reqid"},
					{"data" : "id"},
					{"data" : "loginid"},
					{
						"mRender": function(data, type, full) {
							return '<button class="validate btn btn-success btn-sm" >Proses</button>';
						}
					}
				]
			});
			
		/* 	$('#dt_suspect tbody').on( 'click', 'tr', function () {
				if ( $(this).toggleClass('row_selected') ) {
					var rdata = tab.row($(this).index()).data();
					//alert(JSON.stringify(rdata));
					var fparam = {'reqid' : rdata['reqid'], 'id' : rdata['id'], 'loginid' : rdata['loginid'], 'accOffice' : rdata['accOffice']};
					alert(JSON.stringify(fparam));
				} */
				/*  $(this).toggleClass('row_selected');
				var rdata = tab.row($(this).index()).data();
				var fparam = {'reqid' : rdata['reqid'], 'id' : rdata['id'], 'loginid' : rdata['loginid'], 'accOffice' : rdata['accOffice']}; */
			//});
		/* 	$('#dt_suspect tbody').on( 'click', 'tr', function () {
				if ( $(this).toggleClass('row_selected') ) {
					var rdata = tab.row($(this).index()).data();
					//alert(JSON.stringify(rdata));
					var fparam = {'reqid' : rdata['reqid'], 'id' : rdata['id'], 'loginid' : rdata['loginid'], 'accOffice' : rdata['accOffice']};
					alert(JSON.stringify(fparam));
				}
			}); */
			
			$('#dt_suspect tbody').on( 'click', 'button.validate', function () {				
				var rdata = tab.row( $(this).parents('tr') ).data();
				var fparam = {'reqid' : rdata['reqid'], 'id' : rdata['id'], 'loginid' : rdata['loginid'], 'accOffice' : rdata['accOffice'], 'tipe_btn': 'save', 'notes': $('#notes').val()};
				//alert(JSON.stringify(fparam));
				new PNotify({
					title: 'Notifikasi',
					text: 'Data telah di Proses!',
					type: 'success',
					styling: 'bootstrap3'
				});
				submit(fparam);
			});
		});	
		
		function submit(fparam) {			
			url = "<?php echo site_url('dpass/xdpass/wfaction')?>";		 
			$.ajax({
				url : url,
				data: fparam,
				type: "POST",
				dataType: "JSON",
				success : function (data){
					alert("success");
					//idaction();	
					tab.ajax.reload(null, false);
				},
				error: function (jqXHR, textStatus, errorThrown){
					alert("Error adding / update data");
				}
				
			});
		}
		/* function datatable(fdata){
			dt_dtl_req = $('#dt_dtl_req').DataTable({
				"destroy": true,
				"processing": true, 
				"serverSide": true, 
				"autoWidth": false,
				"ajax": {
					"url":  fdata['url'],
					"data": fdata,
					"type": "POST"			
				},
				"columns": [
					{"data" : "id","width": "5%"},
					{"data" : "reqid","width": "5%"},
					{"data" : "loginid", "width": "5%"},
					{"data" : "target"},
					{"data" : "status"},
				]
			});
			//$('#DescModal').modal("show");
			$('#dt_dtl_req tbody').on( 'click', 'tr', function () {
				$(this).toggleClass('row_selected');
			});
		}
		
		function rp_mark(mtype){
			var ids = [];
			dt_dtl_req.rows(".row_selected").every(function(){
				ids.push(this.data().id);
			});				
			$.ajax({
				url : "<?php echo site_url('dpass/xdpass/rp_mark')?>",
				type: "POST",
				data: {'mtype': mtype, 'ids': ids },
				dataType: "JSON",
				success: function(data)
				{
					dt_dtl_req.ajax.reload();
				}	
			}); 
		} */
	</script>

	<center><h2 style="padding-bottom: 10px;">Pending Password</h2></center>
	<div class="block-table table-sorting clearfix" style="width: 100%">
		<table cellpadding="" cellspacing="2" class="tabel" id="dt_suspect" style="width: 100%; text-align:center;" > 			
			<thead>
				<tr>
					<th>Reqid</th>
					<th>ID</th>
					<th>LoginID</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody  id="vote_buttons" name="vote_buttons">
			</tbody>
		</table>
	</div>
	<input name="notes" id="notes" class="form-control" type="hidden" >
	<!--<div class="modal-footer" id="div_btn_tpos_submit">
		<button type="button" onclick="submit()" class="btn btn-primary">Proses</button>
	</div>-->
	
	<!--<div id="DescModal" class="modal fade">
		<div class="modal-dialog ui-front">
			<div class="modal-content" style="padding: 10px;">
				<div class="modal-header">
					<center><h2 style="padding-bottom: 10px;">Detail</h2></center>
				</div>
				<div class="modal-body form">
					<table cellpadding="" cellspacing="2" class="tabel" id="dt_dtl_req" style="text-align:center;" > 			
						<thead>
							<tr>
								<th>Id</th>
								<th>Reqid</th>
								<th>Loginid</th>
								<th>Target</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody  id="vote_buttons" name="vote_buttons">
						</tbody>
					</table>
				</div>
				<div class="modal-footer" id="div_btn_tpos_submit">
					<button type="button" onclick="rp_mark('proses')" class="btn btn-primary">Proses</button>
					<button type="button" onclick="rp_mark('tolak')" class="btn btn-primary">Tolak</button>
				</div>
			</div>
		</div>
	</div>-->
</body>
</html>