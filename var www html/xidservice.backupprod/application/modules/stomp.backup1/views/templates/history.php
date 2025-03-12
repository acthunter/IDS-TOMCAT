<script type="text/javascript">
	var tabel_history;
	var dt_rp_list;
	var xrpid;
	var tabel2;
	
	var rp_stage;
	
	function  <?php echo $modal_id;?>_trigger(fdata){
			$('#second-modal').hide();
			$('#date').datetimepicker({
            ignoreReadonly: true, widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('YYYY-MM-DD ').maxDate(new Date());
			$('#edate').datetimepicker({
            ignoreReadonly: true, widgetPositioning: { vertical: 'bottom' }
            }).data('DateTimePicker').format('YYYY-MM-DD ').maxDate(new Date());
			$("#date").on("dp.change", function (e) {
				$('#edate').data("DateTimePicker").minDate(e.date);
			});
			$("#edate").on("dp.change", function (e) {
				$('#date').data("DateTimePicker").maxDate(e.date);
			});
			tabel_history = $('#dt_rp_list').DataTable({ 
			dom: 'frtip',
			 "searching": false,
				"aLengthMenu": [[ 5, 25, 50, -1], [ 5, 25, 50, "All"]],
				"iDisplayLength": 5,
							"ajax": {
								"url": "<?php echo site_url('stomp/xids/gethistory')?>" ,
								"type": "POST",
								"dataType": "JSON",
								"data" : function ( data ) {
									data.pemohon = $('#pemohon').val();
									data.date = $('#date').val();
									data.req = $('#req').val();
									data.edate = $('#edate').val();
								}
							},
							"buttons": [
								  {
									 extend: 'collection',
									 buttons: [ 'pdfHtml5', 'csvHtml5', 'copyHtml5', 'excelHtml5' ]
								  }
							],
							"columns" : [
								{"data":"id"},
								{"data":"mode"},
								{"data":"cdate"},
								{"data":"initiator"},
								{"data":"currActor"},
								{"data":"list_npp"},
								{"data":"def",  "visible":false},
								{"data":"change",  "visible":false},
								{"data":"efektifdate",  "visible":false},
								
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
										default:
											var step = 'Request Canceled';
									}
									return pname;
								}, 
							},
							{  
								"targets": [ 3 ],
								"render": function(data,type, row){
									var step = (row['nama_init']); 
									return step + '  (' + row['initiator'] +')';
								}, 
							},
							{  
								"targets": [ 5 ],
								"render": function(data,type, row){
									
									if(row['nama'] == null){
										var step ="  "; 
										return step;
									}else{
										var step = (row['nama']); 
										return step + '  (' + row['list_npp'] +')';
									}
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
			if ($('#date').val() != ""||$('#edate').val() != ""||$('#pemohon').val() != ""||$('#req').val() != ""){
				//alert($('#edate').val());
				if ($('#edate').val() != ""){
					if ($('#date').val() == ""){
						alert("Harap isi Lengkapi Tanggal efektif");
						$('#form-filter')[0].reset();
						tabel_history.ajax.reload();
					}
					tabel_history.ajax.reload();
				}else{
					tabel_history.ajax.reload();
				}
			}else{
				alert("Harap input search terlebih dahulu");
			}//just reload table
		});
		$('#btn-expcsv').on('click', function(){
			tabel_history.button( '0-1' ).trigger();
			//dt_rev_post.button().trigger();
		});  
		$('#date').on('click', function(){
			var now = new Date();
			var day = ("0" + now.getDate()).slice(-2);
			var month = ("0" + (now.getMonth() + 1)).slice(-2);
			$('#edate').val(now.getFullYear()+"-"+(month)+"-"+(day) ) ;
			$('#date').val(now.getFullYear()+"-"+(month)+"-"+(day) ) ;
		});  
		$('#btn-reset').click(function(){ //button reset event click
			
			$('#form-filter')[0].reset();
			//$('#date').data("DateTimePicker").clear();
			$('#edate').data("DateTimePicker").clear();	
			tabel_history.ajax.reload();  //just reload table
		});
		$('#dt_rp_list').on('click', 'tbody tr', function () {
				
				/* var rdata = tabel.row($(this).index()).data();
				//if (rdata['stage'] != 1){
				//var ftype = rdata['ftype'];
				var fparam = {'id' : rdata['id'], "mode" : rdata['mode'],
					'url':'jobbyid', 'reqtype' : 'read_list'};
				loadForm('modal_l2', fparam, true);
				//tabel.fnClearTable();
				//tabel.ajax.reload();
				//}
				//tabel.fnClearTable();
				
				//tabel.ajax.reload(); */
				var rdata = tabel_history.row( this ).data();
				//alert(rdata['id']);
				if(rdata['mode'] == "RP"){
					var ftype = rdata['ftype'];
					var fparam = {'id' : rdata['id'], "mode" : rdata['mode'],
						'url':'jobbyid', 'reqtype' : 'read_list'};
					loadForm('modal_l2', fparam, true);
				}else{
					$('#loginid').val(rdata['list_npp']);
					//$('#tposname').val(rdata['change']);
					$('[name="cposname"]').text(rdata['def']);
					$('[name="nama"]').text(rdata['nama']);
					$('[name="tposname"]').val(rdata['change']);
					$('#sdate').val(rdata['efektifdate']);
					switch (rdata['mode'])
					{
						case 'CU':
						$pname = 'Change Unit';
					break;
						case 'CP':
						$pname = 'Ubah Kewenangan Permanen';
					break;
						case 'CT':
						$pname = 'Ubah Kewenangan Sementara';
					break;
					}
					$('#header').text($pname);
					if (rdata['mode'] == "CU"){
						$('[name="lbl-tposname"]').text("Unit Baru");
						$('[id="pos_def"]').text("Unit Definitif");
					}else{
						$('[name="lbl-tposname"]').text("Posisi Baru");
						$('[id="pos_def"]').text("Posisi Definitif");
					}
					$('#second-modal').modal({
					  show: true
					})
				}
		});
	};
	
	function <?php echo $modal_id;?>_submit(btype){
		var fdata = {'url': 'wf/wfaction', 'modal_id' : "<?php echo $modal_id;?>", 'btype': btype };
		action_submit(fdata);
	}	
</script>
<style>
	li.auth {text-align: center; width: 60px; float: left;}
	li.auth_1 { background-color: grey;}
	li.auth_2 { background-color: yellow;}
	li.auth_3 { background-color: green;}
	
	.infohide {
		display:none;
	}
<?/* #tabel, #srch {
    padding: 5px;
    text-align: center;
    background-color: #e5eecc;
    border: solid 1px #c3c3c3;
}

#tabel {
    padding: 50px;
    display: none;
} */?>
</style>
<div id="<?php echo $modal_id;?>_content" class="modal fade">
	<div class="modal-dialog ui-front" style="width: 85%;">
			<div class="modal-content" style="padding: 10px;">
				<div class="modal-header text-center " style="margin-bottom:15px;">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h2 style="font-family: inherit;">HISTORY REQUEST</h2>
                </div>
				<div class="modal-body form row">
				<div class="col-lg-3 portfolio-item"style="margin-left: 5px; margin-right: -10px;margin-top:0.75%;">
				  <div class="card h-100">
					<div class="card-body">
						<form id="form-filter" class="form-horizontal" style="margin-bottom:2%; background: white;">
							<div class="form-group" style="margin-left:0px; margin-right:0px">
								<label for="pemohon">NPP Pemohon</label>
								<input type="text" class="form-control" id="pemohon">
							</div>
					<div class="form-group" style="margin-left:0px; margin-right:0px">
						<label for="date" >Tanggal Mulai</label>
                            <input type="text" class="form-control" id="date"readonly>                        
						<label for="date" >Tanggal Akhir</label>
							<input type="text" class="form-control" id="edate"readonly>

                    </div>
                    <div class="form-group" style="margin-left:0px; margin-right:0px">
                        <label for="req" > NPP Request</label>
                        <input type="text" class="form-control" id="req">
                    </div>
                    <div class="form-group" style="margin-left:0px">
						<button type="button" id="btn-filter" class="btn btn-success">Filter</button>
                        <button type="button" id="btn-reset" class="btn btn-danger" onclick="$('#req, #date,#pemohon').val('').text('');">Reset</button>	
						<!--<button type="button" id="btn-expcsv" class="btn btn-primary">Export CSV</button>-->
					</div>
                </form>	
					</div>
				  </div>
				</div>
				<div class="col-lg-9 portfolio-item">
				  <div class="card h-100">
					<div class="card-body">
					  	<table cellpadding="" cellspacing="2" class="cell-border" id="dt_rp_list" style="width: 100%"> 			
							<thead>
								<tr>
									<th>ID</th>
									<th>Proses</th>
									<th>Tanggal Permohonan</th>
									<th>Pemohon</th>
									<th>Status</th>
									<th>NPP Request</th>
									<th hidden>Posisi / Unit Definitif</th>
									<th hidden>Posisi / Unit Baru</th>
									<th hidden>Tanggal Efektif</th>
								</tr>
							</thead>
								<tbody  id="vote_buttons" name="vote_buttons">
								</tbody>
						</table>
					</div>
				  </div>
				</div>	
				</div>	
			</div>
		</div>
	</div>
	
<div class="modal fade" id="second-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form action="#"  id="<?php echo $modal_id;?>_form"  role="form">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;" id="header" ></p>
			
			<p class="judul" align= "center" style="margin-left:25%; width:70%;color: red;" id="lockinfo" ></p>			
			<div id="wfinfo" class="infohide"style="margin-right: 8%;margin-left: 9%">
				<label for="doneActor">Done</label> <ul id="doneActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
				<label for="currActor">Curr</label> <ul id="currActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
			</div>
			
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row"style="width:90%;margin-left:6%; ">
				
				<label style="color: rgb(64, 92, 96);font-family: Big Caslon, Book Antiqua, Palatino Linotype, Georgia, serif;" >LoginID</label>
					<label  style="float: right;margin-right: 60px;color: rgb(64, 92, 96);font-family: Big Caslon, Book Antiqua, Palatino Linotype, Georgia, serif;" id="pos_def" ></label>
				<p id="l-login">					
					<input disabled style="width: 20%" name="loginid" id="loginid" placeholder="Login ID" class="column-full form-control" type="text" onchange="query_id()" onclick="$('#loginid, #nama,#cposname,#tposname, #tposid').val('').text('');$('#pos_def').css('display', 'none');">
					<label name="nama" class="labelisi" id="nama" ></label>
					<input disabled name="nama" id="nama" readonly type="hidden">
					<label for="nama"  class="labelisi" name="cposname" id="cposname" ></label>
					<input disabled name="cposname" id="cposname" readonly type="hidden">
				</p>
				<p >
				<label class="judul" name="lbl-tposname" id="lbl-tposname"></label> 
				<input disabled id="tposname" name="tposname" list="tpos" placeholder="-- Posisi Baru --" class="autocomplete form-control" type="text" onclick="$(this).val(''); $('#tposid').val('');">
				</p>
				<p>
				<label class="judul">Tanggal Efektif</label>
				<input name="sdate" id="sdate" placeholder="Tanggal Efektif" class="form-control" type="text" readonly>
					<input name="tposid" id="tposid" readonly type="hidden">
					<input name="status" id="status" class="form-control" type="hidden" >
					<input name="id" id="id" class="form-control" type="hidden" >
					<input name="mode" id="mode" class="form-control" type="hidden" value="CP" >
					<input name="wfid" id="wfid" class="form-control" type="hidden" >	
					<input name="reqtype" id="reqtype" class="form-control" type="hidden" >						
					<input name="notes" id="notes" class="form-control" type="hidden" >								
				<p  class="signin button" id="div_btn_<?php echo $modal_id;?>" style="padding-top: 40px;">
					<button type="button" class="btn btn-primary" data-dismiss="modal" >Close</button>
									
				</p>
			</div>							
		</form>
      </div>
    </div>
  </div>
</div>
	