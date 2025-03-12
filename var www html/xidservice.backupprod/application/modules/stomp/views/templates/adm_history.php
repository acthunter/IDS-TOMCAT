<!--<script src="/tstomp/bucky.js" data-bucky-host="/bucky" data-bucky-page="idssite-itservice"/>-->
<script type="text/javascript">
var counter = 1;
	var tab_myjob;	
	var form_db = {};
	var pname = {RP : "Review Position", CT: "Posisi Sementara ", CP: "Posisi Permanen", CU: "Ubah Unit", UA: "Tambah User", RS: "Reset Target", UC: "Cek User", CL: "Change Level", CI: "Create iCONS", UH: "Update No Handphone" };
	function clearform_db(){
		form_db = {};
	}
$(document).ready(function(){
	$('#date').datetimepicker({
            ignoreReadonly: true, widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('YYYY-MM-DD ');
			tabel = $('#dt_rp_list').DataTable({ 
			"destroy": true,
				"searching": false,
				"serverSide": true, 
				"order": [], 
				"aLengthMenu": [[ 5, 25, 50, -1], [ 10, 25, 50, "All"]],
				"iDisplayLength": 5,
							"ajax": {
								"url": "<?php echo site_url('stomp/xids/getadm_test')?>" ,
								"type": "POST",
								"dataType": "JSON",
								"data" : function ( data ) {
									data.pemohon = $('#pemohon').val();
									data.date = $('#date').val();
									data.req = $('#req').val();
								}
							},
							"columns" : [
								{"data":"id",},
								{"data":"mode"},
								{"data":"cdate"},
								{"data":"name"},
								{"data":"currActor"},
								{"data":"list_npp"},
								{"data":"apv"},
								{"data":"dateapv"},
								{"data":"stage",  "visible":false}
								
							],
							"columnDefs": [
							{  
								"targets": [ 0 ], //first column / numbering column
								"orderable": false,
							},
							{  
								"targets": [ 1 ],
								"render": function(data,type, row){
									var step = (row['stage']=='1') ? 'Init' : 'Approve'; 
									switch (row['mode']){
										case 'UA':
											var pname = 'User Add';
											break;
										case 'CU':
											var pname = 'Change Unit';
											break;
										case 'CP':
											var pname = 'Change Position Permanent';
											break;
										case 'CT':
											var pname = 'Change Position Temprorer';
											break;
										case 'RP':
											var pname = 'Review Position';
											break;
										case 'CI':
											var pname = 'Create Icons';
											break;
										case 'UH':
											var pname = 'Update No Handphone';
											break;
										case 'CL':
											var pname = 'Level Kapabilitas';
											break;
										default:
											var step = 'Request Canceled';
									}
									return step + ' - ' + pname;
								}, 
							},
							{  
								"targets": [ 3 ],
								"render": function(data,type, row){
									var step = (row['name']); 
									return step + '  (' + row['initiator'] +')';
								}, 
							},
							{  
								"targets": [ 4 ],
								"render": function(data,type, row){
									switch (row['stage']){
										case '1':
											var step = 'Request masuk ke draft';
											break;
										case '2':
											var step = 'Request menunggu persetujuan';
											break;
										case '3':
											var step = 'Request telah di setujui'; 
											break;
										default:
											var step = 'Request Canceled';
									}
									return step;
								}, 
							},

						],
					});		
		$('#btn-filter').click(function(){ //button filter event click
			tabel.ajax.reload();  //just reload table
		});
		$('#btn-reset').click(function(){ //button reset event click
			$('#form-filter')[0].reset();
			tabel.ajax.reload();  //just reload table
		});
		$('#dt_rp_list').on('click', 'tbody tr', function () {
				
				var rdata = tabel.row($(this).index()).data();
				//if (rdata['stage'] != 1){
				//var ftype = rdata['ftype'];
				var fparam = {'id' : rdata['id'], "mode" : rdata['mode'],
					'url':'jobbyid', 'reqtype' : 'read_list'};
				loadForm('modal_l2', fparam, true);
				//tabel.fnClearTable();
				//tabel.ajax.reload();
				//}
				//tabel.fnClearTable();
				
				//tabel.ajax.reload();
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
</style>
<div class="panel panel-default" style="width: 90%;margin: 0 auto;min-width: 350px;">
  <div class="panel-heading"style="font-weight: bold;">
	<form id="form-filter" class="form-horizontal" style="margin-bottom:2%;">
	<p class="formHeader" style="font-size: 30px;">History Request</p>
                    <div class="form-group">
                        <label for="pemohon" class="col-sm-2 control-label">Pemohon</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="pemohon">
                        </div>
                    </div>
					<div class="form-group">
                        <label for="date" class="col-sm-2 control-label">Tanggal</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="date"readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="req" class="col-sm-2 control-label">Request</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="req">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </form>
  </div>
  <div class="panel-body">
		<table cellpadding="" cellspacing="2" class="cell-border" id="dt_rp_list" style="width: 100%"> 			
					<thead>
						<tr>
							<th>ID</th>
							<th>Proses</th>
							<th>Tanggal Permohonan</th>
							<th>Pemohon</th>
							<th>Status</th>
							<th>NPP Request</th>
							<th>Approval</th>
							<th>Tanggal Approve</th>
						</tr>
					</thead>
						<tbody  id="vote_buttons" name="vote_buttons">
						</tbody>
		</table>
  </div>
</div>
<div class="modal-container" id="modal_l1"></div>


<div class="modal-container" id="modal_l2"></div>
