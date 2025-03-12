<script type="text/javascript">
	
	$(document).ready(function() {
		
	});
	
	
	
	function  <?php echo $modal_id;?>_trigger(fdata){
		//alert(new Date());
		$('#sdate').datetimepicker({
                  ignoreReadonly: true,
				  //defaultDate: new Date(),
				  //minDate: today,
				  widgetPositioning: { vertical: 'bottom' },
				   format: 'YYYY-MM-DD'
            });
		$("#npp").click(function() {
				$("#vote_buttonsaa option").remove();
				$("#npp").val('');
		});
			var d = new Date();
		$('#sdate').on('dp.change', function(e){ 
			if ($('#npp').val() != ''){
				query_id();
			}
		})
var month = d.getMonth()+1;
var day = d.getDate();

var output = d.getFullYear() + '-' +
(month<10 ? '0' : '') + month + '-' +
(day<10 ? '0' : '') + day;

$("#sdate").val(output );

	};
		function query_id()
		{		
			var url = "<?php echo site_url('stomp/xids/querykill2')?>" ;
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
						var text = 'Silahkan sesuaikan ip yang tertera pada tampilan error';
						var type = 'info';
					}else{
						$("#vote_buttonsaa option").remove();
						if (data.error >= 0){
							if(data.error == 0){
								var text = 'User '+$('#npp').val()+' tidak login SSO pada tanggal '+$('#sdate').val();
								var type = 'error';
							}else{
								var text = 'User '+$('#npp').val()+' Sudah di <b>kill</b> sebelumnya';
								var type = 'error';
							}
						}else{
							var text = 'User not Found';
							var type = 'error';
						}
						
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
		function proses(){
			//alert($('#vote_buttonsaa :selected').text());
			//alert($('#sdate').val());
			var a = $('#sdate').val();
			//alert(a);
			var url = "<?php echo site_url('stomp/xids/proseskill')?>" ;
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
					$("#vote_buttonsaa option").remove();
					$('#npp').val('');
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					alert('User not found');
					$('#btnSave').attr('disabled',false); 
				}
			});
		}
	
</script>
<div class="container">
  <!-- Modal -->
  <div class="modal fade"  id="<?php echo $modal_id;?>_content" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-body">
			 <div id="wrap">
		<form action="#"  id="<?php echo $modal_id;?>_form"  role="form">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Kill User SSO</p>
			<p class="judul" align= "center" style="margin-left:28%; width:70%;color: red;" id="lockinfo" ></p>
			<div class="form-group row" style="width:90%;margin-left:6%;">		
				<p>
					<label class="judul">Tanggal</label> 
					<input name="sdate" id="sdate" placeholder="Tanggal Efektif" class="form-control" readonly>
				</p>
				<p>
				<label class="judul">NPP</label> 
				<input id="npp" name="npp" list="tpos" placeholder="-- NPP--" class="autocomplete form-control" type="text" onchange="query_id()">
				</p>
				<p>
					<label class="judul">IP Address</label> 
					<select id = "vote_buttonsaa" class="form-control">
					</select>
				</p>
										
				<p  class="signin button" id="div_btn_<?php echo $modal_id;?>" style="margin-left: -10%">
						<button type="button" id="btn_save" onclick="proses()" class="btn btn-primary">Proses</button>
				</p>
			</div>							
		</form>
	</div>
        </div>
    </div>
  </div>
  
</div>