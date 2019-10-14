            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Penilaian Sikap <?php echo $_GET['sikap']; ?></h3>
                  <?php if ($_GET['kelas']!='' AND $_GET['tahun']!='' AND $_GET['sikap']!=''){ ?>
                  <a class='btn btn-sm btn-success pull-right' href='<?php echo base_url().$this->uri->segment(1)."/pengolahan_spiritual_dan_sosial?tahun=$_GET[tahun]&kelas=$_GET[kelas]&sikap=$_GET[sikap]"; ?>'><span class='fa fa-calculator'></span> Pengolahan Nilai Sikap</a>
                  <?php } ?>
                </div>
                <?php 
          echo "<div class='box-body'>
              <div class='col-sm-7'>  
                <form style='margin-right:5px; margin-top:0px' action='".base_url()."".$this->uri->segment(1)."/spiritual_dan_sosial' method='GET'>
                <table class='table table-condensed table-hover'>
                  <tbody>";

                    $nama_tahun = ($s['nama_tahun'] =='') ? "<i><small class='text-warning'>????</small></i>" : $s['nama_tahun'];
                    $nama_kelas = ($s['nama_kelas'] =='') ? "<i><small class='text-warning'>Mapel untuk sikap $_GET[sikap] belum di set?</small></i>" : $s['nama_kelas'];
                    $nama_guru = ($s['nama_guru'] =='') ? "<i><small class='text-warning'>Mapel untuk sikap $_GET[sikap] belum di set?</small></i>" : $s['nama_guru'];
                    $namamatapelajaran = ($s['namamatapelajaran'] =='') ? "<i><small class='text-warning'>Mapel untuk sikap $_GET[sikap] belum di set?</small></i>" : $s['namamatapelajaran'];
                    echo "<tr><th width='130px' scope='row'>Tahun Akademik</th> <td> : $nama_tahun</td></tr>
                          <tr><th scope='row'>Kelas</th>              <td> : $nama_kelas</td></tr>
                          <tr><th scope='row'>Guru</th>               <td> : $nama_guru</td></tr>
                          <tr><th scope='row'>Mata Pelajaran</th>     <td> : $namamatapelajaran</td></tr>
                          <tr><th scope='row'>Aspek Penilaian</th>    <td> : <select onchange=\"this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);\" style='padding:4px; width:300px'>
                               <option value=''>- Pilih -</option>";
                                $aspek = $this->model_app->view_where('rb_aspek',array('penilaian'=>$_GET['sikap'],'id_identitas_sekolah'=>$this->session->sekolah));
                                  foreach ($aspek->result_array() as $k) {
                                    if ($this->input->get('aspek')==$k['id_aspek']){
                                      echo "<option value='$k[id_aspek]' selected>$k[nama_aspek] </option>";
                                    }else{
                                      echo "<option value='".base_url().$this->uri->segment(1)."/spiritual_dan_sosial?tahun=$_GET[tahun]&kelas=$_GET[kelas]&sikap=$_GET[sikap]&aspek=$k[id_aspek]'>$k[nama_aspek]</option>";
                                    }
                                  }

                    echo "</select></td></tr>";

                  echo "</tbody>
              </table>
              </form>
            </div>";

            echo "<div class='col-sm-5'>  
                <strong><button class='btn btn-primary btn-sm' style='width:45px; margin-bottom:3px; font-weight:bold'>OBS</button> Observasi <br>
                <button class='btn btn-info btn-sm' style='width:45px; margin-bottom:3px; font-weight:bold'>DS</button> Diri Sendiri <br>
                <button class='btn btn-success btn-sm' style='width:45px; margin-bottom:3px; font-weight:bold'>AP</button> Antar Personal (Teman) <br>
                <button class='btn btn-warning btn-sm' style='width:45px; margin-bottom:3px; font-weight:bold'>JG</button> Jurnal Guru <br>
                <button class='btn btn-danger btn-sm' style='width:45px; margin-bottom:3px; font-weight:bold'>RR</button> Rata-rata <br></strong>
            </div>";

            $attributes = array('class'=>'form-horizontal','role'=>'form');
            echo form_open_multipart($this->uri->segment(1).'/spiritual_dan_sosial',$attributes); 
            echo "<input type='hidden' name='tahun' value='$_GET[tahun]'>
                  <input type='hidden' name='kelas' value='$_GET[kelas]'>
                  <input type='hidden' name='aspek' value='$_GET[aspek]'>
                  <input type='hidden' name='kodejdwl' value='$s[kodejdwl]'>
                  <input type='hidden' name='penilaian' value='$_GET[sikap]'>
                  <table class='table table-bordered table-striped'>
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th style='width:40px'>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama siswa</th>
                        <th>OBS</th>
                        <th>DS</th>
                        <th>AP</th>
                        <th>JG</th>
                        <th>RR</th>
                      </tr>
                    </thead>
                    <tbody>";
                  if (trim($_GET['aspek'])==''){
                    echo "<tr><td colspan='9'><center style='padding:50px; color:red'>Silahkan memilih Aspek penilaian terlebih dahulu!</center></td></tr>";
                  }else{
                    if ($record->num_rows()<=0){
                      echo "<tr><td colspan='8'><center style='padding:60px; color:red'>Silahkan Memilih Tahun akademik dan Kelas Terlebih dahulu...</center></td></tr>";
                    }else{
                      $no = 1;
                      echo "<input type='hidden' name='jumlah' value='".$record->num_rows()."'>";
                      foreach ($record->result_array() as $r){
                      $a = $this->model_app->view_where('rb_nilai_sikap_spiritual_sosial',array('kodejdwl'=>$s['kodejdwl'],'id_siswa'=>$r['id_siswa'],'id_aspek'=>$this->input->get('aspek')))->row_array();
                      $rata_rata = number_format(($a['nilai1']+$a['nilai2']+$a['nilai3']+$a['nilai4'])/4);
                      echo "<tr><td>$no</td>
                                <td>$r[nipd]</td>
                                <td>$r[nisn]</td>
                                <td>$r[nama]</td>
                                <input type='hidden' name='id_siswa".$no."' value='$r[id_siswa]'>
                                <td><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='a".$no."' value='$a[nilai1]' style='width:90px; text-align:center; padding:0px' placeholder='-'></td>
                                <td><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='b".$no."' value='$a[nilai2]' style='width:90px; text-align:center; padding:0px' placeholder='-'></td>
                                <td><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='c".$no."' value='$a[nilai3]' style='width:90px; text-align:center; padding:0px' placeholder='-'></td>
                                <td><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='d".$no."' value='$a[nilai4]' style='width:90px; text-align:center; padding:0px' placeholder='-'></td>
                                <td style='color:blue'><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='e".$no."' value='$rata_rata' style='width:90px; text-align:center; padding:0px' placeholder='-' disabled></td>
                                </tr>";
                        $no++;
                        }
                    }
                  }
                  ?>
                    </tbody>
                  </table>
                  <div class='box-footer'>
                      <button type='submit' name='submit' class='btn btn-info pull-right'>Simpan Data</button>
                  </div>
                <?php 
                  echo form_close();
                ?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
