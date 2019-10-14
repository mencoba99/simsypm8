            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Agenda </h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_agenda'>Tambahkan Data</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Tanggal Agenda</th>
                        <th>Nama Agenda</th>
                        <th>Tempat</th>
                        <th>Ketua Pelaksana</th>
                        <th>Sasaran</th>                        
                        <th>Dokumen <br> Klik untuk Download Dokument</th>
                        <!-- <th>Status</th> -->
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 

                    $no = 1;
                    foreach ($record as $r){
                    $cek = $this->db->query("SELECT * FROM rb_lk_agenda where id_agenda='$r[id_agenda]'")->row_array();
                    if ($cek['status']=='Pending') {
                      $color = 'warning'; 
                      $status = 'Belum Disetujui';
                    }else{ 
                      $color = 'success'; 
                      $status = 'Sudah Disetujui';
                    }       
                
                    echo "<tr><td>$no</td>
                              <td>".tgl_view($r[tgl])."</td>
                              <td>$r[nama_kegiatan]</td>
                              <td>$r[tempat]</td>
                              <td>$r[ketua_pelaksana]</td>
                              <td>$r[sasaran]</td>                              
                              <td><a href='".base_url().$this->uri->segment(1)."/unduh_agenda/$r[id_agenda]'>$r[dokumen]</a></td>                              
                              <td style='width:200px'>
                                <center>
                                  <div class='btn-group'> 
                                    <button type='button' class='btn btn-$color btn-xs'>$status</button> 
                                    <button type='button' class='btn btn-$color btn-xs dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> <span class='caret'></span> <span class='sr-only'>Toggle Dropdown</span> </button> 
                                      <ul class='dropdown-menu'> 
                                        <li><a href='".base_url().$this->uri->segment(1)."/agendaStatus?id=$r[id_agenda]&status=Pending' onclick=\"return confirm('Apa anda yakin ubah status jadi Belum Valid?')\"><span class='glyphicon glyphicon-remove'></span> Belum Valid</a></li>
                                        <li><a href='".base_url().$this->uri->segment(1)."/agendaStatus?id=$r[id_agenda]&status=Terima' onclick=\"return confirm('Apa anda yakin dokumen Sudah Valid?')\" value='btn'><span class='glyphicon glyphicon-ok'></span> Sudah Valid</a></li> 
                                      </ul>
                                  </div>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_agenda/$r[id_agenda]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_agenda/$r[id_agenda]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                                </center>
                              </td>
                              </tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>