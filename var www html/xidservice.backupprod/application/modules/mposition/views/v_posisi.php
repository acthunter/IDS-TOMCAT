<!DOCTYPE html>
<html>
<head> 
	<style type="text/css">
		.ui-autocomplete { height: 300px; overflow-y: scroll; overflow-x: hidden;}
		.width100 {width: 100px;}
	</style>
</head> 
<body>
	<input name="reqid" id="reqid" class="form-control" type="hidden">
	
    <div class="container" style="margin-left: -176px;">
		<h3 style="padding-bottom: 10px;" align="center" class="page-header">Data Pegawai</h3>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
		<button class="btn btn-success" onclick="oke()" value="P"><i class="glyphicon glyphicon-ok"></i> Submit</button>
        <br />		
		<div class="block-table table-sorting clearfix">
			<table cellpadding="" cellspacing="2" class="tabel" id="datatable" style="width: 100%;"> 		
				<thead>
					<tr>
						<th>No</th>
						<th>NPP</th>
						<th>Nama</th>
						<th>Posisi</th>						
						<th>No HP</th>
						<th>Flag</th>
						 
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
    </div>
	
	<script type="text/javascript">
		var save_method; 
		var table;
		var position_list;
		
		function table_item_click(data){
			edit(data);
		}
		$(document).ready(function() {

			table = $('#datatable').DataTable({ 
				
				"processing": true, 
				"serverSide": true, 
				"order": [], 
				"ajax": {
					"url": "<?php echo site_url('mposition/review/pos_list')?>",
					"type": "POST"
				},
				"columns": [
					{"data": "id"},
					{"data": "loginid"},
					{"data": "name"},
					{"data": "pname"},
					{"data": "mobileNumber"},
					{"data": "flag"}
				],
				"columnDefs": [
				{  
					"targets": [ -1 ], 
					"orderable": false,
				},
				],
			});
					$('#datatable').on('click', 'tr:not(:first)', function () {
				table_item_click(table.row($(this).index()).data());
			});

			$("input").change(function(){
				$(this).parent().parent().removeClass('has-error');
				$(this).next().empty();
			});
			$("textarea").change(function(){
				$(this).parent().parent().removeClass('has-error');
				$(this).next().empty();
			});
			$("select").change(function(){
				$(this).parent().parent().removeClass('has-error');
				$(this).next().empty();
			});  
		
			$("#pname").autocomplete({  
				minLength: "2",  
				source:   
				function(request, response){  
				console.log('test');
					$.ajax({  
						url: "<?php echo site_url('mposition/temppos/pos_search')?>",  
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
		});

		function reload_table()
		{
			table.ajax.reload(null,false); 
		}
		
		function edit(data)
		{
			save_method = 'update';
			$('#form')[0].reset(); 
			$('.form-group').removeClass('has-error');
			$('.help-block').empty();
			id = data['id'];
			$.ajax({
				url : "<?php echo site_url('mposition/review/edit/')?>" + id,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{
						$('[name="id"]').val(data.id);
						$('[name="loginid"]').val(data.loginid);
						$('[name="name"]').val(data.name);						
						$('[name="pname"]').val(data.pname);
						$('[name="positionid"]').val(data.positionid);
						$('[name="mobileNumber"]').val(data.mobileNumber);
						$('#modal_form_review').modal('show'); 
						$('.modal-title').text('Edit Pegawai');
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error get data');
				}
			});
		}

		function save()
		{
			
			var url = "<?php echo site_url('mposition/review/update')?>";

			var cpos = $('#positionid').val();
			$.ajax({
				url : url,
				type: "POST",
				data: $('#form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					if(data.status) 
					{
						$('#modal_form').modal('hide');
						reload_table();
					}
					else
					{
						for (var i = 0; i < data.inputerror.length; i++) 
						{
							$('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
							$('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
						}
					}
					$('#btnSave').text('save'); 
					$('#btnSave').attr('disabled',false); 
				},				
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error adding / update data');
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
		
/* 		function update_flag(id, newflag)
		{
			var url = "<?php echo site_url('mposition/posisi/update_flag')?>";

			// ajax adding data to database
			$.ajax({
				url : url,
				type: "POST",
				data: { "id" : id, "flag" : newflag},
				dataType: "JSON",
				success: function(data)
				{
					if(data.status) 
					{
						reload_table();
					}
				}
			});
		} */
		
		function submit()
		{
			var url = "<?php echo site_url('mposition/review/add')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: $('#form_comment').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					alert('Data has been submit');
					window.location.href = "<?php echo site_url('mposition/approval')?>";
				},
				
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error adding / update data'); 
					$('#btnSave').text('save'); 
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
		
		function oke(){
			$('#modal_form').modal('hide');
			$('#modal_comment').modal('show');
		}
	</script>

	<!-- Bootstrap modal -->
	<div class="modal fade" id="modal_form_review" role="dialog">
		<div class="modal-dialog ui-front">
			<div class="modal-content" style="padding: 15px;margin-right: 48px;margin-left: 48px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" style="padding-left: 145px;">Data Pegawai</h3>
				</div>
				<div class="modal-body form">
					<form action="#" id="form" class="form-horizontal">
						<input type="hidden" value="" name="id"/> 
						<div class="form-body">
							<div class="form-group">
								<label for="loginid">NPP</label>
								<input name="loginid" placeholder="NPP" class=" form-control" type="text" readonly="readonly">
							</div>
							<div class="form-group"> 
								<label class="control-label">Nama</label>
								<input name="name" placeholder="Nama" class="form-control" type="text"></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Posisi</label>
								<input id="pname" name="pname" placeholder="--- Posisi ----" class="autocomplete form-control" type="text" onclick="$(this).val(''); $('#positionid').val('');"/>   
							</div>
							<div class="form-group">
								<label class="control-label">Posisi ID</label>
								<input name="positionid" id="positionid" placeholder="Posisi ID" class="form-control" readonly="readonly" type="text"/> 
							</div>
							<div class="form-group"> 
								<label class="control-label">No HP</label>
								<input name="mobileNumber" placeholder="Nomor HP" class="form-control" type="text"></textarea>
								<input name="reqid" id="reqid" class="form-control" type="hidden" >
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="modal_comment" role="dialog">
		<div class="modal-dialog ui-front">
			<div class="modal-content" style="padding: 10px; width: 500px; margin-left: 85px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<center><h3 class="modal-title"></h3></center>
				</div>
				<div class="modal-body form">
					<form action="#" id="form_comment" class="form-horizontal"> 				
						<div class="form-group row">
							<div class="col-md-6">
								<label>You update this data because : </label>
								<textarea style="width: 441px;"name="notes" id="notes" class=" form-control" ="10" type="text"></textarea>
							</div>
						<input name="id" id="id" class="form-control" type="hidden" >
						<input name="reqid" id="reqid" class="form-control" type="hidden" >					
						</div>
					
					</form>
				</div>	
				<div class="modal-footer">
						<button class="btn btn-warning" onclick="submit()" value="P"> Submit</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>