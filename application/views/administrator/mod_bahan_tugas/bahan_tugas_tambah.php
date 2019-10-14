<script type="text/javascript">
  function show1(){
    var option = document.getElementById("kategori").value;
    if(option == "1"){
       document.getElementById("vcode1_hideshow").className="hidden";
       document.getElementById("vcode2_hideshow").className="hidden";
    }
    if(option == "2"){
       document.getElementById("vcode1_hideshow").className="visible";
       document.getElementById("vcode2_hideshow").className="visible";
    }
  }
</script>
<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data Bahan Tugas</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form','name'=>'vcode');
              echo form_open_multipart($this->uri->segment(1).'/tambah_bahan_tugas/'.$this->uri->segment(3),$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Kategori</th> <td><select id='kategori' onchange=\"show1()\" class='form-control' name='a' required> 
                             <option value='' selected>- Pilih Kategori Tugas -</option>"; 
                              foreach ($kategori_elearning->result_array() as $a){
                                  echo "<option value='$a[id_kategori_elearning]'>$a[nama_kategori_elearning]</option>";
                              }
                             echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Nama File</th>        <td><input type='text' class='form-control' name='b' required></td></tr>
                    <tr><th scope='row'>File</th>             <td><input type='file' name='c'></td></tr>
                    <tr id='vcode1_hideshow'><th scope='row'>Waktu Mulai</th>      <td><input type='text' class='form-control' id='datetimepicker1' data-date-format='DD-MM-YYYY HH:mm:ss' name='d' autocomplete='off'></td></tr>
                    <tr id='vcode2_hideshow'><th scope='row'>Waktu Selesai</th>    <td><input type='text' class='form-control' id='datetimepicker2' data-date-format='DD-MM-YYYY HH:mm:ss' name='e' autocomplete='off'></td></tr>
                    <tr><th scope='row'>Keterangan</th>       <td><textarea class='form-control' name='f' style='width:100%; height:32px;' onkeyup=\"auto_grow(this)\"></textarea></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/detail_bahan_tugas/".$this->uri->segment(4)."'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
