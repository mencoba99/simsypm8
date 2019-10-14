<?php 
  if ($_SESSION['beli']!=''){
    $button = 'Update Data';
    $e = $this->db->query("SELECT * FROM rb_koperasi_pembelian where id_pembelian='".$this->session->beli."'")->row_array();
    $tgl_beli = tgl_view($e['tanggal_pembelian']);
    $deskripsi = $e['deskripsi'];
    $kode = $e['kode_pembelian'];
  }else{
    $button = 'Selanjutnya';
    $tgl_beli = date('d-m-Y');
    $deskripsi = '';
    $kode = "PB".date('YmdHis');
  }
?>
<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Transaksi Pembelian Baru</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <form action='<?php echo base_url().$this->uri->segment(1)."/transaksi_pembelian"; ?>' method='POST'>
        <table class="table table-bordered table-striped table-condensed">
            <tr><td>Kode Pembelian</td> <td><input type="text" class='form-control' name='b' value='<?php echo $kode; ?>' required></td></tr> 
            <tr><td width='120px'>Supplier</td> <td><select class='form-control combobox' name='a' required>
                                        <option value='' selected>Cari Supplier</option>
                                        <?php 
                                          $supplier = $this->db->query("SELECT * FROM rb_koperasi_supplier where aktif='Y'");
                                          foreach ($supplier->result_array() as $row) {
                                            if ($e['id_supplier']==$row['id_supplier']){
                                              echo "<option value='$row[id_supplier]' selected>$row[nama_supplier]</option>";
                                            }else{
                                              echo "<option value='$row[id_supplier]'>$row[nama_supplier]</option>";
                                            }
                                          }
                                        ?>
                                    </select></td></tr>
             <tr><td>Tanggal Beli</td> <td><input type="text" class='form-control' name='c' value='<?php echo $tgl_beli; ?>' required></td></tr> 
             <tr><td>Deskripsi</td> <td><textarea class='form-control' name='d'><?php echo $deskripsi; ?></textarea></td></tr>   
             <tr><td></td> <td><input class='btn btn-sm btn-success' type="submit" name='simpan' value='<?php echo $button; ?>'>
                      <?php if ($this->session->beli!=''){ ?>
                        <a class='btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1)."/transaksi_pembelian?selesai"; ?>'>Selesai / Simpan Data</a>  
                      <?php } ?> 
                   </td>
             </tr> 
        </table><hr>
      </form>

      <?php if ($this->session->beli!=''){ ?>
        <table class="table table-bordered table-striped table-condensed">
          <thead>
            <tr>
              <th style='width:40px'>No</th>
              <th>Kode / Nama Barang</th>
              <th>Jumlah</th>
              <th>Harga Beli</th>
              <th>Satuan</th>
              <th>Subtotal</th>
              <th style='width:40px'>Action</th>
            </tr>
            <tr>
              <form action='<?php echo base_url().$this->uri->segment(1)."/transaksi_pembelian"; ?>' method='POST'>
                <th style='width:40px'></th>
                <th><select class='combobox form-control' onchange="changeValue(this.value)" required autofocus>
                    <option value='' selected> Cari Barang </option>
                    <?php
                      $jsArray = "var prdName = new Array();\n";   
                      $barang = $this->db->query("SELECT * FROM rb_koperasi_barang where aktif='Y'"); 
                      foreach ($barang->result_array() as $rows) {
                          echo "<option value='$rows[id_barang]'>$rows[kode_barang] - $rows[nama_barang]</option>";
                          $jsArray .= "prdName['" . $rows['id_barang'] . "'] = {name:'" . addslashes($rows['harga']) . "',desc:'".addslashes($rows['satuan'])."', idb:'" . addslashes($rows['id_barang']) . "'};\n";
                      }
                    ?>
                 </select>
                </th>
                <input class='form-control' type="hidden" name='aa' id='barang'>
                <th><input class='form-control' type="number" name='bb' style='width:70px' value='1'></th>
                <th><input class='form-control' type="number" name='cc' style='width:110px' id='harga'></th>
                <th><input class='form-control' type="text" name='dd' style='width:70px' id='satuan'></th>
                <th></th>
                <th><button class='btn btn-primary' type='submit' name='simpan_barang'><span class='glyphicon glyphicon-plus'></span></button></th>
              </form>
            </tr>
          </thead>
          <tbody>
        <?php 
          $tampil = $this->db->query("SELECT a.*, b.kode_barang, b.nama_barang FROM rb_koperasi_pembelian_detail a JOIN rb_koperasi_barang b ON a.id_barang=b.id_barang where a.id_pembelian='".$this->session->beli."' AND b.aktif='Y' ORDER BY id_pembelian_detail ASC");
          $no = 1;
          foreach ($tampil->result_array() as $r) {
          echo "<tr><td>$no</td>
                    <td style='padding-left:25px'>$r[kode_barang] - $r[nama_barang]</td>
                    <td style='padding-left:20px'>$r[jumlah_pesan]</td>
                    <td style='padding-left:20px'>".rupiah($r['harga_pesan'])."</td>
                    <td style='padding-left:20px'>$r[satuan_pesan]</td>
                    <td style='padding-left:20px' class='info'><b>Rp ".rupiah($r['jumlah_pesan']*$r['harga_pesan'])."</b></td>
                    <td><center>
                      <a class='btn btn-danger btn-xs' title='Delete Data' href='index.php?view=koperasi_pembelian&hapus=$r[id_pembelian_detail]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                    </center></td>
                </tr>";
            $no++;
            }
              $tot = $this->db->query("SELECT sum(harga_pesan*jumlah_pesan) as total FROM rb_koperasi_pembelian_detail where id_pembelian='".$this->session->beli."'")->row_array();
              echo "<tr class='danger'>
                      <td colspan='5'><b>Total Pembelian</b></td>
                      <td style='padding-left:20px'><b>Rp ".rupiah($tot['total'])."</b></td>
                    </tr>";
        ?>
          </tbody>
        </table><br>
      <?php } ?>

    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>

<script type="text/javascript">    
<?php echo $jsArray; ?>  
  function changeValue(id){  
    document.getElementById('harga').value = prdName[id].name;  
    document.getElementById('satuan').value = prdName[id].desc;  
    document.getElementById('barang').value = prdName[id].idb;  
  };  
</script> 