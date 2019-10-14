<?php
echo "<div class='col-md-12'>
  <div class='box box-info'>
    <div class='box-header with-border'>
      <h3 class='box-title'>Edit Data</h3>
    </div>
  <div class='box-body'>";
  $attributes = array('class'=>'form-horizontal','role'=>'form');
  echo form_open_multipart($this->uri->segment(1).'/edit_buku',$attributes); 
    echo "<div class='col-md-12'>
      <table class='table table-condensed table-bordered table-condensed'>
      <tbody>
        <input type='hidden' name='id' value='$s[id_buku]'>
        <tr><th width='130px' scope='row'>Kategori Buku</th> <td><select class='form-control' name='a'> 
                                                    <option value='0' selected>- Pilih -</option>"; 
                                                      $kategori = $this->db->query("SELECT * FROM rb_pustaka_kategori");
                                                      foreach ($kategori->result_array() as $a) {
                                                        if ($s['id_kategori']==$a['id_kategori']){
                                                          echo "<option value='$a[id_kategori]' selected>$a[nama_kategori]</option>";
                                                        }else{
                                                          echo "<option value='$a[id_kategori]'>$a[nama_kategori]</option>";
                                                        }
                                                      }
                                            echo "</select></td></tr>
        <tr><th scope='row'>Kode Buku</th> <td><input type='text' class='form-control' name='b' value='$s[kode_buku]' required> </td></tr>
        <tr><th scope='row'>Judul Buku</th> <td><input type='text' class='form-control' name='c' value='$s[judul]' required> </td></tr>
        <tr><th scope='row'>Pengarang</th> <td><input type='text' class='form-control' name='d' value='$s[pengarang]' required> </td></tr>
        <tr><th scope='row'>Penerbit</th> <td><input type='text' class='form-control' name='e' value='$s[penerbit]' required> </td></tr>
        <tr><th scope='row'>Tahun Terbit</th> <td><input type='number' class='form-control' name='tahun_terbit' value='$s[tahun_terbit]'> </td></tr>
        <tr><th scope='row'>Foto</th> <td><input type='file' class='form-control' name='f'>";
        if ($s['foto']!=''){ echo "<small>Foto saat ini : <a href='foto_buku/$s[foto]'><i>$s[foto]</i></a></small>"; } echo "</td></tr>
        <tr><th scope='row'>Deskripsi</th> <td><textarea class='form-control' name='g'>$s[deskripsi]</textarea></td></tr>
        <tr><th scope='row'>Jumlah</th> <td><input autocomplete='off' type='number' class='form-control' name='h' value='$s[jumlah]'> </td></tr>
        <tr><th scope='row'>Tahun Pengadaan</th> <td><input autocomplete='off' type='number' class='form-control' name='tahun_pengadaan' value='$s[tahun_pengadaan]'> </td></tr>
        <tr><th scope='row'>Harga Buku</th> <td><input autocomplete='off' type='number' class='form-control' name='harga_buku' value='$s[harga_buku]'> </td></tr>
        <tr><th scope='row'>Sumber Dana</th> <td><input autocomplete='off' type='text' class='form-control' name='sumber_dana' value='$s[sumber_dana]'> </td></tr>
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

