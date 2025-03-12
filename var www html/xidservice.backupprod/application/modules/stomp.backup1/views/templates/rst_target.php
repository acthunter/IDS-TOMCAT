<script type="text/javascript">
		
	
	function  <?php echo $modal_id;?>_trigger(fdata){
		var t;
		$('#ok_tabel').hide();
		$('#div_btn_<?php echo $modal_id;?> button').hide();
		var counter = 1 ;
		if (fdata['reqtype'] != "new"){
			$.ajax({
					url : "<?php echo site_url('')?>" + fdata['url'],
					type: "POST",
					data: fdata,
					dataType: "JSON",
					success: function(wdata){
						var data = wdata['detail'];
						var rdata = data['isi'];
						console.log(wdata);		
						
						/* alert( JSON.stringify(rdata));
						 $.each(rdata,function(i,o){
							alert(o);
						}); */
						$('#wfid').val(wdata['id']);
					
					 t = $('#example').DataTable({
						"destroy": true,"searching": false,"bLengthChange": false,"bInfo" : false,  "paging": true,"pageLength": 5,
						"drawCallback": function(settings) {
							var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
							pagination.toggle(this.api().page.info().pages > 1);
						  },
						"data" : rdata,
						"fnCreatedRow": function (row, data, index) {
							$('td', row).eq(0).html(index + 1);
						}
						
					}); 
					$("#srctype").val(data['srctype']);
					$('#example').removeClass('dataTable');
					$('#tipe').find(':radio[name=same][value="'+data['srctype']+'"]').prop('checked', true);
					for (val of wdata["eaction"]){
							$("#<?php echo $modal_id;?>_btn_" + val).show();
						}
					if (data['srctype'] == 'sr'){
						$("#ok2, #ok4").css("display","block");
						$("#nosr").val(data['key1']);
						/* var s = new Date(data['doc_date']);
						var dd = s.getDate();
						var mm = s.getMonth()+1;
						if(dd<10)  { dd='0'+dd } if(mm<10)  { mm='0'+mm }
						var y = s.getFullYear()+'-'+mm+'-'+dd;
						$("#doc_date").val(y); */
						var e = data['doc_date'];
						doc_date = e.split(' ');
						//alert(a)
						
						$('#doc_date').val(doc_date[0]);
					}
					if (data['srctype'] == 'rm'){
						$(" #ok4, #ok3").css("display","block");
						$("#inc").val(data['key1']);
						/* var s = new Date(data['doc_date']);
						var dd = s.getDate();
						var mm = s.getMonth()+1;
						if(dd<10)  { dd='0'+dd } if(mm<10)  { mm='0'+mm }
						var y = s.getFullYear()+'-'+mm+'-'+dd;
						$("#doc_date").val(y); */
						var e = data['doc_date'];
						doc_date = e.split(' ');
						//alert(a)
						
						$('#doc_date').val(doc_date[0]);
					}
					if (wdata['stage'] != '1'){
						$('input[type=radio]').attr('disabled', true);
						var arr_ro = "doc_date,nosr,inc".split(",");
							for(cid of arr_ro){
								$('#' + cid).attr('readonly', true).css('pointer-events', 'none');
							}
						$('#btn_add').hide();
					}else{
						$('#btn_add').show();
					}
					
					
					}
			});
		}else {
			$('#<?php echo $modal_id;?>_form #btn_save, #btn_add').show();
			$("#srctype").val('cm');
		}

		$("input:radio").click(function(){
			if($('input[name="same"]:checked').val() == 'sr') {
				$("#ok2, #ok4, #ok3").css("display","block");
			}else{
				$("#ok2, #ok4, #ok3").css("display","none");
			}
			$("#srctype").val($('input[name="same"]:checked').val());
		});
		
		 var t = $('#example').DataTable({"searching": false,"bLengthChange": false,"bInfo" : false,  "paging": true,"pageLength": 5,
		   drawCallback: function(settings) {
    var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
    pagination.toggle(this.api().page.info().pages > 1);
  }});
		$('#addlevel').on('click', function(){
			$('#npp2').val($('#npp').val());
			var url = "<?php echo site_url('itservice/Xmain/lookup_apps')?>" ;
 			$.ajax({
				url : url,
				type: "POST",
				//data: fdata,
				dataType: "JSON",
				success: function(data)
				{
					//alert(JSON.stringify(data));
					$.each(data.opts, function (index, item) {
						//alert(item['apps']);
						$("#list_apps2").append("<tr class='checklisttr'><td>"+ item['apps'] +"</td><td><input type='radio' id ='b' value='rst' name="+item['apps'] +" ></td><td><input type='radio' id ='b' value='new' name="+item['apps'] +" ></td></tr>");
						  });
						 $("#ok_tabel2,  ok").show();
					/* if (data.opts != '') {
					$('#addlevel').hide();						
					$.each(data.opts, function (index, item) {
						$("#list_apps").append("<tr class='checklisttr "+ item['kelas'] +"'><td>"+ item['desc'] +"</td><td><input type='radio' id ='a' value='rst' name="+item['target'] +" ></td><td><input type='radio' value='new' name="+item['target'] +" id='a'></td></tr>");
						  });
						  document.getElementById('ok').style.display = 'block';
					$("#ok_tabel, button, ok").show();
					}else{
						$('#addlevel').show();
						new PNotify({
							title: 'Notifikasi',
							text: 'User Not Found',
							type: 'error',
							styling: 'bootstrap3'
						});
						//$('#npp').val(""); 
						
					} */
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		});
		 $('#addRow').on( 'click', function () {
			 var $chkbox_checked    = $('input[id="a"]:checked');
                 if($chkbox_checked.length === 0){
                    alert("No Row Selected");
                 }

                 else{
                   
                   var checkboxNameArry = $chkbox_checked.map(function(){
					  // alert(this.name);
                       return [this.name];
                   }).get();;
				   var checkboxValArry = $chkbox_checked.map(function(){
                       return [this.value];
                   }).get();
				   //$val_email = $('#email').val();
				   t.row.add( [
					counter,
					$('#npp').val(),
					//$val_email+"@bni.co.id",
					checkboxNameArry,
					checkboxValArry
				] ).draw( false );
		 
				counter++;
				 }
				 
				
			} );
					 $('#add2').on( 'click', function () {		
			 var $chkbox_checked2    = $('input[id="b"]:checked');
                 if($chkbox_checked2.length === 0){
                    alert("No Row Selected");
                 }

                 else{
                   
                   var checkboxNameArry2 = $chkbox_checked2.map(function(){
					  // alert(this.name);
                       return [this.name];
                   }).get();;
				   var checkboxValArry2 = $chkbox_checked2.map(function(){
                       return [this.value];
                   }).get();;
				   t.row.add( [
					counter,
					$('#npp').val(),
					checkboxNameArry2,
					checkboxValArry2
				] ).draw( false );
		 
				counter++;
				 }
				
				$('#npp').val('').text('');$('#ok_tabel2 tbody tr').empty();$('#addlevel').hide();
			} );
		   $('#btn_submit').click( function() {
			  var TableData;
			  TableData = storeTblValues()
				TableData = JSON.stringify(TableData);
				$("#app").val(TableData);
				//rst_submit(TableData);
				 t.clear().draw();
				
				
		   }); 
		$('#example').removeClass('dataTable');
		document.getElementById('ok').style.display = 'none';
		$('#doc_date').datetimepicker({
            ignoreReadonly: true, widgetPositioning: { vertical: 'bottom' }
        }).data('DateTimePicker').format('YYYY-MM-DD');
		$('#savechecklist').click(function() {
			var the_value;
			the_value = getChecklistItems();
			console.log(the_value);
		});
		$(document).on("change", ".rst_pass", function() {

		if(($('#accoffice').val() != "") && ($('#npp').val() != "")){
			
		var fdata = {'loginid' :$('#npp').val(),'accoffice':$('#accoffice').val()};
		var ar = t.column( 1 ).data().toArray();
		var get_npp = JSON.parse('["' + $('#npp').val()+ '"]');
		var arr = ar.concat(get_npp);
		var uniqOb = {};
		  for (var i in arr)
			uniqOb[arr[i]] = "";
		  if (arr.length == Object.keys(uniqOb).length){
			  		var url = "<?php echo site_url('itservice/Xmain/lookup_user')?>" ;
 			$.ajax({
				url : url,
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function(data)
				{
					//alert(JSON.stringify(data));
					var wdata = data['opts'];
					//alert(wdata.length);
					if (wdata.length > 0){
					$.each(data.opts, function (index, item) {
						//alert(item['apps']);
						$("#list_apps").append("<tr class='checklisttr "+ item['utype'] +"'><td>"+ item['apps'] +"</td><td><input type='radio' id ='a' value='rst' name="+item['apps'] +" ></td><td><input type='radio' id ='a' value='new' name="+item['apps'] +" ></td></tr>");
						  });
						 $("#ok_tabel, button, ok").show(); 
					}else{
						alert("Data Not Found");
						$('#npp,#accoffice').val('').text('');$('#ok_tabel tbody tr').empty();$('#ok_tabel').hide();
					}
					/* if (data.opts != '') {
					$('#addlevel').hide();						
					$.each(data.opts, function (index, item) {
						$("#list_apps").append("<tr class='checklisttr "+ item['kelas'] +"'><td>"+ item['desc'] +"</td><td><input type='radio' id ='a' value='rst' name="+item['target'] +" ></td><td><input type='radio' value='new' name="+item['target'] +" id='a'></td></tr>");
						  });
						  document.getElementById('ok').style.display = 'block';
					$("#ok_tabel, button, ok").show();
					}else{
						$('#addlevel').show();
						new PNotify({
							title: 'Notifikasi',
							text: 'User Not Found',
							type: 'error',
							styling: 'bootstrap3'
						});
						//$('#npp').val(""); 
						
					} */
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			}); 
		  }else{
				
			alert('Data already exists');
			$('#npp,#accoffice').val('').text('');

		  }
		}
	});
	};
		function query()
	{
			var url = "<?php echo site_url('itservice/xmain/valid_priv')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: {"npp": $('#npp').val()},
				dataType: "JSON",
				success: function(data)
				{
					if (data.opts != '') {
					$('#addlevel').hide();						
					$.each(data.opts, function (index, item) {
						$("#list_apps").append("<tr class='checklisttr "+ item['kelas'] +"'><td>"+ item['desc'] +"</td><td><input type='radio' id ='a' value='rst' name="+item['target'] +" ></td><td><input type='radio' value='new' name="+item['target'] +" id='a'></td></tr>");
						  });
						  document.getElementById('ok').style.display = 'block';
					$("#ok_tabel, button, ok").show();
					}else{
						$('#addlevel').show();
						new PNotify({
							title: 'Notifikasi',
							text: 'User Not Found',
							type: 'error',
							styling: 'bootstrap3'
						});
						//$('#npp').val(""); 
						
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
	}
	
	function modal(){
			$('#ok_tabel').hide();
			if (($('input[name="same"]:checked').val() == 'cm')|| ($('input[name="same"]:checked').val() == 'rm')) {
				//document.getElementById('ok_tabel');
				$('#npp').val();
				$('#ok').hide();
				//document.getElementById('ok3').style.display = 'block';
				document.getElementById('ok2').style.display = 'none';
				document.getElementById('ok4').style.display = 'none';		
			}else if($('input[name="same"]:checked').val() == 'sr') {
				$('#npp').val();
				$('#ok').hide();
				document.getElementById('ok2').style.display = 'block';
				document.getElementById('ok4').style.display = 'block';				
				document.getElementById('ok3').style.display = 'block';
			}else{
				$('#ok').hide();
				document.getElementById('ok3').style.display = 'none';
				document.getElementById('ok2').style.display = 'none';
				document.getElementById('ok4').style.display = 'none';
			}
	}
		function storeTblValues()
	{
		var TableData = new Array();

		$('#example tr').each(function(row, tr){
			TableData[row]={
				"npp" : $(tr).find('td:eq(1)').text()
				, "apps" :$(tr).find('td:eq(2)').text()
				, "req" : $(tr).find('td:eq(3)').text()
			}    
		}); 
		TableData.shift();
		return TableData;
	}
	function <?php echo $modal_id;?>_submit(btype){
		$('#doc_date,#nosr,#inc').removeAttr('disabled');
		var fdata = {'url': 'wf/wfaction', 'modal_id' : "<?php echo $modal_id;?>", 'btype': btype };
		//var ar = t.data().toArray();
		//alert(ar);
		//var MyRows = $('#example').find('tbody').find('tr');
		var MyRows = $("#example > tbody > tr:first > td").length;
		//alert(MyRows);
		if ( MyRows > 1){
			var TableData;
			  TableData = storeTblValues()
				TableData = JSON.stringify(TableData);
				$("#app").val(TableData);		
		var isValid = $("#<?php echo $modal_id;?>_form").valid();
		console.log(isValid);
		if (isValid)
			action_submit(fdata);
		}else{
			alert("Silahkan input data terlebih dahulu")
		}
		
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
tr.C {
    background: #FFFACD;
}
tr.U {
	background: #FFBC8F;
}
#example tbody{
	background-color: white;
}
</style>
<div class="container">
  <!-- Modal -->
  <div class="modal fade"  id="<?php echo $modal_id;?>_content" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-body">
			 <div id="wrap">
		<form   id="<?php echo $modal_id;?>_form"style=" margin: auto;">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Reset Password</p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row" style="width:90%;margin-left:6%;">
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
					<table id="example"style="text-align:center; width:100%;" class="table table-bordered">
						<thead  style="background-color: #b3b3b3;">
							<tr >
								<th style="text-align:center">No</th>
								<th style="text-align:center">NPP</th>
								<th style="text-align:center">Apps</th>
								<th style="text-align:center">Req</th>
							</tr>
						</thead>
					</table>
				</p>
				<input name="id" id="id" class="form-control" type="hidden" >
				<input name="app" id="app" class="form-control" type="hidden"  >
				<input name="mode" id="mode" class="form-control" type="hidden" value="RS" >
				<input name="srctype" id="srctype" class="form-control" type="hidden"  >					
				<input name="wfid" id="wfid" class="form-control" type="hidden" >
				<input name="notes" id="notes" class="form-control" type="hidden" >		
				<input name="accoffice" id="accoffice" class="form-control" type="hidden" >					
				<p class="signin button" id="div_btn_<?php echo $modal_id;?>"style="margin-left:3%; width: 100%;">
					<button type="button" id="btn_add" class="btn btn-info" data-toggle="modal" onclick="modal(); $('#npp, #accoffice').val('');"data-target="#myModal" >Add Data</button>
					<button type="button" id="btn_save" onclick="<?php echo $modal_id;?>_submit('save')" class="btn btn-primary">Save</button>
					<!--<button type="button" id="btn_submit" class="btn btn-primary">Submit</button>-->
					<button type="button" id="<?php echo $modal_id;?>_btn_submit" onclick="<?php echo $modal_id;?>_submit('submit')" class="btn btn-primary">Submit</button>
					<button type="button" id="<?php echo $modal_id;?>_btn_cancel" onclick="<?php echo $modal_id;?>_submit('cancel')" class="btn btn-danger">Cancel</button>
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

<div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
         <form  id="form" style="width: 500px; margin: auto;">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Reset Password</p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row" style="width:90%;margin-left:6%;">			
				<p class="rst_pass" >
					<label style="color: rgb(64, 92, 96);">NPP</label> 
					<input type='text' id='npp' name='npp' class="form-control" placeholder="NPP" onclick="$('#npp,#accoffice').val('').text('');$('#ok_tabel tbody').empty();$('#ok_tabel').hide();">
				</p>
				<p  class="rst_pass" >
					<label style="color: rgb(64, 92, 96);">Accoffice</label> 
					<input type='text' id='accoffice' name='accoffice' class="form-control" placeholder="Kode Unit"onclick="$('#npp,#accoffice').val('').text('');$('#ok_tabel tbody').empty();$('#ok_tabel').hide();">
				</p>
				<p id="ok" style="display:none;" >
					<label style="color: rgb(64, 92, 96);">Aplikasi</label> 
					<table id="ok_tabel" class="table table-bordered">
						<thead >
						  <tr style="background: #F6F6F6;">
							<th>Nama Aplikasi</th>
							<th>Reset</th>
							<th>New</th>
						  </tr>
						</thead>
						<tbody id="list_apps">
						</tbody>
					</table>
				</p>					
				<p class="signin button" style="margin-left:3%; width: 100%;">
					<button type="button" id="addRow" data-dismiss="modal" class="btn btn-success">Add</button>
					<button type="button" id="addlevel" class="btn btn-danger" data-toggle="modal" data-target="#myModal2" data-dismiss="modal" >+</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
				</p>
			</div>							
		</form>
    </div>
</div>

<div class="modal fade" id="myModal2" role="dialog">
      <div class="modal-dialog">
         <form  id="form" style="width: 500px; margin: auto;">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Reset Password</p>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row" style="width:90%;margin-left:6%;">			
				<p >
					<label style="color: rgb(64, 92, 96);">NPP</label> 
					<input type='text' id='npp2' name='npp2' class="form-control" placeholder="NPP">
				</p>		
				<p id="ok" style="display:none;" >
					<label style="color: rgb(64, 92, 96);">Aplikasi</label> 
					<table id="ok_tabel2" class="table table-bordered">
						<thead >
						  <tr style="background: #F6F6F6;">
							<th>Nama Aplikasi</th>
							<th>Reset</th>
							<th>New</th>
						  </tr>
						</thead>
						<tbody id="list_apps2">
						</tbody>
					</table>
				</p>					
				<p class="signin button" style="margin-left:3%; width: 100%;">
					<button type="button" id="add2" data-dismiss="modal" class="btn btn-success">Add</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
				</p>
			</div>							
		</form>
    </div>
</div>


