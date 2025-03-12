<script type="text/javascript">
	
	$(document).ready(function() {
/* 		$('#accoffice').change(function()
		{                   
			if($(this).val() == ''){
				alert('empty');  
			}else{
				alert('yeay');
			}
		}); */
	});
	
	
	
	function  <?php echo $modal_id;?>_trigger(fdata){
		$("#pname").autocomplete({  
				minLength: "2",  
				source:   
				function(request, response){  
				console.log('test');
					$.ajax({  
						url: "<?php echo site_url('stomp/xids/quer_pos')?>",  
						dataType: 'json',  
						type: 'POST',  
						data: {
							pattern: request.term,
							accoffice: $('#accoffice').val() 
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
						alert("Silahkan pilih posisi baru");
						$('#pname').val('');
					}
        },
				select: function( event, ui ) {					
					$('#posid').val(ui.item.rvalue.positionid);
				}	
			});
	};
		function query_npp()
		{	
		
			//$('#loginid').removeAttr('readonly').removeAttr('style');
			var url = "<?php echo site_url('stomp/xids/query_sco')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: $('[name="npp"]').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					//alert(data.snpp.length);
					if (data.snpp == null){
						//alert("SCO tidak ditemukan");
						$('[name="nama"]').val(data.nama);
					}else{
						//alert("SCO ditemukan");
						$('[name="nama"]').val(data.nama);
						$('[name="snpp"]').val(data.snpp);
						$('[name="accoffice"]').val(data.unit);
						$('[name="pname"]').val(data.pname);
						$('[name="posid"]').val(data.posid);
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Data yang anda input belum lengkap');
					$('#' + cid).attr('readonly', true).attr("style", "pointer-events: none;");
				}
				
			});
			
		}
		
		function btn_save(){
						var url = "<?php echo site_url('stomp/xids/save_sco')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: {
							npp: $('#npp').val(),
							nama: $('#nama').val() ,
							sco: $('#snpp').val(),
							accoffice: $('#accoffice').val() ,
							posid: $('#posid').val()
					},
				dataType: "JSON",
				success: function(data)
				{
					alert("Data berhasil diupdate");
					$('#<?php echo $modal_id;?>_content').modal('hide');
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Data gagal diupdate');
					$('#' + cid).attr('readonly', true).attr("style", "pointer-events: none;");
				}
				
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
.red-tooltip + .tooltip > .tooltip-inner {background-color: #DCDCDC;}
</style>
<div class="container">
  <!-- Modal -->
  <div class="modal fade"  id="<?php echo $modal_id;?>_content"  role="dialog" data-backdrop="static">
    <div class="modal-dialog">
		<div id="wrap">
		<form action="#" id="<?php echo $modal_id;?>_form" role="form">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">ADD SCO</p>
			<p class="judul" align= "center" style="margin-left:25%; width:70%;color: red;" id="lockinfo" ></p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row"style="width:90%;margin-left:6%;">
				<p id="l-login">					
					<label class="judul" >NPP</label>
					<input name="npp" id="npp" placeholder="NPP" class="form-control" onchange="query_npp()" onclick="$('#npp, #nama,#snpp, #accoffice, #NIK, #pname').val('').removeAttr('readonly').removeAttr('style');" type="text">
				</p>
				<p>
					<label class="judul">Nama</label>
					<input name="nama" id="nama" placeholder="Nama" class="form-control" type="text" >
				</p>
				<p>
					<label class="judul">User SCO</label>
					<input name="snpp" id="snpp" placeholder="SCO"  class=" form-control" type="text" >
				</p>
				<p>
					<label class="judul">Unit</label>
					<input name="accoffice" id="accoffice" placeholder="Unit" onclick="$(' #accoffice, #posid, #pname').val('').removeAttr('readonly').removeAttr('style');"class=" form-control" type="text" >
				</p>
				<p>
					<label class="judul">Posisi</label>
					<input name="pname" id="pname" placeholder="Ketik 2 angka sequence" class="autocomplete form-control" type="text" onclick="$(this).val(''); $('#tposid').val('');" >
					<input name="posid" id="posid" type="hidden">
				</p>
				<p  class="signin button" >
						<br>
						<button type="button" id="save" onclick="btn_save()" class="btn btn-info">submit</button>
				</p>
			</div>							
		</form>
	</div>
    </div>
  </div>
  
</div>