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

<?php if ($_GET['act']==''){
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Setting COA Penjualan Koperasi</h3>
                </div>
              <div class='box-body'>
              <form method='POST' name='vcode' class='form-horizontal' action='".base_url()."keuangan/coa_koperasi' enctype='multipart/form-data'>
                <div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_setting_coa]'>
                    <tr><th width='120px' scope='row'>Nama Jenis</th> <td><input type='text' class='form-control' name='a' value='$s[nama_jenis]'> </td></tr>
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
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='update' class='btn btn-info'>Update</button>
                    <a href='#'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                    
                  </div>
              </form>
            </div>";
}
?>