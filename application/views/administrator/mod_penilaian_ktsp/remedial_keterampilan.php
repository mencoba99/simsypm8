<!DOCTYPE html>
<html>
<head>
  <title>Data Nilai Remedial</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/bootstrap.min.css">
</head>
<body>
<?php
      if (isset($_POST['simpan'])){
        mysqli_query($koneksi,"INSERT INTO rb_nilai_remedial_keterampilan VALUES('','$_GET[id]','$_POST[tahun]','$_POST[kodejdwl]','$_POST[nisn]','$_POST[kd]','$_POST[rata_rata]','$_POST[nilai_remedial]','N','$_POST[waktu]')");
        echo "<script>document.location='raport_remedial.php?id=$_GET[id]';</script>";
      }

      $d = $this->model_app->view_where('rb_siswa',array('id_siswa'=>$this->input->get('siswa')))->row_array();
      $kd = $this->model_app->view_where('rb_kompetensi_dasar',array('id_kompetensi_dasar'=>$this->input->get('kd')))->row_array();
            echo "<div class='col-xs-12'>  
              <div class='box'>
                <div class='box-header'>
                  <h5 class='box-title alert alert-success'><b>Data Nilai Remedial keterampilan</b> </h5>
                </div>
                <div class='box-body'>
                  <div class='col-md-12'>";
                  $attributes = array('class'=>'form-horizontal','role'=>'form');
                  echo form_open_multipart($this->uri->segment(1).'/remedial_keterampilan?kodejdwl='.$this->input->get('kodejdwl').'&kd='.$this->input->get('kd').'&siswa='.$this->input->get('siswa').'',$attributes); 
                  echo "<table class='table table-condensed table-hover'>
                      <tbody>
                        <tr><th width='140px' scope='row'>NIPD/NISN</th> <td>$d[nipd]/$d[nisn]</td></tr>
                        <tr><th scope='row'>Nama Siswa</th> <td>$d[nama]</td></tr>
                        <tr><th scope='row'>Komp. Dasar</th><td>$kd[kd]. $kd[kompetensi_dasar]</td></tr>
                        <tr><th scope='row'>KKM</th><td>$kd[kkm]</td></tr>
                      </tbody>
                  </table>
                  </div>
                  <table id='example1' class='table table-striped table-condensed'>
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th style='width:40px'>No</th>
                        <th width='150px'>Waktu Input</th>
                        <th width='100px'>Remedial</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                      <tr class='info'>
                        <th></th>
                        <th><input style='width:100%; text-align:center' type='text' name='waktu' value='".date('Y-m-d H:i:s')."'></th>
                        <th><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" style='width:100%; text-align:center' type='number' name='nilai' placeholder='0'></th>
                        <th><button type='submit' name='simpan' class='btn btn-xs btn-primary' style='width:55px'><span class='glyphicon glyphicon-plus'></span></button></th>
                      </form>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    $tampil = $this->model_app->view_where('rb_nilai_remedial_keterampilan',array('kodejdwl'=>$this->input->get('kodejdwl'), 'id_kompetensi_dasar'=>$this->input->get('kd'), 'id_siswa'=>$this->input->get('siswa')));
                    foreach ($tampil->result_array() as $r) {
                    $ex = explode(' ',$r['waktu']);
                    echo "<tr><td>$no</td>
                              <td align=center>$r[waktu]</td>
                              <td align=center>$r[nilai_remedial]</td>
                              <td>
                                <a class='btn btn-danger btn-xs' style='width:55px' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_remedial_keterampilan?kodejdwl=".$this->input->get('kodejdwl')."&kd=".$this->input->get('kd')."&siswa=".$this->input->get('siswa')."&id=$r[id_nilai_remedial_keterampilan]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </td>
                          </tr>";
                      $no++;
                      }
                    echo "</tbody>
                  </table>
                </div>
              </div>
            </div>";
?>
</body>
</html>