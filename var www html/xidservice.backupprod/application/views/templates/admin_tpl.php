<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>ID Service</title>

	<!-- begin style plugins -->
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/plugins/bootstrap/css/bootstrap.css'); ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/plugins/bootstrap/css/bootstrap-toggle.min.css'); ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/plugins/bootstrap/css/dashboard.css'); ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/plugins/font-awesome/css/font-awesome.min.css'); ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/plugins/dataTables/css/jquery_data_tables.css'); ?>" media="screen" />
	<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/plugins/jQuery_v1.11.2/jquery-ui.css'); ?>" media="screen" />-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/plugins/dataTables/css/jquery.dataTables.min.css'); ?>" media="screen" />
	<!--add datetimepicker-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/datepicker/css/bootstrap-datetimepicker.min.css'); ?>" media="screen" />
	<!--add datetimepicker-->
	<!--add mrjsontable-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/mrjsontable/css/mrjsontable.css'); ?>" media="screen" />
	<!--add mrjsontable-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/style_admin.css'); ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/style_print.css'); ?>" media="print" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/icons.css'); ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/buttons.dataTables.min.css'); ?>" media="screen" />
	<!-- end begin style plugins -->
	
	<!-- begin js plugins -->	

	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/jQuery_v1.11.2/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/jQuery_v1.11.2/jquery.tabledit.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/jQuery_v1.11.2/jquery.tabledit.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/bootstrap/js/bootstrap-toggle.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/cookie/jquery.cookies.2.2.0.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/dataTables/js/jquery.dataTables.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/js/fnReloadAjax.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/jQuery_v1.11.2/jquery-ui.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/datepicker/js/moment.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/datepicker/js/bootstrap-datetimepicker.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/mrjsontable/scripts/mrjsontable.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/mrjsontable/scripts/mrjsontable.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/js/dataTables.buttons.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/js/buttons.html5.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/js/jszip.min.js'); ?>"></script>
	<!-- end begin js plugins -->
	
	<script type="text/javascript" src="<?php echo base_url('/assets/js/js_cookies.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/js/js_template.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/js/js_plugins.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/js/js_function.js'); ?>"></script>
	<!--<script type="text/javascript" src="<?php echo base_url('/assets/js/js_currency.js'); ?>"></script>-->
	
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/bootstrap/js/ie8-responsive-file-warning.js'); ?>"></script>
	<![endif]-->
    <script type="text/javascript" src="<?php echo base_url('/assets/plugins/bootstrap/js/ie-emulation-modes-warning.js'); ?>"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script type="text/javascript" src="<?php echo base_url('/assets/plugins/bootstrap/js/holder.min.js'); ?>"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script type="text/javascript" src="<?php echo base_url('/assets/plugins/bootstrap/js/ie10-viewport-bug-workaround.js'); ?>"></script>
	
</head>
<body>
	<?php echo $this->load->view($header); ?>
    <div class="container-fluid">
		<div class="row">
			 
		
				<?php echo $this->load->view($content); ?>
	
        </div>
    </div>
</body>
</html>