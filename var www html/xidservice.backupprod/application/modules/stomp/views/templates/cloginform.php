<html lang="en">
<head>
<meta charset="UTF-8">
<title>Simple Bootstrap Modal with Dynamic content Using remote URL</title>

<script type="text/javascript">
	var dt_mylogin;
	
	$(document).ready(function(){
		 
		dt_mylogin = $('#dt_mylogin').DataTable({ 
					"processing": true, 
				"serverSide": true, 
				"order": [], 
				"ajax": {
					"url": "<?php echo site_url('stomp/xctest/loginlist')?>",
					"type": "POST"
				},
				"columns" : [
				{"data":"loginid",
				 width: "20px"},
				{"data":"name"
				  },
				{"data":"s5",
				  width: "30px"},
				 {"data":"s4",
				  width: "30px"},
				{"data":"s3",
				  width: "30px"},
				{"data":"s2",
				  width: "30px"},
				{"data":"s1",
				  width: "30px"},
				],
				"columnDefs": [
				{  
					"targets": [ -1 ],
					"orderable": false, 
				}
				
				],
		});
		
		$('#dt_mylogin').on('click', 'tr:not(:first)', function () {
				var rdata = dt_mylogin.row($(this).index()).data();
				
				var fparam = {'loginid' : rdata['loginid'], 'passwd' : rdata['loginid']};
				$('#loginid').val( rdata['loginid']);
				$('#passwd').val( rdata['loginid']);
				$('#init').val( rdata['s1']);
				$('#appr').val( rdata['s2']);
				$('#sys').val( rdata['s3']);
				$('#ithde').val( rdata['s4']);
				$('#idadmin').val( rdata['s5']);
				$('#btn_submit').trigger('click');

				
		});
	 });

	 
	
function pageRedirect() {
		var url = "<?php echo site_url('logout')?>" ;
		//var url1 = "<?php echo site_url('login')?>" ;
        window.location.replace('logout',url);
		//window.location.replace('login',url1);
    }   
	
</script>
</head>

<button type="button" class="btn btn-info" onclick="pageRedirect()" style="background-color: #003366; font-size:100%; color:#fff; margin-bottom: 20px;">Clear Cache</button>
<br>
<body>
<div class="container" style="width: 100%;">
				<table cellpadding="" cellspacing="2" class="tabel" id="dt_mylogin" style="width: 100%"> 			
					<thead>
						<tr>
							<th>login</th>
							<th>Name</th>
							<th>id admin</th>
							<th>ithde</th>
							<th>sys</th>
							<th>appr</th>
							<th>init</th>
						</tr>
					</thead>
						<tbody  id="vote_buttons" name="vote_buttons">
						</tbody>
				</table>
</div>

		<div style="display: none;">
			<form id="login_form" action="<?php echo site_url('login')?>" method="POST">
				<input id=loginid type="text" name="loginid" value=""/>
				<input id=passwd type="text" name="passwd" value=""/>
				<input id=init type="text" name="init" value=""/>
				<input id=appr type="text" name="appr" value=""/>
				<input id=sys type="text" name="sys" value=""/>
				<input id=ithde type="text" name="ithde" value=""/>
				<input id=idadmin type="text" name="idadmin" value=""/>
				<button type="submit" id="btn_submit">Send</button>
			</form>
		</div>
</body>
</html>
