              <div class='box box-info'>
                  <div class='box-header with-border'>
                    <h3 class='box-title'>Transaksi</h3>
                  </div>
                <div class='box-body'>
                  <?php
                    $attributes = array('class'=>'form-horizontal','role'=>'form');
                    echo form_open_multipart($this->uri->segment(1).'/tambah_transaksi',$attributes);
                  ?>
                  <?php echo $this->session->flashdata('data'); ?>
                    <div class='col-md-12'>
                      <table class='table table-condensed table-bordered'>
                        <tbody>
                         
                          <input type='hidden' name='id' value=''>                          
                          <?php
                          echo"                                 
                          <tr><th width='120px'>Nama Nasabah</th>
                            <td>
                            <select class='form-control combobox' name='id_nasabah' required>
                                <option value='' selected>Cari Nama Nasabah Terlebih Dahulu...</option>";
                                  foreach ($nasabah as $row) {
                                    echo "<option value='$row[id_nasabah]'>$row[nama]</option>";
                                  }
                            echo "</select>
                            </td>
                          </tr>";
                          ?>                     
                                               
                          <?php
                          echo "<tr><th width='120px' scope='row'>Jenis Transaksi</th><td><select name='id_kd_transaksi' class='form-control' style='border:2px solid green'  required>";
                            foreach ($kd_transaksi->result_array() as $row){
                                    echo "<option value='$row[id_kd_transaksi]'>$row[nama_akun]</option>";
                            }
                          echo " </td></tr>";
                          ?>

                           <tr>
                            <th scope='row'>Nominal Transaksi</th> 
                              <td class='col-md-10'><input type='number' style="font-size: 20px" class='form-control' name='nominal' id='nominal' onkeyup="hitung()" required="" placeholder="000000"></td>
                          </tr>
                       
                          <tr>
                            <th scope='row'>Keterangan</th> 
                              <td class='col-md-10'><input type='text' class='form-control' name='nasabah_keterangan'></td>
                          </tr>                    

                        </tbody>
                      </table>
                    </div>
                </div>
                <div class='box-footer'>
                      <?php echo" <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                                  <a href='".base_url()."".$this->uri->segment(1)."/transaksi'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>";?>
                </div>
                <?php echo form_close(); ?>
              </div>
