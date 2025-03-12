<script type="text/javascript">
	
	function  <?php echo $modal_id;?>_trigger(fdata){
		console.log(fdata);
		$('#div_btn_<?php echo $modal_id;?> button').hide();
		
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
						
						//$('#wfid').val(wdata['wfid']);
						$('#loginid').val(rdata['loginid']);
						//$('#mode').val(wdata['mode']);
						$('[name="unit"]').val(rdata.unitbaru);
						$('[name="nama"]').val(rdata.nama);
						$('[name="uname"]').text(rdata.unit);
						$('[name="uname"]').val(rdata.unit);
						$('[name="nama"]').text(rdata.nama);
						$('[name="accOffice"]').val(rdata.accOffice);
						//$('[unit="unit"]').html(ids);
					//$('[name="nama"]').val(rdata.nama);
					//$('[name="cposname"]').text(rdata.cposname);
					//$('[name="cposname"]').val(rdata.cposname);
					
/* 						$('#nama').val(rdata['nama']);
						$('#cposname').val(rdata['cposname']);
						$('#cposname').text(rdata['cposname']);
						$('#nama').text(rdata['nama']); */

						//$('#<?php echo $modal_id;?>_form #nama').val(data['name']);
						var s = rdata['sdate'];
						sdt = s.split(' ');
						//alert(a)
						//datetimepicker();
						$('[name="sdate"]').val(sdt[0]);
						$('[name="jam"]').val(sdt[1]);
					/* 	$('#sdate').val(rdata['sdate']);
						$('#edate').val(rdata['edate']); */
						
						if (wdata['stage'] != '1'){
							var arr_ro = "tposname,sdate,edate,unit,loginid".split(",");
							console.log(arr_ro);
							for(cid of arr_ro){
								$('#' + cid).attr('readonly', true).addClass("read");;
							}
						}else{
							var arr_ro = "loginid".split(",");
							for(cid of arr_ro){
								$('#' + cid).attr('readonly', true).addClass("read");
							}
						}
						
						$('#<?php echo $modal_id;?>_form #id').val(data['id']);
						$('#<?php echo $modal_id;?>_form #wfid').val(data['wfid']);
						
						for (val of wdata["eaction"]){
							$("#<?php echo $modal_id;?>_btn_" + val).show();
						}
					}
			});
		}
		else {
			$('#<?php echo $modal_id;?>_form #btn_save').show();
		}
		
			
		/* $(function () {
			var now = new Date();
			var yest = new Date(new Date().setDate(now.getDate() - 1));
			$('#sdate').datetimepicker({
				ignoreReadonly: true,
				minDate: yest,
				disabledDates: [yest],
				defaultDate: now,
				format:'DD-MM-YYYY HH:mm', widgetPositioning: { vertical: 'bottom' }
			});
			$("#sdate").on("dp.change", function (e) {
				$('#edate').data("DateTimePicker").minDate(e.date);
			});
		}); */
		$(function () {
			var now = new Date();
			
			var day = ("0" + (now.getDate()+ 1)).slice(-2);
			var month = ("0" + (now.getMonth() + 1)).slice(-2);

			var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
						
			var yest = new Date(new Date().setDate(now.getDate() - 1));
			/* $('#sdate').datetimepicker({
            ignoreReadonly: true, defaultDate: now, minDate: now, widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('YYYY-MM-DD '); */
			$('#sdate').datetimepicker({
                  ignoreReadonly: true,
				  defaultDate: today,
				  minDate: today,
				  widgetPositioning: { vertical: 'bottom' },
				   format: 'YYYY-MM-DD'
                });
			//alert(now);
			$('#jam').datetimepicker({
				ignoreReadonly: true,
				defaultDate: new Date().setHours(0,0,0,0),
				minDate:new Date().setHours(0,0,0,0),
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
				if(dat<10)  { dd='0'+dat } if(m<10)  { m='0'+m } if(ho<10){ ho='0'+ho } if(mi<10){ mi='0'+mi }
				var noww = now.getFullYear()+"-"+m+"-"+dat;
				 if (sdate != noww){
					var y = new Date();
					y.setHours(0,0,0,0);
					$('#jam').data("DateTimePicker").minDate(y).date(new Date(new Date().setHours(0,0,0,0)));
					$('#jam').attr('disabled', true);
				}else{
					//var x = new Date(e.date);
					
					var y = new Date();
					y.setHours(0,0,0,0);
					$('#jam').data("DateTimePicker").minDate(y).date(new Date(new Date().setHours(0,0,0,0)));
					//$('#jam').data("DateTimePicker").minDate(new Date(new Date().setHours(0,0,0,0))).date(new Date(new Date().setHours(0,0,0,0))).maxDate(new Date(new Date().setHours(22,0,0,0)));
					//$('#jam').removeAttr('disabled'); 
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
		$('#progressbar').click(function(){
			var ctarget = $('#wfinfo');
			if (ctarget.hasClass('infohide'))
				ctarget.removeClass('infohide');
			else
				ctarget.addClass('infohide');
		});	
		
		
		$('#srch').click(function(){
			var h_modal_id = '#modal_l2';
			$(h_modal_id + "_content2").modal({show:true});
			//thefield = $(this).prev()
			//$('<?php echo $modal_id;?>_btn_confirm').on('click', function(){
				//theselected = $(this).prev()
				//thefield.val( theselected.val() )
				//$('#<?php echo $modal_id;?>_content2').hide()
							//var fparam = {'id' : rdata['id'], "mode" : 'RI',
							//	'url':'rpositem', 'reqtype' : 'readitem'};
							//loadForm('modal_l2', fparam, true);
							var rdata = { "mode" : 'CUD',
										'url':'getunit', 'reqtype' : 'readitem'};
							loadForm('modal_l2', rdata, true);
			});
				$("#<?php echo $modal_id;?> #unit").autocomplete({  
				minLength: "2",  
				source:   
				function(request, response){  
				console.log('test');
					$.ajax({  
						url: "<?php echo site_url('stomp/xids/pos_unit')?>",  
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
						alert("Silahkan pilih unit baru");
						$('#unit').val('');
					}
				},
				select: function( event, ui ) {					
					$('#accOffice').val(ui.item.rvalue.accOffice);
				}	
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
					nama: {
						required: true,
						minlength: 1
						//regex: /^[0-9]+$/
					},
					unit: {
						required: true,
						minlength: 3
						//regex: /^[0-9]+$/
					},
                },
                messages: {
					loginid: {
						required: "Please enter loginid",
						minlength: "Your loginid must be at least 5 number long"
					},
					nama: {
						required: "Please enter position",
					},
					unit: {
						required: "Please enter unit",
						minlength: "unit must be at least 3 character long",
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
	};
	
	function query_id()
		{		
			var url = "<?php echo site_url('stomp/xids/query_unit')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: {"npp": $('#loginid').val()},
				dataType: "JSON",
				success: function(data)
				{
					if (data != null){
					$('[name="nama"]').text(data.name);
					$('[name="nama"]').val(data.name);
					$('[name="cposid"]').val(data.positionid);
					$('[name="uname"]').text(data.uname);
					$('[name="uname"]').val(data.uname);
					}else {
						alert("User Not Found");
						$('#nama,#loginid, #cposid, #cposname').val(null);
						$('#nama').text("");
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
	
	
	
	
	
	function <?php echo $modal_id;?>_submit(btype){
		$('#tposname,#sdate,#edate,#loginid,#jam').removeAttr('disabled');
var fdata = {'url': 'wf/wfaction', 'modal_id' : "<?php echo $modal_id;?>", 'btype': btype };
		//;
		var isValid = $("#<?php echo $modal_id;?>_form").valid();
		console.log(isValid);
				var cpos = $('#accOffice').val();
			if (cpos.length < 1){
				alert("Please select unit");
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
.read{
	pointer-events:none;
}
</style>
<div class="container">
  <!-- Modal -->
  <div class="modal fade"  id="<?php echo $modal_id;?>_content" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
		<div id="wrap">
		<form action="#"  id="<?php echo $modal_id;?>_form"  role="form">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Ubah Unit</p>
			<p class="judul" align= "center" style="margin-left:25%; width:70%;color: red;" id="lockinfo" ></p>			
			<div id="wfinfo" class="infohide"style="margin-right: 8%;margin-left: 9%">
				<label for="doneActor">Done</label> <ul id="doneActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
				<label for="currActor">Curr</label> <ul id="currActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
			</div>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row"style="width:90%;margin-left:6%;">
				<p id="l-login">					
					<label class="judul" >LoginID</label>
					<input style="width: 23%" name="loginid" id="loginid" placeholder="Login ID" class="column-full form-control" type="text" onchange="query_id()" onclick="$('#loginid, #nama,#uname,#unit,#accOffice').val('').text('');">
					<label name="nama" class="labelisi" id="nama" ></label>
					<input name="nama" id="nama" readonly type="hidden">
					<label for="nama"  class="labelisi" name="uname" id="uname" ></label>
					<input name="uname" id="uname" readonly type="hidden">
				</p>
				<p>
					<label class="judul">Unit Baru</label> 
					<input name="unit" id="unit" placeholder="-- Unit Baru --" class="autocomplete form-control" type="text" onclick="$(this).val(''); $('#tposid').val('');">
					<input name="accOffice" id="accOffice" placeholder="accOffice" class="form-control" type="hidden">
				</p>
				<p>
				<label class="judul">Tanggal Efektif</label>
				<input name="sdate" id="sdate" placeholder="Tanggal Efektif" class="form-control" style="width: 28%; float:left" type="text" readonly>
				<input name="jam" placeholder="Tanggal Efektif" id="jam" class="form-control" style="width: 15%;" type="text" readonly disabled>
				</p>
					<input name="tposid" id="tposid" readonly type="hidden">
					<input name="status" id="status" class="form-control" type="hidden" >
					<input name="id" id="id" class="form-control" type="hidden" >
					<input name="mode" id="mode" class="form-control" type="hidden" value="CU" >
					<input name="wfid" id="wfid" class="form-control" type="hidden" readonly >	
					<input name="reqtype" id="reqtype" class="form-control" type="hidden" >
					<input name="notes" id="notes" class="form-control" type="hidden" >
					<br/>						
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
		</form>
	</div>
    </div>
  </div>
  
</div>