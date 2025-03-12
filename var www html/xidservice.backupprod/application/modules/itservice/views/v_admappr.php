<script type="text/javascript">
$(document).ready(function(){

	$('#info_user').hide();
		$('#proses').click(function(){
			$('#info_user').show();
				search() ;
		});
		
		$("#search").autocomplete({  
				minLength: "2",  
				source:   
				function(request, response){  
				console.log('test');
					$.ajax({  
						url: "<?php echo site_url('itservice/xmain/search_unit')?>",  
						dataType: 'json',  
						type: 'POST',  
						data: {
							pattern: request.term
						}, 
						success:      
						function(data){  
							response($.map(data, function (item) {
								return {
									value: item.pname,
									rvalue: item
								}
							}))
						},  
					});  
				},
				change: function (event, ui) {
					if (ui.item === null) {
						$(this).val('');
						alert("Silahkan pilih unit yang akan dicari");
						$('#search').val('');
					}
				},
				select: function( event, ui ) {					
					$('#accOffice').val(ui.item.rvalue.accOffice);
				}	
			});
});

	function search(){
				var url = "<?php echo site_url('itservice/xmain/searchauth')?>" ;
			tabel = $('#info_user').DataTable({ 
			"destroy": true,
				"searching": false,
				"order": [],
				"pageLength": 3,				
				"aLengthMenu": [[ 3, 10, 15, -1], [ 3, 10, 15, "All"]],
				"iDisplayLength": 5,
							"ajax": {
								"url": url ,
								"type": "POST",
								"dataType": "JSON",
								"data" : function ( data ) {
									data.unit = $('#accOffice').val();
								} 
							},
							"columns" : [
								{"data":"kode",},
								{"data":"nama_unit", "width": "15%"},
								{"data":"npp"},
								{"data":"nama"},
								{"data":"posisi","width": "2%"},
								{"data":"adm"} 
								
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
								},
								{
									
									"targets": [ 5 ],
									"render": function(data,type, row){

										if (row['appr'] > 0 && row['adm'] > 0){
											var auth = 'Approval,Admin'
											var arry = auth.split(",");
											var str = '<ul>'
												arry.forEach(function(slide) {
												  str += '<li>'+ slide + '</li>';
												}); 

												str += '</ul>';
											var step = str;
										}else if (row['appr'] > 0){
											var step = "Approval";
										}else{
											var step = "Admin";
										}
										
										return step;
									}, 
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
</style>
<div id="wrap" style="padding: 0 90px 0 90px;">
	<div id="tokenDiv" style="padding:0; margin:0 auto;">
		<form action="#" id="form1" style="width: auto; margin: 0 auto;margin-top: 5%;">
			<p class="formHeader" style="font-size: 30px;">Cek Kewenangan SSO</p>
			<input type="hidden" value="" name="reqtype" id="reqtype">
			<input type="hidden" value="" name="identity" id="userclass">
			<div class="form-group row" style="margin: auto;padding: 10px;">
								<p>
				<div class="input-group" style ="width:61%; margin-right:auto; margin-left: auto;">
				  <input type="text" id="search" class="form-control" placeholder="Search by Kode Unit" onclick="$(this).val('');">
				  <input name="accOffice" id="accOffice" placeholder="accOffice" class="form-control" type="hidden">
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
							<th>Kode Unit</th>
							<th>Nama Unit</th>
							<th>NPP</th>
							<th>Nama</th>
							<th>Posisi</th>
							<th>Kewenganan</th>							
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
