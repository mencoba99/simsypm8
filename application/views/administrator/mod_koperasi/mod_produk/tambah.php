<?php
echo "<div class='col-md-12'>
  <div class='box box-info'>
    <div class='box-header with-border'>
      <h3 class='box-title'>Tambah Data</h3>
    </div>
  <div class='box-body'>";
  $attributes = array('class'=>'form-horizontal','role'=>'form');
  echo form_open_multipart($this->uri->segment(1).'/tambah_produk',$attributes); 
    echo "<div class='col-md-12'>
      <table class='table table-condensed table-bordered'>
      <tbody>
        <input type='hidden' name='id' value=''>
        <tr><th width='120px' scope='row'>Kategori</th> <td><select class='form-control' name='a'> 
                                      <option value=''>- Pilih -</option>";
                                      $kategori = $this->db->query("SELECT * FROM rb_koperasi_kategori where aktif='Y'");
                                      foreach ($kategori->result_array() as $row){
                                          echo "<option value='$row[id_kategori]'>$row[nama_kategori]</option>";
                                      }
                                            echo "</select></td></tr>
        <tr><th scope='row'>Kode Barang</th>            <td><input type='text' class='form-control' name='b'></td></tr>
        <tr><th scope='row'>Nama Barang</th>            <td><input type='text' class='form-control' name='c'></td></tr>
        <tr><th scope='row'>Harga</th>                  <td><input type='number' class='form-control' name='d'></td></tr>
        <tr><th scope='row'>Stok Margin</th>            <td><input type='number' class='form-control' name='ee'></td></tr>
        <tr><th scope='row'>Satuan</th>                 <td><input type='text' class='form-control' name='e'></td></tr>
        <tr><th scope='row'>Keterangan</th>             <td><textarea class='form-control' name='f'></textarea></td></tr>
        <tr><th scope='row'>Jual</th>                <td><input type='radio' name='ff' value='ya' checked> Ya
                                                                 <input type='radio' name='ff' value='tidak'> Tidak
      </tbody>
      </table>
    </div>
  </div>
  <div class='box-footer'>
        <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
        <a href='".base_url()."".$this->uri->segment(1)."/produk/ya'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
  </div>";
  echo form_close();
echo "</div>";

