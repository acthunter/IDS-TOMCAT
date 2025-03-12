<!DOCTYPE html>
<html>
<head> 
	<style type="text/css">
		.ui-autocomplete { height: 300px; overflow-y: scroll; overflow-x: hidden;}
		.width100 { width: 100px; }
		#vote_buttons {
		cursor:pointer;
		cursor:hand;
		}
		.center_div{
    margin: 0 auto;
    width:80% /* value of your choice which suits your alignment */
}
	</style>
</head> 
<body >
<div class="row"  style="width: 101%; background-color: #FFFFFF;">
<div class="container center_div" style="width: 100%;">
<br><br>
	<form action="#" id="modal_form"  style="width: 100%;" role="form" class="form-horizontal"> 				
		<div class="form-group row">
									<div class="col-xs-1"></div>			
										<div class="col-xs-1"><label style="height: 27px; font-size: 90%">LoginID</label></div>
									<div class="col-xs-2">	
			<div class="input-group">	
				<input name="loginid" id="loginid" placeholder="LoginID" class="form-control" onchange="query_npp()" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
				<span id="btn_save" onclick="query_npp()" class="input-group-addon">
					<a href="#"><i class="fa fa-search"></i></a>
				</span>
			</div>
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Prev ID</label></div>
									<div class="col-xs-2">	
										<input name="previledgeid" id="previledgeid" placeholder="Previledge ID" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Position ID</label></div>
									<div class="col-xs-2">	
										<input name="name" id="name" placeholder="Position ID" class="autocomplete form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px" onclick="$(this).val(''); $('#tposid').val('');">
										<input name="positionid" id="positionid" placeholder="Position ID" class="form-control" type="hidden" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
								</div>
								<div class="form-group row">
									<div class="col-xs-1"></div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Icons</label></div>
									<div class="col-xs-2">	
										<input name="icons" id="icons" placeholder="Icons" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">SCO</label></div>
									<div class="col-xs-2">	
										<input name="sco" id="sco" placeholder="SCO" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">EIS</label></div>
									<div class="col-xs-2">	
										<input name="eis" id="eis" placeholder="EIS" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
								</div>
								<div class="form-group row">
									<div class="col-xs-1"></div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">IDM Init</label></div>
									<div class="col-xs-2">	
										<input name="idminit" id="idminit" placeholder="IDM Init" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>								
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">PRSK</label></div>
									<div class="col-xs-2">	
										<input name="prsk" id="prsk" placeholder="PRSK" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">F1m</label></div>
									<div class="col-xs-2">	
										<input name="f1m" id="f1m" placeholder="F1m" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
								</div>
								<div class="form-group row">
									<div class="col-xs-1"></div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Forum</label></div>
									<div class="col-xs-2">	
										<input name="forum" id="forum" placeholder="Forum" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px" >
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">IMS</label></div>
									<div class="col-xs-2">	
										<input name="ims" id="ims" placeholder="IMS" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Internet</label></div>
									<div class="col-xs-2">	
										<input name="internet" id="internet" placeholder="Internet" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
								</div>
								<div class="form-group row">
									<div class="col-xs-1"></div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">PSN</label></div>
									<div class="col-xs-2">	
										<input name="psn" id="psn" placeholder="PSN" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Sec</label></div>
									<div class="col-xs-2">	
										<input name="sec" id="sec" placeholder="Sec" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">SKA</label></div>
									<div class="col-xs-2">	
										<input name="ska" id="ska" placeholder="SKA" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
								</div>
								<div class="form-group row">
									<div class="col-xs-1"></div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">fsep</label></div>
									<div class="col-xs-2">	
										<input name="fsep" id="fsep" placeholder="FSEP" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px" >
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Ibank</label></div>
									<div class="col-xs-2">	
										<input name="ibank" id="ibank" placeholder="Ibank" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">NSKA</label></div>
									<div class="col-xs-2">	
										<input name="nska" id="nska" placeholder="NSKA" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-1"></div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">OPBG</label></div>
									<div class="col-xs-2">					        
										<input name="opbg" id="opbg" placeholder="OPBG" class=" form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">SRP</label></div>
									<div class="col-xs-2">					        
										<input name="srp" id="srp" placeholder="SRP" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Svs</label></div>
									<div class="col-xs-2">					        
										<input name="svs" id="svs" placeholder="Svs" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
								</div>
								<div class="form-group row">
									<div class="col-xs-1"></div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Tplus</label></div>
									<div class="col-xs-2">	
										<input name="tplus" id="tplus" placeholder="Tplus" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">WMS</label></div>
									<div class="col-xs-2">	
										<input name="wms" id="wms" placeholder="WMS" class="form-control" onchange="query_npp()" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">IDM</label></div>
									<div class="col-xs-2">	
										<input name="idm" id="idm" placeholder="IDM" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-1"></div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">IDM App</label></div>
									<div class="col-xs-2">	
										<input name="idmapprove" id="idmapprove" placeholder="IDM Approve" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">CRM </label></div>
									<div class="col-xs-2">					        
										<input name="crm" id="crm" placeholder="CRM" class=" form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">CST</label></div>
									<div class="col-xs-2">					        
										<input name="cst" id="cst" placeholder="CST" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px" >
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-1"></div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Bar</label></div>
									<div class="col-xs-2">					        
										<input name="bar" id="bar" placeholder="Bar" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">SMPK</label></div>
									<div class="col-xs-2">
										<input name="smpk" id="smpk" placeholder="SMPK" class=" form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
									<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Jabatan</label></div>
									<div class="col-xs-2">					        
										<input name="jabatan" id="jabatan" placeholder="Jabatan" class="form-control" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px">
									</div>
								</div>
								<div class="modal-footer" id="div_btn_modal" style="padding-bottom: 0px;padding-top: 12px;border-bottom-width: 0px;margin-bottom: -11px;">
									<div class="col-xs-12" style="text-align: right;">
										<button type="button" id="btn_save" onclick="modal_submit()" class="btn btn-primary">Update</button>
										<button type="reset" class="btn btn-primary" onclick="modal_reset()">Reset</button><br><br>
									</div>
								</div>
							</form>
</div>
</div>
<script type="text/javascript">
	function query_npp()
		{		
			var url = "<?php echo site_url('query_prev')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: $('[name="loginid"]').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					$('[name="previledgeid"]').val(data.previledgeid);
					$('[name="positionid"]').val(data.positionid);
					$('[name="name"]').val(data.name);
					$('[name="icons"]').val(data.icons);
					$('[name="sco"]').val(data.sco);
					$('[name="eis"]').val(data.eis);
					$('[name="idminit"]').val(data.idminit);
					$('[name="prsk"]').val(data.prsk);
					$('[name="f1m"]').val(data.f1m);
					$('[name="forum"]').val(data.forum);
					$('[name="ims"]').val(data.ims);
					$('[name="internet"]').val(data.internet);
					$('[name="psn"]').val(data.psn);
					$('[name="sec"]').val(data.sec);
					$('[name="ska"]').val(data.ska);
					$('[name="fsep"]').val(data.fsep);
					$('[name="ibank"]').val(data.ibank);
					$('[name="nska"]').val(data.nska);
					$('[name="opbg"]').val(data.opbg);
					$('[name="srp"]').val(data.srp);
					//USER EXPIRED
					$('[name="svs"]').val(data.svs);
					$('[name="tplus"]').val(data.tplus);
					$('[name="wms"]').val(data.wms);
					$('[name="idm"]').val(data.idm);
					$('[name="idmapprove"]').val(data.idmapprove);
					$('[name="crm"]').val(data.crm);
					$('[name="cst"]').val(data.cst);
					$('[name="bar"]').val(data.bar);
					$('[name="smpk"]').val(data.smpk);
					$('[name="jabatan"]').val(data.jabatan);
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		};
		$("#name").autocomplete({  
				minLength: "2",  
				source:   
				function(request, response){  
				console.log('test');
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
				select: function( event, ui ) {					
					$('#positionid').val(ui.item.rvalue.positionid);
				}	
			});
	
	function modal_submit(){
		var url = "<?php echo site_url('update_prev')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: $('#modal_form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					alert('Data berhasil di update');
					$("#modal_form")[0].reset()
				}
			});
	};
	function modal_reset(){
		$form[0].reset();
	};
</script>