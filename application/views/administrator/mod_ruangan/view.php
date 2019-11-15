            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Ruangan </h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_ruangan'>Tambahkan Data</a>           
                  <form style='margin-right:5px; margin-top:0px' class='pull-right' action='<?php echo base_url().$this->uri->segment(1)."/import_excel_guru/import_guru"; ?>' method='POST' enctype='multipart/form-data'>
                    <a title='Lihat Format File' class='btn-sm btn-success' href='<?php echo base_url().$this->uri->segment(1)."/download/import/format_data_ruangan.xlsx"; ?>'><span class="glyphicon glyphicon-file" aria-hidden="true"></span>Download Format File</a> 
                    <input type="file" name='fileexcel' style='padding:3px; width:250px; display:inline-block; border:1px solid #ccc; padding:3px'>
                    <input type="submit" name='tambahkan' style='margin-top:-4px' class='btn btn-info btn-sm' value='Import'>
                  </form>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Nama Gedung</th>
                        <th>Kode Ruangan</th>
                        <th>Nama Ruangan</th>
                        <th>Kapasitas Belajar</th>
                        <th>Kapasitas Ujian</th>
                        <th>Image</th>
                        <th>Aktif</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $r){
                    echo "<tr><td>$no</td>
                              <td>$r[nama_gedung]</td>
                              <td>$r[kode_ruangan]</td>
                              <td>$r[nama_ruangan]</td>
                              <td>$r[kapasitas_belajar] Orang</td>
                              <td>$r[kapasitas_ujian] Orang</td>
                              <td>
                                <center>";
                              if (trim($r['foto'])=='' OR !file_exists("asset/asset_sekolah/".$r['foto'])){
                                  echo "<img class='img-thumbnail' style='width:100px ' src='".base_url()."asset/foto_user/blank.png'>";
                                }else{
                                  echo "<img class='img-thumbnail' style='width:100px ' src='".base_url()."asset/asset_sekolah/$r[foto]'>";
                                }
                              echo"
                                </center>
                              </td>
                              <td>$r[aktif]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_ruangan/$r[id_ruangan]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_ruangan/$r[id_ruangan]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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