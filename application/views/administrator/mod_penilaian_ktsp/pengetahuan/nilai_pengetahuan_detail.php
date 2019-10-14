<?php
$kd = $this->model_app->view_where('rb_kompetensi_dasar',array('id_kompetensi_dasar'=>$this->input->get('kd')))->row_array();
if($this->input->get('tanggal')==''){ $tanggal = date('d-m-Y'); }else{ $tanggal = $this->input->get('tanggal'); }
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Input Nilai Akhir Semester Siswa</h3>
                  <a class='btn btn-sm btn-success pull-right' href='".base_url().$this->uri->segment(1)."/pengolahan_nilai_pengetahuan/".$this->uri->segment(3)."'><span class='fa fa-calculator'></span> Pengolahan Nilai Raport</a>
                  
                  <form style='margin-right:5px; margin-top:0px' class='pull-right' action='".base_url().$this->uri->segment(1)."/import_excel_uas/import_uas/".$this->uri->segment(3)."/$s[id_kelas]/$s[id_mata_pelajaran]' method='POST' enctype='multipart/form-data'>
                    <a title='Lihat Format File' href='".base_url().$this->uri->segment(1)."/download/import/format_data_uas.xls'><span class='glyphicon glyphicon-file' aria-hidden='true'></span> Format</a> 
                    <input type='file' name='fileexcel' style='padding:3px; width:250px; display:inline-block; border:1px solid #ccc; padding:3px'>
                    <input type='submit' name='tambahkan' style='margin-top:-4px' class='btn btn-info btn-sm' value='Import'>
                  </form>

                </div>
              <div class='box-body'>
            <form action='".base_url().$this->uri->segment(1)."/detail_nilai_pengetahuan/".$this->uri->segment(3)."'' method='GET' class='form-horizontal' role='form'>
                <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Tahun Akademik</th> <td>$s[nama_tahun]</td></tr>
                    <tr><th scope='row'>Nama Kelas</th>                   <td>$s[nama_kelas]</td></tr>
                    <tr><th scope='row'>Mata Pelajaran</th>               <td>$s[namamatapelajaran]</td></tr>
                    <tr><th scope='row'>Guru</th>                         <td>$s[nama_guru]</td></tr>
                    <tr><th scope='row'>Tgl. Penilaian</th>               <td><input type='text' name='tanggal' class='form-control datepicker' value='$tanggal' style='padding-left:10px'></td></tr>
                    <tr><th scope='row'>Komp. Dasar</th>                  <td><select name='kd' class='form-control' style='padding:4px;' onchange=\"changeValue(this.value)\">
                            <option value=''>- Pilih -</option>";
                            $jsArray = "var prdName = new Array();\n";  
                            $kompetensi_dasar = $this->model_app->view_where_ordering('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$s['id_mata_pelajaran'],'ranah'=>'pengetahuan'),'id_kompetensi_dasar','ASC');
                            $row = $this->model_app->view_where('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$s['id_mata_pelajaran'],'ranah'=>'pengetahuan','id_kompetensi_dasar'=>$this->input->get('kd')))->row_array();
                            foreach ($kompetensi_dasar as $k){
                              if ($this->input->get('kd')==$k['id_kompetensi_dasar']){
                                echo "<option value='$k[id_kompetensi_dasar]' selected>$k[kompetensi_dasar]</option>";
                              }else{
                                echo "<option value='$k[id_kompetensi_dasar]'>$k[kompetensi_dasar]</option>";
                              }
                              $jsArray .= "prdName['" . $k['id_kompetensi_dasar'] . "'] = {kkm:'" .addslashes($k['kkm'])."'};\n";
                            }
                    echo "</select></td></tr>
                    <tr><th scope='row'>KKM</th>         <td><input type='text' name='kkm' class='form-control' value='$kd[kkm]' id='kkm' disabled></td></tr>
                    <tr><th scope='row'></th>            <td><input type='submit' class='btn btn-sm btn-primary' value='Tampilkan Data'></td></tr>
                  </tbody>
              </table>
            </form>
            <hr>

            <div class='panel-body'>
              <ul id='myTabs' class='nav nav-tabs' role='tablist'>
                <li role='presentation' class='active'><a href='#semester' id='semester-tab' role='tab' data-toggle='tab' aria-controls='semester' aria-expanded='true'>Nilai Akhir Semester KD $row[kd]</a></li>
                <li role='presentation' class=''><a href='#rekap' role='tab' id='rekap-tab' data-toggle='tab' aria-controls='rekap' aria-expanded='false'>Rekap Semua Nilai  KD $row[kd]</a></li>
              </ul><br>
            <div id='myTabContent' class='tab-content'>
            <div role='tabpanel' class='tab-pane fade active in' id='semester' aria-labelledby='semester-tab'>
               <div class='col-md-12'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/detail_nilai_pengetahuan/'.$this->uri->segment(3),$attributes); 
              echo "<table class='table table-bordered table-striped'>
                <thead>
                      <tr style='background:#e3e3e3;'>
                        <th>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th><center>Nilai Akhir Semester</center></th>
                      </tr>
                    </thead>
                    <tbody>";
                  if ($this->input->get('tanggal')!=''){
                    $no = 1;
                    $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$s['id_kelas'],'id_identitas_sekolah'=>$this->session->sekolah),'nama','ASC');
                    $jumls = $this->model_app->view_where('rb_siswa',array('id_kelas'=>$s['id_kelas']));
                    echo "<input type='hidden' name='jumlah' value='".$jumls->num_rows()."'>
                          <input type='hidden' name='kd' value='".$this->input->get('kd')."'>
                          <input type='hidden' name='tanggal' value='".$this->input->get('tanggal')."'>
                          <input type='hidden' name='kodejdwl' value='".$this->uri->segment(3)."'>
                          <input type='hidden' name='kategori_nilai' value='3'>
                          <input type='hidden' name='id_mata_pelajaran' value='$s[id_mata_pelajaran]'>
                          <input type='hidden' name='id_tahun_akademik' value='".$s['id_tahun_akademik']."'>";
                    foreach ($siswa as $r) {
                    $a = $this->db->query("SELECT a.* FROM rb_nilai_pengetahuan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND a.kategori_nilai='3' AND a.id_kompetensi_dasar='".$this->input->get('kd')."' AND b.id_tahun_akademik='$s[id_tahun_akademik]'")->row_array();
                    echo "<tr><td>$no</td>
                              <td>$r[nipd]</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <input type='hidden' name='id_siswa".$no."' value='$r[id_siswa]'>
                              <td align=center><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='a".$no."' value='$a[nilai]' style='width:90px; text-align:center; padding:0px' placeholder='-'></td>
                          </tr>";
                      $no++;
                    }
                  }else{
                    echo "<tr><td colspan='5'><center style='padding:60px; color:red'>Silahkan Memilih Memilih Tanggal dan Kompetensi Dasar Terlebih dahulu...</center></td></tr>";
                  }
                    echo "<tbody>
              </table>
              <div class='box-footer'>
                      <button type='submit' name='submit' class='btn btn-primary pull-right'>Simpan Data Penilaian</button>
              </div>
            </form>
              </div>
            </div>

            <div role='tabpanel' class='tab-pane fade' id='rekap' aria-labelledby='rekap-tab'>
               <div class='col-md-12'>
               <table class='table table-bordered table-striped'>
                <thead>
                      <tr style='background:#e3e3e3;'>
                        <th rowspan='2'>No</th>
                        <th rowspan='2'>NIPD</th>
                        <th rowspan='2'>NISN</th>
                        <th rowspan='2'>Nama Siswa</th>
                        <th colspan='3'><center>Nilai / KD</center></th>
                        <th rowspan='2'><center>Akhir Semester</center></th>
                        <th rowspan='2'><center>Rata-rata</center></th>
                      </tr>
                      <tr>
                        <th>Tertulis</th>
                        <th>Lisan</th>
                        <th>Penugasan</th>
                      </tr>
                    </thead>
                    <tbody>";
                  if ($this->input->get('tanggal')!=''){
                    $no = 1;
                    $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$s['id_kelas'],'id_identitas_sekolah'=>$this->session->sekolah),'nama','ASC');
                    $jumls = $this->model_app->view_where('rb_siswa',array('id_kelas'=>$s['id_kelas']));
                    foreach ($siswa as $r) {
                    $a = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_tertulis, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_tertulis FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='1' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='".$this->input->get('kd')."'")->row_array();
                    $aa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_lisan, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_lisan FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='4' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='".$this->input->get('kd')."'")->row_array();
                    $aaa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_penugasan, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_penugasan FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='5' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='".$this->input->get('kd')."'")->row_array();
                    $b = $this->db->query("SELECT a.nilai FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='3' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='".$this->input->get('kd')."'")->row_array();
                    
                    $nilai_tertulis = explode(',',$a['nilai_tertulis']);
                    $nilai_lisan = explode(',',$aa['nilai_lisan']);
                    $nilai_penugasan = explode(',',$aaa['nilai_penugasan']);
                    $remedial = $this->db->query("SELECT max(a.nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_pengetahuan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND a.id_kompetensi_dasar='".$this->input->get('kd')."' AND a.id_siswa='$r[id_siswa]'")->row_array();
                    
                    if($remedial['nilai_remedial']==''){
                      $bobot = $this->model_app->view_where('rb_jenis_penilaian_bobot',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
                      if ($bobot['aktif']=='Y'){
                        $lisan      = array_sum($nilai_tertulis)/count(array_filter($nilai_lisan))*$bobot['lisan'];
                        $tertulis   = array_sum($nilai_tertulis)/count(array_filter($nilai_tertulis))*$bobot['tertulis'];
                        $penugasan  = array_sum($nilai_penugasan)/count(array_filter($nilai_penugasan))*$bobot['penugasan'];
                        $akhir      = $b['nilai']*$bobot['akhir_semester'];
                        $rataa = number_format(($lisan + $tertulis + $penugasan + $akhir)/($bobot['lisan']+$bobot['tertulis']+$bobot['penugasan']+$bobot['akhir_semester']));
                      }else{
                        $rataa = number_format(array_sum($nilai_tertulis)/count(array_filter($nilai_tertulis))+array_sum($nilai_lisan)/count(array_filter($nilai_lisan))+array_sum($nilai_penugasan)/count(array_filter($nilai_penugasan))+$b['nilai'])/4;
                      }
                    }elseif ($remedial['nilai_remedial']>$k['kkm']){
                      $rataa = $k['kkm'];
                    }elseif ($remedial['nilai_remedial']<$k['kkm']){
                      $rataa = $remedial['nilai_remedial'];
                    }

                    echo "<tr><td>$no</td>
                              <td>$r[nipd]</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <td><a data-toggle='tooltip' data-placement='right' title='$a[tanggal_nilai_tertulis]' href=''>$a[nilai_tertulis]</a></td>
                              <td><a data-toggle='tooltip' data-placement='right' title='$aa[tanggal_nilai_lisan]' href=''>$aa[nilai_lisan]</a></td>
                              <td><a data-toggle='tooltip' data-placement='right' title='$aaa[tanggal_nilai_penugasan]' href=''>$aaa[nilai_penugasan]</a></td>
                              <td align=center>$b[nilai]</td>";
                              if ($row['kkm']<=$rataa){
                                echo "<td align=center><a class='btn btn-xs btn-default' href=''>".number_format($rataa)."</a></td>";
                              }else{
                                if($remedial['nilai_remedial']==''){
                                  $rata_rata = $rataa;
                                }elseif ($remedial['nilai_remedial']>$row['kkm']){
                                  $rata_rata = $row['kkm'];
                                }elseif ($remedial['nilai_remedial']<$row['kkm']){
                                  $rata_rata = $remedial['nilai_remedial'];
                                }
                                echo "<td align=center><a class='btn btn-xs btn-danger' href='' onclick=\"return popup('".base_url().$this->uri->segment(1)."/remedial_pengetahuan?kodejdwl=".$this->uri->segment(3)."&kd=".$this->input->get('kd')."&siswa=$r[id_siswa]')\">".number_format($rata_rata)."</a></td>";
                              }
                          echo "</tr>";
                      $no++;
                    }
                  }else{
                    echo "<tr><td colspan='7'><center style='padding:60px; color:red'>Silahkan Memilih Memilih Tanggal dan Kompetensi Dasar Terlebih dahulu...</center></td></tr>";
                  }
                    echo "<tbody>
              </table>
              </div>
            </div>

            </div>
            </div>
            </div>";
  ?>
 <script type="text/javascript">    
<?php echo $jsArray; ?>  
  function changeValue(id){  
    document.getElementById('kkm').value = prdName[id].kkm;  
  };  
</script> 
