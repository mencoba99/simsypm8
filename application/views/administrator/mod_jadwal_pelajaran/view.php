            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Jadwal Pelajaran</h3>
                  <?php 
                    if (isset($_GET['tahun']) AND isset($_GET['kelas'])){
                      echo "<a class='pull-right btn btn-primary btn-sm' href='".base_url().$this->uri->segment(1)."/tambah_jadwal_pelajaran?tahun=$_GET[tahun]&kelas=$_GET[kelas]'>Tambahkan Data</a>
                            <a class='pull-right btn btn-default btn-sm' style='margin-right:3px' role='button' data-toggle='collapse' href='#collapseExample' aria-expanded='false' aria-controls='collapseExample'><span class='glyphicon glyphicon-menu-down'></span></a>
                            <form id='collapseExample' style='margin-top:-6px;' class='pull-right collapse' action='".base_url().$this->uri->segment(1)."/jadwal_pelajaran' method='POST'>
                            <table class='table table-condensed table-hover' style='margin-bottom:0px'>
                                <tbody>
                                <input type='hidden' value='$_GET[tahun]' name='tahun'>
                                <input type='hidden' value='$_GET[kelas]' name='kelas'>
                                <tr><td><select name='transfer_tahun' style='padding:4px'>
                                  <option value=''>- Pilih -</option>";
                                    foreach ($tahun as $k) {
                                      if ($_GET['tahun']==$k['id_tahun_akademik']){
                                        echo "<option value='$k[id_tahun_akademik]' selected>$k[nama_tahun]</option>";
                                      }else{
                                        echo "<option value='$k[id_tahun_akademik]'>$k[nama_tahun]</option>";
                                      }
                                    }
                            echo "</select>
                                  <select name='transfer_kelas' style='padding:4px'>
                                       <option value=''>- Pilih -</option>";
                                          foreach ($kelas as $k) {
                                            if ($this->input->get('kelas')==$k['id_kelas']){
                                              echo "<option value='$k[id_kelas]' selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                                            }else{
                                              echo "<option value='$k[id_kelas]'>$k[kode_kelas] - $k[nama_kelas]</option>";
                                            }
                                          }
                                  echo "</select>
                                        <input type='submit' name='transfer' style='margin-top:-4px' class='btn btn-danger btn-sm' value='Transferkan Jadwal'></td></tr>
                                </tbody>
                            </table>
                            </form>";
                    }
                  ?>

                   <form style='margin-right:5px; margin-top:0px' class='pull-right' action='<?php echo base_url().$this->uri->segment(1)."/import_excel_jadwal/import_jadwal/".$this->uri->segment(3); ?>' method='POST' enctype='multipart/form-data'>
                    <?php echo"<a title='Lihat Format File' href='".base_url().$this->uri->segment(1)."/download/import/format_import_jadwal_pelajaran.xlsx'><span class='glyphicon glyphicon-file' aria-hidden='true'></span> Format</a>" ?>
                    <input type="file" name='fileexcel' style='padding:3px; width:250px; display:inline-block; border:1px solid #ccc; padding:3px'>
                    <input type="submit" name='tambahkan' style='margin-top:-4px' class='btn btn-info btn-sm' value='Import'>
                  </form>

                </div><!-- /.box-header -->
                <div class="box-body">

                <?php

                  echo "<form style='margin-right:5px; margin-top:0px' action='".base_url().$this->uri->segment(1)."/jadwal_pelajaran' method='GET'>
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
                          echo "</select>
                                <input type='submit' style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'></td></tr>
                        </tbody>
                    </table>
                    </form>";
                ?>
                  <table id="example1" class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Nama Mapel</th>
                        <th>Kelas</th>
                        <th>Hari</th>
                        <th>Jam ke</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Ruangan</th>
                        <th style='width:140px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    if ($r['remedial'] == '0'){ $remedial = '<'; }elseif($r['remedial'] == '1'){ $remedial = '>='; }
                    if ($cek['kode_jurusan']!=''){ $kode_jurusan = "($cek[kode_jurusan])"; }else{ $kode_jurusan = ''; }
                    echo "<tr><td>$no</td>
                              <td><span style='color:red'>$r[kode_pelajaran]</span> - $r[namamatapelajaran] $kode_jurusan<br> <small style='color:blue'>$r[nama_guru]</small></td>
                              <td>$r[nama_kelas]</td>
                              <td>$r[hari]</td>
                              <td>$r[jam_ke]</td>
                              <td>$r[jam_mulai]</td>
                              <td>$r[jam_selesai]</td>
                              <td>$r[nama_ruangan]</td>
                              <td><center>
                                <a class='btn btn-xs btn-primary' href='".base_url().$this->uri->segment(1)."/predikat_jadwal_pelajaran/$r[id_mata_pelajaran]'>Predikat</a>
                                <a class='btn btn-xs btn-warning' href='".base_url().$this->uri->segment(1)."/detail_absensi_siswa/$r[kodejdwl]' title='Absensi Siswa'><span class='glyphicon glyphicon-saved'></span></a>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_jadwal_pelajaran/$r[kodejdwl]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_jadwal_pelajaran/$r[kodejdwl]/$_GET[tahun]/$_GET[kelas]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>
                              </tr>";
                      $no++;
                      }
                  ?>

                    </tbody>

                  </table>

                </div><!-- /.box-body -->

              </div><!-- /.box -->

            </div>