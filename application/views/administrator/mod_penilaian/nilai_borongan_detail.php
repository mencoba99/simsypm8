<?php
$kd = $this->model_app->view_where('rb_kompetensi_dasar',array('id_kompetensi_dasar'=>$this->input->get('kd')))->row_array();
if($this->input->get('tanggal')==''){ $tanggal = date('d-m-Y'); }else{ $tanggal = $this->input->get('tanggal'); }
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Input Nilai Borongan Siswa</h3>
                  <form style='margin-right:5px; margin-top:0px' class='pull-right' action='".base_url().$this->uri->segment(1)."/import_excel_borongan/import_borongan/".$this->uri->segment(3)."' method='POST' enctype='multipart/form-data'>
                    <a title='Lihat Format File' href='".base_url().$this->uri->segment(1)."/export_nilai_borongan/".$this->uri->segment(3)."'><span class='glyphicon glyphicon-file' aria-hidden='true'></span> Format</a> 
                    <input type='file' name='fileexcel' style='padding:3px; width:250px; display:inline-block; border:1px solid #ccc; padding:3px'>
                    <input type='submit' name='tambahkan' style='margin-top:-4px' class='btn btn-info btn-sm' value='Import'>
                    <a style='margin-top:-4px' class='btn btn-primary btn-sm' href='".base_url().$this->uri->segment(1)."/detail_nilai_borongan/".$this->uri->segment(3)."?ambil=1' onclick=\"return confirm('Yakin ingin ambil Data nilai Akhir hingga penginputan saat ini?')\"><span class='fa fa-clone' aria-hidden='true'></span> Ambil Penilaian Akhir</a>
   
                  </form>
                </div>
              <div class='box-body'>
            <form action='".base_url().$this->uri->segment(1)."/detail_nilai_borongan/".$this->uri->segment(3)."'' method='GET' class='form-horizontal' role='form'>
                <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Tahun Akademik</th> <td>$s[nama_tahun]</td></tr>
                    <tr><th scope='row'>Nama Kelas</th>                   <td>$s[nama_kelas]</td></tr>
                    <tr><th scope='row'>Mata Pelajaran</th>               <td>$s[namamatapelajaran]</td></tr>
                    <tr><th scope='row'>Guru</th>                         <td>$s[nama_guru]</td></tr>
                  </tbody>
              </table>
            </form>
            <hr>

            <div class='col-md-12'>";
            if ($_GET['ambil']=='1'){
              echo "<div class='alert alert-success'><center>Sukses Mengambil Nilai, Klik disini untuk <a href='".base_url().$this->uri->segment(1)."/detail_nilai_borongan/".$this->uri->segment(3)."'>Refresh Halaman</a>.</center></div>";
            }
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/detail_nilai_borongan/'.$this->uri->segment(3),$attributes); 
              echo "<table class='table table-bordered table-striped'>
                <thead>
                      <tr style='background:#e3e3e3;'>
                        <th>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th><center>Pengetahuan</center></th>
                        <th><center>Desk. Pengetahuan</center></th>
                        <th><center>Keterampilan</center></th>
                        <th><center>Desk. Keterampilan</center></th>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    $cek = $this->db->query("SELECT * FROM rb_jadwal_pelajaran b JOIN rb_mata_pelajaran a ON a.id_mata_pelajaran=b.id_mata_pelajaran where b.kodejdwl='".$this->uri->segment(3)."' AND a.sesi='1'");
                    if ($cek->num_rows()>=1){
                      $ex = explode(' ', $s['namamatapelajaran']);
                      $ag = $this->db->query("SELECT * FROM rb_agama where nama_agama LIKE '%$ex[1]%'")->row_array();
                      $siswa = $this->db->query("SELECT * FROM rb_siswa a JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin where a.id_kelas='$s[id_kelas]' AND a.id_identitas_sekolah='".$this->session->sekolah."' AND a.id_agama='$ag[id_agama]' AND a.status_siswa='Aktif' ORDER BY a.nama ASC")->result_array();
                      $jumls = $this->db->query("SELECT * FROM rb_siswa a where a.id_kelas='$s[id_kelas]' AND a.id_identitas_sekolah='".$this->session->sekolah."' AND a.id_agama='$ag[id_agama]' AND a.status_siswa='Aktif' ORDER BY a.nama ASC");
                    }else{
                      $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$s['id_kelas'],'id_identitas_sekolah'=>$this->session->sekolah,'status_siswa'=>'Aktif'),'nama','ASC');
                      $jumls = $this->model_app->view_where('rb_siswa',array('id_kelas'=>$s['id_kelas']));
                    }
                    echo "<input type='hidden' name='jumlah' value='".$jumls->num_rows()."'>
                          <input type='hidden' name='kodejdwl' value='".$this->uri->segment(3)."'>
                          <input type='hidden' name='id_tahun_akademik' value='".$s['id_tahun_akademik']."'>
                          <input type='hidden' name='id_mata_pelajaran' value='$s[id_mata_pelajaran]'>";
                    foreach ($siswa as $r) {
                    $ab = $this->db->query("SELECT a.* FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND a.kodejdwl='".$this->uri->segment(3)."'")->row_array();
                    
                    // Ambil Nilai dari Hasil Penilain Guru ===================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================
                    if ($_GET['ambil']=='1'){
                      $kompetensi_dasar = $this->model_app->kd_penilaian($s['id_mata_pelajaran'],$s['id_tahun_akademik'],$s['id_kelas']);
                      $rataasum = 0;
                      foreach ($kompetensi_dasar as $k) {
                        $a = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_tertulis, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_tertulis FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='1' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                        $aa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_lisan, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_lisan FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='4' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                        $aaa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_penugasan, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_penugasan FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='5' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                        $aaaa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_uts, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_uts FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='11' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                        $b = $this->db->query("SELECT a.nilai FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='3' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                        $nilai_tertulis = explode(',',$a['nilai_tertulis']);
                        $nilai_lisan = explode(',',$aa['nilai_lisan']);
                        $nilai_penugasan = explode(',',$aaa['nilai_penugasan']);
                        $nilai_uts = explode(',',$aaaa['nilai_uts']);
                        
                        $remedial = $this->db->query("SELECT max(nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_pengetahuan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]' AND a.id_siswa='$r[id_siswa]'")->row_array();
                          
                          if($remedial['nilai_remedial']==''){
                            $bobot = $this->model_app->view_where('rb_jenis_penilaian_bobot',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
                            if ($bobot['aktif']=='Y'){
                              $lisan      = array_sum($nilai_lisan)/count(array_filter($nilai_lisan))*$bobot['lisan'];
                              $tertulis   = array_sum($nilai_tertulis)/count(array_filter($nilai_tertulis))*$bobot['tertulis'];
                              $penugasan  = array_sum($nilai_penugasan)/count(array_filter($nilai_penugasan))*$bobot['penugasan'];
                              $uts  = array_sum($nilai_uts)/count(array_filter($nilai_uts))*$bobot['uts'];
                              $akhir      = $b['nilai']*$bobot['akhir_semester'];

                              if ($a['nilai_tertulis']!=''){ $nt = $bobot['tertulis']; }else{ $nt = 0; }
                              if ($aa['nilai_lisan']!=''){ $nl = $bobot['lisan']; }else{ $nl = 0; }
                              if ($aaa['nilai_penugasan']!=''){ $np = $bobot['penugasan']; }else{ $np = 0; }
                              if ($aaaa['nilai_uts']!=''){ $nu = $bobot['uts']; }else{ $nu = 0; }
                              if ($b['nilai']!=''){ $n = $bobot['akhir_semester']; }else{ $n = 0; }

                              $bagi = $nt+$nl+$np+$nu+$n;

                              $rata_pengetahuan = ($lisan + $tertulis + $penugasan + $uts + $akhir)/$bagi;
                            }else{
                              if ($a['nilai_tertulis']!=''){ $nt = 1; }else{ $nt = 0; }
                              if ($aa['nilai_lisan']!=''){ $nl = 1; }else{ $nl = 0; }
                              if ($aaa['nilai_penugasan']!=''){ $np = 1; }else{ $np = 0; }
                              if ($aaaa['nilai_uts']!=''){ $nu = 1; }else{ $nu = 0; }
                              if ($b['nilai']!=''){ $n = 1; }else{ $n = 0; }

                              $bagi = $nt+$nl+$np+$nu+$n;

                              $rata_pengetahuan = number_format(array_sum($nilai_tertulis)/count(array_filter($nilai_tertulis))+array_sum($nilai_lisan)/count(array_filter($nilai_lisan))+array_sum($nilai_penugasan)/count(array_filter($nilai_penugasan))+array_sum($nilai_uts)/count(array_filter($nilai_uts))+$b['nilai'])/$bagi;
                            }
                          }elseif ($remedial['nilai_remedial']>$k['kkm']){
                            $rata_pengetahuan = $k['kkm'];
                          }elseif ($remedial['nilai_remedial']<$k['kkm']){
                            $rata_pengetahuan = $remedial['nilai_remedial'];
                          }

                        if (strlen($k['kompetensi_dasar']) > 55){ $kdasar = substr($k['kompetensi_dasar'],0,55).',..';  }else{ $kdasar = $k['kompetensi_dasar']; }
                        $rataasum = $rataasum + $rata_pengetahuan;

                        $nilai[] = $rata_pengetahuan;
                        if (max($nilai)==$rata_pengetahuan){
                          $max_desk = $k['kompetensi_dasar'];
                          if ($k['id_kompetensi_dasar']==''){ $max_id_kompetensi_dasar = 0; }else{ $max_id_kompetensi_dasar = $k['id_kompetensi_dasar']; }
                          $max_rata_pengetahuan_nilai = $rata_pengetahuan;
                        }

                        if (min($nilai)==$rata_pengetahuan){
                          $min_desk = $k['kompetensi_dasar'];
                          if ($k['id_kompetensi_dasar']==''){ $min_id_kompetensi_dasar = 0; }else{ $min_id_kompetensi_dasar = $k['id_kompetensi_dasar']; }
                          $min_kkm = $k['kkm'];
                          $min_rata_pengetahuan_nilai = $rata_pengetahuan;
                        }
                      }

                      $kompetensi_dasar_jml = $this->model_app->kd_penilaian_hitung($s['id_mata_pelajaran'],$s['id_tahun_akademik'],$s['id_kelas']);
                      $nilai_raport = $rataasum/$kompetensi_dasar_jml->num_rows();

                      if ($nilai_raport=='0'){
                          $minus = "";
                          $plus = "-";
                      }else{
                        $max_cek = $this->model_app->view_where('temp_deskripsi',array('id_siswa'=>$r['id_siswa'],'id_kompetensi_dasar'=>$max_id_kompetensi_dasar,'status'=>'pengetahuan'));
                        $max_data = array('id_siswa'=>$r['id_siswa'],
                                        'id_kompetensi_dasar'=>$max_id_kompetensi_dasar,
                                        'rata_rata'=>$max_rata_pengetahuan_nilai,
                                        'status'=>'pengetahuan');
                        if ($max_cek->num_rows()<=0){
                          $this->model_app->insert('temp_deskripsi',$max_data);
                        }else{
                          $max_where = array('id_siswa'=>$r['id_siswa'],'id_kompetensi_dasar'=>$max_id_kompetensi_dasar,'status'=>'pengetahuan');
                          $this->model_app->update('temp_deskripsi', $max_data, $max_where);
                        }

                        $min_cek = $this->model_app->view_where('temp_deskripsi',array('id_siswa'=>$r['id_siswa'],'id_kompetensi_dasar'=>$min_id_kompetensi_dasar,'status'=>'pengetahuan'));
                        $min_data = array('id_siswa'=>$r['id_siswa'],
                                        'id_kompetensi_dasar'=>$min_id_kompetensi_dasar,
                                        'rata_rata'=>$min_rata_pengetahuan_nilai,
                                        'status'=>'pengetahuan');
                        if ($min_cek->num_rows()<=0){
                          $this->model_app->insert('temp_deskripsi',$min_data);
                        }else{
                          $min_where = array('id_siswa'=>$r['id_siswa'],'id_kompetensi_dasar'=>$min_id_kompetensi_dasar,'status'=>'pengetahuan');
                          $this->model_app->update('temp_deskripsi', $min_data, $min_where);
                        }

                        $plus = "Memiliki kemampuan $max_desk";
                        if ($min_rata_pengetahuan_nilai<$min_kkm){
                          $minus = ", namun perlu peningkatan $min_desk";
                        }
                      }



                      // Keterampilan Rumus ================================================
                      $kompetensi_dasar_ket = $this->model_app->kd_penilaianketerampilan($s['id_mata_pelajaran'],$s['id_tahun_akademik'],$s['id_kelas']);
                      $rata_keterampilan_sum = 0;
                      foreach ($kompetensi_dasar_ket as $kk) {
                        $aa = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='1' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$kk[id_kompetensi_dasar]'")->row_array();
                        $bb = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='2' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$kk[id_kompetensi_dasar]'")->row_array();
                        $cc = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='3' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$kk[id_kompetensi_dasar]'")->row_array();
                        $dd = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='4' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$kk[id_kompetensi_dasar]'")->row_array();
                        $jumlah = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$kk[id_kompetensi_dasar]'")->num_rows();
                        $praktek = max($aa['nilai1'],$aa['nilai2'],$aa['nilai3'],$aa['nilai4']);
                        $produk = max($bb['nilai1'],$bb['nilai2'],$bb['nilai3'],$bb['nilai4']);
                        $proyek = max($cc['nilai1'],$cc['nilai2'],$cc['nilai3'],$cc['nilai4']);
                        $portofolio = max($dd['nilai1'],$dd['nilai2'],$dd['nilai3'],$dd['nilai4']);
                        $remediall = $this->db->query("SELECT max(a.nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_keterampilan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND a.id_kompetensi_dasar='$kk[id_kompetensi_dasar]' AND a.id_siswa='$r[id_siswa]'")->row_array();
                          
                        $bobot = $this->model_app->view_where('rb_jenis_penilaian_bobot',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
                        if ($bobot['aktif']=='Y'){
                          if($remediall['nilai_remedial']==''){
                            if ($praktek!=''){ $nt = $bobot['praktek']; }else{ $nt = 0; }
                            if ($produk!=''){ $nl = $bobot['produk']; }else{ $nl = 0; }
                            if ($proyek!=''){ $np = $bobot['proyek']; }else{ $np = 0; }
                            if ($portofolio!=''){ $nu = $bobot['portofolio']; }else{ $nu = 0; }
                            $bagi = $nt+$nl+$np+$nu;
                            $rata_keterampilan = (($praktek*$bobot['praktek'])+($produk*$bobot['produk'])+($proyek*$bobot['proyek'])+($portofolio*$bobot['portofolio']))/$bagi;
                          }elseif ($remediall['nilai_remedial']>$kk['kkm']){
                            $rata_keterampilan = $kk['kkm'];
                          }elseif ($remediall['nilai_remedial']<$kk['kkm']){
                            $rata_keterampilan = $remediall['nilai_remedial'];
                          }
                        }else{
                          if($remediall['nilai_remedial']==''){
                            $rata_keterampilan = ($praktek+$produk+$proyek+$portofolio)/$jumlah;
                          }elseif ($remediall['nilai_remedial']>$kk['kkm']){
                            $rata_keterampilan = $kk['kkm'];
                          }elseif ($remediall['nilai_remedial']<$kk['kkm']){
                            $rata_keterampilan = $remediall['nilai_remedial'];
                          }
                        }
                          
                        if (strlen($kk['kompetensi_dasar']) > 55){ $kdasar = substr($kk['kompetensi_dasar'],0,55).',..';  }else{ $kdasar = $kk['kompetensi_dasar']; }
                        $rata_keterampilan_sum = $rata_keterampilan_sum + $rata_keterampilan;

                        $nilai[] = $rata_keterampilan;
                        if (max($nilai)==$rata_keterampilan){
                          $desk = $kk['kompetensi_dasar'];
                          if ($kk['id_kompetensi_dasar']==''){ $id_kompetensi_dasar = 0; }else{ $id_kompetensi_dasar = $kk['id_kompetensi_dasar']; }
                          $rata_keterampilan_nilai = $rata_keterampilan;
                        }else{
                          $id_kompetensi_dasar = 0;
                          $rata_keterampilan_nilai = 0;
                        }
                      }

                      $kompetensi_dasar_jml = $this->model_app->kd_penilaianketerampilan_hitung($s['id_mata_pelajaran'],$s['id_tahun_akademik'],$s['id_kelas']);
                      $nilai_raport_keterampilan = number_format($rata_keterampilan_sum/$kompetensi_dasar_jml->num_rows());
                      
                      if ($nilai_raport_keterampilan!='0'){
                        $cek = $this->model_app->view_where('temp_deskripsi',array('id_siswa'=>$r['id_siswa'],'id_kompetensi_dasar'=>$id_kompetensi_dasar));
                          $data = array('id_siswa'=>$r['id_siswa'],
                                        'id_kompetensi_dasar'=>$id_kompetensi_dasar,
                                        'rata_rata'=>$rata_keterampilan_nilai,
                                        'status'=>'keterampilan');
                        if ($cek->num_rows()<=0){
                          $this->model_app->insert('temp_deskripsi',$data);
                        }else{
                          $where = array('id_siswa'=>$r['id_siswa'],'id_kompetensi_dasar'=>$id_kompetensi_dasar);
                          $this->model_app->update('temp_deskripsi', $data, $where);
                        }
                        $deskripsi_keterampilan = "Sangat terampil ".$desk;
                      }else{
                        $deskripsi_keterampilan = '-';
                      }


                        $cek = $this->db->query("SELECT * FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]'");
                        if ($cek->num_rows() >= '1'){
                            $data = array('nilai_pengetahuan'=>$nilai_raport,
                                          'deskripsi_pengetahuan'=>$plus.' '.$minus,
                                          'nilai_keterampilan'=>$nilai_raport_keterampilan,
                                          'deskripsi_keterampilan'=>$deskripsi_keterampilan);
                            $where = array('id_siswa'=>$r['id_siswa'],'kodejdwl'=>$this->uri->segment(3));
                            $this->model_app->update('rb_nilai_borongan', $data, $where);
                        }else{
                          $data = array('kodejdwl'=>$this->uri->segment(3),
                                        'id_siswa'=>$r['id_siswa'],
                                        'nilai_pengetahuan'=>$nilai_raport,
                                        'deskripsi_pengetahuan'=>$plus.' '.$minus,
                                        'nilai_keterampilan'=>$nilai_raport_keterampilan,
                                        'deskripsi_keterampilan'=>$deskripsi_keterampilan,
                                        'user_akses'=>$this->session->id_session,
                                        'waktu'=>date('Y-m-d H:i:s'));
                            $this->model_app->insert('rb_nilai_borongan',$data);
                        }
                        
                    }
                    // Akhir Ambil Nilai dari Hasil Penilain Guru ===================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================================
                    

                    echo "<tr><td>$no</td>
                              <td>$r[nipd]</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <input type='hidden' name='id_nilai_borongan".$no."' value='$ab[id_nilai_borongan]'>
                              <input type='hidden' name='id_siswa".$no."' value='$r[id_siswa]'>
                              <td align=center><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='a".$no."' value='$ab[nilai_pengetahuan]' style='width:90px; text-align:center; padding:0px' placeholder='-'></td>
                              <td><textarea name='b".$no."' class='form-control' style='width:100%; height:32px; color:blue' placeholder=' Tuliskan Deskripsi...' onkeyup=\"auto_grow(this)\">$ab[deskripsi_pengetahuan]</textarea></td>
                              <td align=center><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' name='c".$no."' value='$ab[nilai_keterampilan]' style='width:90px; text-align:center; padding:0px' placeholder='-'></td>
                              <td><textarea name='d".$no."' class='form-control' style='width:100%; height:32px; color:blue' placeholder=' Tuliskan Deskripsi...' onkeyup=\"auto_grow(this)\">$ab[deskripsi_keterampilan]</textarea></td>
                          </tr>";
                      $no++;
                    }
                    echo "<tbody>
              </table>
              <div class='box-footer'>
                 <button type='submit' name='submit' class='btn btn-primary pull-right'>Simpan Data Penilaian</button>
              </div>
            </form>
            </div>
            </div>";
  ?>

 <script type="text/javascript">    
<?php echo $jsArray; ?>  
  function changeValue(id){  
    document.getElementById('kkm').value = prdName[id].kkm;  
  };  
</script> 
