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

<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Pilih Data Beban Biaya PSB</h3>
      <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/beban_biaya_tambah'>Tambahkan Data</a>
    </div><!-- /.box-header -->
    <div class="box-body">
      <form method='POST' class='form-horizontal' action='<?php echo base_url().$this->uri->segment(1); ?>/beban_biaya' enctype='multipart/form-data'>
        <div class='col-md-12'>
          <table class='table table-condensed table-bordered'>
          <tbody>
            <input type='hidden' name='id' value=''>
            <tr><th width='50px' scope='row'>Pilih</th> <td><div class='checkbox-scroll'>
              <?php
                
                  $sek = $this->db->query("SELECT * FROM rb_psb_keuangan where id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
                  $_arrNilai = explode(',', $sek['id_keuangan_jenis']);
                  $keuangan = $this->db->query("SELECT * FROM rb_psb_keuangan_jenis where id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_keuangan_jenis");
                  if ($this->session->sekolah){
                    if ($keuangan->num_rows()==0){
                      echo "<i style='color:red'>Data Beban Biaya PSB masih Kosong pada unit ini, tambahkan melalui button di sudut kanan atas..</i>";
                    }
                  }else{
                    echo "<i style='color:red'>Silahkan Pilih unit / Sekolah Terlebih dahulu...</i>";
                  }
                  foreach ($keuangan->result_array() as $r) {
                    $_ck = (array_search($r['id_keuangan_jenis'], $_arrNilai) === false)? '' : 'checked';
                    echo "<span style='display:inline-block;border-bottom: 1px dotted #8a8a8a; width:97%'><input type=checkbox name='id_keuangan_jenis[]' value='$r[id_keuangan_jenis]' $_ck> $r[keuangan_jenis] </span> 
                          <a class='btn btn-danger btn-xs pull-right' title='Delete Data' href='".base_url().$this->uri->segment(1)."/beban_biaya?hapus=$r[id_keuangan_jenis]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>";
                  }
              ?>
            </div></td></tr>
          </tbody>
          </table>
        </div>
      </div>
      <div class='box-footer'>
            <button type='submit' name='update' class='btn btn-info'>Update</button>
          </div>
      </form>
    </div>
  </div>
</div>