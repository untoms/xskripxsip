<?php

session_start();
include "../../config/koneksi.php";
include "../../config/cek_session.php";

$module = $_GET['module'];
$act = $_GET['act'];

// Hapus user
if ($module == 'user' AND $act == 'hapus') {
    if ($_POST['username'] == "") {
        mysql_query("DELETE FROM users WHERE (`level` = 'guest' OR `level` = 'dosen')");
    } else {
        mysql_query("DELETE FROM users WHERE username='" . $_POST['username'] . "'");
    }

    if (mysql_affected_rows() > 0) {
        $data = array("status" => 0, "msg" => "Data Berhasil Di Hapus");
    } else {
        $data = array("status" => 1, "msg" => "Data Gagal Di Hapus");
    }
    echo json_encode($data);
    mysql_close();
}

// Input user
elseif ($module == 'user' AND $act == 'proses') {

    $a = mysql_query("(SELECT nim,nama,'guest' AS tipe from table4
                LEFT JOIN (SELECT username FROM users WHERE `level` = 'guest' ORDER BY username ) 
                AS users ON users.username = nim
                GROUP BY nim,nama,users.username
                HAVING users.username IS NULL
                ) 
                UNION
                (SELECT nip AS nim,nama,'dosen' AS tipe from table6 WHERE nip NOT IN(
                SELECT username FROM users WHERE `level` = 'dosen' ORDER BY username )
                GROUP BY nip,nama)");
    $b = mysql_num_rows($a);
    if ($b > 0) {
        mysql_query("START TRANSACTION;");
        try {
            while ($user = mysql_fetch_array($a)) {
                $pass = md5(md5('123456'));
                mysql_query("INSERT INTO users(username,
                                 password,
                                 nama_lengkap,
                                 email, 
                                 no_telp,
				 level,
				 kode,nik) 
	                       VALUES('" . $user['nim'] . "',
                                '" . $pass . "',
                                '" . str_replace("'", "", $user['nama']) . "',
                                '" . @ums . "',
                                '-',
				'" . $user['tipe'] . "',
				'0','" . $user['nim'] . "')");


                if (mysql_affected_rows() == 0) {
                    $msg = "Data Gagal Di Simpan";
                    throw new Exception($msg);
                    break;
                }
            }
            $data = array("status" => 0, "msg" => "Data Berhasil Di Simpan");
            mysql_query("COMMIT;");
        } catch (Exception $e) {
            $data = array("status" => 1, "msg" => "Data Gagal Di Simpan");
        }
    } else {
        $data = array("status" => 1, "msg" => "Belum Ada Data Baru");
        mysql_query("ROLLBACK;");
    }
    echo json_encode($data);
    mysql_close();
}


// Input from tabel
elseif ($module == 'user' AND $act == 'input') {

    $a = mysql_query("select * from users where username = '" . $_POST['username'] . "' ");
    $b = mysql_num_rows($a);

    if ($b == 0) {
        $pass = md5(md5($_POST[password]));
        mysql_query("INSERT INTO users(username,
                                 password,
                                 nama_lengkap,
                                 email, 
                                 no_telp,
								 level,
								 kode,nik) 
	                       VALUES('$_POST[username]',
                                '$pass',
                                '$_POST[nama_lengkap]',
                                '$_POST[email]',
                                '$_POST[no_telp]',
								'$_POST[status]',
								'0','$_POST[nik]')");

        if (mysql_affected_rows() > 0) {
            $data = array("status" => 0, "msg" => "Data Berhasil Di Simpan");
        } else {
            $data = array("status" => 1, "msg" => "Data Gagal Di Simpan");
        }
    } else {
        $data = array("status" => 1, "msg" => "Data Gagal Di simpan");
    }
    echo json_encode($data);
    mysql_close();
}


// Update user
elseif ($module == 'user' AND $act == 'update') {

    if (empty($_POST['password'])) {
        mysql_query("UPDATE users SET nama_lengkap   = '$_POST[nama_lengkap]',
									  email          = '$_POST[email]',  
									  no_telp        = '$_POST[no_telp]',
                                                                          nik        = '$_POST[nik]'
							   WHERE  username       = '$_POST[username]'");
    }
    // Apabila password diubah
    else {
        $pass = md5(md5($_POST['password']));
        mysql_query("UPDATE users SET  password        = '$pass',
									   nama_lengkap    = '$_POST[nama_lengkap]',
									   email           = '$_POST[email]',   
									   no_telp        = '$_POST[no_telp]',
                                                                           nik        = '$_POST[nik]'
							   WHERE username        = '$_POST[username]'");
    }
    if (mysql_affected_rows() > 0) {
        $data = array("status" => 0, "msg" => "Data Berhasil Di Update");
    } else {
        $data = array("status" => 1, "msg" => "Data Gagal Di Update");
    }
    echo json_encode($data);
    mysql_close();
}

// get user
elseif ($module == 'user' AND $act == 'select') {

    $edit = mysql_query("SELECT * FROM users WHERE username='" . $_POST['name'] . "'");
    $r = mysql_fetch_array($edit);
    mysql_close();
    $users = array();
    if (isset($edit)) {
        $users = array(
            "username" => $r['username'],
            "nama_lengkap" => $r['nama_lengkap'],
            "email" => $r['email'],
            "enik" => $r['nik'],
            "no_telp" => $r['no_telp']
        );
    }

    echo json_encode($users);
} elseif ($module == 'user' AND $act == 'load') {
    $url = "modul/mod_users/aksi_users.php";
    $data = array();
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
    $sortby = isset($_POST['sortby']) ? trim($_POST['sortby']) : '';
    $data_cari = isset($_POST['data']) ? trim($_POST['data']) : '';
    $offset = ($page - 1) * $rows;
    $usn = ($_SESSION['leveluser'] == "admin") ? "" : ((isset($_POST['cari'])) ? "AND username = '" . $_SESSION['namauser'] . "'" : "WHERE username = '" . $_SESSION['namauser'] . "'");
    $where = isset($_POST['cari']) ? "WHERE " . $sortby . " LIKE '%" . $data_cari . "%' " . $usn . "" : $usn;
    $tampil = mysql_query("SELECT * FROM users " . $where . " ORDER BY username DESC LIMIT " . $offset . "," . $rows);
    $hitung = mysql_query("SELECT * FROM users ");
    while ($r = mysql_fetch_array($tampil)) {
        $aksi = " <a onclick = getData('" . $r['username'] . "','?module=user&act=select') href='javascript:void(0);' data-toggle='modal' data-target='#edit' class ='glyphicon glyphicon-pencil'> </a> &nbsp;
					<a onclick = transdelete('" . $r['username'] . "','?module=user&act=hapus') class ='glyphicon glyphicon-trash' > </a>";
        $data['rows'][] = array("username" => $r['username'], "nama" => $r['nama_lengkap'],
            "level" => $r['level'],
            "telp" => $r['no_telp'],
            "blokir" => $r['blokir'],
            "aksi" => $aksi);
    }
    $data["total"] = mysql_num_rows($hitung);
    echo json_encode($data);
    mysql_close();
}
?>
