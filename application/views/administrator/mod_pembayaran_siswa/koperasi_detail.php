<script language="JavaScript" type="text/JavaScript">
 function showCoa(){
   <?php
     $hasil = $this->db->query("SELECT * FROM rb_keuangan_coa");
     foreach ($hasil->result_array() as $data) {
       $idCoa = $data['id_coa'];
       echo "if (document.vcode.c.value == \"".$idCoa."\")";
       echo "{";
        $hasil2 = $this->db->query("SELECT * FROM rb_keuangan_sub_coa WHERE id_coa = $idCoa");
         $content = "document.getElementById('sub_coa').innerHTML = \"";
             foreach ($hasil2->result_array() as $data2) {
                 $content .= "<option value='".$data2['id_sub_coa']."'>".$data2['nama_sub_coa']."</option>";
             }
           $content .= "\"";
         echo $content;
       echo "}\n";
     }
   ?>
 }
</script>

<?php 
  echo "<div class='col-xs-12'>  
              <div class='box'>
                <div class='box-header'>
                  <h3 class='box-title'>Detail Laporan Data pembelian </h3>
                </div>
                <div class='box-body'>
                <form action='".base_url()."keuangan/transaksi_koperasi_detail/".$this->uri->segment(3)."' name='vcode' method='POST'>
                <table class='table table-bordered table-striped table-condensed'>
                    <tr><td><b>Kode pembelian</b></td>         <td>$d[kode_pembelian]</td></tr> 
                    <tr><td width='120px'><b>Supplier</b></td>    <td>$d[nama_supplier]</td></tr>
                    <tr><td width='120px'><b>Tgl Beli</b></td>    <td>".tgl_view($d['tanggal_pembelian'])."</td></tr>
                    <tr><td><b>Deskripsi</b></td>              <td>$d[deskripsi]</td></tr> 
                    <tr><th width='120px' scope='row'>COA</th> <td><select class='form-control' name='c' style='padding:4px' onchange=\"showCoa()\">
                          <option value=''>- Pilih -</option>";
                              $coa = $this->db->query("SELECT * FROM rb_keuangan_coa");
                              foreach ($coa->result_array() as $k) {
                                if ($d['id_coa']==$k['id_coa']){
                                  echo "<option value='$k[id_coa]' selected>$k[nama_coa]</option>";
                                }else{
                                  echo "<option value='$k[id_coa]'>$k[nama_coa]</option>";
                                }
                              }
                          echo "</select>
                    </td></tr>
                    <tr><th width='120px' scope='row'>Sub-COA</th> <td><select id='sub_coa' class='form-control' name='d' style='padding:4px'>
                          <option value=''>- Pilih -</option>";
                            if ($d['id_coa']!=''){
                              $sub_coa = $this->db->query("SELECT * FROM rb_keuangan_sub_coa where id_coa='$d[id_coa]'");
                            }else{
                              $sub_coa = $this->db->query("SELECT * FROM rb_keuangan_sub_coa");
                            }
                              foreach ($sub_coa->result_array() as $k) {
                                if ($d['id_sub_coa']==$k['id_sub_coa']){
                                  echo "<option value='$k[id_sub_coa]' selected>$k[nama_sub_coa]</option>";
                                }else{
                                  echo "<option value='$k[id_sub_coa]'>$k[nama_sub_coa]</option>";
                                }
                              }
                          echo "</select>
                    </td></tr>
                </table>
                <input class='btn btn-primary' type='submit' name='submit' value='Proses dan Simpan Data'>
                </form><hr>";

                echo "<table class='table table-bordered table-striped table-condensed'>
                        <thead>
                          <tr>
                            <th style='width:40px'>No</th>
                            <th>Kode / Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga Beli</th>
                            <th>Satuan</th>
                            <th>Subtotal</th>
                          </tr>
                        </thead>
                        <tbody>";
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    echo "<tr><td>$no</td>
                              <td style='padding-left:25px'>$r[kode_barang] - $r[nama_barang]</td>
                              <td style='padding-left:20px'>$r[jumlah_pesan]</td>
                              <td style='padding-left:20px'>".rupiah($r['harga_pesan'])."</td>
                              <td style='padding-left:20px'>$r[satuan_pesan]</td>
                              <td style='padding-left:20px' class='info'><b>Rp ".rupiah($r['jumlah_pesan']*$r['harga_pesan'])."</b></td>
                          </tr>";
                      $no++;
                      }
                        echo "<tr class='danger'>
                                <td colspan='5'><b>Total Pembelian</b></td>
                                <td style='padding-left:20px'><b>Rp ".rupiah($tot['total'])."</b></td>
                              </tr>
                        </tbody>
                      </table><br>
            </div>
          </div>
        </div>";