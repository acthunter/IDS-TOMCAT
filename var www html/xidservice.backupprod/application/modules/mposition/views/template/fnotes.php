<script type="text/javascript">

</script>	
	
	<div class="modal fade" id="modal_comment" role="dialog">
		<div class="modal-dialog ui-front">
			<div class="modal-content" style="padding: 10px; width: 500px; margin-left: 85px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<center><h3 class="modal-title"></h3></center>
				</div>
				<div class="modal-body form">
					<form action="#" id="form_1" class="form-horizontal"> 				
						<div class="form-group row">
							<div class="col-md-6">
								<label>You reject this data because : </label>
								<textarea style="width: 441px;"name="note" id="note" class=" form-control" value = "" ="10" type="text"></textarea>
							</div>
							<input name="id" id="id" class="form-control" type="hidden" >
							<input name="reqid" id="reqid" class="form-control" type="hidden" >		
							<input name="reqtype" id="reqtype" class="form-control" type="hidden" >	
						</div>					
					</form>
				</div>
				
				<div class="modal-footer" id="div_btn_review_comment">
					<button type="button" id="btncancel" onclick="cancel()"class="btn btn-warning">Submit1</button>
				</div>
				<div class="modal-footer" id="div_btn_review_comment2">
					<button type="button" id="btnupdate" onclick="update()" class="btn btn-warning">Submit2</button>
				</div>
				<div class="modal-footer" id="div_btn_review_comment3">
					<button type="button" id="btnadd" onclick="add()" class="btn btn-warning" value="P">Submit3</button>
				</div>
			</div>
		</div>
	</div>