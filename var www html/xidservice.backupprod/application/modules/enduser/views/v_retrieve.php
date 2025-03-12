<script type="text/javascript">

	
	$(document).ready(function(){
		
	});
	
	function show_toast(isSuccess, msg){
		if (isSuccess){
			$("#flash-msg").addClass("alert-success");
		} else {
			$("#flash-msg").addClass("alert-warning");
		}
		$("#ifa_txt").html(msg);
		
		$("#flash-msg").fadeIn(500);
		$("#flash-msg").delay(3000).fadeOut("slow")
	}
	
	function bc_submit(stype){
			var fdata = {"reqtype" : stype};
			//show_toast(false, stype);
			var sdate = new Date();
			//show_toast(true, sdate.toLocaleTimeString() + " " + stype);
			$.ajax({
				url : "<?php echo site_url('')?>sysrequest",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function(data)
				{
					var edate = new Date();
					var ddate = edate - sdate;
					show_toast(true, edate.toLocaleTimeString() + " " + stype + " " + data);
					//update_view(data);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Submit Fail');
				}
			});
		};
	
		function verification()
				{
			var url = "<?php echo site_url('itservice/Xmain/handle')?>" ;
			var fdata = {'reqtype': 'setTarget', 'npp' : $("#npp").val(), 'target' : $("#target").val(), 'mobileNumber' : $("#mobileNumber").val()};
			$('#pretext').text('User Tidak Tersedia'); 
			$('#reqtype').val('tellinq'); 
			$.ajax({
				url : url,
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function(data)
				{
					$('#pretext').text(data['res']);
					//alert('testing');
					if (data['status'].startsWith('Ok')){
								$('#nama').val(data['name']); 
								
								$('#branchcode').val(data['branchcode']);
								
								//addnew ryanda
								$('#grouptransc').val(data['grouptransc']);
								$('#lvlcap').val(data['lvlcap']);
								$('#securitycode').val(data['securitycode']);
								//addnew ryanda
								
								//$('#pretext').text(JSON.stringify(data)); 
								console.log(JSON.stringify(data)); 
								$('#pretext').text('I T  >> '  + data['loginStatus']); 
							} else {
								$('#nama').val("---"); 
								$('#pretext').text('Not Valid'); 
							}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Error adding / update data');
					$('#btnSave').attr('disabled',false); 
				}
			});
/* 					var url = "<?php echo site_url('itservice/xmain/handle')?>" ;
					
					var fdata = {'reqtype': 'resetTarget', 'npp' : $("#npp").val(), 'target' : $("#target").val(), 'mobileNumber' : $("#mobileNumber").val()};
					$('#pretext').text('User Tidak Tersedia'); 
					$('#reqtype').val('tellinq'); 
					$.ajax({
						url : url,
						type: "POST",
						data: fdata,
						dataType: "JSON",
						success: function(data)
						{
							console.log(data);
							if (data['status'].startsWith('Ok')){
								$('#nama').val(data['name']); 
								
								$('#branchcode').val(data['branchcode']);
								
								//addnew ryanda
								$('#grouptransc').val(data['grouptransc']);
								$('#lvlcap').val(data['lvlcap']);
								$('#securitycode').val(data['securitycode']);
								//addnew ryanda
								
								//$('#pretext').text(JSON.stringify(data)); 
								console.log(JSON.stringify(data)); 
								$('#pretext').text('I T  >> '  + data['loginStatus']); 
							} else {
								$('#nama').val("---"); 
								$('#pretext').text('Not Valid'); 
							}
							
							//$('#btnSave').attr('disabled',false); //set button enable 
						},
						
						error: function (jqXHR, textStatus, errorThrown)
						{ 
							alert('Error adding / update data');
							$('#btnSave').text('save'); //change button text
							$('#btnSave').attr('disabled',false); //set button enable 
						}
					}); */
				}
</script>

<style>
#tb_action button { width: 100px }
.catlabel {width: 100px }
</style>

 <div id="page-wrapper">
            <center><div class="row" style="width:61%;">
				
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body" >
                            <div class="row">
							    <div class="col-lg-12">
									<center><h1 class="page-header">Retrieve Password</h1></center>
								</div>
                                <div class="col-lg-12">
						<form action="#" role="form" class="form-horizontal" style="margin-left:3%; margin-right:-11%"> 	
							<input type="hidden" value="" name="reqtype" id="reqtype"/>
							<div class="form-group row">
								<label class="col-xs-3" style="left:-4%; height: 30px; font-size: 90%;">Input Token</label> 
								<div class="col-xs-6" style="left:-7%; width:75%; margin-left: -4%">	
									<input style="height: 30px; font-size: 90%" name="token" id="token" placeholder="-- Input Token --" class="form-control" type="text" onclick="$(this).val('');">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xs-3" style="left:-5%; height: 30px; font-size: 90%;"> Select Target</label> 
								<div class="col-xs-6" style="left:-7%; width:75%; margin-left: -4%">	
									<input style="height: 30px; font-size: 90%" name="target" id="target" placeholder="-- Target --" class="form-control" type="text" onclick="$(this).val('');">
								</div>
							</div>						
							<div class="form-group row">
								<label class="col-xs-3" style="left:-5%; height: 30px; font-size: 90%;">Password</label> 
								<div class="col-xs-6" style="left:-7%; width:75%; margin-left: -4%">	
									<input style="height: 30px; font-size: 90%" name="password" id="password" placeholder="-- password --" class="form-control" type="text" onclick="$(this).val(''); ">
								</div>
							</div>
						<div class="modal-footer"  style="margin-left: -1%; margin-right:11%">
							<div class="col-xs-9"style ="width:103%">
							<button type="button" onclick="bc_submit('get');" class="btn btn-primary">get</button>
							<button type="button" id="btn_release" class="btn btn-danger">Cancel</button>
							</div>
						</div>							
						</form>
						
						<pre id="pretext">
			adasd
		</pre>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div></center>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->