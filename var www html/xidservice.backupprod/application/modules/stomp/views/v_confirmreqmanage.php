<style>
#formpopup{
	width: 100%;
}

</style>
<div class="container">
  <!-- Modal -->
    
  <div class="modal fade"  id="modal_target_content" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-body">
			 <div id="wrap">
		<form action="#"  id="formpopup"  class="form-horizontal" role="form">
		  
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<p class="formHeader" style="font-size: 30px;">Konfirmasi Request Management</p>
			<div id="isi">
			<div class="form-group row" style="width:90%;margin-left:6%;">
				<div class="form-group">
					<label class="control-label col-sm-2" for="email">NPP:</label>
					<div class="col-sm-9">
					  <p class="form-control-static npp" ></p>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="email">NAMA:</label>
					<div class="col-sm-9">
					  <p class="form-control-static nama"></p>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="email">Unit:</label>
					<div class="col-sm-9">
					  <p class="form-control-static unit"></p>
					</div>
				</div>
				<p>		
					<label>Aplikasi </label> 
					<table id="ok_tabel" class="table table-bordered">
						<thead >
						  <tr style="background: #F6F6F6;">
							<th>Nama Aplikasi</th>
							<th>User ID</th>
							<th>Reset</th>
						  </tr>
						</thead>
							<tbody id="list_apps2">
							</tbody>
					</table>
				</p>
				<div class="col-md-12">
					<div class="col-md-6 portfolio-image">
						<button type="button" id="btn_process" class="btn btn-primary">Proses</button>
						<button type="button"   data-dismiss="modal"class="btn btn-default">Cancel</button> 
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