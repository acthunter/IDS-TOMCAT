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
</script>

<style>
#tb_action button { width: 100px }
.catlabel {width: 100px }
</style>
<div class="alert alert-dismissable" style="text-align: right;" id="flash-msg">
<h4><i class="icon fa fa-check" id="ifa_txt"></i></h4>
</div>

	<table border="0" cellspacing="50">
		<thead>
			<tr><th class="catlabel"></><th style="width: 100px;">Action</th><th>Desc</th></tr>
			<tbody id="tb_action">
				<tr><td rowspan="2" >Banc</td><td><button type="button" onclick="bc_submit('initMUX');" class="sysbutton btn btn-primary">InitMUX</button></td><td>Restart Banc Connection</td></tr>
				<tr><td></td><td collspan="2" >-</td></tr>
				<tr><td rowspan="2" >Front End</td>
				<td><button type="button"  onclick="bc_submit('prepareRequest');" class="btn btn-primary">Prep Req</button></td><td>Prepare Change Position Start-EndDate</td></tr>
				<tr><td><button type="button"  onclick="bc_submit('scanRequest');" class="btn btn-primary">Scan Req</button></td><td>Create BackEnd MasterRequest from FrontEnd workflow</td></tr>
				<tr><td >-</td><td><button type="button"  onclick="bc_submit('loadRequest');" class="btn btn-primary">Load Req</button></td><td>Split form Xrequest to TransitRepo</td></tr>
				<tr><td rowspan="2" >Back End</td>
				<td><button type="button" onclick="bc_submit('createResource');" class="btn btn-primary">Create Res</button></td><td>Split to target System Resource </td></tr>
				<tr><td><button type="button"  onclick="bc_submit('dispatchResource');" class="btn btn-primary">Dispatch Res</button></td><td>Dispatch Target system resource</td></tr>
				<tr><td rowspan="2" >Password Delivery</td>
				<tr><td></td><td collspan="2" >-</td></tr>
				<tr><td >-</td><td><button type="button"  onclick="bc_submit('activateXR');" class="btn btn-primary">activateXR</button></td><td>Aktivasi xrequest untuk diproses</td></tr>
				<tr><td >-</td><td><button type="button"  onclick="bc_submit('loadRequest');" class="btn btn-primary">Load Request</button></td><td>Split xrequest ke transitRepo</td></tr>
				<tr><td >-</td><td><button type="button"  onclick="bc_submit('trCreateValidation');" class="btn btn-primary">trCreateValidation</button></td><td>Create Data xrequest ke xvalidation</td></tr>
				<tr><td >-</td><td><button type="button"  onclick="bc_submit('valGroupQueueing');" class="btn btn-primary">valGroupQueing</button></td><td>Create Group Queueing di xqueue</td></tr>
				<tr><td >-</td><td><button type="button"  onclick="bc_submit('activateTR');" class="btn btn-primary">activateTR</button></td><td>Scan transitRepo, change status transitRepo</td></tr>
				<tr><td >-</td><td><button type="button"  onclick="bc_submit('splitManaged');" class="btn btn-primary">splitmanaged</button></td><td>Split into managed, unmanaged, given</td></tr>
				<tr><td >-</td><td><button type="button"  onclick="bc_submit('assignMasterPassword');" class="btn btn-primary">AssignPassword_1</button></td><td>Give Master Password, all user per reqid</td></tr>
				<tr><td >-</td><td><button type="button"  onclick="bc_submit('assignMasterPassword_test');" class="btn btn-primary">AssignPassword_2</button></td><td>Give Master Password, different per user per reqid</td></tr>
				<tr><td >-</td><td><button type="button"  onclick="bc_submit('readytosend');" class="btn btn-primary">readytosend</button></td><td>Ready to Deliver</td></tr>
				<tr><td >-</td><td><button type="button"  onclick="bc_submit('sendReqToUser');" class="btn btn-primary">sendrequest</button></td><td>Deliver Pass to User</td></tr>
				<tr><td >-</td><td><button type="button"  onclick="bc_submit('createUserOnlineDelivery');" class="btn btn-primary">createUserOnlineDelivery</button></td><td>Create user</td></tr>
				<tr><td >-</td><td><button type="button"  onclick="bc_submit('userChecking');" class="btn btn-primary">userChecking</button></td><td>Check User</td></tr>
			</tbody
		</thead>
	</table>
	
	
	
	
	
	
	

