            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Barang </h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_barang'>Tambahkan Data</a>
                  <?php 
                    echo "<form class='pull-right' style='margin-right:5px; margin-top:-2px' action='".base_url().$this->uri->segment(1)."/barang' method='GET'>
                    <select style='padding:4px' name='kategori'>
                              <option value='all'> Semua Kategori </option>";
                              $kategori = $this->model_app->view("kategori");
                              foreach ($kategori->result_array() as $row) {
                                if ($this->input->get('kategori')==$row['id_kategori']){
                                  echo "<option value='$row[id_kategori]' selected>$row[nm_kategori]</option>";
                                }else{
                                  echo "<option value='$row[id_kategori]'>$row[nm_kategori]</option>";
                                }
                              }
                    echo "</select>
                    <input type='submit' value='Tampilkan' class='btn btn-sm btn-success'>
                    </form>";
                  ?>
                  
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Merek</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Foto</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $r){
                    echo "<tr><td>$no</td>
                              <td>$r[kd_barang]</td>
                              <td>$r[nm_barang]</td>
                              <td>$r[merek]</td>
                              <td>$r[jumlah]</td>
                              <td>$r[satuan]</td>
                              <td>";
                              $ex = explode(';',$r['foto']);
                              $no = 1;
                              for($i=0; $i<count($ex); $i++){
                                if ($ex[$i]!=''){
                                  echo "<a target='_BLANK' href='".base_url()."asset/files/".$ex[$i]."'>$ex[$i], </a>";
                                }
                                $no++;
                              }
                              echo "</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_barang/$r[id_barang]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_barang/$r[id_barang]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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