<script type="text/javascript">

	var def_secure_timeout=50;
	var timeout;
	var clean_timer;
	$(document).ready(function(){
		$( "#status, #sdiv, #myBar, #passDiv, #note" ).hide();
		//$('#passDiv').hide();
	$.validator.addMethod('regex', function(value, element, param) {
        return this.optional(element) ||
            value.match(typeof param == 'string' ? new RegExp(param) : param);
    },
    'Please enter a value in the correct format.');
		$(function() {
		 $("#form").validate({
                rules: {
                    npp: {
                        required: true,
                        minlength: 5,
						digits: true
                    },
					target: {
						required: true,
						minlength: 1
						//regex: /^[0-9]+$/
					},
					token: {
						required: true,
						minlength: 1
						//regex: /^[0-9]+$/
					},
                },
                messages: {
					npp: {
						required: "Please enter npp",
						minlength: "Your npp must be at least 5 number long"
					},
					target: {
						required: "Please enter target",
					},
					token: {
						required: "Please enter token",
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
		
		$(function() {
		$.validator.addMethod('regex', function(value, element, param) {
			return this.optional(element) ||
				value.match(typeof param == 'string' ? new RegExp(param) : param);
		},
		'Please enter a value in the correct format.');
		$("#form2").validate({
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
	
	function empty(){
		var $select=$("#status,#pass,#qrcode");		
		$select.empty();
		
	}
	
	function clean_sarea(){
		$('#pass').text('');
		//$('#qrcode').html('Demi keamanan password telah dihapus dari layar');
		$('#qrcode').html('Token yang anda input tidak sesuai');
	}
	
	function handle_showPassword(data){
			$('#pass').text(data['pass']);
			$('#qrcode').html('<img class="qrclass" src="data:image/png;base64,' + data['qrpass'] + '" />');
			  var elem = document.getElementById("myBar");   
			  var width = 100;
			  var id = setInterval(frame, 500);
			  function frame() {
				if (width <= 0) {
				  clearInterval(id);
				} else {
				  width--; 
				  elem.style.width = width + '%'; 
				}
			  }
			  $( "#myBar" ).show();
			if (def_secure_timeout > 0){
				timeout = def_secure_timeout;
				clean_timer = setTimeout(handleTimeout, 1000);
			}
	}
	
	function handle_setPassword(data){
			$("#tokenDiv").hide();
			$("#passDiv, #note").show();
	}
	
	function submitToken(ttype)
				{
			clearTimeout(clean_timer);
			clean_sarea();
			var url = "<?php echo site_url('guser/getpass')?>" ;
			//var url = "http://172.18.2.80:8082/cas/idm" ;
			var fdata = null;
			if (ttype == 'token' ){
			  fdata = {'reqtype': 'getPass', 'token' : $("#token").val(), 'target' : $("#target").val(), 'npp' : $("#npp").val()};
				var isValid = $("#form").valid();
			}else{ 
			//var h1 = hashForTransport($('#npp').val(), $('#passwd').val());
			  fdata = {'reqtype': 'setPass', 'token' : $("#token").val(), 'target' : $("#target").val(), 'npp' : $("#npp").val(), 'pass': $('#passwd').val()};
				var isValid = $("#form2").valid();
			}			
		console.log(isValid);
		
		if (isValid){
			$('#reqtype').val('tellinq'); 
			$.ajax({
				url : url,
				type: "POST",
				data: fdata,
				dataType: "JSON",
				crossDomain:true,
				success: function(data)
				{	
					//$("#frm_div").html('');
					
					
					//alert('testing');
					if (data['status'].startsWith('ok')){
						
						handle_showPassword(data);
					} else if (data['status'].startsWith('Pls-SetPassword')){
						handle_setPassword(data);
					} else if (data['status'].startsWith('set Password OK')){
							handle_showPassword(data);
							alert("Sandi telah dikonfirmasi");
							window.location.replace("<?php echo site_url('redirect')?>");		
					}else{
						//$('#status').text("  "+data['status']).attr("class", "fa fa-exclamation-circle ");
						$('#status').text(" Data tidak ditemukan ").attr("class", "fa fa-exclamation-circle ").css({"padding": "1%"});
						//$('#status2').text(data['status']);
						$('#status2').text(" Data tidak ditemukan ").attr("class", "fa fa-exclamation-circle ").css({"padding": "1%"});
						alert("Invalid Token")
					}
					$( "#status, #sdiv" ).show();
					$('#passwd').val("");
					$('#cpasswd').val("");
					
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error adding / update data');
					$('#btnSave').attr('disabled',false); 
				}
			});
			$( "#myBar" ).hide();
		}
	}
	
	function handleTimeout(){
			if (timeout-- > 0){
				$('#status').text("Password terhapus  dalam - " + timeout + ' - detik');
				clean_timer = setTimeout(handleTimeout, 1000);
			} else {
				clean_sarea();
			}
	}
	
</script>

<style>
#tb_action button { width: 100px }
.catlabel {width: 100px }
.qrclass {width: 150px;}
#myProgress {
  width: 100%;
  background-color: #ddd;
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
#myBar {
  width: 1%;
  height: 30px;
  background-color: #4CAF50;
}
#form label {
    /* Other styling.. */
    clear: both;
    float:left;
    margin-right:15px;
}
#form label.error {
    color: red;
	font-size: 11px;
	text-align: left;
	width: 500px;
	display: block;
}
#form2 label {
    /* Other styling.. */
    clear: both;
    float:left;
    margin-right:15px;
}
#form2 label.error {
    color: red;
	font-size: 11px;
	text-align: left;
	width: 500px;
	display: block;
}
#status {
  display: inline-block;
  border-radius: 4px;
  background-color: #FFB240;
  border: none;
  color: #FFFFFF;
  text-align: center;
  margin: 1%;
}

</style>

<div id="wrap">
	<div id ="tokenDiv" style="width: 50%; margin:0 auto; margin-bottom:10%;">
	<br><center><div id="pretext"></div></br>
	<div class="modal-container" id="status"></div></center>
		<form action="#" id="form">
			<p class="formHeader" style="font-size: 30px;">Verifikasi Token</p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row" style="width:90%;margin-left:6%;">
					<p class="row fl-controls-left">
							<label class="fl-label" for="username">Npp       </label>
							<input size="20" tabindex="1" name="npp" id="npp" placeholder="-- NPP --" 
							value="<?php echo $_SESSION['passRetMode']['npp']; ?>" class="form-control"  type="text" readonly disabled>
					</p>	
					<p class="row fl-controls-left">
						<label class="fl-label" for="username">Target      </label> 
						<input size="20" tabindex="1" name="target" id="target" placeholder="-- Target --" 
						value="<?php echo $_SESSION['passRetMode']['apps']; ?>" class="form-control"  type="text" readonly disabled>
					</p>
					<p class="row fl-controls-left">
						<input type="hidden" />
					</p>
					<p class="row fl-controls-left" id="mobileNumber_div">
							<label class="fl-label" for="username">Token       </label>
							<input name="token"  size="25"tabindex="1" 
							id="token" value="" placeholder="-- Token --" class="form-control" type="text" onblur="empty()" onclick="$(this).val('');">
					</p>								
					<p class="signin button" style="margin-left:3%; width: 100%;">
						<button type="button" id="btnTest" onclick="submitToken('token')" class="btn btn-primary">Submit</button>
					</p>
			</div>							
		</form>		
		<div class="modal-container" id="modal_l1"></div>
		<div class="modal-container" id="modal_l2"></div>
	</div>


	<div id ="passDiv" style="width: 50%; margin:0 auto; margin-top: 5%; margin-bottom:5%;">
	<br><div id="pretext2"></div></br>
		<form action="#" id="form2">
			<p class="formHeader" style="font-size: 30px;">Ubah Sandi</p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row" style="width:90%;margin-left:6%;">	
					<p class="row fl-controls-left">
						<label class="label-input">Password</label> 
						<input size="20" tabindex="1" name="passwd" id="passwd" placeholder="-- Sandi --" 
						 class="form-control" type="password" >
					</p>	
					<p class="row fl-controls-left">
						<label class="label-input">Konfirmasi Password</label> 
							<input size="20" tabindex="1"  name="cpasswd" id="cpasswd" placeholder="-- Konfirmasi Sandi --" 
							 class="form-control" type="password" >
					</p>															
					<p class="signin button" style="margin-left:3%; width: 100%;">
						<!--<button type="button" onclick="verification('token')" class="btn btn-primary">Submit</button>-->
						<button type="button" onclick="submitToken('pass')" class="btn btn-primary">Submit</button>
						<button type="button" id="btn_release" class="btn btn-danger">Cancel</button>
					</p>
			</div>							
		</form>
		
		<div class="modal-container" id="modal_l1"></div>
		<div class="modal-container" id="modal_l2"></div>
		<div class="modal-container" id="status2"></div>
	</div>
		<div id="note">
		<center><p style="margin-top: -3%;color:black;font-family:'FranchiseRegular';font-weight: normal;font-style: normal;">*Note:Gunakan sedikitnya 8 karakter terdiri dari Huruf besar, Huruf kecil, Angka dan Simbol</p></center>
	</div>
</div>