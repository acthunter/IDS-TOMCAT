<html>
<head>
</head>
<script type="text/javascript">
/* alert("OK111"); */
			$.urlParam = function(name){
				var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
				if (results==null){
				   return null;
				}
				else{
				   return decodeURI(results[1]) || 0;
				}
			}
			var fingerprint = new Fingerprint().get();
			var fdata = { 'loginid' : $.urlParam('loginid'), 'reqid' : $.urlParam('reqid'), 'otp' : $('[name="otp_pass"]').val(), 'fp' : fingerprint, 'type' : 'submitToken' };
			var url = "<?php echo site_url('pass/xgpass/getpass')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: fdata,
				dataType: "JSON",
				beforeSend: function(){
					$('#wait').show();
				},
				success: function(data)
				{								
					var wdata = data['rmap'];
					
					//if (data['status'] == 'ok'){
					if (data.hasOwnProperty('rmap')){
						
						var xdata = wdata['vlist'];
						console.log(wdata['vlist']);
						$.each(xdata, function (index, item) {
							$.each(item, function (idx, elm) {
								if (elm['target'] == 'ibank_trx'){
									elm['sloginid'] = '-';
								}else if (elm['target'] == 'bancss'){
									elm['target'] = 'bancs';
								}
								$("#list_apps").append("<tr class='checklist'><td>"+ elm['target'] +"</td><td>"+ elm['sloginid'] +"</td><td style='letter-spacing: 4px; font-family: verdana;'>"+ index +"</td></tr>");
							});
						});
						$("#ok_tabel2").show();
						$("#ok").show();
						//$("#myModal").modal('show');
						$("#wrap2").hide();
						$("#wrap").show();
						$("mToken").hide();
						//form.remove();
						$("#dialog-input").val("");
					} else {
						alert("Token Tidak Sesuai");
						$("#wait").hide();
						$(".ui-dialog-content").dialog("close");
						form.remove();
						$("#dialog-input").val("");
						
					}
				},
				complete: function(){
					 $("#wait").hide();
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
</script>

<body>
	<!--<div style="margin:0 auto; margin-top: 15%; margin-bottom: 10%;">-->
	<div id="dialog">
        <!--<form  id="form" style="width: 500px; margin: auto;">-->
		<form  id="form" style="width: 500px; margin: auto;-webkit-box-shadow:none;border:none;background:none;box-shadow:none;">
			<!--<p class="formHeader" style="font-size: 30px;">Password</p>-->
			<div class="form-group row" style="width:90%;margin-left:6%;">				
				<p id="ok" hidden >
					<table id="ok_tabel2" class="table table-bordered" hidden>
						<thead>
							<tr style="background: #F6F6F6;">
								<th>Aplikasi</th>
								<th>User1</th>
								<th>Password</th>
							</tr>
						<div id="wait" style="display:none;width:20px;height:20px;position:relative;top:50%;left:50%;padding:2px;"><img  src="/idservice/assets/images/loader.gif" width="64" height="64" /></div>
						</thead>
						<tbody id="list_apps">
						</tbody>
					</table>
				</p>					
			</div>							
		</form>
	</div>
</body>
</html>