<!DOCTYPE html>
<html>
<head> 
	<style type="text/css">
		.ui-autocomplete { height: 300px; overflow-y: scroll; overflow-x: hidden;}
		.width100 {width: 100px;}
	</style>
</head> 
<body>
    
	<script type="text/javascript">
	
		/*$(document).ready(function() {
			$("button").click(function(){
				$(".form-group-1").hide();
			});
		});*/
		
		function save_request()
		{
			
			//var url = "<?php echo site_url('stomp/xbanc/query_id')?>" ;
			var url = "<?php echo site_url('stomp/xbanc/save_priv')?>" ;

			// ajax adding data to database
			$.ajax({
				url : url,
				type: "POST",
				data: $('#form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					if (data['status'].startsWith('EXIST')){
						$('#nama').val(data['TellerName']); 
						
						//$('#mobileNumber').val(data['Branch']);
						$('#branchcode').val(data['brch_no']);
						
						//addnew ryanda
						$('#grouptransc').val(data['grp_no']);
						$('#lvlcap').val(data['capable']);
						$('#cposname').val(data['cposname']);
						$('#securitycode').val(data['access_secur_code']);
						$('#trx_dt').val(data['transc_date']);
						$('#duration').val(data['transc_dur']);
						//addnew ryanda
						
						//$('#pretext').text(JSON.stringify(data)); 
						console.log(JSON.stringify(data)); 
						$('#pretext').text('Valid'); 
					} else {
						$('#pretext').text('Not Valid'); 
					}
					
					//$('#btnSave').attr('disabled',false); //set button enable 
				},
				
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error adding / update data' + jqXHR.responseText); 
					$('#btnSave').text('save'); //change button text
					$('#btnSave').attr('disabled',false); //set button enable 
				}
			});
		}
		
		function query_id()
		{
			
			var url = "<?php echo site_url('stomp/xbanc/query_id')?>" ;
			//var url = "<?php echo site_url('stomp/xbanc/query_id_dmy')?>" ;
			
			$('#pretext').text('---'); 
			// ajax adding data to database
			$.ajax({
				url : url,
				type: "POST",
				data: $('#form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					if (data['status'].startsWith('EXIST')){
						$('#nama').val(data['TellerName']); 
						//$('#mobileNumber').val(data['Branch']);
						$('#branchcode').val(data['Branch']);
						
						$('#nppicons').val(data['NPP']);
						//addnew ryanda
						$('#grouptransc').val(data['GroupTrx']);
						$('#lvlcap').val(data['Capability']);
						$('#cposname').val(data['cposname']);
						$('#cposid').val(data['cposid']);
						
						$('#securitycode').val(data['access_secur_code']);
						$('#trx_dt').val(data['transc_date']);
						$('#duration').val(data['transc_dur']);
						//addnew ryanda
						
						//$('#pretext').text(JSON.stringify(data)); 
						console.log(JSON.stringify(data)); 
						$('#pretext').text('Valid'); 
					} else {
						$('#pretext').text('Not Valid'); 
					}
					
					//$('#btnSave').attr('disabled',false); //set button enable 
				},
				
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error adding / update data' + jqXHR.responseText); 
					$('#btnSave').text('save'); //change button text
					$('#btnSave').attr('disabled',false); //set button enable 
				}
			});
		}

	</script>

	<!-- Bootstrap modal -->
	
			<div class="modal-content" style="padding: 10px; width: 726px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" style="padding-left: 190px; padding-right: 190px; text-align: center">Ubah Level Kapabilitas</h3>
				</div>
				<div class="modal-body form">
					<form action="#" id="form" class="form-horizontal">
						<input type="hidden" value="" name="id"/> 
						<div class="form-body">
							<div class="form-group">
								<label for="npp">User ID</label>
								<input name="npp" id="npp" placeholder="NPP" class=" form-control" type="text" value="51981">
							</div>
							<div class="form-group"> 
								<label class="control-label">Npp(Icons)</label>
								<input name="nppicons]" id="nppicons" placeholder="nppicons" class="form-control" type="text" readonly="true">
							</div>
							<div class="form-group"> 
								<label class="control-label">Nama</label>
								<input name="name" id="nama" placeholder="Nama" class="form-control" type="text">
							</div>
							<div class="form-group"> 
								<label class="control-label">Posisi skrg</label>
								<input name="cposname" id="cposname" placeholder="cposname" class="form-control" type="text" readonly="true">
								<input name="cposid" id="cposid" type="hidden" readonly="true">
							</div>
							
							<!--add new ryanda-->
							<div class="form-group"> 
								<label class="control-label">Posisi Target</label>
								<input name="tposname" id="tposname" placeholder="cposname" class="form-control" type="text" readonly="true">
								<input name="tposid" id="tposid" type="hidden" readonly="true">
							</div>
							<!--add new ryanda-->
							
						
							<div class="form-group">
								<label class="control-label">Level Kapabilitas</label>
								<input name="lvlcap" id="lvlcap" placeholder="Level Kapabilitas" class="form-control" type="text">
							</div>
							
							<div class="form-group">
								<label class="control-label">Tanggal Efektif</label>
								<input name="trx_dt" id="trx_dt" placeholder="Tanggal Efektif" class="form-control" type="text"></textarea>
							</div>
							
							<div class="form-group">
								<label class="control-label">Durasi</label>
								<input name="duration" id="duration" placeholder="Durasi" class="form-control" type="text"></textarea>
							</div>
							<!-- add new ryanda-->
							
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnSave" onclick="query_id()" class="btn btn-primary">Get</button>
					<button type="button" id="btnSave" onclick="save_request()" class="btn btn-primary">Ubah level</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</div><!-- /.modal-content -->
		<pre id="pretext" style="width: 726px;">
			dadsa
			adasd
		</pre>
	<!-- End Bootstrap modal -->
</body>
</html>