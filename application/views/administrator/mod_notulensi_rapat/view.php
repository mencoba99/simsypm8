            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Rapat</h3>
                  <!-- <a class='pull-right btn btn-success btn-sm' style='margin-left:3px' href='<?php echo base_url().$this->uri->segment(1); ?>/excel_tracer_alumni'><span class='glyphicon glyphicon-print'></span></a> -->
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_notulensi_rapat'>Tambahkan Data</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:20px'>No</th>
                        <th>Tanggal Rapat</th>
                        <th>Topik Rapat</th>
                        <th>Agenda Rapat</th>
                        <th>Ruang Rapat</th>
                        <th>Pembahasan</th>
                        <th>Tindak Lanjut</th>
                        <th>Peserta Rapat</th>
                        <th style='width:50px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $r){
                    echo "<tr><td>$no</td>
                              <td>".tgl_view($r['tgl_rapat'])."</td>
                              <td>$r[topik_rapat]</td>
                              <td>$r[agenda_rapat]</td>
                              <td>$r[ruang_rapat]</td>
                              <td>$r[pembahasan]</td>
                              <td>$r[tindak_lanjut]</td>
                              <td>$r[peserta_rapat]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_notulensi_rapat/$r[id_rapat]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_notulensi_rapat/$r[id_rapat]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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