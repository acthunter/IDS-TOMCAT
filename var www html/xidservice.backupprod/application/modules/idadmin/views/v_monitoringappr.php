<script type="text/javascript">
var counter = 1;
var tabel;
$(document).ready(function(){
			tabel = $('#dt_req_list').DataTable({ 
			"destroy": true,
				"searching": false,
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, 
				"order": [], 
				"aLengthMenu": [[ 10, 25, 50, -1], [ 10, 25, 50, "All"]],
				"iDisplayLength": 10,
							"ajax": {
								"url": "<?php echo site_url('idadmin/xmain/getreqappr')?>" ,
								"type": "POST",
								"dataType": "JSON",
								"data" : function ( data ) { 
									data.request = $('#request').val();
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
								{"data":"id",},
								{"data":"nosrt"},
								{"data":"tglsrt"},
								{"data":"tglreq"},
								{"data":"requestor"},
								{"data":"stage"},
								{"data":"name",
								visible: false}
								
							],
							"rowCallback": function( row, data, index ) {
								if (data['stage']=='2'){
										$('td', row).css('color', 'red');
									}
							},
							"columnDefs": [
							{  
								"targets": [ 0 ], //first column / numbering column
								"orderable": false,
							},
							{  
								"targets": [ 4 ],
								"render": function(data,type, row){
										var step = row['name'];
									
									return step;
								}, 
							},
							{  
								"targets": [ 5 ],
								"render": function(data,type, row){
									if (row['stage']=='3'){
										var step = 'Approved';
									}else{
										var step = 'Process Approve';
									}
									return step;
								}, 
							}
						]
					});		
		$('#btn-filter').click(function(){ //button filter event click
			tabel.search($('#request').val()).draw();
			//tabel.ajax.reload();  //just reload table
		});
	});

</script>
<div class="panel panel-default" style="width: 90%;margin: 0 auto;min-width: 350px;padding: 10px;">
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
							<th>No Surat Masuk</th>
							<th>Tgl Surat </th>
							<th>Tgl Request </th>
							<th>Requestor</th>
							<th>Status</th>
						</tr>
					</thead>
						<tbody  id="vote_buttons" name="vote_buttons">
						</tbody>
		</table>
  </div>
			
  </div>
</div>

