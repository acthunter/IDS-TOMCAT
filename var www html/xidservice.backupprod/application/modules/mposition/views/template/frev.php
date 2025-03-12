<script type="text/javascript">

</script>

	<div class="container" >	
		<div class="modal fade" id="form_tpos_detail_review" role="dialog" style="padding-left: 300px;" >
			<div class="modal-dialog ui-front" >
				<div class="modal-content" style="padding: 10px; width: 828px; border-left-width: 0px; left: -127px;">
					<input name="reqid" id="reqid" class="form-control" type="hidden" >
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title" style="padding-left: 284px;">POSISI</h3>
					</div>
					<div class="modal-body form">
						<div class="block-table table-sorting clearfix">
							<table cellpadding="" cellspacing="2" class="tabel" id="datatable" style="width: 100%;" >		
								<thead>
									<tr>
										<th>No</th>
										<th>Req ID</th>
										<th>NPP</th>
										<th>Nama</th>
										<th>Posisi ID</th>
										<th>Posisi</th>						
										<th>No HP</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
							<input name="reqtype" id="reqtype" class="form-control" type="hidden" >
						</div>
						
						<div class="form-group row" name = "divnote">
							<div class="col-md-12">
								<br/>
								<label>Comment History</label>
								<div class="block-table table-sorting clearfix">
									<table cellpadding="" cellspacing="2" class="tabel" id="comment2" style="width: 100%; "> 		
										<thead>
											<tr>
												<th>No</th>
												<th>Tanggal</th>
												<th>Jam</th>
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
						
						<div class="modal-footer" id="div_btn_review_appr">
							<button type="button" id="btnapprove" onclick="approve()" class="btn btn-primary">Approve</button>
							<button type="button" id="btntolak" onclick="tolak()"class="btn btn-warning">Reject</button>
						</div>
						<div class="modal-footer" id="div_btn_review_submit">
							<button type="button" id="btntolak" onclick="tolak()" class="btn btn-primary">Submit</button>
							<button type="button" id="btnbatal" onclick="batal()"class="btn btn-warning right">Cancel</button>
						</div>
						<div class="modal-footer" id="div_btn_submit">
							<button type="button" id="btntolak" onclick="tolak()" class="btn btn-primary">Submit</button>
						</div>
					</div>	
				</div>
			</div>	
		</div>	
	</div>	