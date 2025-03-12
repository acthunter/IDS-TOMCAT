<script type="text/javascript">
var t;
	function  <?php echo $modal_id;?>_trigger(fdata){
		$('#div_btn_<?php echo $modal_id;?> button').hide();	
			$.ajax({
					url : "<?php echo site_url('')?>" + fdata['url'],
					type: "POST",
					data: fdata,
					dataType: "JSON",
					success: function(wdata){
						var data = wdata['detail'];
						var rdata = data['data'];
						//alert(JSON.stringify(rdata));
						$('#wfid').val(wdata['id']);
						$('#mode').val(wdata['mode']);
						
						$('#token_id').val(data['id']);
						 $('#token_val').text(data['id']);
						// $('#trid').val(trid);
						$('#type').val(data.type);
						$('#type_val').text(data.type);
						$('#status').val(data.status);
						$('#status_val').text(data.status);
						
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
							"className": "dt-center", "targets": "_all"}
						],
						});
					}
			});		
	};
	
		function <?php echo $modal_id;?>_submit(btype){
		var fdata = {'url': 'wf/wfaction', 'modal_id' : "<?php echo $modal_id;?>", 'btype': btype };
		var isValid = $("#<?php echo $modal_id;?>_form").valid();
		
		if (isValid)
			action_submit(fdata);
	}	
</script>
<style>
	#form label {
		text-align: left;
		clear: both;
		margin-right:15px;
	}

	#form label.error {
		color: red;
		font-size: 11px;
		text-align: left;
		width: 500px;
		margin-left: 28%;
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
	
	tr.C { background: #FFFACD; }
	
	tr.U { background: #FFBC8F; }
	
	#example tbody{ background-color: white; }
	
	.lbl{
		width: 15%;
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
</style>
<div class="container">
  <!-- Modal -->
  <div class="modal fade"  id="<?php echo $modal_id;?>_content" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-body">
			 <div id="wrap">
		<form action="#" id="<?php echo $modal_id;?>_form" style="width: 500px; margin: auto;">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Get Password</p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row" style="width:90%;margin-left:6%;">
					<p class="row fl-controls-left"style="padding-left: 4%;">
						<label class="lbl" >Id</label> <label class="lblval" id="token_val" name="token_val"></label> 
						<input name="token_id" id="token_id" value="" class="form-control "  type="hidden" readonly="true" />
					</p>	
					<!--<p class="row fl-controls-left">
						<label class="judul">Trid</label> <label class="lblval" id="trid_val" name="trid_val"></label> 
						<input name="trid" id="trid" value="" class="form-control"  type="hidden" readonly="true"/>
					</p>-->
					<p class="row fl-controls-left"style="padding-left: 4%;">
						<label class="lbl">Type</label> <label class="lblval" id="type_val" name="type_val"></label> 
						<input name="type" id="type" value="" class="form-control"  type="hidden" readonly="true"/>
					</p>		
					<p class="row fl-controls-left" style="padding-left: 4%;">
						<label class="lbl">Status</label> <label class="lblval" id="status_val" name="status_val"></label> 
						<input name="status" id="status" value="" class="form-control"  type="hidden" readonly="true"/>
					</p>
					<p>
					<table id="example" class="table table-bordered">
						<thead >
						  <tr style="background: #F6F6F6;">
							<th>Loginid</th>
							<th>Trid</th>
							<th>Target</th>
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
					<input name="mode" id="mode" class="form-control" type="hidden" value="VL" >					
					<input name="notes" id="notes" class="form-control" type="hidden" >	
					<input name="wfid" id="wfid" class="form-control" type="hidden" >	
					<p >
						<button type="button" id="<?php echo $modal_id;?>_btn_approve" onclick="<?php echo $modal_id;?>_submit('approve')" class="btn btn-primary">Approve</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_reject" onclick="<?php echo $modal_id;?>_submit('reject')" class="btn btn-danger">Reject</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_release" onclick="<?php echo $modal_id;?>_submit('release')" class="btn btn-default">Release</button>
					</p>
			</div>							
		</form>
	</div>
        </div>
    </div>
  </div>
  
</div>