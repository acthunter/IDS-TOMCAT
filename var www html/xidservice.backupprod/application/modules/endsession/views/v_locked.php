<script type="text/javascript">

	var tabel;
	$(document).ready(function(){
		tabel = $('#dt_req_list').DataTable({ 
				"destroy": true,
				"searching": false,
				"processing": true, //Feature control the processing indicator.
				"serverSide": true,
"bLengthChange": false,"bInfo" : false,				
				"order": [], 
				"aLengthMenu": [[ 10, 25, 50, -1], [ 10, 25, 50, "All"]],
				"iDisplayLength": 10,
							"ajax": {
								"url": "<?php echo site_url('endsession/xmain/getval')?>" ,
								"type": "POST",
								"dataType": "JSON",
								"data" : function ( data ) { 
									data.request = $('#request').val();
								}
							},
							"columns" : [
								{"data":"npp"},
								{"data":"nama"},
								{"data":"unit"},
								{"data":"locked"},
								{"data":"locked"}
								
							],
							"columnDefs": [
							{  
								"targets": [ 0 ], //first column / numbering column
								"orderable": false,
							},
							{  
								"targets": [ 3 ],
								"render": function(data,type, row){
									if (row['locked']=='0'){
										var step = 'unlocked';
									}else{
										var step = 'locked';
									}
									return step;
								}, 
							},
							{  
								"targets": [ 4 ],
								"render": function(data,type, row){
									if (row['locked']=='0'){
										var step = '';
									}else{
										var step = '<button type="button" class="btn btn-warning edit" id="btn-edit"> Buka Lock</button>';
									}
									//var step = '<button type="button" class="btn btn-warning edit" id="btn-edit"> Buka Lock</button>';
									return step;
								}, 
							}
						]
					});		
		$('#btn-filter').click(function(){ //button filter event click
			tabel.search($('#request').val()).draw();
			//tabel.ajax.reload();  //just reload table
		});
		$('#dt_req_list tbody').on('click', 'button.edit' , function () { //button filter event click
			var rdata = tabel.row( $(this).parents('tr') ).data();
			var url = "<?php echo base_url('endsession/xmain/unlocked')?>";
			$.ajax({
					url : url,
					type: "POST",
					data: rdata,
					dataType: "JSON",
					success: function(data)
					{
						if(data > 0){
							new PNotify({
								title: 'Notifikasi',
								text: 'Unlock Success',
								type: 'success',
								styling: 'bootstrap3'
							});
							$('#request').val('').text('');
							tabel.search($('#request').val()).draw();
						}else{
							new PNotify({
								title: 'Notifikasi',
								text: 'Unlock Fail',
								type: 'error',
								styling: 'bootstrap3'
							});
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						alert('User not found');
					}
				});
			/* var url = "<?php echo base_url('endsession/xmain/show_edit')?>";
			$.ajax({
					url : url,
					type: "POST",
					}).done(function(data) {
						$('#modal_target').html(data);
						$('#modal_target_content').modal({show:true}); 
					}).fail(function(jqXHR, textStatus) {
										alert("Request failed:  - Please try again.")
									}); */
		});
	 });
	 
</script>

<div id="wrapper">
		<div style="width: 50%;margin:0 auto; margin-top: 5%; ">
		<form action="#" style="width: 500px; margin: auto;">
			<p class="formHeader">Unlocked CAS</p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<div class="form-group row" style="padding : 5%;">
			<p>
			<label style="color:black;">NPP</label>
				<div class="input-group">
				
					<input type="text" class="form-control" id="request" placeholder="Search npp..."  onclick= "$('#request').val('').text('');">
					  <span class="input-group-btn">
						<button class="btn btn-default" type="button" id ="btn-filter" class="btn btn-primary" style="-webkit-box-shadow: unset;">
							<i class="fa fa-search"></i>
						</button>
					  </span>
				</div>
			</p>
			<p>
				<table cellpadding="" cellspacing="2" class="cell-border" id="dt_req_list" style="width: 100%"> 			
						<thead>
							<tr>
								<th>NPP</th>
								<th>Nama</th>
								<th>Unit</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
							<tbody  id="vote_buttons" name="vote_buttons">
							</tbody>
				</table>
			</p>				
			</div>							
		</form>
	</div>
	<!--<div class="modal-container" id="modal_target"></div>-->
</div>


