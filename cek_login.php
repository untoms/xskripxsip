<?php
include "config/koneksi.php";
include "config/library.php";

$username = antiinjection($_POST['username']);
$pass     = antiinjection(md5(md5($_POST['password'])));

$login=mysql_query("SELECT * FROM users WHERE username='".$username."' AND password='".$pass."' AND blokir='N'");
mysql_close(); 
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);

if ($ketemu > 0){
  session_start();

  $_SESSION['namauser']     = $r['username'];
  $_SESSION['namalengkap']  = $r['nama_lengkap'];
  $_SESSION['passuser']     = $r['password'];
  $_SESSION['leveluser']    = $r['level'];
  $_SESSION['kode']         = $r['kode'];
  $_SESSION['nik']         = $r['nik'];
  
  header('location:media.php?module=home');
}
else{
  echo "<link href=../config/adminstyle.css rel=stylesheet type=text/css>";
  echo "<center>LOGIN GAGAL! <br> 
        Username atau Password Anda tidak benar.<br>
        Atau account Anda sedang diblokir.<br>";
  echo "<a href=index.php><b>ULANGI LAGI </b></a></center>";
}
?>
