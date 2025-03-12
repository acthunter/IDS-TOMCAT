<script type="text/javascript">
	var def_secure_timeout=50;
	var timeout;
	var clean_timer;
	$(document).ready(function(){
		idaction();
	});
	
	function idaction (nextStep, status){
		action();
	}
	
	function action(){
			var url = "<?php echo site_url('sys_login_list')?>";
			$.ajax({
				url : url,
				type: "GET",
				dataType: "JSON",
				crossDomain:true,
				success: function(data)
				{	
					$('#xrsc_created').val(data.sql_xrsc_created);
					$('#loginstatus').val(data.loginStatus);
					$('#xdispatch').val(data.sql_xdispatch);
				
					if (data.sql_xrsc_created == '0'){
						$("#xrsc_created").css("background-color","#0F0");
					} else if (data.sql_xrsc_created > '0'){
						$("#xrsc_created").css("background-color","#EA3722");
					}

					if (data.loginstatus != 'login-ok'){
						$("#loginstatus").css("background-color","#0F0");
					} else {
						$("#loginstatus").css("background-color","#EA3722");
					}
					
					if (data.sql_xdispatch == '0'){
						$("#xdispatch").css("background-color","#0F0");
					} else if (data.sql_xdispatch > '0'){
						$("#xdispatch").css("background-color","#EA3722");
					}
				},
				
			});
	}
</script>

<style>

</style>

	<div id ="tokenDiv" style="width: 50%; margin:0 auto;">
		<form action="#" id="form1" style="width: 500px; margin: auto; margin-left: -200px; padding-right: 190px;">
			<p class="formHeader" style="font-size: 30px; text-align: center;">CAS HUB MON</p>
			<div class="form-group row" style="width:90%;margin-left:6%;">
					<p class="row fl-controls-left">
						<label class="judul">Resource Not Created</label> 
						<input name="xrsc_created" id="xrsc_created" value="" class="form-control"  type="text" readonly="true"/>
					</p>	
					<p class="row fl-controls-left">
						<label class="judul">System Login to Icon</label> 
						<input name="loginstatus" id="loginstatus" value="" class="form-control"  type="text" readonly="true"/>
					</p>	
					<p class="row fl-controls-left">
						<label class="judul">Resource Not Dispatch</label> 
						<input name="xdispatch" id="xdispatch" value="" class="form-control"  type="text" readonly="true"/>
					</p>
					</p>
			</div>
		</form>
		
		<form action="#" id="form1" style="width: 500px; margin: auto; margin-left: 200px; padding-right: 190px;margin-bottom: auto;margin-top: -250px;">
			<!--<p class="formHeader" style="font-size: 30px; text-align: center;">LEGEND</p>-->
			<div class="form-group row" style="width:90%;margin-left:6%;">
				<form>
				 <fieldset>
				  <legend>LEGEND</legend>
				  <input type="text" style="background-color:#0F0;" disabled> : Normal<br>
				  <br>
				  <input type="text" style="background-color:#EA3722;" disabled> : Allert<br>
				 </fieldset>
				</form>	
					
			</div>
		</form>
	</div>
