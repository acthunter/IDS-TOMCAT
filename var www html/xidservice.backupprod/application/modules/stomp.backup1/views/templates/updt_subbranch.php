<script type="text/javascript">
	
	$(document).ready(function() {
		$("input[name$='same']").click(function() {
			var test = $(this).val();

			$("div.desc").hide();
			$("#same" + test).show();
			});
		
		$("#tposid").change(function(){
			alert("test");
		});
/* 		$('#sdate').attr("style", "display: none;width:28%; float: left");
		$('#edate').attr("style", "display: none; width:29%;float:left "); */
/* 		$('#sdate').attr("style", "display: block;width:43%; float: left");
		$('#edate').attr("style", "display: block; width:42.8%; ");
		$('[name="hour_st"]').attr("style", "display: none; width: 55%; float:left; ");
		$('[name="hour_end"]').attr("style", "display: none;width: 35%; float:left; "); */
/* 		$('[name="jam"]').attr("style", "display: none; width: 15%; float:left; ");
		$('[name="jam2"]').attr("style", "display: none; width: 15%; float:left; "); */
		
	});
	
	
	
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
						
						$('#wfid').val(wdata['id']);
						$('#loginid').val(rdata['loginid']);
						$('#mode').val(wdata['mode']);
						$('[name="nama"]').text(rdata.nama);
						$('[name="nama"]').val(rdata.nama);
						$('[name="cposname"]').text(rdata.cposname);
						$('[name="cposname"]').val(rdata.cposname);
						$('#cposid').val(rdata['cposid']);
						
						$('#tposname').val(rdata['pname']);
						$('#tposid').val(rdata['tpos']);
						$('#subbranch').val(rdata['subbranch']);
						var s = rdata['sdate'];
						sdt = s.split(' ');
						var e = rdata['edate'];
						edt = e.split(' ');
						//alert(a)
						
						$('[name="sdate"]').val(sdt[0]);
						//$('[name="jam"]').val(sdt[1]);
						//alert(sdt[1]);
						$('[name="edate"]').val(edt[0]);
						//$('[name="jam2"]').val(edt[1]);
						var current_date = new Date();
						var a = -current_date.getTimezoneOffset() / 60;
						
						if (a == '8'){
							$val = sdt[1].split(":");
							
							$('#jam').val((parseInt($val[0])+1)+":"+$val[1]);
							
							if(edt[1] != "00:00"){
								//alert("test1");
								$val2 = edt[1].split(":");
								$('#jam2').val((parseInt($val2[0])+1)+":"+$val2[1]);
								
							}else{
								$('[name="jam2"]').val(edt[1]);
							}
						 }else if (a == '9'){
							$val = sdt[1].split(":");
							$('#jam').val((parseInt($val[0])+2)+":"+$val[1]);
							if(edt[1] != "00:00"){
								//alert("test2");
								$val2 = edt[1].split(":");
								$('#jam2').val((parseInt($val2[0])+2)+":"+$val2[1]);
								
							}else{
								$('[name="jam2"]').val(edt[1]);
							}
						 }else{
							 $('[name="jam2"]').val(edt[1]);
							 $('[name="jam"]').val(sdt[1]);
						 }
						
						
						
						if (wdata['stage'] != '1'){
							$('input[type=radio]').attr('disabled', true);
							var arr_ro = "tposname,sdate,edate,loginid".split(",");
							console.log(arr_ro);
							for(cid of arr_ro){
								$('#' + cid).attr('disabled', true);
							}
							
						}else{
							var arr_ro = "loginid".split(",");
							for(cid of arr_ro){
								$('#' + cid).attr('readonly', true).css('pointer-events', 'none');
							}
							//datetimepicker();
						}

						$('#<?php echo $modal_id;?>_form #id').val(data['id']);
						$('#<?php echo $modal_id;?>_form #wfid').val(data['wfid']);
						
						for (val of wdata["eaction"]){
							$("#<?php echo $modal_id;?>_btn_" + val).show();
						}
							
					}
			});
			$('#pos_def').css("display", "block");
		}
		else {
					/* var check = $('input[value="0"]');
		var check2 = $('input[value="1"]');		
		check.attr("checked", true);
		check2.attr("checked", false);
		var interval= '0'; */
			datetimepicker();
			$('#pos_def').css("display", "none");
			$('#<?php echo $modal_id;?>_form #btn_save').show();
			
		}
		
		$("#<?php echo $modal_id;?> #tposname").autocomplete({  
				minLength: "2",  
				source:   
				function(request, response){  
				console.log('test');
					$.ajax({  
						url: "<?php echo site_url('stomp/xids/pos_search2')?>",  
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
						alert("Silahkan pilih posisi baru");
						$('#tposname').val('');
					}
				},
				select: function( event, ui ) {					
					$('#tposid').val(ui.item.rvalue.positionid);
					$val = ui.item.rvalue.subbranch;
					if($val<10)  { $val='0'+$val }
					$('#subbranch').val($val);
				}	
			});
		$(function () {
			var now = new Date();
		now.setHours(0,0,0,0);
		var yest = new Date(new Date().setDate(now.getDate() - 1));
		yest.setMinutes(new Date().getMinutes()+1);
		var tom = new Date(new Date().setDate(now.getDate() + 1));
		tom.setHours(0,0,0,0);
		$('#sdate').datetimepicker({
            ignoreReadonly: true, defaultDate: now, minDate: now, disabledDates: [yest], widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('YYYY-MM-DD ');
        $('#edate').datetimepicker({
            ignoreReadonly: true, defaultDate: now, minDate: now, disabledDates: [yest], widgetPositioning: { vertical: 'bottom' }
        }).data('DateTimePicker').format('YYYY-MM-DD');
		$('#jam').datetimepicker({
            ignoreReadonly: true, minDate: new Date(), widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('HH:mm');
        $('#jam2').datetimepicker({
            ignoreReadonly: true, minDate: new Date(new Date().setMinutes(new Date().getMinutes()+1)), widgetPositioning: { vertical: 'bottom' }
        }).data('DateTimePicker').format('HH:mm');
			
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
					tposid: {
						required: true,
						minlength: 1,
						digits: true
					},
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
					tposid: {
						required: "Please enter position",
						minlength: "position must be at least 3 character long",
					},
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
			var url = "<?php echo site_url('stomp/xids/query')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: {"npp": $('#loginid').val()},
				dataType: "JSON",
				success: function(data)
				{
					if(data != null){
					$('[name="nama"]').text(data.name);
					$('[name="nama"]').val(data.name);
					$('[name="cposid"]').val(data.positionid);
					$('[name="cposname"]').text(data.nama);
					$('[name="cposname"]').val(data.nama);
					$('#pos_def').css("display", "block");
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
		}
	
	/* function updateInterval(interval) {
	
      if (interval === '0') {
		$('[name="hour_st"]').attr("style", "display: block; width: 55%; float:left; ");
		$('[name="hour_end"]').attr("style", "display: block;width: 35%; float:left; ");
		$('[name="tgl_st"]').attr("style", "display: none; width: 55%; float:left; ");
		$('[name="tgl_end"]').attr("style", "display: none; width: 35%; float:left; ");
		var now = new Date();
		now.setHours(now.getHours(),(now.getMinutes()),0,0);
		var na = new Date(now);
			na.setHours(22);
			na.setMinutes(00);
         $('#sdate').attr("style", "display: none;width:28%; float: left");
         $('#edate').attr("style", "display: none; width:29%;float:left ");
		 $('#jam').attr("style", "display: none;width:15%; float: left");
         $('#jam2').attr("style", "display: none; width:15%;");
         $('#sdate').attr("style", "display: block; width:43%; float: left");
         $('#edate').attr("style", "display: block; width:42.8%;");
		 
		$('#sdate').datetimepicker({
           ignoreReadonly: true, defaultDate: now , minDate: now, maxDate: na, widgetPositioning: { vertical: 'bottom' }
                }).data('DateTimePicker').format('HH:mm');
		$('#edate').datetimepicker({
			ignoreReadonly: true, defaultDate:new Date(new Date().setMinutes(now.getMinutes()+5)), minDate: new Date(new Date().setMinutes(now.getMinutes()+1)), maxDate: na, widgetPositioning: { vertical: 'bottom' }
                }).data('DateTimePicker').format('HH:mm');
        $("#sdate").on("dp.change", function (e) {
			 var d = new Date(e.date);
			 d.setMinutes(d.getMinutes()+1);
			 d.setHours(d.getHours());
			$('#edate').data("DateTimePicker").minDate(d);
        }); 
                        
		$("#edate").on("dp.change", function (e) {
			$('#sdate').data("DateTimePicker");
        });  
    } else  {
		$('[name="hour_st"]').attr("style", "display: none; width: 55%; float:left; ");
		$('[name="hour_end"]').attr("style", "display: none;width: 35%; float:left; ");
		$('[name="tgl_st"]').attr("style", "display: block; width: 55%; float:left; ");
		$('[name="tgl_end"]').attr("style", "display: block; width: 35%; float:left; ");
		var now = new Date();
		now.setHours(0,0,0,0);
		var yest = new Date(new Date().setDate(now.getDate() - 1));
		yest.setMinutes(new Date().getMinutes()+1);
		var tom = new Date(new Date().setDate(now.getDate() + 1));
		tom.setHours(0,0,0,0);
        $('#sdate').attr("style", "display: block;width:28%; float: left");
        $('#edate').attr("style", "display: block; width:29%;float:left ");
		$('#jam').attr("style", "display: block;width:15%; float: left");
        $('#jam2').attr("style", "display: block; width:15%; ");
        $('#sdate').attr("style", "display: none;width:43%; float: left");
        $('#edate').attr("style", "display: none; width:42.8%; ");
        $('#sdate').datetimepicker({
            ignoreReadonly: true, defaultDate: now, minDate: now, disabledDates: 		[yest], widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('YYYY-MM-DD ');
        $('#edate').datetimepicker({
            ignoreReadonly: true, defaultDate: tom, minDate: tom, disabledDates: [yest, now], widgetPositioning: { vertical: 'bottom' }
        }).data('DateTimePicker').format('YYYY-MM-DD');
		$('#jam').datetimepicker({
            ignoreReadonly: true, defaultDate: now, widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('HH:mm');
        $('#jam2').datetimepicker({
            ignoreReadonly: true, defaultDate: now,  widgetPositioning: { vertical: 'bottom' }
        }).data('DateTimePicker').format('HH:mm');

        $("#sdate").on("dp.change", function (e) {
            var d = new Date(e.date);
			d.setHours(0,0,0,0);
			var i = new Date(new Date().setDate(d.getDate() + 1));
			i.setHours(0,0,0,0);
			var u = new Date(new Date().setDate(d.getDate() - 1));
			$('#edate').data("DateTimePicker").minDate(i).disabledDates([d,yest]);
			//$('#edate').val("");
        });  
        $("#edate").on("dp.change", function (e) {
			var d = new Date(e.date);
			var i = new Date(new Date().setDate(d.getDate() + 1));
			var u = new Date(new Date().setDate(d.getDate() - 1));
			$('#sdate').data("DateTimePicker").disabledDates([yest,d]);
        });
		 		
    }
} */
	
	function datetimepicker(){
		var now = new Date();
		now.setHours(0,0,0,0);
		var yest = new Date(new Date().setDate(now.getDate() - 1));
		yest.setMinutes(new Date().getMinutes()+1);
		var tom = new Date(new Date().setDate(now.getDate() + 1));
		tom.setHours(0,0,0,0);
		$('#sdate').datetimepicker({
            ignoreReadonly: true, defaultDate: now, minDate: now, disabledDates: [yest], widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('YYYY-MM-DD ');
        $('#edate').datetimepicker({
            ignoreReadonly: true, defaultDate: now, minDate: now, disabledDates: [yest], widgetPositioning: { vertical: 'bottom' }
        }).data('DateTimePicker').format('YYYY-MM-DD');
		$('#jam').datetimepicker({
            ignoreReadonly: true, minDate:new Date().setHours(new Date().getHours(),new Date().getMinutes(),0,0),
                    maxDate:new Date().setHours(21,0,0,0), widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('HH:mm');
        $('#jam2').datetimepicker({
            ignoreReadonly: true, minDate:new Date().setHours(new Date().getHours(),(new Date().getMinutes()+1),0,0),
                    maxDate:new Date().setHours(22,0,0,0), widgetPositioning: { vertical: 'bottom' }
        }).data('DateTimePicker').format('HH:mm');
		$("#jam").on("dp.change", function (e) {

			var sdate = $("#sdate").val();
			var edate = $("#edate").val();
			var now = new Date();
			var dat = now.getDate();
			var m = now.getMonth() + 1 ;
			var ho = now.getHours ;
			var mi = now.getMinutes ;
			if(dat<10)  { dat='0'+dat } if(m<10)  { m='0'+m } if(ho<10){ ho='0'+ho } if(mi<10){ mi='0'+mi }
			var noww = now.getFullYear()+"-"+m+"-"+dat;
			//alert(noww);
			if (sdate.match(noww)){
				if (sdate.match(edate)){
					var d = new Date(e.date);
					d.setMinutes(d.getMinutes()+1);
					$a = $('#jam2').data("DateTimePicker").minDate(e.date).date(d);
					//alert(d);
				}else{
					$('#jam2').data("DateTimePicker");
				}
			}else{
				$('#jam2').data("DateTimePicker");
			}
		});
		$("#jam2").on("dp.change", function (e) {
			$('#jam').data("DateTimePicker");
		});
		 $("#sdate").on("dp.change", function (e) {
			 var d = new Date(e.date);	
			 $('#edate').data("DateTimePicker").minDate(d);
			var sdate = $("#sdate").val();
			var edate = $("#edate").val();
			var now = new Date();
			var dat = now.getDate();
			var m = now.getMonth() + 1 ;
			var ho = now.getHours ;
			var mi = now.getMinutes ;
			if(dat<10)  { dat='0'+dat } if(m<10)  { m='0'+m } if(ho<10){ ho='0'+ho } if(mi<10){ mi='0'+mi }
			var noww = now.getFullYear()+"-"+m+"-"+dat;
			if (sdate.match(noww)){
				if (sdate.match(edate)){
					//alert("a");
				var today = new Date();
				var y = new Date(d);
				y.setHours(today.getHours(), today.getMinutes(), 0, 0);
					$('#jam2').data("DateTimePicker").minDate(d).date(new Date(new Date().setHours(0,0,0,0))).maxDate(new Date(new Date().setHours(22,0,0,0)));
					$('#jam').data("DateTimePicker").minDate(y).date(new Date(new Date().setHours(0,0,0,0))).maxDate(new Date(new Date().setHours(21,0,0,0)));
					//$('#jam2').removeAttr('disabled');
					$('#jam,jam2').removeAttr('disabled');
				} else{
					//alert("b");
					var today = new Date();
					$('#jam').data("DateTimePicker").minDate(new Date).date(new Date).maxDate(new Date(new Date().setHours(21,59,0,0)));
					$('#jam2').data("DateTimePicker").minDate(d).date(new Date(new Date().setHours(0,0,0,0))).maxDate(new Date(new Date().setHours(22,0,0,0)));				
					$('#jam2').attr('disabled', true);
					$('#jam').removeAttr('disabled');
				}
			}else{
				if (sdate.match(edate)){
					//var today = new Date();
					var y = new Date();
					y.setHours(0,0,0,0);
					
					$('#jam2').data("DateTimePicker").minDate(y).date(new Date(new Date().setHours(0,0,0,0))).maxDate(new Date(new Date().setHours(22,0,0,0)));
					$('#jam').data("DateTimePicker").minDate(y).date(new Date(new Date().setHours(0,0,0,0))).maxDate(new Date(new Date().setHours(21,59,0,0)));				
					$('#jam2, #jam').attr('disabled', true);
				}else{
				/* if (sdate.match(edate)){
					alert("a");
				var today = new Date();
				var y = new Date(d);
				y.setHours(today.getHours(), today.getMinutes(), 0, 0);
					$('#jam2').data("DateTimePicker").minDate(d).date(new Date(new Date().setHours(0,0,0,0)));
					$('#jam').data("DateTimePicker").minDate(y).date(new Date(new Date().setHours(0,0,0,0)));
				} else{ */
					var today = new Date();
					var y = new Date();
					y.setHours(0,0,0,0);
					var x = new Date();
					x.setHours(0,0,0,0);
					$('#jam2,#jam').attr('disabled', true);
					$('#jam2').data("DateTimePicker").minDate(y).date(new Date(new Date().setHours(y.getHours(),(y.getMinutes()),0,0))).maxDate(new Date(new Date().setHours(22,0,0,0)));
					$('#jam').data("DateTimePicker").minDate(x).date(x).maxDate(new Date(new Date().setHours(21,59,0,0)));				
				//}
				}
			}
		 });
        $("#edate").on("dp.change", function (e) {
			$('#sdate').data("DateTimePicker");
			$('#edate').data("DateTimePicker").minDate($('#sdate').val());
			var sdate = $("#sdate").val();
			var edate = $("#edate").val();
			var now = new Date();
			var dat = now.getDate();
			var m = now.getMonth() + 1 ;
			var ho = now.getHours ;
			var mi = now.getMinutes ;
			if(dat<10)  { dat='0'+dat } if(m<10)  { m='0'+m } if(ho<10){ ho='0'+ho } if(mi<10){ mi='0'+mi }
			var noww = now.getFullYear()+"-"+m+"-"+dat;
			if (sdate.match(noww)){
				if (sdate.match(edate)){
					var today = new Date();
					var y = new Date();
					y.setHours(today.getHours(),today.getMinutes()+1,0,0);
					var x = new Date();
					x.setHours(today.getHours(),today.getMinutes(),0,0);
					$('#jam2').removeAttr('disabled');
					$('#jam2').data("DateTimePicker").minDate(y).date(new Date(new Date().setHours(y.getHours(),(y.getMinutes()),0,0)));
					$('#jam').data("DateTimePicker").minDate(x).date(new Date(new Date().setHours(6,0,0,0))).maxDate(new Date(new Date().setHours(21,59,0,0)));	
					
				}else{
					var today = new Date();
					var y = new Date();
					y.setHours(0,0,0,0);
					$('#jam2').data("DateTimePicker").minDate(y).date(new Date(new Date().setHours(y.getHours(),(y.getMinutes()),0,0)));
					$('#jam').data("DateTimePicker").minDate(new Date).date(new Date).maxDate(new Date(new Date().setHours(21,59,0,0)));
					$('#jam2').attr('disabled', true);
				}
			} else{
				if (sdate.match(edate)){
					//var today = new Date();
					var y = new Date();
					y.setHours(0,0,0,0);
					//$('#jam2,').removeAttr('disabled');
					$('#jam2').data("DateTimePicker").minDate(y).date(new Date(new Date().setHours(y.getHours(),(y.getMinutes()),0,0))).maxDate(new Date(new Date().setHours(22,0,0,0)));
					$('#jam').data("DateTimePicker").minDate(y).date(new Date(new Date().setHours(y.getHours(),0,0,0))).maxDate(new Date(new Date().setHours(21,59,0,0)));				

				}else{
					var today = new Date();
					var y = new Date();
					y.setHours(0,0,0,0);
					var x = new Date();
					x.setHours(0,0,0,0);
					$('#jam2').attr('disabled', true);
					$('#jam2').data("DateTimePicker").minDate(y).date(new Date(new Date().setHours(y.getHours(),(y.getMinutes()),0,0)));
					$('#jam').data("DateTimePicker").minDate(x).date(x).maxDate(new Date(new Date().setHours(21,59,0,0)));	
				}
			}
		});
		
	}
	
	function <?php echo $modal_id;?>_submit(btype){
		$('#tposname,#sdate,#edate,#loginid,#jam,#jam2').removeAttr('disabled');
		$('input[type=radio]').removeAttr('disabled', true);
		var fdata = {'url': 'wf/wfaction', 'modal_id' : "<?php echo $modal_id;?>", 'btype': btype };
		//;
		var current_date = new Date();
		var a = -current_date.getTimezoneOffset() / 60;
		if (a == '8'){
			$val = $('#jam').val().split(":");
			$('#jam').val(($val[0]-1)+":"+$val[1]);
			if($('#jam2').val() != "00:00"){
				$val2 = $('#jam2').val().split(":");
				$('#jam2').val(($val2[0]-1)+":"+$val2[1]);
			}
		 }else if (a == '9'){
			$val = $('#jam').val().split(":");
			$('#jam').val(($val[0]-2)+":"+$val[1]);
			if($('#jam2').val() != "00:00"){
				$val2 = $('#jam2').val().split(":");
				$('#jam2').val(($val2[0]-2)+":"+$val2[1]);
			}
		 }
				
		var isValid = $("#<?php echo $modal_id;?>_form").valid();
		console.log(isValid);
		
		var cpos = $('#tposid').val();
			if (cpos.length < 1){
				alert("please select position name");
				$('#tposname').val('');
				return ;
			}
/* 		var choose = $('#same').val();
		console.log(choose);
		var date1 = $('#sdate').val();
		console.log(date1);
		var date2 = $('#edate').val();
		if (choose = '0'){
			if (date1 <= date2){
				alert("input tanggal efektif dengan benar11111");
				return ;			
			}else{
				var sdate = Date.parse(date1);
				console.log(sdate);
				var edate = Date.parse(date2);
				console.log(edate);	
			}
			if (sdate > edate){
				alert("input tanggal efektif dengan benar2222");
				return ;
			}
		}else{
			var sdate = date1;
			var edate = date2;
			if (sdate >= edate){
				alert("input tanggal efektif dengan benaraaaa");
				return ;
			}
		} */
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

#<?php echo $modal_id;?>_form1 label.error {
    color: red;
	font-size: 11px;
	width: 100%;
}

.ui-autocomplete {
    max-height:400px;
    overflow-y: auto;
	overflow-x: hidden;
}
* html .ui-autocomplete {
    height: 50px;
}
#<?php echo $modal_id;?>_form label.error {
    color: red;
	font-size: 11px;
	width: 100%;
}
</style>
<div class="container">
  <!-- Modal -->
  <div class="modal fade"  id="<?php echo $modal_id;?>_content" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-body">
			 <div id="wrap">
		<form action="#"  id="<?php echo $modal_id;?>_form"  role="form">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Update Subbranch</p>
			<p class="judul" align= "center" style="margin-left:28%; width:70%;color: red;" id="lockinfo" ></p>
			<div id="wfinfo" class="infohide"style="margin-right: 8%;margin-left: 9%">
				<label for="doneActor">Done</label> <ul id="doneActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
				<label for="currActor">Curr</label> <ul id="currActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
			</div>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row" style="width:90%;margin-left:6%;">				
					<label style="color: rgb(64, 92, 96);font-family: Big Caslon, Book Antiqua, Palatino Linotype, Georgia, serif;" >LoginID</label>
					<label  style="float: right;margin-right: 60px;color: rgb(64, 92, 96);font-family: Big Caslon, Book Antiqua, Palatino Linotype, Georgia, serif;" id="pos_def" >Posisi Definitif</label>
				<p id="l-login">					
					<input style="width: 20%" name="loginid" id="loginid" placeholder="Login ID" class="column-full form-control" type="text" onchange="query_id()" onclick="$('#loginid, #nama,#cposname,#tposname, #tposid').val('').text('');$('#pos_def').css('display', 'none');">
					<label name="nama" class="labelisi" id="nama" ></label>
					<input name="nama" id="nama" readonly type="hidden">
					<label for="nama"  class="labelisi" name="cposname" id="cposname" ></label>
					<input name="cposname" id="cposname" readonly type="hidden">
				</p>
				<p>
				<label class="judul">Subbranch Baru</label> 
				<input id="tposname" name="tposname" list="tpos" placeholder="-- Posisi Baru --" class="autocomplete form-control" type="text" onclick="$(this).val(''); $('#tposid').val('');">
				</p>
				<!--<p>
				<label style="color: rgb(64, 92, 96);" >Perubahan</label> 
				<input style="margin-left: 10%;" type="radio"id="same" class="sama" onclick="updateInterval('0')" name="same" value="0"> Hari Yang Sama
				<input style="margin-left: 10%;" type="radio"id="same"  onclick="updateInterval('1')"  name="same" value="1"> Beda Hari
				</p>-->
				<p>
				<!--<label class="judul" name="hour_st" style="width: 55%; float:left;">Waktu  Mulai</label>
				<label class="judul" name="hour_end" style="width: 35%; float:left;">Waktu Berakhir</label>-->
				<label class="judul" name="tgl_st" style="width: 90%; float:left;">Tanggal Efektif</label>
				<!--<label class="judul" name="tgl_end" style="width: 30%; float:left;"></label>
				<!--<input name="sdate" id="sdate" placeholder="Tanggal Efektif" class="form-control" style="width: 42%; float:left" type="text" readonly>-->
				<input name="sdate" id="sdate" placeholder="Tanggal Efektif" class="form-control" style="width: 28%; float:left" type="text" readonly>
				<input name="jam" placeholder="Tanggal Efektif" id="jam" class="form-control" style="width: 15%; float : left;" type="text" readonly>
				<label style="margin-left: 4%; margin-right: 4%; float:left;color: rgb(64, 92, 96);">  s/d  </label>
				<!--<input name="edate" placeholder="Tanggal Efektif" id="edate" class="form-control" style="width: 43%;" type="text" readonly>-->
				<input name="edate" placeholder="Tanggal Efektif" id="edate" class="form-control" style="width: 28%;float:left" type="text" readonly>
				<input name="jam2" placeholder="Tanggal Efektif" id="jam2" class="form-control" style="width: 15%;float:left" type="text" readonly>

				</p>
				<ul style="font-size:12px;color: red;margin-bottom: 25px; margin-top: 10px;
				margin-left:-30px;">
					<li>Sebelum melakukan perubahan, harap memperhatikan posisi definitif saat ini</li>
					<li>Posisi yang tertera diatas adalah posisi kembali dari perubahan sementara.</li>
					<li>Jika posisi definitif belum sesuai harap melakukan review posisi atau perubahan permanen</li>
				</ul>
					<input name="tposid" id="tposid" readonly type="hidden">
					<input name="cposid" id="cposid" readonly type="text">
					<input name="subbranch" id="subbranch" readonly type="text">
					<input name="status" id="status" class="form-control" type="hidden" >
					<input name="id" id="id" class="form-control" type="hidden" >
					<input name="mode" id="mode" class="form-control" type="hidden" value="US" >
					<input name="wfid" id="wfid" class="form-control" type="hidden" >	
					<input name="reqtype" id="reqtype" class="form-control" type="hidden" >						
					<input name="notes" id="notes" class="form-control" type="hidden" >					
				<p  class="signin button" id="div_btn_<?php echo $modal_id;?>" style="margin-left: -10%">
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
  
</div>