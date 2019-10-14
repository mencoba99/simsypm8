<?php 
    echo "<div class='col-xs-12'>  
              <div class='box'>
                <div class='box-header'>
                  <h3 class='box-title'>Cetak Raport Akhir Semester </h3>
              </div>
                <div class='box-body'>
                <form style='margin-right:5px; margin-top:0px' action='".base_url()."".$this->uri->segment(1)."/cetak_semester' method='GET'>
                <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='130px' scope='row'>Angkatan</th> <td><select name='angkatan' style='padding:4px; width:300px'>
                        <option value='' selected>- Pilih -</option>";
                            foreach ($angkatan->result_array() as $k) {
                              if ($this->input->get('angkatan')==$k['angkatan']){
                                echo "<option value='$k[angkatan]' selected>Angkatan $k[angkatan]</option>";
                              }else{
                                echo "<option value='$k[angkatan]'>Angkatan $k[angkatan]</option>";
                              }
                            }

                    echo "</select>";
                  if($this->session->level!='guru'){
                    echo "<tr><th scope='row'>Kelas</th>                   <td><select name='kelas' style='padding:4px; width:300px'>
                         <option value=''>- Pilih -</option>";
                            foreach ($kelas as $k) {
                              if ($this->input->get('kelas')==$k['id_kelas']){
                                echo "<option value='$k[id_kelas]' selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                              }else{
                                echo "<option value='$k[id_kelas]'>$k[kode_kelas] - $k[nama_kelas]</option>";
                              }
                            }

                    echo "</select></td></tr>
                    <tr><th scope='row'>Tahun Akademik</th>                   <td><select name='tahun' style='padding:4px; width:300px'>
                         <option value=''>- Pilih -</option>";
                            foreach ($tahun as $k) {
                              if ($this->input->get('tahun')==$k['id_tahun_akademik']){
                                echo "<option value='$k[id_tahun_akademik]' selected>$k[kode_tahun_akademik] - $k[nama_tahun]</option>";
                              }else{
                                echo "<option value='$k[id_tahun_akademik]'>$k[kode_tahun_akademik] - $k[nama_tahun]</option>";
                              }
                            }

                    echo "</select> <input type='submit' style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'></td></tr>";
                  }else{
                    echo " <input type='submit' style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'></td></tr>
                          <input type='hidden' name='kelas' value='".$this->input->get('kelas')."'>
                          <input type='hidden' name='tahun' value='".$this->input->get('tahun')."'>";
                  }
           echo "</tbody>
              </table>
              </form>
              <table class='table table-bordered table-striped'>
                  <thead>
                    <tr bgcolor=#e3e3e3>
                      <th style='width:40px'>No</th>
                      <th>NIPD</th>
                      <th>NISN</th>
                      <th>Nama siswa</th>
                      <th>Jenis Kelamin</th>
                      <th width='230px'>Action</th>
                    </tr>
                  </thead>
                  <tbody>";
                if ($this->input->get('angkatan')!='' AND $this->input->get('kelas')!='' AND $this->input->get('tahun')!=''){
                $kel = $this->db->query("SELECT b.kode_kurikulum, c.directory FROM rb_kelas a JOIN rb_tingkat b ON a.id_tingkat=b.id_tingkat JOIN rb_raport c ON b.id_raport=c.id_raport where a.id_kelas='$_GET[kelas]'")->row_array();
                  $no = 1;
                  foreach ($record->result_array() as $r){
                  echo "<tr><td>$no</td>
                            <td>$r[nipd]</td>
                            <td>$r[nisn]</td>
                            <td>$r[nama]</td>
                            <td>$r[jenis_kelamin]</td>
                            <td><center><a class='btn btn-success btn-xs' target='_BLANK' title='Raport Halaman 1' href='".base_url().$this->uri->segment(1)."/cetak_semester_raport?angkatan=$_GET[angkatan]&kelas=$_GET[kelas]&tahun=$_GET[tahun]&siswa=$r[id_siswa]&page=1'><span class='glyphicon glyphicon-print'></span> 1</a>
                              <a class='btn btn-success btn-xs' target='_BLANK' title='Raport Halaman 2' href='".base_url().$this->uri->segment(1)."/cetak_semester_raport?angkatan=$_GET[angkatan]&kelas=$_GET[kelas]&tahun=$_GET[tahun]&siswa=$r[id_siswa]&page=2'><span class='glyphicon glyphicon-print'></span> 2</a>
                              <a class='btn btn-success btn-xs' target='_BLANK' title='Raport Halaman 3' href='".base_url().$this->uri->segment(1)."/cetak_semester_raport?angkatan=$_GET[angkatan]&kelas=$_GET[kelas]&tahun=$_GET[tahun]&siswa=$r[id_siswa]&page=3'><span class='glyphicon glyphicon-print'></span> 3</a>
                              <a class='btn btn-success btn-xs' target='_BLANK' title='Raport Halaman 4' href='".base_url().$this->uri->segment(1)."/cetak_semester_raport?angkatan=$_GET[angkatan]&kelas=$_GET[kelas]&tahun=$_GET[tahun]&siswa=$r[id_siswa]&page=4'><span class='glyphicon glyphicon-print'></span> 4</a>
                              <a class='btn btn-success btn-xs' target='_BLANK' title='Raport Halaman 5' href='".base_url().$this->uri->segment(1)."/cetak_semester_raport?angkatan=$_GET[angkatan]&kelas=$_GET[kelas]&tahun=$_GET[tahun]&siswa=$r[id_siswa]&page=5'><span class='glyphicon glyphicon-print'></span> 5</a>
                              <a class='btn btn-success btn-xs' target='_BLANK' title='Raport Halaman 6' href='".base_url().$this->uri->segment(1)."/cetak_semester_raport?angkatan=$_GET[angkatan]&kelas=$_GET[kelas]&tahun=$_GET[tahun]&siswa=$r[id_siswa]&page=6'><span class='glyphicon glyphicon-print'></span> 6</a>
                            </center></td>
                        </tr>";
                    $no++;
                    }
                  }else{
                    echo "<tr><td colspan='8'><center style='padding:60px; color:red'>Silahkan Memilih Memilih Angkatan, Kelas dan Tahun Akademik Terlebih dahulu...</center></td></tr>";
                  }
                    echo "</tbody>
                  </table>
                </div>
              </div>
            </div>";