            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Predikat Penilaian Karakter</h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_predikat_karakter'>Tambahkan Data</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th>Dari Nilai</th>
                        <th>Sampai Nilai</th>
                        <th>Keterangan</th>
                        <th>Penilaian</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $r){
                    if ($r['penilaian']=='Integritas'){ $color = 'red'; }elseif ($r['penilaian']=='Religius'){ $color = 'green'; }elseif ($r['penilaian']=='Nasionalis'){ $color = 'blue'; }elseif ($r['penilaian']=='Mandiri'){ $color = 'purple'; }else{  $color = 'black'; }
                    echo "<tr><td>$r[nilaia]</td>
                              <td>$r[nilaib]</td>
                              <td>$r[keterangan]</td>
                              <td style='color:$color'>$r[penilaian]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_predikat_karakter/$r[id_predikat_karakter]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_predikat_karakter/$r[id_predikat_karakter]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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