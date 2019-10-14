            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Input Nilai Borongan Sikap Siswa</h3>
                  <?php 
                  if ($this->input->get('kelas')!=''){
                    echo "<form style='margin-right:5px; margin-top:0px' class='pull-right' action='".base_url().$this->uri->segment(1)."/import_excel_borongan_sikap/import_borongan_sikap?tahun=".$this->input->get('tahun')."&kelas=".$this->input->get('kelas')."' method='POST' enctype='multipart/form-data'>
                            <a title='Lihat Format File' href='".base_url().$this->uri->segment(1)."/export_nilai_borongan_sikap?tahun=".$this->input->get('tahun')."&kelas=".$this->input->get('kelas')."'><span class='glyphicon glyphicon-file' aria-hidden='true'></span> Format</a> 
                            <input type='file' name='fileexcel' style='padding:3px; width:250px; display:inline-block; border:1px solid #ccc; padding:3px'>
                            <input type='submit' name='tambahkan' style='margin-top:-4px' class='btn btn-info btn-sm' value='Import'>
                          </form>";
                  }
                  ?>
                </div><!-- /.box-header -->
                <div class="box-body">
                <?php 
                if ($this->session->level!='guru'){
                  echo "<form style='margin-right:5px; margin-top:0px' action='".base_url().$this->uri->segment(1)."/nilai_borongan_sikap' method='GET'>
                    <table class='table table-condensed table-hover'>
                        <tbody>
                          <tr><th width='120px' scope='row'>Tahun Akademik</th> <td><select name='tahun' style='padding:4px; width:300px'>
                          <option value=''>- Pilih -</option>";
                            foreach ($tahun as $k) {
                              if ($_GET['tahun']==$k['id_tahun_akademik']){
                                echo "<option value='$k[id_tahun_akademik]' selected>$k[nama_tahun]</option>";
                              }else{
                                echo "<option value='$k[id_tahun_akademik]'>$k[nama_tahun]</option>";
                              }
                            }

                    echo "</select></td></tr>
                          <tr><th scope='row'>Kelas</th> <td><select name='kelas' style='padding:4px; width:300px'>
                               <option value=''>- Pilih -</option>";
                                  foreach ($kelas as $k) {
                                    if ($this->input->get('kelas')==$k['id_kelas']){
                                      echo "<option value='$k[id_kelas]' selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                                    }else{
                                      echo "<option value='$k[id_kelas]'>$k[kode_kelas] - $k[nama_kelas]</option>";
                                    }
                                  }

                          echo "</select>
                                <input type='submit' style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'></td></tr>
                        </tbody>
                    </table>
                    </form>";
              }
              echo "<div class='col-md-12'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/nilai_borongan_sikap/'.$this->uri->segment(3),$attributes); 
              echo "<table class='table table-bordered table-striped'>
                <thead>
                      <tr style='background:#e3e3e3;'>
                        <th>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th><center>Spiritual</center></th>
                        <th><center>Desk. Spiritual</center></th>
                        <th><center>Sosial</center></th>
                        <th><center>Desk. Sosial</center></th>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$this->input->get('kelas'),'id_identitas_sekolah'=>$this->session->sekolah),'nama','ASC');
                    $jumls = $this->model_app->view_where('rb_siswa',array('id_kelas'=>$this->input->get('kelas')));
                    echo "<input type='hidden' name='jumlah' value='".$jumls->num_rows()."'>
                          <input type='hidden' name='id_tahun_akademik' value='".$this->input->get('tahun')."'>
                          <input type='hidden' name='id_kelas' value='".$this->input->get('kelas')."'>";
                    if ($this->input->get('kelas')!=''){
                      foreach ($siswa as $r) {
                      $a = $this->db->query("SELECT * FROM rb_nilai_borongan_sikap where id_siswa='$r[id_siswa]' AND id_tahun_akademik='".$this->input->get('tahun')."'")->row_array();
                      echo "<tr><td>$no</td>
                                <td>$r[nipd]</td>
                                <td>$r[nisn]</td>
                                <td>$r[nama]</td>
                                <input type='hidden' name='id_nilai_borongan_sikap".$no."' value='$a[id_nilai_borongan_sikap]'>
                                <input type='hidden' name='id_siswa".$no."' value='$r[id_siswa]'>
                                <td align=center><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='a".$no."' value='$a[nilai_spiritual]' style='width:90px; text-align:center; padding:0px' placeholder='-'></td>
                                <td><textarea name='b".$no."' class='form-control' style='width:100%; height:32px; color:blue' placeholder=' Tuliskan Deskripsi...' onkeyup=\"auto_grow(this)\">$a[deskripsi_spiritual]</textarea></td>
                                <td align=center><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='c".$no."' value='$a[nilai_sosial]' style='width:90px; text-align:center; padding:0px' placeholder='-'></td>
                                <td><textarea name='d".$no."' class='form-control' style='width:100%; height:32px; color:blue' placeholder=' Tuliskan Deskripsi...' onkeyup=\"auto_grow(this)\">$a[deskripsi_sosial]</textarea></td>
                            </tr>";
                        $no++;
                      }
                    }else{
                      echo "<tr><td colspan='8'><center style='padding:60px; color:red'>Silahkan Memilih Tahun akademik dan Kelas Terlebih dahulu...</center></td></tr>";
                    }
                    echo "<tbody>
              </table>";
              if ($this->input->get('kelas')!=''){
                echo "<div class='box-footer'>
                   <button type='submit' name='submit' class='btn btn-primary pull-right'>Simpan Data Penilaian</button>
                </div>";
              }
            echo "</form>
            </div>";
                ?>
          
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>