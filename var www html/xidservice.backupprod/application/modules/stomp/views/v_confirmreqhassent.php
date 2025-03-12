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
    
  <div class="modal fade"  id="modal_target_content3" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-body">
			 <div id="wrap">
		<form action="#"  id="form"  class="form-horizontal" role="form">
		  
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Request Password Aplikasi</p>
			<div id="isi">
			<div class="form-group row" style="width:90%;margin-left:6%;">
				<p> Aplikasi telah direset sebelumnya dan saat ini belum dibuka oleh ybs  </p>
				<p>		
					<table id="ok_tabel" class="table table-bordered">
						<thead >
						  <tr style="background: #F6F6F6;">
							<th>Nama Aplikasi</th>
							<th>Waktu Reset</th>
						  </tr>
						</thead>
							<tbody id="list_apps4">
							</tbody>
					</table>
				</p>
				<p>		
					Klik lanjut jika ingin mereset aplikasi selain list aplikasi diatas
					Jika ybs tidak menerima link email password silahkan menghubungi admin untuk mengirimkan email kembali
				</p>
				<div class="col-md-12">
					<div class="col-md-6 portfolio-image">
						<button type="button" id="btn_prosesdup" data-dismiss="modal" class="btn btn-primary">Lanjut</button>
						<button type="button" id="btn_cancelmodal" data-dismiss="modal" class="btn btn-default">Cancel</button> 
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