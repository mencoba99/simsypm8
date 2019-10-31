            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Jenis Biaya</h3>
                  <?php 
                    
                      echo "<a class='pull-right btn btn-primary btn-sm' href='".base_url().$this->uri->segment(1)."/tambah_jenis_biaya'>Tambahkan Data</a>";
                    
                  ?>
                  
                </div><!-- /.box-header -->
                <div class="box-body">               
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Jenis Biaya</th>
                        <th>Coa</th>
                        <th>Sub-Coa</th>
                        <th>Total Beban</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    if ($r['id_sub_coa']=='0'){ $sub_coa = '-'; }else{ $sub_coa = $r['nama_sub_coa']; }
                    echo "<tr><td>$no</td>
                              <td>$r[nama_jenis]</td>
                              <td>$r[nama_coa]</td>
                              <td>$sub_coa</td>
                              <td style='text-align : right;'>Rp ".number_format($r['total_beban'])."</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_jenis_biaya/$r[id_keuangan_jenis]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_jenis_biaya/$r[id_keuangan_jenis]/$_GET[tahun]/$_GET[kelas]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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