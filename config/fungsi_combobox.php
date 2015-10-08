<?php
include "koneksi.php";
function combotgl($awal, $akhir, $var, $terpilih){
  $data = "<div class='form-group'><select name=$var id=$var class='form-control' style='width:100%'>";
  for ($i=$awal; $i<=$akhir; $i++){
    $lebar=strlen($i);
    switch($lebar){
      case 1:
      {
        $g="0".$i;
        break;     
      }
      case 2:
      {
        $g=$i;
        break;     
      }      
    }  
    if ($i==$terpilih)
      $data .= "<option value=$g selected>$g</option>";
    else
      $data .= "<option value=$g>$g</option>";
  }
  $data .= "</select></div>";
  return $data;
}

function combobln($awal, $akhir, $var, $terpilih){
  $data .= "<div class='form-group'><select name=$var id=$var class='form-control' style='width:100%'>";
  for ($bln=$awal; $bln<=$akhir; $bln++){
    $lebar=strlen($bln);
    switch($lebar){
      case 1:
      {
        $b="0".$bln;
        break;     
      }
      case 2:
      {
        $b=$bln;
        break;     
      }      
    }  
      if ($bln==$terpilih)
         $data .= "<option value=$b selected>$b</option>";
      else
        $data .= "<option value=$b>$b</option>";
  }
  $data .= "</select> </div>";
  return $data;
}

function combothn($awal, $akhir, $var, $terpilih){
  $data = "<div class='form-group'><select name=$var id=$var class='form-control' style='width:100%'>";
  for ($i=$awal; $i<=$akhir; $i++){
    if ($i==$terpilih)
      $data .= "<option value=$i selected>$i</option>";
    else
      $data .= "<option value=$i>$i</option>";
  }
  $data .= "</select></div> ";
  
  return $data;
}

function Jenis_surat($var,$isi,$terpilih,$type,$judul){
  $id =  $var;
  $data = "<select name=$var id='".$id."' class='form-control' style='width:100%'>";
  $data .= "<option value=''>".$judul."</option>";
  foreach($isi AS $key=>$row){
	$data .= "<option value='".$row."' ".(($row == $terpilih) ? "selected":"")." >".$row."</option>";
  }
  
  $data .= "</select> ";
  
  return $data;
}

function getDiteruskan(){
  $query = mysql_query("SELECT UNITKERJA FROM unitkerja");
  $data = array();
	  while($row=mysql_fetch_array($query)){
			$data[] = $row['UNITKERJA'];
	  }
  
  return $data;
}
?>
