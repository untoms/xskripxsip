<?php
include "../config/koneksi.php";

if ($_SESSION[leveluser]=='admin'){
  $sql=mysql_query("select * from modul where status ='admin' and aktif='Y' order by urutan");
}
elseif($_SESSION[leveluser]=='wali'){
  $sql=mysql_query("select * from modul where status='wali' and aktif='Y' order by urutan"); 
} 
else{
  $sql=mysql_query("select * from modul where status='user' and aktif='Y' order by urutan"); 
} 
while ($m=mysql_fetch_array($sql)){  
  echo "<li><a href='$m[link]'>&#187; $m[nama_modul]</a></li>";
}
if ($_SESSION[leveluser]=='admin'){
?>
	<ul class="easyui-tree"><li data-options="state:'closed'"><span>SMS</span><ul>
	<li><a href="?module=sms&act=satu">Kirim Sms</a></li>
	<li><a href="?module=sms&act=banyak">Broadcast Sms</a></li>
	<li><a href="?module=phonebook">Phone Book</a></li>
	</ul></li></ul>
<?php
}
?>
