<script type="text/javascript">
	
	function  <?php echo $modal_id;?>_trigger(fdata){
		
		var now = new Date();
		var day = ("0" + (now.getDate())).slice(-2);
		var month = ("0" + (now.getMonth() + 1)).slice(-2);
		var dob = (now.getFullYear()-5)+"-"+(month)+"-"+(day) ;
		var today = (now.getFullYear())+"-"+(month)+"-"+(day) ;
		
		$('#div_btn_<?php echo $modal_id;?> button').hide();
			$('#DOB').datetimepicker({
							  ignoreReadonly: true,
							  maxDate: dob,
							  widgetPositioning: { vertical: 'bottom' },
							   format: 'YYYY-MM-DD'
							});
		$('#DOB').val('');
		 var time = new Date();
		 var hour_time = time.getHours();
		 
		 if (hour_time >= 22 || hour_time <= 5 ){
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

						
						$('#cposname').val(rdata['pname']);
						$('#cposid').val(rdata['positionid']);
						var datedob = rdata['DOB'];
						var datedob2 = datedob.split("-");
						var yy = datedob2[2]+'-'+datedob2[1]+'-'+datedob2[0];
						$('#DOB').val(yy);
						
						var s = rdata['sdate'];
						sdt = s.split(' ');
						if ( (sdt[1] == "0:00")){
							sdt[1] = '00:00'; 
						}
						ssda = sdt[0];
						$('[name="sdate"]').val(sdt[0]);
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

						if (fdata['reqtype'] == "read_list"){
							$('[id="div_btn_<?php echo $modal_id;?>"]').hide();
							var arr_ro = "new,cposname,tposname,sdate,edate,loginid,jam,DOB".split(",");
							console.log(arr_ro);
							for(cid of arr_ro){
								$('#' + cid).attr('disabled', true);
							}
							
						}else{
							if (wdata['stage'] != '1'){
							$('input[type=radio]').attr('disabled', true);
							$('#keterangan').hide();
							$('#ket').text(rdata['note']); 
							var arr_ro = "new,cposname,tposname,sdate,edate,loginid,DOB,jam".split(",");
							console.log(arr_ro);
							for(cid of arr_ro){
								$('#' + cid).attr('disabled', true);
							}
								
							}else{

								var arr_ro = "loginid".split(",");
								for(cid of arr_ro){
									$('#' + cid).attr('readonly', true).css('pointer-events', 'none');
								}
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
				var arr_ro = "new,tposname,sdate,edate,jam,DOB".split(",");
				for(cid of arr_ro){
					$('#' + cid).attr('disabled', false);
				}
				$('#<?php echo $modal_id;?>_form #btn_save').show();
			});
		}
		
		$("#<?php echo $modal_id;?> #cposname").autocomplete({  
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

				select: function( event, ui ) {					
					$('#cposid').val(ui.item.rvalue.positionid);
				}	
			});
			
		$(function () {
			var now = new Date();
			now.setHours(0,0,0,0);
			var yest = new Date(new Date().setDate(now.getDate() - 1));
			$('#sdate').datetimepicker({
                  ignoreReadonly: true,
				  minDate: today,
				  widgetPositioning: { vertical: 'bottom' },
				   format: 'YYYY-MM-DD'
                }).on("dp.change", function (e) {
					$('#exp').hide();
					$('#<?php echo $modal_id;?>_btn_approve').attr('disabled', false).css('pointer-events', 'auto');
					$('#<?php echo $modal_id;?>_btn_submit').attr('disabled', false).css('pointer-events', 'auto');
					return $(this).data('DateTimePicker').defaultDate(now).minDate(now);
						});
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
						maxlength: 5,
						digits: true
                    },
					cposname: {
						required: true
					},
					sdate: {
						required: true
					},
					DOB: {
						required: true
					}
                },
                messages: {
					loginid: {
						required: "Please enter loginid",
						minlength: "Your loginid must be at least 5 number long",
						maxlength: "Users cannot be created"
					},
					nama: {
						required: "Please re-enter loginid"
					},
					cposname: {
						required: "Please enter position"
					},
					sdate: {
						required: "Please enter date"
					},
					DOB: {
						required: "Please enter date of birth"
					}
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
		});
	};
	
	function query_id()
		{		
			var npp = $('#loginid').val();
			if(npp.length <= 5){
				var url = "<?php echo site_url('stomp/xids/query')?>" ;
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
								var arr_ro = "new,tposname,sdate,edate,jam,DOB".split(",");
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
						
							if (data.DOB == null){
								alert("Silahkan cek kembali request");
									
							}else{
								var tgl = data.DOB;
								var arr = tgl.split(/-/);
								var today = arr[0]+'-'+arr[1]+'-'+arr[2];
								$('[name="DOB"]').val(today);
							}
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
			}else{
				$('#nama,#loginid, #cposid, #cposname').val('');
				new PNotify({
					title: 'Notifikasi',
					text: 'Maaf untuk user tersebut tidak dapat create icons',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
		}
	
	
	
	
	
	function <?php echo $modal_id;?>_submit(btype){
		$('#cposname,#DOB, #tposname,#sdate,#edate,#loginid,#jam').removeAttr('disabled');
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
			var cpos = $('#cposid').val();
			if (cpos.length < 1){
				alert("please select position name");
				$('#cposname').val('');
				return ;
			}
		if (isValid){
			action_submit(fdata);
		}else{
			$('#cposname').attr('disabled',true);
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
			<p class="formHeader" style="font-size: 30px;">Create icons</p>
			<p class="judul" align= "center" style="margin-left:25%; width:70%;color: red;" id="lockinfo" ></p>			
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
			<div class="form-group row"style="width:90%;margin-left:6%; ">
				<p id="l-login">
					<label class="judul" >LoginID</label>
					<input style="width: 23%" name="loginid" id="loginid" placeholder="Login ID" class="column-full form-control" type="text" onchange="query_id()"onclick="$('#loginid, #nama,#DOB,#cposname, #cposid').val('').text('');">
					<label name="nama" class="labelisi" style="width:65%;" id="nama" ></label>
					<input name="nama" id="nama" readonly type="hidden">					
				</p> 
								<p>
				<label class="judul">Tanggal Lahir</label>
				<input name="DOB" id="DOB" placeholder="Tanggal Lahir" class="form-control" type="text" readonly >
				</p>
				<p>
				<label class="judul">Posisi </label> 
				<input id="cposname" name="cposname" list="tpos" placeholder="-- Posisi  --" class="autocomplete form-control" type="text" disabled> 
				</p>

				<p>
				<label class="judul">Tanggal Efektif</label>
				<input name="sdate" id="sdate" placeholder="Tanggal Efektif" class="form-control" style="width: 28%; float:left" type="text" readonly>
				<input name="jam" placeholder="Tanggal Efektif" id="jam" class="form-control" style="width: 15%;" type="text" readonly>
				</p>
				<ul style="font-size:12px;color: red;margin-bottom: 25px; margin-top: 10px;
				margin-left:-30px;">
					<label style="margin-left: -5px;margin-top: 10px;">Catatan : </label>

					<li>Menu create icons ini hanya diperuntukkan untuk pembuatan icons bagi user yang sudah terdaftar di SSO namun belum memiliki user icons </li>
					<li>Silahkan dipermanenkan kembali posisi ybs, icons akan efektif H+1 setelah dipermanenkan posisinya </li>
				</ul>
					<input name="cposid" id="cposid" readonly type="hidden">
					<input name="status" id="status" class="form-control" type="hidden" >
					<input name="id" id="id" class="form-control" type="hidden" >
					<input name="mode" id="mode" class="form-control" type="hidden" value="CI" >
					<input name="wfid" id="wfid" class="form-control" type="hidden" >	
					<input name="reqtype" id="reqtype" class="form-control" type="hidden" >						
					<input name="notes" id="notes" class="form-control" type="hidden" >								
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
			</div>							
		</form>
	</div>
    </div>
  </div>
  
</div>