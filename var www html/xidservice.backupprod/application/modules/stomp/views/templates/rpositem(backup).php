<script type="text/javascript">
	
	function  <?php echo $modal_id;?>_trigger(fdata){
		console.log(fdata);
		$('#div_btn_<?php echo $modal_id;?> button').hide();
		
		if (fdata['flag'] == null){
			console.log(fdata);
			fillform(fdata);
		} else {
			$.ajax({
						url : "<?php echo site_url('')?>" + fdata['url'],
						type: "POST",
						data: fdata,
						dataType: "JSON",
						success: function(data){
							fillform(data);
						}
			});
		}
		
		$("#<?php echo $modal_id;?> #posname").autocomplete({  
				minLength: "2",  
				source:   
				function(request, response){  
				console.log('test');
					$.ajax({  
						url: "<?php echo site_url('mposition/temppos/pos_search')?>",  
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
				select: function( event, ui ) {					
					$('#positionid').val(ui.item.rvalue.positionid);
				}	
			});
			
	};
	
	function fillform(data){
		$('#<?php echo $modal_id;?>_form #mode').val('RI');
		$('#<?php echo $modal_id;?>_form #id').val(data['id']);
		$('#loginid').val(data['loginid']);
		$('#name').val(data['name']);
		$('#posname').val(data['posname']);
		$('#<?php echo $modal_id;?>_form #nama').val(data['name']);
		$('#positionid').val(data['positionid']);
		$('#mobileNumber').val(data['mobileNumber']);
		
		if (data['stage'] != '1'){
			var arr_ro = "posname,mobileNumber".split(",");
			console.log(arr_ro);
			for(cid of arr_ro){
				$('#' + cid).attr('readonly', true);
			}
		} else {
			$("#<?php echo $modal_id;?>_form #btn_save").show()
		}
		
		
		
		/*for (val of wdata["eaction"]){
			$("#<?php echo $modal_id;?>_btn_" + val).show();
		}*/
	}
	
	function <?php echo $modal_id;?>_submit(btype){
		var fid = "#<?php echo $modal_id;?>";
		var fdata = {'reqtype': btype, "id" :  $(fid + " #id").val(), mode : 'RI', 
			loginid: $(fid + " #loginid").val(),  positionid: $(fid + " #positionid").val(),
			mobileNumber: $(fid + " #mobileNumber").val()
			};
		
		$.ajax({
			url : url = "<?php echo site_url('')?>rpositem" ,
			type: "POST",
			data: fdata,
			dataType: "JSON",
			success: function(data)
			{
				
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Submit Fail');
				$('#btnSave').attr('disabled',false); 
			}
		});
		$(fid + '_content').modal('hide');
		dt_rp_list.ajax.reload();
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

</style>
<div id="<?php echo $modal_id;?>_content" class="modal fade">
	<div class="modal-dialog ui-front" style="width: 500px;">
			<div class="modal-content" style="padding: 10px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" style="padding-left: 190px;">User Request</h3>
					<div style="width: 800px;">
					<div class="progressbar" id="progressbar"><span id="stagename" style="position:absolute; margin-left:10px; margin-top:2px"></span></div>
					<span id="lockinfo" style="position:absolute; margin-right:10px; margin-top:2px"></span>
				</div>
				</div>
						<div id="wfinfo" class="infohide">
							<label for="doneActor">Done</label> <ul id="doneActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
								<label for="currActor">Curr</label> <ul id="currActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
						</div>
					<div class="modal-body form">
					<form action="#" id="<?php echo $modal_id;?>_form" class="form-horizontal"> 				
						<div class="form-body">
							<div class="form-group">
								<label for="loginid">Login</label>
								<input id="loginid" name="loginid" class=" form-control" type="text" readonly="readonly">
							</div>
							<div class="form-group"> 
								<label class="control-label">Nama</label>
								<input name="name" id="name" placeholder="Nama" class="form-control" type="text"></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Posisi</label>
								<input id="posname" name="posname" placeholder="--- Posisi ----" class="autocomplete form-control" type="text" onclick="$(this).val('');"/>   
							</div>
							<div class="form-group">
								<label class="control-label">Posisi ID</label>
								<input name="positionid" id="positionid" placeholder="Posisi ID" class="form-control" readonly="readonly" type="text"/> 
							</div>
							<div class="form-group"> 
								<label class="control-label">No HP</label>
								<input id="mobileNumber" name="mobileNumber" placeholder="Nomor HP" class="form-control" type="text"></textarea>
								<input name="reqid" id="reqid" class="form-control" type="hidden" >
							</div>
						</div>
						
						
						<input name="status" id="status" class="form-control" type="hidden" >
						<input name="id" id="id" class="form-control" type="hidden" >
						<input name="mode" id="mode" class="form-control" type="hidden" >
						<input name="reqtype" id="reqtype" class="form-control" type="hidden" >						
					
					<div class="modal-footer" id="div_btn_<?php echo $modal_id;?>">
						<div class="col-xs-6" style="text-align: left;">
							<button type="button" id="btn_save" onclick="<?php echo $modal_id;?>_submit('save')" class="btn btn-primary">Save</button>
						</div>
					</div>
					</form>
				</div>	
			</div>
		</div>
	</div>