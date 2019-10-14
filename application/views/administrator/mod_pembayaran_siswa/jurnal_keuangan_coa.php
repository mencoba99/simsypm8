            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Jurnal Keuangan COA </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <?php 
                    echo "<form style='margin-right:5px; margin-top:0px' action='".base_url().$this->uri->segment(1)."/jurnal_keuangan' method='GET'>
                      <table class='table table-condensed table-hover'>
                          <tbody>
                            <tr>
                              <th width='200px' scope='row'>Tampilkan berdasarkan Bulan</th> 
                              <td>
                                  <input type='month' style='padding:4px; width:300px' name='bulan'>
                                  <input type='submit' style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'>
                                </td>
                              </tr>
                          </tbody>
                      </table>
                      </form>";
                  ?>
                  <form action='' method='POST'>
                    <?php 
                      echo "<table class='table table-bordered'>
                        <thead>
                          <tr bgcolor='#e3e3e3'>
                            <th width='40px'>No</th>
                            <th>Kode</th>
                            <th>Nama Coa</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                          </tr>
                      </thead>
                      <tbody>";

                      $no = 1;
                      
                      foreach ($tampil->result_array() as $r) {
                        $kr = $this->db->query("SELECT sum(a.total_bayar) as total FROM `rb_lk_keuangan_keluar` a WHERE a.id_coa='$r[id_coa]' AND MONTH(waktu_bayar) = '$bulan' AND YEAR(waktu_bayar) = '$tahun'")->row_array();
                        $kr1 = $this->db->query("SELECT sum(a.total_bayar) as total FROM `rb_keuangan_bayar` a JOIN rb_keuangan_jenis b ON a.id_keuangan_jenis=b.id_keuangan_jenis WHERE b.id_coa='$r[id_coa]' AND MONTH(waktu_bayar) = '$bulan' AND YEAR(waktu_bayar) = '$tahun'")->row_array();
                        
                        $total += $kr1['total'] - $kr['total'];
                        
                        echo "<tr class='success' style='font-weight:bold;'><td>$no</td>
                                  <td>$r[kode_coa]</td>
                                  <td>$r[nama_coa]</td>
                                  <td style='text-align:right; color : green;'>Rp ".rupiah($kr1['total']+$kr2['kredit']+$kpr1['total'])."</td>
                                  <td style='text-align:right; color : red;'>Rp ".rupiah($kr['total']-$kr2['kredit']+$kpr1['total'])."</td>
                              </tr>";
                          $no++;

                          
                          $subcoa = $this->db->query("SELECT * FROM rb_keuangan_sub_coa WHERE id_coa='$r[id_coa]' ORDER BY id_sub_coa ASC");
                          
                          foreach ($subcoa->result_array() as $row) {
                            $krs = $this->db->query("SELECT sum(a.total_bayar) as total FROM `rb_lk_keuangan_keluar` a WHERE a.id_coa='$r[id_coa]' AND a.id_sub_coa='$row[id_sub_coa]' AND MONTH(waktu_bayar) = '$bulan' AND YEAR(waktu_bayar) = '$tahun'")->row_array();
                            $krs1 = $this->db->query("SELECT sum(a.total_bayar) as total FROM `rb_keuangan_bayar` a JOIN rb_keuangan_jenis b ON a.id_keuangan_jenis=b.id_keuangan_jenis where b.id_coa='$r[id_coa]' AND b.id_sub_coa='$row[id_sub_coa]' AND MONTH(waktu_bayar) = '$bulan' AND YEAR(waktu_bayar) = '$tahun'")->row_array();
                            
                            echo "<tr><td>-</td>
                                  <td>$row[kode_sub_coa]</td>
                                  <td>$row[nama_sub_coa]</td>
                                  <td style='text-align:right'>Rp ".rupiah($krs1['total']+$krs2['kredit']+$kprs1['total'])."</td>
                                  <td style='text-align:right'>Rp ".rupiah($krs['total'])."</td>
                              </tr>";
                          }
                        }
                    ?>
                      </tbody>
                    </table>
                    <h3 style="size: bold; font-weight: bold; text-align: right;">Saldo : Rp. <?php echo rupiah($total) ?></h3> 
                  </div><!-- /.box-body -->                  
                  </div><!-- /.box -->
                </form>
            </div>