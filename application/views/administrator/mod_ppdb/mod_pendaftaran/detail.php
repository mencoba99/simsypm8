<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Detail Data Siswa PSB</h3>
      <a class='btn btn-sm btn-warning pull-right' href='<?php echo base_url().$this->uri->segment(1); ?>/pendaftaran'>Kembali</a>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?php 
          $ex = explode(' ',$s['waktu_daftar']);
          $tanggal = $ex[0];
          $jam = $ex[1];
          echo "<div class='panel-body'>
                    <ul id='myTabs' class='nav nav-tabs' role='tablist'>
                      <li role='presentation' class='active'><a href='#siswa' id='siswa-tab' role='tab' data-toggle='tab' aria-controls='siswa' aria-expanded='true'>Data Siswa </a></li>
                      <li role='presentation' class=''><a href='#ortu' role='tab' id='ortu-tab' data-toggle='tab' aria-controls='ortu' aria-expanded='false'>Data Orang Tua</a></li>
                      <li role='presentation' class=''><a href='#rapor' role='tab' id='rapor-tab' data-toggle='tab' aria-controls='rapor' aria-expanded='false'>Nilai Rapor</a></li>
                      <li role='presentation' class=''><a href='#nilai' role='tab' id='nilai-tab' data-toggle='tab' aria-controls='nilai' aria-expanded='false'>Nilai Ujian PSB</a></li>
                      <li role='presentation' class=''><a href='#biaya' role='tab' id='biaya-tab' data-toggle='tab' aria-controls='biaya' aria-expanded='false'>Beban Biaya</a></li>
                    </ul><br>

                    <div id='myTabContent' class='tab-content'>
                    <div role='tabpanel' class='tab-pane fade active in' id='siswa' aria-labelledby='siswa-tab'>
                        <form class='form-horizontal'>
                        <div class='col-md-7'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>
                            <tr><th style='background-color:#E7EAEC' width='160px' rowspan='17'>
                              <img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_user/blank.png'></th>
                            </tr>
                            <tr><th width='160px' scope='row'>Nama Lengkap</th> <td>$s[nama]</td></tr>
                            <tr><th scope='row'>Jenis Kelamin</th> <td>$s[jenis_kelamin]</td></tr>
                            <tr><th scope='row'>Tempat Lahir</th> <td>$s[tempat_lahir]</td></tr>
                            <tr><th scope='row'>Tanggal Lahir</th> <td>".tgl_indo($s['tanggal_lahir'])."</td></tr>
                            <tr><th scope='row'>Agama</th> <td>$s[nama_agama]</td></tr>
                            <tr><th scope='row'>Alamat Siswa</th> <td>$s[alamat_siswa]</td></tr>
                            <tr><th scope='row'>No Telpon</th> <td>$s[no_telpon]</td></tr>
                            <tr><th scope='row'>Email</th> <td>$s[email]</td></tr>
                            <tr><th scope='row'>Anak Ke / dari</th> <td>$s[anak_ke] / $s[jumlah_saudara]</td></tr>
                            <tr><th scope='row'>Status</th> <td>$s[status_dalam_keluarga]</td></tr>
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
                            <tr class='alert alert-success'><th width='120px' scope='row'>Jalur Daftar</th> <td>".($jal['jalur'])."</td></tr>
                            <tr class='alert alert-success'><th width='120px' scope='row'>Pilihan 1</th> <td>$pilihan1</td></tr>
                            <tr class='alert alert-success'><th width='120px' scope='row'>Pilihan 2</th> <td>$pilihan2</td></tr>
                            
                            <tr><th width='120px' scope='row'>Prest. Akademik</th> <td>".nl2br($s['prestasi_akademik'])."</td></tr>
                            <tr><th width='160px' scope='row'>Prest. Non Akademik</th> <td>".nl2br($s['prestasi_non_akademik'])."</td></tr>
                            <tr><th scope='row'>Sekolah Asal</th> <td>$s[sekolah_asal]</td></tr>
                            <tr><th scope='row'>No Induk (NISN)</th> <td>$s[no_induk]</td></tr>
                            <tr><th scope='row'>Tahun Lulus</th> <td>".$ex[0]."</td></tr>
                            <tr><th scope='row'>Akreditasi Sekolah</th> <td>".$ex[1]."</td></tr>
                            <tr><th scope='row'>Tahu SMK Limakode</th> <td>".$ex[2]."</td></tr>
                            <tr><th scope='row'>Tanggal Daftar</th> <td>".tgl_indo($tanggal).", $jam Wib</td></tr>
                          </tbody>
                          </table>
                        </div>   
                        </form>
                    </div>

                    <div role='tabpanel' class='tab-pane fade' id='ortu' aria-labelledby='ortu-tab'>
                        <form class='form-horizontal'>
                        <div class='col-md-12'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>
                            <tr><th style='background-color:#E7EAEC' width='160px' rowspan='26'><img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_user/blank.png'></th>
                            </tr>
                            <tr bgcolor=#e3e3e3><th width='120px' scope='row'>Nama Ayah</th> <td>$s[nama_ayah]</td></tr>
                            <tr><th scope='row'>Pekerjaan</th> <td>$s[pekerjaan_ayah]</td></tr>
                            <tr><th scope='row'>Telpon Rumah</th> <td>$s[telpon_rumah_ayah]</td></tr>

                            <tr><th scope='row' coslpan='2'><br></th></tr>
                            <tr bgcolor=#e3e3e3><th width='120px' scope='row'>Nama Ibu</th> <td>$s[nama_ibu]</td></tr>
                            <tr><th scope='row'>Pekerjaan</th> <td>$s[pekerjaan_ibu]</td></tr>
                            <tr><th scope='row'>Telpon Rumah</th> <td>$s[telpon_rumah_ibu]</td></tr>
                          </tbody>
                          </table>
                        </div>
                        </form>
                    </div>

                    <div role='tabpanel' class='tab-pane fade' id='rapor' aria-labelledby='rapor-tab'>
                        <form class='form-horizontal'>
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
                                <th bgcolor=#FFDEAD>Rata-rata</th>                              </tr>
                            </thead>
                            <tbody>";
                            $tampil = $this->db->query("SELECT * FROM rb_psb_pendaftaran_rapor where id_pendaftaran='$_GET[id]'");
                            $no = 1;
                            foreach ($tampil->result_array() as $r) {
                            $mean = ($r[semester1] + $r[semester2] + $r[semester3] + $r[semester4] + $r[semester5]) / 5;
                            echo "<tr>
                                    <td>$no</td>
                                    <td>$r[nama_mapel]</td>
                                    <td>$r[semester1]</td>
                                    <td>$r[semester2]</td>
                                    <td>$r[semester3]</td>
                                    <td>$r[semester4]</td>
                                    <td>$r[semester5]</td>
                                    <td>$mean</td>
                                  </tr>";
                              $no++;
                              }
                            echo "</tbody>
                          </table>
                        </div>
                        </form>
                    </div>

                    <div role='tabpanel' class='tab-pane fade' id='biaya' aria-labelledby='biaya-tab'>
                        <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
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
                        </div>
                        </form>
                    </div>

                    <div role='tabpanel' class='tab-pane fade' id='nilai' aria-labelledby='nilai-tab'>
                        <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                        <div class='col-md-12'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>
                            <input type='hidden' name='id' value='$_GET[id]'>
                            <tr bgcolor='#e3e3e3'>
                              <th width='40px'>No</th>
                              <th>Nama Ujian</th>
                              <th width='60px'>Nilai</th>
                            </tr>";
                            $no = 1;
                            $tampil = $this->db->query("SELECT * FROM rb_psb_nilai where id_pendaftaran='$_GET[id]'");
                            foreach ($tampil->result_array() as $r) {
                                echo "<tr><td>$no</td>
                                        <td>$r[keterangan]</td>
                                        <td>$r[nilai]</td>
                                    </tr>";
                                $no++;
                            }

                            $rata = $this->db->query("SELECT sum(nilai)/count(*) as rata_rata FROM rb_psb_nilai where id_pendaftaran='$_GET[id]'")->row_array();
                          echo "<tr bgcolor='lightgreen'>
                                  <th colspan='2'>Rata-rata Nilai</th>
                                  <th width='40px'>$rata[rata_rata]</th>
                                </tr>

                          </tbody>
                          </table>
                        </div>
                        </form>
                    </div>
                  </div>
                </div>";
        ?>
    </div>
  </div>
</div>