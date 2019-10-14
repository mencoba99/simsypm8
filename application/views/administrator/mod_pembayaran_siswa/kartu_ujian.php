            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Cetak Kartu Ujian Siswa </h3>
                  <form style='margin-right:5px; margin-top:0px' class='pull-right' action='' method='GET'>
                    <input type="hidden" name='view' value='kartu_ujian'>
                    <select name='tahun' style='padding:4px' required="">
                        <?php 
                            echo "<option value=''>- Pilih Tahun Akademik -</option>";
                            $tahun = $this->db->query("SELECT * FROM rb_tahun_akademik where id_identitas_sekolah='".$this->session->sekolah."'");
                            foreach ($tahun->result_array() as $k) {
                              if ($_GET['tahun']==$k['id_tahun_akademik']){
                                echo "<option value='$k[id_tahun_akademik]' selected>$k[nama_tahun]</option>";
                              }else{
                                echo "<option value='$k[id_tahun_akademik]'>$k[nama_tahun]</option>";
                              }
                            }
                        ?>
                    </select>
                    <select name='kelas' style='padding:4px' required>
                        <?php 
                            echo "<option value=''>- Pilih Kelas -</option>";
                            $kelas = $this->db->query("SELECT * FROM rb_kelas where id_identitas_sekolah='".$this->session->sekolah."'");
                            foreach ($kelas->result_array() as $k) {
                              if ($_GET['kelas']==$k['id_kelas']){
                                echo "<option value='$k[id_kelas]' selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                              }else{
                                echo "<option value='$k[id_kelas]'>$k[kode_kelas] - $k[nama_kelas]</option>";
                              }
                            }
                        ?>
                    </select>
                    <input type="submit" style='margin-top:-4px' class='btn btn-info btn-sm' value='Lihat'>
                  </form>
                </div><!-- /.box-header -->
                <div class="box-body">
                <form action='' method='POST'>
                <input type="hidden" name='kelas' value='<?php echo $_GET[kelas]; ?>'>
                <?php 
                if (isset($_GET['kelas']) AND isset($_GET['tahun'])){
                $j = $this->db->query("SELECT * FROM `rb_keuangan_jenis` a JOIN rb_kelas b ON a.id_kelas=b.id_kelas where a.id_keuangan_jenis='$_GET[biaya]' AND b.id_identitas_sekolah='".$this->session->sekolah."' AND a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]'")->row_array();
                $th = $this->db->query("SELECT * FROM rb_tahun_akademik where aktif='Ya' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
                echo "<table id='example1' class='table table-bordered table-striped'>
                    <thead>
                    <tr><th width='30px'>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Status</th>
                        <th width='60px'>Action</th>
                    </tr>
                    </thead>
                    <tbody>";

                  if ($_GET['kelas'] != '' AND $_GET['tahun'] != ''){
                    $tampil = $this->db->query("SELECT * FROM rb_siswa a LEFT JOIN rb_kelas b ON a.id_kelas=b.id_kelas 
                                              LEFT JOIN rb_jenis_kelamin c ON a.id_jenis_kelamin=c.id_jenis_kelamin
                                                  where a.id_kelas='$_GET[kelas]' ORDER BY a.id_siswa");
                  }
                    $no = 1;
                    foreach ($tampil->result_array() as $r) {
                    $beban = $this->db->query("SELECT sum(total_beban) as total_beban FROM `rb_keuangan_jenis` a JOIN rb_kelas b ON a.id_kelas=b.id_kelas where b.id_identitas_sekolah='".$this->session->sekolah."' AND a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]'")->row_array();
                    $bayar = $this->db->query("SELECT sum(total_bayar) as total FROM `rb_keuangan_bayar` where id_kelas='$_GET[kelas]' AND id_siswa='$r[id_siswa]' AND id_tahun_akademik='$_GET[tahun]'")->row_array();
                    if (($beban['total_beban']-$bayar['total']) <= 0) { $status = 'Lunas'; $class = 'green'; }else{ $status = 'Belum Lunas'; $class = 'red'; }

                    echo "<tr><td>$no</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <td>$r[jenis_kelamin]</td>
                              <td><i style='color:$class'>$status</i></td>";
                              if (($beban['total_beban']-$bayar['total']) <= 0) {
                                echo "<td><a target='_BLANK' class='btn btn-xs btn-success' href='".base_url().$this->uri->segment(1)."/print_kartu_ujian?sekolah=".$this->session->sekolah."&tahun=$_GET[tahun]&kelas=$_GET[kelas]&siswa=$r[id_siswa]'><span class='glyphicon glyphicon-print'></span> Kartu Ujian</a></td>";
                              }else{
                                echo "<td><a target='_BLANK' class='btn btn-xs btn-success' href='".base_url().$this->uri->segment(1)."/print_kartu_ujian?sekolah=".$this->session->sekolah."&tahun=$_GET[tahun]&kelas=$_GET[kelas]&siswa=$r[id_siswa]' onclick=\"return confirm('Maaf, Keuangan siswa ini belum lunas, tetap mau cetak?')\"><span class='glyphicon glyphicon-print'></span> Kartu Ujian</a></td>";
                              }
                          echo "</tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                  <?php 
                    }else{
                        echo "<center style='padding:15%; color:red'>Silahkan Memilih Tahun akademik dan kelas Terlebih dahulu...</center>";
                    }
                ?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              </form>
            </div>
