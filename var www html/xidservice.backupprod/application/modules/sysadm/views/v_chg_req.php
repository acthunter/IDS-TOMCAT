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

<div class="container" style="width: 100%;">

  <ul class="nav nav-tabs">
	<li class="active"><a href="#general_rp_tab" data-toggle="tab" >WAVE 2</a></li>
	<li><a href="#general_tab" data-toggle="tab" >WAVE 3</a></li>
    <!--<li><a href="#propose" data-toggle="tab" >WAVE 3</a></li>-->
  </ul>

  <div class="tab-content clearfix" style="background-color: #FFFFFF; margin-left: ">
	<div id="general_rp_tab" class="tab-pane fade in active">
	<center><h2 style="padding-bottom: 10px;">Jumlah Request</h2></center>
		<div class="block-table table-sorting clearfix" style="width: 100%">
			<table cellpadding="" cellspacing="2" class="tabel" id="dt_wave2" style="width: 100%; text-align:center;" > 			
				<thead>
					<tr>
						<th>Kode Unit</th>
						<th>CABANG</th>
						<th>JUMLAH PERUBAHAN</th>
					</tr>
				</thead>
				<tbody  id="vote_buttons" name="vote_buttons">
				</tbody>
			</table>
		</div>
	</div>
	
	<div id="general_tab" class="tab-pane fade">
	<center><h2 style="padding-bottom: 10px;">Jumlah Request</h2></center>
		<div class="block-table table-sorting clearfix" style="width: 100%">
			<table cellpadding="" cellspacing="2" class="tabel" id="dt_suspect" style="width: 100%; text-align:center;" > 			
				<thead>
					<tr>
						<th>Kode Unit</th>
						<th>CABANG</th>
						<th>JUMLAH PERUBAHAN</th>
					</tr>
				</thead>
				<tbody  id="vote_buttons" name="vote_buttons">
				</tbody>
			</table>
		</div>
	</div>
	
	
<script type="text/javascript">
	var tab;
	var dt_wave2;
	
	function load_table(){
			tab = $('#dt_suspect').DataTable({
					destroy: true,
					"processing": true, 
					"serverSide": true,
					"paging": false,
					"info": false,
					"searching":false,
					"ajax": {
						"url": "<?php echo site_url('chg_req_list')?>",
						"type": "POST"
						},
						"columns": [
							{"data":"accoffice"},
							{"data":"name"},
							{"data":"jumlah"},
						],
				});
				
			
			}
	
	function action(){
		load_table();
	}
	
	$(document).ready(function() {
			action();
			//setInterval("action();",60000);
			
			dt_wave2 = $('#dt_wave2').DataTable({ 
					"processing": true, 
				"serverSide": true,
				"searchable": true,
				"info": false,
				"paging": false,
				"searching":false,
				"ajax": {
					"url": "<?php echo site_url('chg_req_list2')?>",
					"type": "POST",
				},
				"columns": [
							{"data":"accoffice"},
							{"data":"name"},
							{"data":"jumlah"},
						],

			});
			
		});
</script>
</body>
</html>