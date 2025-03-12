<script type="text/javascript">
	
	function  <?php echo $modal_id;?>_trigger(fdata){
		console.log(fdata);
		$('#div_btn_<?php echo $modal_id;?> button').hide();
		var current_date = new Date();
		var a = -current_date.getTimezoneOffset() / 60;
		 var time = new Date();
		 var hour_time = time.getHours();
		 //alert(hour_time);
		 if (hour_time >= 22 || hour_time <= 5 ){
			  //alert("Tidak dapat melakukan request SSO. Silahkan dicoba kembali lain hari");
			  $('#isi').hide();
			  $('#alert').show();
		 }else{
			  $('#alert').hide();
			  $('#isi').show();
		 }
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
					$('#keterangan').val(rdata['note']);
/* 						$('#nama').val(rdata['nama']);
						$('#cposname').val(rdata['cposname']);
						$('#cposname').text(rdata['cposname']);
						$('#nama').text(rdata['nama']); */

						//$('#<?php echo $modal_id;?>_form #nama').val(data['name']);
						$('#cposid').val(rdata['cposid']);
						
						$('#tposname').val(rdata['pname']);
						$('#tposid').val(rdata['tpos']);
						var s = rdata['sdate'];
						sdt = s.split(' ');
						//alert(a)
						//datetimepicker();
						if ( (sdt[1] == "0:00")){
							sdt[1] = '00:00'; 
						}
						ssda = sdt[0];
						$('[name="sdate"]').val(sdt[0]);
						//$('[name="jam"]').val(sdt[1]);
						var current_date = new Date();
						var a = -current_date.getTimezoneOffset() / 60;
		
						if (a == '8'){
							if(sdt[1] != "00:00"){
								$val = sdt[1].split(":");
							
							$('#jam').val((parseInt($val[0])+1)+":"+$val[1]);
								
							}else{
								$('[name="jam"]').val(sdt[1]);
							}
						 }else if (a == '9'){
							if(sdt[1] != "00:00"){
								$val = sdt[1].split(":");
								$('#jam').val((parseInt($val[0])+2)+":"+$val[1]);
							}else{
								$('[name="jam"]').val(sdt[1]);
							}
						 }else{
							 $('[name="jam"]').val(sdt[1]);
						 }
						 
						//$('#sdate').val(rdata['sdate']);
						//$('#edate').val(rdata['edate']);
						var s = new Date(rdata['sdate']);
						var dd = s.getDate();
						var mm = s.getMonth()+1;
						var hh = s.getHours();
						var minu = s.getMinutes();
						if(dd<10)  { dd='0'+dd } 
						if(mm<10)  { mm='0'+mm } 
						if(hh<10){ hh='0'+hh } 
						if(minu<10){ minu='0'+minu } 
						var y = s.getFullYear()+'-'+mm+'-'+dd;
						var d = new Date();
							var strDate = d.getFullYear() + "-" + (((d.getMonth() + 1) < 10 ? '0' : '') + (d.getMonth() + 1)) + "-" + (d.getDate() < 10 ? '0' : '') + d.getDate();
												
						if (wdata['stage'] != '1'){
							if (wdata['stage'] >= '3'){
								$('#div_btn_<?php echo $modal_id;?> button').hide();
							}else{
								var arr_ro = "tposname,sdate,jam,edate,loginid".split(",");
								console.log(arr_ro);
								$('#keterangan').hide();
								$('#ket').text(rdata['note']);  
								for(cid of arr_ro){
									$('#' + cid).attr('readonly', true).attr("style", "pointer-events: none;");
								}
								$('[name="sdate"]').attr("style", "display: block;width:28%; float: left").attr('disabled', true);
								$('[name="loginid"]').attr("style", "display: block;width:23%; float: left").attr('disabled', true);
								$('[name="jam"]').attr("style", "display: block;width: 15%;").attr('disabled', true);
								if(ssda <= strDate){
									if ((ssda == strDate) && (sdt[1] != "00:00")){
										
										$('#exp').hide();
									}else{
										
										$('#exp').show();
										$('#<?php echo $modal_id;?>_btn_approve').attr('disabled', true).css('pointer-events', 'none');
									}
								}else{
									$('#exp').hide();
								}
							}
						}else{
							if(ssda <= strDate){
								if ((ssda == strDate) && (sdt[1] != "00:00")){
									$('#exp').hide();
								}else{
									$('#exp').show();
									$('#<?php echo $modal_id;?>_btn_submit').attr('disabled', true).css('pointer-events', 'none');
								}
							}else{
								
								$('#exp').hide();
							}
							var arr_ro = "loginid".split(",");
							for(cid of arr_ro){
								$('#' + cid).attr('readonly', true).css('pointer-events', 'none');
							}
						}
						if ((fdata['reqtype'] == "read_list") && (wdata['stage'] >= '3')){
							var arr_ro = "tposname,sdate,jam,edate,loginid,keterangan".split(",");
							//console.log(arr_ro);
							//$('#keterangan').hide();
							//$('#ket').text(rdata['note']);
							$('#exp').hide();							
							for(cid of arr_ro){
								$('#' + cid).attr('disabled', true);
							}
						}
						
						$('#<?php echo $modal_id;?>_form #id').val(data['id']);
						
						for (val of wdata["eaction"]){
							$("#<?php echo $modal_id;?>_btn_" + val).show();
						}
					}
			});
		}
		else {
			$('#exp').hide();
			var ss = new Date();
						var ddd = ss.getDate();
						var mmm = ss.getMonth()+1;
						var hhh = ss.getHours();
						var minuu = ss.getMinutes();
						if(ddd<10)  { ddd='0'+ddd } 
						if(mmm<10)  { mmm='0'+mmm } 
						if(hhh<10){ hh='0'+hhh } 
						if(minuu<10){ minuu='0'+minuu } 
						var yy = ss.getFullYear()+'-'+mmm+'-'+ddd;
			$('[name="sdate"]').val(yy);
			$('#<?php echo $modal_id;?>_form #btn_save').show();
			$('#loginid').click(function() {
				var arr_ro = "keterangan,tposname,sdate,jam,edate".split(",");
				for(cid of arr_ro){
					$('#' + cid).attr('disabled', false);
				}
				$('#<?php echo $modal_id;?>_form #btn_save').show();
			});
		}
		
		$("#<?php echo $modal_id;?> #tposname").autocomplete({   
				minLength: "2",  
				source:   
				function(request, response){  
				console.log('test');
					$.ajax({  
						//url: "<?php echo site_url('stomp/xids/pos_search')?>",  
						url: "<?php echo site_url('stomp/xids/pos_searchdata')?>",  
						dataType: 'json',  
						type: 'POST',  
						data: {
							pattern: request.term,
							'loginid' : $('#loginid').val()
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
			
		$(function () {
			var now = new Date();
			now.setHours(0,0,0,0);
			var yest = new Date(new Date().setDate(now.getDate() - 1));
			/* $('#sdate').datetimepicker({
            ignoreReadonly: true, defaultDate: now, minDate: now, widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('YYYY-MM-DD '); */
			$('#sdate').datetimepicker({
                  ignoreReadonly: true,
				  widgetPositioning: { vertical: 'bottom' },
				   format: 'YYYY-MM-DD'
                }).on("dp.change", function (e) {
					$('#exp').hide();
					$('#<?php echo $modal_id;?>_btn_approve').attr('disabled', false).css('pointer-events', 'auto');
					$('#<?php echo $modal_id;?>_btn_submit').attr('disabled', false).css('pointer-events', 'auto');
					return $(this).data('DateTimePicker').defaultDate(now).minDate(now);
						});
			//alert(now);
			$('#jam').datetimepicker({
				ignoreReadonly: true,
				defaultDate: new Date,
				minDate:new Date().setHours(new Date().getHours(),new Date().getMinutes(),0,0),
                maxDate:new Date().setHours(22,0,0,0),
				format:'HH:mm', widgetPositioning: { vertical: 'bottom' }
			});

			
		});
 		$("#sdate").on("dp.change", function (e) {
				var sdate = $("#sdate").val();
				var now = new Date();
				var dat = now.getDate();
				var m = now.getMonth() + 1 ;
				var ho = now.getHours ;
				var mi = now.getMinutes ;
				if(dat<10)  { dat='0'+dat } if(m<10)  { m='0'+m } if(ho<10){ ho='0'+ho } if(mi<10){ mi='0'+mi }
				var noww = now.getFullYear()+"-"+m+"-"+dat;
				 if (sdate != noww){
					var y = new Date();
					y.setHours(0,0,0,0);
					$('#jam').data("DateTimePicker").minDate(y).date(new Date(new Date().setHours(0,0,0,0)));
					$('#jam').attr('disabled', true);
				}else{
					var x = new Date(e.date);
					
					$('#jam').data("DateTimePicker").minDate(new Date(new Date().setHours(new Date().getHours(),new Date().getMinutes(),0,0))).date(new Date(new Date().setHours(now.getHours,now.getMinutes,0,0))).maxDate(new Date(new Date().setHours(22,0,0,0)));
					$('#jam').removeAttr('disabled'); 
				} 
				//}
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
                rules: {
                    loginid: {
                        required: true,
                        minlength: 5,
						digits: true
                    },
					tposname: {
						required: true,
						minlength: 3
						//regex: /^[0-9]+$/
					},
					keterangan: {
						required: true
						//regex: /^[0-9]+$/
					}
                },
                messages: {
					loginid: {
						required: "Please enter loginid",
						minlength: "Your loginid must be at least 5 number long"
					},
					tposname: {
						required: "Please enter position",
						minlength: "position must be at least 3 character long",
					},
					keterangan: {
						required: "Please enter keterangan"
					}
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
	};
	
	function query_id()
		{		
			var url = "<?php echo site_url('stomp/xids/query')?>" ;
			var npp = $('#loginid').val();
			//if(npp.length <= 5){
			$.ajax({
				url : url,
				type: "POST",
				data: {"npp": $('#loginid').val()},
				dataType: "JSON",
				success: function(data)
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
							var arr_ro = "keterangan,tposname,sdate,jam,edate".split(",");
							for(cid of arr_ro){
								$('#' + cid).attr('disabled', true);
							}
							$('#div_btn_<?php echo $modal_id;?> button').hide();
							
						}
					$('[name="nama"]').text(data.name);
					$('[name="nama"]').val(data.name);
					$('[name="cposid"]').val(data.positionid);
					$('[name="cposname"]').text(data.nama);
					$('[name="cposname"]').val(data.nama);
					} else{
						alert('User not found');
						$('#nama,#loginid, #cposid, #cposname').val(null);
						$('#nama,#cposname').text("");
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
			/* }else{
				//$('#nama,#loginid, #cposid, #cposname').val('');
				$('#nama,#loginid, #cposid, #cposname').val(null);
				$('#nama,#cposname').text("");
				new PNotify({
					title: 'Notifikasi',
					text: 'Maaf untuk user tersebut tidak dapat perubahan posisi. Silahkan mengajukan surat / memo ke Divisi ISU untuk perubahan posisi user tersebut',
					type: 'error',
					styling: 'bootstrap3'
				});
			} */
		}
	
	
	
	
	
	function <?php echo $modal_id;?>_submit(btype){
		$('#tposname,#sdate,#edate,#loginid,#jam').removeAttr('disabled');
		var fdata = {'url': 'wf/wfaction', 'modal_id' : "<?php echo $modal_id;?>", 'btype': btype };
		//;
		var isValid = $("#<?php echo $modal_id;?>_form").valid();
		console.log(isValid);
		var current_date = new Date();
		var a = -current_date.getTimezoneOffset() / 60;
		
		 if (a == '8'){
			if($('#jam').val() != "00:00"){
				$val = $('#jam').val().split(":");
				$('#jam').val(($val[0]-1)+":"+$val[1]);
			}
		}else if (a == '9'){
			if($('#jam').val() != "00:00"){
				$val = $('#jam').val().split(":");
				$('#jam').val(($val[0]-2)+":"+$val[1]);
			}
		 }
			var cpos = $('#tposid').val();
			if (cpos.length < 1){
				alert("please select position name");
				$('#tposname').val('');
				return ;
			}
		if (isValid)
			action_submit(fdata);
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
  <div class="modal fade"  id="<?php echo $modal_id;?>_content" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
		<div id="wrap">
		<form action="#"  id="<?php echo $modal_id;?>_form"  role="form">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Ubah Kewenangan Permanen</p>
			<p class="judul" align= "center" style="margin-left:25%; width:70%;color: red;" id="lockinfo" ></p>			
			<div id="wfinfo" class="infohide"style="margin-right: 8%;margin-left: 9%">
				<label for="doneActor">Done</label> <ul id="doneActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
				<label for="currActor">Curr</label> <ul id="currActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
			</div>
			<div id="alert">
				<div class="alert alert-danger" align="center">
					 Tidak dapat melakukan request. <br>
					 Request bisa dilakukan pukul (06.00 - 22.00 WIB).
				  </div>
			</div>
			<div id="isi"> 
			<div class="alert alert-danger" id="exp" style="display: block;" hidden="" align="center">
			  Tanggal Efektif tidak berlaku 
				<div>silahkan disesuaikan kembali tanggal efektifnya oleh admin</div>
			</div>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row"style="width:90%;margin-left:6%; ">
				<p id="l-login">
					<label class="judul" >LoginID</label>
					<input style="width: 23%" name="loginid" id="loginid" placeholder="Login ID" class="column-full form-control" type="text" onchange="query_id()"onclick="$('#loginid, #nama,#cposname,#tposname, #tposid').val('').text('');">
					<label name="nama" class="labelisi" id="nama" ></label>
					<input name="nama" id="nama" readonly type="hidden">					
					<label for="nama"  class="labelisi" name="cposname" id="cposname" ></label>
					<input name="cposname" id="cposname" readonly type="hidden">
				</p>
				<p >
				<label class="judul">Posisi Baru</label> 
				<input id="tposname" name="tposname" list="tpos" placeholder="-- Posisi Baru --" class="autocomplete form-control" type="text" onclick="$(this).val(''); $('#tposid').val('');">
				</p>
				<p>
				<label class="judul">Tanggal Efektif</label>
				<input name="sdate" id="sdate" placeholder="Tanggal Efektif" class="form-control" style="width: 28%; float:left" type="text" readonly>
				<input name="jam" placeholder="Tanggal Efektif" id="jam" class="form-control" style="width: 15%;" type="text" readonly>
				</p>
				<p >
					<label class="judul">Keterangan</label> 
					<input id="keterangan" name="keterangan" list="tpos" class="form-control" placeholder="-- Keterangan --" type="text">
					<label id="ket" name="ket"></label>
				</p>
				<ul style="font-size:12px;color: red;margin-bottom: 25px; margin-top: -23px;
				    margin-left:-30px;">
					<label style="margin-left: -5px;margin-top: 10px;">Catatan : </label>
					<li>Agar aplikasi icons dapat langsung efektif, pastikan user telah login icons terlebih dahulu  </li>
				</ul>
					<input name="tposid" id="tposid" readonly type="hidden">
					<input name="status" id="status" class="form-control" type="hidden" >
					<input name="id" id="id" class="form-control" type="hidden" >
					<input name="mode" id="mode" class="form-control" type="hidden" value="CP" >
					<input name="wfid" id="wfid" class="form-control" type="hidden" >	
					<input name="reqtype" id="reqtype" class="form-control" type="hidden" >						
					<input name="notes" id="notes" class="form-control" type="hidden" >								
				<p  class="signin button" id="div_btn_<?php echo $modal_id;?>">
						<br>
						<button type="button" id="btn_save" onclick="<?php echo $modal_id;?>_submit('save')" class="btn btn-primary">Save</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_submit" onclick="<?php echo $modal_id;?>_submit('submit')" class="btn btn-primary">Submit</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_cancel" onclick="<?php echo $modal_id;?>_submit('cancel')" class="btn btn-danger">Cancel</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_approve" data-dismiss="modal" onclick="<?php echo $modal_id;?>_submit('approve')" class="btn btn-primary">Approve</button>
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