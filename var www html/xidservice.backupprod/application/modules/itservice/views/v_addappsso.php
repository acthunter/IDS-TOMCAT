<script type="text/javascript">
		$(document).ready(function() {
			$('input').val('');  
			$("#app").autocomplete({  
				minLength: "2", 
				source:   
				function(request, response){  
				console.log('test');
					$.ajax({  
						url: "<?php echo site_url('search_app')?>",  
						dataType: 'json',  
						type: 'POST',  
						data: {
							pattern: request.term
						}, 
						success:      
						function(data){  
							response($.map(data, function (item) {
								return {
									value: item.appname,
									rvalue: item
								}
							}))
							
						},  
					});  
				},
				change: function (event, ui) {
					if (ui.item === null) {
						$(this).val('');
						alert("Silahkan pilih Aplikasi yang akan didaftarkan");
						$('#app').val('');
					}
				},
				select: function( event, ui ) {					
					$('#appid').val(ui.item.rvalue.id_app);
				}	
			});
			
			$('#btn_clear, #npp').on('click', function() {
			  $('input').val('');  
			});
			$('#app').on('click', function() {
			  $('#appid').val('');  
			});
			/* $('#npp').on('click', function() {
			  $('#npp, #nama, #unit_name').val('');  
			}); */ 
			$('#btn_save').on('click', function() {
			 proses();
			});
			$('#btn_proses').on('click', function() {
				$('#cnpp').text($('#npp').val());
				$('#cnama').text($('#nama').val());
				$('#cunit').text($('#unit_name').val());
				
				$('#capp').text($('#app').val());
				$('#cuser_app').text($('#user_app').val());
			});   
			
				$.validator.addMethod('regex', function(value, element, param) {
        return this.optional(element) ||
            value.match(typeof param == 'string' ? new RegExp(param) : param);
    },
    'Please enter a value in the correct format.');
		$(function() {
			 $("#form").validate({
					rules: {
						npp: {
							required: true,
							minlength: 5,
							digits: true
						},
						user_app: {
							required: true
						},
						app: {
							required: true
						}
						
					},
					messages: {
						npp: {
							required: "Please enter NPP",
							minlength: "Your NPP must be at least 5 number long"
						},
						user_app: {
							required: "Please enter User ID Aplikasi"
						},
						app: {
							required: "Please select Application"
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
		function npp_search()
		{		
			var url = "<?php echo site_url('npp_search')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: {"npp": $('#npp').val()},
				dataType: "JSON",
				success: function(data)
				{
					if(data != null){
						alert('User found');
						$('[name="nama"]').val(data.name);
						$('[name="unit"]').val(data.accOffice);
						$('[name="unit_name"]').val(data.unit);
						$('[name="user_app"]').val($('#npp').val());
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
	function proses() {
		var isValid = $("#form").valid();
		//$('#email_,#unit_,#posisi_').removeAttr('disabled');
		if (isValid && $('#appid').val()!=""){
			var url = "<?php echo site_url('proses_add')?>" ;
			//$('#nama').removeAttr('disabled');
			$.ajax({
				url : url,
				type: "POST",
				data: $("form").serialize(),
				dataType: "JSON",
				success: function(data)
				{
					//alert(data.status);
					if (data.status == 'duplicate'){
						var text = 'User telah terdaftar sebelumnya, Silahkan dicek kembali aplikasi user di menu informasi user';
						var type = 'error';
						new PNotify({
							title: 'Gagal Menambahkan User Aplikasi ',
							text: text,
							type: type,
							styling: 'bootstrap3'
						});							
					}else{
						var text = 'User Aplikasi berhasil didaftarkan';
						var type = 'success';
						new PNotify({
							title: 'Berhasil Menambahkan User Aplikasi',
							text: text,
							type: type,
							styling: 'bootstrap3'
						});
						$('input').val('');  
					}
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					//alert('Fail');
					var text = 'Silahkan dicek kembali data yang diinputkan di form';
						var type = 'error';
						new PNotify({
							title: 'Gagal Menambahkan Data User',
							text: text,
							type: type,
							styling: 'bootstrap3'
					});	
					//$('#btnSave').attr('disabled',false); 
				}
			});
		}else if($('#appid').val()==""){
			//alert("Aplikasi yang dipilih tidak tersedia");
		};
	}

</script>
<style>
#form{
	width: 100%;
}
.new{
	margin-top: 24px;
}
.wdth{
	width: 56%;
}
#form label.error {
    color: red;
	font-size: 11px;
	width: 100%;
}
</style>
<div id="wrap" style="width: 70%;">
	<div  id="cekuser"style="margin:0 auto; margin-top: 5%; ">
		<form action="#"  id="form"  class="form-horizontal" role="form">
		  
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Detail Penambahan User Aplikasi</p>
			<div id="isi">
			<div class="form-group row" style="width:90%;margin-left:6%;">
				<p class='col-sm-3'>
				<label class="judul">NPP</label> 
				<input id="npp" name="npp" placeholder="-- NPP--" class="form-control" type="text" onchange="npp_search()">
				</p>
				<p class='col-sm-9'>
				<label class="judul">Nama</label> 
				<input id="nama" name="nama"  class="form-control" type="text" placeholder="-- Nama --"disabled>
				</p>
				<p class='col-sm-12'>
					<label class="judul">Unit</label> 
					<input id="unit_name" name="unit_name"  class="form-control" type="text" placeholder="-- Unit --"disabled>
					<input name="unit" id="unit" readonly type="hidden">
				</p>
				<p class='col-sm-12'>
					<label class="judul">Aplikasi</label> 
					<input id="app" name="app"  class="autocomplete form-control" type="text" placeholder="-- Aplikasi --">
					<input name="appid" id="appid" readonly type="hidden">
				</p>
				<p class='col-sm-12'>
					<label class="judul">User ID Aplikasi</label> 
					<input id="user_app" name="user_app"  class="form-control" type="text" placeholder="-- User Aplikasi --">
				</p>
				<p  class="signin button col-sm-12" style ="padding-top:3px;"id="div_btn_<?php echo $modal_id;?>">
						<button type="button" id="btn_proses" data-toggle="modal"  data-target="#confirm-submit" class="btn btn-success">Proses</button>
						<button type="button" id="btn_clear" class="btn btn-primary">Clear</button>
				</p>
				</div>
	
			</div>							
		</form>
	</div>
        </div>
    </div>
  </div>

</div>

<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Confirm Submit
            </div>
            <div class="modal-body">
                Are you sure you want to submit the following details?
                <table class="table">
                    <tr>
                        <th>NPP</th>
                        <td id="cnpp"></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td id="cnama"></td>
                    </tr>
					<tr>
                        <th>Unit</th>
                        <td id="cunit"></td>
                    </tr>
					<tr>
                        <th>Aplikasi</th>
                        <td id="capp"></td>
                    </tr>
					<tr>
                        <th>User ID Aplikasi</th>
                        <td id="cuser_app"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				 <button type="button" class="btn btn-success" data-dismiss="modal" id="btn_save">Submit</button>
                <!--<a href="#" id="btn_save" class="btn btn-success success">Submit</a>-->
            </div>
        </div>
    </div>
</div>