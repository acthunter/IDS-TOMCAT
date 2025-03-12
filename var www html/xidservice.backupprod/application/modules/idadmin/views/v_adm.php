<html>
<head> 
	<style type="text/css">
		.ui-autocomplete { height: 300px; overflow-y: scroll; overflow-x: hidden;}
		.width100 { width: 100px; }
		#vote_buttons {
			cursor:pointer;
			cursor:hand;
		}
		.high {
            color: red;
        }
        .low {
			color: black;
        }
		tr.row_selected td {
			background-color: grey !important; 
		}
	td {
       max-width: 120px;
       white-space: nowrap;
       text-overflow: ellipsis;
	   word-wrap:break-word !important;
     }
	 .container{
		 background: white;
	 }
		
	</style>
</head> 
<body>
<div style="background:white;">
<div class="col-lg-3 portfolio-item"style="margin-left: 5px; margin-right: -10px;margin-top:3.75%;">
				  <div class="card h-100">
					<div class="card-body">
						<form id="form-filter" class="form-horizontal" style="margin-bottom:2%; background: white;">
							<div class="form-group" style="margin-left:0px; margin-right:0px">
								<label for="pemohon">NO Surat</label>
								<input type="text" class="form-control" id="no_surat">
							</div>
					<div class="form-group" style="margin-left:0px; margin-right:0px">
						<label for="date" >Tanggal Mulai</label>
                            <input type="text" class="form-control" id="date"readonly>                        
						<label for="date" >Tanggal Akhir</label>
							<input type="text" class="form-control" id="edate"readonly>

                    </div>
                    <div class="form-group" style="margin-left:0px">
						<button type="button" id="btn-filter" class="btn btn-success">Filter</button>
                        <button type="button" id="btn-reset" class="btn btn-danger" onclick="$('#no_surat, #date,#edate').val('').text('');">Reset</button>	
						<!--<button type="button" id="btn-expcsv" class="btn btn-primary">Export CSV</button>-->
					</div>
                </form>	
					</div>
				  </div>
				</div>
				<div class="col-lg-9 portfolio-item">
				  <div class="card h-100">
					<div class="card-body">
					  <table cellpadding="" cellspacing="2" class="tabel" id="dt_suspect" style="width: 100%; text-align:center;" > 			
				<thead>
					<tr>
						<th>id</th>
						<th>Jenis request</th>
						<th>Keterangan</th>
						<th>Tanggal</th>
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

	<div id="DescModal" class="modal fade">
		<div class="modal-dialog ui-front">
			<div  id="cekuser"style="margin:0 auto; margin-top: 5%; ">
			<form  id="form_reset" style=" margin-left: 1px; margin-right: -30px;">
				<p class="formHeader" style="font-size: 30px;">Detail Request Management</p>
				<input type="hidden" value="" name="reqtype" id="reqtype"/>
				<input type="hidden" value="" name="identity" id="userclass"/>
				<div class="form-group row" >
					<p id= "tipe" align="center">
						<label style="color: rgb(64, 92, 96);" >Tipe</label> 
						<input style="margin-left: 10%;" type="radio" id="cm" class="sama" name="same" value="cm" checked> Member
						<input style="margin-left: 10%;" type="radio" id="sr"  name="same" value="sr"> Surat
						<input style="margin-left: 10%;" type="radio" id="rm" name="same" value="rm"> Remedy
					</p>
					<p id="ok2" style="display:none;">
						<label style="color: rgb(64, 92, 96);">No Surat</label>
						<input type='text' id='nosr' name='nosr' class="form-control" placeholder="No Surat">
					</p>
					<p id="ok3"style="display:none;">
						<label style="color: rgb(64, 92, 96);">Incident ID</label>
						<input type='text' id='inc' name='inc' class="form-control" placeholder="Incident ID">
					</p>
					<p id="ok4"style="display:none;">
						<label style="color: rgb(64, 92, 96);">Tanggal</label>
						<input type='text' id='doc_date' name='doc_date' class="form-control" placeholder="Tanggal">
					</p>
					<p >
						<table id="dt_dtl_req"style="text-align:center;" class="table table-bordered">
							<thead  style="background-color: #b3b3b3;">
								<tr >
									<th style="text-align:center">Id</th>
									<th style="text-align:center">Reqid</th>
									<th style="text-align:center">Loginid</th>
									<th style="text-align:center">Target</th>
									<th style="text-align:center">Status</th>
									<th style="text-align:center">Email</th>
								</tr>
							</thead>
						</table>
					</p>
						<input name="id" id="id" class="form-control" type="hidden" >
						<input name="mode" id="mode" class="form-control" type="hidden" value="RS" >
						<input name="reqid" id="reqid" class="form-control" type="hidden" >	
						<input name="reqtype" id="reqtype" class="form-control" type="hidden" >
						<input name="notes" id="notes" class="form-control" type="hidden" >						
				</div>							
			</form>
		</div>
	</div>
<script type="text/javascript">
	
	$(document).ready(function() { 
		var tab;
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
		
		$('#dt_dtl_req td').css('white-space','initial');
		tab = $('#dt_suspect').DataTable({
			"destroy": true,
			"dom": 'frtip',
			"autoWidth": false,
			 "searching": false,
				"aLengthMenu": [[ 15, 25, 50, -1], [ 15, 25, 50, "All"]],
				"iDisplayLength": 15,
			"ajax": {
			"url": "<?php echo site_url('sysadm/xbatch/deliv_pass_list')?>",
			"data" : function ( data ) {
									data.no_surat = $('#no_surat').val();
									data.date = $('#date').val();
									data.edate = $('#edate').val();
								},
			"type": "POST"
			},
			"columns": [
				
				{"data":"id"},
				{"data":"srctype"},
				{"data":"key1"},
				{"data":"doc_date"},
				
				
			],
			"columnDefs": [
				
				{  
					"targets": [ 4 ],
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
				{  
					"targets": [ 1 ],
					"render": function(data,type, row){
						if (row['srctype']=='sr'){
							var step = 'Surat';
					}else if (row['srctype']=='cm'){
						var step = 'Member'; 
					}else if (row['srctype']=='rm'){
						var step = 'Remedy'; 
					}else{
						var step = ''; 
						}
						return '<a>'+step+'</a>';
					}, 
				},
				/* {  
					"targets": [ 5 ],
					"render": function(data,type, row){
						//alert(row['status']);
						if (row['status']=='J')
							var step = 'Validate';
					if (row['status']=='L')
							var step = 'Request Fail';
					if (row['status']=='K')
						var step = 'Validate Sudah di submit';
					if (row['status']=='P')
						if (row['stattr']=='F'){
							var step = 'Splitmanaged';
						}else if (row['stattr']=='G'){
							var step = 'Splitmanaged';
						}else if (row['stattr']=='H'){
							var step = 'Splitmanaged';
					}else if (row['stattr']=='Q'){
							var step = 'AssignPassword';
					}else if (row['stattr']=='T'){
							var step = 'Antrian';
					}else if (row['stattr']=='L'){
							var step = 'Request Fail';
					}else if (row['stattr']=='R'){
							var step = 'AssignPassword';
					}else{
							var step = 'Validasi Submit';
					}
						return step;
					}, 
				} */
			],

		});
		$('#dt_suspect').on('click', 'tr:not(:first)', function () {
			var rdata = tab.row($(this).index()).data();
			var fparam = {'reqid' : rdata['id'], 'url' : 'detail2', 'req': rdata['key1'], 'type': rdata['srctype'], 'doc_date': rdata['doc_date']  };
			//alert(JSON.stringify(fparam));
			datatable(fparam, true);
		});
		$('#btn-reset').click(function(){ //button reset event click
			
			$('#form-filter')[0].reset();
			//$('#date').data("DateTimePicker").clear();
			$('#edate').data("DateTimePicker").clear();	
			tab.ajax.reload();  //just reload table
		});
		$('#btn-filter').click(function(){ //button filter event click
			if ($('#date').val() != ""||$('#edate').val() != ""||$('#no_surat').val() != ""){
				//alert($('#no_surat').val());
				//alert($('#edate').val());
				if ($('#edate').val() != ""){
					if ($('#date').val() == ""){
						alert("Harap isi Lengkapi Tanggal efektif");
						$('#form-filter')[0].reset();
						tab.ajax.reload();
					}
					tab.ajax.reload();
				}else{
					
					tab.ajax.reload();
				}
			}else{
				alert("Harap input search terlebih dahulu");
			}//just reload table
		});
	})
	
	function datatable(fdata){		
		dt_dtl_req = $('#dt_dtl_req').DataTable({
			"destroy": true,
			"searching": false,
			"bLengthChange": false,
			"bInfo" : false,  
			"paging": true,
			"pageLength": 5,
			drawCallback: function(settings) {
				var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
				pagination.toggle(this.api().page.info().pages > 1);
			},
			"processing": true, 
			"serverSide": true, 
			"autoWidth": false,
			"ajax": {
				"url":  fdata['url'],
				"data": fdata,
				"type": "POST"			
			},
			"columns": [
				{"data" : "id","width": "5%"},
				{"data" : "reqid","width": "5%"},
				{"data" : "loginid", "width": "5%"},
				{"data" : "target"},
				{"data" : "status"},
				{
					"data" : null,
					"render": function(data, type, row){
						if (data.email != null){
							var val = row['email'];
							
						}else{	
							var val = row['mail'];
						}
						return val.length > 15 ?
							val.substr( 0, 15 ) +'…' :
							val;
					}
				}
			]
		});
		
		$('input[type=radio],#nosr,#inc,#doc_date').attr('disabled', true);
		$('#doc_date').datetimepicker({
			ignoreReadonly: true, widgetPositioning: { vertical: 'bottom' }
        }).data('DateTimePicker').format('YYYY-MM-DD');
		
		var e = fdata['doc_date'];
		doc_date = e.split(' ');
		$('#doc_date').val(doc_date[0]);
		if ( fdata['type'] == 'cm') {
			$('#npp').val();
			$('#ok').hide();
			$( "#cm" ).prop('checked', true);
			document.getElementById('ok2').style.display = 'none';
			document.getElementById('ok4').style.display = 'none';
			document.getElementById('ok3').style.display = 'none';					
		} else if(fdata['type'] == 'sr') {
			$('#npp').val();
			$('#ok').hide();
			$( "#sr" ).prop('checked', true);
			$("#nosr").val(fdata['req']);
			document.getElementById('ok2').style.display = 'block';
			document.getElementById('ok4').style.display = 'block';
			document.getElementById('ok3').style.display = 'none';				
		} else if(fdata['type'] == 'rm'){
			$('#npp').val();
			$('#ok').hide();
			$( "#rm" ).prop('checked', true);
			$("#inc").val(fdata['req']);
			document.getElementById('ok3').style.display = 'block';
			document.getElementById('ok4').style.display = 'block';
			document.getElementById('ok2').style.display = 'none';
		}
		$('#DescModal').modal("show");
		
		/* $("#dt_dtl_req tbody tr").click(function(){
		 if (! $(this).find("button").length)
		 {
		   $(this).find("td").each(function(){
			if (!$(this).hasClass("td-button"))
			{
				var text = $(this).text();
				$(this).html ('<input type="text" value="' +  text + '">')
			} else
				$(this).html ('<button class="button-save">Save</button>')
		   })
		 }
		});
		$(document).on("click", ".button-save",function(){
			var tr = $(this).parent().parent();
		  alert(this);
		  tr.find("td").each(function(){
			if (!$(this).hasClass("td-button"))
			{
				var text = $(this).find("input").val();
				$(this).text(text)
			} else
				$(this).html('');
		  })
		}) */
		
		/* $("#mail").click(function() {
			var tr = $(this).parent().parent();
			  tr.find(".email").each(function(){
				var text = $(this).find("input").val();
					$(this).text(text);
				});
				 var items = dt_dtl_req.fnGetNodes();
					for ( var i=0 ; i<items.length ; i++ ) {
					var alldata = dt_dtl_req.fnGetData(i);
					console.log(alldata);
				}
				
				var oTable = $('#dt_dtl_req').dataTable();
				var data = oTable.fnGetData();
		
			send();
			var oTable = $('#dt_dtl_req').dataTable();
			var nlines = $(oTable.fnGetNodes()).length;
			var ncols = $(oTable.fnGetNodes(0)).find("td").length;
			alert(ncols);
			for(var i=0; i<nlines; i++){
				for(var j=0; j<ncols; j++){
					var alldata = [];
					var z = oTable.fnGetNodes()[i].cells[j].childNodes[0];
					alldata.push(  oTable.$(z).is("input") ? oTable.$(z).val() : oTable.$(z).text()  );
				    
				}
			} alert(alldata);
			var fdata = {'adt' : alldata};
			alert(JSON.stringify(fdata)); 
		}); */
	}

</script>
</body>
</html>