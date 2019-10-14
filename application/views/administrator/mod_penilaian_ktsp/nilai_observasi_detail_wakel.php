<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Observasi - Jurnal Sikap Wali Kelas</h3>
                </div>
              <div class='box-body'>
            <form action='".base_url().$this->uri->segment(1)."/detail_nilai_observasi_wakel/".$this->uri->segment(3)."'' method='GET' class='form-horizontal' role='form'>
                <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Tahun Akademik</th> <td>$thn[nama_tahun]</td></tr>
                    <tr><th scope='row'>Nama Kelas</th>                   <td>$s[nama_kelas]</td></tr>
                    <tr><th scope='row'>Wali Kelas</th>                         <td>$s[nama_guru]</td></tr>
                  </tbody>
              </table>
            </form>
            <hr>

            <div class='panel-body'>
              <ul id='myTabs' class='nav nav-tabs' role='tablist'>
                <li role='presentation' class='active'><a href='#praktek' id='praktek-tab' role='tab' data-toggle='tab' aria-controls='praktek' aria-expanded='true'>Penilaian Spiritual</a></li>
                <li role='presentation' class=''><a href='#produk' role='tab' id='produk-tab' data-toggle='tab' aria-controls='produk' aria-expanded='false'>Penilaian Sosial</a></li>
              </ul><br>
            <div id='myTabContent' class='tab-content'>
            <div role='tabpanel' class='tab-pane fade active in' id='praktek' aria-labelledby='praktek-tab'>
            <div class='col-md-12'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/detail_nilai_observasi_wakel/'.$this->uri->segment(3),$attributes); 
              echo "<table class='table table-bordered table-striped'>
                      <tr>
                        <th style='border:1px solid #e3e3e3' width='30px'>No</th>
                        <th style='border:1px solid #e3e3e3' width='80px'>Waktu</th>
                        <th style='border:1px solid #e3e3e3' width='190px'>Nama Lengkap</th>
                        <th style='border:1px solid #e3e3e3'><center>Kejadian / Perilaku</center></th>
                        <th style='border:1px solid #e3e3e3'><center>Butir Sikap</center></th>
                        <th style='border:1px solid #e3e3e3'><center>Pos. / Neg.</center></th>
                        <th style='border:1px solid #e3e3e3'><center>Tindak Lanjut</center></th>
                        <th></th>
                      </tr>
                    
                      <tr>
                        <input type='hidden' value='$thn[id_tahun_akademik]' name='id_tahun_akademik'>
                        <td style='border:1px solid #e3e3e3' width='30px'><input type='hidden' value='spiritual' name='status'></td>
                        <td style='border:1px solid #e3e3e3' width='120px'><input type='text' class='form-control' name='a' value='".date('d-m-Y')."'></td>
                        <td style='border:1px solid #e3e3e3' width='190px'><select name='b' style='padding:4px'>";
                                echo "<option value=''>- Pilih Siswa -</option>";
                                $siswa = $this->model_app->view_where('rb_siswa',array('id_kelas'=>$s['id_kelas']));
                                foreach ($siswa->result_array() as $k) {
                                    echo "<option value='$k[id_siswa]'>$k[nama]</option>";
                                }
                        echo "</select></td>
                        <td style='border:1px solid #e3e3e3'><textarea name='c' class='form-control' style='width:100%; height:32px;' onkeyup=\"auto_grow(this)\"></textarea></td>
                        <td style='border:1px solid #e3e3e3' width='190px'><select name='d' style='padding:4px'>";
                                echo "<option value=''>- Pilih -</option>";
                                $butir = $this->model_app->view('rb_butir_sikap');
                                foreach ($butir->result_array() as $k) {
                                    echo "<option value='$k[id_butir_sikap]'>$k[nama_butir_sikap]</option>";
                                }
                        echo "</select></td>
                        <td style='border:1px solid #e3e3e3' width='110px'><select class='form-control' name='e'>
                                                                            <option value=''>- Pilih -</option>";
                                                                            $data = array('+','-');
                                                                            for($i=0; $i<=1; $i++){
                                                                              echo "<option value='".$data[$i]."'>".$data[$i]."</option>";
                                                                            }
                                                                          echo "</select></td>
                        <td style='border:1px solid #e3e3e3'><textarea name='f' class='form-control' style='width:100%; height:32px;' onkeyup=\"auto_grow(this)\"></textarea></td>
                        <td style='border:1px solid #e3e3e3'><button type='submit' name='submit' class='btn btn-primary'><span class='glyphicon glyphicon-plus'></span></button></td>
                      </tr>

                    <tbody>";
                    $no = 1;
                    $tampil = $this->model_app->view_join_tigo_where('*','rb_nilai_sikap_butir_walikelas','rb_siswa','id_siswa','rb_butir_sikap','id_butir_sikap',array('id_kelas'=>$s['id_kelas'],'id_tahun_akademik'=>$thn['id_tahun_akademik'],'status_sikap'=>'spiritual'),'waktu_terjadi','ASC');
                    foreach ($tampil as $r){
                      echo "<tr>
                              <td>$no</td>
                              <td>".tgl_view($r['waktu_terjadi'])."</td>
                              <td>$r[nama]</td>
                              <td>$r[kejadian_perilaku]</td>
                              <td>$r[nama_butir_sikap]</td>
                              <td align=center><b>$r[positif_negatif]</b></td>
                              <td>$r[tindak_lanjut]</td>
                              <td><center><a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_nilai_observasi_wakel/$r[id_nilai_sikap_butir]/".$this->uri->segment(3)."' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a></center></td>
                              </tr>";
                        $no++;
                      }
                      echo "</tbody>
                  </table>
            </form>
            </div>
            </div>

            <div role='tabpanel' class='tab-pane fade' id='produk' aria-labelledby='produk-tab'>
               <div class='col-md-12'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/detail_nilai_observasi_wakel/'.$this->uri->segment(3),$attributes); 
              echo "<table class='table table-bordered table-striped'>
                      <tr>
                        <th style='border:1px solid #e3e3e3' width='30px'>No</th>
                        <th style='border:1px solid #e3e3e3' width='80px'>Waktu</th>
                        <th style='border:1px solid #e3e3e3' width='190px'>Nama Lengkap</th>
                        <th style='border:1px solid #e3e3e3'><center>Kejadian / Perilaku</center></th>
                        <th style='border:1px solid #e3e3e3'><center>Butir Sikap</center></th>
                        <th style='border:1px solid #e3e3e3'><center>Pos. / Neg.</center></th>
                        <th style='border:1px solid #e3e3e3'><center>Tindak Lanjut</center></th>
                        <th></th>
                      </tr>
                    
                      <tr>
                        <input type='hidden' value='$thn[id_tahun_akademik]' name='id_tahun_akademik'>
                        <td style='border:1px solid #e3e3e3' width='30px'><input type='hidden' value='sosial' name='status'></td>
                        <td style='border:1px solid #e3e3e3' width='120px'><input type='text' class='form-control' name='a' value='".date('d-m-Y')."'></td>
                        <td style='border:1px solid #e3e3e3' width='190px'><select name='b' style='padding:4px'>";
                                echo "<option value=''>- Pilih Siswa -</option>";
                                $siswa = $this->model_app->view_where('rb_siswa',array('id_kelas'=>$s['id_kelas']));
                                foreach ($siswa->result_array() as $k) {
                                    echo "<option value='$k[id_siswa]'>$k[nama]</option>";
                                }
                        echo "</select></td>
                        <td style='border:1px solid #e3e3e3'><textarea name='c' class='form-control' style='width:100%; height:32px;' onkeyup=\"auto_grow(this)\"></textarea></td>
                        <td style='border:1px solid #e3e3e3' width='190px'><select name='d' style='padding:4px'>";
                                echo "<option value=''>- Pilih -</option>";
                                $butir = $this->model_app->view('rb_butir_sikap');
                                foreach ($butir->result_array() as $k) {
                                    echo "<option value='$k[id_butir_sikap]'>$k[nama_butir_sikap]</option>";
                                }
                        echo "</select></td>
                        <td style='border:1px solid #e3e3e3' width='110px'><select class='form-control' name='e'>
                                                                            <option value=''>- Pilih -</option>";
                                                                            $data = array('+','-');
                                                                            for($i=0; $i<=1; $i++){
                                                                              echo "<option value='".$data[$i]."'>".$data[$i]."</option>";
                                                                            }
                                                                          echo "</select></td>
                        <td style='border:1px solid #e3e3e3'><textarea name='f' class='form-control' style='width:100%; height:32px;' onkeyup=\"auto_grow(this)\"></textarea></td>
                        <td style='border:1px solid #e3e3e3'><button type='submit' name='submit' class='btn btn-primary'><span class='glyphicon glyphicon-plus'></span></button></td>
                      </tr>

                    <tbody>";
                    $no = 1;
                    $tampil = $this->model_app->view_join_tigo_where('*','rb_nilai_sikap_butir_walikelas','rb_siswa','id_siswa','rb_butir_sikap','id_butir_sikap',array('id_kelas'=>$s['id_kelas'],'id_tahun_akademik'=>$thn['id_tahun_akademik'],'status_sikap'=>'sosial'),'waktu_terjadi','ASC');
                    foreach ($tampil as $r) {
                      echo "<tr>
                              <td>$no</td>
                              <td>".tgl_view($r['waktu_terjadi'])."</td>
                              <td>$r[nama]</td>
                              <td>$r[kejadian_perilaku]</td>
                              <td>$r[nama_butir_sikap]</td>
                              <td align=center><b>$r[positif_negatif]</b></td>
                              <td>$r[tindak_lanjut]</td>
                              <td><center><a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_nilai_observasi_wakel/$r[id_nilai_sikap_butir]/".$this->uri->segment(3)."' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a></center></td>
                              </tr>";
                        $no++;
                      }
                      echo "</tbody>
                  </table>
              </form>
              </div>
            </div>

            </div>
            </div>
            </div>";
  ?>
