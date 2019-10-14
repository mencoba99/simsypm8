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
if ($r['tanggal_tugas']=='0000-00-00 00:00:00' AND $r['tanggal_selesai']='0000-00-00 00:00:00'){
  $tanggal_tugas = '-';
  $tanggal_selesai = '-';
}else{
  $ex1 = explode(' ', $row['tanggal_tugas']);
  $tanggal_tugas = tgl_view($ex1[0]).' '.$ex1[1].' WIB';
  $ex2 = explode(' ', $row['tanggal_selesai']);
  $tanggal_selesai = tgl_view($ex2[0]).' '.$ex2[1].' WIB';
}
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data Bahan Tugas</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form','name'=>'vcode');
              echo form_open_multipart($this->uri->segment(1).'/edit_bahan_tugas/'.$this->uri->segment(3).'/'.$this->uri->segment(4),$attributes); 
                echo "<div class='col-md-12'>
                  <input type='hidden' class='form-control' name='id' value='$row[id_elearning]' required>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Kategori</th> <td><select id='kategori' onchange=\"show1()\" class='form-control' name='a' required> 
                             <option value='' selected>- Pilih Kategori Tugas -</option>"; 
                              foreach ($kategori_elearning->result_array() as $a){
                                if ($row['id_kategori_elearning']==$a['id_kategori_elearning']){
                                  echo "<option value='$a[id_kategori_elearning]' selected>$a[nama_kategori_elearning]</option>";
                                }else{
                                  echo "<option value='$a[id_kategori_elearning]'>$a[nama_kategori_elearning]</option>";
                                }
                              }
                             echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Nama File</th>        <td><input type='text' class='form-control' name='b' value='$row[nama_file]' required></td></tr>
                    <tr><th scope='row'>File</th>             <td><input type='file' name='c'>";
                                                                               if ($row['file_upload'] != ''){ echo "<i style='color:red'>Lihat file Saat ini : </i><a href='".base_url().$this->uri->segment(1)."/download/files/$row[file_upload]'>$row[file_upload]</a>"; } echo "</td></tr>
                    
                    <tr id='vcode1_hideshow'><th scope='row'>Waktu Mulai</th>      <td><input type='text' class='form-control' id='datetimepicker1' data-date-format='DD-MM-YYYY HH:mm:ss' value='$tanggal_tugas' name='d'></td></tr>
                    <tr id='vcode2_hideshow'><th scope='row'>Waktu Selesai</th>    <td><input type='text' class='form-control' id='datetimepicker2' data-date-format='DD-MM-YYYY HH:mm:ss' value='$tanggal_selesai' name='e'></td></tr>
                    
                    <tr><th scope='row'>Keterangan</th>       <td><input type='text' class='form-control' name='f' value='$row[keterangan]'></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/detail_bahan_tugas/".$this->uri->segment(4)."'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
