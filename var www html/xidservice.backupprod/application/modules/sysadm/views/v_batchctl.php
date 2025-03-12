<script type="text/javascript">

	function update_view(data){
		var holder = $('#div_batchMode');
		holder.empty();
		$.each(data['batchModeList'], function(idx, value){
			cb = $("<input type='checkbox'>")
				.attr("id", value).attr("name", "batchMode[]").
				attr("value", value);
			if ($.inArray(value, data['batchMode']) != -1)
				cb.attr("checked", true);
			lbl = $("<label>").text(value);
			holder.append(cb);
			holder.append(lbl);
			holder.append($("<br>"));
		});
		
		var holder = $('#div_rsc_generate');
		holder.empty();
		$.each(data['resourceList'], function(idx, value){
			cb = $("<input type='checkbox'>")
				.attr("id", value).attr("name", "generateResource[]").
				attr("value", value);
			if ($.inArray(value, data['generateResource']) != -1)
				cb.attr("checked", true);
			lbl = $("<label>").text(value);
			holder.append(cb);
			holder.append(lbl);
			holder.append($("<br>"));
		});
		
		var holder = $('#div_rsc_dispatch');
		holder.empty();
		$.each(data['resourceList'], function(idx, value){
			cb = $("<input type='checkbox'>")
				.attr("id", value).attr("name", "dispatchResource[]")
				.attr("value", value);
			if ($.inArray(value, data['dispatchResource']) != -1)
				cb.attr("checked", true);
			lbl = $("<label>").text(value);
			holder.append(cb);
			holder.append(lbl);
			holder.append($("<br>"));
		});
	}
	function load_form(){
		$.ajax({
			url : "<?php echo site_url('')?>param_batchctl" ,
			type: "POST",
			data: {reqtype: "read"},
			dataType: "JSON",
			success: function(data)
			{
				update_view(data);
			}
		});
	}
	$(document).ready(function(){
		load_form();
	});
	
	function bc_submit(stpe){
		var fdata = $("#frm_sysparam").serialize();
		$.ajax({
			url : "<?php echo site_url('')?>param_batchctl",
			type: "POST",
			data: fdata,
			dataType: "JSON",
			success: function(data)
			{
				update_view(data);
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Submit Fail');
			}
		});
	};
	
	function refresh_config(){
		var fdata = {"reqtype" : "reloadParam"};
		var sdate = new Date();
		$.ajax({
			url : "<?php echo site_url('')?>sysrequest",
			type: "POST",
			data: fdata,
			dataType: "JSON",
			success: function(data)
			{
				console.log("ok");
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Submit Fail');
			}
		});
	};
</script>
<form id="frm_sysparam" action="#" method="POST">
	<div class="form-group row">
		<label class="col-xs-1" style="height: 27px; font-size: 90%">BatchMode</label>
		<br>
		<div class="col-xs-3" id="div_batchMode">
			
		</div>
	</div>
	<div class="form-group row">
		<label class="col-xs-1" style="height: 27px; font-size: 90%">Rsc Generate</label>
		<br>
		<div class="col-xs-3" id="div_rsc_generate">
			
		</div>
	</div>
	<div class="form-group row">
		<br>
		<label class="col-xs-1" style="height: 27px; font-size: 90%">Rsc Dispatch</label>
		<br>
		<div class="col-xs-3" id="div_rsc_dispatch">
			
		</div>
	</div>
	<input name="reqtype" id="reqtype" type="hidden" value="save"/>	
	<div class="col-xs-9">
	<button type="button" id="_btn_submit" onclick="bc_submit('submit');" class="btn btn-primary">Submit</button>
	<button type="button" id="_btn_submit" onclick="refresh_config();" class="btn btn-primary">Reload</button>
	</div>
</form>