            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Tahun Akademik </h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_akademik'>Tambahkan Data</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                <div class='alert alert-info'><b>Format Kode Tahun Harus 20171</b> : Contoh <b>20171</b> artinya <b>2017</b> untuk tahun, dan <b>1</b> untuk semester</div>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Kode Tahun</th>
                        <th>Nama Tahun</th>
                        <th>Keterangan</th>
                        <th>Aktif</th>
                        <th style='width:90px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $r){
                    if ($r['aktif']=='Ya'){ $icon = 'star'; $color = 'orange'; }else{ $icon = 'star-empty'; $color = '#8a8a8a'; }
                    echo "<tr><td>$no</td>
                              <td>$r[kode_tahun_akademik]</td>
                              <td>$r[nama_tahun]</td>
                              <td>$r[keterangan]</td>
                              <td>$r[aktif]</td>
                              <td><center>
                                <a class='btn btn-default btn-xs' title='Aktifkan' href='".base_url().$this->uri->segment(1)."/aktif_akademik/$r[id_tahun_akademik]/$r[aktif]'><span style='color:$color' class='glyphicon glyphicon-$icon'></span></a>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_akademik/$r[id_tahun_akademik]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_akademik/$r[id_tahun_akademik]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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