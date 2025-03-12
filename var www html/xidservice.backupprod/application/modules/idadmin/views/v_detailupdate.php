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
</style>
<div class="container">
  <!-- Modal -->
    
  <div class="modal fade"  id="modal_target_content" role="dialog" data-backdrop="static">
    <div class="modal-dialog wdth">
        <div class="modal-body ">
			 <div id="wrap">
		<form action="#"  id="form"  class="form-horizontal" role="form">
		  
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Detail Update Data</p>
			<div id="isi">
			<div class="form-group row" style="width:90%;margin-left:6%;">
				<p class='col-sm-3'>
				<label class="judul">NPP</label> 
				<input id="npp" name="npp" placeholder="-- NPP--" class="form-control" type="text" onclick="npp_clear()" onchange="query_id()" disabled>
				</p>
				<p class='col-sm-9'>
				<label class="judul">Nama</label> 
				<input id="nama" name="nama"  class="form-control" type="text" placeholder="-- Nama --"disabled>
				</p>
				<p class='col-sm-12'>
					<div class='col-sm-6'>
					<label class="judul">Email</label> 
					<input id="email_old" name="email_old"  class="form-control" type="text" placeholder="-- Nama --"disabled>
					</div>
					<div class='col-sm-6'>
					<input id="email_new" name="email_new"  class="new form-control" type="text" placeholder="-- Nama --"disabled>
					</div>
				</p>
				<p class='col-sm-12'>
					<div class='col-sm-6'>
					<label class="judul">Unit</label> 
					<input id="unit_old" name="unit_old"  class="form-control" type="text" placeholder="-- Nama --"disabled>
					</div>
					<div class='col-sm-6'>
					<input id="unit_new" name="unit_new"  class="new form-control" type="text" placeholder="-- Nama --"disabled>
					</div>
				</p>
				<p class='col-sm-12'>
					<div class='col-sm-6'>
					<label class="judul">Posisi</label> 
					<input id="posisi_old" name="posisi_old"  class="form-control" type="text" placeholder="-- Nama --"disabled>
					</div>
					<div class='col-sm-6'>
					<input id="posisi_new" name="posisi_new"  class="new form-control" type="text" placeholder="-- Nama --"disabled>
					</div>
				</p>
				<p class='col-sm-12'>
				<label class="judul">Keterangan</label> 
				<input id="ket" name="ket"  class="form-control" type="text" placeholder="-- Nama --"disabled>
				</p>
				<div class="col-md-12"  style="margin-left: -30px;padding-top: 23px;">
					<div class="col-md-6 portfolio-image"> 
						<button type="button" id="btn_close" data-dismiss="modal" class="btn btn-primary">Close</button>
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