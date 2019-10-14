<?php 
$attributes = array('class'=>'form-horizontal','role'=>'form','id'=>'formku','name'=>'demo');
echo form_open_multipart($this->uri->segment(1).'/tambah_labor_detail',$attributes); 
echo "
<h3 style='margin:0px 0px 20px 0px'>Tambah Data</h3>
    <table class='table table-condensed table-bordered'>
    <tbody>
      <input type='hidden' name='id' value='".$this->input->post(id)."'>
      <tr><th width='140px' scope='row'>Nama Alat</th>   <td><input type='text' class='form-control' name='a'></td></tr>
      <tr><th scope='row'>Kapasitas</th>                 <td><input type='text' class='form-control' name='b'></td></tr>
      <tr><th scope='row'>Jumlah</th>                     <td><input type='text' class='form-control' name='c'></td></tr>
      <tr><th scope='row'>keterangan</th>                <td><textarea type='text' class='form-control' name='d'></textarea></td></tr>
    </tbody>
    </table>

<div class='box-footer'>
  <button type='submit' name='submit' class='btn btn-info'>Simpan</button>
  <a data-dismiss='modal' href='#'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
</div>";
echo form_close();
