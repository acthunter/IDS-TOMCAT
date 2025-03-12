<script type="text/javascript">

	var tabel;
	$(document).ready(function(){
			
		$("#npp").click(function() {
				$("#vote_buttonsaa option").remove();
				$("#npp").val('');
		});
		var d = new Date();

		var month = d.getMonth()+1;
		var day = d.getDate();

		var output = d.getFullYear() + '-' +
		(month<10 ? '0' : '') + month + '-' +
		(day<10 ? '0' : '') + day;
		$('#sdate').datetimepicker({
                  ignoreReadonly: true,
				  //defaultDate: new Date(),
				  //minDate: today,
				  widgetPositioning: { vertical: 'bottom' },
				   format: 'YYYY-MM-DD'
            });
		$("#sdate").val(output );

	 });
	 
	 function query_id()
		{		
			var url = "<?php echo site_url('endsession/xmain/querykill2')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: {"npp": $('#npp').val(), "date": $('#sdate').val()},
				dataType: "JSON",
				success: function(data)
				{

					if (data.opts.length > 0){
					$.each(data.opts, function(index, value) {
						$("#vote_buttonsaa").append('<option value='+value['AUD_CLIENT_IP']+'>'+value['AUD_CLIENT_IP']+'</option>');
					})
					}else{
						$("#vote_buttonsaa option").remove();
						new PNotify({
							title: 'Notifikasi',
							text: 'User '+$('#npp').val()+' tidak login SSO pada tanggal '+$('#sdate').val(),
							type: 'error',
							styling: 'bootstrap3'
						});
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
		function proses(){
			//alert($('#vote_buttonsaa :selected').text());
			//alert($('#sdate').val());
			var a = $('#sdate').val();
			//alert(a);
			var url = "<?php echo site_url('endsession/xmain/proseskill')?>" ;
			$.ajax({
				url : url,
				type: "POST",
				data: {"npp": $('#npp').val(),"ipaddress":$('#vote_buttonsaa :selected').text(),"tanggal":a},
				dataType: "JSON",
				success: function(data)
				{
					if (data == null){
						var text = 'User Tidak ditemukan !';
						var type = 'info';
					}else{
						var text = 'Kill User berhasil !';
						var type = 'success';
					}
					new PNotify({
						title: 'Notifikasi',
						text: text,
						type: type,
						styling: 'bootstrap3'
					});
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
			}
</script>

<div id="wrapper">
		<div style="width: 50%;margin:0 auto; margin-top: 5%; ">
		<form action="#"  id="form"  role="form">
			<p class="formHeader" style="font-size: 30px;">Kill User SSO</p>
			<p class="judul" align= "center" style="margin-left:28%; width:70%;color: red;" id="lockinfo" ></p>
			<div class="form-group row" style="width:90%;margin-left:6%;">
				<p class='col-sm-12'>
					<label class="judul">Tanggal</label> 
					<input name="sdate" id="sdate" placeholder="Tanggal Efektif" class="form-control" readonly>
				</p>	
				<p class='col-sm-12'>
				<label class="judul">NPP</label> 
				<input id="npp" name="npp" list="tpos" placeholder="-- NPP--" class="autocomplete form-control" type="text" onchange="query_id()">
				</p>
				<p class='col-sm-12'>
					<label class="judul">IP Address</label> 
					<select id = "vote_buttonsaa" class="form-control">
					</select>
				</p>
									
				<p  class="signin button col-sm-12" id="div_btn_<?php echo $modal_id;?>">
						<button type="button" id="btn_save" onclick="proses()" class="btn btn-primary">Proses</button>
				</p>
			</div>							
		</form>
	</div>
	<!--<div class="modal-container" id="modal_target"></div>-->
</div>


