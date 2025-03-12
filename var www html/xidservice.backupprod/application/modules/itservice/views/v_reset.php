<!--<script src="/tstomp/bucky.js" data-bucky-host="/bucky" data-bucky-page="idssite-itservice"/>-->
<script type="text/javascript">
var counter = 1;
var yy;
var t;
var count;
$(document).ready(function(){
	var ss = new Date();
	var ddd = ss.getDate();
						var mmm = ss.getMonth()+1;
						var hhh = ss.getHours();
						var minuu = ss.getMinutes();
						if(ddd<10)  { ddd='0'+ddd } 
						if(mmm<10)  { mmm='0'+mmm } 
						if(hhh<10){ hh='0'+hhh } 
						if(minuu<10){ minuu='0'+minuu } 
						yy = ss.getFullYear()+'-'+mmm+'-'+ddd;
	$("#btnsearch").click(
        function () {
            search();
        }            
    );
	$(window).bind("beforeunload", function(e) {
		return false;
	});
	$('#myModal').on('show.bs.modal', function (e) {
		$('#pnama').show();
		$('#addlevel, #addRow, #clear').hide();
		$('#npp, #nama').val(''); 
		$('#btnsearch').show();
		 $('body').css("overflow-y", "hidden"); 
		 $('.modal').css("overflow-y", "auto");
	});
	$('#myModal').on('hide.bs.modal', function (e) {
		 $('body').css("overflow-y", "auto"); 
		 $('.modal').css("overflow-y", "hidden");
	});
	$('#clear-radio, #clear-radio2').on('click', function() {
		$('input[type=radio]').prop('checked', function () {
			return this.getAttribute('checked') == 'checked';
		});
	})
	
	
		$('#addlevel, #addRow, #clear').hide();
		
		$("input:radio").click(function(){
			modal();
		});
		
		 t = $('#example').DataTable({"searching": false,"bLengthChange": false,"bInfo" : false,  "paging": true,"pageLength": 30,
		   drawCallback: function(settings) {
				var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
				pagination.toggle(this.api().page.info().pages > 1);
			  },
			  "columns": [
				null,
				null,
				null,
				null,
				null,
				null
			  ]
  });
		$('#addlevel').on('click', function(){
			addapps();
		});
				$('#req').on( 'shown.bs.select', function () {
			$('#hidden_d').val($('#req').val());
			var length = $('#req option').length;
			for (i = 1; i <= length; i++) {
				$("option[name*='reqt']").remove();
			}
			var url = "<?php echo base_url('itservice/Xmain/query_req')?>";
			//var divisi = [];
			var str = $('#nosr').val();
			if (str.length >= 3){
			$.ajax({
				url : url,
				type: "POST",
				data: {"accOffice": str.substring(0, 3)},
				dataType: "JSON",					
				success: function(data)
				{
					
					//$("#req").selectpicker('render').selectpicker('refresh');
					$.each(data, function(index, value) {
						$("#"+value['loginid']).remove();
						$("#req").append("<option id="+value['accoffice']+" name='reqt' value="+value['loginid']+">"+ value['position'] +" (" +value['loginid']+" - "+ value['name'] + ")</option>").selectpicker('refresh');
					});
					//unit();
				}	  
			});
			}else{
				alert("silahkan mengisi no surat terlebih dahulu")
			}
			
		}); 
		$("#unit").autocomplete({  
				minLength: "2",  
				source:   
				function(request, response){  
				console.log('test');
					$.ajax({  
						url: "<?php echo site_url('itservice/Xmain/pos_unit2')?>",  
						dataType: 'json',  
						type: 'POST',  
						data: {
							pattern: request.term
						}, 
						success:      
						function(data){  
							response($.map(data, function (item) {
								return {
									value: item.accOffice+"-"+item.pname,
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
					$('#accoffice').val(ui.item.rvalue.accOffice);
				}	
			});
		$(document).on('click','.remove', function() {
			//alert("test");
			var rowCount = $('#myTable tbody tr').length;
			 t.row( $(this).parents('tr') ).remove().draw();
			 if(rowCount == 0){
				counter = 1;
			 }
			return false;
		});
		$("#btn_clear").on('click', function() {
			counter = 1;
			t.clear().draw();
			return false;
		});
		$('#clear').click(function() {
			$('input[class=check]').prop('checked', false);
		});
		$("#btn_add").on('click', function() {
			 $('#myModal').modal('show');
			 unit();
		});
		$('#addRow').on( 'click', function () {
			$('.selected input[name^="slog"]').each(function () {
				$(this).rules('add', {
					required: true,
					messages: {
						required: "Silahkan input user aplikasi"
					}
				});
			});
			var isValid = $("#form").valid();
			var $chkbox_checked = $('input[id="a"]:checked');
			if (isValid){
				$('.selected input[name^="slog"]').each(function () {
						 $(this).rules('remove', 'required');
					});
				if($chkbox_checked.length === 0){
					alert("No Row Selected");
				}
				else {
					
					//alert([this.name]);
					var checkboxx = $chkbox_checked.map(function(){
						if(this.value == 'rst'){
							return [this.name];
						}
					}).get();;
					var url = "<?php echo site_url('itservice/xmain/filter_data')?>" ;
					var url2 = "<?php echo site_url('itservice/xmain/popup')?>" ;
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
											add_val();
											$('#myModal').modal('hide');
											
										}else{
											$('#modal_target').html(data2);
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
												var tgl_nosr = dd + '-' + mm + '-' + yyyy;
												$("#list_apps2").append("<tr class='checklisttr "+ item['apps'] +"'><td>"+ item['apps'] +"</td><td>"+ tgl_nosr +"</td></tr>");
											});	
												
												$('#modal_target_content').modal({show:true}); 
												$("#btn_cancelmodal").click(function(){
													$('#myModal').modal('hide');
												});
												$("#btn_process").click(function(){
													add_val(); 
													$('#myModal').modal('hide');
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
			}else{
				return false;
			}
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
						},
						/* email: {
							required: true,
							minlength: 3
							//regex: /^[0-9]+$/
						}, */
						accoffice: {
							required: true,
							minlength: 1
						},
					},
					messages: {
						npp: {
							required: "Please enter npp",
							minlength: "Your loginid must be at least 5 number long"
						},
						/* email: {
							required: "Please enter username email"
						}, */
						accoffice: {
							required: "Please enter unit",
							minlength: "accoffice must be at least 1 character long",
						},
					},
					errorPlacement: function(error, element) {
					  var placement = $(element).data('error');
					  if (placement) {
						$(placement).append(error)
					  } else {
						error.insertAfter(element);
					  }
					},
					
					unhighlight: function (element) {
						$(element).closest('#myModal').removeClass('error');
					}
				});
			});
			$('#myModal').on('hidden.bs.modal', function() {
				
				$("label[class=error]").remove();
			});
		   $('#btn_submit').click( function() {
			  var TableData;
			  TableData = storeTblValues()
				TableData = JSON.stringify(TableData);
				//rst_submit(TableData);
				//alert(JSON.stringify(TableData));
				submit(TableData,t);
				t.clear().draw();	
		   }); 
		$('#example').removeClass('dataTable');
		document.getElementById('ok').style.display = 'none';
		$('#doc_date').datetimepicker({
            ignoreReadonly: true, widgetPositioning: { vertical: 'bottom' }, defaultDate: yy, maxDate: $.now()
        }).data('DateTimePicker').format('YYYY-MM-DD');
		$('#savechecklist').click(function() {
			var the_value;
			the_value = getChecklistItems();
			console.log(the_value);
		});
	});
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
					var nameval = [];
					$('input').each(function(){
						nameval.push($(this).attr('name'));
					   //alert($(this).attr('name'));
					});
					$.each(data.opts, function (index, item) {
						//alert(item['apps']);
						if ( nameval.indexOf( item['apps'] ) == -1 ) { 
						   $("#list_apps").append("<tr class='checklisttr'><td>"+ item['apps'] +"</td><td><input type='text' id='slog_"+count+"' name='slog_"+count+"'></td><td><input class='check' type='radio' id ='a' value='rst' name="+item['apps'] +" ></td><td><input class='check' type='radio' id ='a' value='new' name="+item['apps'] +" ></td></tr>");
						}
						count++;
						  });
					$("#ok_tabel input[type='radio']").on("click", function () {
						if ($(this).is(':checked')) {
							$(this).closest('tr').addClass('selected');    
						}
					});
						 $("#ok_tabel2, button, ok").show();
						 $("#addlevel, #btnsearch").hide();
					$('#addRow, #clear').show();
					
				},
				
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
	}
	function search(){
		//alert($('#npp,#accoffice,#type').val());
		if(($('#accoffice').val() != "") && ($('#npp').val() != "") && ($('#nama').val() != "")){
			
		var fdata = {'loginid' :$('#npp').val(),'accoffice':$('#accoffice').val()};
		//var fdata = {'loginid' :$('#npp').val()};
		//alert(JSON.stringify(fdata));
		var url = "<?php echo site_url('itservice/Xmain/lookup_user')?>" ; 
 			$.ajax({
				url : url,
				type: "POST",
				beforeSend: function(){
					$('#wait').modal('show');
					//$('#wait').show();
				},
				data: fdata,
				dataType: "JSON",
				success: function(data)
				{
					//alert(JSON.stringify(data));
					//alert(data);
					var wdata = data['opts'];
					//alert(wdata.length);
					if (wdata.length > 0){
						 count = 1;
					$.each(data.opts, function (index, item) {
						//alert(item['apps']);
						
						$("#list_apps").append("<tr class='checklisttr "+ item['utype'] +"'><td>"+ item['apps'] +"</td><td><input type='text' id='slog_"+ count +"' name='slog_"+count+"' value='"+ item['sloginid'] +"' readonly></td><td><input type='radio' class='check' id ='a' value='rst' name="+ item['apps'] +" ></td><td></td></tr>");
						count++;
						});
						 $("#ok_tabel, button, ok").show(); 
						 $("#btnsearch").hide();
					}else{
						if(wdata.resp == "null"){
							
							count = 1;
							addapps(); 
							$("#ok_tabel").show();
						}else{
							alert("Data Not Found");
						}
						
/* 						addapps();
						$("#ok_tabel, button, ok").show();  */
						//$('#npp,#accoffice').val('').text('');$('#ok_tabel tbody tr').empty();$('#ok_tabel').hide();
					}	

					$("#ok_tabel input[type='radio']").on("click", function () {
						if ($(this).is(':checked')) {
							$(this).closest('tr').addClass('selected');    
						}
					});
				},
				complete: function(){
					// $("#wait").hide();
					$('#wait').modal('hide');
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			}); 
		}else{
			new PNotify({
				title: 'Notifikasi!',
				text: 'User Not Found.',
				type: 'error',
				styling: 'bootstrap3'
			});
		}
	};
	function add_val(){
			var isValid = $("#form").valid();
			var $chkbox_checked = $('input[id="a"]:checked');
			if (isValid){
				if($chkbox_checked.length === 0){
					alert("No Row Selected");
					
				}
				else {
					var checkboxNameArry = $chkbox_checked.map(function(){
						return [this.name];
					}).get();;
					var checkboxValArry = $chkbox_checked.map(function(){
						return [this.value];
					}).get();;
					 var userArry = $('#ok_tabel tr.selected').map(function() {
						return $(this).find('td:eq(1) input').val();
					}).get();
					//$val_email = $('#email').val();
					t.row.add( [
						counter,
						$('#npp').val(),
						//$val_email+"@bni.co.id",
						userArry,
						checkboxNameArry,
						checkboxValArry,
						"<button id ='del' class='remove' style='background: transparent;border: none !important;color:white; box-shadow: none !important; padding: none !important;, font-size:none !important;' ><i class='fa fa-close' style='font-size:20px;color:red'></i></button>"
					] ).draw( false );		 
					counter++;
					$( "#ok_tabel tr.selected" ).removeClass( "selected" );
				}
			}else{
				return false;
			}
	}
	function addMail(fdt){
		var url = "<?php echo site_url('itservice/xmain/mail')?>" ;
		$.ajax({
			url : url,
			type: "POST",
			data: fdt,
			dataType: "JSON",
			success: function(data)
			{
				if(data != null){
					$('[name="email"]').text(data.email);
					$('[name="email"]').val(data.email);
					
				} else{
					alert('Email tidak ditemukan. Silahkan input email user tersebut.');
					//$('#nama,#loginid, #cposid, #cposname').val(null);
					$('#email').text("");
				}		
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('User not found');
			}
		});
	}
	
	function storeTblValues()
	{
		var TableData = new Array();

		$('#example tr').each(function(row, tr){
			TableData[row]={
				"npp" : $(tr).find('td:eq(1)').text()
				, "user" :$(tr).find('td:eq(2)').text()
				, "apps" :$(tr).find('td:eq(3)').text()
				, "req" : $(tr).find('td:eq(4)').text()
			}
				
		}); 
		TableData.shift();
		return TableData;
	}
		
		function submit(data,t){
			
			if($('input[name="same"]:checked').val() == 'sr') {
				var doc_date = $('#doc_date').val();
			}else{
				var d = new Date(),
					mm = d.getMonth() + 1; 
					dd= d.getDate();
					if(mm<10)  { mm='0'+mm } if(dd<10)  { dd='0'+dd }
					year = d.getFullYear();
					var h = d.getHours();
					var m = d.getMinutes();
				var doc_date = year+'-'+mm+'-'+dd;
			}

			var myDb = JSON.parse(data);
			//var myDb = [{"npp":"25311","apps":"webmail,icons,skcdm_icons","req":"rst,rst"}];
			//myObject = JSON.parse(myJSONString);
			//[{"npp":"22102","apps":"skcdm_icons,ska_icons","req":"rst,rst"}];
			//alert(JSON.stringify(Jsondata));
			var arr = [];

			$.each( myDb, function( key, value ) {
				var jsonStrig="";
				  var items = value['apps'].split(',');
				  for (var i = 0; i < items.length; i++) {
					 var cid =  items[i];
					 if(cid == "webmail"){
						cid = "ldapAccount_oid";
						
					} else if(cid == "icons"){
						cid = "banc";
						
					}
					  jsonStrig +=  cid+',';
				  }
				  jsonStrig = jsonStrig.substr(0, jsonStrig.length - 1);
				 
				  var obj = jsonStrig;
				  this.apps = obj;
			});
			
			var arr = t.data().toArray();

			let res = myDb;
			let newArr = res.reduce((acc, curr) => {
			  if(acc.some(obj => obj.npp === curr.npp)) {
				acc.forEach(obj => {
				  if(obj.npp === curr.npp) {
					obj.apps = obj.apps + "," + curr.apps;
					obj.req = obj.req + "," + curr.req;
				  }
				});
			  } else {
				acc.push(curr);
			  }
			  return acc;
			}, []);

			
			var url = "<?php echo site_url('itservice/xmain/wfaction')?>";
			var fdata = {'tipe_btn':'submit','reqtype' :$('input[name="same"]:checked').val(),'app': JSON.stringify(newArr), 'doc_date': doc_date,'nosr': $('#nosr').val(),'req': $( "#req option:selected" ).val(), 'mode': $('#mode').val(), 'reqid': $('#id').val(), 'notes': $('#notes').val(), 'accoffice': $('#accoffice').val(), 'inc' : $('#inc').val()};
			//alert(JSON.stringify(fdata));

			if(arr != ""){
				if (($('input[name="same"]:checked').val() == 'cm')) {
					proses(url,fdata);
				}else{
					 if($('#req :selected').text() == ''){
						alert("silahkan isi requestor terlebih dahulu");
					   new PNotify({
							title: 'Notifikasi',
							text: 'Silahkan isi requestor terlebih dahulu',
							type: 'warning',
							styling: 'bootstrap3'
						});
					}else{
						proses(url,fdata);
					}
					/* if (length < 2){
						alert("oko");
						proses(url,fdata);
					}else{
						alert("nooo");
						new PNotify({
							title: 'Notifikasi',
							text: 'Silahkan isi requestor terlebih dahulu',
							type: 'warning',
							styling: 'bootstrap3'
						});
					} */
				}
			}
			else {
				alert('Silahkan tambahkan data terlebih dahulu');
			}
		};
	function proses(url,fdata){
			$.ajax({
					url : url,
					type: "POST",
					data: fdata,
					dataType: "JSON",
					success: function(data)
					{
						new PNotify({
							title: 'Notifikasi',
							text: 'Data processed',
							type: 'success',
							styling: 'bootstrap3'
						});
						$('#req').val('default');$('#req').selectpicker('refresh');
						$('#npp,#req,#nosr,#inc,#mode,#reqid,#notes,#accoffice, #name, #email').val('');$('#list_apps').empty();$('#ok_tabel').hide();
						$('#doc_date').val(yy);
					},						
					error: function (jqXHR, textStatus, errorThrown)
					{
						alert('system error');
						$('#btnSave').attr('disabled',false); 
					}
				});
	}
	function query()
	{
			var url = "<?php echo site_url('itservice/xmain/valid_priv')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: {"npp": $('#npp').val()},
				dataType: "JSON",
				success: function(data)
				{
					if (data.opts != '') {
					$('#addlevel, #addRow, #clear').hide();						
					$.each(data.opts, function (index, item) {
						$("#list_apps").append("<tr class='checklisttr "+ item['kelas'] +"'><td>"+ item['desc'] +"</td><td><input type='radio' id ='a' value='rst' name="+item['target'] +" ></td><td><input type='radio' value='new' name="+item['target'] +" id='a'></td></tr>");
						  });
						document.getElementById('ok').style.display = 'block';
					$("#ok_tabel, button, ok").show();
					}else{
						//$('#email').prop('disabled', false);
						$('#addlevel').show();
						new PNotify({
							title: 'Notifikasi',
							text: 'User Not Found',
							type: 'error',
							styling: 'bootstrap3'
						});
						//$('#npp').val(""); 
						
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
	}
	
	function modal(){
			$('#ok_tabel').hide();
			//$('#email').prop('disabled', false);
			if (($('input[name="same"]:checked').val() == 'cm')) {
				//document.getElementById('ok_tabel');
				$('#npp').val();
				$('#nosr').val('');
				$('#ok').hide();
				$('#doc_date').val(yy);
				//document.getElementById('ok3').style.display = 'block';
				document.getElementById('ok2').style.display = 'none';
				document.getElementById('ok4').style.display = 'none';
				document.getElementById('ok5').style.display = 'none';
				document.getElementById('ok7').style.display = 'none';
				document.getElementById('ok3').style.display = 'none';					
			}else if($('input[name="same"]:checked').val() == 'sr') {
				$('#npp').val();
				$('#ok').hide();
				document.getElementById('ok2').style.display = 'block';
				document.getElementById('ok4').style.display = 'block';
				document.getElementById('ok5').style.display = 'block';
				document.getElementById('ok7').style.display = 'block';
				document.getElementById('ok3').style.display = 'none';				
			}else if($('input[name="same"]:checked').val() == 'rm'){
				$('#npp').val();
				$('#ok').hide();
				document.getElementById('ok3').style.display = 'block';
				document.getElementById('ok4').style.display = 'block';
				document.getElementById('ok5').style.display = 'block';
				document.getElementById('ok7').style.display = 'block';
				document.getElementById('ok2').style.display = 'block';
			}
	}
	
	function query_mail(){		
		var url = "<?php echo site_url('itservice/xmain/query')?>" ;
		$.ajax({
			url : url,
			type: "POST",
			data: {"npp": $('#npp').val()},
			dataType: "JSON",
			success: function(data)
			{
				/* if(data != null){
					if(data.email != null){
						$('#email').prop('disabled', true);
						e_mail = data.email;
						val = e_mail.split('@');
						$('[name="email"]').text(val[0]);
						$('[name="email"]').val(val[0]);
						
					} else{
						$('#email').prop('disabled', false);
						new PNotify({
							title: 'Email tidak ditemukan',
							text: 'Silahkan input email user.',
							type: 'info',
							styling: 'bootstrap3'
						});
						//alert('Email tidak ditemukan. Silahkan input email user');
					}	
				}else{
					new PNotify({
						title: 'Oh No!',
						text: 'Data Not Found.',
						type: 'error',
						styling: 'bootstrap3'
					});
					$('#email').val('').text('');
				} */
				if(data != null){
						$('#nama').prop('disabled', true);
						$('[name="nama"]').text(data.name);
						$('[name="nama"]').val(data.name);	
						$('[name="type"]').val("v");	
				}else{
					$('#pnama').hide();
					new PNotify({
						title: 'Notifikasi!',
						text: 'Data Not Found.',
						type: 'error',
						styling: 'bootstrap3'
					});
					$('#email').val('').text('');
					$('[name="type"]').val("x");	
				}
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('User not found');
			}
		});
	}
	function unit(){
		var str = $('#nosr').val();
		var valreq = $('#req option:selected').val();

		$.ajax({
				url : "<?php echo site_url('itservice/Xmain/pos_unit')?>",
				type: "POST",
				data: {pattern: str.substring(0, 4), valreq: valreq},
				dataType: "JSON",					
				success: function(data)
				{
					if (data.accOffice < 600){
						$('[name="unit"]').prop('disabled', true);
					}else{
						$('[name="unit"]').prop('disabled', false);
					}
					$('[name="unit"]').val(data.accOffice+"-"+data.pname);
					$('#accoffice').val(data.accOffice);
				}	  
			});
	}
	function query_req()
	{		
		var url = "<?php echo site_url('itservice/xmain/query_req2')?>" ;
		$.ajax({
			url : url,
			type: "POST",
			data: {"npp": $('#req').val()},
			dataType: "JSON",
			success: function(data)
			{
				if(data != null){
					$('[name="email"]').val(data.email);
				} else{
					alert('User not found');
					$('#name,#email').val(null);
				}					
			},
				error: function (jqXHR, textStatus, errorThrown)
			{
				alert('User not found');
				$('#btnSave').attr('disabled',false); 
			}
		});
	}
	function query_srt()
		{		
			var url = "<?php echo site_url('itservice/xmain/query_srt')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: {"nosr": $('#nosr').val()},
				dataType: "JSON",
				success: function(data)
				{
					if (data !== null) {
						var tgl_nosr = new Date(data.order_time);
						var dd = tgl_nosr.getDate();
						var mm = tgl_nosr.getMonth() + 1; //January is 0!

						var yyyy = tgl_nosr.getFullYear();
						if (dd < 10) {
						  dd = '0' + dd;
						} 
						if (mm < 10) {
						  mm = '0' + mm;
						} 
						var tgl_nosr = dd + '/' + mm + '/' + yyyy +" "+ tgl_nosr.getHours() +":"+tgl_nosr.getMinutes();
						 $("#dialog-confirm").html("Data telah diinput sebelumnya oleh <br> npp &nbsp &nbsp&nbsp &nbsp: &nbsp("+data.initiator+"-"+data.name+")<br> tanggal :&nbsp"
						 +tgl_nosr);
						 
						$("#dialog-confirm").dialog({
							resizable: false,
							modal: true,
							dialogClass: 'noTitleStuff',
							dialogClass: 'no-close',
							height: 200,
							width: 550,
							buttons: {
								"Proses": function () {
									$(this).dialog('close');
									 callback(true);
								},
								"Cancel": function () {
									$(this).dialog('close');
									callback(false);
								}
							}
						});
					}
					
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
		function callback(value) {
			if (value == false) {
				new PNotify({
					title: 'Regular Notice',
					text: 'Request has been cancelled',
					styling: 'bootstrap3'
				});
				$('#nosr').val('');
			}else{
				new PNotify({
					title: 'Success!',
					text: 'Silahkan melengkapi data lainnya',
					type: 'success',
					styling: 'bootstrap3'
				});
			}
		}
</script>

<style>
#form label {
    /* Other styling.. */
    text-align: left;
    clear: both;
    margin-right:15px;
}

#form label.error {
    color: red;
	font-size: 11px;
	text-align: left;
	margin-left: 2%;
	display: block;
}
.ui-dialog-titlebar-close{
    display: none;
}
.ui-widget-overlay {
   background: #AAA url(images/ui-bg_flat_0_aaaaaa_40x100.png) 50% 50% repeat-x;
   opacity: .50;
   filter: Alpha(Opacity=50);
}
.noTitleStuff .ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle {display:none}

#pretext {
  display: inline-block;
  border-radius: 4px;
  background-color: #FFB240;
  border: none;
  color: #FFFFFF;
  text-align: center;
  margin: 5%;
}
tr.C {
    background: #FFFACD;
}
tr.U {
	background: #FFBC8F;
}
#example tbody{
	background-color: white;
}
.datatable td {
  overflow: hidden; /* this is what fixes the expansion */
  text-overflow: ellipsis; /* not supported in all browsers, but I accepted the tradeoff */
  white-space: nowrap;
 
}
td{
	 word-wrap: break-word;
}
</style>
<div id="wrap" style="width: 70%;">
	<div  id="cekuser"style="margin:0 auto; margin-top: 5%; ">
		<form  id="form_reset" style=" margin: auto;">
		
			<p class="formHeader" style="font-size: 30px;">Request Management</p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row" style="width:90%;margin-left:6%;">
				<p id= "tipe" align="center">
					<label style="color: rgb(64, 92, 96);" >Tipe</label> 
					<input style="margin-left: 10%;" type="radio" id="cm" class="sama" name="same" value="cm" checked> Member
					<input style="margin-left: 10%;" type="radio" id="sr"  name="same" value="sr"> Surat
					<input style="margin-left: 10%;" type="radio" id="rm" name="same" value="rm"> Remedy
				</p>
				<p id="ok3"style="display:none;">
					<label style="color: rgb(64, 92, 96);">Work Order ID</label>
					<input type='text' id='inc' name='inc' class="form-control" placeholder="Incident ID">
				</p>
				<p id="ok2" style="display:none;">
					<label style="color: rgb(64, 92, 96);">No Surat</label>
					<input type='text' id='nosr' name='nosr' class="form-control" placeholder="No Surat" onchange="query_srt()" onclick="$('#nosr, #req, #unit, #accoffice, #email').val('').text('');$('#req').val('default');$('#req').selectpicker('refresh');">
				</p>
				
				<p id="ok4"style="display:none;">
					<label style="color: rgb(64, 92, 96);">Tanggal</label>
					<input type='text' id='doc_date' name='doc_date' class="form-control" placeholder="Tanggal">
				</p>
				<p id="ok5" style="display:none;">
					<label style="color: rgb(64, 92, 96);">Requestor</label> (silahkan pilih asisten umum jika ada)
					<select name="req" id="req" class="selectpicker form-control required" data-live-search="true" title="-- Pilih Requestor --" data-actions-box="true"  onchange="query_req()">
						<option disabled value="0">-- Pilih requestor --</option>
					</select>	
				</p>
				<p id="ok7" style="display:none;">
					<label style="color: rgb(64, 92, 96);">Email</label>
					<input type='text' id='email' name='email' class="form-control" placeholder="Email" disabled>
				</p>
				<p >
					<table id="example"style="text-align:center;table-layout: fixed;" class="table table-bordered">
						<thead  style="background-color: #b3b3b3;">
							<tr >
								<th style="text-align:center">No</th>
								<th style="text-align:center">NPP</th>
								<th style="text-align:center">User</th>
								<th style="text-align:center">Apps</th>
								<th style="text-align:center">Req</th>
								<th style="text-align:center">Action</th>
							</tr>
						</thead>
					</table>
				</p>
					<input name="id" id="id" class="form-control" type="hidden" >
					<input name="mode" id="mode" class="form-control" type="hidden" value="RS" >
					<input name="reqid" id="reqid" class="form-control" type="hidden" >	
					<input name="reqtype" id="reqtype" class="form-control" type="hidden" >
					<input name="notes" id="notes" class="form-control" type="hidden" >						
				<p class="signin button" style="margin-left:3%; width: 100%;">
					<button type="button" id="btn_add"class="btn btn-info" data-toggle="modal" onclick="modal(); $('#npp').val('');" >Add Data</button>
					<button type="button" id="btn_submit" class="btn btn-primary">Submit</button>
					<button type="button" id="btn_clear" class="btn btn-danger">Clear</button>
				</p>
				<p id="dialog-confirm"></p>
				
			</div>							
		</form>
	</div>

<div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
         <form  id="form" style="width: 500px; margin: auto;">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Request Management</p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<!--<div id="wait" style="display:none;width:20px;height:20px;position:relative;top:50%;left:50%;padding:2px;"><img  src="/idservice/assets/images/loader.gif" width="64" height="64" /></div>-->
			<div class="form-group row" style="width:90%;margin-left:6%;">			
				<p class="rst_pass" >
					<label style="color: rgb(64, 92, 96);">NPP</label> 
					<input type='text' id='npp' name='npp' class="form-control" placeholder="NPP" onchange="query_mail()" onclick="$('#pnama').show();$('#npp, #nama').val('').text('');$('#ok_tabel tbody tr').empty();$('#ok_tabel').hide();$('#addlevel, #addRow, #clear').hide();$('#btnsearch').show();">
				</p>
				<p class="rst_pass" id ="pnama"> 
					<label style="color: rgb(64, 92, 96);">Nama</label> 
					<input type='text' id='nama' name='nama' class="form-control" placeholder="Nama" disabled>
				</p>
				<p  class="rst_pass" >
					<label style="color: rgb(64, 92, 96);">Unit</label>
					
					<input name="unit" id="unit" placeholder="-- Unit Baru --" class="autocomplete form-control" type="text">
					<input type='hidden' id="accoffice" name='accoffice' class="form-control" placeholder="Kode Unit">
								 
				</p>
				<p id="ok" style="display:none;" >
					<label style="color: rgb(64, 92, 96);">Aplikasi</label> 
					<table id="ok_tabel" class="table table-bordered">
						<thead >
						  <tr style="background: #F6F6F6;">
							<th>Nama Aplikasi</th>
							<th>User</th>
							<th>Reset</th>
							<th>New</th>
						  </tr>
						</thead>
						<tbody id="list_apps">
						</tbody>
					</table>
				</p>					
				<p class="signin button" style="margin-left:3%; width: 100%;">
					<button type="button" id="btnsearch" class="btn btn-success">Search</button>
					<button type="button" id="addRow" class="btn btn-success">Add</button>
					<button type="button" id="addlevel" class="btn btn-danger" data-toggle="modal" >+</button>
					<button type="button" id="clear" class="btn btn-default">Clear</button> 
				</p>
				
			</div>							
		</form>
    </div>
</div>
<div class="modal-container" id="modal_target"></div>
<div class="modal fade" id="wait" role="dialog">
      <div class="modal-dialog">
		<div  class="ajax_overlay blue-loader" style="background-color: rgb(0, 0, 0); opacity: 0.3; width: 100%; height: 100%; position: absolute; top: 0px; left: 0px;">
			<div style="margin: auto; display: inline-block; width: 100%; text-align: center; padding-top: 20%;">
				<img src="<?php echo base_url('/assets/images/loader.gif'); ?> " width="64" height="64" />
			</div>
		</div>
    </div>
</div>