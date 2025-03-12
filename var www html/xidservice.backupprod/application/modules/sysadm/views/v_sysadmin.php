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
		
		.text-wrap{
			white-space:normal;
		}
		.width-200{
			width:1000px;
		}
	</style>
</head> 
<body>


<div class="container" style="width: 100%;">

  <ul class="nav nav-tabs">
	<li class="active"><a href="#general_rp_tab" data-toggle="tab" >RP General </a></li>
	<li><a href="#general_tab" data-toggle="tab" >WF General </a></li>
    <li><a href="#propose" data-toggle="tab" >Propose </a></li>
  </ul>

  <div class="tab-content clearfix" style="background-color: #FFFFFF; margin-left: ">
	<div id="general_rp_tab" class="tab-pane fade in active">
				<br><br><center><h2 style="padding-bottom: 10px;">XRP General</h2></center>
				<div class="block-table table-sorting clearfix"> <!-- block-fluid table-sorting clearfix -->
					<table cellpadding="" cellspacing="2" class="tabel" id="dt_rp_general"style="width: 100%;height: 60px;"> 			
						<thead>
							<tr >
								<th >id</th>
								<th >wfid</th>
								<th >loginid</th>
								<th >Kode Unit</th>
								<th >Pstat</th>
								<th >status</th>
								<th>Detail</th>
							</tr>
						</thead>
						<tbody id="vote_buttons" name="vote_buttons">
						</tbody>
					</table>
				</div>
				<div class="modal-footer" id="div_btn_tpos_submit">
						<button type="button" onclick="rp_mark('pending')" class="btn btn-primary">Pending</button>
						<button type="button" onclick="rp_mark('active')" class="btn btn-primary">Active</button>
						<button type="button"  onclick="rp_mark('start')" class="btn btn-warning right">Start</button>
						<button type="button"  onclick="rp_mark('resource')" class="btn btn-warning right">Resource</button>
						<button type="button"  onclick="rp_mark('finish')" class="btn btn-warning right">Finish</button>						
				</div>
    </div>
	
    <div id="general_tab" class="tab-pane fade">
				<br><br><center><h2 style="padding-bottom: 10px;">WF General</h2></center>
				<div class="block-table table-sorting clearfix"> <!-- block-fluid table-sorting clearfix -->
					<table cellpadding="" cellspacing="2" class="tabel" id="dt_general"style="width: 100%;height: 60px;"> 			
						<thead>
							<tr>
								<th>id</th>
								<th>Tahap</th>
								<th>Proses</th>
								<th>Flag</th>
								
								<th>score</th>
							</tr>
						</thead>
						<tbody id="vote_buttons" name="vote_buttons" style="text-align:center;">
						</tbody>
					</table>
				</div>
				<div class="modal-footer" id="div_btn_tpos_submit">
						<button type="button" onclick="wf_mark('restart')" class="btn btn-primary">Restart</button>
						<button type="button"  onclick="wf_mark('finish')" class="btn btn-warning right">Finish</button>			
				</div>
    </div>	

    <div id="propose" class="tab-pane fade">
				<br><br><center><h2 style="padding-bottom: 10px;">Active List</h2></center>
				<div class="block-table table-sorting clearfix"> <!-- block-fluid table-sorting clearfix -->
					<table cellpadding="" cellspacing="2" class="tabel" id="dt_p"style="width: 100%;height: 60px;"> 			
						<thead>
							<tr>
								<th>id</th>
								<th>refid</th>
								<th>effDate</th>
								<th>endDate</th>
								<th>batchFlag</th>
								<th>ProcStatus</th>
								<th>systemId</th>	
								<th>mode</th>									
														
							</tr>
						</thead>
						<tbody id="vote_buttons" name="vote_buttons" style="text-align:center;">
						</tbody>
					</table>
				</div>
				<div class="modal-footer" id="div_btn_tpos_submit">
						<button type="button" onclick="mark('pending')" class="btn btn-primary">Pending</button>
						<button type="button"  onclick="mark('active')" class="btn btn-warning right">Activate</button>
						<button type="button" onclick="mark('finish')" class="btn btn-primary">Mark-Fin</button>
						<button type="button"  onclick="mark('init')" class="btn btn-warning right">Mark-init</button>
						
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
		tr.row_selected td {
    background-color: grey !important; 
		}
    </style>
	
 	<script type="text/javascript">
		var tab;
		var comm;
		var table;
		var table1;
		var dt_general;
		var dt_rp_general;
		

		function load_table(){
			tab = $('#dt_p').DataTable({
				destroy: true,
					"processing": true, 
				"serverSide": true,
				"autoWidth": false,	
				"info": false,
				"paging": false,				
				"ajax": {
					"url": "<?php echo site_url('rscsrc_list')?>",
					"type": "POST"
				},
				"columns": [
					
					{"data":"id"},
					{"data":"refid"},
					{"data":"effDate"},
					{"data":"endDate"},
					{"data":"batchFlag"},
					{"data":"procStatus"},
					{"data":"systemId"},
					{"data":"mode"}
				],
				"columnDefs": [
				{  
					"targets": [ -1 ], //last column
					"orderable": false, //set not orderable
				}
				],
			});
			
		
		}
		
		function showdetail(rid){
			$.ajax({
				"url": "<?php echo site_url('rscsrc_detail/')?>" + rid,
				success: function(data){
					$('#detail_tag').html(data);
					
					$('#rscdetail').modal('show');
					//alert(data);
				}
			});
			
			
			};
		
		$(document).ready(function() {
			load_table();
			$('#dt_p tbody').on( 'click', 'tr', function () {
				 $(this).toggleClass('row_selected');
				 var data = tab.row($(this)).data();
				 //showdetail(data['id']);
			} );
			
			dt_general = $('#dt_general').DataTable({ 
					"processing": true, 
				"serverSide": true,
				"searchable": true,
				"info": false,
				"paging": false,
				"ajax": {
					"url": "<?php echo site_url('myjob')?>",
					"type": "POST",
					data : {stype: "general"}
				},
				"columns" : [
					{"data":"id", width: "20px"},
					{"data":"stage", width: "20px"},
					{"data":"mode"},
					{"data":"doneActor"},
					{"data":"currScore"}
					],

			});
		
			$('#dt_general tbody').on( 'click', 'tr', function () {
					$(this).toggleClass('row_selected');
			});
			
			dt_rp_general = $('#dt_rp_general').DataTable({
				
					"processing": true, 
				"serverSide": true,
				"autoWidth": false,
				"deferRender":    true,
				"scrollX": 		true,
				"scrollY": 		500,
				"scrollCollapse": true,
				"scroller":       true,
				"searching": 			true,
				"paging":false,
				"info": 					false,
				"ajax": {
					"url": "<?php echo site_url('myjob')?>",
					"type": "POST",
					data : {stype: "xreviewpos"}

				},
				"columns" : [
					{"data":"id"},
					{"data":"wfid"},
					{"data":"type"},
					{"data":"accoffice"},
					{"data":"procStat"},
					{"data":"status"},
					{"data":"data",
					align:"left"},
					],
					columnDefs: [
						{
							"render": function (data, type, full, meta) {
								return "<div class='text-wrap width-200'>" + data + "</div>";
							},
							"targets": 6,
						}
					],

			});
			
			$('#table-filter').on('change', function(){
			   dt_rp_general.search(this.value).draw();   
			});
		
			 $('#dt_rp_general tbody').on( 'click', 'tr', function () {
					$(this).toggleClass('row_selected');
			});
			
		});
		
		function mark(mtype){
			var ids = [];
			tab.rows(".row_selected").every(function(){
					ids.push(this.data().id);
			});
			
			$.ajax({
				url : "<?php echo site_url('rscsrc_mark')?>",
				type: "POST",
				data: {'mtype': mtype, 'ids': ids },
				dataType: "JSON",
				success: function(data)
				{
						tab.ajax.reload();
				}
				
			});
		}
		function wf_mark(mtype){
			var ids = [];
			dt_general.rows(".row_selected").every(function(){
					ids.push(this.data().id);
			});
			
			$.ajax({
				url : "<?php echo site_url('test/wf_mark')?>",
				type: "POST",
				data: {'mtype': mtype, 'ids': ids },
				dataType: "JSON",
				success: function(data)
				{
						dt_general.ajax.reload();
				}
				
			});
		}
		function rp_mark(mtype){
			var ids = [];
			dt_rp_general.rows(".row_selected").every(function(){
					ids.push(this.data().id);
			});
			
			$.ajax({
				url : "<?php echo site_url('test/rp_mark')?>",
				type: "POST",
				data: {'mtype': mtype, 'ids': ids },
				dataType: "JSON",
				success: function(data)
				{
						dt_rp_general.ajax.reload();
				}
				
			}); 
		}
		   

	</script>
		
	
	
	
</body>
</html>