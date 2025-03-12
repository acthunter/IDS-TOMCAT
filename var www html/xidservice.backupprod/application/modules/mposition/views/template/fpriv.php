<script type="text/javascript">

</script>

	<div class="modal fade" id="form_tpos_detail" role="dialog">
		<div class="modal-dialog ui-front">
			<div class="modal-content" style="padding: 10px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title" style="padding-left: 190px;">KEWENANGAN</h3>
				</div>
				<div class="modal-body form">
					<form action="#" id="form_1" class="form-horizontal"> 				
						<div class="form-group row">
							<div class="col-md-4">
								<label>No User</label>
								<input name="npp" onchange="query_id()" id="npp" placeholder="No User" class=" form-control" type="text" >
							</div>
							<div class="col-md-8">
								<label>Nama</label>
								<input name="nama" id="nama" placeholder="Nama" class="form-control" type="text" >
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<label>Posisi Sekarang</label>					        
								<input name="cposname" id="cposname" placeholder="cposname" class="form-control" type="text" >
								<input name="cposid" id="cposid" type="hidden" readonly="true">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">
								<label>Posisi Target</label>
								<input name="tposname" id="tposname" placeholder="--- Posisi ---" class="autocomplete form-control" type="text" onclick="$(this).val(''); $('#tposid').val('');" >
								<input name="tposid" id="tposid" type="hidden" readonly="true">
							</div>
						</div>						
						<div class="form-group row">
							<div class="col-xs-6">
								<label>Tanggal Efektif</label>
								<input name="trx_dt" id="trx_dt" placeholder="Tanggal Efektif" class="form-control" type="text" >
							</div>
							<div class="col-xs-6">
								<label>Tanggal Expired</label>
								<input name="ex_dt" id="ex_dt" class="form-control" type="text" >
							</div>										
						</div>
						
						<div class="form-group row" name = "divnote">
							<div class="col-md-12">
								<br/>
								<label>Comment History</label>
								<div class="block-table table-sorting clearfix">
									<table cellpadding="" cellspacing="2" class="tabel" id="comment" style="width: 100%; "> 		
										<thead>
											<tr>
												<th>Tanggal</th>
												<th>LoginID</th>						
												<th>Comment</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						
						<div class="form-group" name="div_note_kew">
							<div class="col-md-12">
								<label>Notes</label>
								<input name="notes" id="notes" placeholder="Notes" class="form-control" type="text">
							</div>
						</div>
						
						<input name="status" id="status" class="form-control" type="hidden" >
						<input name="id" id="id" class="form-control" type="hidden" >
						<input name="reqid" id="reqid" class="form-control" type="hidden" >		
						<input name="reqtype" id="reqtype" class="form-control" type="hidden" >		
						
						<div class="modal-footer" id="div_btn_tpos_appr">
							<button type="button" id="btnapprove" onclick="approve()" class="btn btn-primary">Approve</button>
							<button type="button" id="btntolak" onclick="tolak()"class="btn btn-warning">Reject</button>
						</div>
						<div class="modal-footer" id="div_btn_tpos_submit">
							<button type="button" id="btntolak" onclick="tolak()" class="btn btn-primary">Submit</button>
							<button type="button" id="btnbatal" onclick="batal()"class="btn btn-warning right">Cancel</button>
						</div>
						<div class="modal-footer" id="div_btn_kew">
							<button type="button" id="btnSave" onclick="save_request()" class="btn btn-success">Submit</button>
							<button type="reset" class="btn btn-danger" data-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>