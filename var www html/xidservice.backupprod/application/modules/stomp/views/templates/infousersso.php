<script type="text/javascript">
var counter = 1;
	var tab_myjob;	
	var form_db = {};
	var tabel;
	var pname = {RP : "Review Position", CT: "Posisi Sementara ", CP: "Posisi Permanen", CU: "Ubah Unit", UA: "Tambah User", RS: "Reset Target", UC: "Cek User", CL: "Change Level", CI: "Create iCONS" };
	function clearform_db(){
		form_db = {};
	}
$(document).ready(function(){

	$('#info_user').hide();
		$('#proses').click(function(){
			$('#info_user').show();
			if ("<?php echo $_SESSION['pengguna']->idm_idadmin?>" == 4 ){
					search_718() ;
					console.log("718");
			}else if(("<?php echo $_SESSION['pengguna']->idm_super?>" > 0) && ("<?php echo $_SESSION['pengguna']->accoffice?>" >= 800)){
				search_sya() ;
				console.log("lainnya");
			}else{
				search() ;
				console.log("lainnya2");
			}
		});	
	});
	function search_718(){
			var url = "<?php echo site_url('stomp/xids/searchuser2')?>" ;
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
								{"data":"npp",},
								{"data":"sloginid", "width": "15%"},
								{"data":"nama"},
								{"data":"pos_name"},
								{"data":"accOffice","width": "2%"},
								{"data":"nama_unit"},
								{"data":"email", "width": "35%"},
								{"data":"nohp"},
								{"data":"apps"}
								
							],
							"columnDefs": [
								{  
									"targets": [ 0 ], //first column / numbering column
									"orderable": false,
								},
								{
									"targets": [ 1 ],
									"className": 'text-center'
								},
								
								{
									"targets": [ 5 ],
									"className": 'text-center'
								},
								{
									"targets": [ 6 ],
									"className": 'break-all'
								},
								{
									
									"targets": [ 7 ],
									"render": function(data,type, row){
										if ("<?php echo $_SESSION['pengguna']->accoffice?>"=='786'){
											var step = row['nohp'];
										}else{
											var step = "-";
										}
										
										return step;
									}, 
								},
								{
									
									"targets": [ 8 ],
									"render": function(data,type, row){
										if (row['apps'] == null){
											var step = "-";
										}else 
										if ("<?php echo $_SESSION['pengguna']->accoffice?>"=='786'){
											var arry = row['apps'].split(",");
											var str = '<ul>'
												arry.forEach(function(slide) {
												  str += '<li>'+ slide + '</li>';
												}); 

												str += '</ul>';
											var step = str;
										}else{
											var step = "-";
										}
										
										return step;
									}, 
								}

							],
					});
					$('#info_user thead th').removeClass('break-all'); 
	}
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
								{"data":"npp",},
								{"data":"sloginid", "width": "15%"},
								{"data":"nama"},
								{"data":"pos_name"},
								{"data":"accOffice","width": "2%"},
								{"data":"nama_unit"}
								
							],
							"columnDefs": [
								{  
									"targets": [ 0 ], //first column / numbering column
									"orderable": false,
								},
								{
									"targets": [ 1 ],
									"className": 'text-center'
								},
								{
									"targets": [ 4 ],
									"className": 'text-center'
								}

							],
					});
		
	}
	function search_sya(){
		
				var url = "<?php echo site_url('stomp/xids/searchuser2')?>" ;
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
								{"data":"npp",},
								{"data":"nama"},
								{"data":"pos_name"},
								{"data":"accOffice","width": "2%"},
								{"data":"nama_unit"},
								{"data":"nohp"}
								
							],
							"columnDefs": [
								{  
									"targets": [ 0 ], //first column / numbering column
									"orderable": false,
								},
								{
									"targets": [ 1 ],
									"className": 'text-center'
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
.ui-autocomplete {
    max-height:400px;
    overflow-y: auto;
	overflow-x: hidden;
}
* html .ui-autocomplete {
    height: 50px;
}
button{
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
}
ul{
	padding: 0 20px;
}
.break-all{
    word-break: break-word;
}
</style>
<?php if ( $_SESSION['pengguna']->idm_idadmin == 4){?> 
<div id="wrap" style="padding: 0 20px 0 20px;">
<?php }else{ ?> 
<div id="wrap" style="padding: 0 40px 0 40px;">
<?php } ?>
	<div id="tokenDiv" style="padding:0; margin:0 auto;">
		<form action="#" id="form1" style="width: auto; margin: 0 auto;margin-top: 5%;">
			<p class="formHeader" style="font-size: 30px;">Cek User</p>
			<input type="hidden" value="" name="reqtype" id="reqtype">
			<input type="hidden" value="" name="identity" id="userclass">
			<div class="form-group row" style="margin: auto;padding: 10px;">
								<p>
				<div class="input-group" style ="width:61%; margin-right:auto; margin-left: auto;">
				  <input type="text" id="search" class="form-control" placeholder="Search by NPP or Name" onclick="$(this).val('');">
				  <span class="input-group-btn">
					<button class="btn btn-success"  id="proses" type="button">
						<i class="fa fa-search"></i>
					</button>
				  </span>
				</div>
			</p>
			<p style="padding-top: 5%">
				<table id="info_user" class="table table-striped table-bordered" style="width:100%; ">
					<thead>
						<tr class="success" style ="text-align: center;">
							<th>NPP</th>
							<?php if ( $_SESSION['pengguna']->accoffice < 800){?>
							<th>User ICONS</th>
							<?php } ?>
							<th>Nama</th>
							<th>Posisi</th>
							<th>Kode Unit</th>
							<th>Nama Unit</th>
							<?php if ( $_SESSION['pengguna']->idm_idadmin > 3){?> 
							<th id="email" >Email</th>
							<?php } ?> 
							<?php if ( ($_SESSION['pengguna']->idm_idadmin > 3) or ($_SESSION['pengguna']->idm_super > 0)){?> 
							<th>No Handphone</th>
							<?php if ( $_SESSION['pengguna']->idm_idadmin > 3 and $_SESSION['pengguna']->accoffice < 800){?>
							<th>Aplikasi</th>
							<?php }} ?>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
					
        <tbody>
			</p>
			</div>							
		</form>
	</div>
</div>
