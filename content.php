<?php

// Bagian Home
if ($_GET['module'] == 'home') {
    $title = "Home";
    echo '<div class="bs-callout bs-callout-info">
			<h4>Sistem Informasi Pengajuan Skripsi </h4>
			<p>Welcome to Sistem Informasi Pengajuan Skripsi Universitas Muhamadiyah Surakarta</p>
		</div>';
} elseif ($_GET['module'] == 'pembimbing') {
    include "modul/mod_pembimbing/pembimbing.php";
    $title = " Daftar Pembimbing";
} elseif ($_GET['module'] == 'skripsi') {
    include "modul/mod_skripsi/skripsi.php";
    $title = "Pengajuan Skripsi";
}
// Bagian Modul
elseif ($_GET['module'] == 'user') {
    include "modul/mod_users/users.php";
    $title = "User Manajemen";
}
// Apabila modul tidak ditemukan
else {
    echo "<p><b>MODUL BELUM ADA ATAU BELUM LENGKAP</b></p>";
    $title = "";
}
?>