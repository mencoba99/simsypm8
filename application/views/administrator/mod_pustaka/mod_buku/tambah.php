<?php
echo "<div class='col-md-12'>
  <div class='box box-info'>
    <div class='box-header with-border'>
      <h3 class='box-title'>Tambah Data</h3>
    </div>
  <div class='box-body'>";
  $attributes = array('class'=>'form-horizontal','role'=>'form');
  echo form_open_multipart($this->uri->segment(1).'/tambah_buku',$attributes); 
    echo "<div class='col-md-12'>
      <table class='table table-condensed table-bordered table-condensed'>
      <tbody>
        <input type='hidden' name='id' value=''>
        <tr><th width='130px' scope='row'>Kategori Buku</th> <td><select class='form-control' name='a'> 
                                                        <option value='0' selected>- Pilih -</option>"; 
                                                          $kategori = $this->db->query("SELECT * FROM rb_pustaka_kategori");
                                                          foreach ($kategori->result_array() as $a) {
                                                              echo "<option value='$a[id_kategori]'>$a[nama_kategori]</option>";
                                                          }
                                                echo "</select></td></tr>
        <tr><th scope='row'>Kode Buku</th> <td><input type='text' class='form-control' name='b' required> </td></tr>
        <tr><th scope='row'>Judul Buku</th> <td><input type='text' class='form-control' name='c' required> </td></tr>
        <tr><th scope='row'>Pengarang</th> <td><input type='text' class='form-control' name='d' required> </td></tr>
        <tr><th scope='row'>Penerbit</th> <td><input type='text' class='form-control' name='e' required> </td></tr>
        <tr><th scope='row'>Tahun Terbit</th> <td><input type='number' class='form-control' name='tahun_terbit'> </td></tr>
        <tr><th scope='row'>Foto</th> <td><input type='file' class='form-control' name='f'></td></tr>
        <tr><th scope='row'>Deskripsi</th> <td><textarea class='form-control' name='g'></textarea></td></tr>
        <tr><th scope='row'>Jumlah</th> <td><input autocomplete='off' type='number' class='form-control' name='h'> </td></tr>
        <tr><th scope='row'>Tahun Pengadaan</th> <td><input autocomplete='off' type='number' class='form-control' name='tahun_pengadaan'> </td></tr>
        <tr><th scope='row'>Harga Buku</th> <td><input autocomplete='off' type='number' class='form-control' name='harga_buku'> </td></tr>
        <tr><th scope='row'>Sumber Dana</th> <td><input autocomplete='off' type='text' class='form-control' name='sumber_dana'> </td></tr>
      </tbody>
      </table>
    </div>
  </div>
  <div class='box-footer'>
        <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
        <a href='".base_url()."".$this->uri->segment(1)."/buku'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
  </div>";
  echo form_close();
echo "</div>";

