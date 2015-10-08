<?php

ini_set('memory_limit', '-1');
session_start();
include "../../config/koneksi.php";
include "../../config/Spreadsheet_Excel_Reader.php";

$status = false;
if ($_GET['act'] == 'dosen') {
    if (isset($_FILES['file'])) {
        $data = new Spreadsheet_Excel_Reader();
        chmod($_FILES['file']['tmp_name'], 0755);
        $data->read($_FILES['file']['tmp_name']);
        $data->setOutputEncoding('CP1251');
        $baris = $data->sheets[0]['numRows'];
        $data_up = array();
        /* Cek Data Surat Apakah Sudah ada */
        $ceknip = array();
        $qcek = mysql_query("DELETE from table6 ");
//        while ($arrcek = mysql_fetch_array($qcek)) {
//            $ceknip[$arrcek['nip']] = $arrcek['nip'];
//        }
        /*         * ***************************** */
        try {
            for ($i = 2; $i <= $baris; $i++) {

                $nip = isset($data->sheets[0]['cells'][$i][1]) ? $data->sheets[0]['cells'][$i][1] : "";
                $nama = isset($data->sheets[0]['cells'][$i][2]) ? $data->sheets[0]['cells'][$i][2] : "";
                $nidn = isset($data->sheets[0]['cells'][$i][3]) ? $data->sheets[0]['cells'][$i][3] : "";
                $pangkatgol = isset($data->sheets[0]['cells'][$i][4]) ? $data->sheets[0]['cells'][$i][4] : "";
                $jabatan = isset($data->sheets[0]['cells'][$i][5]) ? $data->sheets[0]['cells'][$i][5] : "";
                $konsentrasi = isset($data->sheets[0]['cells'][$i][6]) ? $data->sheets[0]['cells'][$i][6] : "";
                $bimbingan = isset($data->sheets[0]['cells'][$i][7]) ? $data->sheets[0]['cells'][$i][7] : "";
                $email = isset($data->sheets[0]['cells'][$i][8]) ? $data->sheets[0]['cells'][$i][8] : "";

                if (array_key_exists($nip, $ceknip)) {
                    
                } else {
                    $data_up[] = array(
                        'nip' => $nip,
                        'nama' => $nama,
                        'nidn' => $nidn,
                        'pangkatgol' => $pangkatgol,
                        'jabatan' => $jabatan,
                        'konsentrasi' => $konsentrasi,
                        'bimbingan' => $bimbingan,
                        'email' => $email);
                }
                $status = true;
            }
        } catch (Exception $d) {
            $pesan = $d->getmessage();
            $status = false;
            $data = array("status" => 1, "msg" => "Gagal");
        }
    } else {
        $data = array("status" => 1, "msg" => "File Excel Tidak Valid");
    }
    /* INput DataBASE */
    if ($status == true) {
        try {
            //$db->autocommit(FALSE);
            /* Input Data */
            if (count($data_up) > 0) {
                foreach ($data_up AS $key => $row) {
                    mysql_query("INSERT INTO table6(
                         nip,
                         nama,
                         nidn,
                         pangkatgol,
                         jabatan,
                         konsentrasi,
                         bimbingan,
                         email)
                        VALUES(
                        '" . $row['nip'] . "',
                        '" . $row['nama'] . "',
                        '" . $row['nidn'] . "',
                        '" . $row['pangkatgol'] . "',
                        '" . $row['jabatan'] . "',
                        '" . $row['konsentrasi'] . "',
                        '" . $row['bimbingan'] . "',
                        '" . $row['email'] . "')");

                    if (mysql_affected_rows() == 0) {
                        $msg = "Data Gagal Di Inputkan";
                        Throw new Exception($msg);
                        break;
                    }
                }
            } else {
                $msg = "Data Kosong / Data Sudah Ada.";
                Throw new Exception($msg);
            }
            //if ( mysql_affected_rows() > 0) {
            //mysqli_commit($db);
            $data = array("status" => 0, "msg" => "Data Berhasil Di Import");
            //}
        } catch (Exception $e) {
            $pesan = $e->getmessage();
            //mysqli_rollback($db);
            $data = array("status" => 1, "msg" => $msg);
        }
    }
    mysql_close();
    echo json_encode($data);
} else {
    if (isset($_FILES['file'])) {
        $data = new Spreadsheet_Excel_Reader();
        chmod($_FILES['file']['tmp_name'], 0755);
        $data->read($_FILES['file']['tmp_name']);
        $data->setOutputEncoding('CP1251');
        $baris = $data->sheets[0]['numRows'];
        $data_up = array();
        $data_update = array();
        /* Cek Data Surat Apakah Sudah ada */
        $ceknim = array();
        mysql_query("DELETE from table4 ");
        try {
            for ($i = 2; $i <= $baris; $i++) {
                $nim = isset($data->sheets[0]['cells'][$i][1]) ? $data->sheets[0]['cells'][$i][1] : "";
                $Nama = isset($data->sheets[0]['cells'][$i][2]) ? $data->sheets[0]['cells'][$i][2] : "";
                $angkatan = isset($data->sheets[0]['cells'][$i][3]) ? $data->sheets[0]['cells'][$i][3] : "";
                $pembimbing1 = isset($data->sheets[0]['cells'][$i][4]) ? $data->sheets[0]['cells'][$i][4] : "";
                $pembimbing2 = isset($data->sheets[0]['cells'][$i][5]) ? $data->sheets[0]['cells'][$i][5] : "";
                $JudulSkripsi = isset($data->sheets[0]['cells'][$i][6]) ? $data->sheets[0]['cells'][$i][6] : "";
                $statusjudul = isset($data->sheets[0]['cells'][$i][7]) ? $data->sheets[0]['cells'][$i][7] : "";
                $bab1 = isset($data->sheets[0]['cells'][$i][8]) ? $data->sheets[0]['cells'][$i][8] : "";
                $bab2 = isset($data->sheets[0]['cells'][$i][9]) ? $data->sheets[0]['cells'][$i][9] : "";
                $bab3 = isset($data->sheets[0]['cells'][$i][10]) ? $data->sheets[0]['cells'][$i][10] : "";
                $bab4 = isset($data->sheets[0]['cells'][$i][11]) ? $data->sheets[0]['cells'][$i][11] : "";
                $bab5 = isset($data->sheets[0]['cells'][$i][12]) ? $data->sheets[0]['cells'][$i][12] : "";

                if (array_key_exists($nim, $ceknim)) {
                    $data_update[] = array(
                        "nim" => $nim,
                        "Nama" => $Nama,
                        "Angkatan" => $angkatan,
                        "pembimbing1" => $pembimbing1,
                        "pembimbing2" => $pembimbing2,
                        "JudulSkripsi" => $JudulSkripsi,
                        "statusjudul" => $statusjudul,
                        "bab1" => $bab1,
                        "bab2" => $bab2,
                        "bab3" => $bab3,
                        "bab4" => $bab4,
                        "bab5" => $bab5);
                } else {
                    $data_up[] = array(
                        "nim" => $nim,
                        "Nama" => $Nama,
                        "Angkatan" => $angkatan,
                        "pembimbing1" => $pembimbing1,
                        "pembimbing2" => $pembimbing2,
                        "JudulSkripsi" => $JudulSkripsi,
                        "statusjudul" => $statusjudul,
                        "bab1" => $bab1,
                        "bab2" => $bab2,
                        "bab3" => $bab3,
                        "bab4" => $bab4,
                        "bab5" => $bab5);
                }
                $status = true;
            }
        } catch (Exception $d) {
            $pesan = $d->getmessage();
            $status = false;
            $data = array("status" => 1, "msg" => "Gagal");
        }
    } else {
        $data = array("status" => 1, "msg" => "File Excel Tidak Valid");
    }
    /* INput DataBASE */
    if ($status == true) {
        try {
            //$db->autocommit(FALSE);
            /* Input Data */
            if (count($data_up) > 0) {
                foreach ($data_up AS $key => $row) {
                    mysql_query("INSERT INTO table4(
                        nim,
                        Nama,
                        Angkatan,
                        pembimbing1,
                        pembimbing2,
                        JudulSkripsi,
                        statusjudul,
                        bab1,
                        bab2,
                        bab3,
                        bab4,
                        bab5) 
	                VALUES('" . $row['nim'] . "',
                        '" . $row['Nama'] . "',
                        '" . $row['Angkatan'] . "',
                        '" . $row['pembimbing1'] . "',
                        '" . $row['pembimbing2'] . "',
                        '" . $row['JudulSkripsi'] . "',
                        '" . $row['statusjudul'] . "',
                        '" . $row['bab1'] . "',
                        '" . $row['bab2'] . "',
                        '" . $row['bab3'] . "',
                        '" . $row['bab4'] . "',
                        '" . $row['bab5'] . "')");



                    if (mysql_affected_rows() == 0) {
                        $msg = "Data Gagal Di Inputkan";
                        Throw new Exception($msg);
                        break;
                    }
                }
            }
            //if ( mysql_affected_rows() > 0) {
            //mysqli_commit($db);
            $data = array("status" => 0, "msg" => "Import Data Berhasil");
            //}
        } catch (Exception $e) {
            $pesan = $e->getmessage();
            //mysqli_rollback($db);
            $data = array("status" => 1, "msg" => $msg);
        }
    }
    mysql_close();
    echo json_encode($data);
}
?>
