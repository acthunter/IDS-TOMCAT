<html>
<head> 
	<style type="text/css">
		.ui-autocomplete { height: 300px; overflow-y: scroll; overflow-x: hidden;}
		.width100 { width: 100px; }
		#vote_buttons {
		cursor:pointer;
		cursor:hand;
		}
	</style>
</head> 
<body>
	<center><h2 style="padding-bottom: 10px;">Waiting Request</h2></center>
		<div class="block-table table-sorting clearfix" style="width: 100%">
			<table cellpadding="" cellspacing="2" class="tabel" id="dt_wreq" style="width: 100%; text-align:center;" > 			
				<thead>
					<tr>
						<th>id</th>
						<th>Ref ID </th>
						<th>T Flag</th>
						<th>Efektif Date</th>
						<th>System ID</th>
						<th>Batch Flag</th>
						<th>Proc Status</th>
					</tr>
				</thead>
				<tbody  id="vote_buttons" name="vote_buttons">
				</tbody>
			</table>
</div>
<div id="DescModal" class="modal fade">
	<div class="modal-dialog ui-front">
		<div class="modal-content" style="padding: 10px;">
				<div class="modal-header">
					<center><h2 style="padding-bottom: 10px;">Detail Waiting Request</h2></center>
				</div>
				<div class="modal-body form">
				<table cellpadding="" cellspacing="2" class="tabel" id="dt_dtl_req" style="text-align:center;" > 			
					<thead>
						<tr>
							<th>Login ID</th>
							<th>Name</th>
							<th>Position</th>
							<th>Position ID</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody  id="vote_buttons" name="vote_buttons">
					</tbody>
				</table>
			</div>	
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() { 
		var tab;
		tab = $('#dt_wreq').DataTable({
			destroy: true,
			"processing": true, 
			"serverSide": true, 
			"language": {
				"infoFiltered": " "
			},
			"ajax": {
			"url": "<?php echo site_url('sysadm/xbatch/wreq_list')?>",
			"type": "POST"
			},
			"columns": [
				
				{"data":"id"},
				{"data":"refid"},
				{"data":"tflag"},
				{"data":"effDate"},
				{"data":"systemId"},
				{"data":"batchFlag"},
				{"data":"procStatus"},
			],
			"columnDefs": [
				{  
				"targets": [ -1 ], //last column
				"order":[[ 1, "asc" ]], //set not orderable
							
				}
			],

		});
		$('#dt_wreq').on('click', 'tr:not(:first)', function () {
			var rdata = tab.row($(this).index()).data();
			var fparam = {'id' : rdata['refid'],'url':'wreq_detail'};
			datatable(fparam, true);
		});
	})
	
	function datatable(fdata){
		 $('#dt_dtl_req').DataTable({
			"destroy": true,
			"processing": true, 
			"serverSide": true, 
			"language": {
				"infoFiltered": " "
			  },
			   "autoWidth": false,
			"ajax": {
			"url":  fdata['url'],
			"data": fdata,
			"type": "POST"
			
			},
			"columns": [
				
				{"data":"npp","width": "5%"},
				{"data":"nama", "width": "5%"},
				{"data":"posname"},
				{"data":"positionid"},
				{"data":"mode"}
				
			],
			"columnDefs": [
				{  
				"targets": [ -1 ], //last column
				"order":[[ 1, "asc" ]], //set not orderable
							
				}
			],

		});
		$('#DescModal').modal("show");
	}
</script>
</body>
</html>