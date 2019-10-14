<?php 

if ($_GET['halaman']=='') {
  echo "<div class='alert alert-info'>Data Profile / Akun <a class='btn btn-xs btn-primary pull-right' href='index.php?view=profile&halaman=edit'>Edit Profile</a></div><br>";
    $cl = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM rb_humas_traceralumni where id_traceralumni='$_SESSION[id]'"));
      if (isset($_GET['sukses'])){
        echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>×</span></button> <strong>Sukses!</strong> - Data telah Berhasil Di Proses,..
          </div>";
      } else if (isset($_GET['gagal'])) {
        echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Data tidak Di Proses, terjadi kesalahan dengan data..
            </div>";
      }
  
  echo "<dl class='dl-horizontal'>
            <dt>Nama Lengkap</dt>         <dd style='color:red'>$cl[nama]</dd>
            <dt>Username / Email</dt>     <dd>$cl[username]</dd>
            <dt>NISN</dt>                 <dd>$cl[nisn]</dd>
            <dt>Password</dt>             <dd>**********************</dd>
            <dt>No Telpon</dt>            <dd>$cl[no_hp]</dd>
            <dt>Tahun Lulus</dt>          <dd>$cl[tahun_lulus]</dd>
            <dt>Alamat</dt>               <dd>$cl[alamat]</dd>
            <dt>IP Terdeteksi</dt>        <dd>$_SERVER[REMOTE_ADDR]</dd>
            <dt>Waktu Daftar</dt>         <dd><i>$cl[waktu_input]</i> WIB</dd>
        </dl>";

        echo "
        <h4 style='margin-top: 20px'>Data Riwayat Pekerjaan</h4>
        <table id='example1' class='table table-condensed table-bordered table-striped'>
          <thead>
              <tr>
                  <th style='width:20px'>No</th>
                  <th>Nama Instansi</th>
                  <th>Pimpinan Instansi</th>
                  <th>Alamat Instansi</th>
                  <th>Jabatan Pekerjaan</th>
                  <th>Tahun Masuk</th>
                  <th>Tahun Keluar</th>
                  <th>Gaji</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>";
              $datas = mysqli_query($koneksi,"SELECT * FROM rb_lk_riwayat_tracer WHERE id_traceralumni = '$_SESSION[id]'");
              // $data = mysqli_fetch_array($datas);
              $no = 1;
              foreach ($datas as $r) {
              echo "<tr>
                      <td style='text-align: center;'>$no</td>
                      <td>$r[nama]</td>
                      <td>$r[pimpinan]</td>
                      <td>$r[alamat]</td>
                      <td>$r[jabatan]</td>
                      <td>$r[tahun_masuk]</td>";
                      if ("$r[tahun_keluar]" === '0') {
                          echo "<td>Sekarang</td>";
                      } else {
                          echo "<td>$r[tahun_keluar]</td>";
                      }
                      echo "<td>Rp. ".rupiah($r['gaji'])."</td>";
                      echo "<td>
                        <a class='btn btn-xs btn-primary' href='index.php?view=profile&halaman=riwayat&id=".$r['id_riwayat']."'>Edit</a><br/>
                        <a style='margin-top: 5px;' class='btn btn-xs btn-danger' href='index.php?view=profile&halaman=hapus&id=".$r[id_riwayat]."' onclick=\"return confirm('Apakah anda Yakin Data ini Dihapus?')\">Hapus</a>
                      </td>
                  </tr>";
              $no++;
              }
          echo "</tbody>
      </table>";
} else if ($_GET['halaman']=='edit') {
  if (isset($_POST['update'])){
      if (trim($_POST['d'])==''){
          $query = mysqli_query($koneksi, "UPDATE rb_humas_traceralumni SET 
                                       nama = '$_POST[a]',
                                       username = '$_POST[b]',
                                       nisn = '$_POST[e]',
                                       tahun_lulus = '$_POST[f]',
                                       alamat = '$_POST[g]',
                                       no_hp = '$_POST[c]' where id_traceralumni='$_POST[id]'");  
      }else{
          $query = mysqli_query($koneksi, "UPDATE rb_humas_traceralumni SET 
                                        nama = '$_POST[a]',
                                        username = '$_POST[b]',
                                        nisn = '$_POST[e]',
                                        tahun_lulus = '$_POST[f]',
                                        alamat = '$_POST[g]',
                                        no_hp = '$_POST[c]',
                                        password = '".md5($_POST[d])."' where id_traceralumni = '$_POST[id]'");
      }
                                       
      if ($query){
        echo "<script>document.location='index.php?view=profile&sukses';</script>";
      }else{
        echo "<script>document.location='index.php?view=profile&gagal';</script>";
      } 

  }

  $s = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM rb_humas_traceralumni where id_traceralumni = '$_SESSION[id]'"));
  echo "<div class='alert alert-info'>Edit Profile / Akun</div><br>
  	<form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
        <div class='col-md-12'>
          <table class='table table-condensed'>
          <tbody>
            <input type='hidden' name='id' value='$s[id_traceralumni]'>
            <tr>
              <th width='140px' scope='row'>Nama Lengkap</th> 
              <td><input type='text' class='form-control' name='a' value='$s[nama]'> </td>
            </tr>
            <tr>
              <th scope='row'>Username / Email</th> 
              <td><input type='text' class='form-control' name='b' value='$s[username]' onkeyup=\"nospaces(this)\"> </td>
            </tr>
            <tr>
              <th scope='row'>Password</th>          
              <td><input type='password' class='form-control' name='d'><small><i>Biarkan Kosong jika tidak diubah!</i></small></td>
            </tr>
            <tr>
              <th scope='row'>No Telpon</th> 
              <td><input type='number' class='form-control' name='c' value='$s[no_hp]'> </td>
            </tr>
            <tr>
              <th scope='row'>NISN</th> 
              <td><input type='number' class='form-control' name='e' value='$s[nisn]'> </td>
            </tr>
            <tr>
              <th scope='row'>Tahun Lulus</th> 
              <td><input type='number' class='form-control' name='f' value='$s[tahun_lulus]'> </td>
            </tr>
            <tr>
              <th scope='row'>Alamat</th> 
              <td><textarea class='form-control' name='g'>$s[alamat]</textarea></td>
            </tr>
          </tbody>
          </table>
        </div>
        <div class='box-footer'>
            <button type='submit' name='update' class='btn btn-info'>Update</button>
            <a href='index.php?view=profile'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
        </div>
    </form>";
} else if ($_GET['halaman']=='riwayat') {
  if (isset($_POST['edit'])) {
    $query = mysqli_query($koneksi, "UPDATE rb_lk_riwayat_tracer SET 
                                       tahun_masuk = '$_POST[a]',
                                       tahun_keluar = '$_POST[b]',
                                       gaji = '$_POST[c]' WHERE id_riwayat = '$_POST[riwayat]' AND id_traceralumni='$_POST[id]'");
  
  echo "<script>document.location='index.php?view=profile&sukses';</script>";

}

  $s = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM rb_lk_riwayat_tracer WHERE id_riwayat = '$_GET[id]' AND id_traceralumni = '$_SESSION[id]'"));
  // return print_r($_GET['id']);
  echo "<div class='alert alert-info'>Edit Profile / Akun</div><br>
  	<form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
        <div class='col-md-12'>
          <table class='table table-condensed'>
          <tbody>
            <input type='hidden' name='riwayat' value='$s[id_riwayat]'>
            <input type='hidden' name='id' value='$s[id_traceralumni]'>
            <tr>
              <th width='140px' scope='row'>Tahun Masuk</th> 
              <td><input type='number' min='1900' max='2099' class='form-control' name='a' value='$s[tahun_masuk]'> </td>
            </tr>
            <tr>
              <th scope='row'>Tahun Keluar</th> 
              <td><input type='number' max='2099' class='form-control' name='b' value='$s[tahun_keluar]' ><small><i>*Isikan dengan angka (0) jika masih bekerja</i></small></td>
            </tr>
            <tr>
              <th scope='row'>Gaji</th>          
              <td><input type='number' class='form-control' name='c' value='$s[gaji]'><small><i>isi dengan nominal langsung</i></small></td>
            </tr>
          </tbody>
          </table>
        </div>
        <div class='box-footer'>
            <button type='submit' name='edit' class='btn btn-info'>Update</button>
            <a href='index.php?view=profile'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
        </div>
    </form>
    <br/><br/>";
} else if ($_GET['halaman']=='hapus') {
  $hapus = mysqli_query($koneksi, "DELETE FROM rb_lk_riwayat_tracer WHERE id_riwayat = '$_GET[id]' OR id_traceralumni='$_POST[id]'");

  // echo "<p>$_POST[id]</p>";
}
?>

