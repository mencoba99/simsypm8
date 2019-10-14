            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Tracer Study </h3>
                  <a class='pull-right btn btn-success btn-sm' style='margin-left:3px' href='<?php echo base_url().$this->uri->segment(1); ?>/excel_tracer_alumni'><span class='glyphicon glyphicon-print'></span></a>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_tracer_alumni'>Tambahkan Data</a>
                </div><!-- /.box-header -->
                
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:20px'>No</th>
                        <th>Nama / Kontak</th>
                        <th>NISN</th>
                        <th>Tahun Lulus</th>
                        <th>Alamat</th>
                        <th style='width:50px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $r){
                    echo "<tr><td style='text-align: center'>$no</td>
                              <td>$r[nama]<br>
                                  <small style='color:blue'><span class='fa fa-envelope'></span> $r[email]</small><br>
                                  <small style='color:green'><span class='fa fa-phone-square'></span> $r[no_hp]</small>
                              </td>
                              <td>$r[nisn]</td>
                              <td>$r[tahun_lulus]</td>
                              <td>$r[alamat]</td>
                              <td><center>
                                <a class='btn btn-primary btn-xs' title='Lihat Detail' href='".base_url().$this->uri->segment(1)."/detail_tracer_alumni/$r[id_traceralumni]'><span class='glyphicon glyphicon-eye-open'> Detail</span></a><br/>
                                <a style='margin-top: 3px' class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_tracer_alumni/$r[id_traceralumni]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a style='margin-top: 3px' class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_tracer_alumni/$r[id_traceralumni]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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