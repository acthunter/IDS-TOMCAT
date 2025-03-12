<html lang="en">
<head>
<meta charset="UTF-8">
<script type="text/javascript">

	var form_db = {};
	var form_db = {};
	var pname = {RP : "Review Position", CT: "Posisi Sementara ", CP: "Posisi Permanen", CU: "Ubah Unit", UA: "Tambah User" };
	var nextStage =""; //tambahan
	
	$(document).ready(function(){
		$('#passDiv,#note').hide();
		$('#success').hide();
		var url = "<?php echo site_url('enduser/xmain/valid_priv')?>" ;
			var $select=$('#target');
			$select.empty();
			
			$.ajax({
				url : url,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					
					$.each(data.opts, function (index, item) {
						$select.append(
							$('<option>', {
								value: item['target'] + ',' + item['delivery'],
								text: item['desc']
							}, '</option>'))
						  }
						 )
					$('[name="npp"]').val(data.npp);
					
					//dari idservicedemo1
					if (data.authorize != undefined){
						if (data.authorize){
							$("#mobileNumber_div").hide();
						}
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
			
			$(function() {
			 $('[id="form"]').validate({
					rules: {
						npp: {
							required: true,
							minlength: 5,
							digits: true
						},
						mobileNumber: {
							required: true,
							minlength: 1,
							digits: true
							//regex: /^[0-9]+$/
						},
					},
					messages: {
						npp: {
							required: "Please enter npp",
							minlength: "Your npp must be at least 5 number long"
						},
						mobileNumber: {
							required: "Please enter mobile number"
						},
					},
					highlight: function (element) {
						$(element).parent().addClass('error')
					},
					unhighlight: function (element) {
						$(element).parent().removeClass('error')
					},
					submitHandler: function(form) {
						//form.submit();
						console.log("about to submit");
					}
				});
		$(function() {
		$.validator.addMethod('regex', function(value, element, param) {
			return this.optional(element) ||
				value.match(typeof param == 'string' ? new RegExp(param) : param);
		},
		'Please enter a value in the correct format.');
		 $('[id="form2"]').validate({
                rules: {
					passwd: {
                        required: true,
                        minlength: 8,
						regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&.])[A-Za-z\d$@$!%*?&.]/
                    },
					cpasswd: {
						required: true,
                        minlength: 8,
						equalTo: "#passwd"
                    },
					cresponse: {
						required: true,
                        minlength: 4,
						digits: true
                    },
                },
                messages: {
					passwd: {
						required: "Please enter password",
						minlength: "Your password must be at least 8 number long",
						regex:"Password terdiri dari minimal 1 Huruf Besar, Huruf Kecil, angka dan Simbol"
					},
					cpasswd: {
						required: "Please enter confirm password",
						equalTo: "Password not match",
						minlength: "Your password must be at least 8 number long"
					},
					cresponse: {
						required: "Please enter valid token",
						minlength: "Your token must be at least 4 number long"
                    },
                },
				highlight: function (element) {
					$(element).parent().addClass('error')
				},
				unhighlight: function (element) {
					$(element).parent().removeClass('error')
				},
                submitHandler: function(form) {
                    //form.submit();
					console.log("about to submit");
                }
            });
		});
		});

		tab_myjob = $('#dt_myjob').DataTable({ 
						"processing": true, 
						"searching": false,
						"serverSide": true, 
						"order": [], 
						"aLengthMenu": [[ 10, 25, 50, -1], [ 10, 25, 50, "All"]],
						"iDisplayLength": 10,

						"ajax": {
							"url": "<?php echo site_url('myjob')?>",
							"type": "POST"
						},
						"columns" : [
						{"data":"id",
						 width: "20px"},
						{"data":"stage",
						  visible: false,
						  width: "50px"},
						{"data":"mode"},

						{"data":"cdate"},
						{"data":"name"},
						{"data":"stage"},
						{"data":"currScore",
						visible: false,
						  width: "50px"}
						],
						"columnDefs": [
						{  
							"targets": [ -1 ],
							"orderable": false, 
						},
						{  
							"targets": [ 2 ],
							"render": function(data,type, row){
								var step = (row['stage']=='1') ? 'Init' : 'Approve'; 
								return step + ' - ' + pname[data];
							}, 
						},
						{  
							"targets": [ 4 ],
							"render": function(data,type, row){
								var step = (row['name']); 
								return step + '  (' + row['initiator'] +')';
							}, 
						},
						{  
							"targets": [ 5 ],
							"render": function(data,type, row){
								if (row['stage']=='1')
								var step = 'Request masuk ke draft';
								if (row['stage']=='2')
								var step = 'Request menunggu persetujuan'; 
								if (row['stage']=='3')
								var step = 'Request telah di setujui'; 
								return step;
							}, 
						},
						],
		});
		
		$('#dt_myjob').on('click', 'tr:not(:first)', function () {
				//job_click('#modal1', '#modal_xadm', tab_myjob.row($(this).index()).data());
				var rdata = tab_myjob.row($(this).index()).data();
				var ftype = rdata['ftype'];
				var fparam = {'id' : rdata['id'], "mode" : rdata['mode'],
					'url':'jobbyid', 'reqtype' : 'read'};
				loadForm('modal_l1', fparam, true);
		});		
		
	});
	
	function update_detail_modal(modal_id, fdata){
		 var h_modal_content_id = modal_id + "_trigger";
		 var fn = window[h_modal_content_id];
		 fn(fdata);
	};
	
	function show_toast(isSuccess, msg){
		if (isSuccess){
			$("#flash-msg").addClass("alert-success");
		} else {
			$("#flash-msg").addClass("alert-warning");
		}
		$("#ifa_txt").html(msg);
		
		$("#flash-msg").fadeIn(500);
		$("#flash-msg").delay(3000).fadeOut("slow")
	}
	
	function bc_submit(stype){
			var fdata = {"reqtype" : stype};
			//show_toast(false, stype);
			var sdate = new Date();
			//show_toast(true, sdate.toLocaleTimeString() + " " + stype);
			$.ajax({
				url : "<?php echo site_url('')?>sysrequest",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function(data)
				{
					var edate = new Date();
					var ddate = edate - sdate;
					show_toast(true, edate.toLocaleTimeString() + " " + stype + " " + data);
					//update_view(data);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Submit Fail');
				}
			});
		};
		
	function verification(ttype){

			var isValid = $("#form2").valid();
			var tdel = $('#target').val().split(",");
			if (ttype == 'token' ){
				var isValid = $('[id="form"]').valid();
				
				//var fdata = {'reqtype': 'setTarget', 'npp' : $("#npp").val(), 'target' : tdel[0] , 'mobileNumber' : $("#mobileNumber").val(),'delivery': tdel[1], 'userclass': 'casuser'};
				//dari idservicedemo1
				var fdata = {'reqtype': 'verifyForPassword', 'npp' : $("#npp").val(), 'target' : tdel[0] , 'mobileNumber' : $("#mobileNumber").val(),'delivery': tdel[1], 'userclass': 'casuser'};
			} else { 
				
				//var fdata = {'reqtype': 'setPass',   'pass': $("#passwd").val()};
				
				//dari idservicedemo1
				var fdata = {'reqtype': 'setPass',   'cresponse': $("#cresponse").val(), 'pass': $("#passwd").val()};
				if (nextStage == "getQrSeed") //tambahan
					fdata['reqtype'] = "getQrSeed"; //tambahan
			}
			var url = "<?php echo site_url('enduser/Xmain/handle')?>" ;
			if (isValid){
			$('#pretext').text("Pls Wait .....");
			$('#reqtype').val('tellinq'); 
			$.ajax({
				url : url,
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function(data)
				{
					
					$('#status').text(data['status']);
					nextStage = ""; //tambahan
					if (data.resp == "ok-next-setpassword"){
						//('#mobileNumber').val(null);
						
						alert("Permintaan yang anda lakukan berhasil");
						$("#tokenDiv").hide();
						$("#passDiv,#note").show();
						
						//dari idservicedemo1
						$("#cresponse_div").hide();
						$("#cresponse").text('');
						
						//yang beda
						if (data.form != undefined && data.form == "getQrOTP"){
							$("#div_pass_new").hide();
							nextStage = "getQrSeed";
						} 
						//yang beda
						
						if (data.msg != undefined){
							if (data.msg == "pls-input-challenge"){
								$("#cresponse_div").show();
							}
						}
						
					} else if (data.resp.startsWith("scanQrSeed")){
						$("#passDiv, #tokenDiv,#note").hide();
						$("#success").show();
						
					} else if (data.resp.startsWith("ok-set-target-ldapAccount_oid-ok") || data.resp.startsWith("ok-set-target-banc-ok")){
						//('#mobileNumber').val(null);
						//alert("Permintaan yang anda lakukan berhasil");
						
						$('#pretext2').text(" setTarget-ok ").attr("class", "fa fa-exclamation-circle ").css({"padding": "1%"});
						//alert(data.resp);
						$("#passDiv, #tokenDiv,#note").hide();
						$("#success").show();
						//location.reload();
						//dari idservicedemo1
						
					} else if (data.resp.startsWith("invalid auth")){
						$('#pretext2').text(" invalid auth ").attr("class", "fa fa-exclamation-circle ").css({"padding": "1%"});
						//alert("Invalid Auth");
						$("#cresponse, #passwd, #cpasswd").val(null);						
					}else {
						//alert(data.resp);
						$('#pretext').text(" Data tidak ditemukan").attr("class", "fa fa-exclamation-circle ").css({"padding": "1%"});
						if (data['reqtype'] == 'setTarget'){
							//alert(data.resp);
							$('#mobileNumber').val(null);
						} else {
							$('#mobileNumber').val(null);
						}
					} 
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					//alert('Error adding / update data');
					$('#btnSave').attr('disabled',false); 
					//dari idservicedemo1
					$('#pretext').text("Error: .." + textStatus);
				}
			});
	}}
		
		function clearform_db(){
		form_db = {};
		}
		
		function createnew(mode){
		var fparam = {'id' : null, "mode" : mode,
					'url':'wf/new/' + mode, 'reqtype' : 'new'};
		loadForm('modal_l1', fparam, true);
		}
		
		function showModal(modal_id, fdata, content, isfirstload){
			var h_modal_id = "#" + modal_id;
			$(h_modal_id).html(content);
			$(h_modal_id + "_content").modal({show:true});
			
			$(h_modal_id + "_content").on("hide.bs.modal", function(event){
					 console.log(event);
					 //$(h_modal_id + "_content").empty();
					 if (event.currentTarget.id == "modal_l1_content"){
						 //window['modal_l1_reload']();
						  tab_myjob.ajax.reload();
					 }
				 });
			
			$(h_modal_id + "_content").modal({show:true});
			 
			update_detail_modal(modal_id, fdata);
		}
		
		function loadForm(modal_id, fdata, isupdate){
		 console.log(fdata);
		  var url = "<?php echo site_url('form')?>";
		  var h_modal_id = "#" + modal_id;
			// jQuery('#modellink').click(function(e) {
				 $(h_modal_id).empty();
				 var form_id = modal_id + "." + fdata['mode'];
				 var cform = form_db[form_id];
				 fdata['modal_id'] = modal_id;
				 if (cform == null){
					 $(h_modal_id).load(url, fdata, function(result){
						 //adjust table
						 form_db[form_id] = result;
						 cform = form_db[form_id];
						 showModal(modal_id, fdata, cform, true);
					});
				 } else {
					 showModal(modal_id, fdata, cform, false);
				 } 
				  
				
			// });
		}
		
		function action_submit(fdata){
		
			var reason = "";
			var isMandatory = ("reject,cancel".indexOf(fdata['btype']) != -1);
			var hmodal_id = '#' + fdata['modal_id'];
			
			console.log(fdata);
			console.log(fdata['btype']);
			if (isMandatory){
				reason = prompt("Alasan", "");
				if (reason == null || reason.length < 2){
					return;
				}
			}
			
			$('#notes').val(reason);
			$(hmodal_id + ' #reqtype').val(fdata['btype']);
			
			var fxdata = $(hmodal_id + '_form').serialize();
			console.log(fdata);
			
			var url = "<?php echo site_url('')?>" + fdata['url'] ;
			$.ajax({
				url : url,
				type: "POST",
				data: fxdata,
				dataType: "JSON",
				success: function(data)
				{
					$('[name="nama"]').val(data.name);
					$('[name="cposname"]').val(data.nama);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Submit Fail');
					$('#btnSave').attr('disabled',false); 
				}
			});
			$('#' + fdata['modal_id'] + '_content').modal('hide');
		}
		
		function arrFlat(arr){
			var ret = "";
			for (var key of arr) {
				ret += "<li class='auth'>" + key + "</li>";
			}
			return ret ;
		}
	
		function jsonFlat(jstr){
			var obj = jstr;
			var ret = "";
			for (var key in obj) {
				ret += "<li class='auth auth_" + obj[key] + "'>" + key + "</li>";
			}
			return ret ;
		}
		
		function arrFlatStr(astr){
			if (astr == null)
				return "";
			var obj = astr.split(",");
			return arrFlat(obj);
		} 	

</script>

<style>
#tb_action button { width: 100px }
.catlabel {width: 100px }

#form label {
    /* Other styling.. */
    text-align: left;
    clear: both;
    margin-right:15px;
}
#form label.error {
    color: red;
	font-size: 11px;
	text-align: left;
	width: 500px;
	margin-left: 28%;
	display: block;
}
#form2 label.error {
    color: red;
	font-size: 11px;
	text-align: left;
	width: 72%;
	margin-left: 28%;
	display: block;
}

#pretext {
  display: inline-block;
  border-radius: 4px;
  background-color: #FFB240;
  border: none;
  color: #FFFFFF;
  text-align: center;
  margin: 5%;
}
#pretext2 {
    /* Other styling.. */
  display: inline-block;
  border-radius: 4px;
  background-color: #f4511e;
  border: none;
  color: #FFFFFF;
  text-align: center;
  margin:5%;
}


</style>
<div id="wrap">
	<div id ="tokenDiv" style="width: 50%;margin:0 auto; margin-top: 5%; ">
		<form action="#" id="form" style="width: 500px; margin: auto;">
			<p class="formHeader" style="font-size: 30px;">Ubah Password</p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row" style="width:90%;margin-left:6%;">
					<p class="row fl-controls-left">
						<label class="label-input" >NPP</label> 
						<input name="npp" id="npp" class="input-right form-control"  placeholder="-- NPP --"  type="text"  readonly disabled >
					</p>	
					<p class="row fl-controls-left">
						<label class="label-input" >Target</label> 
						<select name="target" id="target" class="input-right form-control"  placeholder="-- Target --" type="text"/>
						<option value=""disabled selected>-- select --</option>
					</p>
					<p class="row fl-controls-left">
						<input type="hidden" />
					</p>
					<p class="row fl-controls-left" id="mobileNumber_div">
						<label class="label-input">No HP</label> 
						<input   name="mobileNumber" id="mobileNumber" class="input-right form-control"  placeholder="-- No HP --"  type="text" />
					</p>								
					<p class="signin button" style="margin-left:3%; width: 100%;">
						<button type="button" onclick="verification('token')" class="btn btn-primary">Submit</button>
						<button type="button" id="btn_release" class="btn btn-danger">Cancel</button>
					</p>
			</div>							
		</form>
		
		<div class="modal-container" id="modal_l1"></div>


		<div class="modal-container" id="modal_l2"></div>
	</div>
	
	
	<div id ="passDiv" style="width: 50%;margin:0 auto; margin-top: 5%; ">
	<br><center><div id="pretext2"></div></center></br>
		<form action="#" id="form2">
			<p class="formHeader" style="font-size: 30px;">Ubah Password</p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row" style="width:90%;margin-left:6%;">
					<p class="row fl-controls-left" id="cresponse_div">
						<label class="label-input">OTP</label> 
						<input name="cresponse" id="cresponse" placeholder="-- OTP --" class="input-right form-control" type="text" >		
					</p>	
					
					<div id="div_pass_new">
					<p class="row fl-controls-left">
						<label class="label-input">Password</label> 
						<input name="passwd" id="passwd" placeholder="-- Password --" class="input-right form-control" type="password" >		
					</p>	
					<p class="row fl-controls-left">
						<label class="label-input">Konfirmasi Password</label> 
						<input name="cpasswd" id="cpasswd" placeholder="-- Konfirmasi Password --" class="input-right form-control" type="password" >
					</p>															
					<p class="signin button" style="margin-left:3%; width: 100%;">
						<!--<button type="button" onclick="verification('token')" class="btn btn-primary">Submit</button>-->
						<button type="button" onclick="verification('pass')" class="btn btn-primary">Submit</button>
						<button type="button" id="btn_release" class="btn btn-danger">Cancel</button>
					</p>
					</div >
			</div>							
		</form>
		
		<div class="modal-container" id="modal_l1"></div>


		<div class="modal-container" id="modal_l2"></div>
	</div>
	
	<div id ="success" style="width: 50%; margin:25%; margin-top: 15%;">
		<form action="#">
			<p class="formHeader" style="font-size: 30px;">Ubah Password</p>
			<div class="form-group row" style="width:90%;margin-left:6%;">
					<p class="row fl-controls-left" id="cresponse_div" style="color:black; text-align:center;">
						Ubah Password Berhasil 
					</p>	
			</div>							
		</form>
		<br><div id="pretext2"></div></br>
		<div class="modal-container" id="modal_l1"></div>
		<div class="modal-container" id="modal_l2"></div>
	</div>
	
</div>	
<br>
<br>
	<div id="note">
		<center><p style="color:black;font-family:'FranchiseRegular';font-weight: normal;font-style: normal;">*Note:Gunakan sedikitnya 8 karakter terdiri dari Huruf besar, Huruf kecil, Angka dan Simbol</p></center>
	</div>
</div>	