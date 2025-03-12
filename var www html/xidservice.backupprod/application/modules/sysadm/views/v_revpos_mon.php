<!DOCTYPE html>
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
    <div id="propose" class="tab-pane fade in active">
				<br><br><center><h2 style="padding-bottom: 10px;">review posisi submit</h2></center>
				<div class="block-table table-sorting clearfix"> <!-- block-fluid table-sorting clearfix -->
					<table cellpadding="" cellspacing="2" class="tabel" id="dt_p"> 			
						<thead>
							<tr>
								<th>accoffice_submit</th>
								<th>cabang</th>
								<th>count_submit</th>										
							</tr>
						</thead>
						<tbody id="vote_buttons" name="vote_buttons">
						</tbody>
					</table>
				</div>
    </div>
</div>

<div class="container" style="width: 100%;">
    <div id="propose" class="tab-pane fade in active">
				<br><br><center><h2 style="padding-bottom: 10px;">review posisi approve</h2></center>
				<div class="block-table table-sorting clearfix"> <!-- block-fluid table-sorting clearfix -->
					<table cellpadding="" cellspacing="2" class="tabel" id="dt_pt"> 			
						<thead>
							<tr>
								<th>accoffice_approve</th>
								<th>cabang</th>
								<th>count_approve</th>														
							</tr>
						</thead>
						<tbody id="vote_buttons" name="vote_buttons">
						</tbody>
					</table>
				</div>
    </div>
</div>


<style>
	.high {
		color: red;
	}

	.low {
		color: black;
	}
	tr.row_selected td {
background-color: grey !important; 
	}
</style>
	
 	<script type="text/javascript">
		var tab;
		function load_table(){
			tab = $('#dt_p').DataTable({
					destroy: true,
					"processing": true, 
					"serverSide": true, 
					"ajax": {
						"url": "<?php echo site_url('rev_posmon_list_submit')?>",
						"type": "POST"
						},
						"columns": [
							{"data":"acc_submit"},
							{"data":"cabang"},
							{"data":"count_submit"},
						],
				});
				
			
			}
		
		function load_table1(){
			tab = $('#dt_pt').DataTable({
					destroy: true,
					"processing": true, 
					"serverSide": true, 
					"ajax": {
						"url": "<?php echo site_url('rev_posmon_list_approve')?>",
						"type": "POST"
						},
						"columns": [
							{"data":"acc_approve"},
							{"data":"cabang"},
							{"data":"count_approve"}
						],
				});
				
			
			}
		
		$(document).ready(function() {
			load_table();
			load_table1();
		});
		
		   

	</script>
		
	
	
	
</body>
</html>