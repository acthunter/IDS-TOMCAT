<script type="text/javascript">
	var unit ;
	var checkboxNameArry;
	var checkboxValArry;
	var arr;
	var sentpass;
	var dupl;
	$(document).ready(function(){
		$('#clear').click(function() {
			$('input[class=check]').prop('checked', false);
		});
		$('#ok_tabel').hide();
		var url = "<?php echo site_url('stomp/reqmanage/lookup_user')?>" ;
 			$.ajax({
				url : url,
				type: "POST",
				beforeSend: function(){
					$('#wait').modal('show'); 
				},
				dataType: "JSON",
				success: function(data)
				{
					$('#npp').val();
						$('#unit').val(data.pname); 
						unit = data.pname; 
					var wdata = data['opts'];
					if (wdata.length > 0){
						$.each(data.opts, function (index, item) {
							$("#list_apps").append("<tr class='checklisttr "+ item['utype'] +"'><td >"+ item['apps'] +"</td><td style='display:none;' >"+ item['sloginid'] +"</td><td><input type='radio' class='check' id ='"+ item['apps'] +"' value='rst' name='a' ></td></tr>");						});
						$('#ok_tabel').show();		
					}else{
						new PNotify({
							title: 'Notifikasi',
							text: 'User tidak mendapatkan kewenangan reset aplikasi !',
							type: 'info',
							styling: 'bootstrap3'
						});
						/* $('#addlevel').hide();
						addapps(); */
					}					
				}
		});
		$('#btn_submit').on( 'click', function () {	
			arr = [];
			dupl = [];
			sentpass = [];
			$("#list_apps2").closest("tr").remove();
			
			var isValid = $("#form").valid();
			var $chkbox_checked = $('input[name="a"]:checked');
			
			if (isValid){
				if($chkbox_checked.length === 0){
					alert("Silahkan pilih aplikasi terlebih dahulu");
				}
				else {
					var checkboxx = $chkbox_checked.map(function(){
						if(this.value == 'rst'){
							return [this.id]; 
						}
						
					}).get();;
					var url_sentpass = "<?php echo site_url('stomp/reqmanage/filter_sentpass')?>" ;
					var url_popupsent = "<?php echo site_url('stomp/reqmanage/popupsent')?>" ;
					var dataarr;
					
							$.ajax({
							url : url_sentpass,
							type: "POST",
							data: {"checkboxNameArry": checkboxx,
									"npp": $('#npp').val()},
							dataType: "JSON",
							success: function(data)
							{
									dataarr2 = data;
									
									$.ajax({
										url: url_popupsent,
										type: "POST"
										}).done(function(data3) {
										if (dataarr2 == null){
											//add_val();
											/* var cek = "ceksentpass";
													add_val(cek); */
											duplicate(checkboxx);
											//$('#modal_target_content2').modal({show:false});
											
										}else{
											
											$('#modal_target3').html(data3);
											$.each(dataarr2, function (index, item) {
												var tgl_nosr = new Date(item['time']);
												var dd = tgl_nosr.getDate();
												var mm = tgl_nosr.getMonth() + 1; //January is 0!

												var yyyy = tgl_nosr.getFullYear();
												if (dd < 10) {
												  dd = '0' + dd;
												} 
												if (mm < 10) {
												  mm = '0' + mm;
												} 
												//arr.push(item['apps']);
												sentpass.push(item['apps']);
												var tgl_nosr = dd + '-' + mm + '-' + yyyy;
												$("#list_apps4").append("<tr class='checklisttr "+ item['apps'] +"'><td>"+ item['apps'] +"</td><td>"+ tgl_nosr +"</td></tr>");
											});	
												
												$('#modal_target_content3').modal({show:true}); 
												
												$("#btn_prosesdup").click(function(){
													/* var cek = "ceksentpass";
													add_val(cek);  */ 
													
													duplicate(checkboxx);
													$('.modal').on("hidden.bs.modal", function (e) { 
													if ($('.modal:visible').length) { 
														$('body').addClass('modal-open');
														//duplicate(checkboxx);
													}
												});
												});
												

										}
										
									}).fail(function(jqXHR, textStatus) {
										alert("Request failed:  - Please try again.")
									});
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								alert('User not found');
							}
							});
					
					/*  */
					/*  */
				}
			}else{
				return false;
			}


		});
	
		
		
	});
	function duplicate(checkboxx){
		var url = "<?php echo site_url('stomp/reqmanage/filter_data')?>" ;
		var url2 = "<?php echo site_url('stomp/reqmanage/popup2')?>" ;
		var dataarr;
					
							$.ajax({
							url : url,
							type: "POST",
							data: {"checkboxNameArry": checkboxx,
									"npp": $('#npp').val()},
							dataType: "JSON",
							success: function(data)
							{
									dataarr = data;
									
									$.ajax({
										url: url2,
										type: "POST"
										}).done(function(data2) {
										if (dataarr == null){
											//add_val();
											var cek = "ceksentpass";
											add_val(cek);
											//$('#modal_target_content2').modal({show:false});
											
										}else{
											
											$('#modal_target2').html(data2);
											
											$.each(dataarr, function (index, item) {
												var tgl_nosr = new Date(item['time']);
												var dd = tgl_nosr.getDate();
												var mm = tgl_nosr.getMonth() + 1; //January is 0!

												var yyyy = tgl_nosr.getFullYear();
												if (dd < 10) {
												  dd = '0' + dd;
												} 
												if (mm < 10) {
												  mm = '0' + mm;
												} 
												//arr.push(item['apps']);
												dupl.push(item['apps']);
												var tgl_nosr = dd + '-' + mm + '-' + yyyy;
												$("#list_apps3").append("<tr class='checklisttr "+ item['apps'] +"'><td>"+ item['apps'] +"</td><td>"+ tgl_nosr +"</td></tr>");
											});	
												
												$('#modal_target_content2').modal({show:true}); 
												
												$("#btn_prosesdup2").click(function(){
													var cek = "cekduplicate";
													add_val(cek); 
												});
												$('.modal').on("hidden.bs.modal", function (e) { 
													if ($('.modal:visible').length) { 
														$('body').addClass('modal-open');
													}
												});
										}
										
									}).fail(function(jqXHR, textStatus) {
										alert("Request failed:  - Please try again.")
									});
							},
							error: function (jqXHR, textStatus, errorThrown)
							{
								alert('User not found');
							}
							});
	}
	
	function add_val(cek){
			var isValid = $("#form").valid();
			var $chkbox_checked = $('input[name="a"]:checked');
			if (isValid){
				if($chkbox_checked.length === 0){
					alert("No Row Selected");
					
				}
				else {
					
					arr = dupl.concat(sentpass);
					checkboxNameArry = $chkbox_checked.map(function(){
						var idx = $.inArray(this.id, arr);
						if (idx == -1) {
							return [this.id];
							
						}
						 
					}).get();;
					console.log(checkboxNameArry);
					checkboxValArry = $chkbox_checked.map(function(){
						var idx = $.inArray(this.id, arr);
						if (idx == -1) {
							return [this.value];
						}
					}).get();;
					checkboxLogArr = $chkbox_checked.map(function(){
						row = $(this).closest("tr");
						var idx = $.inArray(this.id, arr);
						if (idx == -1) {
							return [$(row).find('td:eq(1)').text()];
							
						}
						
					}).get();;
					var fdata = {'app' :checkboxNameArry,'val_app':checkboxValArry,'slog':checkboxLogArr};
					var url = "<?php echo site_url('stomp/reqmanage/popup')?>" ;
					var url2 = "<?php echo site_url('stomp/reqmanage/list_popup')?>" ;
					 
						$.ajax({
								url : url2,
								type: "POST",
								data: fdata,
								dataType: "JSON",
								success: function(data2)
								{
									
									if (data2 != null){
									$.ajax({
										url: url,
										type: "POST"
									}).done(function(data) {
										
										  $('#modal_target').html(data);
											$.each(data2, function (index, item) {
												$("#list_apps2").append("<tr class='checklisttr "+ item['val_app'] +"'><td>"+ item['app'] +"</td><td>"+ item['val_log'] +"</td><td><input type='radio' class='check' id ='b' value='rst' name="+ item['app'] +" checked ></td></tr>");
											});
											process();
											$('.npp').text("<?php echo $this->session->userdata('pengguna')->loginid ?>");
											$('.nama').text("<?php echo $this->session->userdata('pengguna')->nama ?>");
											$('.unit').text(unit);
											$('#modal_target_content').modal({show:true});
											
									}).fail(function(jqXHR, textStatus) {
										alert("Request failed:  - Please try again.")
									  });
									
									
									}else{
										if (sentpass.length != 0 && dupl.length != 0){
											var text = 'Password aplikasi '+sentpass+' telah dikirimkan melalui email dan belum dibuka oleh npp <?php echo $this->session->userdata('pengguna')->loginid ?>.';
											var text2 = 'Saat ini password '+dupl+' sedang diproses oleh OTI';
											var type = 'error';
											new PNotify({
												title: 'Request gagal!',
												text: text+'<br>'+text2,
												type: type,
												styling: 'bootstrap3'
											});
										}else if (sentpass.length > 0){
											var text = 'Password telah dikirimkan melalui email dan belum dibuka oleh npp <?php echo $this->session->userdata('pengguna')->loginid ?>.';
											var text2 = 'Jika npp <?php echo $this->session->userdata('pengguna')->loginid ?> belum menerima email password silahkan menggunakan menu TRACKING PENGIRIMAN PASSWORD untuk mengirimkan passwordnya kembali';
											var type = 'error';
											new PNotify({
												title: 'Request gagal!',
												text: text+'<br>'+text2,
												type: type,
												styling: 'bootstrap3'
											});
										}else{
										var text = 'Aplikasi telah direset sebelumnya';
										var text2 = 'saat ini password sedang diproses oleh OTI';
										var type = 'error';
										new PNotify({
											title: 'Request gagal!',
											text: text+'<br>'+text2,
											type: type,
											styling: 'bootstrap3'
										});
										}
									}
									
								}
						});
					      // this will have the content of the view
					 
				}
			}else{
				return false;
			}
	}
	function process(){
		$('#btn_process').on( 'click', function () {
			var fdata = {'app' :checkboxNameArry,'val_app':checkboxValArry};
			var url = "<?php echo site_url('stomp/reqmanage/wfaction')?>" ;
			//let isBoss = confirm("Apakah Konfirmasi Request sudah benar?");
			//if(isBoss == true){
			if(confirm("Apakah Konfirmasi Request sudah benar?")){
				var text = 'Request telah Berhasil dan segera diproses.';
				var text2 = 'Silahkan Cek Email Secara Berkala';
				var type = 'success';
				new PNotify({
					title: 'Notifikasi',
					text: text+'<br>'+text2,
					type: type,
					styling: 'bootstrap3'
				});
				$.ajax({
					url : url,
					type: "POST",
					data: fdata,
					dataType: "JSON",
					success: function(data)
					{
						alert("done");
					}
				});
				$('input[class=check]').prop('checked', false);
				$('#modal_target_content').modal('hide');
			} 
			
		});
	}
	function addapps(){
			$('#npp2').val($('#npp').val());
			var url = "<?php echo site_url('itservice/Xmain/lookup_apps')?>" ;
 			$.ajax({
				url : url,
				type: "POST",
				//data: fdata,
				dataType: "JSON",
				
				success: function(data)
				{
					//alert(JSON.stringify(data));
					//$('#wait').modal('hide');
					$.each(data.opts, function (index, item) {
						//alert(item['apps']);
						$("#list_apps").append("<tr class='checklisttr'><td>"+ item['apps'] +"</td><td><input class='check' type='radio' id ='a' value='rst' name="+item['apps'] +" ></td></tr>");
						  });
					$('#addRow, #clear').show();
					
				},
				
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			}); 
	}
</script>

<style>
#tb_action button { width: 100px }
.catlabel {width: 100px }

#wrapper input:not([type="radio"]), select {
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
		<form action="#" id="form" style="width: 900px; margin: auto;">
			<div class="row" >
			<div class="col-md-12 text-center">
				<h2> Request Management</h2>
				</div>
			</div>
			<div class="row" >
			<div class="col-md-12 portfolio-image">
                <div class="col-md-6 portfolio-image">
					<p>
						<label>NPP</label> 	
						<input name="npp" id="npp" placeholder="-- NPP --" type="text" onclick="$(this).val('');" value="<?php echo $this->session->userdata('pengguna')->loginid ?>" disabled>
					</p>
					<p>
						<label>Nama</label> 	
						<input name="nama" id="nama" placeholder="-- Nama --" value="<?php echo $this->session->userdata('pengguna')->nama ?>" type="text" disabled>
					</p>				
					<p>		
						<label>Unit</label> 
						<input name="unit" id="unit" type="text" style="height: 30px;"  disabled></input>
						<input type='hidden' id="accoffice" name='accoffice' class="form-control" value="<?php echo $this->session->userdata('pengguna')->accoffice ?>" placeholder="Kode Unit">
					</p>
                </div>
                <div class="col-md-6 portfolio-image">
                    <p>		
						<label>Aplikasi </label> 
						<table id="ok_tabel" class="table table-bordered">
							<thead >
							  <tr style="background: #F6F6F6;">
								<th>Nama Aplikasi</th>
								<th>Reset</th>
							  </tr>
							</thead>
							<tbody id="list_apps">
							</tbody>
						</table>
					</p>
                </div>
			</div>
			<div class="col-md-12">
				<div class="col-md-6 portfolio-image" style="margin: 15px 17px 10px;">
					<button type="button" id="btn_submit" class="btn btn-primary">Submit</button>
					<button type="button" id="clear" class="btn btn-default">Clear</button> 
				</div>
			</div>
			<div class="col-md-12">
				<ul style="font-size:12px;color: red;">
					<p style="margin-left: -5px;margin-top: 10px;color: red;margin-bottom: auto;">Catatan : </p>
					<li style="margin-left: 10px;">Reset password ICONS atau Webmail dapat dilakukan di menu <b>Reset Target</b></li>
					<li style="margin-left: 10px;">Menu <b>Reset Target</b> terletak di luar IDS</li>
				</ul>
			</div>
            </div>
		</form>
		<div class="modal-container" id="modal_target"></div>
		<div class="modal-container" id="modal_target2"></div>
		<div class="modal-container" id="modal_target3"></div>
</div>
