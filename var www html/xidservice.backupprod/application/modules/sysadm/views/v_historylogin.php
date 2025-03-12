<html>
<head> 

</head> 
<body>
	<center><h2 style="padding-bottom: 10px;">History Login</h2></center>
		<div class="block-table table-sorting clearfix" style="width: 100%; padding: 2%;">
			<table cellpadding="" cellspacing="2" class="tabel" id="dt_audit" style="width: 100%; text-align:center;" > 			
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>User</th>
						<th>Name</th>
						<th>Acc Office</th>
						<th>Client</th>
						<th>Resource</th>
					</tr>
				</thead>
				<tbody  id="vote_buttons" name="vote_buttons">
				</tbody>
			</table>
</div>
<div id="DescModal" class="modal fade">
	<div class="modal-dialog ui-front" style="width: 95%;">
			<div class="modal-content" style="padding: 10px;">
				<div class="modal-header">
					<center><h2 style="padding-bottom: 10px;">Detail Audit</h2></center>
				</div>
				<div class="modal-body form">
				<table cellpadding="" cellspacing="2" class="tabel" id="dt_dtl_audit" style="text-align:center;" > 			
					<thead>
						<tr>
							<th>ID</th>
							<th>USER</th>
							<th>Client IP</th>
							<th>Server IP</th>
							<th>Resource</th>
							<th>Action</th>
							<th>Application</th>
							<th>Date</th>
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
	var tab;
	$(document).ready(function() { 

		tab = $('#dt_audit').DataTable({
			destroy: true,
			"processing": true, 
			"serverSide": true, 
			"language": {
				"infoFiltered": " "
			},
							"iDisplayLength": 10,
							"lengthMenu": [[10, 25, 50, 1000], [10, 25, 50, 1000]],
			"dom": 'lBfrtip',
			"ajax": {
				"url": "<?php echo site_url('sysadm/xbatch/history_list')?>",
				"type": "POST"
			},
			"columns": [
				
				{"data":"AUD_DATE"},
				{"data":"AUD_USER"},
				{"data":"Name"},
				{"data":"accOffice"},
				{"data":"AUD_CLIENT_IP"},
				{"data":"AUD_RESOURCE"}
				
			],
			"columnDefs": [
				{  
				"targets": [ -1 ], //last column
				"order":[[ 1, "asc" ]], //set not orderable
							
				}
			],
			"buttons": [
				{
					"extend": 'copyHtml5',
					"exportOptions": { orthogonal: 'export' }
				},
				{
					"extend": 'excelHtml5',
					"exportOptions": { orthogonal: 'export' }
				},
				{
					"extend": 'pdfHtml5',
					"exportOptions": { orthogonal: 'export' }
				}
			]

		});
		
	})
	
/* 	function loadForm(fdata)
	{
		$.ajax({
			url : fdata['url'],
			type: "POST",
			data: fdata,
			dataType: "JSON",
			success: function(data)
			{			
				datatable(data);
				$('#DescModal').modal("show");
			},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error get data from ajax');
				}
		});
	} */
	function datatable(fdata){
		 $('#dt_dtl_audit').DataTable({
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
				{"data":"AUD_USER", "width": "5%"},
				{"data":"AUD_CLIENT_IP"},
				{"data":"AUD_SERVER_IP"},
				{"data":"AUD_RESOURCE","width": "10px"},
				{"data":"AUD_ACTION"},
				{"data":"APPLIC_CD"},
				{"data":"AUD_DATE"}
				
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
</html>