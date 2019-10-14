<?php
echo "<div class='col-md-12'>
  <div class='box box-info'>
    <div class='box-header with-border'>
      <h3 class='box-title'>Edit Data</h3>
    </div>
  <div class='box-body'>";
  $attributes = array('class'=>'form-horizontal','role'=>'form');
  echo form_open_multipart($this->uri->segment(1).'/edit_produk',$attributes); 
    echo "<div class='col-md-12'>
      <table class='table table-condensed table-bordered'>
      <tbody>
        <input type='hidden' name='id' value='$s[id_barang]'>
        <tr><th width='120px' scope='row'>Kategori</th> <td><select class='form-control' name='a'> 
                                    <option value=''>- Pilih -</option>";
                                    $kategori = $this->db->query("SELECT * FROM rb_koperasi_kategori where aktif='Y'");
                                    foreach ($kategori->result_array() as $row){
                                      if ($s['id_kategori']==$row['id_kategori']){
                                        echo "<option value='$row[id_kategori]' selected>$row[nama_kategori]</option>";
                                      }else{
                                        echo "<option value='$row[id_kategori]'>$row[nama_kategori]</option>";
                                      }
                                    }
                                  echo "</select></td></tr>
        <tr><th scope='row'>Kode Barang</th>            <td><input type='text' class='form-control' name='b' value='$s[kode_barang]'></td></tr>
        <tr><th scope='row'>Nama Barang</th>            <td><input type='text' class='form-control' name='c' value='$s[nama_barang]'></td></tr>
        <tr><th scope='row'>Harga</th>                  <td><input type='number' class='form-control' name='d' value='$s[harga]'></td></tr>
        <tr><th scope='row'>Stok Margin</th>            <td><input type='number' class='form-control' name='ee' value='$s[stok_margin]'></td></tr>
        <tr><th scope='row'>Satuan</th>                 <td><input type='text' class='form-control' name='e' value='$s[satuan]'></td></tr>
        <tr><th scope='row'>Keterangan</th>             <td><textarea class='form-control' name='f'>$s[keterangan]</textarea></td></tr>
        <tr><th scope='row'>Jual</th>                <td>";
                                              if ($s['jual']=='ya'){
                                                  echo "<input type='radio' name='ff' value='ya' checked> Ya
                                                         <input type='radio' name='ff' value='tidak'> Tidak";
                                              }else{
                                                  echo "<input type='radio' name='ff' value='ya'> Ya
                                                         <input type='radio' name='ff' value='tidak' checked> Tidak";
                                              }
      echo "</td></tr>
      </tbody>
      </table>
    </div>
  </div>
  <div class='box-footer'>
        <button type='submit' name='submit' class='btn btn-info'>Update</button>
        <a href='".base_url()."".$this->uri->segment(1)."/produk/ya'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
  </div>";
  echo form_close();
echo "</div>";

