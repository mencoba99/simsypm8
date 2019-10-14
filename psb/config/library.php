<?php
//date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];

$tgl_sekarang = date("Ymd");
$tgl_cetak = date("j F Y");
$tgl_skrg     = date("d");
$bln_sekarang = date("m");
$thn_sekarang = date("Y");
$jam_sekarang = date("H:i:s");

function rupiah($total){
      if(is_numeric($total)==false){
        return 0;
      }elseif(trim($total)!=''){
        return number_format($total,0);
      }elseif(trim($total)==''){
        return 0;
      }else{
        return 0;
      }
    }
    
$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");
function Upload($fupload_name){
  //direktori banner
  $vdir_upload = "files/";
  $vfile_upload = $vdir_upload . $fupload_name;
  move_uploaded_file($_FILES["tt"]["tmp_name"], $vfile_upload);
}

function Upload1($fupload_name){
  //direktori banner
  $vdir_upload = "files/";
  $vfile_upload = $vdir_upload . $fupload_name;
  move_uploaded_file($_FILES["uu"]["tmp_name"], $vfile_upload);
}

function Upload2($fupload_name){
  //direktori banner
  $vdir_upload = "files/";
  $vfile_upload = $vdir_upload . $fupload_name;
  move_uploaded_file($_FILES["vv"]["tmp_name"], $vfile_upload);
}

function Upload3($fupload_name){
  //direktori banner
  $vdir_upload = "files/";
  $vfile_upload = $vdir_upload . $fupload_name;
  move_uploaded_file($_FILES["ww"]["tmp_name"], $vfile_upload);
}

function Upload4($fupload_name){
  //direktori banner
  $vdir_upload = "files/";
  $vfile_upload = $vdir_upload . $fupload_name;
  move_uploaded_file($_FILES["xx"]["tmp_name"], $vfile_upload);
}

function Upload5($fupload_name,$jml){
  //direktori banner
  $vdir_upload = "files/";
  $vfile_upload = $vdir_upload . $fupload_name;
  move_uploaded_file($_FILES["yy"]["tmp_name"], $vfile_upload);
}
?>
