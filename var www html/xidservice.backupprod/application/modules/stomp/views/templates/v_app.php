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
			<p class="formHeader" style="font-size: 30px;">Request Management</p>
			<div id="isi">
			<div class="form-group row" style="width:90%;margin-left:6%;">
				<p>		
					<label>Aplikasi </label> 
					<table id="ok_tabel" class="table table-bordered">
						<thead >
						  <tr style="background: #F6F6F6;">
							<th>Nama Aplikasi</th>
							<th>Create</th>
						  </tr>
						</thead>
							<tbody id="list_apps2">
							</tbody>
					</table>
				</p>
				<div class="col-md-12">
					<div class="col-md-6 portfolio-image">
						<button type="button" id="btn_process" class="btn btn-primary">Prosess</button>
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