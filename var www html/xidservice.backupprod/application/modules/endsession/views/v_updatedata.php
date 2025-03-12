<script type="text/javascript">
	 $(document).ready(function(){
		 $("input.chk").attr("disabled", true);
        $('input[type="checkbox"]').click(function(){
			var name = "#"+$(this).attr('name');
            if($(this).prop("checked") == true){
				$(name).prop('disabled', false);

            }

            else if($(this).prop("checked") == false){
				if($(name).val()==""){
					$( '[name="'+$(this).attr('name')+'"]' ).prop( 'checked', true );
				}else{
					$(name).prop('disabled', true);
				}
            }

        });
		$('#email').click(function(){
			$('[id="email_new"]').val('');
			var arr_ro = "email,email_new".split(",");
			for(cid of arr_ro){
				$('#' + cid).attr('disabled', false);
				$('#' + cid).val('');
				
			}
        });
		$('#posisi').click(function(){
			$('[id="posisi_new"]').val('');
			var arr_ro = "posisi, posisi_new".split(",");
			for(cid of arr_ro){
				$('#' + cid).attr('disabled', false);
				$('#' + cid).val('');
				
			}
        });
		$('#unit').click(function(){
			$('[id="unit_new"]').val('');
			$('[id="posisi"]').val('');
			$( '[name="posisi"]' ).prop( 'checked', true );
			var arr_ro = "unit,posisi".split(",");
			for(cid of arr_ro){
				$('#' + cid).attr('disabled', false);
				$('#' + cid).val('');
				
			}
			var arr_ro2 = "unit_new,posisi_new".split(",");
			for(cid2 of arr_ro2){
				$('#' + cid2).val('');
				
			}
        });
		
		$(" #unit").autocomplete({  
				minLength: "2",  
				source:   
				function(request, response){  
				console.log('test');
					$.ajax({  
						url: "<?php echo site_url('endsession/xmain/pos_unit')?>",  
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
				change: function (event, ui) {
					if (ui.item === null) {
						$(this).val('');
						alert("Silahkan pilih unit baru");
						$('#unit').val('');
					}
				},
				select: function( event, ui ) {					
					$('#unit_new').val(ui.item.rvalue.accOffice);
				}	
			});
		$("#posisi").autocomplete({  
				minLength: "2",  
				source:   
				function(request, response){  
				console.log('test');
					$.ajax({  
						url: "<?php echo site_url('endsession/xmain/pos_search')?>",  
						dataType: 'json',  
						type: 'POST',  
						data: {
							pattern: request.term,
							"unit": ($('#unit_new').val() == "") ? $('#unit_old').val() : $('#unit_new').val() 
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
				change: function (event, ui) {
					if (ui.item === null) {
						$(this).val('');
						alert("Silahkan pilih posisi baru");
						$('#posisi').val('');
					}
				},
				select: function( event, ui ) {					
					$('#posisi_new').val(ui.item.rvalue.positionid);
				}	
			});
			
			$.validator.addMethod('regex', function(value, element, param) {
        return this.optional(element) ||
            value.match(typeof param == 'string' ? new RegExp(param) : param);
    },
    'Please enter a value in the correct format.');
		$(function() {
		 $("#form").validate({
				rules: {
                    email_: {
                        required: true,
						regex: /([a-zA-Z0-9]+)([\.{1}])?([a-zA-Z0-9]+)\@(bni|bnisyariah)([\.])co([\.])id/g

                    },
					unit_: {
						required: true
					},
					posisi_: {
						required: true
					},
					keterangan: {
						required: true
					}
					
                },
                messages: {
					email_: {
						required: "Silahkan isi kolom email",
						regex: 'Silahkan menggunakan email BNI'
					},
					unit_: {
						required: "Silahkan isi kolom unit"
					},
					posisi_: {
						required: "Silahkan isi kolom posisi"
					},
					keterangan: {
						required: "Silahkan isi kolom keterangan"
					}
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
	});
	function mail(val) {
		$('[id="email_new"]').val(val);
	}
	
	function proses() {
		var isValid = $("#form").valid();
		$('#email_,#unit_,#posisi_').removeAttr('disabled');
		if (isValid){
		var url = "<?php echo site_url('endsession/xmain/proses')?>" ;
		$('#nama').removeAttr('disabled');
		$.ajax({
			url : url,
			type: "POST",
			data: $("form").serialize(),
			dataType: "JSON",
			success: function(data)
			{
				if(data == "TRUE"){
					var text = 'Update Berhasil';
					var type = 'success';
					new PNotify({
						title: 'Notifikasi',
						text: text,
						type: type,
						styling: 'bootstrap3'
					});
					npp_clear();
				}else if (data == 0){
					var text = 'Tidak ada data yang terupdate';
					var type = 'error';
					new PNotify({
						title: 'Notifikasi',
						text: text,
						type: type,
						styling: 'bootstrap3'
					});
				}else{
					var text = 'Update data gagal';
					var type = 'error';
					new PNotify({
						title: 'Notifikasi',
						text: text,
						type: type,
						styling: 'bootstrap3'
					});
					npp_clear();
				}
				//npp_clear();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('User not found');
				$('#btnSave').attr('disabled',false); 
			}
		});
		$('#nama').attr('disabled', true);
		}
	}
	function npp_clear(){
			$("input.chk").attr("disabled", true);
			$(".chk").prop("checked", false);
			$('[id="nama"]').val('');
			$('[id="npp"]').val('');
			$('[id="keterangan"]').val('');
			var arr_ro = "unit,email,posisi,unit_new,email_new,posisi_new,unit_old,email_old,posisi_old".split(",");
			for(cid of arr_ro){
				$('#' + cid).attr('disabled', false);
				$('#' + cid).val('');
			}
	}
	function query_id()
	{		
		var url = "<?php echo site_url('endsession/xmain/inq_user')?>" ;
		$.ajax({
			url : url,
			type: "POST",
			data: {"npp": $('#npp').val()},
			dataType: "JSON",
			success: function(data)
			{
				if(data != null){
					if (data.stat_pos < 0){
						var text = 'Admin tidak dapat merubah user posisi Resign';
						var type = 'error';
						new PNotify({
							title: 'Notifikasi',
							text: text,
							type: type,
							styling: 'bootstrap3'
						});
						var arr_ro = "keterangan,tposname,sdate,edate,jam,jam2".split(",");
						for(cid of arr_ro){
							$('#' + cid).attr('disabled', true);
						}
						$('#div_btn_<?php echo $modal_id;?> button').hide();
						
					}
					$('[id="nama"]').val(data.name);
					$('[id="unit"]').val(data.nama_unit);
					$('[id="unit_old"]').val(data.unit);
					$('[id="email"]').val(data.email);
					$('[id="email_old"]').val(data.email);
					$('[id="posisi"]').val(data.nama);
					$('[id="posisi_old"]').val(data.positionid);
					var arr_ro = "unit,email,posisi".split(",");
						for(cid of arr_ro){
							$('#' + cid).attr('disabled', true);
						}
					$('#pos_def').css("display", "block");
					$("input.chk").attr("disabled", false);
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
</script>
<style>
#form label.error {
    color: red;
	font-size: 11px;
	width: 100%;
}
</style>
<div id="wrapper">
		<div style="width: 60%;margin:0 auto; margin-top: 5%; ">
		<form action="#"  id="form"  role="form">
			<p class="formHeader" style="font-size: 30px;">Update Data SSO</p>
			<p class="judul" align= "center" style="margin-left:28%; width:70%;color: red;" id="lockinfo" ></p>
			<div class="form-group row" style="width:90%;margin-left:6%;">
				<p class='col-sm-3'>
				<label class="judul">NPP</label> 
				<input id="npp" name="npp" placeholder="-- NPP--" class="form-control" type="text" onclick="npp_clear()" onchange="query_id()">
				</p>
				<p class='col-sm-9'>
				<label class="judul">Nama</label> 
				<input id="nama" name="nama"  class="form-control" type="text" placeholder="-- Nama --"disabled>
				</p>
				<p class='col-sm-1'>
					<label class="judul">Email</label>
					 
					<input style="vertical-align: middle;" type="checkbox" class="chk" name="email">
				</p>
				<p class='col-sm-11'>
					<label class="judul"> </label>
					<input type="text" class="form-control" id="email" name="email_" placeholder="-- Email --">
					<input type="hidden" class="form-control" id="email_old" name="email_old">
				</p>
				<p class='col-sm-1'>
					<label class="judul">Unit </label> 
					<input style="vertical-align: middle;" type="checkbox" class="chk" name="unit">
				</p>
				
				<p class='col-sm-11'>
					<label class="judul"> </label> 
					<input type="text" class="form-control" id="unit" name="unit_" placeholder="-- Unit --">
					<input type="hidden" class="form-control" id="unit_old" name="unit_old">
					<input type="hidden" class="form-control" id="unit_new" name="unit_new">
				</p>
				<p class='col-sm-1'>
					<label class="judul">Position</label> 
					<input style="vertical-align: middle;" type="checkbox" class="chk" name="posisi">
				</p>
				<p class='col-sm-11'>
					<label class="judul"> </label> 
					<input type="text" class="form-control" id="posisi" name="posisi_"placeholder="-- Posisi --">
					<input type="hidden" class="form-control" id="posisi_old" name="posisi_old">
					<input type="hidden" class="form-control" id="posisi_new" name="posisi_new">
				</p>
				
				<p class='col-sm-12'>
					<label class="judul">Keterangan</label> 
					<input id="keterangan" name="keterangan" list="tpos" class="form-control" placeholder="-- Keterangan --" type="text">
					<label id="ket" name="ket"></label>
				</p>
				
									
				<p  class="signin button col-sm-12" style ="padding-top:3px;"id="div_btn_<?php echo $modal_id;?>">
						<button type="button" id="btn_save" onclick="proses()" class="btn btn-primary">Proses</button>
				</p>
			</div>							
		</form>
	</div>
	<!--<div class="modal-container" id="modal_target"></div>-->
</div>


