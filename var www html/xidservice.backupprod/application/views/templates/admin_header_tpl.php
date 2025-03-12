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
				
				<?php if ($_SESSION['pengguna']->idm_super > 0) 
					echo "
				<li class='no-dropdown'><a href='#' onclick='show_portal(\"home\");'>IDS</a></li>
				<li class='no-dropdown'><a href='#' onclick='show_portal(\"sysadmin\");'>Sysadm</a></li>
				<li class='no-dropdown'><a href='#' onclick='show_portal(\"batchctl\");'>Sysparam</a></li>
				<li class='no-dropdown'><a href='#' onclick='show_portal(\"sysrequest\");'>Batch Sys</a></li>
				<li class='no-dropdown'><a href='#' onclick='show_portal(\"stomp1\");'>Inq Banc</a></li>
				<li class='dropdown'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#'>Administrator <span class='caret'></span></a>
					<ul class='dropdown-menu'>
							<li><a href='#' onclick='show_portal(\"employee2\");'>EditEmpl</a></li>
							<li><a href='#' onclick='show_portal(\"previledge\");'>EditPreviledge</a></li>
							<li><a href='#' onclick='show_portal(\"monitoring\");'>Monitoring</a></li>
							<li><a href='#' onclick='show_portal(\"reviewupdate\");'>ReviewUpdate</a></li>
					</ul>
				</li>	
				
				
				";
				
				?>
				

				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->session->userdata('pengguna')->nama ?> (<?php echo $this->session->userdata('pengguna')->loginid ?>) <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('/site/logout'); ?>">Logout</a></li>
						<li><a href="#" onclick='createnew(\"AF\");'>Administration</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>

<script type="text/javascript">
	function show_portal(link){
		var base = "<?php echo site_url(''); ?>";
		window.location = base + link;
	}
</script>