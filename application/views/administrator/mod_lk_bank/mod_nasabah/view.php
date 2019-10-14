            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Nasabah</h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_nasabah'>Tambah Nasabah</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>No Rekening</th>
                        <th>Nama Nasabah</th>                        
                        <th>Saldo</th>                        
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php
                    $no = 1;
                    foreach ($record as $r){
                    $nasabah = $this->db->query("SELECT * FROM rb_lk_bankmini_nasabah a JOIN rb_siswa b ON a.id_siswa = b.id_siswa WHERE a.id_nasabah = $r[id_nasabah]")->row_array();
                    echo "<tr><td>$no</td>
                              <td>$r[no_rek]</td>
                              <td>$nasabah[nama]</td>                              
                              <td>Rp. ".rupiah($r[saldo_sekarang])."</td>                              
                              <td><center>
                               <a class='btn btn-default btn-xs' title='Detail Tabungan' href='".base_url().$this->uri->segment(1)."/detail_nasabah/$r[id_nasabah]'><span class='glyphicon glyphicon-list'></span></a>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_nasabah/$r[id_nasabah]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_nasabah/$r[id_nasabah]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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