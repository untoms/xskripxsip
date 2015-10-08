<?php
	error_reporting(1);

include"../config/koneksi.php";
include"../config/library.php";
include"../config/fungsi_combobox.php";
include"../config/fungsi_indotgl.php";
include"../config/fungsi_thumb.php";
include"../config/PHPMailer/class.phpmailer.php";

$module = $_GET['module'];
$act = $_GET['act'];

if ($module == 'skripsi' AND $act == 'select') {

    //$edit = mysql_query("SELECT nip,nama FROM table6 WHERE konsentrasi='" . $_POST['konsentrasi'] . "' AND bimbingan <= 5 order by nama"); hilangkan sementara
    $edit = mysql_query("SELECT nip,nama FROM table6 WHERE bimbingan <= 5 order by nama");
    $pesan = array();
    if (mysql_num_rows($edit)) {
		
        while ($data = mysql_fetch_array($edit)) {			
			$respone["nip"]=$data['nip'];
			$respone["nama"]=$data['nama'];
						
			array_push($pesan,$respone);
        }
        
    }
    mysql_close();
	$data = json_encode($pesan);
	echo "{\"daftar_pembimbing\":" . $data . "}";
} else if ($module == 'skripsi' AND $act == 'edit') {

    $edit = mysql_query("SELECT skripsi.status,skripsi.instansi,skripsi.kota,skripsi.nomor,skripsi.nim,skripsi.nama,skripsi.tgl,pb1.nama AS pbnama1,pb1.konsentrasi,skripsi.judul,
                           pb2.nama AS pbnama2,skripsi.link,skripsi.status,skripsi.kodepembimbing1,skripsi.kodepembimbing2 FROM table111 AS skripsi
                           LEFT JOIN table6 AS pb1 ON pb1.nip = skripsi.kodepembimbing1
                           LEFT JOIN table6 AS pb2 ON pb2.nip = skripsi.kodepembimbing2 
                           WHERE skripsi.nim = '" . $_POST['nim'] . "' AND skripsi.nomor = '" . $_POST['nomor'] . "'");
    $pesan = array();
    if (mysql_num_rows($edit)) {
        $data = mysql_fetch_array($edit);
        $option1 = $data['pbnama1'];
        $option2 = $data['pbnama2'];
        $option3 = $data['konsentrasi'];
        $option4 = $data['status'];
		
		$pesan["pembimbing1"] = $option1;
        $pesan["pembimbing2"] = $option2;
		$pesan["konsentrasi"] = $option3;
		$pesan["nama"] = $data['nama'];
		$pesan["status"] = $data['status'];
		$pesan["nim"] = $data['nim'];
		$pesan["nomor"] = $data['nomor'];
		$pesan["tgl"] = $data['tgl'];
		$pesan["kota"] = $data['kota'];
		$pesan["judul"] = $data['judul'];
		$pesan["instansi"] = $data['instansi'];
		$pesan["CODE"] = "0";
		$pesan["MESSAGE"] = "SUCCESS!";
        
    }
    mysql_close();
    echo json_encode($pesan);
	
} else if ($module == 'skripsi' AND $act == 'save') {
    $tgl = date('Y-m-d H:i:s', strtotime($_POST[tgl]));
    /* get Nomer */
    $qgetNomer = mysql_query("SELECT (nomor + 1) AS nomer FROM table2 WHERE nim = '" . $_POST[nim] . "' ORDER BY nomor DESC LIMIT 1");
    if (mysql_num_rows($qgetNomer) > 0) {
        $arrnomer = mysql_fetch_array($qgetNomer);
        $nomer = $arrnomer['nomer'];
    } else {
        $nomer = 1;
    }
    ###########################
    /* Cek status Pengajuan */
    $qcek = mysql_query("SELECT count(nomor) AS jum FROM table111 WHERE nim = '" . $_POST[nim] . "' AND (status IS NULL OR status = 'Di ACC' OR status = 'Di Revisi')");
    $ncek = mysql_fetch_array($qcek);
    $cek = $ncek['jum'];
    ###########################
    $qgetMail = mysql_query("SELECT email FROM table6 WHERE nip IN ('" . $_POST['kodepembimbing1'] . "','" . $_POST['kodepembimbing2'] . "') AND email != ''");
    $status = FALSE;
    if ($cek == 0) {
        if (mysql_num_rows($qgetMail) > 0) {
            while ($getmail = mysql_fetch_array($qgetMail)) {
                /* Email */
                $mail = new PHPMailer(); // create a new object
                $mail->IsSMTP(); // enable SMTP
                $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
                $mail->SMTPAuth = true; // authentication enabled
                $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
                $mail->Host = "smtp.googlemail.com";
                $mail->Port = 465;
                $mail->Username = "skripsiums@gmail.com";
                $mail->Password = "ums12345";

                $mail->SetFrom('skripsiums@gmail.com', 'Sistem Informasi Skripsi');
                $mail->Subject = "Pengajuan Skripsi A/N " . $_POST['nama'];
                $body = "Pengajuan Skripsi : <br>
             Nama      : " . $_POST['nama']
                        . " <br>
             Tanggal   : " . $tgl . "<br>
             Link File : " . $_POST['link'];
                $address = $getmail['email'];
                $name = "Sistem Informasi Skripsi";
                $mail->MsgHTML($body);
                $mail->AddAddress($address, $name);
                if ($mail->Send()) {
                    $status = TRUE;
                } else {
                    $status = FALSE;
                }
            }
        }
        ##############################################
        mysql_query("INSERT INTO table111(nomor,
                                 nim,
                                 nama,
                                 tgl, 
                                 kodepembimbing1,
				 kodepembimbing2,
				 link,
                                 kota,
                                 instansi,judul) 
	                       VALUES('$nomer',
                                '$_POST[nim]',
                                '$_POST[nama]',
                                '$tgl',
                                '$_POST[kodepembimbing1]',
                                '$_POST[kodepembimbing2]',
				'" . sqlQuery($_POST[link]) . "','" . sqlQuery($_POST[kota]) . "',
                                '" . sqlQuery($_POST[instansi]) . "',
				'" . sqlQuery($_POST[judul]) . "')");

        if (mysql_affected_rows() > 0) {
            if ($status == TRUE) {
                $data = array("CODE" => "0", "MESSAGE" => "Data Berhasil Di Simpan");
            } else {
                $data = array("CODE" => "0", "MESSAGE" => "Data Berhasil Di Simpan.. Email Gagal di kirim Ke dosen Pembimbing.!");
            }
        } else {
            $data = array("CODE" => "1", "MESSAGE" => "Data Gagal Di Simpan");
        }
    } else {
        $data = array("CODE" => "1", "MESSAGE" => "Status Pengajuan Judul Skripsi Sebelumnya Masih Dalam Proses..(Tidak Bisa Menambah Data)");
    }
    echo json_encode($data);
    mysql_close();
} else if ($module == 'skripsi' AND $act == 'update') {
    $tgl = date('Y-m-d H:i:s');
    $qgetNomer = mysql_query("SELECT count(nomor) AS nomer FROM table2 WHERE nim = '" . $_POST[nim] . "' AND nomor = '" . $_POST['nomor'] . "' 
                              AND status != 'Di Tolak' ORDER BY nomor DESC LIMIT 1");
    if (mysql_num_rows($qgetNomer) > 0) {
        $arrnomer = mysql_fetch_array($qgetNomer);
        $nomer = $arrnomer['nomer'];
    } else {
        $nomer = 1;
    }
    ##############################################
    mysql_query("START TRANSACTION;");
    try {
        if ($_POST[statuscek] != $_POST[status]) {
            mysql_query("UPDATE table111 SET `status` ='" . $_POST['status'] . "' WHERE nomor = '" . $_POST['nomor'] . "' AND nim = '" . $_POST['nim'] . "';");
            if (mysql_affected_rows() == 0) {
                $msg = "Gagal Update Data";
                throw new exception($msg);
            }
        }

        if ($nomer == 0) {
            mysql_query("INSERT INTO table2(nomor,
                                 nim,
                                 nama,
                                 tgl, 
                                 kodepembimbing1,
				 kodepembimbing2,
                                 kota,
                                 Instansi,
                                 judul,
                                 `status`,
                                konsentrasi) 
	                       VALUES('$_POST[nomor]',
                                '$_POST[nim]',
                                '$_POST[nama]',
                                '$tgl',
                                '$_POST[kodepembimbing1]',
                                '$_POST[kodepembimbing2]',
                                '" . sqlQuery($_POST[kota]) . "',
                                '" . sqlQuery($_POST[instansi]) . "',
				'" . sqlQuery($_POST[judul]) . "',
                                '$_POST[status]',
                                '$_POST[konsentrasi]');");
        } else {
            mysql_query("UPDATE table2 SET `status` ='" . $_POST['status'] . "',judul = '" . $_POST['judul'] . "' 
                        WHERE nomor = '" . $_POST['nomor'] . "' AND nim = '" . $_POST['nim'] . "';");
            if (mysql_affected_rows() == 0) {
                $msg = "Gagal Input Data";
                throw new exception($msg);
            }
        }
        if (mysql_affected_rows() > 0) {
            $data = array("CODE" => "0", "MESSAGE" => "Data Berhasil Di Simpan");
            mysql_query("COMMIT;");
        } else {
            $msg = "Gagal Input Data";
            throw new exception($msg);
        }
    } catch (Exception $e) {
        $data = array("CODE" => "0", "MESSAGE" => $msg);
        mysql_query("ROLLBACK;");
    }
    echo json_encode($data);
    mysql_close();
} else if ($module == 'skripsi' AND $act == 'load') {
    $cek = 1;
    $url = "modul/modul_disposisi/aksi_pesan.php";
    $data = array();
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
    $sortby = isset($_POST['sortby']) ? trim($_POST['sortby']) : '';
    $data_cari = isset($_POST['data']) ? trim($_POST['data']) : '';
    $offset = ($page - 1) * $rows;
    if ($_POST['leveluser'] == 'admin') {
        $where = isset($_POST['cari']) ? "WHERE " . $sortby . " LIKE '%" . $data_cari . "%'" : "";
        $tampil = mysql_query
		(
			"SELECT skripsi.judul,
					skripsi.status,
					skripsi.nomor,
					skripsi.nim,
					skripsi.nama,
					skripsi.tgl,
					pb1.nama AS pbnama1,
					pb2.nama AS pbnama2,
					skripsi.link,
					skripsi.kodepembimbing2 			
				FROM 
			
					table111 AS skripsi
			
			LEFT JOIN 
					table6 AS pb1 
					ON 
						pb1.nip = skripsi.kodepembimbing1
			LEFT JOIN 
				table6 AS pb2 
					ON 
						pb2.nip = skripsi.kodepembimbing2
                           
		   " . $where . " 
		   
		   ORDER BY skripsi.tgl DESC 
		   
		   LIMIT " . $offset . "," . $rows
		   
		);
    } else if ($_POST['leveluser'] == 'dosen') {
        $where = isset($_POST['cari']) ? "AND " . $sortby . " LIKE '%" . $data_cari . "%'" : "";
        $tampil = mysql_query("SELECT skripsi.judul,skripsi.status,skripsi.nomor,skripsi.nim,skripsi.nama,skripsi.tgl,pb1.nama AS pbnama1, pb2.nama AS pbnama2,skripsi.link,skripsi.kodepembimbing2 FROM table111 AS skripsi
                           LEFT JOIN table6 AS pb1 ON pb1.nip = skripsi.kodepembimbing1
                           LEFT JOIN table6 AS pb2 ON pb2.nip = skripsi.kodepembimbing2 
                           WHERE (skripsi.kodepembimbing1 = '" . $_POST['nik'] . "' OR skripsi.kodepembimbing2 = '" . $_POST['nik'] . "')
                           " . $where . " ORDER BY skripsi.tgl DESC LIMIT " . $offset . "," . $rows);
    } else {
        $where = isset($_POST['cari']) ? "AND " . $sortby . " LIKE '%" . $data_cari . "%'" : "";
        $tampil = mysql_query("SELECT skripsi.judul,skripsi.status,skripsi.nomor,skripsi.nim,skripsi.nama,skripsi.tgl,pb1.nama AS pbnama1, pb2.nama AS pbnama2,skripsi.link,skripsi.kodepembimbing2 FROM table111 AS skripsi
                           LEFT JOIN table6 AS pb1 ON pb1.nip = skripsi.kodepembimbing1
                           LEFT JOIN table6 AS pb2 ON pb2.nip = skripsi.kodepembimbing2 WHERE nim = '" . $_POST['nik'] . "'
                           " . $where . " ORDER BY skripsi.tgl DESC LIMIT " . $offset . "," . $rows);
    }
    $hitung = mysql_query("SELECT * FROM table111 ORDER BY tgl ");
    mysql_close();
    while ($r = mysql_fetch_array($tampil)) {
        if (($_POST['leveluser'] == 'admin' OR $_POST['leveluser'] == 'dosen') && $r['status'] != "Di Tolak") {
            if ($r['kodepembimbing2'] != $_POST['nik']) {
                $aksi = "allow";
            }
        } else {
            $aksi = "not";
        }
        $data['rows'][] = array(
			
			"nomor" => $r['nomor'],
            "nama" => $r['nama'],
            "nim" => $r['nim'],
            "tgl" => $r['tgl'],
            "pbnama1" => $r['pbnama1'],
            "pbnama2" => $r['pbnama2'],
            "link" => $r['link'] ,
            "judul" => $r['judul'],
            "status" => ($r['status'] == NULL) ? "Proses" : $r['status'],
            "aksi" => $aksi);
        $cek++;
    }
    $data["total"] = mysql_num_rows($hitung);
	$data["number"]=mysql_num_rows($tampil);
    if ($cek == 1) {
        $data['rows'] = array();
    }
    echo json_encode($data);
}
?>
