            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Mata Pelajaran <?php if (isset($_GET['tingkat'])){ echo "Tingkat $_GET[tingkat]"; } ?> </h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_mata_pelajaran'>Tambahkan Data</a>
                  <?php if ($this->uri->segment(3)!=''){ ?>
                  <form style='margin-right:5px; margin-top:0px' class='pull-right' action='<?php echo base_url().$this->uri->segment(1)."/import_excel_mapel/import_mapel/".$this->uri->segment(3); ?>' method='POST' enctype='multipart/form-data'>
                    <a title='Lihat Format File' href='<?php echo base_url().$this->uri->segment(1)."/download/import/format_data_mapel.xls"; ?>'><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Format</a> 
                    <input type="file" name='fileexcel' style='padding:3px; width:250px; display:inline-block; border:1px solid #ccc; padding:3px'>
                    <input type="submit" name='tambahkan' style='margin-top:-4px' class='btn btn-info btn-sm' value='Import'>
                  </form>
                  <?php } ?>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <?php 
                    foreach ($tingkat as $r){
                      if ($this->uri->segment(3)==$r['id_tingkat']){
                        echo "<a class='btn btn-success btn-xs' style='margin-right:5px' href='".base_url().$this->uri->segment(1)."/mata_pelajaran/$r[id_tingkat]'>Tingkat $r[kode_tingkat]</a>";
                      }else{
                        echo "<a class='btn btn-default btn-xs' style='margin-right:5px' href='".base_url().$this->uri->segment(1)."/mata_pelajaran/$r[id_tingkat]'>Tingkat $r[kode_tingkat]</a>";
                      }
                    }
                  ?>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Kode Mapel</th>
                        <th>Nama Mapel</th>
                        <th>Jurusan</th>
                        <th>Guru Pengampu</th>
                        <th>SKM</th>
                        <th>Urutan</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                      if ($r['id_jurusan']=='0'){ $jurusan = 'Semua Jurusan'; }else{ $jurusan = $r['nama_jurusan']; }
                      if ($r['sesi']!='' AND $r['sesi']!='0'){ $alias = "<small><i style='color:red'>(Paralel)</i></small>"; }else{ $alias = ''; }
                      if ($r['karakter']!=''){ $karakter = "<small><i style='color:green'>($r[karakter])</i></small>"; }else{ $karakter = ''; }
                    echo "<tr><td>$no</td>
                              <td class='info'>$r[kode_pelajaran]</td>
                              <td>$r[namamatapelajaran] $karakter $alias</td>
                              <td>$jurusan</td>
                              <td>$r[nama_guru]</td>
                              <td>$r[kkm]</td>
                              <td>$r[urutan]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_mata_pelajaran/$r[id_mata_pelajaran]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_mata_pelajaran/$r[id_mata_pelajaran]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>                                
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