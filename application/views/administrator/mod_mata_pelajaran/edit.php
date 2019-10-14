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
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form','name'=>'vcode');
              echo form_open_multipart($this->uri->segment(1).'/edit_mata_pelajaran',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_mata_pelajaran]'>
                    <tr><th width='140px' scope='row'>Kode Pelajaran</th>       <td><input type='text' class='form-control' name='a' value='$s[kode_pelajaran]' onkeyup=\"nospaces(this)\"> </td></tr>
                    <tr><th scope='row'>Nama Mapel</th>           <td><input type='text' class='form-control' name='f' value='$s[namamatapelajaran]'></td></tr>
                    <tr><th scope='row'>Nama Mapel En</th>        <td><input type='text' class='form-control' name='g' value='$s[namamatapelajaran_en]'></td></tr>
                    <tr><th scope='row'>Jurusan</th> <td><select class='form-control' name='c'> 
                             <option value='0' selected>- Pilih Jurusan -</option>"; 
                              foreach ($jurusan as $a){
                                    if ($s['id_jurusan']==$a['id_jurusan']){
                                       echo "<option value='$a[id_jurusan]' selected>$a[nama_jurusan]</option>";
                                    }else{
                                       echo "<option value='$a[id_jurusan]'>$a[nama_jurusan]</option>";
                                    }
                                  }
                             echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Guru Pengampu</th> <td><select class='form-control' name='d'> 
                             <option value='0' selected>- Pilih Guru Pengampu -</option>"; 
                              foreach ($guru as $a){
                                    if ($s['id_guru']==$a['id_guru']){
                                       echo "<option value='$a[id_guru]' selected>$a[nama_guru]</option>";
                                    }else{
                                       echo "<option value='$a[id_guru]'>$a[nama_guru]</option>";
                                    }
                                  }
                             echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Tingkat</th>              <td><select class='form-control' name='h'>";
                          foreach ($tingkat as $r){
                            if ($s['id_tingkat']==$r['id_tingkat']){
                              echo "<option value='$r[id_tingkat]' selected>$r[kode_tingkat]</option>";
                            }else{
                              echo "<option value='$r[id_tingkat]'>$r[kode_tingkat]</option>";
                            }
                          }
                    echo "</select></td></tr>
                    <tr><th scope='row'>Kompetensi Umum</th>           <td><input type='text' class='form-control' name='i' value='$s[kompetensi_umum]'></td></tr>
                    <tr><th scope='row'>Kompetensi Khusus</th>           <td><input type='text' class='form-control' name='j' value='$s[kompetensi_khusus]'></td></tr>
                    <tr><th scope='row'>Jumlah Jam</th>           <td><input type='text' class='form-control' name='k' value='$s[jumlah_jam]'></td></tr>
                    <tr><th scope='row'>Urutan</th>           <td><input type='text' class='form-control' name='ll' value='$s[urutan]'></td></tr>
                    <tr><th scope='row'>Paralel</th>           <td><select class='form-control' name='n'>
                                                                    <option value='' selected>- Pilih -</option>"; 
                                                                  $mapel_alias = $this->db->query("SELECT * FROM rb_mata_pelajaran_alias");
                                                                  foreach ($mapel_alias->result_array() as $a){
                                                                    if ($s['sesi']==$a['id_mata_pelajaran_alias']){
                                                                        echo "<option value='$a[id_mata_pelajaran_alias]' selected>$a[namamatapelajaran_alias]</option>";
                                                                    }else{
                                                                        echo "<option value='$a[id_mata_pelajaran_alias]'>$a[namamatapelajaran_alias]</option>";
                                                                    }
                                                                  }
                                                                 echo "</td></tr>
                    <tr><th scope='row'>Kelompok</th> <td><select class='form-control' name='b' onchange=\"showSub()\"> 
                             <option value='0' selected>- Pilih Kelompok Mata Pelajaran -</option>"; 
                              foreach ($kelompok as $a){
                                    if ($s['id_kelompok_mata_pelajaran']==$a['id_kelompok_mata_pelajaran']){
                                       echo "<option value='$a[id_kelompok_mata_pelajaran]' selected>$a[nama_kelompok_mata_pelajaran]</option>";
                                    }else{
                                       echo "<option value='$a[id_kelompok_mata_pelajaran]'>$a[nama_kelompok_mata_pelajaran]</option>";
                                    }
                                  }
                             echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Sub-Kelompok</th> <td><select class='form-control' id='sub_kel' name='bs'> 
                             <option value='0' selected>- Pilih Sub-Kelompok Mata Pelajaran -</option>"; 
                              foreach ($subkelompok as $a){
                                    if ($s['id_kelompok_mata_pelajaran_sub']==$a['id_kelompok_mata_pelajaran_sub']){
                                       echo "<option value='$a[id_kelompok_mata_pelajaran_sub]' selected>$a[nama_kelompok_mata_pelajaran_sub]</option>";
                                    }else{
                                       echo "<option value='$a[id_kelompok_mata_pelajaran_sub]'>$a[nama_kelompok_mata_pelajaran_sub]</option>";
                                    }
                                  }
                             echo "</select>
                    </td></tr>
                    <input type='hidden' class='form-control' name='kkm' value=''>
                    <tr><th scope='row'>KKM</th>           <td><input type='text' class='form-control' name='kkm' value='$s[kkm]'></td></tr>
                    <tr><th scope='row'>Karakter</th>                <td><select class='form-control' name='karakter'>
                                                                          <option value=''>- Pilih -</option>";
                                                                          $data_karakter = array('Integritas','Religius','Nasionalis','Mandiri','Gotong-royong');
                                                                          for ($i=0; $i < count($data_karakter); $i++) { 
                                                                            if ($s['karakter']==$data_karakter[$i]){
                                                                              echo "<option value='".$data_karakter[$i]."' selected>".$data_karakter[$i]."</option>";
                                                                            }else{
                                                                              echo "<option value='".$data_karakter[$i]."'>".$data_karakter[$i]."</option>";
                                                                            }
                                                                          }
                                                                         echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Aktif</th><td>";
                                                      if ($s['aktif']=='Ya'){
                                                          echo "<input type='radio' name='m' value='Ya' checked> Ya
                                                                 <input type='radio' name='m' value='Tidak'> Tidak";
                                                      }else{
                                                          echo "<input type='radio' name='m' value='Ya'> Ya
                                                                 <input type='radio' name='m' value='Tidak' checked> Tidak";
                                                      }
                  echo "</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/mata_pelajaran'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
