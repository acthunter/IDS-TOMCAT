<script type="text/javascript">

	//var filterApps = "banc,b24,periskop";
	var filterApps = "<?php echo $appfilter; ?>";
	var def_secure_timeout=50;
	var timeout;
	var clean_timer;
	$(document).ready(function(){
		idaction('next', '0');
		$( "#status, #sdiv, #myBar" ).hide();
		var split = filterApps.split(',');
		var result = split.join(' | ');
		$('#text-header').text(result);
		//alert(result);
		//alert(filterApps);
	});
	
	function show_toast(isSuccess, msg){
		if (isSuccess){
			$("#flash-msg").addClass("alert-success");
		} else {
			$("#flash-msg").addClass("alert-warning");
		}
		$("#ifa_txt").html(msg);
		
		$("#flash-msg").fadeIn(500);
		$("#flash-msg").delay(3000).fadeOut("slow");
	}
	
	
	function clean_sarea(){
		$('#pass').text('');
		$('#qrcode').html('Demi keamanan password telah dihapus dari layar');
	}
	
	function idaction (nextStep, status){
		var fdata = null;
		 if ($("#token_id").val() == ''){
			 fdata = {'reqtype': 'update', 'next': nextStep, 'filter':filterApps };
			 __action(fdata);
		} else {
			var fdata2 = {'id' : $("#token_id").val()};
			console
			if ($("#target").val().indexOf('ibank') != -1 && nextStep == 'next' && $("#waktu").val() == '' && status == '1'){
			$.ajax({
				url: "<?php echo site_url('idadmin/xmain/nextpass')?>",
				type: "POST",
				data: fdata2,
				dataType: "JSON",
				success: function(data2){
					if (data2['status'] == 'success'){
							var text = 'Ibank sedang diproses !';
							var type = 'success';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
							nextStep = 'next';
							status = '1';
						
						}else{
							var text = 'Reset Ibank tidak dapat diproses !';
							var type = 'error';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
							nextStep = 'skip';
							status = '1';
						}
						fdata = {'reqtype': 'updatepass', 'repoid' : $("#token_id").val(), 
						 'next': nextStep, 'status': status, 'notes' : $("#notes").val(), 
						 'filter':filterApps, 'given_login' : $("#given_login").val(),
						 'given_trx' : $("#given_trx").val(), 'waktu' : $("#waktu").val()};
						__action(fdata);
				}   
			});
			}else{
			 fdata = {'reqtype': 'updatepass', 'repoid' : $("#token_id").val(), 
			 'next': nextStep, 'status': status, 'notes' : $("#notes").val(), 
			 'filter':filterApps, 'given_login' : $("#given_login").val(),
			 'given_trx' : $("#given_trx").val(), 'waktu' : $("#waktu").val()};
			__action(fdata);
			}
		}
	}
	
	function cleanForm(){
		$('#token_id').val('');
		$('#no_surat').val('');
		$('#target').val('');
		$('#npp').val('');
		$('#token').val('');
		$('#given_login').val('');
		$('#given_trx').val('');
		$('#notes').val('');
		$('#waktu').val('');
	}
	
	function __action(fdata){
			cleanForm();
			var url = "<?php echo site_url('idadmin/xmain')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: fdata,
				dataType: "JSON",
				crossDomain:false,
				success: function(data)
				{	
					if (typeof data.rmap['id'] != 'undefined'){
						$('#token_id').val(data.rmap['id']);
						$('#target').val(data.rmap['target']);
						$('#npp').val(data.rmap['loginid']);
						$('#no_surat').val(data.rmap['key1']);
						
						if(data.rmap['token'] != ""){
							$('#given_login').attr('readonly', true);
							$('#given_trx').attr('readonly', true);
							$('#token').val(data.rmap['token']);
							//$('#given').val(data.rmap['token']);
						} else {
							//$('#token').val(data.rmap['token']);
							$('#given_login').attr('readonly', false);
							$('#given_trx').attr('readonly', false);
							$('#waktu').attr('readonly', false);
						}						
					} else {
						$('#notes').val(data.rmap['status']);
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					//alert('Error adding / update data');
					$('#btnSave').attr('disabled',false); 
				}
			});
			$( "#myBar" ).hide();
	}
	
	function handleTimeout(){
			if (timeout-- > 0){
				$( "#status" ).show();
				$('#status').text("Password terhapus  dalam - " + timeout + ' - detik');
				clean_timer = setTimeout(handleTimeout, 1000);
			} else {
				clean_sarea();
			}
	}
</script>

<style>

</style>

<div id="wrap">
	<div id ="tokenDiv" style="width: 50%; margin:0 auto;">
		<form action="#" id="form1" style="width: 500px; margin: auto;">
			<p class="formHeader" style="font-size: 30px;">Get Password</p>
			<!--<p style="font-size: 20px;"><?php echo $appfilter; ?></p>-->
			 <div class="alert alert-info" style="word-wrap:break-word">
				<strong>Info Application!</strong><br> <a id="text-header"></a> 
			  </div>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row" style="width:90%;margin-left:6%;">
					<p class="row fl-controls-left">
						<label class="judul">No SURAT</label> 
						<input name="no_surat" id="no_surat" value="" class="form-control"  type="text" readonly="true"/>
					</p>
					<p class="row fl-controls-left">
						<label class="judul">Id</label> 
						<input name="token_id" id="token_id" value="" class="form-control"  type="text" readonly="true"/>
					</p>	
					<p class="row fl-controls-left">
						<label class="judul">Npp</label> 
						<input name="npp" id="npp" value="" class="form-control"  type="text" readonly="true"/>
					</p>
					<p class="row fl-controls-left">
						<label class="judul">Target</label> 
						<input name="target" id="target" value="" class="form-control"  type="text" readonly="true"/>
					</p>		
					<p class="row fl-controls-left">
						<label class="judul">Password Master</label> 
						<input name="token" id="token" value="" class="form-control"  type="text" readonly="true"/>
					</p>
					<p class="row fl-controls-left">
						<label class="judul">Given(ibank login)</label> 
						<input name="given_login" id="given_login" value="" class="form-control"  type="text" readonly"/>
					</p>
					<p class="row fl-controls-left">
						<label class="judul">Given(ibank TRX)</label> 
						<input name="given_trx" id="given_trx" value="" class="form-control"  type="text" readonly"/>
					</p>
					<p class="row fl-controls-left">
						<label class="judul">Waktu Ambil</label> 
						<select name="waktu" id="waktu" value="" class="form-control"  type="text">
							<option value="8">Pukul 08:00</option>
							<option value="12">Pukul 12:00</option>
							<option value="16">Pukul 16:00</option>
							<option value="besok">Besok Pagi 08:00</option>
						</select>
					</p>	
					<p class="row fl-controls-left">
						<label class="judul">Notes</label> 
						<input name="notes" id="notes" value="" class="form-control"  type="text"/>
					</p>					
					<p class="signin button">
						<button type="button" id="btnNext" style="width: 22%" onclick="return idaction('next','1');" class="btn btn-primary">Next</button>
						<button type="button" id="btnStop" style="width: 22%" onclick="return idaction('stop','1');" class="btn btn-primary">Stop</button>
						<button type="button" id="btnNextFail" style="width: 22%"  onclick="return idaction('next','1');" class="btn btn-warning">Ambil Nanti</button>
					</p>
					<p class="signin button">
						<button type="button" id="btnNextFail" style="width: 22%"  onclick="return idaction('next_fail','0');" class="btn btn-warning">Next-Fail</button>
						<button type="button" id="btnStopFail"  style="width: 22%" onclick="return idaction('stop','0');" class="btn btn-warning">Stop-Fail</button>
						<button type="button" id="btnStopFail"  style="width: 22%" onclick="return idaction('skip','1');" class="btn btn-success">Skip</button>						
					</p>
			</div>							
		</form>
		<pre id="status">
						<div align="left"style=" margin-top:-10%; margin-bottom:-1%; margin-right:1%">						
							<div id="myBar"></div>
						</div></pre>
				<pre id="sdiv">
						<p id="qrcode"></p>
						<p id="pass"></p>

						</pre>
	</div>
</div>
</div>