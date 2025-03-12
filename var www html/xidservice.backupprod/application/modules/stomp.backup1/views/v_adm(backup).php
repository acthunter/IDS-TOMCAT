<html lang="en">
<head>
<meta charset="UTF-8">
<title>Simple Bootstrap Modal with Dynamic content Using remote URL</title>

<script type="text/javascript">
	var tab_myjob;
	//var data = 0; 
	var form_db = {};
	var pname = {RP : "Review Position", CP: "Change Position", UA: "User Add"};
	function clearform_db(){
		form_db = {};
	}
	
	function createnew(mode){
		var fparam = {'id' : null, "mode" : mode,
					'url':'wf/new/' + mode, 'reqtype' : 'new'};
		loadForm('modal_l1', fparam, true);
	}
	$(document).ready(function(){
		
		tab_myjob = $('#dt_myjob').DataTable({ 
					"processing": true,
					"searching": false,
				"serverSide": true, 
				//aoData.concat( $("#attributeform").serializeArray() );
				"order": [], 
				"ajax": {
					"url": "<?php echo site_url('stomp/xids/getadm/')?>"+ data,
					"type": "POST",
					"data": "aoData", 
				},
				"columns" : [
				{"data":"id",
				 width: "20px"},
				{"data":"stage",
				  visible: false,
				  width: "50px"},
				{"data":"mode"},
				{"data":"doneActor"},
				{"data":"currScore"},
				{"data":"cdate"},
				{"data":"name"},
				{"data":"stage"}
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
					"targets": [ 6 ],
					"render": function(data,type, row){
						var step = (row['name']); 
						return step + '  (' + row['initiator'] +')';
					}, 
				},
				{  
					"targets": [ 7 ],
					"render": function(data,type, row){
						var step = (row['stage']=='1') ? 'Request Initiated' : 'Request Review'; 
						return step;
					}, 
				}
				],
		});
		
		$('#dt_myjob').on('click', 'tr:not(:first)', function () {
				//job_click('#modal1', '#modal_xadm', tab_myjob.row($(this).index()).data());
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
					  tab_myjob.ajax.reload();
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
		
	function srch()
		{		
			var url = "<?php echo site_url('adm')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: $('[id="search"]').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					$('[name="nama"]').text(data.name);
					$('[name="nama"]').val(data.name);
					$('[name="cposid"]').val(data.positionid);
					$('[name="cposname"]').text(data.nama);
					$('[name="cposname"]').val(data.nama);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		}

</script>
</head>
<body>
<br><br>
<div class="container">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#propose" data-toggle="tab">Active </a></li>
		<li><a href="#approve" data-toggle="tab" >General </a></li>
	</ul>
	<div class="tab-content clearfix" style="background-color: #FFFFFF;">
	<br><br>
<form class="navbar-form" id="search" role="search">
    <div class="input-group add-on">
      <input class="form-control" placeholder="Search" onclick="srch" name="srch-term" id="srch-term" type="text">
      <div class="input-group-btn">
        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
      </div>
    </div>
  </form>
</div>
<div class="tab-content clearfix" style="background-color: #FFFFFF;">
		<div id="propose" class="tab-pane fade in active">
				<div class="block-table table-sorting clearfix">
				<table cellpadding="" cellspacing="2" class="tabel" id="dt_myjob" style="width: 100%"> 			
					<thead>
						<tr>
							<th>Request ID</th>
							<th>Tahap</th>
							<th>Proses</th>
							<th>dActor</th>
							<th>score</th>
							<th>Date Requested</th>
							<th>Requested By</th>
							<th>Status</th>
						</tr>
					</thead>
						<tbody  id="vote_buttons" name="vote_buttons">
						</tbody>
				</table>
				</div>
		</div>
	</div>
</div>
<div class="modal-container" id="modal_l1"></div>


<div class="modal-container" id="modal_l2"></div>


</body>
</html>