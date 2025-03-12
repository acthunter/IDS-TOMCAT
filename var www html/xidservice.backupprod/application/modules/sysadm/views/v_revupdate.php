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
			<div class="col-xs-1"><label style="height: 27px; font-size: 90%">Kode Unit</label></div>
			<div class="col-xs-2">
			<div class="input-group">	
				<!--<input name="accOffice" id="accOffice" placeholder="accOffice" class="form-control" onchange="process_proc()" type="text" style="height: 27px; font-size: 90%; padding: 0px 0px 0px 12px"> -->
				<select name="accOffice" id="accOffice" class="input-right form-control"   placeholder="-- Target --" type="text"/>
				<option value=""disabled selected>-- select --</option>
				</select>
			</div>
		</div>
		</div>
		
		<div class="modal-footer" id="div_btn_modal" style="padding-bottom: 0px;padding-top: 12px;border-bottom-width: 0px;margin-bottom: -11px;">
			<div class="col-xs-12" style="text-align: left;">
				<button type="button" id="btn_save" onclick="process_proc()" class="btn btn-primary">Update</button>
				<!--<button type="reset" class="btn btn-primary">Reset</button><br><br>-->
			</div>
		</div>
								

	</form>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
			var url = "<?php echo site_url('sysadm/xbatch/accOffice')?>" ;
			var $select=$('#accOffice');
			//$select.empty();
			$("#div_btn_modal").show();
			
			$.ajax({
				url : url,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					console.log
					$.each(data, function (index, item) {
						$select.append(
							$('<option>', {
								value: item['accoffice'] ,
								text: item['accoffice']
							}, '</option>'))
						  }
						 )
					//dari idservicedemo1
					if (data.authorize != undefined){
						if (data.authorize){
							$("#mobileNumber_div").hide();
						}
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
	});
	function process_proc()
		{		
			var url = "<?php echo site_url('call_procedure')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: $('[name="accOffice"]').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					alert('sucess');
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		};
	function modal_submit(){
		var url = "<?php echo site_url('update_employee')?>" ;
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
</script>