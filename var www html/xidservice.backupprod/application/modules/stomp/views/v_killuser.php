<script type="text/javascript">

	
	$(document).ready(function(){
		
		$( "#npp" ).click(function() {
		  $('#pretext').text("");
		   $("select[name=target]").val("");
		});
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
                    }
                },
                messages: {
					npp: {
						required: "Please enter npp",
						minlength: "Your npp must be at least 5 number long"
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
			function query_id()
		{		
			var url = "<?php echo site_url('endsession/xmain/valid_priv')?>" ;
			var $select=$('#target');
			$select.empty();
			
			$.ajax({
				url : url,
				type: "POST",
				data: {"npp": $('#npp').val()},
				dataType: "JSON",
				success: function(data)
				{
					if (data.opts != '') {
					$("select[name=target]").prepend("<option disabled='disabled' value='Hello Me'>-- select --</option>");
					$.each(data.opts, function (index, item) {
						$select.append(
							$('<option>', {
								value: item['target'] + ',' + item['delivery'],
								text: item['desc']
							}, '</option>'))
						  }
						 )
					}else{
						new PNotify({
							title: 'Notifikasi',
							text: 'User Not Found',
							type: 'error',
							styling: 'bootstrap3'
						});
						$('#npp').val(""); 
						
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
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
	
		function verification(){
			
			//var tdel = $('#target').val().split(",");
			
			var url = "<?php echo site_url('endsession/Xmain/handle')?>" ;
			var fdata = {'reqtype': 'resetPass', 'npp' : "<?php echo $this->session->userdata('pengguna')->loginid ?>", 'terminal' : $("#terminal").val(), 'password': 'endsession','target' : 'banc' , 'delivery': 'online'};
			$('#reqtype').val('tellinq'); 
			$.ajax({
				url : url,
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function(data)
				{

					//$('#pretext').text(data['resp']);
					//alert('testing');
					if (data.resp.startsWith('ok')){
						new PNotify({
							title: 'Notifikasi',
							text: 'kill user icons berhasil',
							type: 'success',
							styling: 'bootstrap3'
						});
					} else{
						new PNotify({
							title: 'Notifikasi',
							text: 'User Sedang tidak login icons',
							type: 'error',
							styling: 'bootstrap3'
						});
						
					}	
								
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error adding / update data');
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
</script>

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
		<form action="#" style="width: 500px; margin: auto;">
			<p class="formHeader">Kill User</p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<div class="form-group row">
				<p>
					<label>NPP</label> 	
					<input name="npp" id="npp" placeholder="-- NPP --" type="text" onclick="$(this).val('');" value="<?php echo $this->session->userdata('pengguna')->loginid ?>" disabled>
				</p>
				<p>
					<label>Terminal</label> 	
					<input name="terminal" id="terminal" placeholder="-- Terminal --" type="text" onclick="$(this).val('');">
				</p>				
				<p>		
					<label>Target</label> 
					<input name="target" id="target" value="ICONS" type="text" style="height: 30px;" disabled></input>
				</p>			
						
				<p class="submit button">						
					<button type="button" onclick="verification()" class="btn btn-primary">Submit</button>
					<!--<button type="button" id="btnTest" onclick="verification()" class="btn btn-primary">verifikasi</button>-->
					<button type="button" id="btn_release" class="btn btn-danger">Cancel</button>
				</p>		
			</div>							
		</form>
	</div>
</div>
