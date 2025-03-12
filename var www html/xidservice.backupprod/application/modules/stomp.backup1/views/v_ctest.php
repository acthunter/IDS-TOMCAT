<html lang="en">
<head>
<meta charset="UTF-8">

<script type="text/javascript">
	var tab_myjob;	
	var form_db = {};
	var pname = {RP : "Review Position",US : "Update Subbranch", EM : "Review Position", CT: "Posisi Sementara ", CP: "Posisi Permanen", CU: "Ubah Unit", UA: "Tambah User", CM: "Ubah Nomor HP", RS: "Reset Target", VL: "Validasi", UC: "Cek User"};
	function clearform_db(){
		form_db = {};
	}
	
	function createnew(mode){
		var fparam = {'id' : null, "mode" : mode,
					'url':'wf/new/' + mode, 'reqtype' : 'new'};
		loadForm('modal_l1', fparam, true);
	}
	$(document).on('hidden.bs.modal', '.modal', function () {
    $('.modal:visible').length && $(document.body).addClass('modal-open');
});
	$(document).ready(function(){
		 
		tab_myjob = $('#dt_myjob').DataTable({ 
				"processing": true, 
				"searching": false,
				"serverSide": true, 
				"order": [], 
				"aLengthMenu": [[ 10, 25, 50, -1], [ 10, 25, 50, "All"]],
				"iDisplayLength": 10,

				"ajax": {
					"url": "<?php echo site_url('myjob')?>",
					"type": "POST"
				},
				"columns" : [
				{"data":"id",
				 width: "20px"},
				{"data":"stage",
				  visible: false,
				  width: "50px"},
				{"data":"mode"},

				{"data":"cdate"},
				{"data":"name"},
				{"data":"stage"},
				{"data":"currScore",
				visible: false,
				  width: "50px"}
				],
				"columnDefs": [
				{  
					"targets": [ -1 ],
					"orderable": false, 
				},
				{  
					"targets": [ 2 ],
					"render": function(data,type, row){
						var step = (row['stage']=='1') ? 'Init' : 'Approve'; 
						return step + ' - ' + pname[data];
					}, 
				},
				{  
					"targets": [ 4 ],
					"render": function(data,type, row){
						var step = (row['name']); 
						return step + '  (' + row['initiator'] +')';
					}, 
				},
				{  
					"targets": [ 5 ],
					"render": function(data,type, row){
						if (row['stage']=='1')
						var step = 'Request masuk ke draft';
						if (row['stage']=='2')
						var step = 'Request menunggu persetujuan'; 
						if (row['stage']=='3')
						var step = 'Request telah di setujui'; 
						return step;
					}, 
				},
				],
		});
		
		$('#dt_myjob').on('click', 'tr:not(:first)', function () {
				//job_click('#modal1', '#modal_xadm', tab_myjob.row($(this).index()).data());
	/* 			$.ajax({
					url: '<?php echo site_url('stomp/xids/sess_user')?>',
					success: function(){
						 alert('YEAY');
						
					}
				});

				return false; */
				var rdata = tab_myjob.row($(this).index()).data();
						var ftype = rdata['ftype'];
						var fparam = {'id' : rdata['id'], "mode" : rdata['mode'],
							'url':'jobbyid', 'reqtype' : 'read'};
						loadForm('modal_l1', fparam, true);
				
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
				 } else if (event.currentTarget.id == "modal_l2_content"){
					  $("body").addClass("modal-open");
					alert('The modal is about to be shown.');
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
			if (reason == null || reason.length < 1){
				return;
			}
		}
		
		$('#notes').val(reason);
		$(hmodal_id + ' #reqtype').val(fdata['btype']);
		
		var fxdata = $(hmodal_id + '_form').serialize();
		console.log(fdata);
		
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
</head>
<body>
<br><br>
	
	<div class="tab-content clearfix" style="background-color: #FFFFFF;">
	<br><br>
		<div id="propose" class="tab-pane fade in active" style="margin-top: -48px;margin-left: 1px;">
				<div class="block-table table-sorting clearfix">
				<table cellpadding="" cellspacing="2" class="cell-border" id="dt_myjob" style="width: 100%"> 			
					<thead>
						<tr>
							<th>ID</th>
							<th>Tahap</th>
							<th>Proses</th>
							<th>Tanggal Permohonan</th>
							<th>Pemohon</th>
							<th>Status</th>
						</tr>
					</thead>
						<tbody  id="vote_buttons" name="vote_buttons">
						</tbody>
				</table>
				</div>
		</div>
	</div>
<div class="modal-container" id="modal_l1"></div>


<div class="modal-container" id="modal_l2"></div>


</body>
</html>