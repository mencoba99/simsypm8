<?php
$cek_lulus = $this->db->query("SELECT * FROM rb_siswa_kelulusan where id_siswa='".$this->session->id_session."' AND id_identitas_sekolah='".$this->session->sekolah."'")->num_rows();
if ($cek_lulus>=1){
    $cek_status = $this->db->query("SELECT * FROM rb_siswa_kelulusan where id_siswa='".$this->session->id_session."' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
    $ketlulus = $this->db->query("SELECT * FROM rb_siswa_kelulusan_ket where id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
    
    $timeSecond  = strtotime($ketlulus['waktu_pengumuman']);
    $timeFirst = strtotime(date('Y-m-d H:i:s'));
    $differenceInSeconds = $timeSecond - $timeFirst;
    
    $ex = explode(' ',$ketlulus['waktu_pengumuman']);
    if ($differenceInSeconds>0){
        ?>
        <center><div class='alert alert-danger'><div style='font-weight:bold' id="pesan"></div> (<?php echo tgl_indo($ex[0]).' '.$ex[1]; ?> WIB)</div></center>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>
            var url = "<?php echo base_url().''.$this->uri->segment(1); ?>/home"; // url tujuan
            var count = <?php echo $differenceInSeconds; ?>; // dalam detik
            function countDown() {
                if (count > 0) {
                    count--;
                    var waktu = count + 1;
                    $('#pesan').html('Pengumuman Kelulusan akan terbuka dalam ' + waktu + ' detik.');
                    setTimeout("countDown()", 1000);
                } else {
                    window.location.href = url;
                }
            }
            countDown();
        </script>
        <?php
    }else{
        if ($cek_status['status']=='1'){
            echo "<div class='alert alert-success'><center>Haloo <b>$users[nama]</b> <br>
                    $ketlulus[keterangan_lulus]</center>
                  </div>";
        }else{
           echo "<div class='alert alert-danger'><center>Haloo <b>$users[nama]</b> <br>
                    $ketlulus[keterangan_tidaklulus]</center>
                  </div>"; 
        }
    }
}
    echo "<div class='col-md-6'>
          <div class='box box-success'>
            <div class='box-header'>";
            if ($this->session->level2!=''){
              echo "<h3 class='box-title'>Selamat Datang di Halaman Orang Tua ".$this->session->level."</h3>";
            }else{
              echo "<h3 class='box-title'>Selamat Datang di Halaman ".$this->session->level."</h3>";
            }
            echo "<a class='btn btn-success btn-sm pull-right' href='".base_url().$this->uri->segment(1)."/edit_siswa/".$this->session->id_session."'>Edit Profile</a>
            
            </div>
            <div class='box-body'>
              <p>Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola data pada halaman ini, berikut informasi akun anda saat ini : </p>
              <dl class='dl-horizontal'>
                <dt>Email</dt>
                <dd>$users[email]</dd>

                <dt>Password</dt>
                <dd>***********</dd>

                <dt>NISN/NIPD</dt>
                <dd>$users[nisn]/$users[nipd]</dd>

                <dt>Nama Lengkap</dt>
                <dd>$users[nama]</dd>

                <dt>Alamat Email</dt>
                <dd>$users[email]</dd>

                <dt>No. Telpon</dt>
                <dd>$users[hp]</dd>

                <dt>Status</dt>
                <dd>".$this->session->level."</dd>


              </dl>
              <div style='color:#3c763d; background-color:#dff0d8; border-color:#d6e9c6' class='alert alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                <h4><i class='icon fa fa-info'></i> Info Penting!</h4>
                Diharapkan informasi akun sesuai dengan identitas pada Kartu Pengenal anda, Untuk Mengubah informasi Profile anda klik <a style='color:red' href='".base_url().$this->uri->segment(1)."/edit_siswa/".$this->session->id_session."'>disini</a>.
              </div><br>
            </div>
          </div>
        </div>

        <section class='col-lg-6 connectedSortable'>";
          // include "home_app.php";
    echo "</section>";