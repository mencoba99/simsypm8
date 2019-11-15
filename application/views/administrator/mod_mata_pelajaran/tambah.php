<script language="JavaScript" type="text/JavaScript">
 function showSub(){
   <?php
     $hasil1 = $this->db->query("SELECT * FROM rb_kelompok_mata_pelajaran");
     foreach ($hasil1->result_array() as $data){
       $idSub = $data['id_kelompok_mata_pelajaran'];
       echo "if (document.vcode.b.value == \"".$idSub."\")";
       echo "{";
        $hasil2 = $this->db->query("SELECT * FROM rb_kelompok_mata_pelajaran_sub WHERE id_kelompok_mata_pelajaran='$idSub'");
         $content = "document.getElementById('sub_kel').innerHTML = \"";
             foreach ($hasil2->result_array() as $data2){
                 $content .= "<option value='".$data2['id_kelompok_mata_pelajaran_sub']."'>".$data2['nama_kelompok_mata_pelajaran_sub']."</option>";
             }
           $content .= "\"";
         echo $content;
       echo "}\n";
     }
   ?>
 }
</script>

<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form','name'=>'vcode');
              echo form_open_multipart($this->uri->segment(1).'/tambah_mata_pelajaran',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th width='140px' scope='row'>Kode Pelajaran</th>       <td><input type='text' class='form-control' name='a' onkeyup=\"nospaces(this)\"> </td></tr>
                    <tr><th scope='row'>Nama Mapel</th>           <td><input type='text' class='form-control' name='f'></td></tr>
                    <tr><th scope='row'>Nama Mapel En</th>        <td><input type='text' class='form-control' name='g'></td></tr>
                    <tr><th scope='row'>Jurusan</th> <td><select class='form-control' name='c'> 
                             <option value='0' selected>- Pilih Jurusan -</option>"; 
                              foreach ($jurusan as $a){
                                echo "<option value='$a[id_jurusan]'>$a[nama_jurusan]</option>";
                              }
                             echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Guru Pengampu</th> <td><select class='form-control' name='d'> 
                             <option value='0' selected>- Pilih Guru Pengampu -</option>"; 
                              foreach ($guru as $a){
                                echo "<option value='$a[id_guru]'>$a[nama_guru]</option>";
                              }
                             echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Tingkat</th>              <td><select class='form-control' name='h'>";
                              foreach ($tingkat as $a){
                                echo "<option value='$a[id_tingkat]'>$a[kode_tingkat]</option>";
                              }
                    echo "</select></td></tr>
                    <tr><th scope='row'>Kompetensi Umum</th>           <td><input type='text' class='form-control' name='i'></td></tr>
                    <tr><th scope='row'>Kompetensi Khusus</th>           <td><input type='text' class='form-control' name='j'></td></tr>
                    <tr><th scope='row'>Jumlah Jam</th>           <td><input type='text' class='form-control' name='k'></td></tr>
                    <tr><th scope='row'>Urutan</th>           <td><input type='text' class='form-control' name='ll'></td></tr>
                    <tr><th scope='row'>Paralel</th>           <td><select class='form-control' name='n'>
                                                                    <option value='' selected>- Pilih -</option>"; 
                                                                  $mapel_alias = $this->db->query("SELECT * FROM rb_mata_pelajaran_alias");
                                                                  foreach ($mapel_alias->result_array() as $a){
                                                                    echo "<option value='$a[id_mata_pelajaran_alias]'>$a[namamatapelajaran_alias]</option>";
                                                                  }
                                                                 echo "</td></tr>
                    
                    <tr><th scope='row'>Kelompok</th> <td><select class='form-control' name='b' onchange=\"showSub()\"> 
                             <option value='0' selected>- Pilih Kelompok Mata Pelajaran -</option>"; 
                              foreach ($kelompok as $a){
                                echo "<option value='$a[id_kelompok_mata_pelajaran]'>$a[nama_kelompok_mata_pelajaran]</option>";
                              }
                             echo "</select>
                    </td></tr>
                    
                    <tr><th width='120px'>Sub-Kelompok</th><td>
                    <select class='form-control'id='sub_kel' name='bs' >
                        <option value='' selected>- Pilih Sub Kelompok Mata Pelajaran -</option>";                          
                          foreach ($subkelmpok as $row) {
                            echo "<option value='$row[id_kelompok_mata_pelajaran_sub]'>$row[nama_kelompok_mata_pelajaran_sub]</option>";
                          }
                    echo "</select></td></tr>
                    
                    <input type='hidden' class='form-control' name='kkm' value='0'>
                    <tr><th scope='row'>Karakter</th>                <td><select class='form-control' name='karakter'>
                                                                          <option value=''>- Pilih -</option>";
                                                                          $data_karakter = array('Integritas','Religius','Nasionalis','Mandiri','Gotong-royong');
                                                                          for ($i=0; $i < count($data_karakter); $i++) { 
                                                                              echo "<option value='".$data_karakter[$i]."'>".$data_karakter[$i]."</option>";
                                                                          }
                                                                         echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Aktif</th><td><input type='radio' name='m' value='Ya'> Ya
                                                                 <input type='radio' name='m' value='Tidak' checked> Tidak</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/mata_pelajaran'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
