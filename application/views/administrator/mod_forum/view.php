            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Forum Diskusi</h3>
                  <form style='margin-right:5px; margin-top:0px' class='pull-right' action='<?php echo base_url().$this->uri->segment(1); ?>/forum' method='GET'>
                    <select name='tahun' style='padding:4px'>
                        <?php 
                            echo "<option value=''>- Pilih Tahun Akademik -</option>";
                            foreach ($tahun as $k) {
                              if ($_GET['tahun']==$k['id_tahun_akademik']){
                                echo "<option value='$k[id_tahun_akademik]' selected>$k[nama_tahun]</option>";
                              }else{
                                echo "<option value='$k[id_tahun_akademik]'>$k[nama_tahun]</option>";
                              }
                            }
                        ?>
                    </select>
                    <select name='kelas' style='padding:4px'>
                        <?php 
                            echo "<option value=''>- Pilih Kelas -</option>";
                            foreach ($kelas as $k) {
                              if ($_GET['kelas']==$k['id_kelas']){
                                echo "<option value='$k[id_kelas]' selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                              }else{
                                echo "<option value='$k[id_kelas]'>$k[kode_kelas] - $k[nama_kelas]</option>";
                              }
                            }
                        ?>
                    </select>
                    <input type="submit" style='margin-top:-4px' class='btn btn-success btn-sm' value='Lihat'>
                  </form>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Jadwal Pelajaran</th>
                        <th>Kelas</th>
                        <th>Hari</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Jumlah</th>
                        <th style='width:50px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    if ($r['remedial'] == '0'){ $remedial = '<'; }elseif($r['remedial'] == '1'){ $remedial = '>='; }
                    $jumlah = $this->model_app->view_where('rb_forum_topic',array('kodejdwl'=>$r['kodejdwl']))->num_rows();
                    echo "<tr><td>$no</td>
                              <td>$r[namamatapelajaran] <br><small style='color:blue'>$r[nama_guru]</small></td>
                              <td>$r[nama_kelas]</td>
                              <td>$r[hari]</td>
                              <td>$r[jam_mulai]</td>
                              <td>$r[jam_selesai]</td>
                              <td>$jumlah Data</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Masuk Forum Diskusi' href='".base_url().$this->uri->segment(1)."/detail_forum/$r[kodejdwl]'><span class='glyphicon glyphicon-th'></span> Lihat</a>
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