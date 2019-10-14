            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Produk Koperasi </h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_produk'>Tambahkan Data</a>
                  
                  <form style='margin-right:5px; margin-top:0px' class='pull-right' action='<?php echo base_url().$this->uri->segment(1); ?>/produk/<?php echo $this->uri->segment(3); ?>' method='GET'>
                  <select name='kategori' style='padding:3px; border:1px solid #e3e3e3; padding:4px 5px 4px 8px' required>
                    <option value=''>Semua Kategori</option>
                    <?php 
                      $kategori = $this->db->query("SELECT * FROM rb_koperasi_kategori where aktif='Y'");
                      foreach ($kategori->result_array() as $r){
                        if($_GET['kategori']==$r['id_kategori']){
                          echo "<option value='$r[id_kategori]' selected>$r[nama_kategori]</option>";
                        }else{
                          echo "<option value='$r[id_kategori]'>$r[nama_kategori]</option>";
                        }
                      }
                    ?>
                  </select>
                  <input type="submit" style='margin-top:-4px' value='Tampilkan' class='btn btn-success btn-sm'>
                  </form>

                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Margin</th>
                        <th>Satuan</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    $beli = $this->db->query("SELECT sum(jumlah_terima) as total FROM rb_koperasi_pembelian_terima_detail where id_barang='$r[id_barang]'")->row_array();
                    $jual = $this->db->query("SELECT sum(jumlah_jual) as total FROM rb_koperasi_penjualan_detail where id_barang='$r[id_barang]'")->row_array();
                    $stok = $beli['total']-$jual['total'];
                    if ($stok<=$r['stok_margin']){ $alert = 'danger'; }else{ $alert = ''; }

                    echo "<tr><td>$no</td>
                              <td>$r[kode_barang]</td>
                              <td>$r[nama_barang]</td>
                              <td>Rp ".rupiah($r['harga'])."</td>
                              <td>".rupiah($beli['total']-$jual['total'])."</td>
                              <td>$r[stok_margin]</td>
                              <td>$r[satuan]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_produk/$r[id_barang]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_produk/$r[id_barang]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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