<script type="text/javascript">

</script>

	<div class="modal fade" id="form_tpos_detail_review_item" role="dialog">
		<div class="modal-dialog ui-front">
			<div class="modal-content" style="padding: 10px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" style="padding-left: 190px;">Form Pegawai</h3>
				</div>
				<div class="modal-body form">
					<form action="#" id="form" class="form-horizontal">
						<input type="hidden" value="" name="id"/> 
						<div class="form-body">
							<div class="form-group">
								<label for="npp">NPP</label>
								<input name="npp" placeholder="NPP" class=" form-control" type="text" readonly="readonly">
							</div>
							<div class="form-group"> 
								<label class="control-label">Nama</label>
								<input name="name" placeholder="Nama" class="form-control" type="text"></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Posisi</label>
								<input id="pname" name="pname" placeholder="--- Posisi ----" class="autocomplete form-control" type="text" onclick="$(this).val('');"/>   
							</div>
							<div class="form-group">
								<label class="control-label">Posisi ID</label>
								<input name="positionid" id="positionid" placeholder="Posisi ID" class="form-control" readonly="readonly" type="text"/> 
							</div>
							<div class="form-group"> 
								<label class="control-label">No HP</label>
								<input name="mobileNumber" placeholder="Nomor HP" class="form-control" type="text"></textarea>
								<input name="reqid" id="reqid" class="form-control" type="hidden" >
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer" id="div_btn_admin">
					<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>