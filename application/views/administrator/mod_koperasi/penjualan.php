<?php 
  if ($this->session->jual!=''){
    $button = 'Update Data';
    $e = $this->db->query("SELECT * FROM rb_koperasi_penjualan where id_penjualan='".$this->session->jual."'")->row_array();
    $deskripsi = $e['deskripsi'];
    $kode = $e['kode_penjualan'];
  }else{
    $button = 'Selanjutnya';
    $deskripsi = '';
    $kode = "PJ".date('YmdHis');
  }
?>
<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Transaksi Penjualan Barang </h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <form action='<?php echo base_url().$this->uri->segment(1)."/transaksi_penjualan"; ?>' method='POST'>
        <table class="table table-bordered table-striped table-condensed">
            <tr><td>Kode penjualan</td> <td><input type="text" class='form-control' name='b' value='<?php echo $kode; ?>' required></td></tr> 
            <tr><td width='120px'>Siswa</td> <td><select class='form-control combobox' name='a' required>
                                            <option value='' selected>Cari Siswa</option>
                                            <?php 
                                              $siswa = $this->db->query("SELECT * FROM rb_siswa");
                                              foreach ($siswa->result_array() as $row) {
                                                if ($e['id_siswa']==$row['id_siswa']){
                                                  echo "<option value='$row[id_siswa]' selected>$row[nama]</option>";
                                                }else{
                                                  echo "<option value='$row[id_siswa]'>$row[nama]</option>";
                                                }
                                              }
                                            ?>
                                        </select></td></tr>
             <input type="hidden" name='d' value=''>
             <tr><td></td> <td><input class='btn btn-sm btn-success' type="submit" name='simpan' value='<?php echo $button; ?>'>
                 </td>
              </tr> 
        </table><hr>
      </form>

    <?php if ($this->session->jual!=''){ ?>
      <table class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>Kode / Nama Barang</th>
            <th>Jumlah</th>
            <th>Harga Jual</th>
            <th>Satuan</th>
            <th>Diskon (Rp)</th>
            <th>Subtotal</th>
            <th style='width:40px'>Action</th>
          </tr>
          <tr>
            <form action='' method='POST'>
              <th style='width:40px'></th>
              <th><select class='combobox form-control' onchange="changeValue(this.value)" required autofocus>
                  <option value='' selected> Cari Barang </option>
                  <?php
                    $jsArray = "var prdName = new Array();\n";   
                    $barang = $this->db->query("SELECT * FROM rb_koperasi_barang where jual='ya'"); 
                    foreach ($barang->result_array() as $rows) {
                        echo "<option value='$rows[id_barang]'>$rows[kode_barang] - $rows[nama_barang]</option>";
                        $jsArray .= "prdName['" . $rows['id_barang'] . "'] = {name:'" . addslashes($rows['harga']) . "',desc:'".addslashes($rows['satuan'])."', idb:'" . addslashes($rows['id_barang']) . "'};\n";
                    }
                  ?>
               </select>
              </th>
              <input class='form-control' type="hidden" name='aa' id='barang'>
              <th><input class='form-control' style='width:70px' type="number" name='bb' value='1'></th>
              <th><input class='form-control' style='width:110px' type="number" name='cc' id='harga'></th>
              <th><input class='form-control' style='width:110px' type="text" name='dd' id='satuan'></th>
              <th><input class='form-control' style='width:110px' type="text" name='ee' ></th>
              <th></th>
              <th><button class='btn btn-primary' type='submit' name='simpan_barang'><span class='glyphicon glyphicon-plus'></span></button></th>
            </form>
          </tr>
        </thead>
        <tbody>
      <?php 
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        echo "<tr><td>$no</td>
                  <td style='padding-left:25px'>$r[kode_barang] - $r[nama_barang]</td>
                  <td style='padding-left:20px'>$r[jumlah_jual]</td>
                  <td style='padding-left:20px'>".rupiah($r['harga'])."</td>
                  <td style='padding-left:20px'>$r[satuan]</td>
                  <td style='padding-left:20px'>$r[diskon]</td>
                  <td style='padding-left:20px' class='info'><b>Rp ".rupiah(($r['jumlah_jual']*$r['harga'])-$r['diskon'])."</b></td>
                  <td><center>
                    <a class='btn btn-danger btn-xs' title='Delete Data' href='index.php?view=koperasi_penjualan&hapus=$r[id_penjualan_detail]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                  </center></td>
              </tr>";
          $no++;
          }
          $tot = $this->db->query("SELECT sum((harga*jumlah_jual)-diskon) as total FROM rb_koperasi_penjualan_detail where id_penjualan='".$this->session->jual."'")->row_array();
            echo "<tr class='danger'>
                    <td colspan='6'><b>Total Harga</b></td>
                    <td style='padding-left:20px'><b>Rp ".rupiah($tot['total'])."</b></td>
                  </tr>";

      ?>
        </tbody>
      </table><br>

      <div class="col-xs-6 pull-right"> 
      <form action='<?php echo base_url().$this->uri->segment(1)."/transaksi_penjualan"; ?>' method='POST'>
        <table class="table table-bordered table-striped table-condensed">
          <input type="hidden" name='idn' value='<?php echo $this->session->jual; ?>'>
          <input type='hidden' value='<?php echo $tot['total']; ?>' class=' input1 value1'>
           <tr><th scope='row' width='120px'>Metode Bayar</th>           <td><select class='form-control' name='metode'>
                                                                                    <option value='Cash'>Cash</option>
                                                                                    <option value='EDC'>EDC</option>
                                                                                    <option value='Transfer'>Transfer</option>
                                                                                  </select></td></tr>
           <tr><th>Total Bayar</th>   <td><input type="number" style='font-weight:bold' class='form-control input1 value2' name='bayar' autocomplete='off' required></td></tr>  
           <tr><th>Kembali</th>   <td><input type="text" style='color:red; font-weight:bold' id='hasilnya' class='form-control' disabled></td></tr>  
        </table>
          <input class='pull-right btn btn-primary btn-sm' type="submit" name='simpanx' value='Selesai / Simpan Data'>  
      </form>
      </div>

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