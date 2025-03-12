<!DOCTYPE html>
<html>
<head> 
	<style type="text/css">
		.ui-autocomplete { height: 300px; overflow-y: scroll; overflow-x: hidden;}
		.width100 {width: 100px;}
	</style>
</head> 
<body>
    
	<script type="text/javascript">
		var save_method; //for save method string
		var table;
		var position_list;
		$(document).ready(function() {
		
		});

		
		function test_table(){
			
			var mydata = [{'a':1, 'b':2}, {'a':1, 'b':5}];
			var tcol = ['b','a','b'];
			var tbl_body = "";
			var odd_even = false;
			$.each(mydata, function(idx, crow) {
				var tbl_row = "";
				
				$.each(tcol, function(i1 , ccol) {
					tbl_row += "<td>"+crow[ccol]+"</td>";
				})
				/*$.each(this, function(k , v) {
					tbl_row += "<td>"+v+"</td>";
				})*/
				tbl_body += "<tr class=\""+( odd_even ? "odd" : "even")+"\">"+tbl_row+"</tr>";
				odd_even = !odd_even;               
			})
			$("#TableCont tbody").html(tbl_body);
		}
		$(function () {
			$('#effDate').datepicker({
				minDate: new Date(),
				dateFormat: "ddmmyy"
			});
		});
		function add_person()
		{
			save_method = 'add';
			$('#form')[0].reset(); // reset form on modals
			$('.form-group').removeClass('has-error'); // clear error class
			$('.help-block').empty(); // clear error string
			$('#modal_form').modal('show'); // show bootstrap modal
			$('.modal-title').text('Tambah Pegawai'); // Set Title to Bootstrap modal title
		}

		function edit_person(id)
		{
			save_method = 'update';
			$('#form')[0].reset(); // reset form on modals
			$('.form-group').removeClass('has-error'); // clear error class
			$('.help-block').empty(); // clear error string

			//Ajax Load data from ajax
			$.ajax({
				url : "<?php echo site_url('xposition/posreview/ajax_edit/')?>/" + id,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{
						$('[name="id"]').val(data.id);
						$('[name="accOffice"]').val(data.accOffice);
						$('[name="npp"]').val(data.npp);
						$('[name="name"]').val(data.name);
						$('[name="mobileNumber"]').val(data.mobileNumber);
						$('[name="pname"]').val(data.pname);
						$('[name="positionid"]').val(data.positionid);
						$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
						$('.modal-title').text('Edit Pegawai'); // Set title to Bootstrap modal title
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error get data from ajax');
				}
			});
		}

		
		function query_id()
		{
			
			var url = "/idservice/stomp/xbanc/query_tellparam" ;
			//var url = "<?php echo site_url('stomp/xbanc/update_kewenangan')?>" ;

			//var url = "<?php echo site_url('stomp/xbanc/test_rest')?>" ;
			// ajax adding data to database
			$('#pretext').text('???'); 
			$('#reqtype').val('tellparam'); 
			$.ajax({
				url : url,
				type: "POST",
				data: $('#form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					console.log(data);
					if (data['status'].startsWith('Ok')){
						$('#nama').val(data['name']); 
						
						$('#effDate').val(data['effDate']);
						$('#branchcode').val(data['branchcode']);
						
						//addnew ryanda
						$('#grouptransc').val(data['grouptransc']);
						$('#lvlcap').val(data['lvlcap']);
						$('#securitycode').val(data['securitycode']);
						//addnew ryanda
						
						//$('#pretext').text(JSON.stringify(data)); 
						console.log(JSON.stringify(data)); 
						$('#pretext').text('Valid'); 
					} else {
						$('#nama').val("---"); 
						$('#pretext').text('Not Valid'); 
					}
					
					//$('#btnSave').attr('disabled',false); //set button enable 
				},
				
				error: function (jqXHR, textStatus, errorThrown)
				{ 
					alert('Error adding / update data');
					$('#btnSave').text('save'); //change button text
					$('#btnSave').attr('disabled',false); //set button enable 
				}
			});
		}

		function inq_tell()
		{
			
			var url = "/idservice/stomp/xbanc/query_tellparam" ;
			//var url = "<?php echo site_url('stomp/xbanc/update_kewenangan')?>" ;

			//var url = "<?php echo site_url('stomp/xbanc/test_rest')?>" ;
			// ajax adding data to database
			$('#pretext').text('??T I ?'); 
			$('#reqtype').val('tellinq'); 
			$.ajax({
				url : url,
				type: "POST",
				data: $('#form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					console.log(data);
					if (data['status'].startsWith('Ok')){
						$('#nama').val(data['name']); 
						
						$('#branchcode').val(data['branchcode']);
						
						//addnew ryanda
						$('#grouptransc').val(data['grouptransc']);
						$('#lvlcap').val(data['lvlcap']);
						$('#securitycode').val(data['securitycode']);
						//addnew ryanda
						
						//$('#pretext').text(JSON.stringify(data)); 
						console.log(JSON.stringify(data)); 
						$('#pretext').text('I T  >> '  + data['loginStatus']); 
					} else {
						$('#nama').val("---"); 
						$('#pretext').text('Not Valid'); 
					}
					
					//$('#btnSave').attr('disabled',false); //set button enable 
				},
				
				error: function (jqXHR, textStatus, errorThrown)
				{ 
					alert('Error adding / update data');
					$('#btnSave').text('save'); //change button text
					$('#btnSave').attr('disabled',false); //set button enable 
				}
			});
		}
		
		function delete_person(id)
		{
			// ajax delete data to database
			$.ajax({
				url : "<?php echo site_url('xposition/posreview/ajax_delete')?>/"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data)
				{
					//if success reload ajax table
					$('#modal_form').modal('hide');
					reload_table();
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error deleting data');
				}
			});
		}
		
		function submit()
		{
		}
	</script>

	<!-- Bootstrap modal -->
	
			<div class="modal-content" style="padding: 10px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" style="padding-left: 190px;">Form Pegawai</h3>
				</div>
				<div class="modal-body form">
					<form action="#" id="form" class="form-horizontal">
						<input type="hidden" value="" name="reqtype" id="reqtype"/> 
						<input type="hidden" value="" name="id"/> 
						<div class="form-body">
							<div class="form-group">
								<label for="npp">NPP/User ID</label>
								<input name="npp" id="npp" placeholder="NPP" class=" form-control" type="text" value="20429">
							</div>
							<div class="form-group">
								<label for="effDate">Eff Date</label>
								<input name="effDate" id="effDate" placeholder="effDate" class=" form-control" type="text" value="">
							</div>
							<div class="form-group">
								<label class="control-label">Kode Cabang/Unit</label>
								<input name="branchcode" id="branchcode" placeholder="Kode Cabang/Unit" class=" form-control" type="text">
							</div>
							
							<div class="form-group"> 
								<label class="control-label">Nama</label>
								<input name="name" id="nama" placeholder="Nama" class="form-control" type="text"></textarea>
							</div>
							<div class="form-group"> 
								<label class="control-label">No HP</label>
								<input name="mobileNumber" id="mobileNumber" placeholder="Nomor HP" class="form-control" type="text"></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Nama Posisi</label>
								<input id="pname" name="pname" placeholder="--- Posisi ----" class="autocomplete form-control" type="text" onclick="$(this).val('');"/>   
							</div>
							<div class="form-group">
								<label class="control-label">Posisi ID</label>
								<input name="positionid" id="positionid" placeholder="Posisi ID" class="form-control" readonly="readonly" type="text"/> 
							</div>
							<!-- add new ryanda-->
							
							<div class="form-group">
								<label class="control-label">Group Transc</label>
								<input name="grouptransc" id="grouptransc" placeholder="Group Transaction" class="form-control" type="text"></textarea>
							</div>
							
							<div class="form-group">
								<label class="control-label">Level Kapabilitas</label>
								<input name="lvlcap" id="lvlcap" placeholder="Level Kapabilitas" class="form-control" type="text"></textarea>
							</div>
							
							<div class="form-group">
								<label class="control-label">Level Security Data</label>
								<input name="securitycode" id="securitycode" placeholder="Level Secuirty Data" class="form-control" type="text"></textarea>
							</div>
							
							<!-- add new ryanda-->
							
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnSave" onclick="query_id()" class="btn btn-primary">Get Param</button>
					<button type="button" id="btnTest" onclick="inq_tell()" class="btn btn-primary">Inq Tell</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</div><!-- /.modal-content -->
		<pre id="pretext">
			adasd
		</pre>
		
		<table id="TableCont">
			<thead>
			  <tr>
				 <th style="width: 10px;">Month</th>
				 <th style="width: 150px;">Savings</th>
				 <th>save</th>
			  </tr>
			 </thead>
			 <tbody>
			 </tbody>
		</table>
	<!-- End Bootstrap modal -->
</body>
</html>