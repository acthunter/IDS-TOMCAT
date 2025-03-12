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
	<center><h2 style="padding-bottom: 10px;">Waiting Approval</h2></center>
		<div class="block-table table-sorting clearfix" style="width: 100%">
			<table cellpadding="" cellspacing="2" class="tabel" id="dt_wappr" style="width: 100%; text-align:center;" > 			
				<thead>
					<tr>
						<th>id</th>
						<th>Status</th>
						<th>Create Date</th>
						<th>ACCOFFICE</th>
						<th>Type</th>
						<th>Details</th>
					</tr>
				</thead>
				<tbody  id="vote_buttons" name="vote_buttons">
				</tbody>
			</table>
</div>
<div id="DescModal" class="modal fade">
	<div class="modal-dialog ui-front" style="width:60%">
		<div class="modal-content" style="padding: 10px;">
				<div class="modal-header">
					<center><h2 style="padding-bottom: 10px;">Detail Waiting Approval</h2></center>
				</div>
				<div class="modal-body form">
				<table cellpadding="" cellspacing="2" class="tabel" id="dt_dtl_appr" style="text-align:center;" > 			
					<thead>
						<tr>
							<th>ID</th>
							<th>currActor</th>
							<th>currScore</th>
							<th>targetScore</th>
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
		tab = $('#dt_wappr').DataTable({
			destroy: true,
			"processing": true, 
			"serverSide": true, 
			"language": {
    "infoFiltered": " "
  },
			"ajax": {
			"url": "<?php echo site_url('sysadm/xbatch/wappr_list')?>",
			"type": "POST"
			},
			"columns": [
				
				{"data":"id"},
				{"data":"status"},
				{"data":"cdate"},
				{"data":"accoffice"},
				{"data":"type"},
				{"data":"details"}
			],
			"columnDefs": [
				{  
				"targets": [ -1 ], //last column
				"order":[[ 1, "asc" ]], //set not orderable
							
				}
			],

		});
		$('#dt_wappr').on('click', 'tr:not(:first)', function () {
			var rdata = tab.row($(this).index()).data();
			var fparam = {'id' : rdata['id'],'url':'wappr_detail'};
			datatable(fparam, true);
		});
	})
	
	function datatable(fdata){
		 $('#dt_dtl_appr').DataTable({
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
				
				{"data":"id","width": "5%"},
				{"data":"currActor", "width": "5%"},
				{"data":"currScore"},
				{"data":"targetScore"}
				
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