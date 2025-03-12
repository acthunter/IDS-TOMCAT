<script type="text/javascript">
	
	$(document).ready(function() {
		$("input[name$='same']").click(function() {
			var test = $(this).val();

			$("div.desc").hide();
			$("#same" + test).show();
			});
		
		$("#tposid").change(function(){
			alert("test");
		});
		$('#new').click(function () {
			$('#<?php echo $modal_id;?>_form #btn_check').show();
			$('#<?php echo $modal_id;?>_form #btn_save').hide();
		});
		$('#loginid').click(function () {
			$('#loginid, #nama,#cposname,#tposname, #tposid').val('').text('');
			$('#pos_def, #showhp, #new-error').css('display', 'none');
			$('#div_btn_<?php echo $modal_id;?> button').hide();	
		});
		var dattime1 = new Date();
		var offset = -(dattime1.getTimezoneOffset()/60);
	});
	
	
	
	function  <?php echo $modal_id;?>_trigger(fdata){
		console.log(fdata);
		
		$('#div_btn_<?php echo $modal_id;?> button').hide();	
		 var time = new Date();
		 var hour_time = time.getHours();
		 if (hour_time >= 22 || hour_time <= 5 ){
			  //alert("Tidak dapat melakukan request SSO. Silahkan dicoba kembali lain hari");
			  $('#isi').hide();
			  $('#alert').show();
		 }else{
			  $('#alert').hide();
			  $('#isi').show();
		 }
		 $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });
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
						
						$('#wfid').val(wdata['id']);
						$('#loginid').val(rdata['loginid']);
						$('#mode').val(wdata['mode']);
						$('[name="nama"]').text(rdata.nama);
						$('[name="nama"]').val(rdata.nama);
						$('[name="cposname"]').text(rdata.cposname);
						$('[name="cposname"]').val(rdata.cposname);
						$('#cposid').val(rdata['cposid']);
						$('#tposname').val(rdata['pname']);
						$('#tposid').val(rdata['tpos']);
						$('#keterangan').val(rdata['note']);
						$('[name="old"]').val(rdata['nohp']);
						$('[name="oldtext"]').html(rdata['nohp']);
						$('[name="new"]').val(rdata['nohp_baru']);
						
						
						
						

						$('#<?php echo $modal_id;?>_form #id').val(data['id']);
						$('#<?php echo $modal_id;?>_form #wfid').val(data['wfid']);
						
						for (val of wdata["eaction"]){
							$("#<?php echo $modal_id;?>_btn_" + val).show();
						}
						if (fdata['reqtype'] == "read_list"){
							$('[id="div_btn_<?php echo $modal_id;?>"]').hide();
							var arr_ro = "new,loginid".split(",");
							console.log(arr_ro);
							for(cid of arr_ro){
								$('#' + cid).attr('disabled', true);
							}
						}else{
							if (wdata['stage'] != '1'){
							$('input[type=radio]').attr('disabled', true);
							$('#keterangan').hide();
							$('#ket').text(rdata['note']);
							var arr_ro = "new,tposname,sdate,edate,loginid".split(",");
							console.log(arr_ro);
							for(cid of arr_ro){
								$('#' + cid).attr('disabled', true);
							}
								
							}else{

								var arr_ro = "loginid".split(",");
								for(cid of arr_ro){
									$('#' + cid).attr('readonly', true).css('pointer-events', 'none');
								}
								var arr_ro2 = "new,loginid".split(",");
								for(cid2 of arr_ro2){
									$('#' + cid2).attr('disabled', true);
								}
							}
						}
							
					}
			});
			$('#pos_def').css("display", "block");

			
		}
		

		else {
			$('[id="showhp"]').hide();
			$('#pos_def').css("display", "none");
			$('#loginid').click(function() {
				var arr_ro = "new,tposname,sdate,edate".split(",");
				for(cid of arr_ro){
					$('#' + cid).attr('disabled', false);
				}
			});
			
		}
		
		$("#<?php echo $modal_id;?> #tposname").autocomplete({  
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
						$('#tposname').val('');
					}
				},
				select: function( event, ui ) {					
					$('#tposid').val(ui.item.rvalue.positionid);
				}	
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
		 $("#<?php echo $modal_id;?>_form").validate({
				errorPlacement: function(error, element) {
					//Custom position: first name
					if (element.attr("name") == "loginid" ) {
						$(".errorTxt").text(error);
					}if (element.attr("name") == "new" ) {
						$(".errorTxt").text(error);
					}
					
				},
				rules: {
                    loginid: {
                        required: true,
                        minlength: 5,
						digits: true
                    },
					new: {
						required: true,
						minlength: 1,
						digits: true
					},
                },
                messages: {
					loginid: {
						required: "Please enter loginid",
						minlength: "Your loginid must be at least 5 number long"
					},
					new: {
						required: "Silahkan input no handphone baru"
					}
                },
				errorPlacement: function (error, element) {
					var name = $(element).attr("name");
					error.appendTo($("#" + name + "_validate"));
				},
				highlight: function (element) {
					$(element).parent().addClass('error')
				},
				unhighlight: function (element) {
					$(element).parent().removeClass('error')
				},
                submitHandler: function(form) {
					console.log("about to submit");
                }
            });
			$('#<?php echo $modal_id;?>_content').validate(rules);
		});
		
	};
	
	function query_mobile()
		{	
			var val_mobile = $('#new').val();
			var url_mobile = "<?php echo site_url('stomp/xids/query_mobile')?>";
			if(val_mobile.match(/^\d+$/)) {
			$.ajax({
				url : url_mobile,
				type: "POST",
				data: {"mobileNumber": $('#new').val(),"type":'UH'},
				dataType: "JSON",
				success: function(data)
				{

					if (data != null ){
						if(data.mobileNumber != ' '){
							$('#new').val('');
							alert("No HP Telah terdaftar . Silahkan Menggunakan no HP lainnya");
						}else{
							$('#new').val('');
							alert("Silahkan Menggunakan no HP lainnya");							
						}
					}else{
						$('#<?php echo $modal_id;?>_form #btn_check').hide();
						$('#<?php echo $modal_id;?>_form #btn_save').show();
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Data yang anda input belum lengkap');
					$('#' + cid).attr('readonly', true).attr("style", "pointer-events: none;");
				}
				
			});
			}else{
				alert('Please enter only digits');
				$('#new').val(''); 
			}

			
		}
	
	function query_id()
		{		
			var url = "<?php echo site_url('stomp/xids/query')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: {"npp": $('#loginid').val()},
				dataType: "JSON",
				success: function(data)
				{
					var url2 = "<?php echo site_url('stomp/xids/get_number')?>" ;
					$.ajax({
						url : url2,
						type: "POST",
						data: {"npp": $('#loginid').val()},
						dataType: "JSON",
						success: function(data2)
						{
							if(data != null){
								if (data.stat_pos < 0){
									var text = 'Admin tidak dapat melakukan request untuk user posisi Resign';
									var type = 'error';
									new PNotify({
										title: 'Notifikasi',
										text: text,
										type: type,
										styling: 'bootstrap3'
									});
									var arr_ro = "new,tposname,sdate,edate".split(",");
									for(cid of arr_ro){
										$('#' + cid).attr('disabled', true);
									}
									$('#div_btn_<?php echo $modal_id;?> button').hide();
									
								}
							$('#<?php echo $modal_id;?>_form #btn_check').show();
							$('#<?php echo $modal_id;?>_form #btn_save').hide(); 
							$('[name="nama"]').text(data.name);
							$('[name="nama"]').val(data.name);
							$('[name="cposid"]').val(data.positionid);
							$('[name="cposname"]').text(data.nama);
							$('[name="cposname"]').val(data.nama);
							$('[name="old"]').val(data2.hp);
							$('[name="oldtext"]').html(data2.hp);
							$('[name="new"]').val(data2.hp);
							$('[id="showhp"]').show();
							$('#pos_def').css("display", "block");
							} else{
								alert('User not found');
								$('#nama,#loginid, #cposid, #cposname').val(null);
								$('#nama,#cposname').text("");
							}
					}
					});
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
	
	function <?php echo $modal_id;?>_submit(btype){
		$('#new,#tposname,#sdate,#edate,#loginid,#jam,#jam2').removeAttr('disabled');
		$('input[type=radio]').removeAttr('disabled', true);
		var fdata = {'url': 'wf/wfaction', 'modal_id' : "<?php echo $modal_id;?>", 'btype': btype };		
		var isValid = $("#<?php echo $modal_id;?>_form").valid();
		console.log(isValid);
		var cpos = $('#loginid').val();
			if (cpos.length < 1){
				//alert("please input loginid");
				$('#loginid').val('');
				return ;
			}
		/* if (isValid)
			action_submit(fdata); */
		if (isValid){
			if( $('#cposname').val() !== null &&  $('#cposname').val() !== '') {
			   //alert($('#cposname').val());
			   
			   /* new PNotify({
				  title: 'Notifikasi!',
				  text: 'Request telah di save. Silahkan cek draft untuk submit requestnya',
				  type: 'success',
				  styling: 'bootstrap3'
				}); */
				action_submit(fdata);
			}else{
				action_fail(fdata);
			}
			
		}
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
</style>
<div class="container">
  <!-- Modal -->
    
  <div class="modal fade"  id="<?php echo $modal_id;?>_content" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-body">
			 <div id="wrap">
		<form action="#"  id="<?php echo $modal_id;?>_form"  role="form">
		  
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Ubah No Handphone</p>
			<p class="judul" align= "center" style="margin-left:28%; width:70%;color: red;" id="lockinfo" ></p>
			<div id="alert">
				<div class="alert alert-danger" align="center">
					 Tidak dapat melakukan request. <br>
					 Request bisa dilakukan pukul (06.00 - 22.00 WIB).
				  </div>
			</div>
			<div id="isi">
			<div id="wfinfo" class="infohide"style="margin-right: 8%;margin-left: 9%">
				<label for="doneActor">Done</label> <ul id="doneActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
				<label for="currActor">Curr</label> <ul id="currActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
			</div>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row" style="width:90%;margin-left:6%;">				
					<label style="color: rgb(64, 92, 96);font-family: Big Caslon, Book Antiqua, Palatino Linotype, Georgia, serif;" >LoginID</label>
					<label  style="float: right;margin-right: 33px;color: rgb(64, 92, 96);font-family: Big Caslon, Book Antiqua, Palatino Linotype, Georgia, serif;" id="pos_def" >Posisi Definitif</label>
				<p id="l-login">
					  <input style ="width:20%;display: table; float:left;" name="loginid" id="loginid" type="text" class="form-control" onchange="query_id()">
					  <span class="input-group-btn" style="padding-right:23px; float:left">
						<button class="btn btn-success" style="box-shadow: unset;"  id="proses" type="button">
							<i class="fa fa-search"></i>
						</button>
					  </span>
					  <div class="errorTxt" id="loginid_validate"></div>
					<label name="nama" class="labelisi" id="nama" ></label>
					<input name="nama" id="nama" readonly type="hidden">
					<label for="nama"  class="labelisi" name="cposname" id="cposname" ></label>
					<input name="cposname" id="cposname" readonly type="hidden">
				</p>
				<p id="showhp">
				<label class="judul" style="float: left;width: 54%;">No Hp Lama</label>
				<label class="judul" style="width: 36%;">No Hp Baru</label> 
				<label  style="width: 30%;float: left;" id="oldtext" name="oldtext"></label> 
				<label style="padding-right: 10%;padding-left: 10%;float: left;color: black;" >=></label> 
				<input style="width:45%;"id="new" name="new" placeholder="-- No Handphone Baru --" class="autocomplete form-control" type="text" onclick="$(this).val(''); $('#tposid').val('');">
				<input id="old" name="old" placeholder="-- No Handphone Lama --" class="autocomplete form-control" type="hidden">
				<div class="errorTxt" id="new_validate" style="float: right;padding-right: 4%;padding-bottom: 5%;"></div>
				<ul style="font-size:12px;color: red;margin-left:-30px;">
					<label style="margin-left: -5px;margin-top: 10px;">Catatan : </label>
					<li>No HP harus terhubung dengan aplikasi Whatsapp</li>
				</ul>
				</p>


				
					<input name="tposid" id="tposid" readonly type="hidden">
					<input name="status" id="status" class="form-control" type="hidden" >
					<input name="id" id="id" class="form-control" type="hidden" >
					<input name="mode" id="mode" class="form-control" type="hidden" value="UH" >
					<input name="wfid" id="wfid" class="form-control" type="hidden" >	
					<input name="reqtype" id="reqtype" class="form-control" type="hidden" >						
					<input name="notes" id="notes" class="form-control" type="hidden" >					
				<p  class="signin button" id="div_btn_<?php echo $modal_id;?>" style="padding-top: 20px;" >
						<button style="margin-left: 85%;" type="button" id="btn_check" onclick="query_mobile()" class="btn btn-success">Check Data</button>
						<button style="margin-left: 85%;" type="button" id="btn_save" onclick="<?php echo $modal_id;?>_submit('save')" class="btn btn-primary">Save</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_submit" onclick="<?php echo $modal_id;?>_submit('submit')" class="btn btn-primary">Submit</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_cancel" onclick="<?php echo $modal_id;?>_submit('cancel')" class="btn btn-danger">Cancel</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_approve" onclick="<?php echo $modal_id;?>_submit('approve')" class="btn btn-primary">Approve</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_reject" onclick="<?php echo $modal_id;?>_submit('reject')" class="btn btn-danger">Reject</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_release" onclick="<?php echo $modal_id;?>_submit('release')" class="btn btn-default">Release</button>
				</p>
				</div>
			</div>							
		</form>
	</div>
        </div>
    </div>
  </div>

</div>