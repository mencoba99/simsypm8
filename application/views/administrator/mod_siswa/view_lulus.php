            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Kelulusan Siswa</h3>
                  <?php 
          echo "</div>
                <div class='box-body'>
                <form style='margin-right:5px; margin-top:0px' action='".base_url()."".$this->uri->segment(1)."/siswa_lulus' method='GET'>
                <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Angkatan</th> <td><select name='angkatan' style='padding:4px; width:300px'>
                        <option value='' selected>- Pilih -</option>";
                            foreach ($angkatan->result_array() as $k) {
                              if ($this->input->get('angkatan')==$k['angkatan']){
                                echo "<option value='$k[angkatan]' selected>Angkatan $k[angkatan]</option>";
                              }else{
                                echo "<option value='$k[angkatan]'>Angkatan $k[angkatan]</option>";
                              }
                            }

                    echo "</select></td></tr>
                    <tr><th scope='row'>Kelas</th>                   <td><select name='kelas' style='padding:4px; width:300px'>
                         <option value=''>- Pilih -</option>";
                            foreach ($kelas as $k) {
                              if ($this->input->get('kelas')==$k['id_kelas']){
                                echo "<option value='$k[id_kelas]' selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                              }else{
                                echo "<option value='$k[id_kelas]'>$k[kode_kelas] - $k[nama_kelas]</option>";
                              }
                            }

                    echo "</select>
                          <input type='submit' style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'></td></tr>
                  </tbody>
              </table>
              </form>";

                  if (isset($_GET['sukses'])){
                      echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Sukses!</strong> - Data telah Berhasil di import,..
                          </div>";
                  }

                  echo "<form style='margin-right:5px; margin-top:0px' action='".base_url()."".$this->uri->segment(1)."/siswa_lulus' method='POST'>
                  <table class='table table-bordered table-striped'>
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th style='width:40px'>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Angkatan</th>
                        <th>Jurusan</th>
                        <th>Kelulusan</th>
                        <th>Waktu Pengumuman</th>
                      </tr>
                    </thead>
                    <tbody>";

                    $no = 1;
                    foreach ($record->result_array() as $r){
                    $wak = $this->db->query("SELECT * FROM rb_siswa_kelulusan where id_siswa='$r[id_siswa]' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
                    $ex = explode(' ',$wak['waktu_lulus']);
                    $waktu = tgl_view($ex[0]).' '.$ex[1];
                    echo "<tr><input type='hidden' value='$r[id_siswa]' name='siswa".$no."'>
                              <td>$no</td>
                              <td>$r[nipd]</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <td>$r[jenis_kelamin]</td>
                              <td>$r[angkatan]</td>
                              <td>$r[nama_jurusan]</td>";
                              if ($wak['status']=='0'){
                                 echo "<td><input type='radio' name='pilih".$no."' value='1'/> <span style='color:green'>Ya</span> &nbsp; <input type='radio' name='pilih".$no."' value='0' checked/> <span style='color:red'>Tidak</span> </td>";
                              }else{
                                 echo "<td><input type='radio' name='pilih".$no."' value='1' checked/> <span style='color:green'>Ya</span> &nbsp; <input type='radio' name='pilih".$no."' value='0'/> <span style='color:red'>Tidak</span> </td>";
                              }
                              echo "<td>$waktu</td>
                              </tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class='box-footer'>
                  <?php 
                  $ket = $this->db->query("SELECT * FROM rb_siswa_kelulusan_ket where id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
                  echo "Keterangan Lulus :<textarea class='form-control' name='lulus'>$ket[keterangan_lulus]</textarea>
                        Keterangan Tidak Lulus :<textarea class='form-control' name='tidaklulus'>$ket[keterangan_tidaklulus]</textarea><hr>";
                  if ($ket['waktu_pengumuman']=='0000-00-00 00:00:00'){
                      $waktululus = date('d-m-Y H:i:s');
                  }else{
                      $wa = explode(' ',$ket['waktu_pengumuman']);
                      $waktululus = tgl_view($wa[0]).' '.$wa[1];
                  }
                  ?>
                  <input type="hidden" name='angkatan' value='<?php echo $_GET[angkatan]; ?>'>
                  <input type="hidden" name='kelas' value='<?php echo $_GET[kelas]; ?>'>
                  <input type="text" name='waktu' style='padding:3px' value='<?php echo $waktululus; ?>'>
                  <button style='margin-top:-5px' type='submit' name='pindahkelas' class='btn btn-sm btn-info'>Proses Kelulusan</button>
                  </form>
              </div>
              </div><!-- /.box -->
            </div>