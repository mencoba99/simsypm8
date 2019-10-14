<?php 
$ex = explode(' ',$s['waktu_daftar']);
$tanggal = $ex[0];
$jam = $ex[1];
if ($_GET['id']==''){
  $id = $cl['id_psb_akun'];
  $nama = $cl['nama_lengkap'];
  $user = $cl['email'];
  $telp = $cl['no_telpon'];
}else{
  $id = $s['id_psb_akun'];
  $nama = $s['nama_lengkap'];
  $user = $s['email'];
  $telp = $s['no_telpon'];
}
echo "<div class='col-md-12'>
<div class='box box-info'>
    <div class='box-header with-border'>
      <h3 class='box-title'>Edit Siswa</h3>
      <a class='btn btn-sm btn-warning pull-right' href='".base_url().$this->uri->segment(1)."/pendaftaran'>Kembali</a>
    </div>
  <div class='box-body'>
      <div class='panel-body'>
                    <ul id='myTabs' class='nav nav-tabs' role='tablist'>
                      <li role='presentation' class='active'><a href='#akun' id='akun-tab' role='tab' data-toggle='tab' aria-controls='akun' aria-expanded='true'>Akun </a></li>
                      <li role='presentation' class=''><a href='#siswa' role='tab' id='siswa-tab' data-toggle='tab' aria-controls='siswa' aria-expanded='false'>Data Siswa</a></li>
                      <li role='presentation' class=''><a href='#ortu' role='tab' id='ortu-tab' data-toggle='tab' aria-controls='ortu' aria-expanded='false'>Data Orang Tua</a></li>
                      <li role='presentation' class=''><a href='#rapor' role='tab' id='rapor-tab' data-toggle='tab' aria-controls='rapor' aria-expanded='false'>Nilai Rapor</a></li>
                      <li role='presentation' class=''><a href='#nilai' role='tab' id='nilai-tab' data-toggle='tab' aria-controls='nilai' aria-expanded='false'>Nilai Ujian PSB</a></li>
                      <li role='presentation' class=''><a href='#biaya' role='tab' id='biaya-tab' data-toggle='tab' aria-controls='biaya' aria-expanded='false'>Beban Biaya</a></li>
                    </ul><br>

                    <div id='myTabContent' class='tab-content'>
                    <div role='tabpanel' class='tab-pane fade active in' id='akun' aria-labelledby='akun-tab'>
                      <form method='POST' class='form-horizontal' action='".base_url().$this->uri->segment(1)."/pendaftaran_editsiswa?id=$_GET[id]&psb=$_GET[psb]' enctype='multipart/form-data'>
                        <div class='col-md-12'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>
                            <input type='hidden' name='id' value='$id'>
                            <tr><th width='120px' scope='row'>Nama Lengkap</th> <td><input type='text' class='form-control' name='a' value='$nama'> </td></tr>
                            <tr><th width='120px' scope='row'>Username / Email</th> <td><input type='text' class='form-control' name='b' value='$user' onkeyup=\"nospaces(this)\"> </td></tr>
                            <tr><th width='120px' scope='row'>No Telpon</th> <td><input type='number' class='form-control' name='c' value='$telp'> </td></tr>
                            <tr><th scope='row'>Password</th>          <td><input type='password' class='form-control' name='d'><small><i>Biarkan Kosong jika tidak diubah!</i></small></td></tr>
                          </tbody>
                          </table>
                        </div>
                        <div class='box-footer'>
                            <button type='submit' name='update' class='btn btn-info'>Update</button>
                        </div>
                      </form>
                    </div>

                    <div role='tabpanel' class='tab-pane fade' id='siswa' aria-labelledby='siswa-tab'>";
                      if ($_GET['status']=='err'){
                        echo "<div class='alert alert-danger'>Maaf, No Pendaftaran Tersebut Sudah Terpakai! Gunakan No Pendaftaran lain yang tersedia.</div>";
                      }
                        echo "<form method='POST' class='form-horizontal' action='".base_url().$this->uri->segment(1)."/pendaftaran_editsiswa?id=$_GET[id]&psb=$_GET[psb]' enctype='multipart/form-data'>
                        <input type='hidden' name='id_pendaftaran' value='$s[id_pendaftaran]'>
                        <div class='col-md-7'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>
                            <tr><th style='background-color:#E7EAEC' width='160px' rowspan='19'>
                              <img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_user/blank.png'></th>
                            </tr>
                            <tr><th width='160px' scope='row'>No Pendaftaran</th> <td><input style='border:1px solid red' type='text' class='form-control' name='id_aktivasi' value='$s[id_aktivasi]'></td></tr>
                            <tr><th scope='row'>Password</th> <td><input type='text' style='border:1px solid red' class='form-control' name='pass' value='$s[pass]'></td></tr>

                            <tr><th scope='row'>Nama Lengkap</th> <td><input type='text' class='form-control' name='aa' value='$s[nama]'></td></tr>
                            <tr><th scope='row'>Jenis Kelamin</th> <td><select name='bb' class='form-control'>";
                                                                       $jk = $this->db->query("SELECT * FROM rb_jenis_kelamin");
                                                                       foreach ($jk->result_array() as $row) {
                                                                        if ($s['id_jenis_kelamin']==$row['id_jenis_kelamin']){
                                                                          echo "<option value='$row[id_jenis_kelamin]' selected>$row[jenis_kelamin]</option>";
                                                                        }else{
                                                                          echo "<option value='$row[id_jenis_kelamin]'>$row[jenis_kelamin]</option>";
                                                                        }
                                                                       }
                                                                       echo "</select></td></tr>
                            <tr><th scope='row'>Tempat Lahir</th> <td><input type='text' class='form-control' name='cc' value='$s[tempat_lahir]'></td></tr>
                            <tr><th scope='row'>Tanggal Lahir</th> <td><input type='text' class='form-control' name='dd' value='$s[tanggal_lahir]'></td></tr>
                            <tr><th scope='row'>Agama</th> <td><select name='ee' class='form-control'>";
                                                                       $ag = $this->db->query("SELECT * FROM rb_agama");
                                                                       foreach ($ag->result_array() as $row) {
                                                                        if ($s['id_agama']==$row['id_agama']){
                                                                          echo "<option value='$row[id_agama]' selected>$row[nama_agama]</option>";
                                                                        }else{
                                                                          echo "<option value='$row[id_agama]'>$row[nama_agama]</option>";
                                                                        }
                                                                       }
                                                                       echo "</select></td></tr>
                            <tr><th scope='row'>Alamat Siswa</th> <td><textarea class='form-control' name='ff'>$s[alamat_siswa]</textarea></td></tr>
                            <tr><th scope='row'>No Telpon</th> <td><input type='number' class='form-control' name='gg' value='$s[no_telpon]'></td></tr>
                            <tr><th scope='row'>Email</th> <td><input type='text' class='form-control' name='hh' value='$s[email]'></td></tr>
                            <tr><th scope='row'>Anak Ke / dari</th> <td><input style='display:inline-block; width:70px' type='text' class='form-control' name='ii' value='$s[anak_ke]'> 
                                                                        / <input style='display:inline-block; width:70px' type='text' class='form-control' name='jj' value='$s[jumlah_saudara]'></td></tr>
                            <tr><th scope='row'>Status</th> <td><select class='form-control' name='kk'>";
                                                                  $jk = $this->db->query("SELECT * FROM ms_status_dikeluarga");
                                                                  foreach ($jk->result_array() as $j) {
                                                                    if ($j['status_dikeluarga']==$s['status_dalam_keluarga']){
                                                                      echo "<option value='$j[status_dikeluarga]' selected>$j[status_dikeluarga]</option>";
                                                                    }else{
                                                                      echo "<option value='$j[status_dikeluarga]'>$j[status_dikeluarga]</option>";
                                                                    }
                                                                  }
                                                               echo "</select>
                            </td></tr>
                          </tbody>
                          </table>
                        </div>
                        <div class='col-md-5'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>";
                          $ex = explode('==', $s['lainnya']);
                          $jal = $this->db->query("SELECT * FROM rb_psb_pendaftaran_jalur where id_pendaftaran='$_GET[id]'")->row_array();
                          if ($jal['pilihan1']=='0'){ $pilihan1 = 'Kimia Industri'; }elseif($jal['pilihan1']=='1'){ $pilihan1 = 'Teknik Otomasi Industri'; }else{ $pilihan1 = '-'; }
                          if ($jal['pilihan2']=='0'){ $pilihan2 = 'Kimia Industri'; }elseif($jal['pilihan2']=='1'){ $pilihan2 = 'Teknik Otomasi Industri'; }else{ $pilihan2 = '-'; }
                            echo "
                            <tr><th width='120px' scope='row'>Jalur Daftar</th> <td><select name='ll' class='form-control'>";
                                                                                  $jalur = array('Seleksi Rapor','Jalur Tes');
                                                                                  for ($i=0; $i < count($jalur); $i++) { 
                                                                                    if ($jal['jalur']==$jalur[$i]){
                                                                                      echo "<option value='".$jalur[$i]."' selected>".$jalur[$i]."</option>";
                                                                                    }else{
                                                                                      echo "<option value='".$jalur[$i]."'>".$jalur[$i]."</option>";
                                                                                    }
                                                                                  }
                                                                                    echo "</select></td></tr>
                            <tr><th width='120px' scope='row'>Pilihan 1</th> <td><select class='form-control' name='mm'>";
                                                                                    $data = array('Kimia Industri','Teknik Otomasi Industri');
                                                                                    for ($i=0; $i < count($data) ; $i++) { 
                                                                                      if ($jal['pilihan1']==$i){
                                                                                        echo "<option value='$i' selected>".$data[$i]."</option>";
                                                                                      }else{
                                                                                        echo "<option value='$i'>".$data[$i]."</option>";
                                                                                      }
                                                                                    }
                                                                                echo "</select></td></tr>
                            <tr><th width='120px' scope='row'>Pilihan 2</th> <td><select class='form-control' name='nn'>";
                                                                                    $data = array('Kimia Industri','Teknik Otomasi Industri');
                                                                                    for ($i=0; $i < count($data) ; $i++) { 
                                                                                      if ($jal['pilihan2']==$i){
                                                                                        echo "<option value='$i' selected>".$data[$i]."</option>";
                                                                                      }else{
                                                                                        echo "<option value='$i'>".$data[$i]."</option>";
                                                                                      }
                                                                                    }
                                                                                echo "</select></td></tr>
                            
                            <tr><th width='120px' scope='row'>Prest. Akademik</th> <td><textarea class='form-control' name='oo'>$s[prestasi_akademik]</textarea></td></tr>
                            <tr><th width='160px' scope='row'>Prest. Non Akademik</th> <td><textarea class='form-control' name='pp'>$s[prestasi_non_akademik]</textarea></td></tr>
                            <tr><th scope='row'>Sekolah Asal</th> <td><input type='text' class='form-control' name='qq' value='$s[sekolah_asal]'></td></tr>
                            <tr><th scope='row'>No Induk (NISN)</th> <td><input type='text' class='form-control' name='rr' value='$s[no_induk]'></td></tr>
                            <tr><th scope='row'>Tahun Lulus</th> <td><input type='text' class='form-control' name='ss' value='".$ex[0]."'></td></tr>
                            <tr><th scope='row'>Akreditasi Sekolah</th> <td><input type='text' class='form-control' name='tt' value='".$ex[1]."'></td></tr>
                            <tr><th scope='row'>Tahu SMK Limakode</th> <td><input type='text' class='form-control' name='uu' value='".$ex[2]."'></td></tr>
                            <tr><th scope='row'>Longitude</th> <td><input type='text' class='form-control' name='longitude' placeholder='Dapatkan di google maps..' value='$s[longitude]'></td></tr>
                            <tr><th scope='row'>Latitude</th> <td><input type='text' class='form-control' name='latitude' placeholder='Dapatkan di google maps..' value='$s[latitude]'></td></tr>
                          </tbody>
                          </table>
                        </div>   
                        <div style='clear:both'></div>
                        <div class='box-footer'>
                            <button type='submit' name='update_siswa' class='btn btn-info'>Update</button>
                        </div>
                        </form>
                    </div>

                    <div role='tabpanel' class='tab-pane fade' id='ortu' aria-labelledby='ortu-tab'>
                        <form method='POST' class='form-horizontal' action='".base_url().$this->uri->segment(1)."/pendaftaran_editsiswa?id=$_GET[id]&psb=$_GET[psb]' enctype='multipart/form-data'>
                        <input type='hidden' name='id_pendaftaran' value='$s[id_pendaftaran]'>
                        <div class='col-md-12'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>
                            <tr bgcolor=#e3e3e3><th width='120px' scope='row'>Nama Ayah</th> <td><input type='text' class='form-control' name='aaa' value='$s[nama_ayah]'></td></tr>
                            <tr><th scope='row'>Pekerjaan</th> <td><input type='text' class='form-control' name='bbb' value='$s[pekerjaan_ayah]'></td></tr>
                            <tr><th scope='row'>Telpon Rumah</th> <td><input type='text' class='form-control' name='ccc' value='$s[telpon_rumah_ayah]'></td></tr>

                            <tr><th scope='row' coslpan='2'><br></th></tr>
                            <tr bgcolor=#e3e3e3><th width='120px' scope='row'>Nama Ibu</th> <td><input type='text' class='form-control' name='ddd' value='$s[nama_ibu]'></td></tr>
                            <tr><th scope='row'>Pekerjaan</th> <td><input type='text' class='form-control' name='eee' value='$s[pekerjaan_ibu]'></td></tr>
                            <tr><th scope='row'>Telpon Rumah</th> <td><input type='text' class='form-control' name='fff' value='$s[telpon_rumah_ibu]'></td></tr>
                          </tbody>
                          </table>
                        </div>
                        <div class='box-footer'>
                            <button type='submit' name='update_ortu' class='btn btn-info'>Update</button>
                            <a href='index.php?view=pendaftar'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                        </div>
                        </form>
                    </div>

                    <div role='tabpanel' class='tab-pane fade' id='rapor' aria-labelledby='rapor-tab'>
                        <form method='POST' class='form-horizontal' action='".base_url().$this->uri->segment(1)."/pendaftaran_editsiswa?id=$_GET[id]&psb=$_GET[psb]' enctype='multipart/form-data'>
                        <input type='hidden' name='id_pendaftaran' value='$s[id_pendaftaran]'>
                        <div class='col-md-12'>
                          <table class='table table-bordered table-striped table-condensed'>
                            <thead>
                              <tr bgcolor=#e3e3e3>
                                <th width='30px'>No</th>
                                <th>Nama Mapel</th>
                                <th>Semester 1</th>
                                <th>Semester 2</th>
                                <th>Semester 3</th>
                                <th>Semester 4</th>
                                <th>Semester 5</th>
                              </tr>
                            </thead>
                            <tbody>";
                            $tampil = $this->db->query("SELECT * FROM rb_psb_pendaftaran_rapor where id_pendaftaran='$_GET[id]'");
                            $i = 1;
                            foreach ($tampil->result_array() as $r) {
                            echo "<tr>
                                    <td>$i</td>
                                    <td><input type='text' class='form-control' style='border-radius:0px;' value='$r[nama_mapel]' name='mapel".$i."' readonly='on'></td>
                                    <td><input type='number' class='form-control' style='border-radius:0px;' name='sa".$i."' value='$r[semester1]'></td>
                                    <td><input type='number' class='form-control' style='border-radius:0px;' name='sb".$i."' value='$r[semester2]'></td>
                                    <td><input type='number' class='form-control' style='border-radius:0px;' name='sc".$i."' value='$r[semester3]'></td>
                                    <td><input type='number' class='form-control' style='border-radius:0px;' name='sd".$i."' value='$r[semester4]'></td>
                                    <td><input type='number' class='form-control' style='border-radius:0px;' name='se".$i."' value='$r[semester5]'></td>
                                  </tr>";
                              $i++;
                              }
                            echo "</tbody>
                          </table>
                        </div>
                        <div class='box-footer'>
                            <button type='submit' name='update_rapor' class='btn btn-info'>Update</button>
                        </div>
                        </form>
                    </div>

                    <div role='tabpanel' class='tab-pane fade' id='biaya' aria-labelledby='biaya-tab'>
                        <form method='POST' class='form-horizontal' action='".base_url().$this->uri->segment(1)."/pendaftaran_editsiswa?id=$_GET[id]&psb=$_GET[psb]' enctype='multipart/form-data'>
                        <div class='col-md-12'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>
                            <input type='hidden' name='id' value='$_GET[id]'>
                            <tr><th style='background-color:#E7EAEC' width='160px' rowspan='26'><img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_user/blank.png'></th>
                            </tr>
                            <tr><td>";
                              $sek = $this->db->query("SELECT * FROM rb_psb_pendaftaran where id_pendaftaran='$_GET[id]'")->row_array();
                              $_arrNilai = explode(',', $sek['beban_biaya']);
                              $keuangan = $this->db->query("SELECT * FROM rb_psb_keuangan_jenis where id_identitas_sekolah='$s[id_identitas_sekolah]' ORDER BY id_keuangan_jenis");
                              foreach ($keuangan->result_array() as $r) {
                                $_ck = (array_search($r['id_keuangan_jenis'], $_arrNilai) === false)? '' : 'checked';
                                $_del = (array_search($r['id_keuangan_jenis'], $_arrNilai) === false)? '<del>' : '';
                                  echo "<span style='display:inline-block;border-bottom: 1px dotted #8a8a8a; width:100%'><input type=checkbox name='id_keuangan_jenis[]' value='$r[id_keuangan_jenis]' $_ck> $_del $r[keuangan_jenis] <span class='pull-right' style='color:red'>$_del Rp ".rupiah($r['nominal'])."</span></span></a>";
                              }
                            echo "</td></tr>
                          </tbody>
                          </table>
                          <div class='box-footer'>
                            <button type='submit' name='update_keuangan' class='btn btn-info'>Update Beban Biaya</button>
                          </div>
                        </div>
                        </form>
                    </div>

                    <div role='tabpanel' class='tab-pane fade' id='nilai' aria-labelledby='nilai-tab'>
                        <form method='POST' class='form-horizontal' action='".base_url().$this->uri->segment(1)."/pendaftaran_editsiswa?id=$_GET[id]&psb=$_GET[psb]' enctype='multipart/form-data'>
                        <div class='col-md-12'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>
                            <input type='hidden' name='id' value='$_GET[id]'>
                            <tr bgcolor='#e3e3e3'>
                              <th width='40px'>No</th>
                              <th>Nama Ujian</th>
                              <th width='60px'>Nilai</th>
                              <th width='40px'></th>
                            </tr>

                            <tr>
                              <td width='30px'></td>
                              <td><input type='text' class='form-control' name='a'></td>
                              <td><input type='text' class='form-control' name='b'></td>
                              <td><button type='submit' name='submit' class='btn btn-sm btn-primary'><i class='fa fa-plus'></i></button></td>
                            </tr>";
                            $no = 1;
                            $tampil = $this->db->query("SELECT * FROM rb_psb_nilai where id_pendaftaran='$_GET[id]'");
                            foreach ($tampil->result_array() as $r) {
                                echo "<tr><td>$no</td>
                                        <td>$r[keterangan]</td>
                                        <td>$r[nilai]</td>
                                        <td><center>
                                          <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/pendaftaran_editsiswa?id=$_GET[id]&psb=$_GET[psb]&hapus=$r[id_psb_nilai]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                                        </center></td>
                                    </tr>";
                                $no++;
                            }
                            
                            $rata = $this->db->query("SELECT sum(nilai)/count(*) as rata_rata FROM rb_psb_nilai where id_pendaftaran='$_GET[id]'")->row_array();
                          echo "<tr bgcolor='#e3e3e3'>
                                  <th colspan='2'>Rata-rata Nilai</th>
                                  <th width='40px'>$rata[rata_rata]</th>
                                </tr>

                          </tbody>
                          </table>
                          <div class='box-footer'>
                            <button type='submit' name='update' class='btn btn-info'>Update Beban Biaya</button>
                          </div>
                        </div>
                        </form>
                    </div>
                  </div>
                </div>
  </div>
</div>
</div>";