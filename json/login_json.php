<?php
	include "../config/koneksi.php";
	include "../config/library.php";

	$username = antiinjection($_POST['username']);
	$pass     = antiinjection(md5(md5($_POST['password'])));

	$login=mysql_query("SELECT * FROM users WHERE username='".$username."' AND password='".$pass."' AND blokir='N'");
	mysql_close(); 
	$ketemu=mysql_num_rows($login);
	$r=mysql_fetch_array($login);

	if ($ketemu > 0){

		$response["code"]			 = "0";
		$response["message"]		 = "LOGIN SUKSES!";
		$response['username']  	   = $r['username'];
		$response['nama_lengkap']	= $r['nama_lengkap'];
		$response['password']  	   = $r['password'];
		$response['level'] 	   = $r['level'];
		$response['kode']    	     = $r['kode'];
		$response['nik']	         = $r['nik'];
		echo json_encode($response);
	}
	else{
	 
		$response["code"] = "1";
		$response["message"] = "LOGIN GAGAL!\nUsername atau Password Anda tidak benar.\n
			Atau account Anda sedang diblokir.";
		echo json_encode($response);
	}
?>
