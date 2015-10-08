<?php
//Fungsi upload image --------------------------------------------------------------
function UploadImage($fupload_name){
	//direktori gambar
	$vdir_upload = "../../image/";
	$vfile_upload = $vdir_upload . $fupload_name;
	
	//Simpan gambar dalam ukuran sebenarnya
	move_uploaded_file($_FILES["file"]["tmp_name"], $vfile_upload);
	
	//identitas file asli
	$tipe_file      = $_FILES['file']['type'];
	if($tipe_file == "image/png"){
		$im_src = imagecreatefrompng($vfile_upload);
	}else if($tipe_file == "image/jpeg"){
		$im_src = imagecreatefromjpeg($vfile_upload);
	}
	$src_width = imageSX($im_src);
	$src_height = imageSY($im_src);
	
	//Simpan dalam versi small 110 pixel
	//Set ukuran gambar hasil perubahan
	$small_width = 50;
	$small_height = ($small_width/$src_width)*$src_height;
	
	//proses perubahan ukuran
	$im = imagecreatetruecolor($small_width,$small_height);
	imagecopyresampled($im, $im_src, 0, 0, 0, 0, $small_width, $small_height, $src_width, $src_height);
	
	//Simpan gambar
	imagejpeg($im,$vdir_upload . "ttd_" . $fupload_name);
	  
	//Hapus gambar di memori komputer
	imagedestroy($im_src);
	imagedestroy($im);
	unlink($vdir_upload . "" . $fupload_name);
}

//Fungsi upload file--------------------------------------------------------
function UploadFile($fupload_name){
	//direktori file
	$vdir_upload = "../../../files/";
	$vfile_upload = $vdir_upload . $fupload_name;
	
	//Simpan gambar dalam ukuran sebenarnya
	move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
	
	
}

?>
