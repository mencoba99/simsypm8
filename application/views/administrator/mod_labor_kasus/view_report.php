            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">laporan Kasus Laboratorium </h3>
                  <a class='btn btn-success btn-sm pull-right' target='_BLANK' href='<?php echo base_url().$this->uri->segment(1); ?>/print_laporan_laboratorium'><span class='glyphicon glyphicon-print'></span> Print Belum Lunas</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:20px'>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Nama Alat</th>
                        <th>Status</th>
                        <th width='80px'></th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $r){
                    $kls = $this->model_app->view_where('rb_kelas',array('id_kelas'=>$r['id_kelas']))->row_array();
                    $alat = $this->db->query("SELECT GROUP_CONCAT(DISTINCT nama_alat SEPARATOR ', ') as nama_semua_alat FROM rb_labor_kasus_detail where id_labor_kasus='$r[id_labor_kasus]'")->row_array();
                    if ($r['status']=='Lunas'){ $color = "green"; }else{ $color = "red"; }
                    echo "<tr><td>$no</td>
                              <td><b>$r[nama]</b> <br>$r[anggota_kelompok]</td>
                              <td>$kls[nama_kelas]</td>
                              <td>$alat[nama_semua_alat]</td>
                              <td><i style='color:$color'>$r[status]</i></td>
                              <td><center>
                                <a class='btn btn-success btn-xs' target='_BLANK' title='Print Data' href='".base_url().$this->uri->segment(1)."/print_labor_kasus/$r[id_labor_kasus]'><span class='glyphicon glyphicon-print'></span> Print Notice</a>
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