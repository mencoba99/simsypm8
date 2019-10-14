<?php 
  if ($_GET['tanggal']==date('d-m-Y') OR $_GET['tanggal']==''){
    $absensi = 'Hari ini';
    $tgl = date('Y-m-d');
    $tgl_filter = date('d-m-Y');
  }else{
    $absensi = tgl_indo(tgl_simpan($_GET['tanggal']));
    $tgl = tgl_simpan($_GET['tanggal']);
    $tgl_filter = $_GET['tanggal'];
  }


    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Absensi Siswa - $absensi</h3>
                </div>
              <div class='box-body'>
              
              <form style='margin-right:5px; margin-top:0px' action='".base_url().$this->uri->segment(1)."/absensi_siswa_harian' method='GET'>
                    <table class='table table-condensed table-hover'>
                        <tbody>
                          <tr><th width='130px' scope='row'>Tahun Akademik</th> <td><select name='tahun' style='padding:4px; width:300px'>
                          <option value=''>- Pilih -</option>";
                            foreach ($tahun as $k) {
                              if ($_GET['tahun']==$k['id_tahun_akademik']){
                                echo "<option value='$k[id_tahun_akademik]' selected>$k[nama_tahun]</option>";
                              }else{
                                echo "<option value='$k[id_tahun_akademik]'>$k[nama_tahun]</option>";
                              }
                            }

                    echo "</select></td></tr>
                          <tr><th scope='row'>Kelas</th> <td><select name='kelas' style='padding:4px; width:300px'>
                               <option value=''>- Pilih -</option>";
                                  foreach ($kelas as $k) {
                                    if ($this->input->get('kelas')==$k['id_kelas']){
                                      echo "<option value='$k[id_kelas]' selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                                    }else{
                                      echo "<option value='$k[id_kelas]'>$k[kode_kelas] - $k[nama_kelas]</option>";
                                    }
                                  }

                          echo "</select></td></tr>
                                <tr><th scope='row'>Tanggal</th> <td><input type='text' name='tanggal' style='padding:4px; width:300px; display:inline-block; border:1px solid #ccc;' value='$tgl_filter' class='datepicker'>
                                <input type='submit' style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'>";
                                if ($_GET['tahun']!='' AND $_GET['kelas']!=''){
                                  echo "<a href='".base_url().$this->uri->segment(1)."/rekap_absensi_kelas_harian?tahun=$_GET[tahun]&kelas=$_GET[kelas]&tanggal=$_GET[tanggal]' style='margin-top:-4px; margin-left:3px' class='btn btn-warning btn-sm'>Rekap Perkelas</a>";
                                }
                                echo "</td></tr>
                        </tbody>
                    </table>
              </form>
              <form action='".base_url()."".$this->uri->segment(1)."/absensi_siswa_harian' method='POST'>
              <input type='hidden' name='tahun' value='$_GET[tahun]'>
              <input type='hidden' name='kelas' value='$_GET[kelas]'>
              <input type='hidden' name='tanggal' value='$_GET[tanggal]'>
              <table class='table table-bordered table-striped'>
                <thead>
                      <tr style='background:#e3e3e3;'>
                        <th>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>No Telpon Orang Tua</th>
                        <th>Catatan</th>
                        <th>Kehadiran</th>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$_GET['kelas'],'id_identitas_sekolah'=>$this->session->sekolah,'status_siswa'=>'Aktif'),'nama','ASC');
                    foreach ($siswa as $r) {
                    $a = $this->model_app->view_where('rb_absensi_siswa_harian',array('id_siswa'=>$r['id_siswa'],'tanggal'=>$tgl,'id_tahun_akademik'=>$this->input->get('tahun'),'id_kelas'=>$this->input->get('kelas')))->row_array();
                    echo "<tr><td>$no</td>
                              <td>$r[nipd]</td>
                            <td>$r[nisn]</td>
                            <td>$r[nama]</td>
                            <td>$r[jenis_kelamin]</td>
                            <td>$r[no_telpon_ayah], $r[no_telpon_ibu]</td>
                            <td><textarea name='catatan[$no]' class='form-control' style='width:100%; height:32px;' onkeyup=\"auto_grow(this)\">$a[catatan]</textarea></td>
                            <input type='hidden' value='$r[id_siswa]' name='id_siswa[$no]'>
                            <td><select style='width:100%;' name='kehadiran[$no]'>";
                                  foreach ($kehadiran->result_array() as $k) {
                                    if ($a['kode_kehadiran']==$k['kode_kehadiran']){
                                      echo "<option value='$k[kode_kehadiran]' selected>* $k[nama_kehadiran] *</option>";
                                    }else{
                                      echo "<option value='$k[kode_kehadiran]'>$k[nama_kehadiran]</option>";
                                    }
                                  }
                              echo "</select></td>
                          </tr>";
                      $no++;
                      }
                    echo "<tbody>
              </table>
              <div class='box-footer'>
                      <button type='submit' name='submit' class='btn btn-info pull-right'>Simpan Absensi dan Journal</button>
                </div>
              </form>
            </div>";
            
