<!DOCTYPE html>
<html>
<head>
	<h2><center>Frequently Asked Question (FAQ)</center></h2><br>
	<ol class="breadcrumb" style="margin-left: 150px;margin-right: 150px;"><li class="first"><a href="https://psso1.bni.co.id/cas/login">Home</a></li>
		<li class="active last">Frequently Asked Question (FAQ)</li>
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
</script>
<style>
	.panel-default {
		margin-left: 150px;
		margin-right: 150px;
		border-radius: 15px;
	}
	.panel-default > .panel-heading {
		background-color: #008c90;
		color: #ffffff;
	}
	mark {
		background-color: yellow;
	} 
	blink {
    -webkit-animation: 2s linear infinite condemned_blink_effect; // for android
    animation: 2s linear infinite condemned_blink_effect;
}
@-webkit-keyframes condemned_blink_effect { // for android
    0% {
        visibility: hidden;
    }
    50% {
        visibility: hidden;
    }
    100% {
        visibility: visible;
    }
}
@keyframes condemned_blink_effect {
    0% {
        visibility: hidden;
    }
    50% {
        visibility: hidden;
    }
    100% {
        visibility: visible;
    }
}
</style>
<body>

<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan Aplikasi Smarforex pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Aplikasi Smartforex dapat diakses menggunakan user ID dan password webmail / eoffice</li>
				<li>Role/akses aplikasi akan sesuai dengan posisi jabatannya, Admin diharapkan melakukan update posisi untuk user yang mendapatkan kewenangan aplikasi Smartforex</li>
				<li>Untuk user yang sudah melakukan reset target / reset webmail namun belum bisa login silahkan dipermanenkan ulang ke posisi definitifnya saat ini</li>

				<br>
				<li>List Posisi yang mendapatkan kewenangan Smartforex:</li>
				
				<br><ul style="border: 1px solid black;background: #f0f0f0;"><br>

				
					<h5><b>BOP</b></h5>
					<ul style="column-count: 3;">
						<li>Cash Operations Department Head</li>
						<li>Banknotes Operations Section Head</li>
						<li>Banknotes Operations Staff</li>
						<li>Treasury Operations Department Head</li>
						<li>System & Regulatory Reporting Section Head</li>
						<li>System & Regulatory Reporting Senior Staff</li>
						<li>Remittance Operation Department Head</li>
						
						<li>ITR Customer Section Head</li>
						<li>ITR Customer Supervisor</li>
						<li>ITR Customer Staff</li>
						
						<li>ITR Refund & Amend Section Head</li>
						<li>ITR Refund & Amend Supervisor</li>
						<li>ITR Refund & Amend Staff</li>
			
					</ul>
					<br>
					
					<h5><b>CABANG</b></h5>
					<ul style="column-count: 3;">
						<li>Pemimpin Kantor Cabang</li>
						<li>Branch Service Manager</li>
						<li>Pemimpin Kantor Cabang Pembantu</li>
						
						<li>Teller Supervisor</li>
						<li>Senior Frontliner - Fungsi Teller</li>
						<li>Teller</li>
						<li>Cashier Staff</li>
						<li>Customer Service Supervisor</li>

						<li>Senior Frontliner - Fungsi Customer Service</li>
						<li>Customer Service</li>
						<li>Senior Frontliner - Fungsi Customer Service (Cab JPU dan kelolaannya)</li>
						<li>Customer Service (Cab JPU dan kelolaannya)</li>

						<li>Emerald Supervisor</li>
						<li>Emerald Service Staff</li>
						<li>Emerald Service Staff (Cab JPU dan kelolaannya)</li>
						<li>Cash Center Supervisor</li>
						<li>Cash Center Staff</li>
						
					</ul>
					<br>
					
					<h5><b>TRS</b></h5>
					<ul style="column-count: 3;">
						<li>Treasury Deputy Division Head</li>
						<li>Treasury Marketing & Client Specialist Department Head</li>
						<li>Treasury Wholesale Solution Department Head</li>
						<li>Dealer FX & Multi Asset Trading</li>

						<li>Junior Dealer FX & Multi Asset Trading</li>
						<li>Senior Staff FX & Multi Asset Trading</li>
						<li>Team Leader Treasury System Development & Implementation</li>
						
						<li>Senior Staff Treasury System Development & Implementation</li>
						<li>Officer Treasury System Development & Implementation</li>
						<li>Chief Dealer Corporate Treasury Client Specialist</li>
						<li>Senior Dealer Corporate Treasury Client Specialist</li>
						
						<li>Dealer Corporate Treasury Client Specialist</li>
						<li>Chief Dealer Enterprise Treasury Client Specialist</li>
						<li>Senior Dealer Enterprise Treasury Client Specialist</li>
						<li>Dealer Enterprise Treasury Client Specialist</li>
						
						<li>Junior Dealer Enterprise Treasury Client Specialist</li>
						<li>Chief Dealer Commercial & Regional Treasury Client Specialist</li>
						<li>Senior Dealer Commercial & Regional Treasury Client Specialist</li>
						<li>Dealer Commercial & Regional Treasury Client Specialist</li>
						
						<li>Junior Dealer Commercial & Regional Treasury Client Specialist</li>
						<li>Chief Dealer Treasury Structuring & Derivative Product</li>
						<li>Senior Dealer Treasury Structuring & Derivative Product</li>
						<li>Dealer Treasury Structuring & Derivative Product</li>
						
						<li>Junior Dealer Treasury Structuring & Derivative Product</li>
						<li>Chief Dealer Treasury Client Dealing</li>
						<li>Senior Dealer Treasury Client Dealing</li>
						<li>Dealer Treasury Client Dealing</li>
						
						<li>Junior Dealer Treasury Client Dealing</li>
						<li>Senior Staff Treasury Client Dealing</li>
						<li>Staff Treasury Client Dealing</li>
						<li>Chief Dealer Marketing Trading</li>
						
						<li>Senior Dealer Marketing Trading</li>
						<li>Dealer Marketing Trading</li>
						<li>Junior Dealer Marketing Trading</li>
						<li>Chief Dealer Retail & Digital FX</li>
						
						<li>Senior Dealer Retail & Digital FX</li>
						<li>Dealer Retail & Digital FX</li>
						<li>Junior Dealer Retail & Digital FX</li>
						<li>Chief Dealer Client & Digital Bonds</li>
						
						<li>Senior Dealer Client & Digital Bonds</li>
						<li>Dealer Client & Digital Bonds</li>
						<li>Junior Dealer Client & Digital Bonds</li>
						
					</ul>
					
				
				</ul>
		</ul>
			
			
		</div>
	</div>


	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan Aplikasi SKA Enterprise pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Aplikasi SKA Enterprise dapat diakses menggunakan user ID dan password webmail / eoffice</li>
				<li>Role/akses aplikasi akan sesuai dengan posisi jabatannya, Admin diharapkan melakukan update posisi untuk user yang mendapatkan kewenangan aplikasi SKA Enterprise</li>
				<li>Untuk user yang sudah melakukan reset target / reset webmail namun belum bisa login silahkan dipermanenkan ulang ke posisi definitifnya saat ini</li>

				<br>
				<li>List Posisi yang mendapatkan kewenangan SKA Enterprise:</li>
				
				<br><ul style="border: 1px solid black;background: #f0f0f0;"><br>
					
					<h5><b>DGO</b></h5>
					<ul style="column-count: 3;">
						<li>MGR of Policy & Procedure Digital Operations</li>
						<li>AMGR of Policy & Procedure Digital Operations</li>
						<li>Section Head of Handling Complain Team</li>
						<li>Senior Staff of Handling Complain Team (Analis)</li>

						<li>Staff of Handling Complain Team (Cardlink)</li>
						<li>Departement Head of ATM & Self-service Management Departement</li>
						<li>Section Head of ATM Control & Report Cash Limit Solutions</li>
						<li>Senior Staff ATM Control & Report Cash Limit Solutions</li>
						
						<li>Staff of ATM Control & Report Cash Limit Solutions Team</li>
						<li>Staff of ATM Control & Report Cash Limit Solutions Team (TAD/OS/Bina BNI)</li>
						<li>Departement Head of Reconciliation II Department</li>
						<li>Section Head of Cash Reconciliation I Team</li>
						
						<li>Senior Staff of Cash Reconciliation I Team</li>
						<li>Staff of Cash Reconciliation I Team</li>
						<li>Staff of Cash Reconciliation I Team (TAD/OS/Bina BNI)</li>
						<li>Section Head of Cash Reconciliation II Team</li>
						
						<li>Senior Staff of Cash Reconciliation II Team</li>
						<li>Staff of Cash Reconciliation II Team</li>
						<li>Staff of Cash Reconciliation II Team (TAD/OS/Bina BNI)</li>
						<li>Section Head of Cash Reconciliation III Team</li>
						
						<li>Senior Staff of Cash Reconciliation III Team</li>
						<li>Staff of Cash Reconciliation III Team</li>
						<li>Staff of Cash Reconciliation III Team (TAD/OS/Bina BNI)</li>
						<li>Senior Staff of Interchange Team</li>
						<li>Staff of Interchange Team</li>
						
						
					</ul>
					
				
				</ul>
		</ul>
			
			
		</div>
	</div>
	

	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan Aplikasi SIMON pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Aplikasi SIMON dapat diakses menggunakan user ID dan password webmail</li>
				<li>Role/akses aplikasi akan sesuai dengan posisi jabatannya, Admin diharapkan melakukan update posisi untuk user yang mendapatkan kewenangan aplikasi SIMON</li>
				<li>Untuk user yang sudah melakukan reset target / reset webmail namun belum bisa login silahkan dipermanenkan ulang ke posisi definitifnya saat ini</li>
				<li>Login User Internal BNI menggunakan NPP (5 digit) dan password Webmail / eoffice </li>

				<br>
				<li>List Posisi yang mendapatkan kewenangan SIMON:</li>
				
				<br><ul style="border: 1px solid black;background: #f0f0f0;"><br>

					<h5><b>CABANG</b></h5>
					<ul>
						<li>Pemimpin Cabang</li>
						<li>Penyelia Pemasaran</li>
						<li>Analis Pemasaran Bisnis Usaha Kecil</li>
					</ul>
					
					<br>

					
					<h5><b>WILAYAH</b></h5>
					<ul >
						<li>Pemimpin Kantor Wilayah</li>
						<li>Wakil Pemimpin Wilayah Bisnis Komersial</li>
						<li>Wakil Pemimpin Wilayah Bisnis SME dan Konsumer</li>


					</ul>
					
					<br>
					
					<h5><b> SBE & SBK </b></h5>
					<ul style="column-count: 2;">
						
						<li>Pemimpin Sentra Bisnis Komersial (SBK)</li>
						<li>Pemimpin Kelompok Pemasaran Bisnis Komersial</li>
						<li>MGR Senior RM Komersial</li>
						<li>AMGR RM Komersial</li>

						<li>Pemimpin Sentra Bisnis SME (SBE)</li>
						<li>Wakil Pemimpin Sentra Bisnis SME (SBE)</li>
						<li>AMGR Pemasaran Bisnis SME (SRM)</li>
						<li>Penyelia Pemasaran Bisnis SME (Penyelia RM)</li>

					</ul>
					
					<br>
					
					<h5><b>INT</b></h5>
					<ul style="column-count: 2;">
						<li>Pemimpin Divisi International</li>
						<li>Pemimpin Kelompok Pemasaran Lembaga Keuangan Bank (PLK)</li>
						<li>MGR Pemasaran Lembaga Keuangan</li>
						<li>AMGR Pemasaran Lembaga Keuangan</li>
						<li>Pemimpin Kelompok Pemasaran Lembangan Keuangan Non Bank (PNB)</li>
						<li>MGR Pemasaran Lembaga Keuangan Non Bank</li>
						<li>AMGR Pemasaran Lembaga Keuangan Non Bank</li>
					</ul>
					
					<br>
					
					<h5><b>INB 1</b></h5>
					<ul>
						<li>Pemimpin Divisi Hubungan Kelembagaan 1</li>
						<li>Pemimpin Kelompok Pemasaran Bisnis Kelembagaan 1</li>
						<li>Mgr Pemasaran Bisnis Kelembagaan 1</li>
						<li>Analis Pemasaran Bisnis Kelembagaan 1</li>
					</ul>
					
					<br>
					
					<h5><b>INB 2</b></h5>
					<ul>
						<li>Pemimpin Divisi Institutional Banking 2</li>
						<li>Pemimpin Kelompok Pemasaran Bisnis Kelembagaan 2</li>
						<li>MGR Pemasaran Bisnis Kelembagaan 2</li>
						<li>Analis Pemasaran Bisnis Kelembagaan 2</li>
					</ul>
					
					<br>
					
					
					<h5><b>CMB</b></h5>
					<ul>
						<li>Pemimpin Divisi Commercial Banking</li>
						<li>Wakil Pemimpin Divisi Bisnis Menengah</li>
						<li>Pemimpin Kelompok Manajemen Bisnis Menengah</li>
						<li>Pengelola Manajemen Bisnis Menengah</li>
						<li>Analis Manajemen Bisnis Menengah</li>
					</ul>
					<br>
					
					<h5><b>SME BANKING</b></h5>
					<ul style="column-count: 2;">
						<li>Pemimpin Divisi SME Banking</li>
						<li>Wakil Pemimpin Divisi I</li>
						<li>Wakil Pemimpin Divisi II</li>
						<li>Pemimpin Kelompok Bisnis Anorganik</li>
						<li>MGR Pemasaran Bisnis Anorganik</li>

						<li>Pemimpin Kelompok Perencanaan & Pengembangan Bisnis</li>
						<li>MGR Pengembangan Program & Bisnis Digital </li>
						<li>AMGR Pengembangan Program & Bisnis Digital </li>
						<li>MGR Perencanaan & Analisa Portofolio</li>
						<li>AMGR Perencanaan & Analisa Portofolio</li>
					</ul>
					<br>
					
					<h5><b>CMR</b></h5>
					<ul style="column-count: 3;">
						<li>Pemimpin Divisi Commercial & SME Credit Risk</li>
						<li>Wakil Pemimpin I (Pengembangan Risiko Kredit)</li>
						<li>Wakil Pemimpin II (Pembina Risiko Kredit Wilayah)</li>
						<li>Wakil Pemimpin III (Pembina Risiko Kredit Wilayah)</li>
						<li>Wakil Pemimpin IV (Pembina Risiko Kredit Wilayah)</li>
						<li>Wakil Pemimpin V (Pembina Risiko Kredit Wilayah)</li>
						<li>AVP Credit Risk Manager</li>
						<li>MGR Credit Risk Manager Anorganik Program </li>

						<li>Pemimpin Risiko Kredit Wilayah</li>
						<li>Credit Risk Manager Menengah</li>
						<li>Pemimpin Risiko Kredit Usaha Kecil (Sentra)</li>
						<li>Pemimpin Risiko Kredit Usaha Kecil (Kantor Cabang)</li>

						<li>Pemimpin Kelompok Manajemen Risiko Kredit</li>
						<li>Pengelola Analisa Risiko Kredit & Pelaporan</li>
						<li>Analis Risiko Kredit & Pelaporan</li>
						<li>Pengelola Penyempurnaan Proses Kredit</li>

						<li>Analis Penyempurnaan Proses Kredit</li>
						<li>Pengelola Pengendalian & Pengkajian Proses Kredit</li>
						<li>Analis Pengendalian & Pengkajian Proses Kredit</li>
						<li>Pemimpin Kelompok Pengembangan Sistem & Otomasi Proses Kredit</li>

						<li>MGR Pengembangan Sistem & Otomasi Proses Kredit</li>
						<li>AMGR Pengembangan Sistem & Otomasi Proses Kredit</li>
						<li>Pengelola Sistem & help Desk Proses Kredit</li>
						<li>Analis Sistem & help Desk Proses Kredit</li>
						<li>Asisten Sistem & help Desk Proses Kredit</li>
					</ul>
					<br>
					
					<h5><b>CRR</b></h5>
					<ul style="column-count: 3;">
						<li>Pemimpin Divisi Corporate & Enterprise Credit Risk</li>
						<li>Senior Credit Officer</li>
						<li>Wakil Pemimpin I</li>
						<li>Wakil Pemimpin II</li>

						<li>Wakil Pemimpin III</li>
						<li>Wakil Pemimpin IV</li>
						<li>AVP Credit Risk Manager</li>
						<li>MGR Credit Risk Manager</li>

						<li>AVP Risiko Kredit Lembaga Keuangan</li>
						<li>MGR Risiko Kredit Lembaga Keuangan</li>
						<li>AMGR Risiko Kredit Lembaga Keuangan</li>
						<li>AVP Pengkajian Risiko Kredit</li>

						<li>MGR Pengkajian Risiko Kredit </li>
						<li>AMGR Pengkajian Risiko Kredit</li>
					</ul>
					<br>
					
					<h5><b>ORM</b></h5>
					<ul style="column-count: 2;">
						<li>Pemimpin Divisi Enterprise Risk Management</li>
						<li>Wakil Pemimpin Bidang Risiko Pasar & Risiko Kredit</li>
						<li>Pemimpin Kelompok Pemodelan Peringkat Nasabah & Industri</li>
						<li>Pengelola Pemodelan Peringkat Nasabah & Industri</li>

						<li>Analis Pemodelan Peringkat Nasabah & Industri</li>
						<li>MGR Validasi Model</li>
						<li>AMGR Validasi Model</li>
					</ul>
					<br>
					
					<h5><b>COB 1</b></h5>
					<ul style="column-count: 2;">
						<li>Pemimpin Divisi Corporate Banking 1</li>
						<li>Wakil Pemimpin Divisi Corporate Banking 1</li>
						<li>Pemimpin Kelompok Relationship Manager</li>

						<li>Senior Relationship Manager</li>
						<li>Relationship Manager</li>
						<li>Analis & Data Pelaporan</li>
					</ul>
					<br>
					
					<h5><b>COB 2</b></h5>
					<ul style="column-count: 2;">
						<li>Pemimpin Divisi Corporate Banking 2</li>
						<li>Wakil Pemimpin Divisi I</li>
						<li>Wakil Pemimpin Divisi II</li>
						<li>Wakil Pemimpin Divisi III</li>
						<li>AMGR Reporting & Data</li>

						
						<li>Customer Senior Relationship Manager CRA 1 - 9</li>
						<li>Customer Relationship Manager CRA 1 - 9</li>
						<li>Customer Relationship AVP CRA 1 - 9</li>						
					</ul>
					<br>
					
					<h5><b>COB 3</b></h5>
					<ul>
						<li>Pemimpin Divisi Corporate Banking 3</li>
						<li>Wakil Pemimpin Divisi</li>

						
						<li>Pemimpin kelompok Relationship Manager Korporasi</li>
						<li>MGR Senior Relationship Manager</li>
						<li>MGR Relationship Manager</li>						
					</ul>
					<br>
					
					<h5><b>ERM</b></h5>
					<ul style="column-count: 2;">
						<li>Pemimpin Divisi Enterprise Risk Management</li>
						<li>Wakil Pemimpin Bidang Risiko Pasar & Risiko Kredit</li>
						<li>Pemimpin Kelompok Pemodelan Peringkat Nasabah & Industri</li>
						<li>Pengelola Pemodelan Peringkat Nasabah & Industri</li>
						<li>Analis Pemodelan Peringkat Nasabah & Industri</li>

						<li>MGR Validasi Model</li>
						<li>AMGR Validasi Model</li>				
					</ul>
					<br>
					
				
				</ul>
		</ul>
			
			
		</div>
	</div>


		<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan Aplikasi BNI FOR SLIK pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				<li><b>URL Login User BNI:</b> <a href="http://report.bni.co.id/SLIK_LDAP/Account/Login"> BNI FOR SLIK </a>dan hanya bisa diakses melalui <b>intranet</b> </li>
				<li>Aplikasi BNI FOR SLIK dapat diakses menggunakan user ID dan password <b>webmail</b></li>
				<li>Login Aplikasi BNI FOR SLIK menggunakan <b>UserID dan password Webmail / eoffice </b></li>
				<li><b>Role/akses aplikasi akan sesuai dengan posisi jabatannya,</b> Admin diharapkan melakukan update posisi untuk user yang mendapatkan kewenangan aplikasi BNI FOR SLIK</li>
				<br>
				<li>List Posisi yang mendapatkan kewenangan BNI FOR SLIK</li>
					<br><ul style="border: 1px solid black;background: #f0f0f0;"><br>
								<h5><b>Wilayah</b></h5>
								<ul style="column-count: 3;">
									<li>Pemimpin Kantor Wilayah</li>
									<li>Wakil Pemimpin Wilayah Bisnis Komersial</li>
									<li>Wakil Pemimpin Wilayah Bisnis SME dan Konsumer</li>
									<li>Wakil Pemimpin Wilayah Operasional</li>
									<li>Pemimpin Remedial & Recovery Wilayah</li>
									<li>Pemimpin Sentra Bisnis Komersial (SBK)</li>
									<li>Pemimpin Kelompok Pemasaran Bisnis Komersial</li>
									<li>MGR Senior RM Komersial</li>
									<li>AMGR RM Komersial</li>
									<li>Pengelola Cash Management & Trade</li>
									<li>Analis Advisori Bisnis Cash Management</li>
									<li>Analis Advisori Bisnis Trade</li>
									<li>Analis Implementasi Solusi Jasa Transaksional</li>
									<li>Asisten Cash Management & Trade</li>
									<li>Pemimpin Sentra Bisnis SME (SBE)</li>
									<li>Wakil Pemimpin Sentra Bisnis SME (SBE)</li>
									<li>AMGR Pemasaran Bisnis SME (SRM)</li>
									<li>Penyelia Pemasaran Bisnis SME (Penyelia RM)</li>
									<li>Analis Pemasaran Bisnis SME (RM)</li>
									<li>Penyelia Analis Kredit Standar</li>
									<li>Analis Kredit Standar</li>
									<li>Asisten Kredit Standar</li>
									<li>Pemimpin Unit Bisnis SME (UBE)</li>
									<li>Analis Pemasaran Bisnis SME (RM)</li>
									<li>Analis Kredit Standar</li>
									<li>Asisten Kredit Standar</li>
									<li>Pemimpin Operasional Kredit Wilayah</li>
									<li>Pengelola Operasional Kredit Komersial</li>
									<li>Analis Operasional Kredit Komersial</li>
									<li>Asisten Operasional Kredit Komersial</li>
									<li>Penyelia Administrasi Kredit SME</li>
									<li>Asisten Administrasi Kredit SME</li>
									<li>Pengelola Pemantauan Operasional Kredit</li>
									<li>Analis Pemantauan Operasional Kredit</li>
									<li>Pemimpin Kelompok Remedial & Recovery Wilayah</li>
									<li>Pengelola Remedial & Recovery Komersial</li>
									<li>Analis Remedial & Recovery Komersial</li>
									<li>Asisten Administrasi</li>
									<li>Pengelola Remedial & Recovery SME</li>
									<li>Analis Remedial & Recovery SME</li>
									<li>Asisten Remedial & Recovery SME</li>
									<li>Pengelola Penagihan Konsumer</li>
									<li>Pemimpin Kelompok Kontrol Internal Wilayah</li>
									<li>MGR Kontrol Internal Wilayah</li>
									<li>AMGR Kontrol Internal Wilayah</li>

								</ul>
								<br><br><h5><b>Cabang</b></h5>
								<ul style="column-count: 3;">
									<li>Pemimpin Cabang (PC)</li>
									<li>Pemimpin Bidang Pemasaran Bisnis (PBP)</li>
									<li>Pemimpin Bidang Pembinaan Pelayanan (PBN)</li>
									<li>Pemimpin Bidang Operasional (PBO)</li>
									<li>Penyelia PNC</li>
									<li>Senior Frontliner - Fungsi PNC</li>
									<li>Asisten Pelayanan Nasabah -2</li>
									<li>Asisten Pelayanan Nasabah</li>
									<li>Penyelia Administrasi Kredit</li>
									<li>Asisten Adm Kredit</li>
									<li>Penyelia Adm DN & Kliring</li>
									<li>Asisten Adm DN & Kliring</li>
									<li>Penyelia Risiko Bisnis Konsumer</li>
									<li>Analis Kredit Konsumer</li>
									<li>Asisten Kredit Konsumer</li>

								</ul>
								<br><br><h5><b>AFR</b></h5>
								<ul style="column-count: 3;">
									<li>Asisten Deteksi Fraud - Transaksi 1 (Credit Card & Merchant)</li>
									<li>Asisten Tim Deteksi Fraud - Transaksi 2 (Debit Card & Prepaid)</li>
									<li>Asisten Deteksi Fraud - Transaksi 3 (E-Banking & WHS)</li>
									<li>Asisten Deteksi Fraud - Non Transaksi 2 (KYE)</li>
									<li>Asisten Deteksi Fraud - Non Transaksi 3 (SGV, RNCH & Merchant Review) - FTE</li>
									<li>Asisten Tim Investigasi Fraud - Transaksi 2 (Debit Card & Prepaid)</li>
									<li>Asisten Investigasi Fraud - transaksi 3 (E-banking & Agen 46) (FTE)</li>
									<li>Asisten Investigasi Fraud - Transaksi 4 (WHS)</li>
									<li>Asisten Investigasi Fraud - Non transaksi 5 (WBS & KYE)</li>
									<li>Asisten Investigasi Fraud - Non Transaksi 6 (SGV)</li>
									<li>Asisten Koordinator SAF Regional & Supporting - Non Transaksi 7 (Supporting)</li>
									<li>Asisten Analisa Fraud - Transaksi (Kredit & Merchant)</li>
									<li>Asisten Analisa Fraud - Transaksi (Debit, Prepaid & Whs)</li>
									<li>Asisten Analisa Fraud - Transaksi (E-Banking & Agen 46)</li>
									<li>Asisten Analisa Fraud - Non Transaksi (WBS & Operasional)</li>
									<li>Asisten Analisa Fraud - Non Transaksi (SGV & Operasional)</li>
									<li>Asisten Analisa Fraud - Non Transaksi (Sistem Anti Fraud & Operasional)</li>
									<li>Analis Sistem & Pelaporan</li>
									<li>Penyelia Administrasi Kredit & Pelaporan</li>

								</ul>
								<br><br><h5><b>CDV</b></h5>
								<ul style="column-count: 3;">
									<li>Co Project Manager</li>
									<li>Sub Program/Proyek Manager</li>

								</ul>
								<br><br><h5><b>CMR</b></h5>
								<ul style="column-count: 3;">
									<li>MGR Pengembangan Sistem & Otomasi Proses Kredit</li>
									<li>AMGR Pengembangan Sistem & Otomasi Proses Kredit</li>
									<li>Pengelola Sistem & Help Desk Proses Kredit</li>
									<li>Analis Sistem & Help Desk Proses Kredit</li>

								</ul>
								<br><br><h5><b>COB2</b></h5>
								<ul style="column-count: 3;">
									<li>Customer Senior Relationship Manager</li>
									<li>Customer Relationship Manager</li>
									<li>Customer Relationship AVP</li>
									<li>Customer Senior Relationship Manager</li>

								</ul>
								<br><br><h5><b>COP</b></h5>
								<ul style="column-count: 3;">
									<li>Wakil Pemimpin</li>
									<li>Pengelola Monitoring & Supervisi Operasional Kredit</li>
									<li>Analis Monitoring & Supervisi Operasional Kredit</li>
									<li>Pengelola Sistem Informasi & Database Operasional Kredit</li>
									<li>Analis Sistem Informasi & Database Operasional Kredit</li>
									<li>Pengelola Service Provider</li>
									<li>Asisten Administrasi Compliance & Legal Admin Kantor Pusat 1 - 3</li>
									<li>Asisten Operasional Compliance & Legal Admin Kantor Pusat 2 & 3</li>
									<li>Pempimpin Kelompok Pengembangan Operasional Kredit</li>
									<li>MGR Pengembangan Operasional Kredit</li>
									<li>Asisten Administrasi Pengembangan Operasional Kredit</li>

								</ul>
								<br><br><h5><b>CPM</b></h5>
								<ul style="column-count: 3;">
									<li>Pengelola SAN</li>
									<li>Analis SAN</li>

								</ul>
								<br><br><h5><b>CRR</b></h5>
								<ul style="column-count: 3;">
									<li>Data & Reporting MGR</li>
									<li>Data & Reporting AMGR</li>

								</ul>
								<br><br><h5><b>DMA</b></h5>
								<ul style="column-count: 3;">
									<li>Penyelia Peningkatan Kualitas Data</li>
									<li>Pemimpin Kelompok Report Delivery</li>
									<li>Pengelola Pengembangan Report Delivery</li>
									<li>Analis Pengembangan Report Delivery</li>
									<li>Pengelola Laporan SLIK</li>
									<li>Analis Laporan SLIK</li>
									<li>Pengelola Data & Informasi Debitur</li>
									<li>Analis Data & Informasi Debitur</li>

								</ul>
								<br><br><h5><b>IAD</b></h5>
								<ul style="column-count: 3;">
									<li>Auditor Madya Kelompok Audit Bisnis Konsumer</li>
									<li>Auditor Kelompok Audit Bisnis Konsumer</li>
									<li>Auditor Muda Kelompok Audit Bisnis Konsumer</li>
									<li>Auditor Madya Kelompok Audit Strategi Teknologi Informasi</li>
									<li>Auditor Kelompok Audit Strategi Teknologi Informasi</li>
									<li>Auditor Madya Kelompok Audit Operasional Teknologi Informasi</li>
									<li>Auditor Kelompok Audit Operasional Teknologi Informasi</li>
									<li>Mgr Kelompok Penunjang Audit & Hubungan Eksternal</li>
									<li>Amgr Kelompok Penunjang Audit & Hubungan Eksternal</li>
									<li>Asisten Kelompok Penunjang Audit & Hubungan Eksternal</li>
									<li>Auditor Madya Kelompok Audit Bisnis Banking</li>
									<li>Auditor Kelompok Audit Bisnis Banking</li>
									<li>Auditor Madya Kelompok Audit Bisnis Internasional, Tresuri Dan Perusahaan Anak</li>
									<li>Auditor Kelompok Audit Bisnis Internasional, Tresuri Dan Perusahaan Anak</li>
									<li>Auditor Madya Kelompok Audit Fungsional</li>
									<li>Auditor Kelompok Audit Fungsional</li>
									<li>Auditor Madya Audit Area</li>
									<li>Auditor Audit Area</li>

								</ul>
								<br><br><h5><b>INB 1</b></h5>
								<ul style="column-count: 3;">
									<li>MGR Pemasaran Bisnis Kelembagaan 1 (PLS 1 - 6)</li>
									<li>MGR Pemasaran Bisnis Kelembagaan 1 (SVP 2)</li>

								</ul>
								<br><br><h5><b>INB 2</b></h5>
								<ul style="column-count: 3;">
									<li>MGR Pemasaran Bisnis Kelembagaan 2 (PLD 1 - 6)</li>
									<li>MGR Pemasaran Bisnis Kelembagaan 2 (LENDING)</li>

								</ul>
								<br><br><h5><b>INT</b></h5>
								<ul style="column-count: 3;">
									<li>AMGR Pemasaran Lembaga Keuangan</li>
									<li>Pemimpin Kelompok Liaison Bisnis Internasional</li>
									<li>MGR Pemasaran Lembaga Keuangan Non Bank</li>
								</ul>
								<br><br><h5><b>RPB</b></h5>
								<ul style="column-count: 3;">
									<li>Pemimpin Kelompok Bisnis Anorganik</li>
									<li>MGR Pemasaran Bisnis Anorganik</li>
									<li>AMGR Pengelolaan SCF & Kerjasama Bisnis</li>

								</ul>
								<br><br><h5><b>RTC</b></h5>
								<ul style="column-count: 3;">
									<li>Pengelola Kebijakan Penagihan</li>
									<li>Analis Kebijakan Penagihan</li>
									<li>Pemimpin Kelompok</li>
									<li>Pengelola Manajemen Sistem Analisa</li>
									<li>Analis Manajemen Sistem Analisa</li>
									<li>Analis Manajemen Sistem Penagihan</li>
									<li>Analis Help Desk & Manajemen User</li>
									<li>Asisten Help Desk & Manajemen User</li>
									<li>Pengelola Pinjaman Tanpa Agunan</li>
									<li>Pengelola Pinjaman Dengan Agunan</li>
									<li>Pengelola Pemantauan Penagihan dan Website Lelang</li>
									<li>Penyelia Pemeliharaan Akun</li>
									<li>Analis Pemeliharaan Akun</li>

								</ul>
								<br><br><h5><b>SBP</b></h5>
								<ul style="column-count: 3;">
									<li>Pemimpin Kelompok Pengembangan Kredit Program</li>
									<li>MGR Pengembangan Kredit Program</li>
									<li>MGR Program Pemerintah</li>
									<li>Pemimpin Kelompok Manajemen Bisnis</li>
									<li>MGR Manajemen Bisnis</li>

								</ul>
								<br><br><h5><b>WPP</b></h5>
								<ul style="column-count: 3;">
									<li>MGR Solusi Transaksi Pembiayaan</li>
									<li>AMGR Solusi Transaksi Pembiayaan</li>

								</ul>





								<br>
								
								
							</ul>
			
			
		</div>
	</div>
	
		<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan Aplikasi DPLK Sure pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				<li><b>URL Login User BNI:</b> <a href="https://dplksure.bni.co.id/Account/Login"> https://dplksure.bni.co.id/Account/Login </a>dan hanya bisa diakses melalui <b>intranet</b> </li>
				<li>Aplikasi DPLK Sure dapat diakses menggunakan user ID dan password <b>webmail</b></li>
				<li>Login Aplikasi DPLK Sure menggunakan <b>UserID dan password Webmail / eoffice </b></li>
				<li><b>Role/akses aplikasi akan sesuai dengan posisi jabatannya,</b> Admin diharapkan melakukan update posisi untuk user yang mendapatkan kewenangan aplikasi DPLK Sure</li>
				<li><b> Untuk user Bina B81XXXX </b> silahkan ajukan request user DPLK SURE melalui <b>ITSD / remedy  </b></li>
				<br>
				<li>List Posisi yang mendapatkan kewenangan DPLK SURE:</li>
					<br><ul style="border: 1px solid black;background: #f0f0f0;"><br>
								<h5><b>Cabang</b></h5>
								<ul style="column-count: 2;">
									<li>Pemimpin Cabang (PC)</li>
									<li>Pemimpin Bidang Pembinaan Pelayanan (PBN)</li>
									<li>Pemimpin Kantor Cabang Pembantu</li>
									<li>Pemimpin Kantor Kas</li>
									<li>Penyelia PUC</li>
									<li>Senior Frontliner - Fungsi PUC</li>
									<li>Asisten PUC</li>
									<li>Penyelia PNC</li>
									<li>Senior Frontliner - Fungsi PNC</li>
									<li>Asisten Pelayanan Nasabah</li>
									<li>Penyelia LPC</li>
									<li>Asisten LPC</li>
								</ul>
								<br><br><h5><b>BINA BNI PUC (Teller)</b></h5>
								<ul style="column-count: 1;">
									<li>Teller - Pradana 2</li> 
									<li>Teller - Utama</li>
									<li>Teller - Madya</li>
								</ul>
								
								<br><br><h5><b>PSF</b></h5>
								<ul style="column-count: 2;">
									<li>Pemimpin Divisi Pension Fund</li>		
									<li>Pemimpin Kelompok Pengembangan Bisnis</li>
									<li>Pengelola Pengembangan Product & Jaringan</li>
									<li>Analisa Pengembangan Product & Jaringan</li>
									<li>Asisten Administrasi (OS)</li>
									<li>MGR Pemasaran</li>
									<li>AMGR Pemasaran</li>
									<li>Pemimpin Kelompok Investasi</li>
									<li>Pengelola Investasi</li>
									<li>Analis Investasi</li>
									<li>Asisten Operasional</li>
									<li>Pemimpin Kelompok Penunjang Operasional</li>
									<li>Pengelola Prosedur</li>
									<li>Analis Prosedur</li>
									<li>Pengelola Klaim</li>
									<li>Analis Klaim </li>
									<li>Asisten Operasional </li>
									<li>Asisten Administrasi (OS) </li>
									<li>Pengelola Akuntansi & Perencanaan I</li>
									<li>Pengelola Akuntansi & Perencanaan II</li>
									<li>Analis Akuntansi & Perencanaan </li>
									<li>Analis Pengembangan Sistem</li>
									<li>Asisten Operasional Akuntansi & Perencanaan (FTE)</li>
									<li>Asisten Operasional Akuntansi (O/S)</li>
									<li>Pemimpin Bagian Settlement</li>
									<li>Penyelia Settlement</li>
									<li>Asisten Operasional Settlement (FTE)</li>
									<li>Asisten Operasional Settlement (O/S)</li>
									<li>Pemimpin Kelompok Manajemen Risiko & Kepatuhan</li>
									<li>Pengelola Manajemen Risiko & Kepatuhan</li>
									<li>Analis Manajemen Risiko & Kepatuhan</li>
									<li>Analis APU PPT</li>
									<li>Asisten Operasional</li>
								</ul>
								
								<br><br><h5><b>IAD</b></h5>
								<ul style="column-count: 2;">
									<li>Auditor Madya Audit Bisnis Internasional, Tresuri & Perusahaan Anak</li>
								</ul>
								<br>
								
								
							</ul>
			
			
		</div>
	</div>

	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan Aplikasi MONI MANAGER pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Aplikasi MONI MANAGER dapat diakses menggunakan user ID dan password webmail</li>
				<li>Role/akses aplikasi akan sesuai dengan posisi jabatannya, Admin diharapkan melakukan update posisi untuk user yang mendapatkan kewenangan aplikasi MONI MANAGER</li>
				<li>Untuk user yang sudah melakukan reset target / reset webmail namun belum bisa login silahkan dipermanenkan ulang ke posisi definitifnya saat ini</li>
				<li>Login User Internal BNI menggunakan NPP (5 digit) dan password Webmail / eoffice </li>
				<li>List Posisi yang mendapatkan kewenangan MONI MANAGER:</li>
			<br><ul style="border: 1px solid black;background: #f0f0f0;"><br>
			<h5><b>Cabang</b></h5>
			<ul style="column-count: 2;">
				<li>Pemimpin Bidang Pembinaan Pelayanan (PBN)</li>
				<li>Penyelia PUC</li>
				<li>Asisten PUC</li>
				<li>Penyelia Logistik & Manajemen Modal Manusia</li>
			</ul>
			
			<br><br><h5><b>Wilayah</b></h5>
			<ul style="column-count: 2;">
				<li>Pemimpin Kantor Wilayah</li>
				<li>Pengelola Manajemen ATM dan EDC</li>
				<li>Analis Manajemen ATM</li>
				<li>Penyelia Operasional</li>
				<li>Asst. Restocking ( Fungsi Pengisian & Pemeliharaan)</li>
				<li>Asst. Administrasi dan Pemantauan</li>				
			</ul>
			
			<br><br><h5><b>RTL</b></h5>
			<ul style="column-count: 2;">
				<li>Pemimpin Divisi</li>
				<li>Wakil Pemimpin Divisi I</li>
				<li>Pemimpin Kelompok Pengembangan Delivery Channel</li>
				<li>MGR Pengembangan Delivery Channel</li>
			</ul>
			
			<br><br><h5><b>DGO</b></h5><br>
			<ul style="column-count: 2;">
				<li>Pemimpin Divisi</li>
				<li>Wakil Pemimpin Divisi</li>
				<li>MGR Manajemen Jaringan Elektronik</li>
				<li>Pemimpin Kelompok Pemantauan Jaringan Elektronik</li>
				<li>Pengelola Pemantauan Operasional & Pelaporan ATM</li>
				<li>Penyelia Pemantauan Operasional & Pelaporan ATM</li>
				<li>Asisten Pemantauan Operasional & Pelaporan ATM</li>
				<li>Pemimpin Kelompok Implementasi Jaringan Elektronik</li>
				<li>Pengelola Distribusi & Pemeliharaan ATM</li>
				<li>Analis Distribusi & Pemeliharaan ATM</li>
				<li>Pemimpin Kelompok Rekonsiliasi II B</li>
				<li>Pengelola Rekonsiliasi Kas ATM</li>
				<li>Penyelia Rekonsiliasi Kas ATM</li>
				<li>Asisten Rekonsiliasi Kas ATM</li>
			</ul>

			<br>
			
			
		</ul></ul>
		
		</div>
	</div>

	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan Aplikasi IBS / BIOMETRIC pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Aplikasi IBS / BIOMETRIC dapat diakses menggunakan user ID dan password webmail</li>
				<li>Role/akses aplikasi akan sesuai dengan posisi jabatannya, Admin diharapkan melakukan update posisi untuk user yang mendapatkan kewenangan aplikasi IBS / BIOMETRIC</li>
				<li>Untuk user yang sudah melakukan reset target / reset webmail namun belum bisa login silahkan dipermanenkan ulang ke posisi definitifnya saat ini</li>
				<li>Login User Internal BNI menggunakan NPP (5 digit) dan password Webmail / eoffice </li>
				<li>List Posisi yang mendapatkan kewenangan IBS / BIOMETRIC:</li>
			<br><ul style="border: 1px solid black;background: #f0f0f0;"><br>
			<h5><b>Cabang</b></h5>
			<ul style="column-count: 2;">
				<li>Pemimpin Cabang (PC)</li>
				<li>Pemimpin Bidang Pemasaran Bisnis (PBP)</li>
				<li>Pemimpin Bidang Pembinaan Pelayanan (PBN)</li>
				<li>Pemimpin Bidang Operasional (PBO)</li>
				<li>Pemimpin Kantor Cabang Pembantu</li>
				<li>Pemimpin Kantor Kas</li>
				<li>Penyelia PUC</li>
				<li>Senior Frontliner - Fungsi PUC</li>
				<li>Asisten PUC</li>
				<li>Penyelia PNC</li>
				<li>Senior Frontliner - Fungsi PNC</li>
				<li>Asisten PNC</li>
				<li>Penyelia Layanan Prima / Emerald</li>
				<li>Asisten Layanan Prima / Emerald</li>
				<li>Penyelia Administrasi Kredit</li>
				<li>Asisten Administrasi Kredit</li>
				<li>MGR Kontrol Internal Sentra/Cabang</li>
				<li>AMGR Kontrol Internal Sentra/Cabang</li>
			</ul>
			
			<br><br><h5><b>BINA BNI PUC BINA BNI (Teller)</b></h5>
			<ul style="column-count: 1;">
				<li>Teller - Pradana 1</li>
				<li>Teller - Pradana 2</li>
			</ul>
			
			<br><br><h5><b>PNC BINA BNI (Customer Service)</b></h5>
			<ul style="column-count: 1;">
				<li>CS - Pradana 1</li>
				<li>CS - Madya / Utama</li>
				<li>CS - Madya (ex. Teler Bina BNI)</li>
				<li>CS - Utama (ex. Teler Bina BNI)</li>
			</ul>
			
			<br><br><h5><b>Wilayah</b></h5>
			<ul style="column-count: 2;">
				<li>Pemimpin Operasional Kredit Wilayah</li>
				<li>Pengelola Operasional Kredit Komersial</li>
				<li>Analis Operasional Kredit Komersial</li>
				<li>Asisten Operasional Kredit Komersial</li>
				<li>Penyelia Administrasi Kredit SME</li>
				<li>Asisten Administrasi Kredit SME</li>
				
				
				
			</ul>
			
			<br><br><h5><b>JAL</b></h5>
			<ul style="column-count: 2;">
				<li>Pemimpin Kelompok Kelompok Penelitian & Pengembangan</li>
				<li>MGR Penelitian dan Pengembangan</li>
				<li>AMGR Penelitian dan Pengembangan</li>
				<li>Pemimpin Operasional Jaringan</li>
				<li>Pengelola Operasional Jaringan</li>
				<li>Analis Operasional Jaringan</li>
			</ul>
			
			<br><br><h5><b>SKK Kelas 1 & Kelas 2</b></h5><br>
			<ul style="column-count: 2;">
				<li>Pengelola Layanan Pinjaman</li>
				<li>Penyelia Penandatanganan Pinjaman</li>
				<li>Asisten Penandatanganan Pinjaman</li>
				<li>Asisten Penandatanganan Pinjaman (Os)</li>
				<li>Bina Bni Asisten Penandatanganan Pinjaman</li>			
			</ul>

			<br>
			
			
		</ul></ul>
		
		</div>
	</div>
	
		<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan Aplikasi DigIMS pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				<li class="pad-btm">Aplikasi DigIMS dapat diakses menggunakan <b>user ID dan password webmail</b></li>
				<li class="pad-btm"><b>Role/akses aplikasi akan sesuai dengan posisi jabatannya,</b> Admin diharapkan melakukan update posisi untuk user yang mendapatkan kewenangan aplikasi DigIMS</li>
				<li class="pad-btm">Untuk user yang sudah melakukan reset target / reset webmail namun belum bisa login <b>silahkan dipermanenkan ulang ke posisi definitifnya saat ini</b></li>

				<li>List Posisi yang mendapatkan kewenangan DigIMS:</li>
			<br><ul style="border: 1px solid black;background: #f0f0f0;"><br><br>

			<h5><b>Cabang</b></h5>
			<ul style="column-count: 1;">
				<li>CAB-0-PEMIMPIN BIDANG PEMBINAAN PELAYANAN(PBN)</li>
				<li>PEMIMPIN BIDANG OPERASIONAL (PBO)</li>
				<li>PEMIMPIN KANTOR CABANG PEMBANTU</li>
				<li>PEMIMPIN KANTOR KAS</li>
				<li>PENYELIA PELAYANAN NASABAH</li>
				<li>ASISTEN PELAYANAN NASABAH</li>
				<li>PENYELIA LOGISTIK & MANAJEMEN MODAL MANUSIA</li>
				<li>ASISTEN ADMINISTRASI LOGISTIK</li>
			</ul>
			<br><br><h5><b>Wilayah</b></h5>
			<ul style="column-count: 1;">
				<li>PEMIMPIN KANTOR WILAYAH</li>
				<li>WAKIL PEMIMPIN WILAYAH OPERASIONAL</li>
				<li>PEMIMPIN KELOMPOK PENUNJANG BISNIS</li>
				<li>PENGELOLA LOGISTIK & PROPERTI</li>
				<li>ANALIS LOGISTIK & PROPERTI</li>
				<li>PEMIMPIN BAGIAN UMUM</li>
				<li>ASISTEN ADMINISTRASI UMUM</li>
			</ul>
			<br><br><H5><B>JAL</B></H5>
			<ul style="column-count: 1;">
			
				<li>PEMIMPIN OPERASIONAL JARINGAN</li>
				<li>PENGELOLA OPERASIONAL JARINGAN</li>
				<li>ANALIS OPERASIONAL JARINGAN</li>

			</ul>
			
			<br><br><H5><B>OPR</B></H5>
			<ul style="column-count: 3;">
				<li>PEMIMPIN KELOMPOK PENUNJANG</li>
				<li>PENGELOLA DISTRIBUSI & PRODUKSI KARTU</li>
				<li>PENYELIA DISTRIBUSI & PRODUKSI KARTU 1</li>
				<li>PENYELIA DISTRIBUSI & PRODUKSI KARTU 2</li>
				<li>ANALIS PIN MAILER</li>
				<li>ASISTEN OPERASIONAL DISTRIBUSI & PRODUKSI KARTU 1</li>
				<li>ASISTEN OPERASIONAL DISTRIBUSI & PRODUKSI KARTU 2</li>
			</ul>
			<br><br><H5><B>PDM</B></H5>
			<ul style="column-count: 1;">
				<li>PEMIMPIN KELOMPOK PENGEMBANGAN BISNIS KARTU DEBIT</li>
				<li>MGR KELOMPOK PENGEMBANGAN BISNIS KARTU DEBIT</li>
				<li>AMGR KELOMPOK PENGEMBANGAN BISNIS KARTU DEBIT</li>
				<li>ASISTEN ADMINISTRASI KELOMPOK PENGEMBANGAN BISNIS KARTU DEBIT</li>

			</ul>
			<br><br><H5><B>WHS</B></H5>
			<ul style="column-count: 3;">
				<li>PEMIMPIN KELOMPOK PENGEMBANGAN SOLUSI INDUSTRI</li>
				<li>MGR PENGEMBANGAN SOLUSI INDUSTRI</li>
				<li>AMGR PENGEMBANGAN SOLUSI INDUSTRI</li>
				<li>PEMIMPIN KELOMPOK IMPLEMENTASI SOLUSI BISNIS</li>
				<li>MGR IMPLEMENTASI SOLUSI NASABAH KORPORASI</li>
				<li>AMGR IMPLEMENTASI SOLUSI NASABAH KORPORASI</li>
				<li>PENGELOLA IMPLEMENTASI SOLUSI NASABAH KOMERSIAL</li>
				<li>ANALIS IMPLEMENTASI SOLUSI NASABAH KOMERSIAL</li>
				<li>PEMIMPIN KELOMPOK MANAJEMEN HUBUNGAN NASABAH</li>
				<li>PENGELOLA MANAJEMEN LAYANAN NASABAH</li>
				<li>ANALIS MANAJEMEN LAYANAN NASABAH</li>
				<li>ASISTEN CALL CENTER (OS/BINA)</li>
				<li>MGR MANAJEMEN PENGALAMAN NASABAH</li>
				<li>AMGR MANAJEMEN PENGALAMAN NASABAH</li>
			</ul>	
			<br><br>
		</ul></ul>
		
		</div>
	</div>

	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan Aplikasi WIC pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Aplikasi WIC dapat diakses menggunakan user ID dan password webmail</li>
				<li>Role/akses aplikasi akan sesuai dengan posisi jabatannya, Admin diharapkan melakukan update posisi untuk user yang mendapatkan kewenangan aplikasi WIC</li>
				<li>Untuk user yang sudah melakukan reset target / reset webmail namun belum bisa login silahkan dipermanenkan ulang ke posisi definitifnya saat ini</li>
				<li>Login User Internal BNI menggunakan NPP (5 digit) dan password Webmail / eoffice </li>
				<li>List Posisi yang mendapatkan kewenangan WIC:</li>
			<br><ul style="border: 1px solid black;background: #f0f0f0;"><br>
			<h5><b>Cabang</b></h5>
			<ul style="column-count: 2;">
				<li>Pemimpin Cabang (PC)</li>
				<li>Pemimpin Bidang Pembinaan Pelayanan (PBN)</li>
				<li>Pemimpin Kantor Cabang Pembantu</li>
				<li>Pemimpin Kantor Kas</li>
				<li>Penyelia PUC</li>
				<li>Senior Frontliner - Fungsi PUC</li>
				<li>Asisten PUC</li>
			</ul>
			
			<br><br><h5><b>BINA BNI</b></h5>
			<ul style="column-count: 1;">
				<li>Teller - Pradana 1</li>
				<li>Teller - Pradana 2</li>
				<li>Madya/Utama </li>
			</ul>
			
			<br><br><h5><b>KPN</b></h5>
			<ul style="column-count: 2;">
				<li>Pengelola Kepatuhan Wilayah Kelompok Kepatuhan Bisnis dan Operasional Bank 1</li>
				<li>Analis Kepatuhan Wilayah Kelompok Kepatuhan Bisnis dan Operasional Bank 1</li>					
				<li>Pengelola Kepatuhan Wilayah Kelompok Kepatuhan Bisnis dan Operasional Bank 2</li>
				<li>Analis Kepatuhan Wilayah Kelompok Kepatuhan Bisnis dan Operasional Bank 2</li>
				<li>Pemimpin Kelompok Analis Transaksi APU-PPT</li>
				<li>Pengelola Analisa Transaksi APU-PPT</li>
				<li>Analis Analisa Transaksi APU-PPT</li>
				<li>Asisten Pelaporan Anti Pencucian Uang</li>
			</ul>
			<br>
		</ul></ul>
		
		</div>
	</div>



	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan Aplikasi Agen46 pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				<li class="pad-btm">Aplikasi Agen46 dapat diakses menggunakan <b>user ID dan password webmail</b></li>
				<li class="pad-btm">Login User Internal BNI menggunakan <b>NPP (5 digit) dan password Webmail / eoffice</b> </li>
				<li class="pad-btm"><b>URL Login User BNI</b>: <b><a href="https://agenbni46.bni.co.id/login/BNI">https://agenbni46.bni.co.id/login/BNI</a></b> dan hanya bisa diakses melalui <b>intranet</b> </li>
				<!--<li class="pad-btm">Untuk <b>URL Agen</b> yang digunakan tetap yaitu <b><a href="https://agenbni46.bni.co.id/login">https://agenbni46.bni.co.id/login</a></b></li>
				<li class="pad-btm"><b>User login dan password untuk Agen masih menggunakan user lama</b></li>-->
				<li class="pad-btm">Untuk menu <b>lupa kata sandi dan reset password</b> untuk pegawai tidak melalui Aplikasi Agen namun diakses melalui <b>menu SSO > reset target > password webmail</b></li>
				<li class="pad-btm"><b>Role/akses aplikasi akan sesuai dengan posisi jabatannya,</b> Admin diharapkan melakukan update posisi untuk user yang mendapatkan kewenangan aplikasi Agen46</li>
				<li class="pad-btm">Untuk user yang sudah melakukan reset target / reset webmail namun belum bisa login <b>silahkan dipermanenkan ulang ke posisi definitifnya saat ini</b></li>
				<br>
				<li class="pad-btm"><b>User TAD/OS Agen46:</b></li>
				<ul  style="border: 1px solid black;background: #f0f0f0;">
				<br>
				<!-- <li class="pad-btm" ><b>Pendaftaran user Agen46 TAD/OS dapat dilakukan dengan cara request permintaan create user SSO terlebih dulu melalui ITSD / Remedy (<a>servicedesk.bni.co.id</a>) dengan melakukan attach surat yang berisi permintaan user dan form mitigasi resiko</b></li>-->
				<li class="pad-btm" ><b>Pendaftaran user Agen46 TAD/OS dapat dilakukan dengan cara request permintaan create user Agen46 terlebih dulu melalui ITSD / Remedy (<a>servicedesk.bni.co.id</a>) dengan melampirkan form mitigasi resiko untuk proses requestnya per masing - masing user yang di request.</b></li>
				<!--<li class="pad-btm" style="padding:5px;"><b>Request pada ITSD / Remedy khusus untuk Non FTE menggunakan menu incident (bukan work order)</b> <a style="color: white;" href="<?php echo base_url('assets/file/Panduan Request incident Create user Agen46 & Mols .pdf'); ?>" class="btn btn-info" role="button" download><i class="fa fa-download" aria-hidden="true"></i> Klik disini</a></li>-->
				<li class="pad-btm"style="padding:5px;"><b>Berikut adalah template mitigasi resiko sebagai lampiran dari surat yang disampaikan melalui ITSD / Remedy</b> <a style="color: white;" href="<?php echo base_url('assets/file/Form Mitigasi User Agent46.doc'); ?>" class="btn btn-info" role="button" download><i class="fa fa-download" aria-hidden="true"></i> Klik disini</a>	</li>
				<li class="pad-btm"style="padding:5px;" ><b>Silahkan  melengkapi form mitigasi per user dengan di ttd Penyelia Pemasaran & Pemimpin.</b></li>
				<li class="pad-btm"style="padding:5px;" ><b>Berikut Panduan Proses Create User TAD/OS Agen46 melalui aplikasi ITSD : </b> <a style="color: white;" href="<?php echo base_url('assets/file/Panduan Request Create Request (Agen46, Mols & SSO).pdf'); ?>" class="btn btn-info" role="button" download><i class="fa fa-download" aria-hidden="true"></i> Klik disini</a>	</li>
				<!--<li class="pad-btm" style="padding:5px;"><b>Setelah user tercreate di SSO, silahkan Admin masing - masing unit mempermanenkan kembali posisi ybs di SSO agar mendapatkan kewenangan Agen46.</b></li>-->
				<li class="pad-btm" style="padding:5px;"><b>Jika status request pada aplikasi ITSD / Remedy adalah completed, maka akan diinformasikan userid yang telah didaftarkan pada aplikasi SSO melalui notifikasi email submitter (Admin yang melakukan request pada aplikasi ITSD).</b></li>
				<li class="pad-btm" style="padding:5px;"><b>Admin SSO dapat melakukan pengecekkan user pada menu informasi user SSO dengan menginputkan userid user yang telah didapatkan sebelumnya pada aplikasi ITSD / Remedy.</b></li>
				<br>
					<img src="<?php echo base_url('assets/images/informasi_user.JPG'); ?>"style="width: 45%; margin-bottom:10px; margin-left:28%;">
				<br>
				<li class="pad-btm" style="padding:5px;"><b>Setelah user terdaftar di aplikasi SSO, silahkan Admin masing - masing unit mempermanenkan kembali posisi ybs di SSO agar dapat mengaktivasi user Agen46.</b></li>
				<br>
				</ul>
				<br>
				<li>List Posisi yang mendapatkan kewenangan Agen46:</li>
			<br><ul style="border: 1px solid black;background: #f0f0f0;"><br><br>
			<br>
			<h5><b>Cabang</b></h5>
			<ul style="column-count: 3;">
				<li>Pemimpin Cabang </li>
				<li>Pemimpin Bidang Pemasaran Bisnis (PBP)</li>
				<li>Pemimpin Kantor Cabang Pembantu</li>
				<li>Pemimpin Kantor Kas</li>
				<li>Penyelia Pemasaran</li>
				<li>Asisten Pelayanan Nasabah</li>
				<li>Agent46 Sales</li>
				<li>Agent46 Sales (TAD/OS)</li>
				
			</ul>
			<br><br><h5><b>Wilayah</b></h5>
			<ul style="column-count: 3;">
				<li>AVP - Kelompok Solusi Bisnis Digital (SDW)</li>
				<li>Pengelola/Penyelia Brancless Banking & Bisnis Program</li>
				<li>Asisten Brancless Banking & Bisnis Program</li>
				<li>Pengelola Manajemen ATM & EDC (ATW)</li>
				<li>Analis Manajemen EDC</li>
			</ul>
			
			<br><br><H5><B>JAL</B></H5>
			<ul style="column-count: 3;">
				<li>Pemimpin Kelompok</li>
				<li>Pengelola Pengembangan Bisnis</li>					
				<li>Penyelia Administrasi Kredit (Usaha Kecil)</li>
				<li>Analis Pengembangan Bisnis</li>
				<li>Pengelola Program Promosi & Usage</li>
				<li>Analis Program Promosi & Usage</li>
				<li>Pengelola Penyaluran Program Pemerintah</li>
				<li>Analis Penyaluran Program Pemerintah</li>
				<li>Pemimpin Pengembangan Produk & Fitur</li>
				<li>Pengelola Pengembangan Produk & Fitur</li>
				<li>Analis Pengembangan Produk & Fitur</li>
				<li>Pengelola Pengembangan Kebijakan </li>
				<li>Analis Pengembangan Kebijakan</li>	
			</ul>
			
			<br><br><H5><B>RTL</B></H5>
			<ul style="column-count: 3;">
				<li>MGR Eksekusi portofolio E-Banking</li>
				<li>AMGR Eksekusi portofolio E-Banking</li>
				<li>MGR Solusi Bisnis 3</li>
				<li>AMGR Solusi Bisnis 3</li>
				<li>MGR Koordinator Bisnis Wilayah</li>
				<li>AMGR Koordinator Bisnis Wilayah</li>
				<li>MGR Pengembangan Produk & Fitur 2</li>
				<li>AMGR Pengembangan Produk & Fitur 2</li>
				<li>Pemimpin Pengembangan Produk & Fitur</li>
				<li>MGR Implementasi, Inkubasi</li>
				<li>AMGR Implementasi, Inkubasi</li>
				<li>MGR Fasilitas Transaksi</li>
				<li>AMGR Fasilitas Transaksi</li>
			</ul>
			<br><br><H5><B>DGO</B></H5>
			<ul style="column-count: 3;">
				<li>Pemimpin Kelompok Pemantauan Jaringan Elektronik</li>
				<li>Pengelola Pemantauan Operasional & Pelaporan Branchless Banking & Bisnis Program</li>
				<li>Penyelia Pemantauan Operasional & Pelaporan Branchless Banking & Bisnis Program</li>
				<li>Analis Pemantauan Operasional & Pelaporan Branchless Banking & Bisnis Program</li>
				<li>Asisten Pemantauan Operasional & Pelaporan Branchless Banking & Bisnis Program</li>
				<li>Pengelola Distribusi & Pemeliharaan Merchant</li>
				<li>Pengelola Penanganan Komplain Branchless Banking & Bisnis Program (KBB)</li>
				<li>Analis Penanganan Komplain Branchless Banking & Bisnis Program (KBB)</li>
				<li>Penyelia Distribusi & Pemeliharaan Merchant</li>
			</ul>
			<br><br>
		</ul></ul>
		
		</div>
	</div>


	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink>Informasi Create Webmail dan Icons Bina BNI B81XXXX  </b></h5></div>
		<div class="panel-body">
			<ul>
				<li><b>Saat ini untuk create WEBMAIL, EMAIL dan BNI ICONS user BINA BNI dengan NPP B81XXXX mohon untuk di request ke ISU melalui aplikasi ITSD / Remedy 
				(<a href="http://servicedesk.bni.co.id">servicedesk.bni.co.id</a>) dengan mencantumkan :
					<br><div style="margin-left: 20px;"><ol>1. Nama ,</ol>
					<ol>2. NPP ,</ol>
					<ol>3. Jabatan ,</ol>
					<ol>4. Unit dan KLN penempatan , </ol>
					<ol>5. No HP Aktif </b></ol><div>
				</li><br>
				<li><b>User ICONS BINA B81XXXX dapat digunakan H+1 dari tanggal user menerima password ICONS </b></li>
				<li><b>Untuk bina B80XXXX masih dapat dicreate via sso (User SSO, ICONs,  dan Webmail)</b></li>
			</ul>
		</div> 
	</div>
	
		<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> List Posisi di Cabang dan Wilayah yang mendapatkan Akses Aplikasi Periskop</b></h5></div>
		<div class="panel-body">
			<br><ul style="border: 1px solid black;background: #f0f0f0;"><br><br>
			<!--<h5><b>Cabang</b></h5>
			<ul>
				<li>Pemimpin Cabang</li>
				<li>PBN/PBO/PBP</li>
				<li>Pemimpin KCP</li>
				<li>Penyelia Pelayanan Nasabah (PNC)</li>
				<li>Penyelia Pelayanan Uang Tunai (PUT)</li>
				<li>Penyelia Administrasi Dalam Negeri & Kliring (DNK)</li>
				<li>Penyelia Administrasi Kredit (ADC)</li>
				<li>Penyelia Logistik & Manajemen Modal Manusia</li>
				<li>Penyelia Appraisal</li>
				<li>Penyelia Pemasaran Bisnis</li>
				<li>Penyelia Risiko Bisnis Konsumer</li>
			</ul>
			<h5><b>Cabang Sentralisasi</b></h5>
			<ul>
				<li>Pemimpin Cabang</li>
				<li>PBN/PBP</li>
				<li>Pemimpin KCP</li>
				<li>Penyelia Pelayanan Nasabah (PNC)</li>
				<li>Penyelia Pelayanan Uang Tunai (PUT)</li>
				<li>Penyelia Logistik & Manajemen Modal Manusia</li>
				<li>Penyelia Pemasaran Bisnis</li>

			</ul>			
			<h5><b>Wilayah</b></h5>
			<ul>
				<li>Pemimpin Wilayah</li>
				<li>Analis Advisory Jasa Transaksional</li>
				<li>Pemimpin Kelompok PCR (Kinerja Bisnis dan Pengelolaan Jaringan)</li>
				<li>Pemimpin Kelompok Penyelamatan dan Penyelesaian Kredit Wilayah</li>
				<li>Pemimpin Kelompok RCR (Administrasi Kredit Wilayah)</li>
				<li>Pemimpin Kelompok SPR (Penunjang Bisnis)</li>
				<li>Pemimpin Bagian Umum</li>
				<li>Pemimpin Jaringan & Layanan Wilayah</li>
				<li>Pemimpin Konsumer Banking Wilayah</li>
				<li>Pemimpin Penyelamatan & Penyelesaian Kredit Wilayah</li>
				<li>Pengelola Administrasi Kredit (Menengah)</li>
				<li>Pengelola Anggaran, Logistik & Properti</li>
				<li>Pengelola Bisnis Wilayah (Consumer Banking)</li>
				<li>Pengelola Cards and Merchants Businesses</li>
				<li>Pengelola Hukum</li>
				<li>Pengelola Manajemen ATM</li>
				<li>Pengelola Manajemen Bisnis (Bisnis Banking)</li>
				<li>Pengelola Manajemen Layanan</li>
				<li>Pengelola Manajemen Modal Manusia</li>
				<li>Pengelola Penelitian dan Pengembangan</li>
				<li>Pengelola Teknologi</li>
				<li>Penyelia Madya ATMRC</li>
				<li>Penyelia Administrasi Kredit (ADC)</li>
				<li>Pemimpin Sentra Operation (Sentra Back Office)</li>
			</ul>-->
			<h5><b>Cabang</b></h5>
			<!--<ul>
				<li>Pemimpin Cabang</li>
				<li>PBN/PBO/PBP</li>
				<li>Pemimpin KCP</li>
				<li>Penyelia Pelayanan Nasabah (PNC)</li>
				<li>Penyelia Pelayanan Uang Tunai (PUT)</li>
				<li>Penyelia Administrasi Dalam Negeri & Kliring (DNK)</li>
				<li>Penyelia Administrasi Kredit (ADC)</li>
				<li>Penyelia Logistik & Manajemen Modal Manusia</li>
				<li>Penyelia Pemasaran Bisnis</li>
				<li>Penyelia Risiko Bisnis Konsumer</li>
				<li>Penyelia Administrasi Umum</li>
			</ul>-->
			<ul style="column-count: 3;">
				<li>Pemimpin Cabang</li>
				<li>Pemimpin Bidang Operasional</li>
				<li>Pemimpin Bidang Pemasaran Bisnis</li>
				<li>Pemimpin Bidang Pembinaan Pelayanan</li>
				<li>Pemimpin Kantor Cabang Pembantu</li>
				<li>Pemimpin Kantor Kas</li>
				<li>Penyelia Administrasi Dalam Negeri & Kliring</li>
				<li>Penyelia Administrasi Kredit</li>
				<li>Penyelia Pelayanan Nasabah</li>
				<li>Penyelia Pelayanan Uang Tunai</li>
				<li>Penyelia Pemasaran Bisnis</li>
				<li>Penyelia Risiko Bisnis Konsumer</li>
				<li>Penyelia Logistik & Manajemen Modal Manusia</li>
				<li>Penyelia ADC Dan DNC</li>
				<li>Asisten Pelayanan Nasabah</li>
				<li>Asisten Pelayanan Uang Tunai</li>
				<li>Analis Kredit Standar</li>
				<li>Customer Relationship Officer</li>
				<li>Penyelia Layanan Prima / Emerald</li>
			</ul>
			<br><br><h5><b>Wilayah</b></h5>
			<!--<ul>
				<li>Pemimpin Wilayah</li>
				<li>Pemimpin Kelompok PCR (Kinerja Bisnis dan Pengelolaan Jaringan)</li>
				<li>Pemimpin Kelompok Penyelamatan dan Penyelesaian Kredit Wilayah</li>
				<li>Pemimpin Kelompok RCR (Administrasi Kredit Wilayah)</li>
				<li>Pemimpin Kelompok SPR (Penunjang Bisnis)</li>
				<li>Pemimpin Bagian Umum</li>
				<li>Pemimpin Jaringan & Layanan Wilayah</li>
				<li>Pemimpin Konsumer Banking Wilayah</li>
				<li>Pemimpin Penyelamatan & Penyelesaian Kredit Wilayah</li>
				<li>Pengelola Administrasi Kredit (Menengah)</li>
				<li>Pengelola Anggaran, Logistik & Properti</li>
				<!--<li>Pengelola Bisnis Wilayah (Consumer Banking)</li>-->
				<!--<li>Pengelola Cards and Merchants Businesses</li>
				<li>Pengelola Hukum</li>
				<li>Pengelola Manajemen ATM</li>
				<li>Pengelola Manajemen Bisnis (Bisnis Banking) / (Consumer Banking)</li>
				<li>Pengelola Manajemen Layanan</li>
				<li>Pengelola Manajemen Modal Manusia</li>
				<li>Pengelola Penelitian dan Pengembangan</li>
				<li>Pengelola Teknologi</li>
				<li>Penyelia Madya ATMRC (Kecuali WJS, WBJ, WJY dan WJK)</li>
				<li>Penyelia Administrasi Kredit (ADC)</li>
				<li>Pemimpin Sentra Operation (Sentra Back Office) (Khusus untuk WMD, WPL, WBN, WSM, WSY, WMK, WDR, WBJ)</li>
				<li>Pemimpin Sentra Kredit Menengah</li>
				<li>MGR Senior Relationship Manager Menengah</li>
				<li>Pemimpin Kelompok Pemasaran Bisnis Menengah</li>
				<li>Pemimpin Sentra Kredit Usaha Kecil</li>
				<li>Wakil Pemimpin Sentra Kredit Usaha Kecil</li>
				<li>Penyelia Analis Kredit Standar</li>
				<li>Penyelia Pemasaran Bisnis Usaha Kecil</li>
				<li>Analis Advisory Jasa Transaksional</li>
			</ul>-->
			<ul style="column-count: 3;">
				<li>Pemimpin Kantor Wilayah</li>
				<li>Pemimpin Administrasi Kredit Wilayah</li>
				<li>Pemimpin Jaringan & Layanan Wilayah</li>
				<li>Pemimpin Kelompok Kinerja Bisnis & Pengelolaan Jaringan</li>
				<li>Pemimpin Kelompok Penunjang Bisnis</li>
				<li>Pemimpin Kelompok Penyelamatan & Penyelesaian <br> Kredit Wilayah</li>
				<li>Pemimpin Konsumer Banking Wilayah</li>
				<li>Pemimpin Bagian Umum</li>
				<li>Pemimpin Sentra Operation  -  [Sentra Back Office]</li>
				<li>Pengelola Administrasi Kredit (Menengah)</li>
				<li>Pengelola Advisori Jasa Transaksional</li>
				<li>Pengelola Anggaran, Logistik & Properti</li>
				<li>Pengelola Card & Merchant Business</li>
				<li>Pengelola Hukum</li>
				<li>Pengelola Manajemen Atm</li>
				<li>Pengelola Manajemen Bisnis (Bisnis Banking)</li>
				<li>Pengelola Manajemen Bisnis (Konsumer Banking)</li>
				<li>Pengelola Manajemen Layanan</li>
				<li>Pengelola Manajemen Modal Manusia</li>
				<li>Pengelola Penelitian Dan Pengembangan</li>
				<li>Pengelola Teknologi Wilayah</li>
				<li>Penyelia Administrasi Kredit</li>
				<li>Penyelia Madya Atm Rc</li>
			</ul>
			
			<br><br><H5><B>SKC</B></H5>
			<ul>
				<li>Pemimpin Sentra Kredit Usaha Kecil</li>
				<li>Wakil Pemimpin Sentra Kredit Usaha Kecil</li>
				<li>Penyelia Pemasaran Bisnis Usaha Kecil</li>
				<li>Penyelia Analis Kredit Standar</li>
			</ul>
			
			<br><br><H5><B>SKM</B></H5>
			<ul>
				<li>Pemimpin Sentra Kredit Menengah</li>
				<li>Pemimpin Kelompok Pemasaran Bisnis Menengah</li>
				<li>Mgr Senior Relationship Manager Menengah</li>
			</ul><br><br>
		</ul>
		</div>
	</div>
	
		<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan Aplikasi PSAK 73 pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				
				<li>Aplikasi PSAK 73 dapat diakses menggunakan user ID dan password webmail</li>
				<li>Role/akses aplikasi akan sesuai dengan posisi jabatannya, Admin diharapkan melakukan update posisi untuk user yang mendapatkan kewenangan aplikasi PSAK 73</li>
				<li>Untuk user yang sudah melakukan reset target / reset webmail namun belum bisa login silahkan dipermanenkan ulang ke posisi definitifnya saat ini</li>
				<li>List Posisi yang mendapatkan kewenangan PSAK 73:</li>
				<ul>
					<h5><b>Divisi PKU</b></h5>
					<ul>
						<li>Pengelola SAN / SAN(Pembukuan)</li>
						<li>Analis SAN / SAN (Pembukuan)</li>
						<li>Asisten SAN / SAN (Pembukuan)</li>
						<li>Pengelola PKA</li>
						<li>Analis PKA</li>
					</ul>
					<h5><b>Divisi PFA</b></h5>
					<ul>
						<li>Pemimpin Bagian Akuntansi</li>
						<li>Analis Bagian Akuntansi</li>
						<li>Pengelola Pembayaran</li>
						<li>Analis Pembayaran</li>
					</ul>
					<h5><b>Wilayah</b></h5>
					<ul>
						<li>Pemimpin Bagian Umum</li>
						<li>Asisten Administrasi Umum</li>
					</ul>
					<h5><b>Cabang</b></h5>
					<ul>
						<li>Penyelia Logistik & Manajemen Modal Manusia</li>
						<li>Asisten Administrasi Logistik</li>
					</ul>
					<h5><b>KCP</b></h5>
					<ul>
						<li>Penyelia Administasi Kredit</li>
						<li>Asisten Administrasi Kredit</li>
					</ul>
				</ul>
			</ul>
			
			
		</div>
	</div>
	
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Monitoring Pengiriman Password Online ( Tracking Pengiriman Password )</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Setiap permintaan Reset atau Create user aplikasi* melalui surat / memo, password akan dikirimkan secara online melalui <b>Sistem Password Online SSO</b>. Prosesnya dapat <b>dimonitoring oleh masing - masing user SSO</b> melalui fitur <b>"Tracking Pengiriman Password"</b>,  sbb:</li>
				<br>
				<ol>
					*Aplikasi: <br>
					IBank Admin, SRP, TI Plus, I-SVS, IRS Online, SKA iCONS, New SKA, SKCDM iCONS, SKCRM iCONS, Channel Manager, SWIFT, BI-SSSS JITU, BI-SSSS DEPOX, CMOD, E-purse, Fund Separation, Cbest, Orchid, Bancs, B24, Cardlink, Go Trade, Globs					
					<br>
					(Selain aplikasi tersebut, password akan tetap dikirimkan melalui hardcopy surat password).
				</ol>
				<img src="<?php echo base_url('assets/images/tracking.JPG'); ?>"style="width: 69%; margin-bottom:10px; margin-left:15%;margin-top: 2%;">
				<li>Status pada <b>History Request Management</b>:</li>
				<img src="<?php echo base_url('assets/images/info.JPG'); ?>"style="width: 57%; margin-bottom:10px; margin-left:21%;margin-top: 2%;">
				<li>Panduan untuk membuka password yang dikirimkan melalui <b>Sistem Password Online SSO</b> dapat dilihat pada link berikut</li>
				<div style="text-align: center;padding: 2%;">
					<a style="padding: 2%;color: white;" href="<?php echo base_url('assets/file/CAS AM otomasi password.pdf'); ?>" class="btn btn-info" role="button" download><i class="fa fa-download" aria-hidden="true"></i>Panduan Password Online</a>	
				</div>
				
			</ul>		
		</div>
	</div>
	
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan Aplikasi Direktori Debitur Ditolak ( DDD ) pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				
				<li>Aplikasi Direktori Debitur Ditolak (DDD) dapat diakses menggunakan user ID dan password webmail</li>
				<li>Role/akses aplikasi akan sesuai dengan posisi jabatannya, Admin diharapkan melakukan update posisi untuk user yang mendapatkan kewenangan aplikasi Direktori Debitur Ditolak (DDD)</li>
				<li>Untuk user yang sudah melakukan reset target / reset webmail namun belum bisa login silahkan dipermanenkan ulang ke posisi definitifnya saat ini</li>
				<li>List Posisi yang mendapatkan kewenangan Direktori Debitur Ditolak (DDD):</li>
				<br><ul style="border: 1px solid black;background: #f0f0f0;">
					<br><h5><b>Cabang</b></h5><br>
					<ul>
						<li>Pemimpin Cabang</li> 
						<li>PBN/PBP</li>
						<li>Pemimpin Kantor Kas</li>
						<li>Penyelia Administasi Kredit</li>
						<li>Asisten Administrasi Kredit</li>
						<li>Asisten Administrasi Penjualan</li>
						<li>Customer Relationship Officer</li>
						
					</ul>
					<br><br>
					
					<h5><b>Wilayah</b></h5><br>
					<ul style="column-count: 3;">
						<li>Pemimpin Kantor Wilayah</li>
						<li>Pemimpin Konsumer banking Wilayah</li>
						<li>Pemimpin Jaringan & Layanan Wilayah</li>
						<li>Pemimpin Bisnis Banking Wilayah</li>
						
						<li>Pemimpin Sentra Kredit Menengah</li>
						<li>Pemimpin Kelompok Pemasaran Bisnis Menengah</li>
						<li>Mgr Senior Relationship Manager Menengah</li>
						
						<li>Pemimpin Sentra Kredit Usaha Kecil</li>
						<li>Wakil Pemimpin Sentra Kredit Usaha Kecil</li>
						<li>Analis Pemasaran Bisnis Usaha Kecil</li>
						<li>Penyelia Pemasaran Bisnis Usaha Kecil (RM)</li>
						<li>Analis Pemasaran Bisnis Usaha Kecil (RM)</li>
						<li>Penyelia Analis Kredit Standar</li>
						<li>Analis Kredit Standar</li>
						<li>Asisten Kredit Standar</li>
						
						<li>Pengelola Card & Merchant Business</li>
						<li>Penyelia Cards & Merchant Usage</li>
						<li>Asisten Administrasi Cards & Merchant Usage</li>
						<li>Asisten Supporting</li>
						<li>Asisten Cards & Merchant Usage</li>
						<li>Penyelia Cards & Merchant Sales</li>
						<li>Asisten Cards & Merchant Sales</li>
						<li>Asisten Administrasi Cards & Merchant Sales</li>
						<li>Asisten Penjualan Branchless Banking</li>
						
						<li>Pemimpin Administrasi Kredit Wilayah</li>
						<li>Pengelola Administrasi Kredit (Menengah)</li>
						<li>Analis Administrasi Kredit Menengah</li>
						<li>Asisten Administrasi Kredit</li>
						<li>Penyelia Administrasi Kredit</li>
						<li>Pengelola Layanan Pinjaman (Konsumer)</li>
						<li>Penyelia Pemeliharaan & Penyimpanan Rekening</li>
						<li>Asisten Pemeliharaan & Penyimpanan Rekening</li>
						<li>Penyelia Manajemen Dokumen</li>
						<li>Asisten Manajemen Dokumen</li>
						<li>Pengelola Pemantauan Administrasi Kredit</li>
						<li>Analis Pemantauan Administrasi Kredit</li>
					</ul>
					
					<br><br>
					<h5><b>Divisi ADK</b></h5><br>
					<ul>
						<li>Pemimpin Divisi </li>
						<li>Pemimpin Kelompok Monitoring & Pengendalian ADK</li>
						<li>Pemimpin kelompok Service Provider</li>
						<li>Wakil Pemimpin</li>
						<li>Analisis Service Provider</li>
						<li>Pengelola Monitoring & Supervisi ADK</li>
						<li>Pengelola Service Provider</li>
						<li>Analis Monitoring & Supervisi ADK</li>
						
					</ul>
					
					<br><br>
					<h5><b>Divisi OTI</b></h5><br>
					<ul>
						<li>Pengelola Service Management</li>
						<li>Analis Service Management</li>
						<li>Pengelola Pengelolaan Aplikasi ICONS</li>
						<li>Analis Pengelolaan Aplikasi ICONS</li>
					</ul>
					
					<br><br>
					<h5><b>Divisi STI</b></h5>
					<ul>
						<li>Pengelola Enterprise System</li>
						<li>Analis Enterprise System</li>
					</ul><br>
				</ul>
			</ul>
			
			
		</div>
	</div>

	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan Aplikasi Avaloq (New WMS) pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				
				<li>Aplikasi Avaloq (New WMS) dapat diakses menggunakan user ID dan password webmail</li>
				<li>Role/akses aplikasi akan sesuai dengan posisi jabatannya, Admin diharapkan melakukan update posisi untuk user yang mendapatkan kewenangan aplikasi Avaloq (New WMS) efektif H+1</li>
				<li>Untuk user yang sudah melakukan reset target / reset webmail namun belum bisa login silahkan dipermanenkan ulang ke posisi definitifnya saat ini  efektif H+1</li>
				<li>List Posisi di Cabang yang mendapatkan kewenangan Avaloq (New WMS):</li>
				<ul>
					<li>Branch Manager</li>
					<li>Branch Business Manager</li>
					<li>Branch Service Manager</li>
					<li>Sub Branch Manager</li>
					<li>Customer Service Supervisor</li>
					<li>Senior Frontliner - Fungsi Customer Service</li>
					<li>Customer Service</li>
					<li>Emerald Supervisor</li>
					<li>Emerald Service Staff</li>
					<li>Business Team Leader</li>
					<li>Business & Transaction Relationship Officer (AMGR)</li>
					<li>Consumer & Transaction Relationship Officer (AMGR)</li>
					<li>Business & Transaction Relationship Officer (ASST)</li>
					<li>Consumer & Transaction Relationship Officer (ASST)</li>
				</ul>
			</ul>
			
			
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan Aplikasi DPLK pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Aplikasi DPLK dapat diakses menggunakan user ID dan password webmail</li>
				<li>Agar role DPLK sesuai dengan posisi jabatannya, admin diharapkan melakukan update posisi untuk user yang mendapatkan kewenangan aplikasi DPLK</li>
				<li>Untuk user yang sudah melakukan reset target / reset webmail namun belum bisa login silahkan dipermanenkan ulang  ke posisi definitifnya saat ini </li>				
				<li>List Posisi yang mendapatkan kewenangan DPLK (Cabang):</li>
					<ul><b>
						<li>Pemimpin KCP / KK </li>
						<li>Penyelia Pelayanan Nasabah (PNC)</li>
						<li>Asisten Pelayanan Nasabah (PNC)</li></b>
					</ul>
				<li>Berikut informasi Integrasi DPLK ke SSO </li>
					<img src="<?php echo base_url('assets/images/DPLK-SSO.jpeg'); ?>"style="width: 53%; margin-bottom:21px; margin-left:23%;margin-top: 2%;">
			</ul>
		</div> 
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Jam Layanan SSO </b></h5></div>
		<div class="panel-body">
			
			<ul>
				<p style=" text-align: left;white-space: pre-line;">
				Berikut kami sampaikan jam operasional aplikasi SSO : 

				Jam Akses Aplikasi SSO : 
					Pukul 06.00 - 22.00 WIB

				Jam Operasional SSO by Whatsapp(Admin) :
					Pukul 07.00 - 21.00 WIB
				</p>
			</ul>
		</div>
	</div>


	<!--<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Pengisian Periskop untuk Petugas yang Merangkap Jabatan</b></h5></div>
		<div class="panel-body">
			<ul>
				<b>Untuk posisi pegawai yang rangkap (contoh: Penyelia ADC dan DNK) harus mengisi satu persatu ke masing-masing posisi secara berurutan, sbb :</b>
				<li>Jika posisi yang rangkap tiernya sama, maka setting urutan pengisiannya bebas</li>
				<li>Jika posisi yang rangkap tiernya berbeda, maka setting dan pengisian dilakukan dari <b>tier yang lebih kecil</b></li><br>
				<mark style="font-size: medium; color: red"><b>contoh :</b><br></mark>
				<li style="color: red;">[Tier Sama] Penyelia ADC dan DNK : setting ke Penyelia ADC kemudian setting kembali ke Penyelia DNK (atau sebaliknya)</li>
				<li style="color: red;">[Tier Beda] PKLN merangkap PBN : setting ke PKLN kemudian setting kembali ke PBN</li>
			</ul>		
		</div>
	</div>-->
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Informasi BINA BNI pada SSO</b></h5></div>
		<div class="panel-body"> 
			<ul>
				<li>Penambahan dan Perubahan posisi jabatan untuk pegawai BINA BNI sudah dapat dilakukan di sistem SSO pada Aplikasi IDS, baik permanen atau sementara dengan batasan 4 Jenis Posisi Bina BNI (PUT)</li>
				<li><b>Perubahan Posisi</b> ataupun penambahan user iCONS untuk user BINA mengacu pada ID iCONS BINA ybs dengan format <b>8XXXX</b></li>
				<li>Berikut daftar posisi BINA yang dapat dipilih untuk perubahan Permanen atau Sementara :</li>
				<p style="white-space: pre-line;padding: 0 60px;">
- Bina Pradana 1 
- Bina Pradana 2 
- Bina Madya / Utama<br></p>
				<li>Penambahan User BINA di system SSO dapat dilakukan pada aplikasi IDS melalui menu Tambah User Baru  </li>
				<li>Pembuatan userID mengikuti format lengkap ID BINA yaitu B80XXXX, seperti berikut: </li>
				<img src="<?php echo base_url('assets/images/bina.png'); ?>"style="width: 30%; margin-bottom:21px; margin-left:30%;margin-top: 2%;">
				<li>Khusus user BINA, kolom email dapat diisi dengan format <b>userid@bni.co.id</b><br>
					<b>ex: 80000@bni.co.id</b> </li>
				<li>Mohon manjadi perhatian, penambahan dan perubahan UserID BINA BNI (PUT) dalam mengakses aplikasi tetap mengacu pada ketentuan HCT yang dimuat pada BNIForum berdasarkan kewenangan wilayah dan kewenangan cabang.</li>
			</ul>
			<ul>
				<p>
				<b>Berikut link ketentuan HCT pada BNIForum:</b>
				<br>
				<a href="http://bniforum.bni.co.id/index.php/113882/updating-ketentuan-program-pemagangan-bina-bni">Updating Ketentuan Program Pemagangan “BINA BNI”</a>     
				<br>
				<a href="http://bniforum.bni.co.id/index.php/119922/updating-ketentuan-program-pemagangan-bina-bni-bidang-pekerjaan-asisten-pelayanan-uang-tunai-teller"> Updating Ketentuan Program Pemagangan BINA BNI Bidang Pekerjaan Asisten Pelayanan Uang Tunai (Teller)</a>
				</p>
			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Level Kapabilitas</b></h5></div>
		<div class="panel-body"> 
			<ul>
				<li>Perubahan level icons di menu Level Kapabilitas hanya berlaku 1 hari sesuai jam efektif</li>
				<li>Tolong Diperhatikan jam efektif perubahan jam sehingga request dapat diapprove oleh approval sebelum jam efektif berakhir</li>
				<li>Jika request yang diapprove setelah jam efektif berakhir, silahkan melakukan request Level Kapabilitas kembali </li>
			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink>Aplikasi terintegrasi dengan SSO</b></h5></div>
		<div class="panel-body"> 
			<p style="white-space: pre-line;padding: 0 60px;">
			Dear Bapak / Ibu,
		
			Saat ini telah dilakukan integrasi login aplikasi - aplikasi dengan Sistem Single Sign On (SSO) untuk meningkatkan kemudahan akses ke beberapa aplikasi.

			Sementara ini Aplikasi Aplikasi yang telah terintegrasi dengan SSO adalah 
				<b>
				- 	Periskop
				- 	BAR
				-	CRM
				-	EIS</b>

			Dengan kondisi tersebut, user dapat langsung mengakses Aplikasi yang telah terintegrasi tersebut di dalam Aplikasi SSO. Pada Saat Login ke dalam Aplikasi SSO, Aplikasi yang telah telah terintegrasi tersebut (Periskop, CRM, BAR dan EIS LDAP) akan langsung muncul di dalam SSO dengan terlebih dahulu melakukan penyesuaian ulang Jabatan oleh admin SSO.

			Jika memang jabatan yang dimaksud (disetting) mendapatkan kewenangan untuk Aplikasi - Aplikasi tersebut, maka secara otomasis pada saat Login ke CAS akan muncul lambang aplikasi - aplikasi yang dapat langsung diklik untuk akses ke masing - masing Aplikasi.
			</p>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> List Posisi di Cabang dan Wilayah yang mendapatkan Akses Aplikasi EIS</b></h5></div>
		<div class="panel-body">
			<h5><b>Cabang</b></h5>
			<ul>
				<li>Pemimpin Cabang</li>
				<li>PBN/PBO/PBP</li>
				<li>Pemimpin KCP / KK</li>
				<li>Penyelia Pelayanan Nasabah (PNC)</li>
				<li>Penyelia Pelayanan Uang Tunai (PUT)</li>
				<li>Penyelia Administrasi Dalam Negeri & Kliring (DNK)</li>
				<li>Penyelia Administrasi Kredit (ADC)</li>
				<li>Penyelia Layanan Prima / Emerald</li>
				<li>Penyelia Sentra Kas</li>
				<li>Penyelia Pemasaran Bisnis</li>
				<li>Penyelia Administasi Umum</li>
			</ul>			
			<h5><b>Wilayah</b></h5>
			<ul style="column-count: 3;">
				<!--
				<li>Pemimpin Sentra Kredit Usaha Kecil</li>
				<li>Pemimpin Sentra Kredit Menengah</li>
				<li>Pemimpin Kelompok Penyelamatan & Penyelesaian Kredit Wilayah</li>
				<li>Pemimpin Kelompok Penunjang Bisnis</li>
				<li>Pemimpin Kelompok Kinerja Bisnis & Pengelolaan Jaringan</li>
				<li>Pemimpin Jaringan & Layanan Wilayah</li>
				<li>Wakil Pemimpin Sentra Kredit Usaha Kecil</li>
				<li>Pengelola Penelitian Dan Pengembangan</li>
				<li>Pengelola Manajemen Layanan</li>
				<li>Pengelola Manajemen Bisnis (Konsumer Banking)</li>
				<li>Pengelola Manajemen Bisnis (Bisnis Banking)</li>
				<li>Pengelola Anggaran, Logistik & Properti</li>
				<li>Pengelola Administrasi Kredit (Menengah)</li>
				<li>Penyelia Sentra Kas</li>
				<li>Penyelia Administrasi Kredit</li>
				<li>Asisten Administrasi Kredit</li
				<li>Pemimpin Kantor Wilayah</li>
				<li>Pemimpin Konsumer Banking Wilayah</li>
				<li>Pemimpin Jaringan & Layanan Wilayah</li>
				<li>Pemimpin Bisnis Banking Wilayah</li>
				<li>Penyelia Business Program & CSR</li>
				<li>Pemimpin Kelompok Kinerja Bisnis & Pengelolaan Jaringan</li>
				<li>Pengelola Manajemen Bisnis (Konsumer Banking)</li>
				<li>Analis Manajemen Bisnis (Konsumer Banking)</li>
				<li>Pengelola Manajemen Layanan</li>
				<li>Analis Manajemen Layanan</li>
				<li>Pengelola Penelitian dan Pengembangan</li>
				<li>Analis Penelitian dan Pengembangan</li>>-->
				<li>Pemimpin Kantor Wilayah</li>
				<li>Wakil Pemimpin Wilayah Bisnis Komersial</li>
				<li>Wakil Pemimpin Wilayah Bisnis SME dan Konsumer</li>
				<li>Wakil Pemimpin Wilayah Operasional</li>
				<li>Pengelola Cash Management & Trade</li>
				<li>Pengelola/Penyelia Brancless Banking & Bisnis Program</li>
				<li>Pengelola Manajemen Layanan</li>
				<li>Analis Manajemen Layanan</li>
				<li>Pemimpin Kelompok Pengendalian Keuangan & Bisnis</li>
				<li>Pengelola Penganggaran & Pengendalian Keuangan</li>
				<li>Analis Penganggaran & Pengendalian Keuangan</li>
				<li>Pengelola Pengembangan Bisnis dan Penjualan</li>
				<li>Analis Pengembangan Bisnis dan Penjualan</li>
				<li>Pengelola Penelitian dan Pengembangan</li>
				<li>Analis Penelitian dan Pengembangan</li>
				<li>Pemimpin Kelompok Kontrol Internal Wilayah</li>
				<li>MGR Kontrol Internal Wilayah</li>
				<li>AMGR Kontrol Internal Wilayah</li>
				<li>MGR Kontrol Internal Sentra/Cabang</li>
				<li>AMGR Kontrol Internal Sentra/Cabang</li>

				

			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> List Posisi di Cabang dan Wilayah yang mendapatkan Akses Aplikasi CRM</b></h5></div>
		<div class="panel-body">
			<h5><b>Cabang</b></h5>
			<ul>
				<li>Pemimpin Cabang</li>
				<li>PBN/PBO/PBP</li>
				<li>Pemimpin KCP / KK</li>
				<li>Penyelia Pelayanan Nasabah (PNC)</li>
				<li>Penyelia Administrasi Dalam Negeri & Kliring (DNK)</li>
				<li>Penyelia Administrasi Kredit (ADC)</li>
				<li>Penyelia Layanan Prima / Emerald</li>
				<li>Penyelia Logistik & Manajemen Modal Manusia</li>
				<li>Penyelia Pemasaran Bisnis</li>
			</ul>			
			<h5><b>Wilayah</b></h5> 
			<ul>
				<li>Pemimpin Jaringan & Layanan Wilayah</li>
				<li>Pemimpin Kantor Wilayah</li>
				<li>Pemimpin Kelompok Kinerja Bisnis & Pengelolaan Jaringan</li>
				<li>Pemimpin Konsumer Banking Wilayah</li>
				<li>Pengelola Manajemen Bisnis (Bisnis Banking)</li>
				<li>Pengelola Manajemen Bisnis (Konsumer Banking)</li>
				<li>Pengelola Manajemen Layanan</li>
				<li>Pengelola Penelitian Dan Pengembangan</li>
				<li>Analis Manajemen Bisnis (Bisnis Banking)</li>
				<li>Analis Manajemen Bisnis (Konsumer Banking)</li>
				<li>Analis Penelitian Dan Pengembangan</li>
			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> List Posisi di Cabang dan Wilayah yang mendapatkan Akses Aplikasi BAR</b></h5></div>
		<div class="panel-body">
			<h5><b>Cabang</b></h5>
			<ul>
				<li>Pemimpin Cabang</li>
				<li>PBN/PBO/PBP</li>
				<li>Pemimpin KCP / KK</li>
				<li>Penyelia Pemasaran Bisnis</li>
				<li>Personal Banking Officer</li>
				<li>Analis Penjualan</li>
				<li>Asisten Penjualan</li>
			</ul>			
			<h5><b>Wilayah</b></h5>
			<ul>
				<li>Pemimpin Kantor Wilayah</li>
				<li>Pemimpin Jaringan & Layanan Wilayah</li>
				<li>Pemimpin Kelompok Kinerja Bisnis & Pengelolaan Jaringan</li>
				<li>Pemimpin Konsumer Banking Wilayah</li>
				<li>Pengelola Manajemen Bisnis (Bisnis Banking)</li>
				<li>Pengelola Manajemen Bisnis (Konsumer Banking)</li>
				<li>Pengelola Manajemen Layanan</li>
				<li>Pengelola Penelitian Dan Pengembangan</li>
				<li>Analis Manajemen Bisnis (Bisnis Banking)</li>
				<li>Analis Manajemen Bisnis (Konsumer Banking)</li>
				<li>Analis Penelitian Dan Pengembangan</li>

			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Aplikasi CMOD</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Reset password aplikasi CMOD dapat dilakukan melalui fitur <b>Reset Password Aplikasi</b> untuk user yang sebelumnya telah terdaftar</li>
				<li>Password baru pada CMOD memiliki ketentuan, yaitu: <b>tidak lebih dari 8 karakter (kombinasi huruf dan angka)</b></li>
				<li>Untuk user yang belum terdaftar, dapat mengirimkan permintaan pembuatan user baru melalui IT Helpdesk <i>(sesuai ketentuan yang berlaku)</i></li>
				<li>Berikut daftar posisi di Cabang yang mendapatkan akses aplikasi CMOD:</li>
				<img src="<?php echo base_url('assets/images/cmodcabang.png'); ?>"style="width: 30%; margin-bottom:21px; margin-left:30%;margin-top: 2%;">
				<li>Request reset aplikasi CMOD akan <b>diproses sesuai antrian</b> (dapat dimonitor oleh Admin, sesuai FAQ - Monitoring Pengiriman Password Online)</li>
			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Penambahan link EIS pada SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Posisi jabatan yang mendapatkan kewenangan aplikasi EIS, saat ini dapat mengakses aplikasi EIS melalui link EIS di SSO</li>
				<li>Agar role EIS sesuai dengan posisi jabatannya, admin diharapkan melakukan update posisi untuk user yang mendapatkan link EIS di SSO</li>
				<li>User ID dan password eis tetap menyesuaikan user dan password webmail</li>
			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Panduan Password Online SSO</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Panduan untuk membuka password yang dikirimkan melalui <b>Sistem Password Online SSO</b> dapat dilihat pada link berikut</li>
				<div style="text-align: center;padding: 2%;">
					<a style="padding: 2%;color: white;" href="<?php echo base_url('assets/file/CAS AM otomasi password.pdf'); ?>" class="btn btn-info" role="button" download><i class="fa fa-download" aria-hidden="true"></i>Panduan Password Online</a>	
				</div>			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> Reset Password Aplikasi</b></h5></div>
		<div class="panel-body">
			<ul>
				<img src="<?php echo base_url('assets/images/resetapp.png'); ?>"style="width: 50%; margin-bottom:21px; margin-left:26%;margin-top: 2%;">
				<li>Reset Aplikasi dapat dilakukan oleh user sesuai dengan aplikasi yang telah dimiliki sebelumnya.</li>
				<li>Untuk Reset Aplikasi <b>iCons dan Webmail</b>, menggunakan menu <b>Reset Target</b>.</li>
				<li>Status request dapat dipantau oleh Admin melalui menu <b>List Request Management</b>.</li>
				<li>Password akan dikirim oleh sistem dalam bentuk email (untuk mendapatkan password aplikasi, dibutuhkan Verifikasi OTP) sesuai dengan antrian request yang masuk ke OTI.</li>
				<li>List aplikasi yang dapat direquest secara self-service, antara lain:<br>
					IBank Admin, SRP, TI Plus, I-SVS, IRS Online, SKA iCONS, New SKA, SKCDM iCONS, SKCRM iCONS, Channel Manager, SWIFT, BI-SSSS JITU, BI-SSSS DEPOX, CMOD, E-purse, Fund Separation, Cbest, Orchid, Bancs, B24, Cardlink, Go Trade, Globs
				</li>
			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> User Tidak Mendapatkan Kewenangan Aplikasi</b></h5></div>
		<div class="panel-body">
			<ul>
				<img src="<?php echo base_url('assets/images/error.JPG'); ?>"style="width: 26%; margin-bottom:21px; margin-left:36%;margin-top: 2%;">
				<li>Error ini akan muncul apabila user belum memiliki akses / kewenangan ke aplikasi yang akan di reset.</li>
				<li>Apabila user sebelumnya sudah memiliki akses / kewenangan aplikasi tetapi muncul error <b>'user tidak memiliki kewenangan'</b> harap menghubungi admin SSO agar dilakukan pengecekkan untuk kewenangan aplikasinya.</li>
				<li>
					*Aplikasi: <br>
					IBank Admin, SRP, TI Plus, I-SVS, IRS Online, SKA iCONS, New SKA, SKCDM iCONS, SKCRM iCONS, Channel Manager, SWIFT, BI-SSSS JITU, BI-SSSS DEPOX, CMOD, E-purse, Fund Separation, Cbest, Orchid, Bancs, B24, Cardlink, Go Trade, Globs					
				</li>
			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" style="background-color: #b0b0b0; color: #000000"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b><blink style="color: #ff1212;">New   </blink> User SKM, SKC, RBC dan RBW</b></h5></div>
		<div class="panel-body">
			<ol><li><b>SKC dan SKM</b></li>
			<ul>
				<li>Perubahan posisi (permanen, sementara, dan perubahan unit) untuk pegawai SKC dan SKM dapat dilakukan admin wilayah</li>
				<li>Posisi untuk SKM dan SKC dapat dicari berdasarkan format berikut:</li>
				<ol style="text-align: center;padding: 2%;font-size: 16px;">
				  <b>RUBRIK - KODE SENTRA - POSISI</b><br> <i>ex: BLM-2090-PEMIMPIN SENTRA KREDIT MENENGAH</i> 
				</ol>
			</ul>
			<br>
			<li><b>RBC dan RBW</b></li>
			<ul>
				<li>Perubahan posisi (permanen, sementara, dan perubahan unit) untuk pegawai RBC dan RBW dapat dilakukan oleh admin divisi CMR</li>
				<li>Posisi untuk SKM dan SKC dapat dicari berdasarkan format berikut:</li>
				<ol style="text-align: center;padding: 2%;font-size: 16px;">
				  <b>RBC/RBW+RUBRIK -0- POSISI</b><br> <i>ex: RBCGTL-0-PEMIMPIN RBC CABANG GORONTALO
					<br>
					<div >RBWTGM-0-PEMIMPIN RISIKO BISNIS WILAYAH</div>
					</i> 
				</ol>
			</ul>
			</ol>
		</div>
	</div>
	<!--<div class="panel panel-default ">
		<div class="panel-heading" ><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Fitur SCO sudah dapat dilakukan pada aplikasi ID Service - SSO</b></h5></div>
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
				<li>Untuk pembuatan <b>iCons SCO baru</b>, silahkan menghubungi <b> Syariah Padanan untuk diteruskan ke Divisi Teknologi Informasi BNI Syariah (ITD)</b>.</li>
			</ul>
		</div>
	</div>-->
		<div class="panel panel-default ">
		<div class="panel-heading" > <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Fitur Kill User</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Kill user icons dapat dilakukan melalui menu kill user dengan menginputkan no terminal icons</li>
				<li>Fitur ini dapat digunakan masing user yang telah terdaftar di SSO (Self Service)</li>
				
			</ul>
			<img src="<?php echo base_url('assets/images/killuser.JPG'); ?>"style="width: 45%; margin-bottom:10px; margin-left:28%;">
			<br>
			
			<ul >
				<u style="font-size: 21px;">Admin</u>
		
				<li style="margin: 24px;margin-top: 24px;margin-top: 10px;">Pada tampilan admin, untuk memunculkan data request silahkan klik <b>request Admin</b></li>
			</ul>
			<img src="<?php echo base_url('assets/images/killuser2.gif'); ?>"style="display: block;margin-left: auto;margin-right: auto;width: 80%;">
			<br>
			<ul >
				<u style="font-size: 21px;">Approval</u> 
		
				<li style="margin: 24px;margin-top: 24px;margin-top: 10px;">Pada tampilan approval, untuk memunculkan data request silahkan klik <b>request Approve</b></li>
			</ul>
			<img src="<?php echo base_url('assets/images/killuser3.gif'); ?>"style="display: block;margin-left: auto;margin-right: auto;width: 80%;">
			<br>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" > <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Fitur Informasi User</b></h5></div>
		<div class="panel-body">
			<ul>
				<li>Informasi <b>posisi, dan kode cabang</b> dapat dilihat pada fitur Informasi User dengan input <b>NPP atau Nama</b> pada field Search seperti contoh berikut :
			</ul>
			<img src="<?php echo base_url('assets/images/newinfo.gif'); ?>"style="width: 45%; margin-bottom:10px; margin-left:28%;">
		</div>
	</div>

	<div class="panel panel-default ">
		<div class="panel-heading" > <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Perubahan Unit</b></h5></div>
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
	<div class="panel panel-default">
		<div class="panel-heading" > <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Tambah User Baru</b></h5></div>
		<div class="panel-body">
			<img src="<?php echo base_url('assets/images/nua.jpg'); ?>"style="width: 45%; margin-bottom:10px; margin-left:28%;">
			<ul>
				<li>Fitur tambah user baru secara otomatis akan membuat user <b>CAS, iCons, dan Webmail</b> pegawai yang dapat efektif pada hari yang sama.</li>
			</ul>
			<ul>
				<li>Pastikan <b>Nama dan NPP</b> pegawai sesuai dengan data HCMS.</li>
			</ul>
			<ul>
				<li>Apabila tombol <b>Save</b> tidak muncul, maka pegawai tersebut sudah terdaftar di unit lain. Silahkan menghubungi unit terkait untuk melakukan Ubah Unit atau menghubungi Administrator.</li>
			</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading" ><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Sudah melakukan update no HP di HCMS, tetapi mengapa pada saat lupa password no HP masih salah?</b></h5></div>
		<div class="panel-body">
		<ul>
			<li>Sistem SSO belum terintegrasi dengan HCMS, apabila ada perubahan no HP dapat dilakukan update melalui fitur Ubah No Handphone.</li>
		</ul>
		<br>
		<img src="<?php echo base_url('assets/images/hp.JPG'); ?>"style="width: 45%; margin-bottom:10px; margin-left:28%;">

		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading"> <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Bagaimana cara mengakses sistem Single Sign On?</b></h5></div>
		<div class="panel-body">Single Sign On dapat diakses melalui browser Chrome atau Mozilla Firefox tanpa menggunakan proxy. Apabila PC telah tersambung dengan proxy, maka dapat dilakukan setting proxy untuk browser yang digunakan. Cara setting proxy browser dapat dilihat pada e-training di <a href="http://bniforum.bni.co.id" style= "color: #FF0000;text-decoration: underline;">http://bniforum.bni.co.id.</a></div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Sudah berhasil login SSO, tetapi kenapa mendapat notifikasi 'Kewenangan Aplikasi Belum Tersedia'?</b></h5></div>
		<div class="panel-body">Menu ID Service (IDS) hanya didapat oleh user dengan posisi yang berwenang sebagai Admin (asisten administrasi umum, asisten bagian umum, asisten logistik dan sdm) atau Approval (Pemimpin Cabang, PBP, PBN, PBO). Selain posisi tersebut maka user hanya dapat melakukan aktivitas self-service saja, seperti reset password ICONS atau Webmail yang menunya terletak di pojok kanan atas (Reset Target) tanpa membutuhkan approval pemimpin.</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Mengapa pada saat pertama kali mengakses SSO muncul keterangan 'Your connection is not secure'?</b></h5></div>
		<div class="panel-body">Setting sertifikat dapat dilihat pada e-training (confirm security certificate) di <a href="http://bniforum.bni.co.id"style= "color: #FF0000;text-decoration: underline;">http://bniforum.bni.co.id.</a></div>
	</div>
    <div class="panel panel-default ">
		<div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Berapa lama waktu yang dibutuhkan untuk menerima SMS OTP?</b></h5></div>
		<div class="panel-body">Tergantung provider yang digunakan oleh masing-masing user. Apabila belum menerima OTP lebih dari 3 menit, maka dapat coba resend OTP atau bisa melakukan proses dari awal kembali.</div>
	</div>

    <div class="panel panel-default ">
		<div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Bagaimana melakukan perubahan posisi untuk pegawai sentra?</b></h5></div>
		<div class="panel-body">
		<ul>
			<li>Perubahan posisi pegawai SKC dan SKM dapat dilakukan oleh admin wilayah masing - masing </li>
		</ul>
		</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Mengapa pada saat login muncul error 'This account has been locked'?</b></h5></div>
		<div class="panel-body">Pada saat user telah mencoba login namun password yang diinput salah sebanyak lebih dari 5x maka akun user tersebut akan dilock secara otomatis. Untuk membuka lock tersebut, silahkah diinfokan melalui group WA Implementasi SSO.</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Bagaimana mekanisme perubahan di SSO?</b></h5></div>
		<div class="panel-body">Apabila menginginkan perubahan posisi permanen atau posisi sementara dapat efektif hari ini, maka lakukan setting jam efektif saja. Namun, apabila menginginkan perubahan posisi untuk yang akan datang, maka lakukan setting tanggal efektif saja. Untuk perubahan unit akan selalu efektif sehari setelah dilakukan perubahan.</div>
	</div>
	<div class="panel panel-default ">
		<div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Bagaimana pada saat melakukan pencarian NPP user, tetapi posisi yang tertera tidak sesuai?</b></h5></div>
		<div class="panel-body">User tersebut didaftarkan posisinya sesuai dengan data HCT, sebaiknya segera melakukan Review Posisi terlebih dahulu untuk memastikan kesesuaian posisi pegawai.</div>
	</div>
    <div class="panel panel-default ">
		<div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Bagaimana pada saat melakukan perubahan posisi untuk Weekend Banking, namun posisi user tidak kembali sesuai dengan posisi saat ini?</b></h5></div>
		<div class="panel-body">Sebaiknya segera melakukan Review Posisi terlebih dahulu untuk memastikan kesesuaian posisi pegawai.</div>
	</div>
    <div class="panel panel-default ">
		<div class="panel-heading"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span><h5><b>Apakah fungsi tombol release?</b></h5></div>
		<div class="panel-body">Apabila salah satu admin melakukan inisiasi request (review maupun perubahan), defaultnya proses request tersebut dilock ke admin tersebut sampai yang bersangkutan melakukan submit. Fungsi release adalah untuk membuka lock tersebut agar request tersebut dapat diupdate oleh admin lain. Sehingga, apabila ada request yang belum disubmit dan butuh bantuan admin lain maka bisa menggunakan tombol "Release".</div>
	</div>
</body>
</html>
