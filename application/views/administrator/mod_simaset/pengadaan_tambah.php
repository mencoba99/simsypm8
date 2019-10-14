<script language="JavaScript" type="text/JavaScript">
 function showBarang(){
   <?php
     $hasil = $this->db->query("SELECT * FROM kategori");
     foreach ($hasil->result_array() as $data) {
       $id_kategori = $data['id_kategori'];
       echo "if (document.vcode.aa.value == \"".$id_kategori."\")";
       echo "{";
        $hasil2 = $this->db->query("SELECT * FROM barang WHERE id_kategori = '$id_kategori'");
         $content = "document.getElementById('barang').innerHTML = \"";
             foreach ($hasil2->result_array() as $data2) {
                 $content .= "<option value='".$data2['id_barang']."'>".$data2['nm_barang']."</option>";
             }
           $content .= "\"";
         echo $content;
       echo "}\n";
     }
   ?>
 }
</script>

<?php
if ($this->session->pengadaan!=''){
    $d = $this->db->query("SELECT * FROM pengadaan where id_pengadaan='".$this->session->pengadaan."'")->row_array();
    $no_pengadaan = $d['no_pengadaan'];
    $tgl_pengadaan = tgl_view($d['tgl_pengadaan']);
    $id_supplier = $d['id_supplier'];
    $jenis_pengadaan = $d['jenis_pengadaan'];
    $foto = "<i><b style='color:red'>File Sekarang</b> : $d[foto]</i>";
    $keterangan = $d['keterangan'];
}else{
    $no_pengadaan = '';
    $tgl_pengadaan = date('d-m-Y');
    $id_supplier = '';
    $jenis_pengadaan = '';
    $foto = '';
    $keterangan = '';
}
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Transaksi Pengadaan</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_transaksi_pengadaan',$attributes); 
                echo "<div class='col-md-6'>
                  <table class='table table-condensed table-bordered table-condensed'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th width='120px' scope='row'>No Pengadaan</th> <td><input type='text' class='form-control' name='a' value='$no_pengadaan'> </td></tr>     
                    <tr><th scope='row'>Tgl Pengadaan</th>        <td><input type='text' class='form-control' name='b' value='$tgl_pengadaan'></td></tr>
                    <tr><th scope='row'>Suppliers</th>        <td><select class='form-control' name='c'>
                                                      <option value=''> - </option>";
                                                      $supplier = $this->model_app->view("supplier");
                                                      foreach ($supplier->result_array() as $row) {
                                                        if ($id_supplier==$row['id_supplier']){
                                                          echo "<option value='$row[id_supplier]' selected>$row[nm_supplier]</option>";
                                                        }else{
                                                          echo "<option value='$row[id_supplier]'>$row[nm_supplier]</option>";
                                                        }
                                                      }
                    echo "</select>

                    <button type='submit' name='submit' class='btn btn-info btn-sm' style='margin-top:5px'>Selanjutnya</button></td></tr>
                  </tbody>
                  </table>
                </div>

                <div class='col-md-6'>
                  <table class='table table-condensed table-bordered table-condensed'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Jenis Pengadaan</th>        <td><select class='form-control' name='d'>
                                                      <option value=''> - </option>";
                                                      $jenis = array('Pembelian','Sumbangan','Wakaf','Hibah','Hadiah','Donasi');
                                                      for ($i=0; $i < count($jenis); $i++) {
                                                        if ($jenis_pengadaan==$jenis[$i]){
                                                          echo "<option value='".$jenis[$i]."' selected>".$jenis[$i]."</option>";
                                                        }else{
                                                          echo "<option value='".$jenis[$i]."'>".$jenis[$i]."</option>";
                                                        }
                                                      }

                    echo "</select></td></tr>
                    <tr><th scope='row'>Keterangan</th>        <td><textarea class='form-control' name='e' style='height:40px'>$keterangan</textarea></td></tr>
                    <tr><th scope='row'>Foto Kwitansi</th>        <td><input type='file' class='form-control' name='userfile[]' multiple>$foto</td></tr>

                  </tbody>
                  </table>
                </div>";
              echo form_close();

              if ($this->session->pengadaan!=''){
                echo "<div style='clear:both'></div>
                <div class='box-header with-border'>
                    <h3 class='box-title'>Input Barang</h3>
                  </div>";
                $attributes = array('class'=>'form-horizontal','role'=>'form','name'=>'vcode');
                echo form_open_multipart($this->uri->segment(1).'/tambah_transaksi_pengadaan',$attributes); 
                echo "<div class='col-md-12'>
                    <table class='table table-condensed table-bordered table-condensed'>
                    <tbody>
                      <input type='hidden' name='id' value=''>
                      <tr><th width='120px' scope='row'>Pilih Kategori</th>        <td><select style='display:inline-block; width:20%' class='form-control' name='aa' onchange=\"showBarang()\">
                                              <option value=''> - </option>";
                                              $kategori = $this->model_app->view("kategori");
                                              foreach ($kategori->result_array() as $row) {
                                                echo "<option value='$row[id_kategori]'>$row[nm_kategori]</option>";
                                              }
                      echo "</select>, &nbsp;

                      <b>Nama Barang</b> <select style='display:inline-block; width:50%' id='barang' class='form-control' name='bb'></select>
                      </td></tr>";
                      echo "<tr><th scope='row'>Deskripsi Barang</th> <td><input type='text' class='form-control' name='cc'> </td></tr>     
                      <tr><th scope='row'>Harga Barang</th> <td><input type='number' class='form-control' name='dd' style='display:inline-block; width:200px' value='0'> Jumlah <input type='number' class='form-control' name='ee' style='display:inline-block; width:100px' value='1'> <button type='submit' name='submit1' class='btn btn-warning' style='margin-top:-2px'>Tambah Barang</button>
                       <a class='btn btn-primary' href='".base_url().$this->uri->segment(1)."/transaksi_pengadaan?selesai'>Selesai / Simpan Data</a></td></tr>     
                    </tbody>
                    </table>
                  </div>";
                  echo form_close();

                  echo "<table id='example2' class='table table-bordered table-striped table-condensed'>
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total Biaya</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    $item = $this->db->query("SELECT a.*, b.id_barang, b.kd_barang, b.nm_barang FROM pengadaan_item a JOIN barang b ON a.id_barang=b.id_barang where a.id_pengadaan='".$this->session->pengadaan."'");
                    foreach ($item->result_array() as $r){
                    echo "<tr><td>$no</td>
                              <td>$r[kd_barang]</td>
                              <td>$r[nm_barang]</td>
                              <td>$r[deskripsi]</td>
                              <td>".rupiah($r['harga_beli'])."</td>
                              <td>$r[jumlah]</td>
                              <td>".rupiah($r['harga_beli']*$r['jumlah'])."</td>
                              <td><center>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_barang_transaksi_pengadaan/$r[id_barang]/".$this->session->pengadaan."' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>
                              </tr>";
                      $no++;
                      }

                    echo "</tbody>
                  </table>";
              }
            echo "</div>
        </div>
      </div>";
            
