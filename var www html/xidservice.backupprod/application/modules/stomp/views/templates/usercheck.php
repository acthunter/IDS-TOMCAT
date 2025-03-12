<script type="text/javascript">
	function  <?php echo $modal_id;?>_trigger(fdata){
		console.log(fdata);
		$('#div_btn_<?php echo $modal_id;?> button').hide();
		
		if (fdata['reqtype'] != "new"){
			$.ajax({
				url : "<?php echo site_url('')?>" + fdata['url'],
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function(wdata){
					var data = wdata['detail'];
					var rdata = data['data'];
					console.log(wdata);
						
					$('#reqid').val(wdata['id']);
					$('#loginid').val(rdata.npp);
					$('#mode').val(wdata['mode']);
					
					$('#nama').val(rdata.nama);
					$('#DOB').val(rdata['DOB']);
					$('#email').val(rdata['email']);
					$('#mobileNumber').val(rdata['mobileNumber']);
					$('#pname').val(rdata['pname']);
					$('#positionid').val(rdata['positionid']);										
						
					if (wdata['stage'] != '1'){
						$('input[type=radio]').attr('disabled', true);
						var arr_ro = "loginid,nama,DOB,email,mobileNumber,pname".split(",");
						console.log(arr_ro);
						for(cid of arr_ro){
							$('#' + cid).attr('disabled', true);
						}
					} else {
/* 						var arr_ro = "loginid".split(",");
						for(cid of arr_ro){
							$('#' + cid).attr('readonly', true).css('pointer-events', 'none');
						} */
						$('input').each(function() {
							if ($(this).val().length != 0) {
								$(this).attr('readonly', true).css('pointer-events', 'none');
							}
						});
					}
						
					$('#<?php echo $modal_id;?>_form #id').val(data['id']);
					$('#<?php echo $modal_id;?>_form #reqid').val(data['reqid']);
						
					for (val of wdata["eaction"]){
						$("#<?php echo $modal_id;?>_btn_" + val).show();
					}							
				}
			});
		} else {
			$('#<?php echo $modal_id;?>_form #btn_save').show();
		}
		
		$("#<?php echo $modal_id;?> #pname").autocomplete({  
			minLength: "2",  
			source:   
			function(request, response){  
				console.log('test');
				$.ajax({  
					url: "<?php echo site_url('stomp/xids/pos_search')?>",  
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
					alert("Silahkan pilih posisi baru");
					$('#pname').val('');
				}
			},
			select: function( event, ui ) {					
				$('#positionid').val(ui.item.rvalue.positionid);
			}	
		});
		
		$(function () {
			$('#DOB').datetimepicker({
				format:'DD-MM-YYYY', widgetPositioning: { vertical: 'bottom' }
			});
		});
	}	
		 
	function <?php echo $modal_id;?>_submit(btype){
		var fdata = {'url': 'wf/wfaction', 'modal_id' : "<?php echo $modal_id;?>", 'btype': btype };	
		var isValid = $("#<?php echo $modal_id;?>_form").valid();
		console.log(isValid);
		if (isValid)
			action_submit(fdata);
		else
			alert("Silahkan input data terlebih dahulu");
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
</style>

<div class="container">
	<!-- Modal -->
	<div class="modal fade"  id="<?php echo $modal_id;?>_content" role="dialog" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-body">
				<div id="wrap">
					<form action="#"  id="<?php echo $modal_id;?>_form"  role="form">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<p class="formHeader" style="font-size: 30px;">Cek User</p>
						<input type="hidden" value="" name="reqtype" id="reqtype"/>
						<input type="hidden" value="" name="identity" id="userclass"/>
						<div class="form-group row" style="width:90%;margin-left:6%;">
							<p>
								<label class="judul">LoginID</label>
								<input name="loginid" id="loginid" placeholder="LoginID" class="form-control" type="text" >
							</p>
							<p>
								<label class="judul">Nama</label>
								<input name="nama" id="nama" placeholder="Nama" class="form-control" type="text" >
							</p>
							<p>
								<label class="judul">Tanggal Lahir</label>
								<input name="DOB" id="DOB" placeholder="Tanggal Lahir" class="form-control" type="text" >
							</p>
							<p>
								<label class="judul">Email</label>
								<input name="email" id="email" placeholder="Email" class="form-control" type="text" >
							</p>
							<p>
								<label class="judul">No HP</label>
								<input name="mobileNumber" id="mobileNumber" placeholder="No HP" class="form-control" type="text" >
							</p>
							<p>
								<label class="judul">Posisi</label>
								<input name="pname" id="pname" placeholder="--- Posisi ---" class="autocomplete form-control" type="text" onclick="$(this).val(''); $('#tposid').val('');" >
								<input name="positionid" id="positionid" type="hidden">
							</p>
							<ul style="font-size:12px;color: red;margin-bottom: 25px; margin-top: -9px;
							margin-left:-30px;">
								<label style="margin-left: -5px;margin-top: 10px;">Catatan : </label>
								<li>Jika posisi belum tersedia silahkan disetting posisi </b>Cuti<b></li>
							</ul>
							<input name="tposid" id="tposid" readonly type="hidden">
							<input name="status" id="status" class="form-control" type="hidden" >
							<input name="id" id="id" class="form-control" type="hidden" >
							<input name="mode" id="mode" class="form-control" type="hidden" value="UC" >
							<input name="reqid" id="reqid" class="form-control" type="hidden" >
							<input name="reqtype" id="reqtype" class="form-control" type="hidden">
							<input name="srctype" id="srctype" class="form-control" type="hidden">						
							<input name="notes" id="notes" class="form-control" type="hidden" >
							<input name="accoffice" id="accoffice" class="form-control" type="hidden" >					
							<p  class="signin button" id="div_btn_<?php echo $modal_id;?>" style="margin-left: -10%">
								<button type="button" id="btn_save" onclick="<?php echo $modal_id;?>_submit('save')" class="btn btn-primary">Save</button>
								<button type="button" id="<?php echo $modal_id;?>_btn_submit" onclick="<?php echo $modal_id;?>_submit('submit')" class="btn btn-primary">Submit</button>
								<button type="button" id="<?php echo $modal_id;?>_btn_cancel" onclick="<?php echo $modal_id;?>_submit('cancel')" class="btn btn-danger">Cancel</button>
								<button type="button" id="<?php echo $modal_id;?>_btn_approve" onclick="<?php echo $modal_id;?>_submit('approve')" class="btn btn-primary">Approve</button>
								<button type="button" id="<?php echo $modal_id;?>_btn_reject" onclick="<?php echo $modal_id;?>_submit('reject')" class="btn btn-danger">Reject</button>
								<button type="button" id="<?php echo $modal_id;?>_btn_release" onclick="<?php echo $modal_id;?>_submit('release')" class="btn btn-default">Release</button>
							</p>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>