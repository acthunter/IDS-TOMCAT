<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
	
})
</script>
</head>

<body>
<div class="panel panel-default">
    <div class="panel-heading"> <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Bagaimana cara mengakses sistem Single Sign On?</b></h5></div>
    <div class="panel-body">Single Sign On dapat diakses melalui browser Chrome atau Mozilla Firefox tanpa menggunakan proxy. Apabila PC telah tersambung dengan proxy, maka dapat dilakukan setting proxy untuk browser yang digunakan. Cara setting proxy browser dapat dilihat pada e-training di <a href="http://bniforum.bni.co.id" style= "color: #FF0000;text-decoration: underline;">http://bniforum.bni.co.id.</a></div>
  </div>
  <div class="panel panel-default ">
    <div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Sudah berhasil login SSO, tetapi kenapa mendapat notifikasi ‘Kewenangan Aplikasi Belum Tersedia’?</b></h5></div>
    <div class="panel-body">Menu ID Service (IDS) hanya didapat oleh user dengan posisi yang berwenang sebagai Admin (asisten administrasi umum, asisten bagian umum, asisten logistik dan sdm) atau Approval (Pemimpin Cabang, PBP, PBN, PBO). Selain posisi tersebut maka user hanya dapat melakukan aktivitas self-service saja, seperti reset password ICONS atau Webmail yang menunya terletak di pojok kanan atas (Reset Target) tanpa membutuhkan approval pemimpin.</div>
  </div>
  <div class="panel panel-default ">
    <div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Mengapa pada saat pertama kali mengakses SSO muncul keterangan ‘Your connection is not secure’?</b></h5></div>
    <div class="panel-body">Setting sertifikat dapat dilihat pada e-training (confirm security certificate) di <a href="http://bniforum.bni.co.id"style= "color: #FF0000;text-decoration: underline;">http://bniforum.bni.co.id.</a></div>
  </div>
    <div class="panel panel-default ">
    <div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Berapa lama waktu yang dibutuhkan untuk menerima SMS OTP?</b></h5></div>
    <div class="panel-body">Tergantung provider yang digunakan oleh masing-masing user. Apabila belum menerima OTP lebih dari 3 menit, maka dapat coba resend OTP atau bisa melakukan proses dari awal kembali.</div>
  </div>
    <div class="panel panel-default ">
    <div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Sudah melakukan update no HP di HCMS, tetapi mengapa pada saat lupa password no HP masih salah?</b></h5></div>
    <div class="panel-body">Sistem SSO belum terintegrasi dengan HCMS, apabila ada perubahan no HP dapat diinfokan melalui group WA Implementasi SSO. Atau bisa dilakukan update no HP beserta posisi seluruh pegawai melalui fitur Review Posisi yang dapat dilakukan setiap bulan.</div>
  </div>
    <div class="panel panel-default ">
    <div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Bagaimana melakukan perubahan posisi untuk pegawai sentra?</b></h5></div>
    <div class="panel-body">Untuk saat ini pegawai Sentra, Syariah, dan Bina belum diakomodasi melalui SSO.</div>
  </div>
  <div class="panel panel-default ">
    <div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Mengapa pada saat login muncul error ‘This account has been locked’?</b></h5></div>
    <div class="panel-body">Pada saat user telah mencoba login namun password yang diinput salah sebanyak lebih dari 5x maka akun user tersebut akan dilock secara otomatis. Untuk membuka lock tersebut, silahkah diinfokan melalui group WA Implementasi SSO.</div>
  </div>
  <div class="panel panel-default ">
    <div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Bagaimana mekanisme perubahan di SSO?</b></h5></div>
    <div class="panel-body">Perubahan unit, posisi permanen, dan posisi sementara akan efektif sehari setelah dilakukan perubahan tersebut. Untuk melakukan perubahan posisi sementara 1 hari saja, maka dapat dipilih perubahan untuk Hari yang Sama. Apabila perubahan posisi sementara untuk jangka waktu tertentu, maka dapat dipilih perubahan untuk Beda Hari. Jika menginginkan perubahan tersebut efektif hari ini, maka dapat dilakukan change temporary posisi tersebut satu hari (hari ini).</div>
  </div>
  <div class="panel panel-default ">
    <div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Bagaimana pada saat melakukan pencarian NPP user, tetapi posisi yang tertera tidak sesuai?</b></h5></div>
    <div class="panel-body">User tersebut didaftarkan posisinya sesuai dengan data HCT, sebaiknya segera melakukan Review Posisi terlebih dahulu untuk memastikan kesesuaian posisi pegawai.</div>
  </div>
    <div class="panel panel-default ">
    <div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Bagaimana pada saat melakukan perubahan posisi untuk Weekend Banking, namun posisi user tidak kembali sesuai dengan posisi saat ini?</b></h5></div>
    <div class="panel-body">Sebaiknya segera melakukan Review Posisi terlebih dahulu untuk memastikan kesesuaian posisi pegawai.</div>
  </div>
  <!--<div class="panel panel-default ">
    <div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Panel Heading</b></h5></div>
    <div class="panel-body">Panel Content</div>
  </div>-->

</body>
</html>
