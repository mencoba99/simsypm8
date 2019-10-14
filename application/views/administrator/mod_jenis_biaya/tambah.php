<script language="JavaScript" type="text/JavaScript">
 function showCoa(){
   <?php
     foreach ($coa as $data) {
       $idCoa = $data['id_coa'];
       echo "if (document.vcode.c.value == \"".$idCoa."\")";
       echo "{";
         $content = "document.getElementById('sub_coa').innerHTML = \"";
         $sub_coa2 = $this->model_app->view_where_ordering('rb_keuangan_sub_coa',array('id_coa'=>$idCoa),'id_sub_coa','ASC');
             foreach ($sub_coa2 as $data2) {
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
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form','name'=>'vcode');
              echo form_open_multipart($this->uri->segment(1).'/tambah_jenis_biaya',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='tahun' value='$_GET[tahun]'>
                    <input type='hidden' name='kelas' value='$_GET[kelas]'>
                    <tr><th width='120px' scope='row'>Nama Jenis</th> <td><input type='text' class='form-control' name='a' required> </td></tr>
                    <tr><th scope='row'>Total Beban</th> <td><input type='number' class='form-control' name='b'> </td></tr>
                    <tr><th width='120px' scope='row'>COA</th> <td><select class='form-control' name='c' style='padding:4px' onchange=\"showCoa()\" required>
                          <option value=''>- Pilih -</option>";
                              foreach ($coa as $k) {
                                  echo "<option value='$k[id_coa]'>$k[nama_coa]</option>";
                              }
                          echo "</select>
                    </td></tr>
                    <tr><th width='120px' scope='row'>Sub-COA</th> <td>
                        <select class='form-control' id='sub_coa' name='d' style='padding:4px'>
                        </select>
                    </td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/jenis_biaya?tahun=$_GET[tahun]&kelas=$_GET[kelas]'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
