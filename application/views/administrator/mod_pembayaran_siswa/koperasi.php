            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Transaksi Pembelian (PO) Koperasi</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th style='width:20px'>No</th>
                        <th>Kode Pembelian</th>
                        <th>Nama Supplier</th>
                        <th>Jml Belanja</th>
                        <th>COA</th>
                        <th>Sub-COA</th>
                        <th>Tanggal Pembelian</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    $b = $this->db->query("SELECT sum(jumlah_pesan*harga_pesan) as jumlah_belanja FROM rb_koperasi_pembelian_detail where id_pembelian='$r[id_pembelian]'")->row_array();
                    if ($r['id_sub_coa']=='0'){ $sub_coa = '-'; }else{ $sub_coa = $r['nama_sub_coa']; }
                    if ($r['id_coa']=='0'){ $coa = '-'; }else{ $coa = $r['nama_coa']; }
                    echo "<tr><td>$no</td>
                              <td>$r[kode_pembelian]</td>
                              <td>$r[nama_supplier]</td>
                              <td>".rupiah($b['jumlah_belanja'])."</td>
                              <td>$coa</td>
                              <td>$sub_coa</td>
                              <td>".tgl_view($r['tanggal_pembelian'])."</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Detail Data' href='".base_url()."keuangan/transaksi_koperasi_detail/$r[id_pembelian]'><span class='glyphicon glyphicon-search'></span> Lihat Detail</a>
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