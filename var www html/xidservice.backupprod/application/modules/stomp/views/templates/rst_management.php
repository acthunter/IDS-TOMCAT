<script type="text/javascript">
	var t;	
	var checkboxValArry;
	var checkboxNameArry;
	var checkboxNameArry1;
	var checkboxListArry ;
	function  <?php echo $modal_id;?>_trigger(fdata){
		
		$('#ok_tabel').hide();
		$('#div_btn_<?php echo $modal_id;?> button').hide();
		var counter = 1 ;
		t = $('#example').DataTable({"searching": false,"bLengthChange": false,"bInfo" : false,  "paging": true,"pageLength": 5,
		   drawCallback: function(settings) {
				var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
				pagination.toggle(this.api().page.info().pages > 1);
			  },
			  "columns": [
				null,
				null,
				null
			  ]
  });
		if (fdata['reqtype'] != "new"){
			$.ajax({
					url : "<?php echo site_url('')?>" + fdata['url'],
					type: "POST",
					data: fdata,
					dataType: "JSON",
					success: function(wdata){
						var data = wdata['detail'];
						var rdata = data['data'];
						$('#wfid').val(wdata['id']);
						$('#loginid').val(rdata['loginid']);
						$('#mode').val(wdata['mode']);
						$('#loginid').val(data['loginid']);
						$('#mode').val(wdata['mode']);
						$('[name="nama"]').text(data.nama);
						$('[name="nama"]').val(data.nama);
						$('[name="cposname"]').text(data.pname);
						$('[name="cposname"]').val(data.pname);
						/* $.each(data.data, function(i, item) {
							alert(data.data[i].app);
						});​ */
						checkboxListArry = new Array();
						checkboxNameArry = new Array();/* 
						checkboxNameArry = rdata.map(getapp); */
						$('#loginid').attr('disabled', true);
						
						if (wdata['stage'] != '1'){ 
							$.each(data.data, function (index, item) {
								checkboxListArry.push(item.app); 
								checkboxNameArry.push(item.app); 
								t.row.add( [
									item['app'],
									"<input type='radio' class='check' id ='b' value='new' name="+ item['app'] +" checked >",
									"<i class='fa fa-minus' style='font-size:20px;color:black'></i>"
								] ).draw( false );
							});
						}else{
							$.each(data.data, function (index, item) {
								checkboxListArry.push(item.app); 
								checkboxNameArry.push(item.app); 
								t.row.add( [
									item['app'],
									"<input type='radio' class='check' id ='b' value='new' name="+ item['app'] +" checked >",
									"<button id ='del' class='delete' style='background: transparent;border: none !important;color:white; box-shadow: none !important; padding: none !important;, font-size:none !important;' ><i class='fa fa-close' style='font-size:20px;color:red'></i></button>"
								] ).draw( false );
							});
							$('#btn_add').css("display", "inline");
						}
						for (val of wdata["eaction"]){
							$("#<?php echo $modal_id;?>_btn_" + val).show();
						}

					} 
			});
		}else {
			$('#pos_def, #<?php echo $modal_id;?>_btn_add').css("display", "none");
			checkboxNameArry= "";
			checkboxListArry = new Array();
			$('#<?php echo $modal_id;?>_form #btn_save ').show();
			
		}
		
		$('#example tbody').on('click', 'button.delete' , function () {
				var rdata = t.row( $(this).parents('tr') ).data();
				/* var fparam = {'id' : rdata['id'], "mode" : rdata['mode']}; */
				var index = checkboxNameArry.indexOf(rdata[0]);
				if (index > -1) {
				  checkboxNameArry.splice(index, 1);
				}
				t.row( $(this).parents('tr') ).remove().draw(); 
		});
		
		$('#<?php echo $modal_id;?>_btn_add').click( function() {

					$('#npp2').val($('#npp').val());
			var url = "<?php echo site_url('itservice/Xmain/lookup_apps2')?>" ;
 			$.ajax({
				url : url,
				type: "POST",
				//data: fdata,
				data: {"npp": $('#loginid').val()},
				dataType: "JSON",
				
				success: function(data)
				{
					//alert(JSON.stringify(data));
					//$('#wait').modal('hide');
					if (data.opts != null){
						
						$('#addRow, #clear').show();
						popup_data(data.opts);
						
						
					}else{
						if(data.error != -1){
							var text = 'User '+$('#loginid').val()+' tidak memiliki kewenangan aplikasi';
							var type = 'error';
						}else{
							var text = 'User '+$('#loginid').val()+' <b>sudah</b> memiliki kewenangan aplikasi';					
							var type = 'info';
						}
						new PNotify({
							title: 'Notifikasi',
							text: text,
							type: type,
							styling: 'bootstrap3'
						});
					}
					/* var data_val;
					if (data.opts == null){
						data_val = null;
						alert("null");
					}else{
						data_val = 1;
						
					} */
					
					
				},
				
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});

			}); 
			
		$(function() {
		 $("#<?php echo $modal_id;?>_form").validate({
                rules: {
                    loginid: {
                        required: true,
                        minlength: 5,
						digits: true
                    }
                },
                messages: {
					loginid: {
						required: "Please enter loginid",
						minlength: "Your loginid must be at least 5 number long"
					}
                },
				highlight: function (element) {
					$(element).parent().addClass('error')
				},
				unhighlight: function (element) {
					$(element).parent().removeClass('error')
				},
                submitHandler: function(form) {
                    //form.submit();
					console.log("about to submit");
                }
            });
		});
		
	};
	function addapps(){
			
	}
	function popup_data(data2){
		var url = "<?php echo site_url('stomp/xids/popup')?>" ;
			$.ajax({
				url: url,
				type: "POST"
				}).done(function(data) {					
					$('#modal_l2').html(data);
					$.each(data2, function (index, item) {
							//alert(item['apps']);
							if(typeof checkboxNameArry != "undefined"){	
								if (checkboxNameArry.indexOf(item['apps']) > -1){
									$("#list_apps2").append("<tr class='checklisttr'><td>"+ item['apps'] +"</td><td><input class='check' type='radio' id ='a' value='rst' name="+item['apps'] +" checked></td></tr>");
								}else{
									$("#list_apps2").append("<tr class='checklisttr'><td>"+ item['apps'] +"</td><td><input class='check' type='radio' id ='a' value='rst' name="+item['apps'] +" ></td></tr>");
								}
							}else{
							$("#list_apps2").append("<tr class='checklisttr'><td>"+ item['apps'] +"</td><td><input class='check' type='radio' id ='a' value='rst' name="+item['apps'] +" ></td></tr>");
							}
						});
					$('#modal_target_content').modal({show:true});
					process();
				}).fail(function(jqXHR, textStatus) {
					alert("Request failed:  - Please try again.")
				});
	}
	function process(){
		$('#btn_process').on( 'click', function () {
			var counter = 1;
			var isValid = $("#form").valid();
			var $chkbox_checked = $('input[id="a"]:checked');
			if (isValid){
				if($chkbox_checked.length === 0){
					alert("No Row Selected");
					
				}
				else {
					//alert([this.name]);
					checkboxNameArry = $chkbox_checked.map(function(){
						return [this.name];
					}).get();;
					 checkboxValArry = $chkbox_checked.map(function(){
						return [this.value];
					}).get();;
					var fdata = {'app' :checkboxNameArry,'val_app':checkboxValArry};
					//$val_email = $('#email').val();
					var url2 = "<?php echo site_url('stomp/reqmanage/list_popup')?>" ;
					$.ajax({
						url : url2,
						type: "POST",
						data: fdata,
						dataType: "JSON",
						success: function(data)
						{

							var count = 1 ;
							$.each(data, function (index, item) {
							if( checkboxListArry.length == 0){	
								checkboxListArry.push(item.app); 
									t.row.add( [
										item['app'],
										"<input type='radio' class='check' id ='b' value='new' name="+ item['app'] +" checked >",
										"<button id ='del' class='delete' style='background: transparent;border: none !important;color:white; box-shadow: none !important; padding: none !important;, font-size:none !important;' ><i class='fa fa-close' style='font-size:20px;color:red'></i></button>"
									] ).draw( false );
							}else{
								if (checkboxListArry.indexOf(item.app) === -1){
									checkboxListArry.push(item.app); 
									t.row.add( [
										item['app'],
										"<input type='radio' class='check' id ='b' value='new' name="+ item['app'] +" checked >",
										"<button id ='del' class='delete' style='background: transparent;border: none !important;color:white; box-shadow: none !important; padding: none !important;, font-size:none !important;' ><i class='fa fa-close' style='font-size:20px;color:red'></i></button>"
									] ).draw( false );
								}else{									
								}
								
							}								
								count++;
							});
						
							
						}
					});
					
				}
			}else{
				return false;
			}
			$('#modal_target_content').modal('hide');
			
		});
		
	}
		function query_id()
		{		 
			var url = "<?php echo site_url('stomp/xids/query')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: {"npp": $('#loginid').val()},
				dataType: "JSON",
				success: function(data)
				{
					if(data != null){
						
					$('[name="nama"]').text(data.name);
					$('[name="nama"]').val(data.name);
					$('[name="cposid"]').val(data.positionid);
					$('[name="cposname"]').text(data.nama);
					$('[name="cposname"]').val(data.nama);
					$('#pos_def').css("display", "block");
					$('#<?php echo $modal_id;?>_btn_add').css("display", "inline");
					} else{
						alert('User not found');
						$('#nama,#loginid, #cposid, #cposname').val(null);
						$('#nama,#cposname').text("");
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
	function <?php echo $modal_id;?>_submit(btype){
		var TableData;
		TableData = storeTblValues();
		TableData = JSON.stringify(TableData);
		console.log(TableData);
		$('[name="data"]').val(TableData);

		var isValid = $("#<?php echo $modal_id;?>_form").valid();
		var fdata = {'url': 'wf/wfaction', 'modal_id' : "<?php echo $modal_id;?>", 'btype': btype, 'data':TableData };
		if (isValid){
			if ( ! t.data().count() ) {
				alert( 'Silahkan Pilih Aplikasi yang akan di create' );
			}else{
				action_submit(fdata);
			}
		}
				/*  */
			
	} 
	
	function storeTblValues()
	{
		var TableData = new Array();
		var apl = new Array();
		var req_val = new Array();

		t.rows().eq(0).each( function ( index ) {
			var row = t.row( index );
			var data = row.data();
			apl.push(data[0]);
			req_val.push(row.$('input').val());
		} );
		TableData ={
				"apps" :apl
				, "req" :req_val
			}
		return TableData;
	}	
	function remove(array, element) {
	  return array.filter(el => el !== element);
	}
	
</script>
<style>
#<?php echo $modal_id;?>_form label.error {
    color: red;
	font-size: 11px;
	width: 90%;
}
</style>
<div class="container">   
  <!-- Modal -->
    
  <div class="modal fade"  id="<?php echo $modal_id;?>_content" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-body">
			 <div id="wrap">
		<form action="#"  id="<?php echo $modal_id;?>_form"  role="form">
		  
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Request Management</p>
			<p class="judul" align= "center" style="margin-left:28%; width:70%;color: red;" id="lockinfo" ></p>
			<div id="isi">
			<div id="wfinfo" class="infohide"style="margin-right: 8%;margin-left: 9%">
				<label for="doneActor">Done</label> <ul id="doneActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
				<label for="currActor">Curr</label> <ul id="currActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
			</div>
			<div class="form-group row" style="width:90%;margin-left:6%;">
				<label style="color: rgb(64, 92, 96);font-family: Big Caslon, Book Antiqua, Palatino Linotype, Georgia, serif;" >LoginID</label>
					<label  style="float: right;margin-right: 60px;color: rgb(64, 92, 96);font-family: Big Caslon, Book Antiqua, Palatino Linotype, Georgia, serif;" id="pos_def" >Posisi Definitif</label>
				<p id="l-login">					
					<input style="width: 20%" name="loginid" id="loginid" placeholder="Login ID" class="column-full form-control" type="text" onchange="query_id()" onclick="$('#loginid, #nama,#cposname,#tposname, #tposid').val('').text('');$('#pos_def, #btn_add').css('display', 'none');">
					<label name="nama" class="labelisi" id="nama" ></label>
					<input name="nama" id="nama" readonly type="hidden">
					<label for="nama"  class="labelisi" name="cposname" id="cposname" ></label>
					<input name="cposname" id="cposname" readonly type="hidden">
				</p>
				<p>
				<label style="color: rgb(64, 92, 96);width: 100%;">Aplikasi</label> 
					<table id="example"style="text-align:center;table-layout: fixed;" class="table table-bordered">
						<thead  style="background-color: #b3b3b3;">
							<tr >
								<th style="text-align:center">Nama Aplikasi</th>
								<th style="text-align:center">Create</th>
								<th style="text-align:center">Action</th>
							</tr>
						</thead>
					</table>
				</p>
				<input name="status" id="status" class="form-control" type="hidden" >
					<input name="id" id="id" class="form-control" type="hidden" >
				<input name="mode" id="mode" class="form-control" type="hidden" value="RC" >
				<input name="wfid" id="wfid" class="form-control" type="hidden" >
				<input name="reqtype" id="reqtype" class="form-control" type="hidden" >	
				<input name="data" id="data" class="form-control" type="hidden" >	
				<input name="notes" id="notes" class="form-control" type="hidden" >
				<p class="signin button" id="div_btn_<?php echo $modal_id;?>" style="margin-left:3%; width: 100%;">
						<button type="button" style="width: unset;" id="<?php echo $modal_id;?>_btn_add" class="btn btn-primary">Tambah Aplikasi</button>
						<button type="button" id="btn_save" onclick="<?php echo $modal_id;?>_submit('save')" class="btn btn-primary">Save</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_submit" onclick="<?php echo $modal_id;?>_submit('submit')" class="btn btn-primary">Submit</button><button type="button" id="<?php echo $modal_id;?>_btn_submit" onclick="<?php echo $modal_id;?>_submit('submit')" class="btn btn-primary">Submit</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_cancel" onclick="<?php echo $modal_id;?>_submit('cancel')" class="btn btn-danger">Cancel</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_approve" onclick="<?php echo $modal_id;?>_submit('approve')" class="btn btn-primary">Approve</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_reject" onclick="<?php echo $modal_id;?>_submit('reject')" class="btn btn-danger">Reject</button>
						<button type="button" id="<?php echo $modal_id;?>_btn_release" onclick="<?php echo $modal_id;?>_submit('release')" class="btn btn-default">Release</button>
				</p>
				</div>
			</div>							
		</form>
	</div>
        </div>
    </div>
  </div>


</div>