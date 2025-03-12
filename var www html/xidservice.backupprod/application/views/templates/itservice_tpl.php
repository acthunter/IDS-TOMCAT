<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>ID Service</title>	
		<!-- begin style plugins -->
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/plugins/bootstrap/css/bootstrap-toggle.min.css'); ?>" media="screen" />
	<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/plugins/bootstrap/css/dashboard.css'); ?>" media="screen" />-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/plugins/font-awesome/css/font-awesome.min.css'); ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/plugins/dataTables/css/jquery_data_tables.css'); ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/plugins/jQuery_v1.11.2/jquery-ui.css'); ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/plugins/dataTables/css/jquery.dataTables.min.css'); ?>" media="screen" /> 
	<!--add datetimepicker-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/datepicker/css/bootstrap-datetimepicker.min.css'); ?>" media="screen" /> <!-- untuk datetimepicker -->
	<!--add datetimepicker-->
	<!--add mrjsontable-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/mrjsontable/css/mrjsontable.css'); ?>" media="screen" /> <!--untuk table -->
	<!--add mrjsontable-->
	<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/style_admin.css'); ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/style_print.css'); ?>" media="print" /> -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/icons.css'); ?>" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/style4.css'); ?>" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/style2.css'); ?>" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/pnotify.custom.min.css'); ?>" media="screen" />
	<!-- end begin style plugins -->
	
	<!-- begin js plugins -->	
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/jQuery_v1.11.2/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/js/jquery.validate.min.js'); ?>"></script> 
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/jQuery_v1.11.2/jquery.tabledit.min.js'); ?>"></script> <!-- kayaknya tidak terpakai -->
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/bootstrap/js/bootstrap-toggle.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/cookie/jquery.cookies.2.2.0.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/dataTables/js/jquery.dataTables.min.js'); ?>"></script> <!--Datatable-->
	<script type="text/javascript" src="<?php echo base_url('/assets/js/fnReloadAjax.js'); ?>"></script> <!-- datatable -->
	<script type="text/javascript" src="<?php echo base_url('/assets/plugins/jQuery_v1.11.2/jquery-ui.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/datepicker/js/moment.min.js'); ?>"></script> <!-- datepicker-->
	<script type="text/javascript" src="<?php echo base_url('/assets/datepicker/js/bootstrap-datetimepicker.min.js'); ?>"></script>
	<script src="/tstomp/bucky.js" data-bucky-host="/bucky" data-bucky-page="idssite-itservice"/>
	<!-- end begin js plugins -->
	
	<script type="text/javascript" src="<?php echo base_url('/assets/js/js_cookies.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/js/js_template.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/js/js_plugins.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/js/pnotify.custom.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/js/js_function.js'); ?>"></script>
</head>
<body>
<style>

#content{
     background: #DCDCDC; 
}
</style>
        <div class="wrapper">
            <!-- Sidebar Holder -->
            <nav id="sidebar">
			<button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn"style="font-size:110%">
                    <i class="fa fa-bars"style="font-size:130%"></i>
					</button>
                <div class="sidebar-header" style="color:#000000">
                     <h3><center><img src="/idservice/assets/images/Logobni.jpg" style="width: 46%;margin-top: -5%"><br><a style="font-size : 110%"><b> ID Service</b></a></center></h3>
                    <strong>IDS</strong>
					
					
                </div>
					<a href="#pagelogout" data-toggle="collapse" aria-expanded="false" style="color:#000000">
                        <center><i class="fa fa-user fa-3x" aria-hidden="true"></i></center><br>
						<center><?php echo $this->session->userdata('pengguna')->nama ?> (<?php echo $this->session->userdata('pengguna')->loginid ?>)</center>
						</a>       
                <ul class="list-unstyled components" id="nav">
				   <li>
						<?php if ($_SESSION['pengguna']->idm_init > 0 or $_SESSION['pengguna']->idm_appr > 0){?>
                        <a href="<?php echo site_url('home'); ?>">
                            <i class="glyphicon glyphicon-home"></i>
                            Beranda
                        </a>
						<?php }?>	
                    </li>
				
				   <!--<li>
						
						<a href="<?php echo site_url('enduser'); ?>" onclick="clearform_db();">
                            <i class="fa fa-recycle" aria-hidden="true"></i>
                            Ganti Password
                        </a>
											
                    </li>-->
					
					<?php if ($_SESSION['pengguna']->idm_ithde > 0){?>
					<li>
						
						<a href="<?php echo site_url('endsession'); ?>" onclick="clearform_db();">
                           <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            Kill User
                        </a>
											
                    </li>
					<?php }?>
					<?php if ($_SESSION['pengguna']->idm_idadmin > 0){?>
					<li>
						<a href="<?php echo site_url('idadmin'); ?>" onclick="clearform_db();">
                            <i class="fa fa-recycle" aria-hidden="true"></i>
                            antrian
                        </a>
											
                    </li>
					<?php }?>	
					<?php if ($_SESSION['pengguna']->idm_ithde > 0){?>
				   <li>
						
						<a href="<?php echo site_url('itservice'); ?>" onclick="clearform_db();">
                            <i class="fa fa-key" aria-hidden="true"></i>
                            Reset Target HDE
                        </a>
						<?php }?>	
                    </li>

					 <li>
						<?php if ($_SESSION['pengguna']->idm_super > 0){?>
						<a href="<?php echo site_url('sysadmin'); ?>" onclick="clearform_db();">
                            <i class="fa fa-key" aria-hidden="true"></i>
                            Sysadmin
                        </a>
						<?php }?>	
                    </li>	
					
					<?php if ($_SESSION['pengguna']->idm_init > 0 ){?>		
                    <li>			
						
                         <a id="admin" style="cursor:pointer" >
                           <i class="fa fa-list" aria-hidden="true"></i>
                            Admin
							<span class="caret"></span>
                        </a>
                            <?php 
							if ($_SESSION['pengguna']->idm_init > 0  ){
							echo "<div style='margin-left: 13%; font-size: 12px;background:#F7FAFA;'><a href='#' onclick='createnew(\"CT\");'>Posisi Sementara</a>							
							<a href='#' onclick='createnew(\"CP\");' >Posisi Permanen</a>
							<a href='#' onclick='createnew(\"CU\");'>Ubah Unit</a>
							<a href='#' onclick='createnew(\"UA\");'>Tambah User Baru</a>
							<a href='#' onclick='createnew(\"RP\");'>Review Position</a>
							<strong style='font-size:20px;'> </strong>
							</div>
							";  }
						?>
                    </li>
					<?php }?>
				   <li>
						<a href="<?php echo site_url('/site/logout'); ?>" onclick="clearform_db();">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            Keluar
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Page Content Holder -->
            <!-- <div id="content" style="background: #F8F8F8;"> -->
			<div class="page-bg"></div>
			<div id="content" style="width: 10000px;">
			
			<div id="navbar">	

					<div class="container" style="width:100%; padding:0;">
					
					<?php echo $this->load->view($content); ?>
					</div>
			</div>

			</div>
         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
					 $('#content').toggleClass('active');
                 });
             });
			 $('#admin').on('click', function () {
                     $('#sidebar').removeClass('active');
					 $('#content').removeClass('active');
                 });
         </script>
</body>
</html>