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
						<th>ReqID</th>
						<th>Status</th>
						<th>NPP</th>
						<th>Kode Unit</th>
						<th>Nama</th>
						<th>Posisi Awal (xlogin)</th>
						<th>Posisi Akhir (revdraft)</th>
						<th>HP Awal (xemployee)</th>
						<th>HP Akhir (revdraft)</th>
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
			"order": [[ 2, "desc" ]],
			"language": {
    "infoFiltered": " "
  },
			"ajax": {
			"url": "<?php echo site_url('sysadm/xbatch/revupdate_list')?>",
			"type": "POST"
			},
			"columns": [
				{"data":"reqid"},
				{"data":"status"},
				{"data":"loginid"},
				{"data":"accOffice"},
				{"data":"name"},
				{"data":"posname"},
				{"data":"posnew"},
				{"data":"mobilenew"},
				{"data":"mobileNumber"},
			],
			"columnDefs": [
				{  
					"targets": [ -1 ],
					"orderable": false, 
				},
				{  
					"targets": [ 1 ],
					"render": function(data,type, row){
						if (row['status']=='pending')
							var step = 'tidak diedit';
							if (row['status']=='position')
							var step = 'Posisi Diedit'; 
							
							return step;	
					}, 
				}
			],
			
			"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
								 if (( aData["posname"] != aData["posnew"] ) && ( aData["mobileNumber"] != aData["mobilenew"] ))
								  { 
									$('td', nRow).css('background-color', '#66CDAA' );
									$('td', nRow).css('color', '#fffff' );
								  }else if (( aData["mobileNumber"] != aData["mobilenew"] )  )
								  {
									$('td', nRow).css('background-color', '#008c90' );
									$('td', nRow).css('color', '#fffff' );
								  } else if (( aData["posname"] != aData["posnew"] ) )
								  { 
									$('td', nRow).css('background-color', '#FF7F50' );
									$('td', nRow).css('color', '#fffff' );
								  } else {
									  $('td', nRow).css('background-color', '#fffff' ); 
								  }
									
							},

		});
	})
	
</script>
</body>
</html>