<head>
<!--<script src="/tstomp/bucky.js" data-bucky-host="/bucky" data-bucky-page="idssite-createuser"/>-->
</head>

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
						
						
						var lockInfo = "";
						if (wdata['locked'])
							lockInfo = " locked by " + wdata['lockActor'] + " -- " + wdata['lockDate'];
							
						$('#progressbar').progressbar({value: wdata['currScore']/wdata['targetScore'], max: 1});
						$('#stagename').html(wdata['pname'] + " (" + wdata['currScore'] + "/" + wdata['targetScore'] + ")");
						$('#lockinfo').html(lockInfo);
						
						$('#currActor').html(jsonFlat(wdata['currActor']));
						
						$('#doneActor').html(arrFlat(wdata['doneActor']));
						
						//$('#id').val(wdata['id']);
						//$('#<?php echo $modal_id;?>_form wfid').val(data['wfid']);
						$('#mode').val(wdata['mode']);
						$('#nik').val(rdata['nik']);
						$('#mobileNumber').val(rdata['mobileNumber']);
						$('[name="nama"]').val(rdata.nama);
						$('#address').val(rdata['address']);
						$('#DOB').val(rdata['DOB']);
						//$( "#DOB" ).datepicker({ dateFormat: 'dd-mm-yy' }).val(rdata['DOB']);
						$('#positionid').val(rdata['positionid']);
						$('#pname').val(rdata['pname']);
						$('#npp').val(rdata['npp']);
						$('#loginid').val(rdata['loginid']);
						$('#email').val(rdata['email']);
						$('#<?php echo $modal_id;?>_form #id').val(data['wfid']);
						if (fdata['reqtype'] == "read_list"){
							$('[id="div_btn_<?php echo $modal_id;?>"]').hide();
							var arr_ro = "npp,loginid,nik,email,address,nama,mobileNumber,DOB,pname".split(",");
										for(cid of arr_ro){
											$('#' + cid).attr('readonly', true);
											
										}
							$('[name="pname"]').attr('readonly', true);
							$('[name="name"]').attr('readonly', true);
							$('[name="mobileNumber"]').attr('readonly', true);
							$('[name="nik"]').attr('readonly', true);
						}else{
							for (val of wdata["eaction"]){
								$("#<?php echo $modal_id;?>_btn_" + val).show();
							}
						}
						
						if (wdata['stage'] != '1'){
							var arr_ro = "npp,loginid,nama,email,nik,mobileNumber,DOB,pname,address".split(",");
							console.log(arr_ro);
							for(cid of arr_ro){
								$('#' + cid).attr('readonly', true).attr("style", "pointer-events: none;");
							}
						}else{
							var url = "<?php echo site_url('stomp/xids/cek')?>" ;
							$.ajax({
								url : url,
								type: "POST",
								data: $('[name="npp"]').serialize(),
								dataType: "JSON",
								success: function(data)
								{
									if (data != null){
										var arr_ro = "npp,loginid,email,nama,mobileNumber,DOB,pname".split(",");
										for(cid of arr_ro){
											$('#' + cid).attr('readonly', true).attr("style", "pointer-events: none;");
										}
									}if (fdata['reqtype'] == "read_list"){
							$('[id="div_btn_<?php echo $modal_id;?>"]').hide();
							var arr_ro = "npp,loginid,nik,email,address,nama,mobileNumber,DOB,pname".split(",");
										for(cid of arr_ro){
											$('#' + cid).attr('readonly', true);
											
										}
							$('[name="pname"]').attr('readonly', true);
							$('[name="name"]').attr('readonly', true);
							$('[name="mobileNumber"]').attr('readonly', true);
							$('[name="nik"]').attr('readonly', true);
						}else{
										$('#npp' ).attr('readonly', true).attr("style", "pointer-events: none;");
										$('#nama,#loginid, #mobileNumber, #NIK, #pname, #DOB').removeAttr('readonly').removeAttr('style');
									}
								}
							});
						}
						
						
					}
			});
		}
		else {
			$('#<?php echo $modal_id;?>_form #btn_save').show();
			$('#npp').click(function() {
				$('#<?php echo $modal_id;?>_form #btn_save').show();
				$('#tanggal').show();
			});
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
		$('#progressbar').click(function(){
			var ctarget = $('#wfinfo');
			if (ctarget.hasClass('infohide'))
				ctarget.removeClass('infohide');
			else
				ctarget.addClass('infohide');
		});	
		
	$.validator.addMethod('regex', function(value, element, param) {
        return this.optional(element) ||
            value.match(typeof param == 'string' ? new RegExp(param) : param);
    },
    'Please enter a value in the correct format.');
		$(function() {
		 var validate = $("#<?php echo $modal_id;?>_form").validate({
                rules: {
                    npp: {
                        required: true,
                        minlength: 5,
						digits: true
                    },
					mobileNumber: {
						required: true,
						minlength: 1,
						regex: /^[0-9]+$/
					},
					nik: {
                        required: true,
						minlength: 1,
						digits: true
                    },
					nama: {
                        required: true,
						minlength: 1
                    },
					DOB: {
                        required: true,
						minlength: 1
                    },
					address: {
                        required: true,
						minlength: 1
                    },
					pname: {
                        required: true,
                        minlength: 3
                    },
					email: {
                        required: true,
                        minlength: 1,
						regex: /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i
                    },
                },
                messages: {
					npp: {
						required: "Please enter npp",
						minlength: "Your npp must be at least 5 number long"
					},
					mobileNumber: {
						required: "Please enter mobile number",
						minlength: "Please enter mobile number",
						regex: 'Your mobile number must be number.'
					},
					nama: "Please enter name ",
					nik: "Please enter NIK ",
					DOB: "Please enter Birthday ",
					address: "Please enter Address",
					pname: "Please enter Position",
					email: {
						required: "Please enter email",
						regex: 'Wrong input email'
					}
                },
            });
			$('#<?php echo $modal_id;?>_btn_cancel').on('click', function (e) {
				e.preventDefault();
				validate.destroy();
				$('#<?php echo $modal_id;?>_form').get(0).reset();
			});
		});
	};
	
	function <?php echo $modal_id;?>_submit(btype){
		//$('#npp,#nama,#loginid, #mobileNumber, #NIK, #nik, #pname, #DOB, #alamat, #address').removeAttr('disabled');
		var fdata = {'url': 'wf/wfaction', 'modal_id' : "<?php echo $modal_id;?>", 'btype': btype };
		
		var isValid = $("#<?php echo $modal_id;?>_form").valid();
		console.log(isValid);
				var cpos = $('#positionid').val();
			if (cpos.length < 1){
				alert("please select position name");
				$('#pname').val('');
				
				return ;
			}
		if (isValid)
			action_submit(fdata);
	}	
	
	function query_npp()
		{	
			$('#loginid').removeAttr('readonly').removeAttr('style');
			var url = "<?php echo site_url('stomp/xids/query_npp')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: $('[name="npp"]').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					if (data != null){
					var dob = data.DOB;
				
					if(data.DOB != null){
						$('#tanggal').hide();	
					}else{
						$('#tanggal').show();
					}	
					/* var arr_ro = "nama,DOB,pname,mobileNumber".split(",");
							//console.log(arr_ro);
							for(cid of arr_ro){
								//$('#' + cid).attr('disabled', true);
								$('#' + cid).attr('readonly', true).attr("style", "pointer-events: none;");
							} */
					
					$('[name="nama"]').val(data.name);
					$('[name="NIK"]').val(data.NIK);
					// $("#date").val( moment().format('MMM D, YYYY') );
					
					//$('[name="DOB"]').val(date("Y-m-d h:i:s",strtotime(data.DOB)));
					//$('#DOB').val(data.DOB).datepicker({ dateFormat: "dd-mm-yYYy" });
					$('[name="mobileNumber"]').val(data.mobileNumber);
					$('[name="address"]').val(data.address);
					$('[name="pname"]').val(data.posname);
					$('[name="positionid"]').val(data.positionid);
					
					$('input[type=text]').each(function(){
					   if($(this).val().length > 0){
						$(this).attr('readonly', true).attr("style", "pointer-events: none;");
					   }
					$('#<?php echo $modal_id;?>_form #btn_save').hide();	
					})
					$('[name="npp"]').removeAttr('readonly').removeAttr('style');
					
					}else {
						alert("User Belum Terdaftar");
						$(' #nama,#loginid, #mobileNumber, #NIK, #pname, #DOB').val(null);
						$('#nama,#loginid, #mobileNumber, #NIK, #pname, #DOB, #pname').removeAttr('readonly').removeAttr('style');
						//$('#nama,#loginid, #mobileNumber, #NIK, #pname, #DOB').removeAttr('disabled');
						//$('#nama,#loginid, #mobileNumber, #NIK, #pname, #DOB').attr('form', true);
						$('#<?php echo $modal_id;?>_form #btn_save').show();
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Data yang anda input belum lengkap');
					$('#' + cid).attr('readonly', true).attr("style", "pointer-events: none;");
				}
				
			});
			
		}
	/* function query_loginid()
		{		
			var url = "<?php echo site_url('stomp/xids/query_id')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: $('[name="loginid"]').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					$('[name="pname"]').val(data.pname);
					$('[name="positionid"]').val(data.positionid);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		} */
</script>
<style>
#<?php echo $modal_id;?>_form label.error {
    color: red;
	font-size: 11px;
	width: 90%;
}

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
  <div class="modal fade"  id="<?php echo $modal_id;?>_content"  role="dialog" data-backdrop="static">
    <div class="modal-dialog">
		<div id="wrap">
		<form action="#" id="<?php echo $modal_id;?>_form" role="form">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Tambah User Baru</p>
			<p class="judul" align= "center" style="margin-left:25%; width:70%;color: red;" id="lockinfo" ></p>
			<div id="wfinfo" class="infohide"style="margin-right: 8%;margin-left: 9%">
				<label for="doneActor">Done</label> <ul id="doneActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
				<label for="currActor">Curr</label> <ul id="currActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
			</div>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row"style="width:90%;margin-left:6%;">
				<p id="l-login">					
					<label class="judul" >NPP</label>
					<input name="npp" id="npp" placeholder="NPP" class="form-control" onchange="query_npp()" onclick="$('#npp, #nama,#loginid, #mobileNumber, #NIK, #pname, #DOB').val('').removeAttr('readonly').removeAttr('style');" type="text">
				</p>
				<p class="row fl-controls-left" style="display: none">
							<label>LoginID</label> 
							<input name="loginid" id="loginid" placeholder="Login" onchange="query_loginid()" class="form-control" type="hidden" style="height: 30px; font-size: 90%">
				</p>	
				<p>
					<label class="judul">Nama</label>
					<input name="nama" id="nama" placeholder="Nama" class="form-control" type="text" >
				</p>
				<p>
					<label class="judul">NIK</label>
					<input name="nik" id="nik" placeholder="NIK"  class=" form-control" type="text" >
				</p>
				<p>
					<label class="judul">Ponsel</label>
					<input name="mobileNumber" id="mobileNumber" placeholder="Ponsel" class=" form-control" type="text" >
				</p>
				<p id ="tanggal">
					<label class="judul">Tanggal Lahir</label>
					<input name="DOB" id="DOB" placeholder="Tanggal Lahir" class="form-control" type="text" >
				</p>
				<p>
					<label class="judul">Email</label>
					<input name="email" id="email" placeholder="Email" class=" form-control" type="text" >
				</p>
				<p>
					<label class="judul">Alamat</label>
					<input name="address" id="address" placeholder="Alamat" class="form-control" type="text" >
				</p>
				<p>
					<label class="judul">Posisi</label>
					<input name="pname" id="pname" placeholder="--- Posisi ---" class="autocomplete form-control" type="text" onclick="$(this).val(''); $('#tposid').val('');" >
					<input name="positionid" id="positionid" type="hidden">
				</p>
					<input name="id" id="id" class="form-control" type="text" >
					<input name="mode" id="mode" class="form-control" value="UA" type="hidden" >
					<input name="wfid" id="wfid" class="form-control" type="hidden" >	
					<input name="reqtype" id="reqtype" class="form-control" type="text" >	
					<input name="notes" id="notes" class="form-control" type="hidden" >	
					<br/>						
				<p  class="signin button" id="div_btn_<?php echo $modal_id;?>">
						<br>
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