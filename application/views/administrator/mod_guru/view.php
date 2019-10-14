            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Pegawai </h3>                  
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_guru'>Tambahkan Data</a>
                  <form style='margin-right:5px; margin-top:0px' class='pull-right' action='<?php echo base_url().$this->uri->segment(1)."/import_excel_guru/import_guru"; ?>' method='POST' enctype='multipart/form-data'>
                    <a title='Lihat Format File' href='<?php echo base_url().$this->uri->segment(1)."/download/import/format_data_guru.xls"; ?>'><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Format</a> 
                    <input type="file" name='fileexcel' style='padding:3px; width:250px; display:inline-block; border:1px solid #ccc; padding:3px'>
                    <input type="submit" name='tambahkan' style='margin-top:-4px' class='btn btn-info btn-sm' value='Import'>
                  </form>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>No Telpon</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    echo "<tr><td>$no</td>
                              <td>$r[nip]</td>
                              <td>$r[nama_guru]</td>
                              <td>$r[email]</td>
                              <td>$r[hp]</td>
                              <td><center>
                                <a class='btn btn-info btn-xs' title='Lihat Detail' href='".base_url().$this->uri->segment(1)."/detail_guru/$r[id_guru]'><span class='glyphicon glyphicon-search'></span></a>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_guru/$r[id_guru]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-warning btn-xs' title='Akses Khusus' href='".base_url().$this->uri->segment(1)."/akses_guru/$r[id_guru]'><span class='glyphicon glyphicon-lock'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_guru/$r[id_guru]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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