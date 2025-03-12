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
	<center><h2 style="padding-bottom: 10px;">Suspect</h2></center>
		<div class="block-table table-sorting clearfix" style="width: 100%">
			<table cellpadding="" cellspacing="2" class="tabel" id="dt_suspect" style="width: 100%; text-align:center;" > 			
				<thead>
					<tr>
						<th>id</th>
						<th>Efektif Date</th>
						<th>Refid</th>
						<th>Proc Status</th>
						<th>System ID</th>
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
					<center><h2 style="padding-bottom: 10px;">Detail Suspect</h2></center>
				</div>
				<div class="modal-body form">
				<table cellpadding="" cellspacing="2" class="tabel" id="dt_dtl_req" style="text-align:center;" > 			
					<thead>
						<tr>
							<th>Login ID</th>
							<th>Nama</th>
							<th>Position</th>
							<th>Mode</th>
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
		tab = $('#dt_suspect').DataTable({
			destroy: true,
			"processing": true, 
			"serverSide": true, 
			"language": {
    "infoFiltered": " "
  },
			"ajax": {
			"url": "<?php echo site_url('sysadm/xbatch/suspect_list')?>",
			"type": "POST"
			},
			"columns": [
				
				{"data":"id"},
				{"data":"effDate"},
				{"data":"refid"},
				{"data":"procStatus"},
				{"data":"systemId"}
			],
			"columnDefs": [
				{  
				"targets": [ -1 ], //last column
				"order":[[ 1, "asc" ]], //set not orderable
							
				}
			],

		});
		$('#dt_suspect').on('click', 'tr:not(:first)', function () {
			var rdata = tab.row($(this).index()).data();
			var fparam = {/* 'date' : rdata['effDate'] */ 'id' : rdata['id'],'url':'wreq_detail'};
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