<?php 
  if ($_GET['tanggal']==date('d-m-Y') OR $_GET['tanggal']==''){
    $absensi = 'Hari ini';
    $tgl = date('Y-m-d');
  }else{
    $absensi = $_GET['tanggal'];
    $tgl = tgl_simpan($_GET['tanggal']);
  }
?>
            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Absensi Guru - <?php echo $absensi; ?></h3>
                  <form style='margin-right:5px; margin-top:0px' class='pull-right' action='<?php echo base_url()."".$this->uri->segment(1); ?>/absensi_guru' method='GET' enctype='multipart/form-data'>
                    <input type="text" name='tanggal' style='padding:4px; width:150px; display:inline-block; border:1px solid #ccc;' value='<?php echo date('d-m-Y'); ?>' class='datepicker'>
                    <button type="submit" style='margin-top:-4px' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-search'></span> Lihat</button>
                  </form>
                </div><!-- /.box-header -->
                <div class="box-body">
                <?php echo "<form action='".base_url()."".$this->uri->segment(1)."/absensi_guru' method='POST'>"; ?>
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Lengkap</th>
                        <th>No Telpon</th>
                        <th>Alamat Email</th>
                        <th>Kehadiran</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    echo "<input type='hidden' class='form-control' value='$tgl' name='tanggal'>";
                    $no = 1;
                    foreach ($absensi_guru->result_array() as $r){
                    $a = $this->model_app->view_where('rb_absensi_guru',array('id_guru'=>$r['id_guru'],'tanggal'=>$tgl))->row_array();
                    echo "<tr><td>$no</td>
                              <td>$r[nip]</td>
                              <td>$r[nama_guru]</td>
                              <td>$r[hp]</td>
                              <td>$r[email]</td>
                              <input type='hidden' value='$r[id_guru]' name='id_guru[$no]'>
                              <td><select style='width:100%;' name='kehadiran[$no]'>";
                                  foreach ($kehadiran->result_array() as $k) {
                                    if ($a['kode_kehadiran']==$k['kode_kehadiran']){
                                      echo "<option value='$k[kode_kehadiran]' selected>$k[nama_kehadiran]</option>";
                                    }else{
                                      echo "<option value='$k[kode_kehadiran]'>$k[nama_kehadiran]</option>";
                                    }
                                  }
                              echo "</select></td>
                            </tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                  <div class='box-footer'>
                      <button type='submit' name='submit' class='btn btn-info pull-right'>Simpan Absensi</button>
                </div>
              </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>