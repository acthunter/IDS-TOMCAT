<script type="text/javascript">
if (!window.console) console = {log: function() {}};
$(document).ready(function(){
	var loginid = getUrlParameter('loginid');
	var reqid = getUrlParameter('reqid');
	$('#loginid').val(loginid);
	$('#reqid').val(reqid);
	 console.log(loginid);
	 console.log(reqid);
	$("#mToken, #wrap2, #myModal, #ok_tabel2, #loginid, #reqid").hide();
	$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null) {
       return null;
    }
    return decodeURI(results[1]) || 0;
}
	$( "#submit" ).click(function() {
		if(($('#loginid').val() != "") && ($('#reqid').val() != "")){
			var fingerprint = new Fingerprint().get(); 
			var fdata = { 'loginid' : $.urlParam('loginid'), 'reqid' : $.urlParam('reqid'), 'fp' : fingerprint, 'type' : 'validateUser' };
			//alert(JSON.stringify(fdata));		
			var url = "<?php echo site_url('pass/xgpass/getpass')?>" ;
			var url2 = "<?php echo site_url('pass/xgpass/otp')?>" ;
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
					//alert(data['resp']);
					if (data['resp'] == 'ok'){
						if (typeof console == "undefined") console = {
							log: function() {},
							debug: function() {},
							error: function() {}
						};
						$.ajax({
							url: url2,
							type: "POST",
							success: function(data2){
								var $dialog = "test";
								$('<div></div>').dialog({
									modal: true,
									title: "Input OTP",
									resizable: false,
									draggable: false,
									width: 550,
									height: 300,
									closeText : 'close',
									open: function () {
										var markup = 'Hello World';
										$(this).html(data2);
										//$('button').replaceWith('<i class="fa fa-times" aria-hidden="true"></i>');
										//$('button.ui-button.ui-corner-all.ui-widget.ui-button-icon-only.ui-dialog-titlebar-close').replaceWith('<button type="button" class="ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-close" title="close"><span class="ui-button-icon ui-icon ui-icon-closethick"></span><span class="ui-button-icon-space"> </span>close</button>');
										$("button.ui-button.ui-corner-all.ui-widget.ui-button-icon-only.ui-dialog-titlebar-close").empty().removeClass('ui-button-icon-only').append('x');
										//$("div.ui-dialog.ui-corner-all.ui-widget.ui-widget-content.ui-front ui-resizable").removeClass('ui-dialog');
										//$('span.ui-button-icon.ui-icon.ui-icon-closethick').replaceWith('<i class="fa fa-times" aria-hidden="true"></i>');
										//$("button span.ui-button.ui-corner-all.ui-widget.ui-button-icon-only.ui-dialog-titlebar-close").remove();
									},
									buttons   : [
										{
											text: "Submit",
											"class": 'btn-change',
											click: function() {
												$('.ui-state-default:first').addClass('btn-change');
												//$('.ui-dialog-titlebar-close').css('',"{primary: 'ui-icon-volume-on'}");
												/* alert("next");
												alert($('[id="otp"]').val()); */
												if(($('#otp').val() != "")){
													$('[name="otp_pass"]').val($('[id="otp"]').val());
													//window.open('<?php echo site_url('pass/xgpass/showpass')?>?loginid='+$.urlParam('loginid')+'&reqid='+$.urlParam('reqid')+'&otp='+$('#otp').val(),'winname','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=750');
													$(this).dialog('close');
													//var fdata2 = { 'loginid' : $.urlParam('loginid'), 'reqid' : $.urlParam('reqid'), 'otp' : $('[name="otp_pass"]').val(), 'fp' : fingerprint, 'type' : 'submitToken' };
																$.ajax({
																	url: "<?php echo site_url('pass/xgpass/showpass')?>",
																	type: "POST",
																	success: function(data4){
																		$('<div></div>').dialog({
																			modal: true,
																			title: "Password",
																			resizable: true,
																			draggable: false,
																			width: 550,
																			height: 300,
																			open: function () {
																				$(this).html(data4);
																				$("button.ui-button.ui-corner-all.ui-widget.ui-button-icon-only.ui-dialog-titlebar-close").empty().removeClass('ui-button-icon-only').append('x');
																				//$("div.ui-dialog.ui-corner-all.ui-widget.ui-widget-content.ui-front ui-resizable").removeClass('ui-dialog');
																				
																			},
																			close: function () {
																				$('#form').remove();
																				
																			}
																		})
																	}
																});
												}
											}
										},
										{
											text: "Back",
											"class": 'btn-default',
											click: function() {
												// Save code here
												$(this).dialog('close');
												$('#form').remove();
											}
										}
									],
									close: function () {
										$('#form').remove();
									}
								});
							}   
						});
/* 						$("#wrap2").show();
						$("#wrap").hide();
						$("mToken").show(); */
					} else {
						alert("Loginid / Reqid yang Anda Masukkan Belum Sesuai");
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
		}
	});
	$( "#back" ).click(function() {
		$("#wrap2").hide();
		$("#wrap").show();
		$("mToken").hide();
	});
	$( "#submit2" ).click(function() {
		if(($('#otp').val() != "")){
/* 			var fingerprint = new Fingerprint().get();
			var fdata = { 'loginid' : $('#loginid').val(), 'reqid' : $('#reqid').val(), 'otp' : $('#otp').val(), 'fp' : fingerprint, 'type' : 'submitToken' }; */
			//alert(JSON.stringify(fdata));		
							window.open('<?php echo site_url('pass/xgpass/showpass')?>?loginid='+$.urlParam('loginid')+'&reqid='+$.urlParam('reqid')+'&otp='+$('#otp').val(),'winname','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=750');

/* 			var url = "<?php echo site_url('pass/xgpass/getpass')?>" ;
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
					//alert(data['resp']);
					var wdata = data['rmap'];
					if (data['status'] == 'ok'){
						var xdata = wdata['vlist'];
						$.each(xdata, function (index, item) {
							$.each(item, function (idx, elm) {
								//alert(JSON.stringify(index));
								$("#list_apps").append("<tr class='checklist'><td>"+ elm['target'] +"</td><td>"+ index +"</td></tr>");
							});
						});
						$("#ok_tabel2").show();
						$("#myModal").modal('show');
						$("#wrap2").hide();
						$("#wrap").show();
						$("mToken").hide();
					} else {
						alert("Token Tidak Sesuai");
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
 */		}
	});
	
	/* var dt = new Date();
	var sec = document.getElementById("sec");
	sec.innerHTML = dt.getHours() + ":" + (dt.getMinutes() + 1); */
});

function save(){
	var data = {'loginid' : $('#loginid').val(), 'reqid' : $('#reqid').val()};
	var url = "<?php echo site_url('pass/xgpass/save')?>" ;
 	$.ajax({
		url : url,
		type: "POST",
		data: data,
		dataType: "JSON",
		beforeSend: function(){
					$('#wait').show();
				},
		success: function(data)
		{
			alert("saved");
		},
		complete: function(){
					 $("#wait").hide();
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('error');
			$('#btnSave').attr('disabled',false); 
		}
	});
}

function getUrlParameter(name) {
	name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
	var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
 	var results = regex.exec(location.search);
	return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

</script>
<style>
.blue-loader.ajax_loader {
    background: transparent url("/xidservice/assets/images/loader.gif") no-repeat scroll center center;
}
.ui-widget-overlay{
	opacity: 0.5;
	filter: alpha(opacity=50);
}
button{
	-webkit-box-shadow:none;
	box-shadow:none;
}
elemen {

    height: auto;
    width: 550px;
    top: 177px;
    left: 408px;
    display: block;
    z-index: 101;

}
.ui-widget.ui-widget-content {

    border: 1px solid 

    #c5c5c5;

}
.ui-dialog {

    padding: none;

}
.ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br {

    border-bottom-right-radius: 3px;

}
.ui-corner-all, .ui-corner-bottom, .ui-corner-left, .ui-corner-bl {

    border-bottom-left-radius: 3px;

}
.ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr {

    border-top-right-radius: 3px;

}
.ui-corner-all, .ui-corner-top, .ui-corner-left, .ui-corner-tl {

    border-top-left-radius: 3px;

}
.ui-widget-content {

    border: 1px solid #dddddd;
    background: 

#ffffff;

color:

    #333333;

}
.ui-widget {

    font-family: Arial,Helvetica,sans-serif;
    font-size: 1em;

}
.ui-dialog{
	padding: 0;
}

.btn-change.ui-button  {
    border: none;
    font-weight: normal;
	color: #fff;
    background-color: #5cb85c;
    border-color: #4cae4c;

}
.btn-default.ui-button  {
    border: 1px solid #cccccc;
	background: #ededed;
	font-weight: normal;
	color: #2b2b2b;
}


.close:hover {
    color: #000;
	text-decoration: none;
	cursor: pointer;
	filter: alpha(opacity=50);
	opacity: .5;
}
</style>
<div id="wrap" style="width: 50%;">
	<div id="cekuser"style="margin:0 auto; margin-top: 15%; margin-bottom: 10%;">
		<form id="form_reset" style=" margin: auto;">
			<p class="formHeader" style="font-size: 30px;">Get OTP</p>
			<div class="form-group row" style="width:90%;margin-left:5%;">					
				<p class="signin button" style="margin-left:3%; width: 100%;">
					<button type="button" id="submit" class="btn btn-success" data-toggle="modal">Get OTP</button>
					<input name="otp_pass" id="otp_pass" class="form-control" type="hidden" >
				</p>	
			</div>							
		</form>
	</div>
</div>
<div id="wait" class="ajax_overlay blue-loader" style=" display:none; background-color: rgb(0, 0, 0); opacity: 0.3; width: 100%; height: 100%; position: absolute; top: 0px; left: 0px;">
	<div style="margin: auto; display: inline-block; width: 100%; text-align: center; padding-top: 20%;">
		<img  src="/xidservice/assets/images/loader.gif" width="64" height="64" />
	</div>
</div>
<!--<div id="wrap3" style="width: 100%;">
		<div id="wait" style="display:none;width:20px;height:20px;position:relative;top:50%;left:50%;padding:2px;"><img  src="/idservice/assets/images/loader.gif" width="64" height="64" /></div>
<div>-->