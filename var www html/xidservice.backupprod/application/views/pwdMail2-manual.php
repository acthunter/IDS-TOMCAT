<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>[ID Service] Permintaan Kode Token</title>
    <!-- 
    The style block is collapsed on page load to save you some scrolling.
    Postmark automatically inlines all CSS properties for maximum email client 
    compatibility. You can just update styles here, and Postmark does the rest.
    -->
    <style type="text/css" rel="stylesheet" media="all">
	body {
		font-size: 10px;
	}
    div.container {
    width: 100%;
    border: 1px solid gray;
}

header, footer {
    padding: 1em;
    color: white;
    background-color: black;
    clear: left;
    text-align: center;
	width: 600px;
}

nav {
    float: left;
    max-width: 160px;
    margin: 0;
    padding: 1em;
}

nav ul {
    list-style-type: circle;
    padding: 0;
}
   
nav ul a {
    text-decoration: none;
}

article {
    margin-left: 170px;
	width: 400px;
    border-left: 1px solid gray;
    padding: 1em;
    overflow: hidden;
}

 .button {
    
    border: none;
    color: white;
    padding: 3px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
 }
 .button1 {border-radius: 8px; background-color: #4CAF50; /* Green */}
 #helpdesk{
	width: 630px;
    overflow: hidden;
 }
 .button1:hover {background-color: #ffff00;}
    </style>
  </head>
  <body>
     <header><img src="cid:bnilogo.jpg" style="width: 10%;"><b style="font-size : 150%;" /> AKSES Manajemen</header>
	<p>
	Dear ${mail.name},
	</p>
	<p>Anda baru saja melakukan penggantian password untuk aplikasi ${mail.apps}</p>

<nav style="margin-top:1%;">
  <ul>
     <button class="button button1"><a style="color: black;" href="${url_link}&npp=${jtoken.npp}&t=${jtoken.apps}" class="button button--grey">! <br> Laporkan Penyalahgunaan</a></button>
  </ul>
</nav>
	<article>
	<ul>
	<li>Password yang telah Bpk/Ibu tentukan sedang dalam penanganan kami</li>
	<li>Kami akan menyampaikan email konfirmasi lebih lanjut, jika password telah berhasil kami proses </li>
	<li>Jika dalam 1x24 jam Bpk/Ibu belum memperoleh email konfirmasi, mohon hubungi IT help desk</li>
	</ul>
	</article>
	
	<p class="sub align-center" id="helpdesk" style="color: #000">Email ini dikirimkan secara otomatis oleh sistem, jika ada pertanyaan silahkan hubungi Help Desk Divisi OTI (021)29946000</p>
	
  </body>
</html>