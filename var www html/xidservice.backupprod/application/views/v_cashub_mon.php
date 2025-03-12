<script type="text/javascript">
	var sensorMap = {
		"tot_xrsc_created" : [1,3],
		"xresource" : [1,1]
	};
	$(document).ready(function(){
		$( "#det_xrsc_created, #det_xdispatch" ).hide();
		
		idaction();
		//getStatus();
		
    
	});
	
	function idaction (){
		action();
	}
	
	function getStatus(criteria, val){
		var carr = sensorMap[criteria];
		var ret = "unknown";
		if (carr != null){
			if (val >= carr[1])
				ret = $("#xrsc_created").css("background-color","#0F0");
			else if (val >= carr[0])
				ret = $("#xrsc_created").css("background-color","#EA3722");
			else ret = "normal";
		}
		return ret;
	}
	
	function action(){
			var x = "", i, y = "";
			var url = "<?php echo site_url('sys_login_list')?>";
			$.ajax({
				url : url,
				type: "GET",
				dataType: "JSON",
				crossDomain:true,
				success: function(data)
				{	
					var test = data; 
					$('#xrsc_created').val(data.tot_xrsc_created);
					for (i in data.det_xdispatch) {
						x += "<tr><td>"+data.det_xdispatch[i].id+"</td><td>"+ data.det_xdispatch[i].refid+"</td></tr>" ;
					}
					document.getElementById("det_xdis").innerHTML = x;
					for (i in data.det_xrsc_created) {
						y += "<tr><td>"+data.det_xrsc_created[i].id+"</td>" ;
					}
					document.getElementById("det_created").innerHTML = y;
					$('#loginstatus').val(data.loginStatus);
					$('#tot_xapproval').val(data.tot_xapproval);
					$('#tot_xrsc_created').val(data.tot_xrsc_created);
					$('#xdispatch').val(data.tot_xdispatch);
					
					//if (typeof data.det_xdispatch != null){
						//$('#loginstatus').val(data.det_xdispatch[0]['id']);
					//}-->
						
					if (data.loginStatus == 'login-ok'){
						$("#loginstatus").css("background-color","#0F0");
					} else {
						$("#loginstatus").css("background-color","#EA3722");
					}
					
					if (data.tot_xapproval > '0'){
						//$("#btn_xrsc_created").show();
						$("#tot_xapproval").click(function(){
							$("#det_xrsc_created").toggle();
						});
						$("#tot_xapproval").css("background-color","#EA3722");
					} else {
						$("#tot_xapproval").css("background-color","#0F0");
					}
					
					if (data.tot_xrsc_created > '0'){
						//$("#btn_xrsc_created").show();
						$("#tot_xrsc_created").click(function(){
							$("#det_xrsc_created").toggle();
						});
						$("#tot_xrsc_created").css("background-color","#EA3722");
					} else {
						$("#tot_xrsc_created").css("background-color","#0F0");
					}

					
					if (data.tot_xdispatch == '0'){
						$("#xdispatch").css("background-color","#0F0");
					} else if (data.tot_xdispatch > '0'){
						$("#xdispatch").click(function(){
							$("#det_xdispatch").toggle();
						});
						$("#xdispatch").css("background-color","#EA3722");
					}
				},
				
			});
	}
</script>

<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
.column {
    float: left;
    width: 50%;
    padding: 10px;
    height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}
</style>	
<div class="row" id ="tokenDiv">
	<p class="formHeader" style="font-size: 30px; text-align:left; padding-left:15%;">CAS HUB MON</p>
  <div class="column"style="padding:0 7% 0 7%;">
	<form action="#" id="form1">
			<div class="form-group row" style="width:90%;margin-left:6%;">
					<p class="row fl-controls-left">
						<label class="judul">System Login to Icon</label> 
						<input name="loginstatus" id="loginstatus" value="" class="form-control"  type="text" readonly="true"/>
					</p>	
					
					<p class="row fl-controls-left">
						<label class="judul">Request Belum Di Approve</label> 
						<input name="tot_xapproval" id="tot_xapproval" value="" class="form-control"  type="text" readonly="true"/>
					</p>	
					
					<p class="row fl-controls-left">
						<label class="judul">Resource Tidak Terbentuk</label> 
						<input name="tot_xrsc_created" id="tot_xrsc_created" value="" class="form-control"  type="text" readonly="true"/>
						<table id="det_xrsc_created">
							<thead>
								<tr>
									<th>ID</th>
								</tr>
							</thead>
							<tbody  id="det_created">
							</tbody>
						</table>
					</p>	
					<p class="row fl-controls-left">
						<label class="judul">Resource Tidak Diproses</label> 
						<input name="xdispatch" id="xdispatch" value="" class="form-control"  type="text" readonly="true"/>
						<table id="det_xdispatch" style="text-align : center;">
							<thead>
								<tr style="text-align : center;">
									<th>ID</th>
									<th>Refid</th>
								</tr>
							</thead>
							<tbody  id="det_xdis">
							</tbody>
						</table>
					</p>
					
			</div>
		</form>
  </div>
  <div class="column"  style="padding-left:10%;" >
	<form action="#" id="form1">
				  <legend>LEGEND</legend>
				  <input type="text" style="background-color:#0F0;" disabled> : Normal<br>
				  <br>
				  <input type="text" style="background-color:#EA3722;" disabled> : Allert<br>
	</form>
  </div>
</div>