            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Penilaian Diri </h3>
                </div>
                <?php
          echo "<div class='box-body'>
                <form style='margin-right:5px; margin-top:0px' action='".base_url()."".$this->uri->segment(1)."/sikap_penilaian_diri' method='GET'>
                <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Tahun Akademik</th> <td><select name='tahun' style='padding:4px; width:300px'>
                          <option value=''>- Pilih -</option>";
                            foreach ($tahun as $k) {
                              if ($_GET['tahun']==$k['id_tahun_akademik']){
                                echo "<option value='$k[id_tahun_akademik]' selected>$k[nama_tahun]</option>";
                              }else{
                                echo "<option value='$k[id_tahun_akademik]'>$k[nama_tahun]</option>";
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
              </form>

              <table class='table table-bordered table-striped'>
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Angkatan</th>
                        <th>Jurusan</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>";
                  if ($record->num_rows()<=0){
                    echo "<tr><td colspan='8'><center style='padding:60px; color:red'>Silahkan Memilih Tahun akademik dan Kelas Terlebih dahulu...</center></td></tr>";
                  }else{
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    echo "<tr><td>$no</td>
                              <td>$r[nipd]</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <td>$r[jenis_kelamin]</td>
                              <td>$r[angkatan]</td>
                              <td>$r[nama_jurusan]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Penilaian Diri' href='".base_url().$this->uri->segment(1)."/penilaian_diri_siswa/$r[id_siswa]?tahun=$_GET[tahun]'><span class='glyphicon glyphicon-th-list'></span> Detail</a>
                              </center></td>
                              </tr>";
                      $no++;
                      }
                  }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>