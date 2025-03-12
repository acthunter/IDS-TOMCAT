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
    
  <div class="modal fade"  id="modal_target_content" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-body">
			 <div id="wrap">
		<form action="#"  id="form"  class="form-horizontal" role="form">
		  
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Request Duplicate</p>
			<div id="isi">
			<div class="form-group row" style="width:90%;margin-left:6%;">
				<p> Aplikasi telah direset sebelumnya oleh user ybs(Self Service)  </p>
				<p>		
					<table id="ok_tabel" class="table table-bordered">
						<thead >
						  <tr style="background: #F6F6F6;">
							<th>Nama Aplikasi</th>
							<th>Waktu Reset</th>
						  </tr>
						</thead>
							<tbody id="list_apps2">
							</tbody>
					</table>
				</p>
				<p>		
					Jika ingin meresetnya kembali tekan tombol proses
				</p>
				<div class="col-md-12"  style="margin-left: -30px;padding-top: 23px;">
					<div class="col-md-6 portfolio-image"> 
						<button type="button" id="btn_process" data-dismiss="modal" class="btn btn-primary">Proses</button>
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