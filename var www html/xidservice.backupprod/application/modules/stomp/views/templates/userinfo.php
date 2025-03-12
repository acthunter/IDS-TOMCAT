<script type="text/javascript">

	
	
	
	function  <?php echo $modal_id;?>_trigger(fdata){
		$('#info_user').hide();
		$('#proses').click(function(){
			$('#info_user').show();
			search();
			
		});	

	};
	
	function search(){
		var url = "<?php echo site_url('stomp/xids/searchuser')?>" ;
			tabel = $('#info_user').DataTable({ 
			"destroy": true,
				"searching": false,
				"order": [],
				"pageLength": 5,				
				"aLengthMenu": [[ 5, 25, 50, -1], [ 5, 25, 50, "All"]],
				"iDisplayLength": 5,
							"ajax": {
								"url": url ,
								"type": "POST",
								"dataType": "JSON",
								"data" : function ( data ) {
									data.npp = $('#search').val();
								}
							},
							"columns" : [
								{"data":"npp"},
								{"data":"bloginid", "width": "15%"},
								{"data":"nama"},
								{"data":"pos_name"},
								{"data":"accOffice","width": "2%"},
								{"data":"nama_unit"},
								{"data":"sloginid",
								visible: false},
								
							],
							"columnDefs": [
								{  
									"targets": [ 0 ], //first column / numbering column
									"orderable": false,
								},
								{  
									"targets": [ 1 ],
									"render": function(data,type, row){
										if (row['bloginid']!= null){
												var step = row['bloginid'];
										}else if (row['sloginid']!= null){
												var step = row['sloginid'];
										}else{
												var step = row['npp'];
										}
											return step;
									} 
								},
								{
									"targets": [ 4 ],
									"className": 'text-center'
								}

							],
					});
	}
	
</script>
<style>
	li.auth {text-align: center; width: 60px; float: left;}
	li.auth_1 { background-color: grey;}
	li.auth_2 { background-color: yellow;}
	li.auth_3 { background-color: green;}
	
	.infohide {
		display:none;
	}

#<?php echo $modal_id;?>_form1 label.error {
    color: red;
	font-size: 11px;
	width: 100%;
}

.ui-autocomplete {
    max-height:400px;
    overflow-y: auto;
	overflow-x: hidden;
}
* html .ui-autocomplete {
    height: 50px;
}
#<?php echo $modal_id;?>_form label.error {
    color: red;
	font-size: 11px;
	width: 100%;
}
button{
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
}
</style>
<div class="container">
  <!-- Modal -->
    
  <div class="modal fade"  id="<?php echo $modal_id;?>_content" role="dialog" data-backdrop="static" >
    <div class="modal-dialog"style="width:50%">
        <div class="modal-body">
			 <div id="wrap">
		<form action="#"  id="<?php echo $modal_id;?>_form"  role="form">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Informasi User</p>
			<p class="judul" align= "center" style="margin-left:28%; width:70%;color: red;" id="lockinfo" ></p>
			<p>
			<p>
				<div class="input-group" style ="width:35%">
				  <input type="text" id="search" class="form-control" placeholder="Search by Userid" onclick="$(this).val('');">
				  <span class="input-group-btn">
					<button class="btn btn-success"  id="proses" type="button">
						<i class="fa fa-search"></i>
					</button>
				  </span>
				</div>
			</p>
			<p style="padding-top: 5%">
				<table id="info_user" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr class="success" style ="text-align: center;">
							<th>NPP</th>
							<th>User ICONS</th>
							<th>Nama</th>
							<th>Posisi</th>
							<th>Kode Unit</th>
							<th>Nama Unit</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
					
        <tbody>
			</p>
		</form>
	</div>
        </div>
    </div>
  </div>

</div>