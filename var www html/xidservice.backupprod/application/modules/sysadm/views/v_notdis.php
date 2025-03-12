<html>
<head> 
	<style type="text/css">
		.ui-autocomplete { height: 300px; overflow-y: scroll; overflow-x: hidden;}
		.width100 { width: 100px; }
		#vote_buttons {
		cursor:pointer;
		cursor:hand;
		}
		tr.selected td {
    background-color: grey !important; 
		}
	</style>
</head> 
<body>
	<center><h2 style="padding-bottom: 10px;">Suspect</h2></center>
		<div class="block-table table-sorting clearfix" style="width: 100%">
			<table cellpadding="" cellspacing="2" class="tabel" id="dt_test" style="width: 100%; text-align:center;" > 			
				<thead>
					<tr>
						<th>id</th>
						<th>Refid</th>
						<th>Branch</th>
						<th>Mode</th>
						<th>ProcStatus</th>
						<th>Name</th>
					</tr>
				</thead>
				<tbody  id="vote_buttons" name="vote_buttons">
				</tbody>
			</table>
			<div class="modal-footer" id="div_btn_tpos_submit">
						<button type="button" onclick="rp_mark()" class="btn btn-primary">Update</button>					
				</div>
</div>
<script type="text/javascript">
var tab;
	$(document).ready(function() { 
		load_tabel()
		$('#dt_test tbody').on( 'click', 'tr', function () {
				 $(this).toggleClass('selected');
				 //showdetail(data['id']);
				 //alert("bisa");
			} );
	});
	function load_tabel(){
		tab = $('#dt_test').DataTable({
			"ajax": {
			"url": "<?php echo site_url('sysadm/xbatch/test_list')?>",
			"type": "POST"
			},
			"columns": [
				
				{"data":"id"},
				{"data":"refid"},
				{"data":"branch"},
				{"data":"status"},
				{"data":"npp"},
				{"data":"mode"},

			],
			
			"columnDefs": [
				{  
				"targets": [ -1 ], //last column
					"orderable": false, //set not orderable
							
				}
			],
			

		});
	}
	function rp_mark(){
			var ids = [];
			tab.rows(".selected").every(function(){
					ids.push(this.data().id);
			});
			alert(JSON.stringify(ids));
			$.ajax({
				url : "<?php echo site_url('sysadm/xbatch/update_list')?>",
				type: "POST",
				data: {'ids': ids },
				dataType: "JSON",
				success: function(data)
				{
						tab.ajax.reload();
				}
				
			}); 
		}
	
</script>
</body>
</html>