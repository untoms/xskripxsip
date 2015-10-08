<?php
function grade($nilai) {
  if($nilai >= 60 && $nilai <= 74){
   $grade='C' ;
 }else if($nilai >= 75 && $nilai <= 84){
   $grade='B' ;
 }else if($nilai >= 85 && $nilai <= 100 ){
   $grade='A'; 
  }else{
  $grade='D';
  }
 return $grade ;
 }
 
function kelulusan($nilai){
if($nilai > 65 ){
$kelulusan='LULUS';
}else{
$kelulusan='TIDAK LULUS';
} 
return $kelulusan ;
} 
?>
