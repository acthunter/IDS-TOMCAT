<script type="text/javascript">
var counter = 1;
var tabel;
var status;
	var tab_myjob;	
	var form_db = {};
	var pname = {RP : "Review Position", CT: "Posisi Sementara ", CP: "Posisi Permanen", CU: "Ubah Unit", UA: "Tambah User", RS: "Reset Target", UC: "Cek User", CL: "Change Level", CI: "Create iCONS" };
	function clearform_db(){
		form_db = {};
	}
	
$(document).ready(function(){
			load_tabel();

		$('#btn-filter').click(function(){ //button filter event click
			tabel.search($('#request').val()).draw();
			//tabel.ajax.reload();  //just reload table
		});
		$('#btn-refresh').click(function(){ //button filter event click
			tabel.ajax.reload();  //just reload table
		});
				$('#dt_req_list tbody').on('click', 'button.resend' , function () {
				
				var rdata = tabel.row( $(this).parents('tr') ).data();
				/* var fparam = {'id' : rdata['id'], "mode" : rdata['mode']}; */
				var fparam = {'loginid' : rdata['user_req'], "reqid" : rdata['id']};
				$.ajax({
					url: "<?php echo site_url('idadmin/xmain/resend')?>",
					type: "POST",
					data: fparam,
					dataType: "JSON",
					success: function(data){
						if (data['status'] == 'success'){
							var text = 'Data telah di proses Kembali !';
							var type = 'success';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						tabel.ajax.reload( null, false );
						}else{
							var text = 'Data tidak dapat diproses !';
							var type = 'error';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						}
					}
				});
				cek();
		});
		$('#dt_req_list tbody').on('click', 'button.process' , function () {
				alert("ok");
				var rdata = tabel.row( $(this).parents('tr') ).data();
				var fparam = {'loginid' : rdata['user_req'], "reqid" : rdata['id']};
				$.ajax({
					url: "<?php echo site_url('idadmin/xmain/process')?>",
					type: "POST",
					data: fparam,
					dataType: "JSON",
					success: function(data){
						if (data['status'] == 'success'){
							var text = 'Ibank sedang diproses !';
							var type = 'success';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						tabel.ajax.reload( null, false );
						}else{
							var text = 'Reset Ibank tidak dapat diproses !';
							var type = 'error';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						}
					}
				});
				/* console.log(tabel.row( $(this).parents('tr') ).data());
				//console.log($('td', tabel.row( this )));
				$('#dt_req_list tbody tr td').css('color', 'blue'); */
				//$(this).addClass('selected').css('color', 'blue');  
				//$(this).css("background-color", "#eeeeee");

		});
		$('#dt_req_list tbody').on('click', 'button.reload' , function () {
				
				var rdata = tabel.row( $(this).parents('tr') ).data();
				/* var fparam = {'id' : rdata['id'], "mode" : rdata['mode']}; */
				var fparam = {'loginid' : rdata['user_req'], "reqid" : rdata['id']};
				$.ajax({
					url: "<?php echo site_url('idadmin/xmain/reloadlist')?>",
					type: "POST",
					data: fparam,
					dataType: "JSON",
					success: function(data){
						if (data['status'] == 'success'){
							var text = 'Data telah di proses Kembali !';
							var type = 'success';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						tabel.ajax.reload( null, false );
						}else{
							var text = 'Data tidak dapat diproses !';
							var type = 'error';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						}
					}
				});
				cek();
		});
	$('#dt_req_list tbody').on('click', 'button.reloadval' , function () {
				
				var rdata = tabel.row( $(this).parents('tr') ).data();
				/* var fparam = {'id' : rdata['id'], "mode" : rdata['mode']}; */
				var fparam = {'loginid' : rdata['user_req'], "reqid" : rdata['id']};
				$.ajax({
					url: "<?php echo site_url('idadmin/xmain/reloadval')?>",
					type: "POST",
					data: fparam,
					dataType: "JSON",
					success: function(data){
						if (data['status'] == 'success'){
							var text = 'Data telah di proses Kembali !';
							var type = 'success';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						tabel.ajax.reload( null, false );
						}else{
							var text = 'Data tidak dapat diproses !';
							var type = 'error';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						}
					}
				});
				cek();
		});
		
		$('#dt_req_list tbody').on('click', 'button.cancelreq' , function () {
				 
				
			var result = confirm("Are you sure you want to delete this request?");
			if (result) {
				var rdata = tabel.row( $(this).parents('tr') ).data();
				/* var fparam = {'id' : rdata['id'], "mode" : rdata['mode']}; */
				var fparam = {'loginid' : rdata['user_req'], "reqid" : rdata['id']};
				$.ajax({
					url: "<?php echo site_url('idadmin/xmain/deletereq')?>",
					type: "POST",
					data: fparam,
					dataType: "JSON",
					success: function(data){
						if (data['status'] == 'success'){
							var text = 'Data telah di cancel !';
							var type = 'success';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						tabel.ajax.reload( null, false );
						}else{
							var text = 'Data tidak dapat diproses !';
							var type = 'error';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						}
					}
				});
				cek();
			}
		});
		
		$('#dt_req_list tbody').on('click', 'button.randpass' , function () {
				alert("ok");
				var rdata = tabel.row( $(this).parents('tr') ).data();
				var fparam = {'loginid' : rdata['user_req'], "reqid" : rdata['id']};
				$.ajax({
					url: "<?php echo site_url('idadmin/xmain/randpass')?>",
					type: "POST",
					data: fparam,
					dataType: "JSON",
					success: function(data){
						if (data['status'] == 'success'){
							var text = 'Password telah diacak kembali !';
							var type = 'success';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						tabel.ajax.reload( null, false );
						}else{
							var text = 'Password sedang dalam proses, mohon ditunggu !';
							var type = 'error';
							new PNotify({
								title: 'Notifikasi',
								text: text,
								type: type,
								styling: 'bootstrap3'
							});
						}
					}
				});
				/* console.log(tabel.row( $(this).parents('tr') ).data());
				//console.log($('td', tabel.row( this )));
				$('#dt_req_list tbody tr td').css('color', 'blue'); */
				//$(this).addClass('selected').css('color', 'blue');  
				//$(this).css("background-color", "#eeeeee");

		});
	});
	function update_detail_modal(modal_id, fdata){
		 var h_modal_content_id = modal_id + "_trigger";
		 var fn = window[h_modal_content_id];
		 fn(fdata);
	};
	
	 function showModal(modal_id, fdata, content, isfirstload){
		  var h_modal_id = "#" + modal_id;
		 $(h_modal_id).html(content);
		$(h_modal_id + "_content").modal({show:true});
		
		$(h_modal_id + "_content").on("hide.bs.modal", function(event){
				 console.log(event);
				 //$(h_modal_id + "_content").empty();
				 if (event.currentTarget.id == "modal_l1_content"){
					 //window['modal_l1_reload']();
					  tab_myjob.ajax.reload(null, false);
				 }
			 });
		
		$(h_modal_id + "_content").modal({show:true});
		 
		update_detail_modal(modal_id, fdata);

	 }
	 
	 function loadForm(modal_id, fdata, isupdate){
	 console.log(fdata);
	  var url = "<?php echo site_url('form')?>";
	  var h_modal_id = "#" + modal_id;
		// jQuery('#modellink').click(function(e) {
			 $(h_modal_id).empty();
			 var form_id = modal_id + "." + fdata['mode'];
			 var cform = form_db[form_id];
			 fdata['modal_id'] = modal_id;
			 if (cform == null){
				 $(h_modal_id).load(url, fdata, function(result){
					 //adjust table
					 form_db[form_id] = result;
					 cform = form_db[form_id];
					 showModal(modal_id, fdata, cform, true);
				});
			 } else {
				 showModal(modal_id, fdata, cform, false);
			 } 
			  
			
		// });
	 }
	 
	 function action_submit(fdata){
		
		var reason = "";
		var isMandatory = ("reject,cancel".indexOf(fdata['btype']) != -1);
		var hmodal_id = '#' + fdata['modal_id'];
		
		console.log(fdata);
		console.log(fdata['btype']);
		if (isMandatory){
			reason = prompt("Alasan", "");
			if (reason == null || reason.length < 2){
				return;
			}
		}
		
		$('#notes').val(reason);
		$(hmodal_id + ' #reqtype').val(fdata['btype']);
		
		var fxdata = $(hmodal_id + '_form').serialize();
		
		var url = "<?php echo site_url('')?>" + fdata['url'] ;
		$.ajax({
			url : url,
			type: "POST",
			data: fxdata,
			dataType: "JSON",
			success: function(data)
			{
				$('[name="nama"]').val(data.name);
				$('[name="cposname"]').val(data.nama);
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Submit Fail');
				$('#btnSave').attr('disabled',false); 
			}
		});
		$('#' + fdata['modal_id'] + '_content').modal('hide');
		console.log(fdata['btype']);
		if (fdata['btype'] == 'save'){
			var text = 'Data Berhasil ditambahkan !';
			var type = 'success';
		}else if (fdata['btype'] == 'submit'){
			var text = 'Data telah di Proses !';
			var type = 'success';
		}else if (fdata['btype'] == 'approve'){
			var text = 'Data telah di Approve !';
			var type = 'success';
		}else if (fdata['btype'] == 'reject'){
			var text = 'Data telah di Reject !';
			var type = 'success';
		}else if (fdata['btype'] == 'cancel'){
			var text = 'Data telah di Cancel !';
			var type = 'success';
		}else if (fdata['btype'] == 'release'){
			var text = 'Data telah di Release !';
			var type = 'info';
		}else if (fdata['btype'] == 'batal'){
			var text = 'Data telah di Cancel !';
			var type = 'success';
		}
		new PNotify({
				title: 'Notifikasi',
				text: text,
				type: type,
				styling: 'bootstrap3'
			});
	}
	 
	 
	function arrFlat(arr){
		var ret = "";
		for (var key of arr) {
			ret += "<li class='auth'>" + key + "</li>";
		}
		return ret ;
	}
	function jsonFlat(jstr){
		var obj = jstr;
		var ret = "";
		for (var key in obj) {
			ret += "<li class='auth auth_" + obj[key] + "'>" + key + "</li>";
		}
		return ret ;
	}
	function arrFlatStr(astr){
		if (astr == null)
			return "";
		var obj = astr.split(",");
		return arrFlat(obj);
	} 
	function load_tabel(status){
		console.log(status);
		
		tabel = $('#dt_req_list').DataTable({ 
			"destroy": true,
				"searching": false,
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, 
				"order": [], 
				
				"aLengthMenu": [[ 10, 25, 50, -1], [ 10, 25, 50, "All"]],
				"iDisplayLength": 10,
				
							"ajax": {
								"url": "<?php echo site_url('idadmin/xmain/getreq')?>" ,
								"type": "POST",
								"dataType": "JSON",
								"data" : function ( data ) { 
									data.request = $('#request').val();
									data.status = $('#status').find(":selected").val();
									data.typereq = $('#typer').find(":selected").val();
								}
							},
							"columns" : [
								/* {"data":"id",},
								{"data":"no_srt"},
								{"data":"tgl_srt"},
								{"data":"user_req"},
								{"data":"unit"},
								{"data":"staff"},
								{"data":"send_pass"},
								{"data":"status"} */
								{"data":"id"},
								{"data":"tgl_request"},
								{"data":"typereq"},
								{"data":"no_srt"},
								{"data":"tgl_srt"},
								{"data":"user_req"},
								{"data":"apps"},
								{"data":"status"},
								{"data":"received"},
								{"data":"req_stat"},
								{"data":"reqid",
								visible: false},
								{"data":"stat",
								visible: false},
								{"data":"statpass",
								visible: false},
								{"data":"userlock",
								visible: false}
								
							],
							"rowCallback": function( row, data, index ) {
								console.log($('td', row));
								console.log($('td', row));
								if (data['stat']=='1'){
										$('td', row).css('color', 'green'); 
									}else{
										if (data['status']!='S'){
											if (data['typereq']=='ss' && ((data['apps'].indexOf('ibank') != -1) || (data['apps'].indexOf('gotrade') != -1))&& data['userlock'] == null) {
												$('td', row).css('color', 'Blue');
											}else{
												$('td', row).css('color', 'Red');
											}
											
										}
									}
							},
							"columnDefs": [
							{  
								"targets": [ 0 ], //first column / numbering column
								"orderable": false,
							},
							{  
								"targets": [ 2 ],
								"render": function(data,type, row){
								if (row['typereq']=='sr'){
										var step = 'Surat';
								}else if (row['typereq']=='rm'){
										var step = 'Remedy';
								}else if (row['typereq']=='cm'){
										var step = 'Member';
								}else{
										var step = 'Self Service';
								}
									return step;
								}, 
							},
							/* {  
								"targets": [ 7 ],
								"render": function(data,type, row){
								if (row['status']=='1'){
										var step = 'Password diterima';
								}else{
										var step = 'Password Dikirim';
								}
									return step;
								}, 
							},
							{  
								"targets": [ 8 ],
								"render": function(data,type, row){
									if (row['status']=='1'){
										var step = 'Selesai';
								}else{
										var step = '<button type="button" class="btn btn-warning resend" id="btn-resend"> Resend Email</button>';
								}
									return step;
								}, 
							}, */
														{  
								"targets": [ 6],
								"render": function(data,type, row){
									var step = row['apps'];
									return step;
								}, 
							},
							{  
								"targets": [ 7 ],
								"render": function(data,type, row){
									if (row['stat']=='1'){
										var step = 'Password accepted';
									}else{
										if (row['status']=='S'){
											var step = 'Delivery Password';
										}else{
											if (row['statpass']=='T'){
												var step = 'Pending';
											}else{
												var step = 'On Process';
											}	
										}
									}
									/* if (row['status']=='1'){
										var step = 'Selesai';
									}else{
										if (row['status']=='S'){
											var step = 'Delivery Password';
										}else{
											var step = 'On Process';
										}
									} */
									return step;
								}, 
							},
							{  
								"targets": [ 8 ],
								"render": function(data,type, row){
									if (row['stat']=='1'){
										var step = row['received'];
									}else{
										var step = '-';
									}
									return step;
								}, 
							},
							{  
								"targets": [ 9 ],
								"render": function(data,type, row){
									if (row['status']=='S'){
										if (row['stat']=='1'){
											var step = '-';
										}else{
											var step = '<button type="button" class="btn btn-warning resend" id="btn-resend">Send Email</button>';
										}
									}else{
										if (row['typereq']=='ss'){
											if (((row['apps'].indexOf('ibank') != -1) || (row['apps'].indexOf('gotrade') != -1)) && row['userlock'] == null) {
												var step = '<button type="button" class="btn btn-success process" id="btn-process" data-toggle="tooltip" data-placement="top" title="Password Process"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></button>   <button type="button" class="btn btn-danger cancelreq" id="btn-cancelreq" data-toggle="tooltip" data-placement="top" title="Cancel Request"><i class="fa fa-trash" aria-hidden="true"></i></button>';
											}else if (row['apps'].indexOf('globs') != -1){
												var step = '<button type="button" class="btn btn-info reload" id="btn-backlist" data-toggle="tooltip" data-placement="top" title="Back To list"><i class="fa fa-refresh" aria-hidden="true"></i></button>     <button type="button" class="btn btn-warning randpass" id="btn-randpass" data-toggle="tooltip" data-placement="top" title="Random Password"><i class="fa fa-random" aria-hidden="true"></i></button>    <button type="button" class="btn btn-danger cancelreq" id="btn-cancelreq" data-toggle="tooltip" data-placement="top" title="Cancel Request"><i class="fa fa-trash" aria-hidden="true"></i></button>';
											}else if (row['statpass']=='T'){
												var step = "-";
											}else{
												var step = '<button type="button" class="btn btn-info reload" id="btn-backlist" data-toggle="tooltip" data-placement="top" title="Back To list"><i class="fa fa-refresh" aria-hidden="true"></i></button>   <button type="button" class="btn btn-danger cancelreq" id="btn-cancelreq" data-toggle="tooltip" data-placement="top" title="Cancel Request"><i class="fa fa-trash" aria-hidden="true"></i></button>';
											} 
										}else{
											/* if (row['apps'].indexOf('ibank') != -1 && row['userlock'] == null) {
												var step = '<button type="button" class="btn btn-success process" id="btn-process" data-toggle="tooltip" data-placement="top" title="Password Process"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></button><button type="button" class="btn btn-default reloadval" id="btn-backval" data-toggle="tooltip" data-placement="top" title="Back To Validate"><i class="fa fa-check-circle"></i></button>';
											}else */ if (row['statpass']=='T'){
												var step = "-"
											}else{
												if (row['apps'].indexOf('globs') != -1){
													var step = '<button type="button" class="btn btn-info reload" id="btn-backlist" data-toggle="tooltip" data-placement="top" title="Back To list"><i class="fa fa-refresh" aria-hidden="true"></i></button>   <button type="button" class="btn btn-default reloadval" id="btn-backval" data-toggle="tooltip" data-placement="top" title="Back To Validate"><i class="fa fa-check-circle"></i></button>     <button type="button" class="btn btn-warning randpass" id="btn-randpass" data-toggle="tooltip" data-placement="top" title="Random Password"><i class="fa fa-random" aria-hidden="true"></i></button>';
												}else{
													var step = '<button type="button" class="btn btn-info reload" id="btn-backlist" data-toggle="tooltip" data-placement="top" title="Back To list"><i class="fa fa-refresh" aria-hidden="true"></i></button>   <button type="button" class="btn btn-default reloadval" id="btn-backval" data-toggle="tooltip" data-placement="top" title="Back To Validate"><i class="fa fa-check-circle"></i></button>';
												}
											}
										}
									}
																		
									return step;
								}, 
							},

						]
					});
	}	
$(document).on('change', '#status', function(){
	  status = $(this).val();
	  if(status != '')
	  {
	    tabel.search(status).draw();
	  }
	  else
	  {
	   tabel.ajax.reload();
	  }
	 });
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
	width: 500px;
	margin-left: 2%;
	display: block;
}
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
button{
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
}
#content{
	width: auto;
    min-width: 0;
}
.container{
	width: '';
    min-width: 0;
}

</style>

<div class="panel panel-default" style="margin: 0 auto;min-width: 350px;padding: 10px;">
<div class="panel panel-default">
  <div class="panel-body">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
            <div class="input-group" id="adv-search">
                <input type="text" id="request" class="form-control" placeholder="Search Request" />
                <div class="input-group-btn">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary" id="btn-filter"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button> 
                    </div>
					<div class="btn-group" role="group" style="margin-left: 3px;">
                        <button type="button" class="btn btn-success" id="btn-refresh"><span class=" glyphicon glyphicon-refresh " aria-hidden="true"></span></button>
                    </div>
                </div>
            </div>
          </div>
        </div>
	</div>
  <div class="panel-body">
		<table cellpadding="" cellspacing="2" class="cell-border" id="dt_req_list" style="width: 100%"> 			
					<thead>
						<tr>
							<th>Id</th>
							<th>Tgl Request</th>
							<th>
								<select name="typer" id="typer" class="form-control">
									<option value="">Tipe Request</option>
									<option value="cm">Member</option>
									<option value="sr">Surat</option>
									<option value="rm">Remedy</option>
									<option value="ss">Self Service</option>
								</select></th>
							<th>No Surat</th>
							<th>Tgl Kirim </th>
							<th>Npp</th>
							<th>Aplikasi</th>
							<th>
								<select name="status" id="status" class="form-control">
									<option value="">Status Search</option>
									<option value="1">Password Accepted</option>
									<option value="S">Delivery Password</option>
									<option value="T" selected>On Process</option>
									<option value="P">Pending</option>
								</select>
						   </th>
						   <th>Received</th>
							<th>Action</th>
						</tr>
					</thead>
						<tbody  id="vote_buttons" name="vote_buttons">
						</tbody>
					<tfoot>
						<tr>
							<th>Id</th>
							<th>Tgl Request </th>
							<th>Tipe Request</th>
							<th>No Surat</th>
							<th>Tgl Surat </th>
							<th>Npp</th>
							<th>Aplikasi</th>
							<th>Status</th>
							<th>Received</th>
							<th>Action</th>
						</tr>
					</tfoot>
		</table>
  </div>
			
  </div>
</div>

