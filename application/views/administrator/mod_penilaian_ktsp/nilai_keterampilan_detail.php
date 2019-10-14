<?php
$kd = $this->model_app->view_where('rb_kompetensi_dasar',array('id_kompetensi_dasar'=>$this->input->get('kd')))->row_array();
if($this->input->get('tanggal')==''){ $tanggal = date('d-m-Y'); }else{ $tanggal = $this->input->get('tanggal'); }
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Input Nilai keterampilan Siswa</h3>
                  <a class='btn btn-sm btn-success pull-right' href='".base_url().$this->uri->segment(1)."/pengolahan_nilai_keterampilan/".$this->uri->segment(3)."'><span class='fa fa-calculator'></span> Pengolahan Nilai Raport</a>
                </div>
              <div class='box-body'>
            <form action='".base_url().$this->uri->segment(1)."/detail_nilai_keterampilan/".$this->uri->segment(3)."'' method='GET' class='form-horizontal' role='form'>
                <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Tahun Akademik</th> <td>$s[nama_tahun]</td></tr>
                    <tr><th scope='row'>Nama Kelas</th>                   <td>$s[nama_kelas]</td></tr>
                    <tr><th scope='row'>Mata Pelajaran</th>               <td>$s[namamatapelajaran]</td></tr>
                    <tr><th scope='row'>Guru</th>                         <td>$s[nama_guru]</td></tr>
                    <tr><th scope='row'>Komp. Dasar</th>                  <td><select name='kd' class='form-control' style='padding:4px;' onchange=\"changeValue(this.value)\">
                            <option value=''>- Pilih -</option>";
                            $jsArray = "var prdName = new Array();\n";  
                            $kompetensi_dasar = $this->model_app->view_where('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$s['id_mata_pelajaran'],'ranah'=>'keterampilan'));
                            $row = $this->model_app->view_where('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$s['id_mata_pelajaran'],'ranah'=>'keterampilan','id_kompetensi_dasar'=>$this->input->get('kd')))->row_array();
                            foreach ($kompetensi_dasar->result_array() as $k) {
                              if ($this->input->get('kd')==$k['id_kompetensi_dasar']){
                                echo "<option value='$k[id_kompetensi_dasar]' selected>$k[kompetensi_dasar]</option>";
                              }else{
                                echo "<option value='$k[id_kompetensi_dasar]'>$k[kompetensi_dasar]</option>";
                              }
                              $jsArray .= "prdName['" . $k['id_kompetensi_dasar'] . "'] = {kkm:'" .addslashes($k['kkm'])."'};\n";
                            }
                    echo "</select></td></tr>
                    <tr><th scope='row'>KKM</th>         <td><input type='text' name='kkm' class='form-control' value='$kd[kkm]' id='kkm' disabled></td></tr>
                    <tr><th scope='row'></th>            <td><input type='submit' class='btn btn-sm btn-primary' value='Tampilkan Data'></td></tr>
                  </tbody>
              </table>
            </form>
            <hr>

            <div class='panel-body'>
              <ul id='myTabs' class='nav nav-tabs' role='tablist'>
                <li role='presentation' class='active'><a href='#praktek' id='praktek-tab' role='tab' data-toggle='tab' aria-controls='praktek' aria-expanded='true'>Nilai Praktek KD $row[kd]</a></li>
                <li role='presentation' class=''><a href='#produk' role='tab' id='produk-tab' data-toggle='tab' aria-controls='produk' aria-expanded='false'>Nilai Produk KD $row[kd]</a></li>
                <li role='presentation' class=''><a href='#proyek' role='tab' id='proyek-tab' data-toggle='tab' aria-controls='proyek' aria-expanded='false'>Nilai Proyek KD $row[kd]</a></li>
                <li role='presentation' class=''><a href='#portofolio' role='tab' id='portofolio-tab' data-toggle='tab' aria-controls='portofolio' aria-expanded='false'>Nilai Portofolio KD $row[kd]</a></li>
                <li role='presentation' class=''><a href='#rekap' role='tab' id='rekap-tab' data-toggle='tab' aria-controls='rekap' aria-expanded='false'>Rekap Semua Nilai</a></li>
              </ul><br>
            <div id='myTabContent' class='tab-content'>
            <div role='tabpanel' class='tab-pane fade active in' id='praktek' aria-labelledby='praktek-tab'>
            <div class='col-md-12'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/detail_nilai_keterampilan/'.$this->uri->segment(3),$attributes); 
              echo "<table class='table table-bordered table-striped'>
                <thead>
                      <tr style='background:#e3e3e3;'>
                        <th>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th><center>Nilai Praktek</center></th>
                      </tr>
                    </thead>
                    <tbody>";
                  if ($this->input->get('kd')!=''){
                    $no = 1;
                    $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$s['id_kelas'],'id_identitas_sekolah'=>$this->session->sekolah),'nama','ASC');
                    $jumls = $this->model_app->view_where('rb_siswa',array('id_kelas'=>$s['id_kelas']));
                    echo "<input type='hidden' name='jumlah' value='".$jumls->num_rows()."'>
                          <input type='hidden' name='kd' value='".$this->input->get('kd')."'>
                          <input type='hidden' name='kodejdwl' value='".$this->uri->segment(3)."'>
                          <input type='hidden' name='kategori_nilai' value='1'>
                          <input type='hidden' name='id_tahun_akademik' value='".$s['id_tahun_akademik']."'>
                          <input type='hidden' name='id_mata_pelajaran' value='$s[id_mata_pelajaran]'>";
                    foreach ($siswa as $r) {
                    $a = $this->db->query("SELECT a.* FROM rb_nilai_keterampilan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND a.kategori_nilai='1' AND a.id_kompetensi_dasar='".$this->input->get('kd')."'")->row_array();
                    echo "<tr><td>$no</td>
                              <td>$r[nipd]</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <input type='hidden' name='id_nilai_keterampilan".$no."' value='$a[id_nilai_keterampilan]'>
                              <input type='hidden' name='id_siswa".$no."' value='$r[id_siswa]'>
                              <td align=center><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='a".$no."' value='$a[nilai1]' style='width:90px; text-align:center; padding:0px' placeholder='-'>
                                               <input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='b".$no."' value='$a[nilai2]' style='width:90px; text-align:center; padding:0px' placeholder='-'>
                                               <input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='c".$no."' value='$a[nilai3]' style='width:90px; text-align:center; padding:0px' placeholder='-'>
                                               <input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='d".$no."' value='$a[nilai4]' style='width:90px; text-align:center; padding:0px' placeholder='-'></td>
                          </tr>";
                      $no++;
                    }
                  }else{
                    echo "<tr><td colspan='5'><center style='padding:60px; color:red'>Silahkan Memilih Memilih Tanggal dan Kompetensi Dasar Terlebih dahulu...</center></td></tr>";
                  }
                    echo "<tbody>
              </table>
              <div class='box-footer'>
                 <button type='submit' name='submit' class='btn btn-primary pull-right'>Simpan Data Penilaian</button>
              </div>
            </form>
            </div>
            </div>

            <div role='tabpanel' class='tab-pane fade' id='produk' aria-labelledby='produk-tab'>
               <div class='col-md-12'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/detail_nilai_keterampilan/'.$this->uri->segment(3),$attributes); 
              echo "<table class='table table-bordered table-striped'>
                      <thead>
                      <tr style='background:#e3e3e3;'>
                        <th>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th><center>Nilai Produk</center></th>
                      </tr>
                    </thead>
                    <tbody>";
                  if ($this->input->get('kd')!=''){
                    $no = 1;
                    $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$s['id_kelas'],'id_identitas_sekolah'=>$this->session->sekolah),'nama','ASC');
                    $jumls = $this->model_app->view_where('rb_siswa',array('id_kelas'=>$s['id_kelas']));
                    echo "<input type='hidden' name='jumlah' value='".$jumls->num_rows()."'>
                          <input type='hidden' name='kd' value='".$this->input->get('kd')."'>
                          <input type='hidden' name='kodejdwl' value='".$this->uri->segment(3)."'>
                          <input type='hidden' name='kategori_nilai' value='2'>
                          <input type='hidden' name='id_tahun_akademik' value='".$s['id_tahun_akademik']."'>
                          <input type='hidden' name='id_mata_pelajaran' value='$s[id_mata_pelajaran]'>";
                    foreach ($siswa as $r) {
                    $a = $this->db->query("SELECT a.* FROM rb_nilai_keterampilan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND a.kategori_nilai='2' AND a.id_kompetensi_dasar='".$this->input->get('kd')."'")->row_array();
                    echo "<tr><td>$no</td>
                              <td>$r[nipd]</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <input type='hidden' name='id_nilai_keterampilan".$no."' value='$a[id_nilai_keterampilan]'>
                              <input type='hidden' name='id_siswa".$no."' value='$r[id_siswa]'>
                              <td align=center><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='a".$no."' value='$a[nilai1]' style='width:90px; text-align:center; padding:0px' placeholder='-'>
                                               <input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='b".$no."' value='$a[nilai2]' style='width:90px; text-align:center; padding:0px' placeholder='-'>
                                               <input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='c".$no."' value='$a[nilai3]' style='width:90px; text-align:center; padding:0px' placeholder='-'>
                                               <input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='d".$no."' value='$a[nilai4]' style='width:90px; text-align:center; padding:0px' placeholder='-'></td>
                          </tr>";
                      $no++;
                    }
                  }else{
                    echo "<tr><td colspan='5'><center style='padding:60px; color:red'>Silahkan Memilih Memilih Tanggal dan Kompetensi Dasar Terlebih dahulu...</center></td></tr>";
                  }
                    echo "<tbody>
                    </table>
                <div class='box-footer'>
                   <button type='submit' name='submit' class='btn btn-primary pull-right'>Simpan Data Penilaian</button>
                </div>
              </form>
              </div>
            </div>

            <div role='tabpanel' class='tab-pane fade' id='proyek' aria-labelledby='proyek-tab'>
               <div class='col-md-12'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/detail_nilai_keterampilan/'.$this->uri->segment(3),$attributes); 
              echo "<table class='table table-bordered table-striped'>
                      <thead>
                      <tr style='background:#e3e3e3;'>
                        <th>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th><center>Nilai Proyek</center></th>
                      </tr>
                    </thead>
                    <tbody>";
                  if ($this->input->get('kd')!=''){
                    $no = 1;
                    $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$s['id_kelas'],'id_identitas_sekolah'=>$this->session->sekolah),'nama','ASC');
                    $jumls = $this->model_app->view_where('rb_siswa',array('id_kelas'=>$s['id_kelas']));
                    echo "<input type='hidden' name='jumlah' value='".$jumls->num_rows()."'>
                          <input type='hidden' name='kd' value='".$this->input->get('kd')."'>
                          <input type='hidden' name='kodejdwl' value='".$this->uri->segment(3)."'>
                          <input type='hidden' name='kategori_nilai' value='3'>
                          <input type='hidden' name='id_tahun_akademik' value='".$s['id_tahun_akademik']."'>
                          <input type='hidden' name='id_mata_pelajaran' value='$s[id_mata_pelajaran]'>";
                    foreach ($siswa as $r) {
                    $a = $this->db->query("SELECT a.* FROM rb_nilai_keterampilan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND a.kategori_nilai='3' AND a.id_kompetensi_dasar='".$this->input->get('kd')."'")->row_array();
                    echo "<tr><td>$no</td>
                              <td>$r[nipd]</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <input type='hidden' name='id_nilai_keterampilan".$no."' value='$a[id_nilai_keterampilan]'>
                              <input type='hidden' name='id_siswa".$no."' value='$r[id_siswa]'>
                              <td align=center><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='a".$no."' value='$a[nilai1]' style='width:90px; text-align:center; padding:0px' placeholder='-'>
                                               <input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='b".$no."' value='$a[nilai2]' style='width:90px; text-align:center; padding:0px' placeholder='-'>
                                               <input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='c".$no."' value='$a[nilai3]' style='width:90px; text-align:center; padding:0px' placeholder='-'>
                                               <input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='d".$no."' value='$a[nilai4]' style='width:90px; text-align:center; padding:0px' placeholder='-'></td>
                          </tr>";
                      $no++;
                    }
                  }else{
                    echo "<tr><td colspan='5'><center style='padding:60px; color:red'>Silahkan Memilih Memilih Tanggal dan Kompetensi Dasar Terlebih dahulu...</center></td></tr>";
                  }
                    echo "<tbody>
                    </table>
                <div class='box-footer'>
                   <button type='submit' name='submit' class='btn btn-primary pull-right'>Simpan Data Penilaian</button>
                </div>
              </form>
              </div>
            </div>

            <div role='tabpanel' class='tab-pane fade' id='portofolio' aria-labelledby='portofolio-tab'>
               <div class='col-md-12'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/detail_nilai_keterampilan/'.$this->uri->segment(3),$attributes); 
              echo "<table class='table table-bordered table-striped'>
                      <thead>
                      <tr style='background:#e3e3e3;'>
                        <th>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th><center>Nilai Portofolio</center></th>
                      </tr>
                    </thead>
                    <tbody>";
                  if ($this->input->get('kd')!=''){
                    $no = 1;
                    $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$s['id_kelas'],'id_identitas_sekolah'=>$this->session->sekolah),'nama','ASC');
                    $jumls = $this->model_app->view_where('rb_siswa',array('id_kelas'=>$s['id_kelas']));
                    echo "<input type='hidden' name='jumlah' value='".$jumls->num_rows()."'>
                          <input type='hidden' name='kd' value='".$this->input->get('kd')."'>
                          <input type='hidden' name='kodejdwl' value='".$this->uri->segment(3)."'>
                          <input type='hidden' name='kategori_nilai' value='4'>
                          <input type='hidden' name='id_tahun_akademik' value='".$s['id_tahun_akademik']."'>
                          <input type='hidden' name='id_mata_pelajaran' value='$s[id_mata_pelajaran]'>";
                    foreach ($siswa as $r) {
                    $a = $this->db->query("SELECT a.* FROM rb_nilai_keterampilan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND a.kategori_nilai='4' AND a.id_kompetensi_dasar='".$this->input->get('kd')."'")->row_array();
                    echo "<tr><td>$no</td>
                              <td>$r[nipd]</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <input type='hidden' name='id_nilai_keterampilan".$no."' value='$a[id_nilai_keterampilan]'>
                              <input type='hidden' name='id_siswa".$no."' value='$r[id_siswa]'>
                              <td align=center><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='a".$no."' value='$a[nilai1]' style='width:90px; text-align:center; padding:0px' placeholder='-'>
                                               <input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='b".$no."' value='$a[nilai2]' style='width:90px; text-align:center; padding:0px' placeholder='-'>
                                               <input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='c".$no."' value='$a[nilai3]' style='width:90px; text-align:center; padding:0px' placeholder='-'>
                                               <input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='d".$no."' value='$a[nilai4]' style='width:90px; text-align:center; padding:0px' placeholder='-'></td>
                          </tr>";
                      $no++;
                    }
                  }else{
                    echo "<tr><td colspan='5'><center style='padding:60px; color:red'>Silahkan Memilih Memilih Tanggal dan Kompetensi Dasar Terlebih dahulu...</center></td></tr>";
                  }
                    echo "<tbody>
                    </table>
                <div class='box-footer'>
                   <button type='submit' name='submit' class='btn btn-primary pull-right'>Simpan Data Penilaian</button>
                </div>
              </form>
              </div>
            </div>

            <div role='tabpanel' class='tab-pane fade' id='rekap' aria-labelledby='rekap-tab'>
               <div class='col-md-12'>
                  <table class='table table-bordered table-striped'>
                      <thead>
                      <tr style='background:#e3e3e3;'>
                        <th>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th><center>Praktek</center></th>
                        <th><center>Produk</center></th>
                        <th><center>Proyek</center></th>
                        <th><center>Portofolio</center></th>
                        <th><center>Rata-rata</center></th>
                      </tr>
                    </thead>
                    <tbody>";

                    $no = 1;
                    $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$s['id_kelas'],'id_identitas_sekolah'=>$this->session->sekolah),'nama','ASC');
                    $jumls = $this->model_app->view_where('rb_siswa',array('id_kelas'=>$s['id_kelas']));
                    foreach ($siswa as $r) {
                    $remedial = $this->db->query("SELECT max(a.nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_keterampilan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND id_kompetensi_dasar='".$this->input->get('kd')."' AND id_siswa='$r[id_siswa]'")->row_array();
                    $a = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='1' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='".$this->input->get('kd')."'")->row_array();
                    $b = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='2' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='".$this->input->get('kd')."'")->row_array();
                    $c = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='3' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='".$this->input->get('kd')."'")->row_array();
                    $d = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='4' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='".$this->input->get('kd')."'")->row_array();
                    $jumlah = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='".$this->input->get('kd')."'")->num_rows();
                    $praktek = max($a['nilai1'],$a['nilai2'],$a['nilai3'],$a['nilai4']);
                    $produk = max($b['nilai1'],$b['nilai2'],$b['nilai3'],$b['nilai4']);
                    $proyek = max($c['nilai1'],$c['nilai2'],$c['nilai3'],$c['nilai4']);
                    $portofolio = max($d['nilai1'],$d['nilai2'],$d['nilai3'],$d['nilai4']);
                    $rataa = number_format(($praktek+$produk+$proyek+$portofolio)/$jumlah);
                    echo "<tr><td>$no</td>
                              <td>$r[nipd]</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <td align=center>$praktek</td>
                              <td align=center>$produk</td>
                              <td align=center>$proyek</td>
                              <td align=center>$portofolio</td>";
                              if ($row['kkm']<=$rataa){
                                echo "<td align=center><a class='btn btn-xs btn-default' href=''>".number_format($rataa)."</a></td>";
                              }else{
                                if($remedial['nilai_remedial']==''){
                                  $rata_rata = $rataa;
                                }elseif ($remedial['nilai_remedial']>$row['kkm']){
                                  $rata_rata = $row['kkm'];
                                }elseif ($remedial['nilai_remedial']<$row['kkm']){
                                  $rata_rata = $remedial['nilai_remedial'];
                                }
                                echo "<td align=center><a class='btn btn-xs btn-danger' href='' onclick=\"return popup('".base_url().$this->uri->segment(1)."/remedial_keterampilan?kodejdwl=".$this->uri->segment(3)."&kd=".$this->input->get('kd')."&siswa=$r[id_siswa]')\">".number_format($rata_rata)."</a></td>";
                              }
                          echo "</tr>";
                      $no++;
                    }

                    echo "<tbody>
                    </table>
              </div>
            </div>

            </div>
            </div>
            </div>";
  ?>

 <script type="text/javascript">    
<?php echo $jsArray; ?>  
  function changeValue(id){  
    document.getElementById('kkm').value = prdName[id].kkm;  
  };  
</script> 
