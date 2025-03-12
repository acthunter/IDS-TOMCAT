<script type="text/javascript">
	var maxlvl;
	$(document).ready(function() {
		$("input[name$='same']").click(function() {
			var test = $(this).val();

			$("div.desc").hide();
			$("#same" + test).show();
			});

		
		$("#tposid").change(function(){
			alert("test");
		});
		var dattime1 = new Date();
		var offset = -(dattime1.getTimezoneOffset()/60);  
	});
	
	
	
	function  <?php echo $modal_id;?>_trigger(fdata){

			$("#ubahlvl").on("change",function(){
            var e = document.getElementById("ubahlvl");
			var strUser = e.options[e.selectedIndex].value;
			$("#newlvl").val(strUser);
        });
		$('select[id*="ubahlvl"] option[value="15"]').hide();
		$('select[id*="ubahlvl"] option[value="16"]').hide();
		$('#div_btn_<?php echo $modal_id;?> button').hide();	
		 var time = new Date();
		 var hour_time = time.getHours();
		 if (hour_time >= 22 || hour_time <= 5 ){
			  $('#isi').hide();
			  $('#alert').show();
		 }else{
			  $('#alert').hide();
			  $('#isi').show();
		 }
		 $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });
		if (fdata['reqtype'] != "new"){
			$.ajax({
					url : "<?php echo site_url('')?>" + fdata['url'],
					type: "POST",
					data: fdata,
					dataType: "JSON",
					success: function(wdata){
						var data = wdata['detail'];
						var rdata = data['data'];

						
						
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
						$('#cposid').val(rdata.tpos);
						$('#tposname').val(rdata['pname']);
						$('#tposid').val(rdata['tpos']);
						
						if (rdata.changelevel < 15){
							$('select[id*="ubahlvl"] option[value="15"]').remove();
							$('select[id*="ubahlvl"] option[value="16"]').remove();
						}else if (rdata.changelevel == 15){
							$('select[id*="ubahlvl"]').append('<option value="15">15: 2 trilyun (Pimp Wilayah)</option>');
							$('select[id*="ubahlvl"] option[value="16"]').remove();
							
						}else if ((rdata.changelevel > 15) && (wdata.accOffice == 709)){
							$('select[id*="ubahlvl"]').append('<option value="15">15: 2 trilyun (Pimp Wilayah)</option>');
							$('select[id*="ubahlvl"]').append('<option value="16">16: unlimited / Super');
							
						}
						
						$('#lvl').val(rdata.level);
						$('#newlvl').val(rdata.changelevel);
						$('#keterangan').val(rdata['note']);
						$('#lvl_kapabilitas  option[value="' + rdata.level + '"]').prop('selected', true);
						$('#ubahlvl  option[value="' + rdata.changelevel + '"]').prop('selected', true);
						
						var s = rdata['sdate'];
						sdt = s.split(' ');
						var e = rdata['edate'];
						edt = e.split(' ');
						datetimepicker();
						$('[name="sdate"]').val(sdt[0]);
						$('[name="edate"]').val(edt[0]);
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
						
						var d = new Date();
						var strDate = d.getFullYear() + "-" + ( '0' + (d.getMonth()+1) ).slice( -2 ) + "-" + (d.getDate()<10 ? '0'+d.getDate() : d.getDate());
						if(sdt[0] != strDate){
								$('#exp').show();
								if (wdata['stage'] != '1'){
									$('#<?php echo $modal_id;?>_btn_approve').attr('disabled', true).css('pointer-events', 'none');	
								}else{
									$('#<?php echo $modal_id;?>_btn_submit').attr('disabled', true).css('pointer-events', 'none');
								}
								//$('#<?php echo $modal_id;?>_btn_approve').attr('readonly', true).css('pointer-events', 'none');
						}else{
								 $('#exp').hide();
						}
						

						$('#<?php echo $modal_id;?>_form #id').val(data['id']);
						$('#<?php echo $modal_id;?>_form #wfid').val(data['wfid']);
						
						for (val of wdata["eaction"]){
							$("#<?php echo $modal_id;?>_btn_" + val).show();
						}
						if (wdata['stage'] != '1'){
							/* $('input[type=radio]').attr('disabled', true); */
							var arr_ro = "tposname,jam,jam2,loginid".split(",");
							$('#keterangan').hide();
							$('#ket').text(rdata['note']);
							
							for(cid of arr_ro){
								$('#' + cid).attr('disabled', true);
							}
							$('#ubahlvl').prop('disabled', true);
							var json = wdata['currActor'];
							//alert(Object.keys(json));
							if (json.hasOwnProperty(rdata['loginid'])){

								$('#<?php echo $modal_id;?>_btn_approve').text('Submit');
								$('#<?php echo $modal_id;?>_btn_reject').text('Cancel');
								$('#<?php echo $modal_id;?>_btn_release').css("display", "none");
								
							}else{
								$('#<?php echo $modal_id;?>_btn_approve').text('Approve');
								$('#<?php echo $modal_id;?>_btn_reject').text('Reject');
								$('#<?php echo $modal_id;?>_btn_release').css("display", "inline-block");
							}
							/* if(sdt[0] != strDate){
								$('#<?php echo $modal_id;?>_btn_approve').prop("disabled", true);
								//$('#<?php echo $modal_id;?>_btn_approve').attr('readonly', true).css('pointer-events', 'none');
							}else{
								 $('#<?php echo $modal_id;?>_btn_approve').prop("disabled", false);
							} */
						}else{
							var arr_ro = "loginid".split(",");
							for(cid of arr_ro){
								$('#' + cid).attr('readonly', true).css('pointer-events', 'none');
							}
							
						/* 	if(sdt[0] != strDate){
								$('#<?php echo $modal_id;?>_btn_submit').prop("disabled", true);
								//$('#<?php echo $modal_id;?>_btn_approve').attr('readonly', true).css('pointer-events', 'none');
							}else{
								 $('#<?php echo $modal_id;?>_btn_submit').prop("disabled", false);
							} */
						
							//datetimepicker();
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

					$.ajax({  
						url: "<?php echo site_url('stomp/xids/pos_search')?>",  
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
					ubahlvl: {
						 required: true
					},
					keterangan: {
						required: true
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
					tposid: {
						required: "Please enter position",
						minlength: "position must be at least 3 character long",
					},
					ubahlvl: {
						required: "Please select change level"
					},
					keterangan: {
						required: "Please enter keterangan"
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
			var val_npp = $('#loginid').val();
			if(val_npp < 80000){
				var url = "<?php echo site_url('stomp/xids/query_level')?>" ;
				load_query(url);
			}else if(val_npp > 80000 && val_npp < 90000){
				new PNotify({
					title: 'Notifikasi',
					text: 'Untuk user Bina BNI tidak dapat menggunakan menu ini',
					type: 'error',
					styling: 'bootstrap3'
				});
				$('#nama,#loginid, #cposid, #cposname').val(null);
			}else{
				new PNotify({
					title: 'Notifikasi',
					text: 'User tidak tersedia',
					type: 'error',
					styling: 'bootstrap3'
				});
				$('#nama,#loginid, #cposid, #cposname').val(null);
			}		
		}
		function load_query(url){
			$.ajax({
				url : url,
				type: "POST",
				data: {"npp": $('#loginid').val()},
				dataType: "JSON",
				success: function(data)
				{
					
					if(data.positionid != null){
						$('[name="nama"]').text(data.name);
						$('[name="nama"]').val(data.name);
						$('[name="cposid"]').val(data.positionid);
						$('[name="cposname"]').text(data.nama);
						$('#lvl_kapabilitas  option[value="' + data.level + '"]').prop('selected', true);
						$('[name="lvl"]').val(data.level);
						$('[name="cposname"]').val(data.nama);
						$('[name="maxlvl"]').val(data.maxlvl);
						$('[id="posdef"]').html("Posisi Definitif");
						$('#pos_def').css("display", "block");
						maxlvl = data.maxlvl;
						/* if (data.maxlvl < 15){
							$('select[id*="ubahlvl"] option[value="15"]').hide();
						}else{
							$('select[id*="ubahlvl"] option[value="15"]').show();
						} */
						if (data.maxlvl < 15){
							$('select[id*="ubahlvl"] option[value="15"]').remove();
							$('select[id*="ubahlvl"] option[value="16"]').remove();
						}else if (data.maxlvl == 15){
							$('select[id*="ubahlvl"]').append('<option value="15">15: 2 trilyun (Pimp Wilayah)</option>');
							
						}else if ((data.maxlvl > 15) && (data.accOffice = 709)){
							$('select[id*="ubahlvl"]').append('<option value="15">15: 2 trilyun (Pimp Wilayah)</option>');
							$('select[id*="ubahlvl"]').append('<option value="16">16: unlimited / Super');
							
						}
						$('#btn_save').attr('disabled',false);
					} else{
						alert('User not found');
						$('#nama,#loginid, #cposid, #cposname').val(null);
						$('#nama,#cposname').text("");
						$('#btn_save').attr('disabled',true); 
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$('#btn_save').attr('disabled',true); 
					alert('User not found');
					
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
		var d = new Date();
		var n = d.getHours();
		$('#sdate').datetimepicker({
            ignoreReadonly: true, defaultDate: now, minDate: now, disabledDates: [yest], widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('YYYY-MM-DD ');
        $('#edate').datetimepicker({
            ignoreReadonly: true, defaultDate: now, minDate: now, disabledDates: [yest], widgetPositioning: { vertical: 'bottom' }
        }).data('DateTimePicker').format('YYYY-MM-DD');
		$('#jam').datetimepicker({
            ignoreReadonly: true, minDate:new Date().setHours(new Date().getHours(),new Date().getMinutes(),0,0),
                    maxDate:new Date().setHours(21,59,0,0), widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('HH:mm');
        // $('#jam2').datetimepicker({
            // ignoreReadonly: true, minDate:new Date().setHours(new Date().getHours(),(new Date().getMinutes()+1),0,0),
                    // maxDate:new Date().setHours(22,0,0,0), widgetPositioning: { vertical: 'bottom' }
        // }).data('DateTimePicker').format('HH:mm');
		if(n == 21){
			//alert("OKE");
			$('#jam2').datetimepicker({
				ignoreReadonly: true, minDate:new Date().setHours(22,0,0,0),
                    maxDate:new Date().setHours(22,00,0,0), widgetPositioning: { vertical: 'bottom' }
			}).data('DateTimePicker').format('HH:mm');
		}if(n >= 16){
			$('#jam2').datetimepicker({
				ignoreReadonly: true, minDate:new Date().setHours((new Date().getHours()+1),new Date().getMinutes(),0,0),
                    maxDate:new Date().setHours(22,00,0,0), widgetPositioning: { vertical: 'bottom' }
			}).data('DateTimePicker').format('HH:mm');
		}else{
			$('#jam2').datetimepicker({
				useCurrent: false, defaultDate: new Date().setHours(17,0,0,0),ignoreReadonly: true, minDate:new Date().setHours((new Date().getHours()+1),new Date().getMinutes(),0,0),
                    maxDate:new Date().setHours(22,00,0,0), widgetPositioning: { vertical: 'bottom' }
			}).data('DateTimePicker').format('HH:mm');
        }
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
			if (sdate.match(noww)){
			if (sdate.match(edate)){
				var d = new Date(e.date);
			 d.setHours(d.getHours()+1);
			 var y = new Date(e.date);
			 //alert(y.getHours());
			 if (y.getHours() == 21){
				$('#jam2').data("DateTimePicker").minDate(new Date(new Date().setHours(22,0,0,0))).date(new Date(new Date().setHours(22,0,0,0)));
			 }else{
				$('#jam2').data("DateTimePicker").minDate(d).date(d);
			 }
			//$('#jam2').data("DateTimePicker").minDate(e.date).date(d);
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

		
	}
	
	function <?php echo $modal_id;?>_submit(btype){
		$('#tposname,#sdate,#edate,#loginid,#jam,#jam2, #ubahlvl').removeAttr('disabled');
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
		
/* 		var cpos = $('#tposid').val();
			if (cpos.length < 1){
				alert("please select position name");
				$('#tposname').val('');
				return ;
			} */
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
		/* 
		if (isValid)
			action_submit(fdata); */
		if (isValid){
			if ( $("#ubahlvl option:selected").val() !== "" && $('#cposname').val() !== null &&  $('#cposname').val() !== ''){				  
				action_submit(fdata);
			}else{
				var text = 'Request yang dilakukan gagal. Data yang diinputkan tidak lengkap. Silahkan direquest kembali';
				var type = 'error';
				new PNotify({
					title: 'Notifikasi',
					text: text,
					type: type,
					styling: 'bootstrap3'
				});
				action_fail(fdata); 
			}
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
			<p class="formHeader" style="font-size: 30px;">Level Kapabilitas</p>
			<p class="judul" align= "center" style="margin-left:28%; width:70%;color: red;" id="lockinfo" ></p>
			<div id="alert">
				<div class="alert alert-danger" align="center">
					 Tidak dapat melakukan request. <br>
					 Request bisa dilakukan pukul (06.00 - 22.00).
				  </div>
			</div>
			<div class="alert alert-danger" align="center" id="exp" hidden>
			  Request has expired
			</div>
			<div id="isi">
			<div id="wfinfo" class="infohide"style="margin-right: 8%;margin-left: 9%">
				<label for="doneActor">Done</label> <ul id="doneActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
				<label for="currActor">Curr</label> <ul id="currActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
			</div>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
		<div class="form-group row">
		<div class="form-group">
			<div class='col-md-3'>
				<label class="judul">Loginid</label>
				<input  class="form-control" name="loginid" id="loginid" type="text" onchange="query_id()" onclick="$('#lvl_kapabilitas').prop('selectedIndex', -1);$('#loginid, #nama,#cposname,#tposname, #tposid, #posdef').val('').text('');$('#pos_def').css('display', 'none');">
			</div>
			<div class='col-md-4'>
				<label name="nama" class="labelisi" style="margin-top: 23%;width: unset;font-size:15px;" id="nama" ></label>
				<input name="nama" id="nama" readonly type="hidden">
				
			</div>
			<div class='col-md-5'>
				<label class="judul" id="posdef" style="text-align: center;"></label>
				<label for="nama"  class="labelisi" style="width: unset;font-size:15px;" name="cposname" id="cposname" ></label>
					<input name="cposname" id="cposname" readonly type="hidden">
					<input name="cposid" id="cposid" readonly type="hidden">
			</div>
		</div>
		<div class="form-group">
				<div class='col-md-12' style="margin-top:10px">
					<label class="judul">Level Kapabilitas</label> 
					<select class="form-control"id="lvl_kapabilitas" disabled>
						<option selected class="form-control"></option>
						<option value="02">2: Inquiry</option>
						<option value="04">4: 25 juta (asisten)</option>
						<option value="05">5: 100 juta (penyelia)</option>
						<option value="06">6: 500 juta (KLN)</option>
						<option value="08">8: 1 milyar (KLN)</option>
						<option value="09">9: 5 milyar (PBN/PBO)</option>
						<option value="10">10: 10 milyar (BM)</option>
						<option value="11">11: 25 milyar (BM)</option>
						<option value="12">12: 50 milyar (BM)</option>
						<option value="13">13: 100 milyar (BM)</option>
						<option value="14">14: 500 milyar (BM)</option>
						<option value="15">15: 2 trilyun (Pimp Wilayah)</option>
					</select>
					<input name="lvl" id="lvl" readonly type="hidden">
				</div>
			</div>
		<div class="form-group">
				<div class='col-md-12'>
					<label class="judul">Perubahan Level Kapabilitas</label> 
					<select class="form-control"id="ubahlvl" name="ubahlvl">
						<option selected class="form-control"></option>
						<option value="02">2: Inquiry</option>
						<option value="04">4: 25 juta (asisten)</option>
						<option value="05">5: 100 juta (penyelia)</option>
						<option value="06">6: 500 juta (KLN)</option>
						<option value="08">8: 1 milyar (KLN)</option>
						<option value="09">9: 5 milyar (PBN/PBO)</option>
						<option value="10">10: 10 milyar (BM)</option>
						<option value="11">11: 25 milyar (BM)</option>
						<option value="12">12: 50 milyar (BM)</option>
						<option value="13">13: 100 milyar (BM)</option>
						<option value="14">14: 500 milyar (BM)</option>
					</select>
					<input name="newlvl" id="newlvl" readonly type="hidden">
				</div>
			</div>
			  <div class="form-group">		
					<div class='col-md-6'>
						<label class="judul">Waktu Mulai</label>
						<div class="form-group">
							<div class='input-group date' id='datetimepicker6'>
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>							
								<input name="sdate" id="sdate" placeholder="Tanggal Efektif" class="form-control"  type="hidden" readonly>
								<input name="jam" placeholder="Tanggal Efektif" id="jam" class="form-control"  type="text" readonly>
							</div>
						</div>
					</div>
					<div class='col-md-6'>
						<label class="judul">Waktu Akhir</label>
						<div class="form-group">
							<div class='input-group date' >
								
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>
								<input name="edate" placeholder="Tanggal Efektif" id="edate" class="form-control" type="hidden" readonly>
								<input name="jam2" placeholder="Tanggal Efektif" id="jam2" class="form-control" type="text" readonly>

							</div>
						</div>
					</div>
			  </div>
			  <div class="form-group">
				<div class='col-md-12'>
					<label class="judul">Keterangan</label> 
					<input id="keterangan" name="keterangan" list="tpos" class="form-control" placeholder="-- Keterangan --" type="text">
					<label id="ket" name="ket"></label>
				</div>
			</div>
			<div class="form-group">
				<div class='col-md-12'>
				<ul style="font-size:12px;color: red;margin-bottom: 25px; margin-top: 10px;margin-left:-30px;">
					<label style="margin-left: -5px;margin-top: 10px;">Catatan : </label> 
					<li>Perubahan berlaku sesuai dengan settingan waktu efektif </li>
					<li>Pastikan user telah sign off sebelum dilakukan perubahan </li>
					<li>Perubahan akan efektif setelah user melakukan sign on kembali </li>
				</ul>
				</div>
			</div>
				<input name="mode" id="mode" class="form-control" type="hidden" value="CL" >
			  	<input name="wfid" id="wfid" class="form-control" type="hidden" >	
				<input name="reqtype" id="reqtype" class="form-control" type="hidden" >						
				<input name="notes" id="notes" class="form-control" type="hidden" >	

			<div class="form-group">
				<div class='col-md-12'>	
				<p  class="signin button" id="div_btn_<?php echo $modal_id;?>" style="margin-left: -10%">
						<button type="button" id="btn_save" onclick="<?php echo $modal_id;?>_submit('save')" class="btn btn-primary">Save</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_submit" onclick="<?php echo $modal_id;?>_submit('submit')" class="btn btn-primary">Submit</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_cancel" onclick="<?php echo $modal_id;?>_submit('cancel')" class="btn btn-danger">Cancel</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_approve" onclick="<?php echo $modal_id;?>_submit('approve')" class="btn btn-primary">Approve</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_reject" onclick="<?php echo $modal_id;?>_submit('reject')" class="btn btn-danger">Reject</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_release" onclick="<?php echo $modal_id;?>_submit('release')" class="btn btn-default ">Release</button>
				</p>
			</div>
			</div>
			</div>
		</form>
	</div>
        </div>
    </div>
  </div>

</div>