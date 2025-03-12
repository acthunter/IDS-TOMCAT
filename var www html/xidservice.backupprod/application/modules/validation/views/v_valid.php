<script type="text/javascript">
var filterApps = "<?php echo $appfilter; ?>";
var t ;
$(document).ready(function(){

/* if ($('.selected').length == $(rdata).length) {
					$('#btn_next').prop("disabled", false);
				}  */
var detailRows = [];
		idaction();
		$( " #sdiv, #myBar" ).hide();
					$('#example tbody').on( 'click', 'tr td a.validate', function () {
				
				 var tr = $(this).closest('tr');
				 var idx =  t.row( tr ).data();
						var person = prompt("Alasan:", "");
						if (person != null) {
							var fdata = {'detail':person, 'trid':idx['trId'], 'id':idx['xvId'], 'req': "validate"};
							proses(fdata); 
						 $(this).closest('tr').addClass('selected');//break out of the function early
						}
						if ($("#list_apps tr.selected").length == $("#list_apps tr").length) {
							//$( "#btn_submit" ).show();
							$("#btn_submit").css("display", "block");
							$("#btn_next").css("display", "none");
							
						}
						
					} );
			$('#example tbody').on( 'click', 'tr td a.reject', function () {
				
				 var tr = $(this).closest('tr');
				 var idx =  t.row( tr ).data();
						var person = prompt("Alasan:", "");
						if (person != null) {
							var fdata = {'detail':person, 'trid':idx['trId'], 'id':idx['xvId'], 'req': "reject" };
							proses(fdata); 
						 $(this).closest('tr').addClass('selected');//break out of the function early
						}
						if ($("#list_apps tr.selected").length == $("#list_apps tr").length) {
							//$( "#btn_submit" ).show();
							$("#btn_submit").css("display", "block");
							$("#btn_next").css("display", "none");
							
						}
						
					} );	
	});
	function idaction (){
		$("#btn_submit").css("display", "none");
		
		//$('#btn_next').prop("disabled", true);
		$('#wait').show();
		var fdata = null;
		 if ($("#token_id").val() == ''){
			 fdata = {'reqtype': 'update', 'filter':filterApps };
		 }else{ 
			 fdata = {'reqtype': 'update', 'repoid' : $("#token_id").val(), 'filter':filterApps };
		 }
		//alert(JSON.stringify(fdata));
		__action(fdata);
		
	}
	function __action(fdata){
			cleanForm();
			$('#wait').show();
			var url = "<?php echo site_url('validation/xvalid')?>" ;
			//$("#wait").show();
			 $('#wait').show();
			$.ajax({
				url : url,
				type: "POST",
				data: fdata,
				dataType: "JSON",
				crossDomain:false,
				beforeSend: function(){
        $('#wait').show();
    },
				success: function(data)
				{	 
				//var data = {"vlist":[{"xrId":28,"xvId":87,"trId":115,"loginid":56680,"target":"globs","type":"U"},{"xrId":22,"xvId":93,"trId":119,"loginid":30393,"target":"skcdm_icons","type":"U"}],"queue":{"id":8,"lasttime":null,"type":"V","status":"J","actor":37559}}; 
				var wdata = data.queue;
				var rdata = data.vlist;
				//alert($(rdata).length);
				//alert($('.selected').length)
				t =  $('#example').DataTable({
						"destroy": true,"searching": false,"bLengthChange": false,"bInfo" : false,  "paging": true,"pageLength": 5,
						"data" : rdata,
						"drawCallback": function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  },
						"columns": [
							{ "data": "loginid",
							  "className": "dt-center", "targets": "_all"},
							{ "data": "target" },
							{ "data": "type" ,
							"className": "dt-center", "targets": "_all"},
							{
							   "mRender": function(data, type, full) {
								return '<a class="validate btn btn-success btn-sm" >' + 'Validate' + '</a> <a class="reject btn btn-warning btn-sm" >' + 'Reject' + '</a>';
							}
							},
							
						],
						});	
				if (data.resp !== 'false'){
				
				//var list= [];
					/* $.each(data.vlist, function (index, item) {
						//alert(item['apps']);
						list.push(item['trId']);
						//alert(item['trId']);
						  }); */
						 //alert(trid);
				 //var trid = list.toString();
				

					
					if (typeof wdata['id'] != 'undefined'){
						
						 $('#token_id').val(wdata['id']);
						 $('#token_val').text(wdata['id']);
						// $('#trid').val(trid);
						$('#type').val(wdata.type);
						$('#type_val').text(wdata.type);
						$('#status').val(wdata.status);
						$('#status_val').text(wdata.status);
						// $('#token').val(data.rmap['token']); 
						 
					} else {
						//alert("kosong");
						t.clear().draw();
					}
				 }else{
					//$('#btn_next').prop("disabled", true);
					 //t.clear().draw();
				}
					
				},
				complete: function(){
					$("#wait").hide();
					$("#btn_next").css("display", "block");
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error adding / update data');
					//$('#btnSave').attr('disabled',false); 
				}
			});
			$( "#myBar" ).hide();
	
	} 
	
	function proses(fdata){
		url = "<?php echo site_url('validation/xvalid/validate')?>";
		
		$.ajax({
			url : url,
			data: fdata,
			type: "POST",
			dataType: "JSON",
			success : function (data){
			//	alert("success");
				
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert("Error adding / update data");
			}
			
		});
	}
	
	function cleanForm(){
		$('#token_id').val('');
		$('#trid').val('');
		$('#type').val('');
		$('#status').val('');
		$('#notes').val('');
	}
	function submit_action(){
		//alert(btype);
		var fdata = {'id':$("#token_id").val()};
		url = "<?php echo site_url('validation/xvalid/processed')?>";
		 $("#wait").show();
		$.ajax({
			url : url,
			data: fdata,
			type: "POST",
			beforeSend: function(){
        $('#wait').show();
    },
			dataType: "JSON",
			success : function (data){
				//alert("success");
				new PNotify({
					title: 'Notifikasi',
					text: 'Data telah di Proses !',
					type: 'success',
					styling: 'bootstrap3'
				});
				idaction();
				
			},
			complete: function(){
					 $("#wait").hide();
			},
			error: function (jqXHR, textStatus, errorThrown){
				alert("Error adding / update data");
			}
			
		});
		
	}
</script>

<style>
.lbl{
	width: 28%;
	color: rgb(64, 92, 96);
	font-size: 13 px;
}
.lblval{
	display: inline;
	width: 65%;
	color: rgb(64, 92, 96);
}
th.dt-center, td.dt-center { text-align: center; }
tr.selected td.btn {
    pointer-events: none;
        cursor: not-allowed;
        opacity: 0.6;
		color : white;
		}
.dataTables_wrapper {
    position: static;
}
</style>

<div id="wrap">
	<div id ="tokenDiv" style="padding:0; margin:0 auto;">
		<form action="#" id="form1" style="width: 625px; margin: auto;">
			<p class="formHeader" style="font-size: 30px;">Validasi</p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row" style="width:90%;margin-left:6%;">
					<p class="row fl-controls-left"style="padding-left: 4%;">
						<!--<label class="lbl" >Id</label> <label class="lblval" id="token_val" name="token_val"></label>--> 
						<input name="token_id" id="token_id" value="" class="form-control "  type="hidden" readonly="true" />
					</p>	
					<!--<p class="row fl-controls-left">
						<label class="judul">Trid</label> <label class="lblval" id="trid_val" name="trid_val"></label> 
						<input name="trid" id="trid" value="" class="form-control"  type="hidden" readonly="true"/>
					</p>-->
					<p class="row fl-controls-left"style="padding-left: 4%;">
						<!--<label class="lbl">Type</label> <label class="lblval" id="type_val" name="type_val"></label>--> 
						<input name="type" id="type" value="" class="form-control"  type="hidden" readonly="true"/>
					</p>		
					<p class="row fl-controls-left" style="padding-left: 4%;">
						<!--<label class="lbl">Status</label> <label class="lblval" id="status_val" name="status_val"></label>--> 
						<input name="status" id="status" value="" class="form-control"  type="hidden" readonly="true"/>
					</p>
					<p>
					<div id="wait" style="display:none;width:20px;height:20px;position:relative;top:50%;left:50%;padding:2px;"><img  src="<?php echo base_url('/assets/images/loader.gif'); ?>" width="64" height="64" /></div>

					<table id="example" class="table table-bordered">
						<thead >
						  <tr style="background: #F6F6F6;">
							<th>Loginid</th>
							<th>Trid</th>
							<th>Target</th>
							<th>Action</th>
						  </tr>
						</thead>
						<tbody id="list_apps">
						</tbody>
					</table>
					</p>
					<!--<p class="row fl-controls-left">
						<label class="judul">detail</label> 
						<input name="notes" id="notes" value="" class="form-control"  type="text"/>
					</p>-->									
					<p >
						<button type="button" id="btn_submit" style="display: none;float:left; margin: 0 2% 0 2%" onclick="submit_action();" class="btn btn-success">Submit</button>
						<button type="button" id="btn_next"  onclick="return idaction();" class="btn btn-primary">Next</button>
					</p>
			</div>							
		</form>
	</div>
</div>