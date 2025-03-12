<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>[ID Service] Konfirmasi Password</title>
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

 .button--green {
      background-color: #22BC66;
      border-top: 10px solid #22BC66;
      border-right: 18px solid #22BC66;
      border-bottom: 10px solid #22BC66;
      border-left: 18px solid #22BC66;
 }
    </style>
  </head>
  <body>
     <header><img src="cid:bnilogo.jpg" style="width: 10%;"><b style="font-size : 150%;" /> AKSES Manajemen</header>
	<p>
	Dear <?php $npp ?>,
	</p>
	<p>Anda telah melakukan pengesetan password baru untuk aplikasi ${jtoken.apps}</p>

	<article>
	<ul>
	<li>Sistem IDS akan memberikan konfirmasi lebih lanjut terkait waktu efektif password dapat digunakan.</li>
	</ul>
	</article>

	<p class="sub align-center" style="color: #000">Email ini dikirimkan secara otomatis oleh sistem, jika ada pertanyaan silahkan hubungi Help Desk Divisi OTI (021)29946000</p>
	
  </body>
</html>