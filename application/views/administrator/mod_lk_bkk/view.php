<div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Mitra Industri </h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_alumni_bkk'>Tambahkan Data</a>
                </div><!-- /.box-header -->

                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th style='width:20px; text-align: center;'>No</th>
                        <th>Kode Mitra Kerja</th>
                        <th>Nama Instansi</th>
                        <th>Pimpinan Instansi</th>
                        <th>No Telpon</th>
                        <th>Alamat Lengkap</th>
                        <th>Status</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $r){
                    echo "<tr><td style='text-align: center;'>$no</td>
                              <td style='text-align: center;'>$r[kode_bkk]</td>
                              <td>$r[nama_instansi]</td>
                              <td>$r[pimpinan_instansi]</td>
                              <td>$r[no_telp]</td>
                              <td>$r[alamat_instansi]</td>
                              <td style='text-align: center;'>"; 
                                if ("$r[status]" === 'Aktif') {
                                    echo "<a class='btn btn-success btn-xs' title='Aktif'><span>Aktif</span></a>";
                                } else {
                                    echo "<a class='btn btn-danger btn-xs' title='Tidak Aktif'><span>Tidak Aktif</span></a>";
                                }
                              echo "</td>
                              <td><center>
                                <a class='btn btn-primary btn-xs' title='Detail' href='".base_url().$this->uri->segment(1)."/detail_alumni_bkk/$r[id_bkk]'><span class='glyphicon glyphicon-eye-open'></span></a>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_alumni_bkk/$r[id_bkk]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_alumni_bkk/$r[id_bkk]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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