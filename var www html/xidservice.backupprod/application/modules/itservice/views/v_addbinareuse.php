<script type="text/javascript">
	$(document).ready(function() {	
	
		$.validator.addMethod('regex', function(value, element, param) {
        return this.optional(element) ||
        value.match(typeof param == 'string' ? new RegExp(param) : param);
		},
		);
		
		$("#form").validate({
		rules:{
			npp: {
					required: true,
					minlength: 7,
					maxlength: 7
				},
			bloginid: {
					required: true,
					minlength: 5,
					maxlength: 5,
					digits: true
				},
			email: {
					required: true,
					email: true,
					regex: /([a-zA-Z0-9]+)([\.{1}])?([a-zA-Z0-9]+)\@(bni)([\.])co([\.])id/g 
				}, 
			nama: {
					required: true,		
				},		
			nohp: {
					required: true,
					digits: true
				},
			unit_name: {
					required: true
				},
			surat: {
					required: true
				},
			app: {
					required: true			
				}		
		},
		messages: {
			npp: {
					required: "Mohon masukan NPP.",
					minlength: "Harap masukan min 7 karakter.",
					maxlength: "Harap masukkan tidak lebih dari 7 karakter."
				},
			bloginid: {
					required: "Mohon masukan USER ICONS.",
					minlength: "Harap masukan min 5 karakter.",
					maxlength: "Harap masukkan tidak lebih dari 5 karakter."
				},
			email: {
					required: "Mohon masukan email format bni",
					regex: 'Silahkan menggunakan email BNI' 
				}, 
			unit_name: {
					required: "Mohon masukkan Unit."
				},
			surat: {
					required: "Mohon masukkan surat."
				},
			nohp: {
					required: "Mohon masukkan nomor handphone."
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
		
	
        $("#btn_proses").click (function () { // The button type should be "button" and not submit
            if ($('#form').valid()) {
                $('#cnpp').text($('#npp').val());
				$('#cbloginid').text($('#bloginid').val());
				$('#cnama').text($('#nama').val());
				$('#cemail').text($('#email').val());
				$('#cnohp').text($('#nohp').val());
				$('#cunit').text($('#unit_name').val());
				$('#cposisi').text($('#pname').val());
				$('#csurat').text($('#surat').val());
				$('#notes').text($('#surat').val());
            }else{
                alert("Mohon lengkapi terlebih dahulu");
                return false;
            }	
        }); 

	  $("#unit_name").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo site_url('search_unitbina')?>",
					type: "POST",
                    dataType: "json",
                    data: { pattern: request.term },
                    success: function (data) {
                    response($.map(data, function (item) {
						return {
							value: item.unitname,
							svalue: item	
                        }
                    }))
                    //debugger;
					},
				});
					},
					/* error: function (result) {
                    alert("Error");
                    }
                    });
                    },*/
					minLength: "2",
					change: function (event, ui) {
					if (!ui.item ) {
						$('#app').val('');
					}
					}, select: function (event,ui) {
					$('#unit').val(ui.item.svalue.unit);
					$('#pname').val(ui.item.svalue.posisi);
					$('#positionid').val(ui.item.svalue.posid);
				}
         });
		 
	function proses() {
		var isValid = $("#form").valid();
		//$('#email_,#unit_,#posisi_').removeAttr('disabled');
		if (isValid && $('#appid').val()!=""){
			//var url = "<?php echo site_url('proses_add')?>" ;
			var url = "<?php echo site_url('itservice/xmain/wfaction')?>";
			//$('#nama').removeAttr('disabled');
			$.ajax({
				url : url,
				type: "POST",
				data: $("form").serialize()+ "&tipe_btn=" + 'submit' + "&mode=" + 'BN',
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
						f_userid();
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
				/* var arr_ro2 = "npp,bloginid,nama,unit_name,pname,positionid,email,nohp,unit,surat".split(",");
					for(cid of arr_ro2){
						$('#' + cid).val('').text('');
					} */
				
			});
		}else if($('#appid').val()==""){
			//alert("Aplikasi yang dipilih tidak tersedia");
		};
	}
	 
		$('#btn_save').on('click', function() {
			 proses();
		});	

	});	
	
	function query_id()
		{	
			$('#loginid').removeAttr('readonly').removeAttr('style');
			var val_npp = $('#npp').val();
				if((val_npp.indexOf('8') >= 0)||(val_npp.indexOf('8') >= 0)){
					var url = "<?php echo site_url('itservice/xmain/query_bina')?>";
					load_query(url);
				}else{
					//$('#npp').val("");
					var arr_ro = "npp,bloginid,nama,unit_name,email,nohp,unit,surat".split(",");
					for(cid of arr_ro){
						$('#' + cid).val('').text('');
					}
						
					new PNotify({
						title: 'Notifikasi',
						text: 'User tidak tersedia',
						type: 'error',
						styling: 'bootstrap3'
					});
				}
			
			
		}
	function load_query(url){
			var datauser = {"npp": $('#npp').val(), "bnpp": $('#bloginid').val() };
			$.ajax({
				url : url,
				type: "POST",
				data: datauser,
				dataType: "JSON",
				success: function(data)
				{
					if (data != null){
						alert("User Telah terdaftar . Silahkan cek user tersebut di menu Informasi User");

					$('[name="bloginid"]').val(data.bloginid);
					$('[name="mobileNumber"]').val(data.mobileNumber);

					
					$('input[type=text]').each(function(){
					   if($(this).val().length > 0){
						$(this).attr('readonly', true).attr("style", "pointer-events: none;");
					   }
					$('#<?php echo $modal_id;?>_form ').hide();
					})
					$('[name="npp"]').removeAttr('readonly').removeAttr('style');
					$('#div_btn button').hide();
					
					var arr_ro = "bloginid,nama,email,nohp,unit_name,unit,surat".split(",");
					for(cid of arr_ro){
						$('#' + cid).attr('readonly', true).attr("style", "pointer-events: none;");
					}
					}else {
						$('#<?php echo $modal_id;?>_form').show();
						$('#div_btn button').show();
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('Data yang anda input belum lengkap');
					var arr_ro = "npp,bloginid,nama,email,nohp,unit,surat".split(",");
					for(cid of arr_ro){
						$('#' + cid).removeAttr('readonly').removeAttr('style').val('').text('');
						}
				}
				
			});
		}
		
		function f_userid()
		{	
			var useridck = $('[name="npp"]').val();
			if (useridck != ''){
				var arr_ro = "npp,bloginid,nama,unit_name,email,nohp,unit,surat,pname".split(",");
			}else{
				var arr_ro = "bloginid,nama,unit_name,email,nohp,unit,surat,pname".split(",");
			}
			
			for(cid of arr_ro){
				$('#' + cid).removeAttr('readonly').removeAttr('style').val('').text('');
			}
			$('#pname').attr('readonly',true); 
			$('#div_btn button').show();
		}
		
	/* function npp_search()
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
	 */

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
.wid{
	width: 27%;
}
</style>
<div id="wrap" style="width: 70%;">
	<div  id="cekuser"style="margin:0 auto; margin-top: 5%; ">
		<form action="#"  id="form"  class="form-horizontal" role="form">
		  
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Penambahan User SSO Bina Reuse</p>
			<div id="isi">
			<div class="form-group row" style="width:90%;margin-left:6%;">
				<div class='col-sm-12'>
					<p class='col-sm-6'>
					<label class="judul">NPP (B81XXXX)</label> 
					<input id="npp" name="npp" placeholder="-- NPP--" class="form-control" onchange="query_id()" onclick="f_userid()" type="text" >
					</p>
					<p class='col-sm-6'>
					<label class="judul">User Icons (Reuse)</label> 
					<input id="bloginid" name="bloginid" placeholder="-- User Icons Bina--" class="form-control" onchange="query_id()" onclick="f_userid()" type="text">
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
				<!--<input name="mode" id="mode" class="form-control" value="UB" type="text" >-->
				<input name="notes" id="notes" class="form-control" type="hidden" >
				<div class='col-sm-12' id="div_btn">            
					<p  class="signin button col-sm-12" style ="padding-top:3px;margin-top:2%;"id="div_btn_<?php echo $modal_id;?>">
							<button type="button" id="btn_proses" data-toggle="modal"  data-target="#confirm-submit" class="btn btn-success"  >Proses</button>
							<button type="reset" id="btn_clear" onclick="f_userid()" class="btn btn-primary">Clear</button>
					</p>
				</div>
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
                        <th class='wid'>NPP (81XXXX)	</th>
						<td> : </td>
                        <td id="cnpp"></td>
                    </tr>
					<tr>
                        <th class='wid'>User Icons Bina </th>
						<td> : </td>
                        <td id="cbloginid"></td>
                    </tr>
                    <tr>
                        <th class='wid'>Nama		</th>
						<td> : </td>
                        <td id="cnama"></td>
                    </tr>
					<tr>
                        <th class='wid'>Email		</th>
						<td> : </td>
                        <td id="cemail"></td>
                    </tr>
					<tr>
                        <th class='wid'>No HP		</th>
						<td> : </td>
                        <td id="cnohp"></td>
                    </tr>
					<tr>
                        <th class='wid'>Unit		</th>
						<td> : </td>
                        <td id="cunit"></td>
                    </tr>
					<tr>
                        <th class='wid'>Posisi		</th>
						<td> : </td>
                        <td id="cposisi"></td>
                    </tr>
					<tr>
                        <th class='wid'>Surat / Remedy	</th>
						<td> : </td>
                        <td id="csurat"></td>
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