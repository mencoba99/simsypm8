            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Kasus Laboratorium </h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_labor_kasus'>Tambahkan Data</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Nama Siswa</th>
                        <th>Nama Pratikum</th>
                        <th>Tempat Praktek</th>
                        <th>Waktu Praktek</th>
                        <th>Nama Group</th>
                        <th>Status</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $r){
                    if ($r['status']=='Lunas'){ 
                      $color = "green"; 
                      $button = 'default';
                      $stat = '0';
                    }else{ 
                      $button = 'info';
                      $color = "red"; 
                      $stat = '1';
                    }
                    echo "<tr><td>$no</td>
                              <td>$r[nama]</td>
                              <td>$r[nama_pratikum]</td>
                              <td>$r[tempat_praktek]</td>
                              <td>$r[waktu_praktek]</td>
                              <td>$r[kelompok]</td>
                              <td><i style='color:$color'>$r[status]</i></td>
                              <td><center>
                                <a class='btn btn-$button btn-xs' title='Status Data' href='".base_url().$this->uri->segment(1)."/status_labor_kasus/$r[id_labor_kasus]/$stat'><span class='glyphicon glyphicon-ok'></span></a>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_labor_kasus/$r[id_labor_kasus]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_labor_kasus/$r[id_labor_kasus]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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