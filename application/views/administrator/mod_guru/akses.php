            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Hak Akses Khusus Guru </h3>
                  <?php 
                    $attributes = array('class'=>'form-horizontal pull-right','style'=>'margin-right:5px; margin-top:0px');
                    echo form_open_multipart($this->uri->segment(1).'/akses_guru/'.$this->uri->segment(3),$attributes); 
                    echo "<select name='modul' style='padding:4px'>
                          <option value='' selected>- Pilih Modul -</option>";
                          $nom = 1;
                          foreach ($record->result_array() as $m){
                            echo "<option value='$m[id_modul]'>$nom. $m[nama_modul]</option>";
                            $nom++;
                          }
                      echo "</select>
                      <input type='submit' name='submit' style='margin-top:-4px' class='btn btn-primary btn-sm' value='Tambahkan'>
                    </form>";
                  ?>
                </div>
                <div class="box-body">
                    <?php 
                      echo "<div class='col-md-12'>
                            <table class='table table-condensed table-hover'>
                                <tbody>
                                  <tr><th width='120px' scope='row'>NIP</th> <td>$s[nip]</td></tr>
                                  <tr><th scope='row'>Nama Guru</th>           <td>$s[nama_guru]</td></tr>
                                </tbody>
                            </table>

                            <table id='example' class='table table-bordered table-striped'>
                              <thead>
                                <tr>
                                  <th style='width:20px'>No</th>
                                  <th>Nama Modul</th>
                                  <th>URL Modul</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>";
                              $no = 1;
                              foreach ($akses as $r){
                              echo "<tr><td>$no</td>
                                        <td>$r[nama_modul]</td>
                                        <td><a href='".base_url().$this->uri->segment(1)."/$r[url]'>".base_url().$this->uri->segment(1)."/$r[url]</a></td>
                                        <td style='width:80px !important'><center>
                                            <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/akses_hapus/$r[id_guru_akses]/$r[id_guru]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                                        </center></td>
                                    </tr>";
                                $no++;
                                }
                              echo "<tbody>
                            </table>
                            </div>";
                    ?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>