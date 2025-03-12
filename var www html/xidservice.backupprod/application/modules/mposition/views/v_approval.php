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
	</style>
</head> 
<body>
<div class="row" style="margin-right: -400px;margin-left: -50px;">
<div class="container">
<?php $idm_init = $_SESSION['pengguna']->idm_init;
	  $idm_appr = $_SESSION['pengguna']->idm_appr;
	  if ($idm_init > 0){
		echo '<button class="btn btn-primary" onclick="kew()" style="margin-left: 808px;margin-bottom: -55px;">Ubah Kewenangan</button>';
		echo '<button class="btn btn-primary" onclick="pos()" value= "1" style=" margin-left: -269px;margin-bottom: -55px;">  Review Jabatan</button>';
	  }else{
		'';
	  } ?>

  <ul class="nav nav-tabs">
    <li class="active"><a href="#propose" data-toggle="tab" style="margin-left: -151px; margin-right: 110px;">Propose ( <?php echo $pending ?> )</a></li>
    <li><a href="#approve" data-toggle="tab" style="margin-left: -109px; margin-right: 110px;">Approve ( <?php echo $approve ?> )</a></li>
    <li><a href="#reject" data-toggle="tab" style="margin-left: -110px; margin-right: 110px;">Reject ( <?php echo $reject ?> ) </a></li>
  </ul>

  <div class="tab-content clearfix" style="background-color: #FFFFFF; margin-left: -150px; margin-right: 199px;">
    <div id="propose" class="tab-pane fade in active">
				<br><br><center><h3 style="padding-bottom: 10px;">Pending</h3></center>
				<div class="block-table table-sorting clearfix"> <!-- block-fluid table-sorting clearfix -->
					<table cellpadding="" cellspacing="2" class="tabel" id="dt_p"style="width: 1091px;height: 60px;" style="width: 1100px;"> 			
						<thead>
							<tr>
								<th>Req ID</th>
								<th>NPP</th>
								<th>Appr Name</th>
								<th>Requestor</th>
								<th>Jenis</th>
								<th>Req Time</th>
								<th>Status</th>	
								<th>Notes</th>									
							</tr>
						</thead>
						<tbody id="vote_buttons" name="vote_buttons">
						</tbody>
					</table>
				</div>
    </div>
    <div id="approve" class="tab-pane fade">
			<br><br><center><h3 style="padding-bottom: 10px;">Approved</h3></center>
			<div class="block-table table-sorting clearfix">
				<table cellpadding="" cellspacing="2" class="tabel" id="dt_app" style="width: 100%"> 			
					<thead>
						<tr>
							<th>Req ID</th>
							<th>NPP</th>
							<th>Appr Name</th>
							<th>Requestor</th>
							<th>Jenis</th>
							<th>Req Time</th>
							<th>Status</th>						
							<th>Notes</th>
						</tr>
					</thead>
						<tbody  id="vote_buttons" name="vote_buttons">
						</tbody>
				</table>
			</div>
    </div>
    <div id="reject" class="tab-pane fade">
 			<br><br><center><h3 style="padding-bottom: 10px;">Rejected</h3></center>
			<div class="block-table table-sorting clearfix">
				<table cellpadding="" cellspacing="2" class="tabel" id="dt_rej" style="width: 100%"> 				
					<thead>
						<tr>
							<th>Req ID</th>
							<th>NPP</th>
							<th>Appr Name</th>
							<th>Requestor</th>
							<th>Jenis</th>
							<th>Req Time</th>
							<th>Status</th>						
							<th>Notes</th>
						</tr>
					</thead>
						<tbody  id="vote_buttons" name="vote_buttons">
						</tbody>
				</table>
			</div>
    </div>
  </div>
</div>
	<style>
        .high {
            color: red;
        }

        .low {
			color: black;
        }
    </style>
	
 	<script type="text/javascript">
		var tab;
		var comm;
		var table;
		var table1;
		var table2;
		
		var idm_init = <?php echo ($_SESSION['pengguna']->idm_init)?>;
		var idm_appr = <?php echo ($_SESSION['pengguna']->idm_appr)?>;
		
		function table_item_click(data){
			if (data['reqtype']=='P'){				
				posisi(data);			
			} else	
			if (data['reqtype']=='K'){
				form_tpos_detail(data);				
			}
		}
		$(function () {
			$('#trx_dt').datetimepicker({
				minDate: new Date()
			});
			$('#ex_dt').datetimepicker({
				minDate: new Date()
			});
			$("#trx_dt").on("dp.change", function (e) {
				$('#ex_dt').data("DateTimePicker").minDate(e.date);
			});
			$("#ex_dt").on("dp.change", function (e) {
				$('#trx_dt').data("DateTimePicker").maxDate(e.date);
			});
		});
		$(document).ready(function() {
		    $(".nav-tabs a").click(function(){
			$(this).tab('show');
			});
			$('.nav-tabs a').on('shown.bs.tab', function(event){
				var x = $(event.target).text();         // active tab
				var y = $(event.relatedTarget).text();  // previous tab
			$(".act span").text(x);
			$(".prev span").text(y);
			});
			$('table.display').dataTable();
			$('#datepicker').datepicker({
                    dateFormat: "dd-mm-yy",
            });

			//datatables
			table = $('#dt_p').DataTable({ 
				

				"processing": true, 
				"serverSide": true, 
				"order": [], 
				"ajax": {
					"url": "<?php echo site_url('homelist/P')?>",
					"type": "POST"
				},
				"columns" : [
				{"data":"id"},
				{"data":"approval"},
				{"data":"accOffice"},
				{"data":"requestor"},
				{"data":"reqtype"},
				{"data":"reqtime"},
				{"data":"status"},
				{"data":"notes"}
				],
				"columnDefs": [
				{  
					"targets": [ -1 ],
					"orderable": false, 
				},
				],
			});
						
			table1 = $('#dt_app').DataTable({ 

				"processing": true, 
				"serverSide": true, 
				"order": [], 
				"ajax": {
						"url": "<?php echo site_url('homelist/A')?>",
					"type": "POST"
				},
				"columns" : [
				{"data":"id"},
				{"data":"approval"},
				{"data":"accOffice"},
				{"data":"requestor"},
				{"data":"reqtype"},
				{"data":"reqtime"},
				{"data":"status"},
				{"data":"notes"}

				],

				"columnDefs": [
				{  
					"targets": [ -1 ], 
					"orderable": false, 
				},
				],
			});
			
			
			table2 = $('#dt_rej').DataTable({ 

				"processing": true, 
				"serverSide": true, 
				"order": [], 
				"ajax": {
					"url": "<?php echo site_url('homelist/R')?>",
					"type": "POST"
				},
				"columns" : [
				{"data":"id"},
				{"data":"approval"},
				{"data":"accOffice"},
				{"data":"requestor"},
				{"data":"reqtype"},
				{"data":"reqtime"},
				{"data":"status"},
				{"data":"notes"}
				],
				"columnDefs": [
				{  
					"targets": [ -1 ], 
					"orderable": false,
				},
				],
			});
						
			$('#dt_p').on('click', 'tr:not(:first)', function () {
				table_item_click(table.row($(this).index()).data());
			});
			
			$('#dt_app').on('click', 'tr:not(:first)', function () {
				table_item_click(table1.row($(this).index()).data());
			});
			
			$('#dt_rej').on('click', 'tr:not(:first)', function () {
				table_item_click(table2.row($(this).index()).data());
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

			
			$("#tposname").autocomplete({  
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
					$('#tposid').val(ui.item.rvalue.positionid);
				}	
			});
		});
		
				$(function () {
			$('#trx_dt').datetimepicker({
				minDate: new Date()
			});
			$('#ex_dt').datetimepicker({
				minDate: new Date()
			});
			$("#trx_dt").on("dp.change", function (e) {
				$('#ex_dt').data("DateTimePicker").minDate(e.date);
			});
			$("#ex_dt").on("dp.change", function (e) {
				$('#trx_dt').data("DateTimePicker").maxDate(e.date);
			});
		});
		function form_tpos_detail(data)
		{
			reqid = data['id'];
			status = data['status'];
			notes = data['notes'];
			reqtype = data['reqtype'];
			$('#form')[0].reset();
			$('.form-group').removeClass('has-error'); 
			$('.help-block').empty(); 

			$.ajax({
				url : "<?php echo site_url('temppos/get/')?>" + reqid,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{			
				$('[name="npp"]').val(data.loginid);
				$('[name="nama"]').val(data.name);
				$('[name="tposname"]').val(data.tposname);
				$('[name="cposname"]').val(data.posname);
				$('[name="tposid"]').val(data.tpos);
				$('[name="tposname"]').val(data.tposname);
				$('[name="trx_dt"]').val(data.sdate);
				$('[name="ex_dt"]').val(data.edate);
				$('[name="id"]').val(data.id);
				$('[name="reqid"]').val(data.reqid);
				$('[name="notes"]').val(notes);
				$('[name="reqtype"]').val(reqtype);
				$('.modal-title').text('Kewenangan'); 
				$('#form_tpos_detail').modal('show');
				$('[name="div_note_kew"]').hide();				
				$('.modal-footer').hide();
				$('[name="divnote"]').show();
				
				$('#comment').DataTable({
					retrieve: true,
					"searching": false,
					"bPaginate": false,
				"ajax": {
					"url": "<?php echo site_url('apprbyid/')?>"+reqid,
					"type": "POST",
					"dataSrc": "notes",
					
				},
				"columns": [
					{"data": "ndate", "order": [[0, 'asc']], "orderable": true },
					{"data": "loginid"},
					{"data": "notes"}
				],
				"columnDefs": [
				{   
				"targets": [ 2 ], 
				"order": [[1, 'desc']], 
				"orderable": true 
				}
				],
			});		
				$("#npp").prop("readonly", true);
					$("#loginid, #nama, #cposname, #tposname, #trx_dt, #ex_dt").prop("readonly", true);
				if (idm_init > 0 && status == 'R'){
					$('.modal-title').text('Kewenangan');
					$("#tposname, #trx_dt, #ex_dt ").prop("readonly", false);
					$('#div_btn_review_comment2, #div_btn_tpos_submit').show();
					$('#div_btn_tpos_appr').hide();
				}else if (idm_init > 0 && status == 'P'|| status == 'A'){
					$('.modal-title').text('Kewenangan');
					$("#tposname").prop('onclick',null).off('click');
					$('#div_btn_review_comment2, #div_btn_tpos_submit, #div_btn_tpos_appr').hide();
				} else 	
				if (idm_appr > 0 && status == 'P'){
					$('.modal-title').text('Kewenangan');
					$("#tposname").prop('onclick',null).off('click');
					$('#div_btn_review_comment, #div_btn_tpos_appr').show();
					$('#div_btn_tpos_submit').hide();
				}else{
					$('.modal-title').text('Kewenangan');
					$("#tposname").prop('onclick',null).off('click');
					$('#div_btn_review_comment, #div_btn_tpos_appr, #div_btn_tpos_submit').hide();
				}
				
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error get data from ajax');
				}
			});
			
		}

		function posisi(rdata)
		{	reqid = rdata['id'];
			status = rdata['status'];
			notes = rdata['notes'];
			reqtype = rdata['reqtype'];
			
			tab = $('#datatable').DataTable({
				destroy: true,
				"createdRow": function (row, data, dataIndex) {
                    if (data['flag'] == 'E') {
                        $(row).addClass("high"); 
                    } else {
                        $(row).addClass("low");
                    }
				}, 
				"ajax": {
					"url": "<?php echo site_url('apprbyid/')?>"+reqid,
					"type": "POST"
				},
				
				"columns": [
					{"data":"id"},
					{"data":"reqid"},
					{"data":"loginid"},
					{"data":"name"},
					{"data":"positionid"},
					{"data":"pname"},
					{"data":"mobileNumber"}
				],
				"columnDefs": [
				{  
					"targets": [ -1 ],
					"orderable": false,
				}
				],
			});
			$('#datatable tbody').on('click', 'td', function () {
				var cidx = $(this).index();
				console.log(cidx);
				var crow  = this.parentNode;
				var data = tab.row(crow).data();
				var fposisi = 1;
				if (cidx != 8){
					edit_posisi(data['id'], fposisi);
				}	
				
			});
			
			
			
			comm = $('#comment2').DataTable({
				destroy: true,
				"ajax": {
					"url": "<?php echo site_url('apprbyid/')?>"+reqid,
					"type": "POST",
					"dataSrc": "notes"
				},
				"columns": [
					{"data": "id"},
					{"data": "ndate"},
					{"data": "ndate"},
					{"data": "loginid"},
					{"data": "notes"},
				],
				"columnDefs": [
				{  
					"targets": [ -1 ],
					"orderable": false,
				}
				],
			});
			

			$('[name="reqid"]').val(reqid);
			$('[name="notes"]').val(notes);
			$('[name="reqtype"]').val(reqtype);
			
			$('.modal-footer').hide();
			 $('.modal-title').text('List Posisi'); 
				if (idm_init > 0 && status == 'R')
					$('#div_btn_review_submit').show();		
				if (idm_appr > 0 && status == 'P')
					$('#div_btn_review_appr').show();
					
			
			if (status == 'P') {
				
               $('#form_tpos_detail_review').modal('show');
			   $('[name="divnote"]').show();
			   $('#div_btn_review_comment').show();
            } else{
			   $('#form_tpos_detail_review').modal('show');
			   $('[name="divnote"]').show();
			   $('#div_btn_review_comment3').show();
			}
		}
		
		function edit_posisi(id, fpos)
		{
			//save_method = 'update';
			$('#form')[0].reset(); 
			$('.form-group').removeClass('has-error');
			$('.help-block').empty(); 
			$.ajax({
				url : "<?php echo site_url('mposition/review/edit/')?>/" + id,
				type: "GET",
				dataType: "JSON",
				
				success: function(data)
				{
						$('[name="id"]').val(data.id);
						$('[name="accOffice"]').val(data.accOffice);
						$('[name="npp"]').val(data.loginid);
						$('[name="name"]').val(data.name);
						$('[name="mobileNumber"]').val(data.mobileNumber);
						$('[name="pname"]').val(data.pname);
						$('[name="positionid"]').val(data.positionid);			

					if (fpos == 0){
						$('[name="id"], [name="accOffice"],  [name="name"], [name="mobileNumber"], [name="pname"]').prop("readonly", false);
						$('#div_btn_admin').show();
						$('#form_tpos_detail_review_item').modal('show');
						$('.modal-title').text('List Posisi'); 
					}else{
						if (idm_init > 0 && status == 'R') {
							$('[name="id"], [name="accOffice"],  [name="name"], [name="mobileNumber"], [name="pname"]').prop("readonly", false);
							$('#div_btn_admin').show();
							$('#div_btn_review_comment3').show();
						}  else{
							$('[name="id"], [name="accOffice"], [name="npp"], [name="name"], [name="mobileNumber"], [name="pname"], [name="positionid"]').prop("readonly", true);
							$('#div_btn_admin').hide();
							$('#div_btn_review_comment3').hide();
						}
						$('#form_tpos_detail_review_item').modal('show');
						$('.modal-title').text('List Posisi'); 
					}
						
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error get data from ajax');
				}
			});
		}

		
function reload_table()
		{
			table.ajax.reload(null,false); 
		}
		
		
		function tolak(){
				$('#modal_comment').modal('show');
				reload_table();
		}
		
		function cancel()
		{
			$.ajax({
				url : "<?php echo site_url('mposition/approval/reject')?>",
				type: "POST",
				data: $('#form_1').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					$('#modal_comment').modal('hide');
						alert('This data has been Rejected');
						$('#form_tpos_detail').modal('hide');
						$('#form_tpos_detail_review').modal('hide');
						reload_table();
						window.location.reload()
					if(data.status)
					{
						
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
					alert('Error adding / updating data');
					$('#btnSave').text('save'); 
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
	function approve()
	{
		$('#btnSave').text('saving...'); 
		$('#btnSave').attr('disabled',true); 
		$.ajax({
			url : "<?php echo site_url('mposition/approval/approve')?>",
			type: "POST",
			data: $('#reqid').serialize(),
			dataType: "JSON",
			success: function(data)
			{
				alert('This data has been approved');
					$('#modal_form').modal('hide');
					$('#modal_formil').modal('hide');
					reload_table();
					window.location.reload()
				if(data.status) 
				{
					
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
				alert('Error adding / updating data');
				$('#btnSave').text('save'); 
				$('#btnSave').attr('disabled',false); 
			}
		});
	}
	function save()
		{
			$('#btnSave').text('saving...'); 
			$('#btnSave').attr('disabled',true);  
			var url = "<?php echo site_url('mposition/review/update')?>";
			//var $datatable = ;

			$.ajax({
				url : url,
				type: "POST",
				data: $('#form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					$('#form_tpos_detail_review_item').modal('hide');
					tab.ajax.reload();
					if(data.status) 
					{
					}
					else
					{
						for (var i = 0; i < data.inputerror.length; i++) 
						{
							$('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
							$('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
						}
					};
					$('#btnSave').text('save'); 
					$('#btnSave').attr('disabled',false); 
					//location.reload();
				},
				
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error adding / update data');
					$('#btnSave').text('save'); 
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
		function update()
		{
			$.ajax({
				url : "<?php echo site_url('mposition/approval/propose')?>",
				type: "POST",
				data: $('#form_1').serialize(),
				
				dataType: "JSON",
				success: function(data)
				{
					alert('This data has been update');
					$('#modal_form').modal('hide');
					reload_table();
					location.reload();
					if(data.status) 
					{
						alert('This data has been update');
						$('#modal_form').modal('hide');
						reload_table();
						location.reload();
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
					location.reload();
				},
				
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error adding / updating data');
					$('#btnSave').text('save'); //change button text
					$('#btnSave').attr('disabled',false); //set button enable 
				}
			});
		}
		
		function query_id()
		{		
			var url = "<?php echo site_url('mposition/temppos/query')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: $('#form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					$('[name="nama"]').val(data.name);
					$('[name="cposname"]').val(data.nama);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
		
		function batal()
		{
			$.ajax({
				url : "<?php echo site_url('mposition/approval/cancel')?>",
				type: "POST",
				data: $('#reqid').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					alert('This data has been canceled');
					$('#modal_formil').modal('hide');
					reload_table();
					location.reload();
					if(data.status) 
					{
						
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
					location.reload();
				},
				
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error adding / updating data');
					$('#btnSave').text('save'); 
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
/* 			$("#datatable pname").autocomplete({  
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
			});		 */
		function pos()
		{	
			
			save_method = 'pos';
			tab = $('#datatable').DataTable({
				retrieve: true,
				"ajax": {
					"url": "<?php echo site_url('mposition/review/pos_list')?>",
					"type": "POST"
				},
				"columns": [
					{"data":"id"},
					{"data":"reqid"},
					{"data":"loginid"},
					{"data":"positionid"},
					{"data":"pname"},
					{"data":"mobileNumber"},
				],
				"columnDefs": [
				{  
					"targets": [ -1 ],
					"orderable": false,
				}
				],
			});
			$('#datatable').on('draw.dt', function() {
			$(this).Tabledit({
			url : "<?php echo site_url('mposition/review/update')?>",
			columns: {
            identifier: [[0, 'id'], [1, 'reqid'], [2, 'loginid'], [3, 'positionid']],
            editable: [ [4, 'pname','{"1": "PNJ-2-ASISTEN OPERASIONAL", "2": "Green", "3": "Blue"}'], [5, 'mobileNumber']]
			},
    });
});


			$('.modal-title').text('List Posisi'); 
			$('#form_tpos_detail_review').modal('show');
			$('[name="divnote"]').hide();
			$('#div_btn_submit').show();
			$('#div_btn_review_comment2').hide();
			$('#div_btn_review_comment').hide();
			$('#div_btn_review_appr').hide();
			$('#div_btn_review_submit').hide();
		}
		
 		function kew()
		{
				$('#form_1')[0].reset();
				$('.modal-title').text('Kewenangan'); 				
				$('[name="npp"], [name="tposname"], [name="trx_dt"], [name="ex_dt"], [name="accOffice"], [name="nama"], [name="cposname"]').prop("readonly", false );
				$('#form_tpos_detail').modal('show');
				$('[name="divnote"], #div_btn_tpos_submit, #div_btn_tpos_appr').hide();
				$('#div_btn_kew, [name="div_note_kew"]').show();
				reload_table();
		} 
		function query_id()
		{		
			var url = "<?php echo site_url('mposition/temppos/query')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: $('#npp').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					$('[name="nama"]').val(data.name);
					$('[name="cposname"]').val(data.nama);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
		
		function save_request()
		{			
			var url = "<?php echo site_url('mposition/temppos/add')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: $('[id="form_1"]').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					alert('Data has been saved');
					window.location.reload();
				},				
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error adding / updating data'); 
					$('#btnSave').attr('disabled',false); 
				}
			});
		}	
		function add()
		{
			var url = "<?php echo site_url('mposition/review/add')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: $('[id="form_1"]').serialize(),
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
	</script>
		
	<div class="modal fade" id="form_tpos_detail" role="dialog">
		<div class="modal-dialog ui-front">
			<div class="modal-content" style="padding: 10px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" style="padding-left: 190px;">KEWENANGAN</h3>
				</div>
				<div class="modal-body form">
					<form action="#" id="form_1" class="form-horizontal"> 				
						<div class="form-group row">
							<div class="col-md-4">
								<label>No User</label>
								<input name="npp" onchange="query_id()" id="npp" placeholder="No User" class=" form-control" type="text" >
							</div>
							<div class="col-md-8">
								<label>Nama</label>
								<input name="nama" id="nama" placeholder="Nama" class="form-control" type="text" >
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<label>Posisi Sekarang</label>					        
								<input name="cposname" id="cposname" placeholder="cposname" class="form-control" type="text" >
								<input name="cposid" id="cposid" type="hidden" readonly="true">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<label>Posisi Target</label>
								<input name="tposname" id="tposname" placeholder="--- Posisi ---" class="autocomplete form-control" type="text" onclick="$(this).val(''); $('#tposid').val('');" >
								<input name="tposid" id="tposid" type="hidden" readonly="true">
							</div>
						</div>						
						<div class="form-group row">
							<div class="col-xs-6">
								<label>Tanggal Efektif</label>
								<input name="trx_dt" id="trx_dt" placeholder="Tanggal Efektif" class="form-control" type="text" >
							</div>
							<div class="col-xs-6">
								<label>Tanggal Expired</label>
								<input name="ex_dt" id="ex_dt" class="form-control" type="text" >
							</div>										
						</div>
						<div class="form-group row" name = "divnote">
							<div class="col-md-12">
								<br/>
								<label>Comment History</label>
								<div class="block-table table-sorting clearfix">
									<table cellpadding="" cellspacing="2" class="tabel" id="comment" style="width: 100%; "> 		
										<thead>
											<tr>
												<th>Tanggal</th>
												<th>LoginID</th>						
												<th>Comment</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="form-group" name="div_note_kew">
							<div class="col-md-12">
								<label>Notes</label>
								<input name="notes" id="notes" placeholder="Notes" class="form-control" type="text">
							</div>
						</div>
						<input name="status" id="status" class="form-control" type="hidden" >
						<input name="id" id="id" class="form-control" type="hidden" >
						<input name="reqid" id="reqid" class="form-control" type="hidden" >		
						<input name="reqtype" id="reqtype" class="form-control" type="hidden" >						
						<div class="modal-footer" id="div_btn_tpos_appr">
							<button type="button" id="btnapprove" onclick="approve()" class="btn btn-primary">Approve</button>
							<button type="button" id="btntolak" onclick="tolak()"class="btn btn-warning">Reject</button>
						</div>
					<div class="modal-footer" id="div_btn_tpos_submit">
						<button type="button" id="btntolak" onclick="tolak()" class="btn btn-primary">Submit</button>
						<button type="button" id="btnbatal" onclick="batal()"class="btn btn-warning right">Cancel</button>
					</div>
					<div class="modal-footer" id="div_btn_kew">
					<button type="button" id="btnSave" onclick="save_request()" class="btn btn-success">Submit</button>
					<button type="reset" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
					</form>
				</div>	
			</div>
		</div>
	</div>

    <div class="container" >	
		<div class="modal fade" id="form_tpos_detail_review" role="dialog" style="padding-left: 300px;" >
			<div class="modal-dialog ui-front" >
				<div class="modal-content" style="padding: 10px; width: 828px; border-left-width: 0px; left: -127px;">
				<input name="reqid" id="reqid" class="form-control" type="hidden" >
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title" style="padding-left: 284px;">POSISI</h3>
					</div>
					<div class="modal-body form">
						<div class="block-table table-sorting clearfix">
							<table cellpadding="" cellspacing="2" class="tabel" id="datatable" style="width: 100%;" >		
								<thead>
									<tr>
										<th>No</th>
										<th>Req ID</th>
										<th>NPP</th>
										<th>Posisi ID</th>
										<th>Posisi</th>						
										<th>No HP</th>
										<th>Action</th>
									</tr>
								</thead>
									<tbody>
									</tbody>
							</table>
						<input name="reqtype" id="reqtype" class="form-control" type="hidden" >
	
						</div>
											<div class="form-group row" name = "divnote">
							<div class="col-md-12">
								<br/>
								<label>Comment History</label>
								<div class="block-table table-sorting clearfix">
									<table cellpadding="" cellspacing="2" class="tabel" id="comment2" style="width: 100%; "> 		
										<thead>
											<tr>
												<th>No</th>
												<th>Tanggal</th>
												<th>Jam</th>
												<th>LoginID</th>						
												<th>Comment</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="modal-footer" id="div_btn_review_appr">
							<button type="button" id="btnapprove" onclick="approve()" class="btn btn-primary">Approve</button>
							<button type="button" id="btntolak" onclick="tolak()"class="btn btn-warning">Reject</button>
						</div>
					<div class="modal-footer" id="div_btn_review_submit">
						<button type="button" id="btntolak" onclick="tolak()" class="btn btn-primary">Submit</button>
						<button type="button" id="btnbatal" onclick="batal()"class="btn btn-warning right">Cancel</button>
					</div>
					<div class="modal-footer" id="div_btn_submit">
						<button type="button" id="btntolak" onclick="tolak()" class="btn btn-primary">Submit</button>
					</div>
					</div>	
				</div>
			</div>	
		</div>	
	</div>	
	
	
	<div class="modal fade" id="form_tpos_detail_review_item" role="dialog">
		<div class="modal-dialog ui-front">
			<div class="modal-content" style="padding: 10px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" style="padding-left: 190px;">Form Pegawai</h3>
				</div>
				<div class="modal-body form">
					<form action="#" id="form" class="form-horizontal">
						<input type="hidden" value="" name="id"/> 
						<div class="form-body">
							<div class="form-group">
								<label for="npp">NPP</label>
								<input name="npp" placeholder="NPP" class=" form-control" type="text" readonly="readonly">
							</div>
							<div class="form-group"> 
								<label class="control-label">Nama</label>
								<input name="name" placeholder="Nama" class="form-control" type="text"></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Posisi</label>
								<input id="pname" name="pname" placeholder="--- Posisi ----" class="autocomplete form-control" type="text" onclick="$(this).val('');"/>   
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
				<div class="modal-footer" id="div_btn_admin">
					<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Submit</button>
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
					<form action="#" id="form_1" class="form-horizontal"> 				
						<div class="form-group row">
							<div class="col-md-6">
								<label>You reject this data because : </label>
								<textarea style="width: 441px;"name="note" id="note" class=" form-control" value = "" ="10" type="text"></textarea>
							</div>
						<input name="id" id="id" class="form-control" type="hidden" >
						<input name="reqid" id="reqid" class="form-control" type="hidden" >		
						<input name="reqtype" id="reqtype" class="form-control" type="hidden" >	
						</div>					
					</form>
				</div>	
				<div class="modal-footer" id="div_btn_review_comment">
						<button type="button" id="btncancel" onclick="cancel()"class="btn btn-warning">Submit 1</button>
				</div>
				<div class="modal-footer" id="div_btn_review_comment2">
						<button type="button" id="btnupdate" onclick="update()" class="btn btn-warning">Submit2</button>
				</div>
				<div class="modal-footer" id="div_btn_review_comment3">
						<button type="button" id="btnadd" onclick="add()" class="btn btn-warning" value="P">Submit3</button>
				</div>
			</div>
		</div>
	</div>
</div>	
	
</body>
</html>