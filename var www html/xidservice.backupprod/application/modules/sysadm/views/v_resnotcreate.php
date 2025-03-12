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
	<center><h2 style="padding-bottom: 10px;">Resource Not Create</h2></center>
		<div class="block-table table-sorting clearfix" style="width: 100%">
			<table cellpadding="" cellspacing="2" class="tabel" id="dt_res_not_create" style="width: 100%; text-align:center;" > 			
				<thead>
					<tr>
						<th>id</th>
						<th>Efektif Date</th>
						<th>Batch Flag</th>
						<th>Proc Status</th>
						<th>System ID</th>
						<th>Mode</th>
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
					<center><h2 style="padding-bottom: 10px;">Detail Data Resource</h2></center>
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
		tab = $('#dt_res_not_create').DataTable({
			destroy: true,
			"processing": true, 
			"serverSide": true, 
			"language": {
    "infoFiltered": " "
  },
			"ajax": {
			"url": "<?php echo site_url('sysadm/xbatch/resnotcreate_list')?>",
			"type": "POST"
			},
			"columns": [
				
				{"data":"id"},
				{"data":"effDate"},
				{"data":"batchFlag"},
				{"data":"procStatus"},
				{"data":"systemId"},
				{"data":"mode"}
			],
			"columnDefs": [
				{  
				"targets": [ -1 ], //last column
				"order":[[ 1, "asc" ]], //set not orderable
							
				}
			],

		});
	})
	
</script>
</body>
</html>