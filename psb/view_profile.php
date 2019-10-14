<?php 
if ($_GET['halaman']==''){
echo "<div class='alert alert-info'>Data Profile / Akun <a class='btn btn-xs btn-primary pull-right' href='index.php?view=profile&halaman=edit'>Edit Profile</a></div><br>";
  $cl = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM rb_psb_akun where id_psb_akun='$_SESSION[id]'"));
  	if (isset($_GET['sukses'])){
	  echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
	      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
	      <span aria-hidden='true'>×</span></button> <strong>Sukses!</strong> - Data telah Berhasil Di Proses,..
	      </div>";
	}elseif(isset($_GET['gagal'])){
	  echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
	      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
	      <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Data tidak Di Proses, terjadi kesalahan dengan data..
	      </div>";
	}
  echo "<dl class='dl-horizontal'>
            <dt>Nama Lengkap</dt>     <dd style='color:red'>$cl[nama_lengkap]</dd>
            <dt>Username / Email</dt>     <dd>$cl[email]</dd>
            <dt>No Telpon</dt>        <dd>$cl[no_telpon]</dd>
            <dt>Password</dt>        <dd>**********************</dd>
            <dt>IP Terdeteksi</dt>    <dd>$cl[ip]</dd>
            <dt>Waktu Daftar</dt>     <dd><i>$cl[waktu_daftar]</i> WIB</dd>
        </dl>";
}elseif($_GET['halaman']=='edit'){
  if (isset($_POST['update'])){
      if (trim($_POST['d'])==''){
          $query = mysqli_query($koneksi, "UPDATE rb_psb_akun SET 
                                       nama_lengkap = '$_POST[a]',
                                       email = '$_POST[b]',
                                       no_telpon = '$_POST[c]' where id_psb_akun='$_POST[id]'");  
      }else{
          $query = mysqli_query($koneksi, "UPDATE rb_psb_akun SET 
                                       nama_lengkap = '$_POST[a]',
                                       email = '$_POST[b]',
                                       no_telpon = '$_POST[c]',
                                       password = '".md5($_POST[d])."' where id_psb_akun='$_POST[id]'");
      }
                                       
      if ($query){
        echo "<script>document.location='index.php?view=profile&sukses';</script>";
      }else{
        echo "<script>document.location='index.php?view=profile&gagal';</script>";
      } 

  }

  $s = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM rb_psb_akun where id_psb_akun='$_SESSION[id]'"));
  echo "<div class='alert alert-info'>Edit Profile / Akun</div><br>
  	<form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
        <div class='col-md-12'>
          <table class='table table-condensed'>
          <tbody>
            <input type='hidden' name='id' value='$s[id_psb_akun]'>
            <tr><th width='140px' scope='row'>Nama Lengkap</th> <td><input type='text' class='form-control' name='a' value='$s[nama_lengkap]'> </td></tr>
            <tr><th scope='row'>Username / Email</th> <td><input type='text' class='form-control' name='b' value='$s[email]' onkeyup=\"nospaces(this)\"> </td></tr>
            <tr><th scope='row'>No Telpon</th> <td><input type='number' class='form-control' name='c' value='$s[no_telpon]'> </td></tr>
            <tr><th scope='row'>Password</th>          <td><input type='password' class='form-control' name='d'><small><i>Biarkan Kosong jika tidak diubah!</i></small></td></tr>
          </tbody>
          </table>
        </div>
        <div class='box-footer'>
            <button type='submit' name='update' class='btn btn-info'>Update</button>
            <a href='index.php?view=profile'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
        </div>
    </form>";
}
?>

