<!DOCTYPE html>
<html>
<head>
	<h2><center>Informasi Improvement Fitur <i>Single Sign-on</i> (SSO)</center></h2><br>
	<ol class="breadcrumb" style="margin-left: 150px;margin-right: 150px;">
		<li class="first"><a href="http://psso1.bni.co.id/xidservice/home">Home</a></li>
		<li class="second"><a href="http://psso1.bni.co.id/didservice/soc">Improvement Fitur Perubahan Posisi</a></li>
		<li class="active last">Improvement Fitur SSO</li>
		<button type="submit" style="float: right; background-color: #008c90; color: #ffffff" class="active last" onclick="goBack()"><b>Ke Halaman ID Service</b></button>
	</ol>	
</head>
<script>
$(document).ready(function(){
    $('.panel-body').hide();
	$('div.panel-heading').click();	 
});
$(document).on('click', 'div.panel-heading', function(e){
    var $this = $(this);
	if (!$(this).next("div.panel-body").is(':visible')) {
            $(".panel-body").hide(600);
			$(".panel-heading").find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
    }
	if(!$this.hasClass('panel-collapsed')) {
		$this.parents('.panel').find('.panel-body').slideUp();
		$this.addClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');		
	} else {
		$this.parents('.panel').find('.panel-body').slideDown();
		$this.removeClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');		
	}
});

function goBack() {
    window.location.href = "http://psso1.bni.co.id/xidservice/home";
}
</script>
<style>	
	.panel-default {
		margin-left: 167px;
		margin-right: 167px;
		border-radius: 15px;
	}
	.panel-default > .panel-heading {
		background-color: #b0b0b0;
	}
	mark {
		background-color: yellow;
	}
	li {
		font-size: medium;
	}
</style>
<body>
	<ul style="margin-left: 131px;margin-right: 149px; line-height: 1.5em;">
		<h5>
			<li>Pada hari <b>Kamis, 23 Agustus 2018</b> telah dilakukan <i>improvement</i> untuk fitur aplikasi ID Service (IDS) SSO. Berikut adalah beberapa fitur yang di-<i>update</i> :</li>
		</h5>		
	</ul>
	<div class="panel panel-default ">
		<div class="panel-heading"> <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Fitur SCO sudah dapat dilakukan pada aplikasi ID Service - SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Perubahan posisi (permanen, sementara, dan perubahan unit) untuk pegawai yang memiliki user SCO <b>secara otomatis akan meng-<i>update</i> iCons SCO sesuai kewenangan SCO pegawai tersebut</b>.</li>
			</ul>		
			<ul>
				<li>Apabila pegawai tidak dapat login iCons SCO dikarenakan lupa password, pegawai tersebut dapat melakukan reset password secara mandiri melalui fitur <mark><b>Reset Target</b></mark> dan memilih target <b>ICONS Syariah</b> pada aplikasi CAS.</li>
			</ul>
			<ul>
				<li>Setelah melakukan Reset Password iCons Syariah, pegawai akan mendapatkan notifikasi email yang berisi informasi userID SCO pegawai tersebut.</li>
			</ul>
			<img src="<?php echo base_url('assets/images/rtsco.jpg'); ?>"style="width: 45%; margin-bottom:10px; margin-left:28%;">
			<ul>
				<li>Fitur tersebut hanya akan muncul pada pegawai yang memiliki iCons SCO sebelumnya.</li>
			</ul>
			<ul>
				<li>Untuk pembuatan <b>iCons SCO baru</b>, silahkan menghubungi <b>Divisi Teknologi Informasi BNI Syariah (ITD)</b>.</li>
			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading"> <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Fitur Informasi User</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Informasi <b>posisi, kode cabang, dan userID SCO</b> dapat dilihat pada fitur Informasi User dengan input <b>NPP atau Nama</b> pada field Search seperti contoh berikut :
			</ul>
			<img src="<?php echo base_url('assets/images/newinfo.gif'); ?>"style="width: 45%; margin-bottom:10px; margin-left:28%;">
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading"> <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Perubahan Unit</b></h5></div>
		<div class="panel-body">
			<ul>
				<li><b>Perubahan unit dapat efektif hari yang sama</b><br>Perubahan unit dapat efektif pada hari yang sama dengan melakukan <i>setting</i> tanggal dan jam efektif sesuai contoh berikut :				
				
			</ul>
			<img src="<?php echo base_url('assets/images/CU.jpg'); ?>"style="width: 45%; margin-bottom:10px; margin-left:28%;">
			<ul>
				<mark style="font-size: medium; color: red"><b>dengan catatan :</b><br></mark>
				<li style="color: red;">iCons user yang dilakukan perubahan <b>belum</b> <i>sign on</i> di cabang sebelumnya.</li>
				<li style="color: red;">Apabila pegawai tersebut telah <i>sign on</i> di cabang sebelumnya, maka perubahan unit akan efektif pada <b>H+1</b> setelah dilakukan perubahan.</li>
			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading"> <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Tambah User Baru</b></h5></div>
		<div class="panel-body">
			<img src="<?php echo base_url('assets/images/nua.jpg'); ?>"style="width: 45%; margin-bottom:10px; margin-left:28%;">
			<ul>
				<li>Fitur tambah user baru secara otomatis akan membuat user <b>CAS, iCons, dan Webmail</b> pegawai yang dapat efektif pada hari yang sama.</li>
			</ul>
			<ul>
				<li>Apabila tombol <b>Save</b> tidak muncul, maka pegawai tersebut sudah terdaftar di unit lain. Silahkan menghubungi unit terkait untuk melakukan Ubah Unit atau menghubungi Administrator.</li>
			</ul>
		</div>
	</div> 
</body>
</html>
