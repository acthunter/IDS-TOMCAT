<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">		
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
			<a class="navbar-brand" href="<?php echo site_url('/dashboard'); ?>">Akses Manajemen</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li class="no-dropdown"><a href="<?php echo site_url('/dashboard'); ?>">Beranda</a></li>
				
				<li class="no-dropdown"><a href="#" onclick="clearform_db();">Clear Form</a></li>
				<?php if ($_SESSION['pengguna']->idm_init > 0){?>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Menu <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<?php 
							echo "<li><a href='#' onclick='createnew(\"CP\");'>CHANGE POSITION (CP)</a></li>
							<li><a href='#' onclick='createnew(\"RP\");'>REVIEW POSITION (RP)</a></li>
							<li><a href='#' onclick='createnew(\"UA\");'>CREATE USER (UA)</a></li>
							<li><a href='#' onclick='createnew(\"EM\");'>EDIT EMPLOYEE (EM)</a></li>
							<li><a href='#' onclick='createnew(\"A\");'>SEARCH REQ BY ID</a></li>
							<li><a href='#' onclick='createnew(\"AI\");'>SEARCH REQ BY NPP</a></li>";
						?>
					</ul>
				</li><?php }?>

				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->session->userdata('pengguna')->nama ?> (<?php echo $this->session->userdata('pengguna')->loginid ?>) <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('/site/logout'); ?>">Logout</a></li>
						<!--<?php if ($_SESSION['pengguna']->idm_init > 0){ 
						echo "<li><a href='#' onclick='createnew(\"AF\");'>NEW CP</a></li>"; }?>-->
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>