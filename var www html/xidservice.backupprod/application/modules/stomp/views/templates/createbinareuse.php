<script type="text/javascript">
	
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
						$('#npp').val(rdata['npp']);
						$('#mode').val(wdata['mode']);
						$('[name="nama"]').val(rdata.nama);
					
						$('#bloginid').val(rdata['nloginid']);
						$('#email').val(rdata['email']);
						$('#nohp').val(rdata['mobileNumber']);
						$('#unit_name').val(rdata['unit_name']);
						$('#unit').val(rdata['unit']);
						$('#pname').val(rdata['pname']);
						$('#positionid').val(rdata['positionid']);
						$('#surat').val(rdata['surat']);
												
						if (wdata['stage'] != '1'){
							if (wdata['stage'] >= '3'){
								$('#div_btn_<?php echo $modal_id;?> button').hide();
							}else{
								$('[name="npp"]').attr("style", "display: block;").attr('disabled', true);
								var arr_ro = "npp,bloginid,nama,email,nohp,unit_name,pname,surat".split(",");
								console.log(arr_ro);
								for(cid of arr_ro){
									$('#' + cid).attr('disabled', true);
								}
							}

							
						}else{
							var arr_ro = "loginid".split(",");
							for(cid of arr_ro){
								$('#' + cid).attr('readonly', true).css('pointer-events', 'none');
							}
							
						}
						
						$('#<?php echo $modal_id;?>_form #id').val(data['id']);
						
						for (val of wdata["eaction"]){
							$("#<?php echo $modal_id;?>_btn_" + val).show();
						}
					}
			});
		}
		else {
			var ss = new Date();
						var ddd = ss.getDate();
						var mmm = ss.getMonth()+1;
						var hhh = ss.getHours();
						var minuu = ss.getMinutes();
						if(ddd<10)  { ddd='0'+ddd } 
						if(mmm<10)  { mmm='0'+mmm } 
						if(hhh<10){ hh='0'+hhh } 
						if(minuu<10){ minuu='0'+minuu } 
						var yy = ss.getFullYear()+'-'+mmm+'-'+ddd;
			$('[name="sdate"]').val(yy);
			$('#<?php echo $modal_id;?>_form #btn_save').show();
		}
		
		$("#<?php echo $modal_id;?> #cposname").autocomplete({  
				minLength: "2",  
				source:   
				function(request, response){  
				console.log('test');
					$.ajax({  
						url: "<?php echo site_url('stomp/xids/pos_search2')?>",  
						dataType: 'json',  
						type: 'POST',  
						data: {
							pattern: request.term
						}, 
						success:      
						function(data){  
							response($.map(data, function (item) {
								return {
									value: item.pname,
									rvalue: item
								}
							}))
						},  
					});  
				},

				select: function( event, ui ) {
					if(ui.item.rvalue.role == 1){
						$('#cposid').val(ui.item.rvalue.positionid);
					}else{
						$('#cposid').val("");
						$('#cposname').val("");
						alert("Posisi tersebut tidak memiliki kewenangan icons");
					}
				}	
			});
			
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
				ignore: [],
                rules: {
                    loginid: {
                        required: true,
                        minlength: 5,
						maxlength: 5,
						digits: true
                    },
					nama: {
						required: true,
						minlength: 3
					},
					cposname: {
						required: true,
						minlength: 3
					},
					dob: {
						required: true
					}
                },
                messages: {
					loginid: {
						required: "Please enter loginid",
						minlength: "Your loginid must be at least 5 number long",
						maxlength: "Users cannot be created"
					},
					nama: {
						required: "Please re-enter loginid"
					}, 
					cposname: {
						required: "Please enter position",
						minlength: "Position must be at least 3 character long",
					},
					dob: {
						required: "Please enter date of birth"
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
	
	function <?php echo $modal_id;?>_submit(btype){
		$('#npp,#bloginid,#nama,#email,#nohp,#unit_name,#pname,#surat').removeAttr('disabled');
		var fdata = {'url': 'wf/wfaction', 'modal_id' : "<?php echo $modal_id;?>", 'btype': btype };
		//;
		var isValid = $("#<?php echo $modal_id;?>_form").valid();
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

#<?php echo $modal_id;?>_form label.error {
    color: red;
	font-size: 11px;
	width: 90%;
}
.ui-autocomplete {
    max-height:400px;
    overflow-y: auto;
	overflow-x: hidden;
}
* html .ui-autocomplete {
    height: 50px;
}

</style>
<div class="container">
  <!-- Modal -->
  <div class="modal fade"  id="<?php echo $modal_id;?>_content" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
		<div id="wrap">
		<form action="#"  id="<?php echo $modal_id;?>_form"  role="form">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">User SSO Bina Reuse</p>
			<p class="judul" align= "center" style="margin-left:25%; width:70%;color: red;" id="lockinfo" ></p>			
			<div id="wfinfo" class="infohide"style="margin-right: 8%;margin-left: 9%">
				<label for="doneActor">Done</label> <ul id="doneActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
				<label for="currActor">Curr</label> <ul id="currActor" style="padding: 0px; list-style-type: none; margin: 0px; width: 600px; overflow: hidden;"></ul>
			</div>
			<input type="hidden" value="" name="reqtype" id="reqtype"/>
			<input type="hidden" value="" name="identity" id="userclass"/>
			<div class="form-group row"style="width:90%;margin-left:6%; ">
				<div class='col-sm-12'>
					<p class='col-sm-6'>
					<label class="judul">NPP (B81XXXX)</label> 
					<input id="npp" name="npp" placeholder="-- NPP--" class="form-control" type="text" onchange="npp_search()">
					</p>
					<p class='col-sm-6'>
					<label class="judul">User Icons (Reuse)</label> 
					<input id="bloginid" name="bloginid" placeholder="-- User Icons Bina--" class="form-control" type="text">
					</p>
				</div>
				
				<div class='col-sm-12'>
					<p class='col-sm-12'>
					<label class="judul">Nama</label> 
					<input id="nama" name="nama" placeholder="-- Nama--" class="form-control" type="text">
					</p>
				</div>
				
				<div class='col-sm-12'>
					<p class='col-sm-6'>
					<label class="judul">Email</label> 
					<input id="email" name="email" placeholder="-- Email--" class="form-control" type="text">
					</p>
					<p class='col-sm-6'>
					<label class="judul">No HP</label> 
					<input id="nohp" name="nohp" placeholder="-- No HP--" class="form-control" type="text">
					</p>
				</div>
				
				<div class='col-sm-12'>
					<p class='col-sm-12'>
						<label class="judul">Unit</label> 
						<input id="unit_name" name="unit_name"  class="autocomplete form-control" type="text" placeholder="-- Unit --">
						<input name="unit" id="unit" readonly type="hidden">
					</p>
				</div>
				<div class='col-sm-12'>
					<p class='col-sm-12'>
						<label class="judul">Posisi</label> 
						<input id="pname" name="pname"  class="form-control" type="text" placeholder="-- Posisi --" readonly>
						<input name="positionid" id="positionid" type="hidden">
					</p>
				</div>
				<div class='col-sm-12'>
					<p class='col-sm-12'>
						<label class="judul">Surat / Remedy</label> 
						<input id="surat" name="surat" placeholder="-- Surat / Remedy--" class="form-control" type="text">
					</p>
				</div>
					<!--<input name="cposid" id="cposid" readonly type="block">-->
					<input name="status" id="status" class="form-control" type="hidden" >
					<input name="id" id="id" class="form-control" type="hidden" >
					<input name="mode" id="mode" class="form-control" type="hidden" value="BN" >
					<input name="wfid" id="wfid" class="form-control" type="hidden" >	
					<input name="reqtype" id="reqtype" class="form-control" type="hidden" >						
					<input name="notes" id="notes" class="form-control" type="hidden" >								
				<p  class="signin button" id="div_btn_<?php echo $modal_id;?>">
						<br>
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