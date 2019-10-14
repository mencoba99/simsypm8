            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Siswa</h3>
                  <?php                   
                      if (trim($this->input->get('kelas')) != ''){
                        if ($this->session->id_session=='1'){
                          echo "<a class='pull-right btn btn-danger btn-sm' style='margin-left:5px' href='index.php?view=siswa&act=deletesiswa&kelas=$_GET[kelas]&angkatan=$_GET[angkatan]' onclick=\"return confirm('Apa anda yakin untuk hapus Semua data ini?')\">Delete All</a>";
                        }
                  echo "
                  <form style='margin-left:0px; margin-top:0px' class='col-sm-6 pull-right' action='".base_url().$this->uri->segment(1)."/import_excel_siswa/import_siswa' method='POST' enctype='multipart/form-data'>
                    <a title='Lihat Format File' href='".base_url().$this->uri->segment(1)."/download/import/format_data_siswa.xls'><span class='glyphicon glyphicon-file' aria-hidden='true'></span> Format Excel</a><br>

                      <input type='hidden' name='angkatan' value='$_GET[angkatan]'>
                      <input type='hidden' name='kelas' value='$_GET[kelas]'>
                      <input type='file' name='fileexcel' style='padding:3px; width:250px; display:inline-block; border:1px solid #ccc; padding:px'>
                      <input type='submit' name='tambahkan' style='margin-top:' class='btn btn-info btn-sm' value='Import'>
                      <a style='margin-top:px; margin-left:10px;' class='btn btn-primary btn-sm' href='".base_url()."".$this->uri->segment(1)."/tambah_siswa'>Tambahkan Data</a>
                  </form>";

                      }
          echo"</div>
                <div class='box-body'>
                   <form class='col-sm-12'style='margin-top:0px' method='GET'>
                      <table class='table table-condensed table-hover'>
                        <tbody>
                          <tr>
                           <th width='120px' scope='row'>Angkatan</th> 
                              <td>
                                 <select name='angkatan' style='padding:4px; width:300px'>
                                    <option value='' selected>- Pilih -</option>";
                                        foreach ($angkatan->result_array() as $k) {
                                          if ($this->input->get('angkatan')==$k['angkatan']){
                                            echo "<option value='$k[angkatan]' selected>Angkatan $k[angkatan]</option>";
                                          }else{
                                            echo "<option value='$k[angkatan]'>Angkatan $k[angkatan]</option>";
                                          }
                                        }
                             echo "
                                 </select>
                              </td>
                          </tr>

                           <tr><th scope='row'>Kelas</th>
                              <td><select name='kelas' style='padding:4px; width:300px'>
                                  <option value=''>- Pilih -</option>";
                                     foreach ($kelas as $k) {
                                       if ($this->input->get('kelas')==$k['id_kelas']){
                                         echo "<option value='$k[id_kelas]' selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                                       }else{
                                         echo "<option value='$k[id_kelas]'>$k[kode_kelas] - $k[nama_kelas]</option>";
                                       }
                                     }
                                 echo"
                                  <input type='submit' style='margin-left: 5px;margin-right:10px' class='btn btn-info btn-sm' value='Tampilkan'>
                                  <a href='".base_url().$this->uri->segment(1)."/unduh_siswa?angkatan=".$_GET['angkatan']."&kelas=".$_GET['kelas']."' title='Unduh Data' class='btn btn-success btn-sm' >Unduh</a>
                                  <a title='Print Data Siswa' style='margin-top: px' class='btn btn-danger btn-sm' target='_BLANK' href='print/print-siswa.php?kelas=$_GET[kelas]&angkatan=$_GET[angkatan]'>Print</a>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </form>";
                 
                  if (isset($_GET['sukses'])){
                      echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Sukses!</strong> - Data telah Berhasil di import,..
                          </div>";
                  }
                  echo "<form style='margin-right:5px; margin-top:0px' action='".base_url()."".$this->uri->segment(1)."/siswa' method='POST'>
                  <table id='example1' class='table table-bordered table-striped'>
                    <thead>
                      <tr>
                        <th><input type='checkbox' onClick=\"check_semua(this)\"/></th>
                        <th style='width:40px'>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Angkatan</th>
                        <th>Sesi</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>";

                    $no = 1;
                    foreach ($record->result_array() as $r){
                    echo "<tr><td><input type='checkbox' name='pilih".$no."' value='$r[id_siswa]'/></td>
                              <td>$no</td>
                              <td>$r[nipd]</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <td>$r[jenis_kelamin]</td>
                              <td>$r[angkatan]</td>
                              <td>$r[id_sesi]</td>
                              <td>$r[nama_jurusan]</td>
                              <td>$r[status_siswa]</td>
                              <td><center>
                                <a class='btn btn-info btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_siswa/$r[id_siswa]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a style='margin-left:3px' class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_siswa/$r[id_siswa]?angkatan=$_GET[angkatan]&kelas=$_GET[kelas]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a></center></td>
                              </tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->               
                  <?php if (trim($this->input->get('kelas')) != ''){
                    ?>
                  <div class='box-footer'>
                     Pindah Ke Angkatan : 
                     <input type="hidden" name='angkatan' value='<?php echo $_GET[angkatan]; ?>'>
                     <input type="hidden" name='kelas' value='<?php echo $_GET[kelas]; ?>'>
                     <input type="number" name='angkatanpindah' style='padding:3px' placeholder='Angkatan' value='<?php echo $_GET[angkatan]; ?>'>
                        <select name='kelaspindah' style='padding:4px' required>
                           <?php 
                               echo "<option value=''>- Pilih Kelas -</option>";
                               foreach ($kelas as $k) {
                                   echo "<option value='$k[id_kelas]'>$k[kode_kelas] - $k[nama_kelas]</option>";
                               }
                           ?>
                        </select>
                     <button style='margin-top:-5px' type='submit' name='pindahkelas' class='btn btn-sm btn-info'>Proses Pindah Kelas</button>
                     </form>
                  </div>
                  <?php } ?>              
              </div><!-- /.box -->
            </div>
