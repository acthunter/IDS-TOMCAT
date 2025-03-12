<script type="text/javascript">
	var tabel;
	$(document).ready(function(){
		tabel = $('#dt_req_list').DataTable({ 
				"destroy": true,
				"searching": false,
				"processing": true, //Feature control the processing indicator.
				"serverSide": true,
				"bLengthChange": false,
				"bPaginate": false,
				"bInfo" : false,				
				"order": [], 
				"aLengthMenu": [[ 10, 25, 50, -1], [ 10, 25, 50, "All"]],
				"iDisplayLength": 10,
							"ajax": {
								"url": "<?php echo site_url('getuserlock')?>" ,
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
			var rowCount = $('#myTable tr').length;
			if(rowCount = 0){
			new PNotify({
								title: 'Notifikasi',
								text: 'gagal dong',
								type: 'success',
								styling: 'bootstrap3'
							});
			}
		});
		
		$('#dt_req_list tbody').on('click', 'button.edit' , function () { //button filter event click
			var rdata = tabel.row( $(this).parents('tr') ).data();
			var url = "<?php echo base_url('unlock')?>";
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
							//$('#request').val('').text('');
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
		});
	 });




</script>
<div class="container">
  <!-- Modal -->
  <div class="modal fade"  id="<?php echo $modal_id;?>_content" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-body">
			 <div id="wrap">
		<form action="#"  id="<?php echo $modal_id;?>_form"  role="form">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Unlocked CAS</p>
			<p class="judul" align= "center" style="margin-left:28%; width:70%;color: red;" id="lockinfo" ></p>
			<div class="form-group row" style="width:90%;margin-left:6%;">		
				<p>
			<label style="color:black;">Userid CAS</label>
				<div class="input-group">
				
					<input type="text" class="form-control" id="request" placeholder="Search Userid CAS..." onclick= "$('#request').val('').text('');">
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
								<th>Userid CAS</th>
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
			<ul style="font-size:12px;color: red;margin-bottom: 25px; margin-top: -23px;
				margin-left:-30px;padding-top: 36px;">
					<label style="margin-left: -5px;margin-top: 10px;">Catatan : </label>
					<li>Unlock CAS dapat dilakukan oleh admin masing - masing unit</li>
					<li>Jika user tidak ditemukan, pastikan user sesuai dengan unit yang akan melakukan unlock CAS</li>
					<li>Untuk mengecek unit user telah sesuai atau belum, Silahkan menggunakan menu INFORMASI USER</li>

				</ul>
			</div>							
		</form>
	</div>
        </div>
    </div>
  </div>
  
</div>