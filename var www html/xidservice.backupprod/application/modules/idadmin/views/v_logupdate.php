<script type="text/javascript">
var tabel;
	$(document).ready(function(){
		load_tabel();
		$('#btn-filter').click(function(){ //button filter event click
			tabel.search($('#request').val()).draw();
			//tabel.ajax.reload();  //just reload table
		});
	});
	function load_tabel(){
	tabel = $('#dt_req_list').DataTable({ 
			"destroy": true,
				"searching": false,
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, 
				"order": [], 
				"aLengthMenu": [[ 10, 25, 50, -1], [ 10, 25, 50, "All"]],
				"iDisplayLength": 10,
							"ajax": {
								"url": "<?php echo site_url('idadmin/xmain/getlog')?>" ,
								"type": "POST",
								"dataType": "JSON",
								"data" : function ( data ) { 
									data.request = $('#request').val();
								}
							},
							"columns" : [

								{"data":"id",},
								{"data":"tgl_ubah"},
								{"data":"userid"},
								{"data":"nama"},
								{"data":"npp_user"},
								{"data":"nama_user"},
								{"data":"nama_user"}
								
							],
							"columnDefs": [
							{  
								"targets": [ 0 ], //first column / numbering column
								"orderable": false,
							},
							{  
								"targets": [ 6 ],
								"render": function(data,type, row){
									var step = '<button type="button" class="btn btn-danger reload" id="btn-backlist" >View</button>';										
									return step;
								}
							}
							

						]
					});
		$('#dt_req_list').on( 'click', '#btn-backlist ', function () {
			 var rdata = tabel.row( $(this).parents('tr') ).data();
			 var fparam = {'id' : rdata['id']};
			 load_modal('modal_l1', fparam);
		});
	}
	function load_modal($id, $data){
		var url = "<?php echo site_url('idadmin/xmain/load_detail')?>" ;
		var url2 = "<?php echo site_url('idadmin/xmain/getdetail')?>" ;
		$.ajax({
			url: url,
			type: "POST"
			}).done(function(data) {
				$('#modal_target').html(data);
				
				$.ajax({
					url : url2,
					type: "POST",
					data: {"id": $data['id']},
					dataType: "JSON",
					success: function(data2)
					{
					$('[id="npp"]').val(data2.loginid);
					$('[id="nama"]').val(data2.nama);
					$('[id="email_new"]').val(data2.email_new);
					$('[id="email_old"]').val(data2.email_old);
					$('[id="unit_new"]').val(data2.unit_new);
					$('[id="unit_old"]').val(data2.unit_old);
					$('[id="posisi_new"]').val(data2.posisi_new);
					$('[id="posisi_old"]').val(data2.posisi_old);
					$('[id="ket"]').val(data2.ket);
					var arr_ro = "unit_new,posisi_new,email_new,ket".split(",");
							for(cid of arr_ro){
								$datacid = eval('data2.'+cid);
								console.log($datacid);
								if($datacid == null || $datacid == ""){
									$('#' + cid).val("-");
								}/* else{
									$('#' + cid).val($datacid);
								} */
								
							}
					$('#modal_target_content').modal({show:true}); 
					},
					error: function (jqXHR, textStatus, errorThrown)
					{
						alert('User not found');
					}
				});
				
				
			}).fail(function(jqXHR, textStatus) {
				alert("Request failed:  - Please try again.")
			});
	}
</script>
<div class="panel panel-default" style="width: 90%;margin: 0 auto;min-width: 350px;padding: 10px;">
<div class="panel panel-default">
  <div class="panel-body">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
            <div class="input-group" id="adv-search">
                <input type="text" id="request" class="form-control" placeholder="Search Request" />
                <div class="input-group-btn">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary" id="btn-filter"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </div>
                </div>
            </div>
          </div>
        </div>
	</div>
  <div class="panel-body">
		<table cellpadding="" cellspacing="2" class="cell-border" id="dt_req_list" style="width: 100%"> 			
					<thead>
						<tr>
							<th>Id</th>
							<th>Tgl Request </th>
							<th>User ID</th>
							<th>Nama User ID</th>
							<th>NPP</th>
							<th>Nama user</th>
							<th>Action</th>
						</tr>
					</thead>
						<tbody  id="vote_buttons" name="vote_buttons">
						</tbody>
		</table>
  </div>
			
  </div>
</div>

<div class="modal-container" id="modal_target"></div>

