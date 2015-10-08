<?php
	function sqlQuery($data){
			if(isset($data)){
				$escape_string = strip_tags(mysql_real_escape_string($data));
			}else{
				$escape_string = $data;
			}
		  return $escape_string;	
	}

	function encryptIt($q) {
		$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
		$qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
		return( $qEncoded );
	}

	function decryptIt( $q ) {
		$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
		$qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
		return( $qDecoded);
	}

	function antiinjection($data){
	  $filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
	  return $filter_sql;
	}

	function count_msg($data){
	    if($data == "all"){
			$data = mysql_query("SELECT count(NO) AS jum_surat FROM aktif WHERE catatan = ''");
		}else if($data != "Sisipan"){
			$data = mysql_query("SELECT count(NO) AS jum_surat FROM aktif WHERE catatan = '' AND JENISSURAT = '".$data."'");
		}else{
			$data = mysql_query("SELECT count(NO) AS jum_surat FROM aktif WHERE catatan = '' AND noagenda2 LIKE '%.%'");
		}
		$arrjum =mysql_fetch_array($data);
		return $arrjum['jum_surat'];
	}
	
	function split_tanggal($data){
		$split_waktu = explode(" ",$data);
		$cek_tanggal = $split_waktu[0] == "0000-00-00" ? date("Y-m-d"):$split_waktu[0];
		$split_tanggal = explode("-",$cek_tanggal);
		$arrdata = array();
		
		if(isset($split_tanggal)){
			$arrdata = array("tgl" => $split_tanggal[2],
							"bln" => $split_tanggal[1],
							"thn" => $split_tanggal[0]);
		}	
		return $arrdata;
	}
	
?>
