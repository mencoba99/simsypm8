<script language="JavaScript" type="text/JavaScript">
 function showCoa(){
   <?php
     $hasil = $this->db->query("SELECT * FROM rb_keuangan_coa");
     foreach ($hasil->result_array() as $data) {
       $idCoa = $data['id_coa'];
       echo "if (document.vcode.c.value == \"".$idCoa."\")";
       echo "{";
        $hasil2 = $this->db->query("SELECT * FROM rb_keuangan_sub_coa WHERE id_coa = $idCoa");
         $content = "document.getElementById('sub_coa').innerHTML = \"";
             foreach ($hasil2->result_array() as $data2) {
                 $content .= "<option value='".$data2['id_sub_coa']."'>".$data2['nama_sub_coa']."</option>";
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
                  <h3 class='box-title'>Setting PPDB Online</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form','name'=>'vcode');
              echo form_open_multipart($this->uri->segment(1).'/setting',$attributes); 
          echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Harga Formulir</th> <td><input type='number' class='form-control' name='a' value='$s[formulir]'> </td></tr>
                    <tr><th width='120px' scope='row'>COA</th> <td><select class='form-control' name='c' style='padding:4px' onchange=\"showCoa()\">
                          <option value=''>- Pilih -</option>";
                              $coa = $this->db->query("SELECT * FROM rb_keuangan_coa");
                              foreach ($coa->result_array() as $k) {
                                if ($s['id_coa']==$k['id_coa']){
                                  echo "<option value='$k[id_coa]' selected>$k[nama_coa]</option>";
                                }else{
                                  echo "<option value='$k[id_coa]'>$k[nama_coa]</option>";
                                }
                              }
                          echo "</select>
                    </td></tr>
                    <tr><th width='120px' scope='row'>Sub-COA</th> <td><select id='sub_coa' class='form-control' name='d' style='padding:4px'>
                          <option value=''>- Pilih -</option>";
                              $sub_coa = $this->db->query("SELECT * FROM rb_keuangan_sub_coa");
                              foreach ($sub_coa->result_array() as $k) {
                                if ($s['id_sub_coa']==$k['id_sub_coa']){
                                  echo "<option value='$k[id_sub_coa]' selected>$k[nama_sub_coa]</option>";
                                }else{
                                  echo "<option value='$k[id_sub_coa]'>$k[nama_sub_coa]</option>";
                                }
                              }
                          echo "</select>
                    </td></tr>
                    <tr><th width='120px' scope='row'>Pendaftaran</th> <td><select class='form-control' name='e' style='padding:4px'>";
                                      $data = array('Ya','Tidak');
                                      $dataa = array('Terbuka','Telah Ditutup');
                                      for ($i=0; $i < count($data) ; $i++) { 
                                          if ($s['aktif']==$data[$i]){
                                              echo "<option value='".$data[$i]."' selected>".$dataa[$i]."</option>";
                                          }else{
                                              echo "<option value='".$data[$i]."'>".$dataa[$i]."</option>";
                                          }
                                      }
                    echo "</select></td></tr>
                  </tbody>
                  </table>
                </div>
              
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    
                  </div>
            </div></div></div>";
            echo form_close();
