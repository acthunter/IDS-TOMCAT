<!DOCTYPE html>
<html>
<head>
<style>
body {
    margin: 0;
}

ul#navbar {
    list-style-type: none;
    margin: 0;
	padding: 0;
    width: 15%;
    background-color: #f1f1f1;
    position: fixed;
    height: 100%;
	margin-left: -10px;
    overflow: auto;
}

li a {
    display: block;
    color: #000;
    padding: 8px 16px;
    text-decoration: none;
}

li a.active {
    background-color: #4CAF50;
    color: white;
}

li a:hover:not(.active) {
    background-color: #555;
    color: white;
}
</style>
<script type="text/javascript">
	function show_portal(link){
		var base = "<?php echo site_url(''); ?>";
		window.location = base + link;
	}
</script>
</head>
<body>
<div class="container" style="width: 100%;">
<ul id="navbar">
  <li><a href="<?php echo site_url('suspect'); ?>" id="menu">Suspect Resource Error</a></li>
  <li><a href="<?php echo site_url('wait_approval'); ?>" id="menu">Waiting Approval</a></li>
  <li><a href="<?php echo site_url('reqsuccess'); ?>" id="menu">Request Success</a></li>
  <li><a href="<?php echo site_url('audit'); ?>" id="menu">Active Login</a></li>
  <li><a href="<?php echo site_url('history_login'); ?>" id="menu">History Login</a></li>
  <li><a href="<?php echo site_url('wait_request'); ?>" id="menu">Future Request</a></li>
  <li><a href="<?php echo site_url('resource-not-create'); ?>" id="menu">Resource Not Create</a></li>
  <li><a href="<?php echo site_url('revupdate_data'); ?>" id="menu">RevUp Ready to Process</a></li>
  <li><a href="<?php echo site_url('revupdate_data_submit'); ?>" id="menu">RevUp Not Ready to Process(submit)</a></li>
  <li><a href="<?php echo site_url('sys_login'); ?>" id="menu">CAS_HUB MONITORING</a></li>
  <li><a href="<?php echo site_url('test_xml'); ?>" id="menu">test xml</a></li>
  <li><a href="<?php echo site_url('chg_req'); ?>" id="menu">Jumlah Request Perubahan</a></li>
  <li><a href="<?php echo site_url('login_sum'); ?>" id="menu">Jumlah yang sudah login</a></li>
</ul>

<div style="margin-left:15%;padding:30px; 16px;height:1000px;">
	<?php echo $this->load->view($main); ?>
</div>
</div>
</body>
</html>
