<?php 
$cek = $this->model_app->view_where('rb_journal_list',array('kodejdwl'=>$s['kodejdwl'])); 
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Rekap Absensi Siswa</h3>
                  <a class='pull-right btn btn-warning btn-sm' href='".base_url().$this->uri->segment(1)."/absensi_siswa?tahun=$_GET[tahun]&kelas=$_GET[kelas]'>Kembali</a>
                </div>
              <div class='box-body'>
              <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='130px' scope='row'>Tahun Akademik</th> <td>$tahun[nama_tahun]</td></tr>
                    <tr><th scope='row'>Nama Kelas</th>                   <td>$kelas[nama_kelas]</td></tr>
                  </tbody>
              </table>

              <hr>
              <table class='table table-bordered table-striped'>
                <thead>
                      <tr style='background:#e3e3e3;'>
                        <th>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Pertemuan</th>
                        <th>H</th>
                        <th>S</th>
                        <th>I</th>
                        <th>A</th>
                        <th>Kehadiran</th>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$_GET['kelas'],'id_identitas_sekolah'=>$this->session->sekolah,'status_siswa'=>'Aktif'),'nama','ASC');
                    $pertemuan = $this->db->query("SELECT a.*, b.id_tahun_akademik, c.id_kelas FROM `rb_absensi_siswa` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_siswa c ON a.id_siswa=c.id_siswa where b.id_tahun_akademik='$_GET[tahun]' AND c.id_kelas='$_GET[kelas]' GROUP BY a.tanggal")->num_rows();
                    foreach ($siswa as $r) {
                    $h = $this->db->query("SELECT a.*, b.id_tahun_akademik, c.id_kelas FROM `rb_absensi_siswa` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_siswa c ON a.id_siswa=c.id_siswa where b.id_tahun_akademik='$_GET[tahun]' AND c.id_kelas='$_GET[kelas]' AND a.id_siswa='$r[id_siswa]' AND a.kode_kehadiran='H'")->num_rows();
                    $s = $this->db->query("SELECT a.*, b.id_tahun_akademik, c.id_kelas FROM `rb_absensi_siswa` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_siswa c ON a.id_siswa=c.id_siswa where b.id_tahun_akademik='$_GET[tahun]' AND c.id_kelas='$_GET[kelas]' AND a.id_siswa='$r[id_siswa]' AND a.kode_kehadiran='S'")->num_rows();
                    $i = $this->db->query("SELECT a.*, b.id_tahun_akademik, c.id_kelas FROM `rb_absensi_siswa` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_siswa c ON a.id_siswa=c.id_siswa where b.id_tahun_akademik='$_GET[tahun]' AND c.id_kelas='$_GET[kelas]' AND a.id_siswa='$r[id_siswa]' AND a.kode_kehadiran='I'")->num_rows();
                    $a = $this->db->query("SELECT a.*, b.id_tahun_akademik, c.id_kelas FROM `rb_absensi_siswa` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_siswa c ON a.id_siswa=c.id_siswa where b.id_tahun_akademik='$_GET[tahun]' AND c.id_kelas='$_GET[kelas]' AND a.id_siswa='$r[id_siswa]' AND a.kode_kehadiran='A'")->num_rows();
                    $persen = $h/$pertemuan*100;
                    if($persen<=50){ $color = 'red'; }else{ $color = 'black'; }
                    echo "<tr><td>$no</td>
                            <td>$r[nipd]</td>
                            <td>$r[nisn]</td>
                            <td>$r[nama]</td>
                            <td>$r[jenis_kelamin]</td>
                            <td>$pertemuan</td>
                            <td>$h</td>
                            <td>$s</td>
                            <td>$i</td>
                            <td>$a</td>
                            <td style='color:$color'>".number_format($persen, 2)." %</td>
                          </tr>";
                      $no++;
                      }
                    echo "<tbody>
              </table>
            </div>";
            
