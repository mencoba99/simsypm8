<script language="JavaScript" type="text/JavaScript">
 function showCoa(){
   <?php
     $hasil = $this->db->query("SELECT * FROM rb_keuangan_coa");
     foreach ($hasil->result_array() as $data) {
       $idCoa = $data['id_coa'];
       echo "if (document.vcode.d.value == \"".$idCoa."\")";
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
                  <h3 class='box-title'>Tambah Halaman Baru</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form','name'=>'vcode');
              echo form_open_multipart($this->uri->segment(1).'/beban_biaya_tambah',$attributes); 
          echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th scope='row'>Nama Jenis</th> <td><input type='text' class='form-control' name='b'> </td></tr>
                    <tr><th scope='row'>Nominal</th> <td><input type='number' class='form-control' name='c'> </td></tr>
                    <tr><th width='120px' scope='row'>COA</th> <td><select class='form-control' name='d' style='padding:4px' onchange=\"showCoa()\">
                          <option value=''>- Pilih -</option>";
                              $coa = $this->db->query("SELECT * FROM rb_keuangan_coa");
                              foreach ($coa->result_array() as $k) {
                                  echo "<option value='$k[id_coa]'>$k[nama_coa]</option>";
                              }
                          echo "</select>
                    </td></tr>
                    <tr><th width='120px' scope='row'>Sub-COA</th> <td><select id='sub_coa' class='form-control' name='e' style='padding:4px'>
                                                                          <option value='0'>- Pilih -</option>
                                                                       </select>
                    </td></tr>
                  </tbody>
                  </table>
                </div>
              
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url().$this->uri->segment(1)."/beban_biaya'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                    
                  </div>
            </div></div></div>";
            echo form_close();
