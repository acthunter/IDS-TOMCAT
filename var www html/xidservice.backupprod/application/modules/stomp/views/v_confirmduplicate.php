<style>
#form{
	width: 100%;
}
p{
	line-height: normal;
}
</style>
<div class="container">
  <!-- Modal -->
    
  <div class="modal fade"  id="modal_target_content2" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-body">
			 <div id="wrap">
		<form action="#"  id="form"  class="form-horizontal" role="form">
		  
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Request Duplicate</p>
			<div id="isi">
			<div class="form-group row" style="width:90%;margin-left:6%;">
				<p>Permintaan reset password aplikasi sebelumnya sudah diterima dan dalam antrian system, mohon cek statusnya pada menu Tracking Pengiriman Password  </p>
				<p>		
					<table id="ok_tabel" class="table table-bordered">
						<thead >
						  <tr style="background: #F6F6F6;">
							<th>Nama Aplikasi</th>
							<th>Waktu Reset</th>
						  </tr>
						</thead>
							<tbody id="list_apps3">
							</tbody>
					</table>
				</p>
				<p>		
					Klik lanjut jika ingin mereset aplikasi selain list aplikasi diatas
				</p>
				<div class="col-md-12">
					<div class="col-md-6 portfolio-image">
						<button type="button" id="btn_prosesdup2" data-dismiss="modal" class="btn btn-primary">Lanjut</button>
						<button type="button" id="btn_cancelmodal2" data-dismiss="modal" class="btn btn-default">Cancel</button> 
					</div>
				</div>
				</div>
	
			</div>							
		</form>
	</div>
        </div>
    </div>
  </div>

</div>