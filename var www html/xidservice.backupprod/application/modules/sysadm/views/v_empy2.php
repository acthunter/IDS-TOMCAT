<style>
#tb_action button { width: 100px }
.catlabel {width: 100px }

#wrapper input:not([type="checkbox"]), select {
					width: 83%;
					margin-left: 4%;
					padding: 5px 5px 2px 32px;
					border: 1px solid rgb(178, 178, 178);
					-webkit-appearance: textfield;
					-webkit-box-sizing: content-box;
					-moz-box-sizing: content-box;
					box-sizing: content-box;
					-webkit-border-radius: 3px;
					-moz-border-radius: 3px;
					border-radius: 3px;
					-webkit-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
					-moz-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
					box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
					-webkit-transition: all 0.2s linear;
					-moz-transition: all 0.2s linear;
					-o-transition: all 0.2s linear;
					transition: all 0.2s linear;
				}


				.formHeader {
					font-size: 39px;
					color: rgb(6, 106, 117);
					padding: 20px 0 10px 0;
					font-family: 'BebasNeueRegular','Arial Narrow',Arial,sans-serif;
					text-align: center;
					 text-transform: uppercase;
				}

				form {
					width: 50%;
					padding: 18px 6% 25px 6%;
					background: rgb(247, 247, 247);
					border: 1px solid rgba(147, 184, 189,0.8);
					-webkit-box-shadow: 0pt 2px 5px rgba(105, 108, 109, 0.7), 0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
					-moz-box-shadow: 0pt 2px 5px rgba(105, 108, 109, 0.7), 0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
					box-shadow: 0pt 2px 5px rgba(105, 108, 109, 0.7), 0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
					-webkit-box-shadow: 5px;
					-moz-border-radius: 5px;
					border-radius: 5px;
					margin: 10%;
					left: 15%;
				}

				#wrapper {
					right: 0px;
					min-height: 560px;
					margin: 0px auto;
					position: relative;
				}

				.formHeader::after {
					content: ' ';
					display: block;
					width: 100%;
					height: 2px;
					margin-top: 10px;
					background: -moz-linear-gradient(left, rgba(147,184,189,0) 0%, rgba(147,184,189,0.8) 20%, rgba(147,184,189,1) 53%, rgba(147,184,189,0.8) 79%, rgba(147,184,189,0) 100%);
					background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(147,184,189,0)), color-stop(20%,rgba(147,184,189,0.8)), color-stop(53%,rgba(147,184,189,1)), color-stop(79%,rgba(147,184,189,0.8)), color-stop(100%,rgba(147,184,189,0)));
				}

				#wrapper p.button input, button {
					width: 30%;
					cursor: pointer;
					background: rgb(61, 157, 179);
					padding: 4px 2px;
					font-family: 'BebasNeueRegular','Arial Narrow',Arial,sans-serif;
					color: #fff;
					font-size: 20px;
					border: 1px solid rgb(28, 108, 122);
					margin-bottom: 10px;
					text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);
					-webkit-border-radius: 3px;
					-moz-border-radius: 3px;
					border-radius: 3px;
					-webkit-box-shadow: 0px 1px 6px 4px rgba(0, 0, 0, 0.07) inset, 0px 0px 0px 3px rgb(254, 254, 254), 0px 5px 3px 3px rgb(210, 210, 210);
					-moz-box-shadow: 0px 1px 6px 4px rgba(0, 0, 0, 0.07) inset, 0px 0px 0px 3px rgb(254, 254, 254), 0px 5px 3px 3px rgb(210, 210, 210);
					box-shadow: 0px 1px 6px 4px rgba(0, 0, 0, 0.07) inset, 0px 0px 0px 3px rgb(254, 254, 254), 0px 5px 3px 3px rgb(210, 210, 210);
					-webkit-transition: all 0.2s linear;
					-moz-transition: all 0.2s linear;
					-o-transition: all 0.2s linear;
					transition: all 0.2s linear;
				}

				#wrapper label {
					float: left;
					clear: left;
					margin-left: 5%; 
					color: rgb(64, 92, 96);z
				}
				#wrapper select{
					padding: 5px 5px 2px 32px;
				}
				p.submit.button{
					text-align: right;
					margin: 5px 0;
					top: 10px;
				}
</style>

<div id="wrapper">
		<div style="width: 50%;margin:0 auto; margin-top: 5%; ">
		<form action="#"  id="modal_form" style="width: 500px; margin: auto;">
			<p class="formHeader">Edit Employee</p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<div class="form-group row">
				<p>
					<label>Login ID syariah</label> 	
					<input name="loginid" id="loginid" placeholder="LoginID" class="form-control" onchange="query_npp()" >
				<!--<span id="btn_save" onclick="query_npp()" class="input-group-addon">
					<a href="#"><i class="fa fa-search"></i></a>
				</span>-->
				</p>
				<p>
					<label>Name</label> 	
					<input name="Name" id="Name" placeholder="Name" disabled>
				</p>	
				<p>
					<label>Email</label> 	
					<input name="email" id="email" placeholder="Email"  onclick="$(this).val('');">
				</p>			
				<div class="modal-footer" id="div_btn_modal" style="padding-bottom: 0px;padding-top: 12px;border-bottom-width: 0px;margin-bottom: -11px;">
					<div class="col-xs-12" style="text-align: right;">
						<button type="button" id="btn_save" onclick="modal_submit()" class="btn btn-warning">Update</button>
						<button type="reset" class="btn btn-primary">Reset</button><br><br>
					</div>
				</div>		
			</div>							
		</form>
	</div>
</div>
<script type="text/javascript">
var nextallatt;
	$(document).ready(function(){
		$("#loginid").click(function(){
			$("input").val("");
			//$("input[type=select]").val("null");
			$(" select").val("null");
		});
		$('#null').click(function() {
						if(document.getElementById('null').checked) {
							$('#naa').val('');
						} else {
							$('#naa').val(nextallatt);
						}
					});
		$.validator.addMethod('regex', function(value, element, param) {
        return this.optional(element) ||
            value.match(typeof param == 'string' ? new RegExp(param) : param);
    },
    'Please enter a value in the correct format.');
		$(function() {
			var validate = $("#modal_form").validate({
                rules: {
					email: {
                        required: true,
                        minlength: 1,
						regex: /([a-zA-Z0-9]+)([\.{1}])?([a-zA-Z0-9]+)\@(bni|bnisyariah|BNI)([\.])(co|CO)([\.])(id|ID)/g
                    },
                },
				
                messages: {
					email: {
						required: "Please enter email",
						regex: 'Jika tidak memiliki email bni, silahkan mencreate email bni terlebih dahulu'
					}
                },
            });
		});
		
	});
	function query_npp()
		{		
		//alert($('[name="loginid"]').val());
			var url = "<?php echo site_url('query_em2')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: { loginid: $('[name="loginid"]').val() },
				dataType: "JSON",
				success: function(data)
				{
					if (data != null){
					//$('[name="loginid"]').val(data.sloginid);
					$('[name="email"]').val(data.email);
					$('[name="Name"]').val(data.Name);
					$('[name="locked"]').val(data.locked);
					$('[name="mn"]').val(data.mobileNumber);
					//USER EXPIRED
					$('[name="nl"]').val(data.NPPxl);
					nextallatt = data.nextAllowedAttempt;
					}else{
						alert("Data tidak ditemukan");
						$("input").val("");
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		};
		$(function () {
				$('#DOB').datetimepicker({
                    format: 'YYYY-MM-DD'
                });
                $('#passwordExpired, #expired, #naa, #expxl, #lexp').datetimepicker();
    });
	function modal_submit(){
		var isValid = $("#modal_form").valid();
		var url = "<?php echo site_url('update_employeesya')?>" ;
		if (isValid){
			$.ajax({
				url : url,
				type: "POST",
				data: $('#modal_form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					alert('Data berhasil di update');
					$("#modal_form")[0].reset()
				}
			});
		}
	};
</script>