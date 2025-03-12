<script type="text/javascript">
	
	$(document).ready(function() {
		$("input[name$='same']").click(function() {
			var test = $(this).val();

			$("div.desc").hide();
			$("#same" + test).show();
			});
		
		$("#tposid").change(function(){
			alert("test");
		});
/* 		$('#sdate').attr("style", "display: none;width:28%; float: left");
		$('#edate').attr("style", "display: none; width:29%;float:left "); */
/* 		$('#sdate').attr("style", "display: block;width:43%; float: left");
		$('#edate').attr("style", "display: block; width:42.8%; ");
		$('[name="hour_st"]').attr("style", "display: none; width: 55%; float:left; ");
		$('[name="hour_end"]').attr("style", "display: none;width: 35%; float:left; "); */
/* 		$('[name="jam"]').attr("style", "display: none; width: 15%; float:left; ");
		$('[name="jam2"]').attr("style", "display: none; width: 15%; float:left; "); */
		
	});
	
	
	
	function  <?php echo $modal_id;?>_trigger(fdata){
		console.log(fdata);
		$('#div_btn_<?php echo $modal_id;?> button').hide();	
		
		if (fdata['reqtype'] != "new"){
			$.ajax({
					url : "<?php echo site_url('')?>" + fdata['url'],
					type: "POST",
					data: fdata,
					dataType: "JSON",
					success: function(wdata){
						var data = wdata['detail'];
						var rdata = data['data'];
						console.log(wdata);
						
						
						var lockInfo = "";
						if (wdata['locked'])
							lockInfo = " locked by " + wdata['lockActor'] + " -- " + wdata['lockDate'];
							
						$('#progressbar').progressbar({value: wdata['currScore']/wdata['targetScore'], max: 1});
						$('#stagename').html(wdata['pname'] + " (" + wdata['currScore'] + "/" + wdata['targetScore'] + ")");
						$('#lockinfo').html(lockInfo);
						
						$('#currActor').html(jsonFlat(wdata['currActor']));
						
						$('#doneActor').html(arrFlat(wdata['doneActor']));
						
						$('#wfid').val(wdata['id']);
						$('#loginid').val(rdata['loginid']);
						$('#scoid').val(rdata['sco']);
						//$('#ms').val(wdata['mode']);
						$('[name="nama"]').text(rdata.nama);
						$('[name="nama"]').val(rdata.nama);
						$('[name="cposname"]').text(rdata.cposname);
						$('[name="cposname"]').val(rdata.cposname);
						$('#cposid').val(rdata['cposid']);			
						
						
						if (wdata['stage'] != '1'){
							$('input[type=radio]').attr('disabled', true);
							var arr_ro = "scoid,sdate,edate,loginid".split(",");
							console.log(arr_ro);
							for(cid of arr_ro){
								$('#' + cid).attr('disabled', true);
							}
							
						}else{
							var arr_ro = "loginid".split(",");
							for(cid of arr_ro){
								$('#' + cid).attr('readonly', true).css('pointer-events', 'none');
							}
							//datetimepicker();
						}

						$('#<?php echo $modal_id;?>_form #id').val(data['id']);
						$('#<?php echo $modal_id;?>_form #wfid').val(data['wfid']);
						
						for (val of wdata["eaction"]){
							$("#<?php echo $modal_id;?>_btn_" + val).show();
						}
							
					}
			});
			$('#pos_def').css("display", "block");
		}
		else {
					/* var check = $('input[value="0"]');
		var check2 = $('input[value="1"]');		
		check.attr("checked", true);
		check2.attr("checked", false);
		var interval= '0'; */
			$('#pos_def').css("display", "none");
			$('#<?php echo $modal_id;?>_form #btn_save').show();
			
		}
		
		$('#progressbar').click(function(){
			var ctarget = $('#wfinfo');
			if (ctarget.hasClass('infohide'))
				ctarget.removeClass('infohide');
			else
				ctarget.addClass('infohide');
		});	
		
	$.validator.addMethod('regex', function(value, element, param) {
        return this.optional(element) ||
            value.match(typeof param == 'string' ? new RegExp(param) : param);
    },
    'Please enter a value in the correct format.');
		$(function() {
		 $("#<?php echo $modal_id;?>_form").validate({
				rules: {
                    loginid: {
                        required: true,
                        minlength: 5,
						digits: true
                    },
					scoid: {
						required: true,
						maxlength: 5,
						//regex: /^[0-9]+$/
						digits: true
					},
					tposid: {
						required: true,
						minlength: 1,
						digits: true
					},
                },
                messages: {
					loginid: {
						required: "Please enter loginid",
						minlength: "Your loginid must be at least 5 number long"
					},
					scoid: {
						required: "Please enter sco number",
						maxlength: "position must be at most 5 number long",
					},
					tposid: {
						required: "Please enter position",
						minlength: "position must be at least 3 character long",
					},
                },
				highlight: function (element) {
					$(element).parent().addClass('error')
				},
				unhighlight: function (element) {
					$(element).parent().removeClass('error')
				},
                submitHandler: function(form) {
					console.log("about to submit");
                }
            });
		});
		
	};
	
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
		$('#scoid,#loginid,#jam,#jam2').removeAttr('disabled');
		$('input[type=radio]').removeAttr('disabled', true);
		var fdata = {'url': 'wf/wfaction', 'modal_id' : "<?php echo $modal_id;?>", 'btype': btype };
		
		var isValid = $("#<?php echo $modal_id;?>_form").valid();
		console.log(isValid);
		
		var cpos = $('#scoid').val();
			if (cpos.length < 1){
				alert("please input sco number");
				$('#scoid').val('');
				return ;
			}

		if (isValid)
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

#<?php echo $modal_id;?>_form1 label.error {
    color: red;
	font-size: 11px;
	width: 100%;
}

.ui-autocomplete {
    max-height:400px;
    overflow-y: auto;
	overflow-x: hidden;
}
* html .ui-autocomplete {
    height: 50px;
}
#<?php echo $modal_id;?>_form label.error {
    color: red;
	font-size: 11px;
	width: 100%;
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
			<p class="formHeader" style="font-size: 30px;">Ubah Kewenangan Sementara</p>
			<p class="judul" align= "center" style="margin-left:28%; width:70%;color: red;" id="lockinfo" ></p>
			<div id="wfinfo" class="infohide"style="margin-right: 8%;margin-left: 9%">
				<label for="doneActor">Done</label> <ul id="doneActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
				<label for="currActor">Curr</label> <ul id="currActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
			</div>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row" style="width:90%;margin-left:6%;">				
					<label style="color: rgb(64, 92, 96);font-family: Big Caslon, Book Antiqua, Palatino Linotype, Georgia, serif;" >LoginID</label>
					<label  style="float: right;margin-right: 60px;color: rgb(64, 92, 96);font-family: Big Caslon, Book Antiqua, Palatino Linotype, Georgia, serif;" id="pos_def" >Posisi Definitif</label>
				<p id="l-login">					
					<input style="width: 20%" name="loginid" id="loginid" placeholder="Login ID" class="column-full form-control" type="text" onchange="query_id()" onclick="$('#loginid, #nama,#cposname,#tposname, #tposid').val('').text('');$('#pos_def').css('display', 'none');">
					<label name="nama" class="labelisi" id="nama" ></label>
					<input name="nama" id="nama" readonly type="hidden">
					<label for="nama"  class="labelisi" name="cposname" id="cposname" ></label>
					<input name="cposname" id="cposname" readonly type="hidden">
				</p>
				<p>
				<label class="judul">SCO</label> 
				<input id="scoid" name="scoid" list="scoid" placeholder="-- Input SCO Number --" class="autocomplete form-control" type="text" onclick="$(this).val(''); $('#tposid').val('');">
				</p>
					<input name="status" id="status" class="form-control" type="hidden" >
					<input name="id" id="id" class="form-control" type="hidden" >
					<input name="mode" id="mode" class="form-control" type="hidden" value="SC" >
					<input name="wfid" id="wfid" class="form-control" type="hidden" >	
					<input name="reqtype" id="reqtype" class="form-control" type="hidden" >						
					<input name="notes" id="notes" class="form-control" type="hidden" >					
				<p  class="signin button" id="div_btn_<?php echo $modal_id;?>" style="margin-left: -10%">
						<button type="button" id="btn_save" onclick="<?php echo $modal_id;?>_submit('save')" class="btn btn-primary">Save</button>
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