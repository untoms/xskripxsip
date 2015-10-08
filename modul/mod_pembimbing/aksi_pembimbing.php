<?php

session_start();
include "../../config/koneksi.php";
include "../../config/library.php";
include "../../config/cek_session.php";
include "../../config/fungsi_combobox.php";
include "../../config/fungsi_indotgl.php";

$data = array();
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$sortby = isset($_POST['sortby']) ? trim($_POST['sortby']) : '';
$data_cari = isset($_POST['data']) ? trim($_POST['data']) : '';
$offset = ($page - 1) * $rows;
if ($_SESSION['leveluser'] == 'admin') {
    $cari = ($sortby != "") ? "WHERE " . $sortby . " LIKE '%" . $data_cari . "%'" : "";
    $tampil = mysql_query(" SELECT * FROM table4 " . $cari . " ORDER BY Nama DESC LIMIT " . $offset . "," . $rows);
    $hitung = mysql_query("SELECT * FROM table4 " . $cari . " ORDER BY Nama ");
} else if ($_SESSION['leveluser'] == 'dosen') {
    $cari = ($sortby != "") ? "AND " . $sortby . " LIKE '%" . $data_cari . "%'" : "";
    $tampil = mysql_query(" SELECT * FROM table4  WHERE (kodepembimbing1 = '" . $_SESSION['nik'] . "' OR kodepembimbing2 = '" . $_SESSION['nik'] . "') " . $cari . " ORDER BY Nama DESC LIMIT " . $offset . "," . $rows);
    $hitung = mysql_query("SELECT * FROM table4 WHERE (kodepembimbing1 = '" . $_SESSION['nik'] . "' OR kodepembimbing2 = '" . $_SESSION['nik'] . "') " . $cari . " ORDER BY Nama ");
} else {
    $cari = ($sortby != "") ? "AND " . $sortby . " LIKE '%" . $data_cari . "%'" : "";
    $tampil = mysql_query(" SELECT * FROM table4  WHERE nim = '" . $_SESSION['nik'] . "' " . $cari . " ORDER BY Nama DESC LIMIT " . $offset . "," . $rows);
    $hitung = mysql_query("SELECT * FROM table4 WHERE nim = '" . $_SESSION['nik'] . "' " . $cari . " ORDER BY Nama ");
}

mysql_close();
while ($r = mysql_fetch_array($tampil)) {
    $data['rows'][] = array("nomor" => $r['nomor'],
        "nama" => $r['Nama'],
        "nim" => $r['nim'],
        "tgl" => $r['tgldaftarskripsi'],
        "pbnama1" => $r['pembimbing1'],
        "pbnama2" => $r['pembimbing2'],
        "link" => "",
        "judul" => $r['JudulSkripsi'],
        "status" => $r['statusjudul'],
        "1" => $r['bab1'],
        "2" => $r['bab2'],
        "3" => $r['bab3'],
        "4" => $r['bab4'],
        "5" => $r['bab5'],
        "tglujian" => $r['tglujian'],
        "penguji1" => $r['penguji1'],
        "penguji2" => $r['penguji2'],
        "penguji3" => $r['penguji3']);
}
$data["total"] = mysql_num_rows($hitung);
if (mysql_num_rows($hitung) == 0) {
    $data['rows'] = array();
}
echo json_encode($data);
?>
