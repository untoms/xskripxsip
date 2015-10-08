<?php
/*
$server = "localhost";
$username = "root";
$password = "";
$database = "xyz1";
*/
$server = "localhost";
$username = "root";
$password = "root";
$database = "indonesiamerdeka";

// Koneksi dan memilih database di server
$db = mysql_connect($server,$username,$password) or die("Koneksi gagal");
mysql_select_db($database) or die("Database tidak bisa dibuka");
// SPP201145217
?>
