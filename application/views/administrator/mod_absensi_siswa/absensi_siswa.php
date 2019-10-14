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

$cek = $this->model_app->view_where('rb_journal_list',array('kodejdwl'=>$s['kodejdwl'])); 
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Absensi Siswa - $absensi</h3>
                  <form style='margin-right:5px; margin-top:0px' class='pull-right' action='".base_url()."".$this->uri->segment(1)."/detail_absensi_siswa/".$this->uri->segment(3)."' method='GET' enctype='multipart/form-data'>
                    <input type='text' name='tanggal' style='padding:4px; width:150px; display:inline-block; border:1px solid #ccc;' value='$tgl_filter' class='datepicker'>
                    <button type='submit' style='margin-top:-4px' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-search'></span> Lihat</button>
                  </form>
                </div>
              <div class='box-body'>
              <form action='".base_url()."".$this->uri->segment(1)."/detail_absensi_siswa/".$this->uri->segment(3)."' method='POST'>
              <div class='col-md-12'>
              <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='140px' scope='row'>Kelas</th>   <td><select class='form-control' name='kelas'>"; 
                                                $kelas = $this->model_app->view_where_ordering('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah),'id_kelas','ASC');
                                                foreach ($kelas as $a) {
                                                  if ($s['id_kelas']==$a['id_kelas']){
                                                    echo "<option value='$a[id_kelas]' selected>$a[nama_kelas]</option>";
                                                  }
                                                }
                                                echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Mata Pelajaran</th>   <td><select class='form-control' name='mapel'>";
                                                $mapel = $this->model_app->view_where_ordering('rb_mata_pelajaran',array('id_identitas_sekolah'=>$this->session->sekolah),'id_mata_pelajaran','DESC'); 
                                                foreach ($mapel as $a) {
                                                  if ($s['id_mata_pelajaran']==$a['id_mata_pelajaran']){
                                                    echo "<option value='$a[id_mata_pelajaran]' selected>$a[namamatapelajaran]</option>";
                                                  }
                                                }
                                                echo "</select>
                    </td></tr>
                   
                    <tr><th scope='row'>Hari</th>  <td><input type='text' class='form-control' value='".namahari($tgl)."' name='hari' readonly='on'></td></tr>
                    <tr><th scope='row'>Tanggal</th>  <td><input type='text' style='border-radius:0px; padding-left:12px' class='form-control' value='".tgl_view($tgl)."' name='tanggal' data-date-format='dd-mm-yyyy' readonly='on'></td></tr>
                    <tr><th scope='row'>Pertemuan Ke</th>  <td><input type='number' class='form-control' value='$row[jam_ke]' name='pertemuan' required></td></tr>
                    <tr><th scope='row'>Kompetensi Dasar</th>   <td><select class='form-control' name='kd' required><option value='' selected>- Pilih -</option>"; 
                                                $kdasar = $this->model_app->view_where_ordering('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$s['id_mata_pelajaran']),'id_kompetensi_dasar','ASC');
                                                foreach ($kdasar as $a) {
                                                  if ($row['id_kompetensi_dasar']==$a['id_kompetensi_dasar']){
                                                    echo "<option value='$a[id_kompetensi_dasar]' selected>$a[kd] ($a[ranah]) - $a[kompetensi_dasar]</option>";
                                                  }else{
                                                    echo "<option value='$a[id_kompetensi_dasar]'>$a[kd] ($a[ranah]) - $a[kompetensi_dasar]</option>";
                                                  }
                                                }
                                                echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Materi</th>  <td><textarea style='height:60px' class='form-control' name='materi' required>$row[materi]</textarea></td></tr>
                    <tr><th scope='row'>Keterangan</th>  <td><textarea style='height:100px'  class='form-control' name='keterangan'>$row[keterangan]</textarea></td></tr>
                    </td></tr>

                  </tbody>
              </table>
              </div>

              <hr>
              <table id='example1' class='table table-bordered table-striped'>
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
                    $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$s['id_kelas'],'id_identitas_sekolah'=>$this->session->sekolah,'status_siswa'=>'Aktif'),'nama','ASC');
                    foreach ($siswa as $r) {
                    $a = $this->model_app->view_where('rb_absensi_siswa',array('id_siswa'=>$r['id_siswa'],'tanggal'=>$tgl,'kodejdwl'=>$this->uri->segment(3)))->row_array();
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
                                      echo "<option value='$k[kode_kehadiran]' selected>* $k[nama_kehadiran]</option>";
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
            
