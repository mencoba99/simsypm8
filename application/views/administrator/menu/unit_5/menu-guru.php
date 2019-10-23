<?php 
  $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya','id_identitas_sekolah'=>$this->session->sekolah))->row_array();
?>
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
            <?php $usr = $this->model_app->view_where('rb_guru', array('id_guru'=> $this->session->id_session))->row_array();
                  if (trim($usr['foto'])=='' OR !file_exists("asset/foto_pegawai/".$usr['foto'])){ $foto = 'blank.png'; }else{ $foto = $usr['foto']; } ?>
            <img style='height:45px' src="<?php echo base_url(); ?>asset/foto_pegawai/<?php echo $foto; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <?php echo "<p>$usr[nama_guru]</p>"; ?>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header" style='color:#fff; text-transform:uppercase;'>MENU <span class='uppercase'><?php echo $this->session->level; ?></span></li>
            <li><a href="<?php echo base_url()."".$sekolah[keyword]; ?>/home"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>                  
           
            <li class="treeview">
              <a href="#"><i class="fa fa-wrench"></i> <span>Proses Akademik</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
              <?php
                $cek=$this->model_app->umenu_akses("kelompok_mapel",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/kelompok_mapel'><i class='fa fa-circle-o'></i> Kelompok Mapel</a></li>";
                }

                $cek=$this->model_app->umenu_akses("kelompok_mapel_sub",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/kelompok_mapel_sub'><i class='fa fa-circle-o'></i> Sub-Kelompok Mapel</a></li>";
                }

                $cek=$this->model_app->umenu_akses("mata_pelajaran",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/mata_pelajaran'><i class='fa fa-circle-o'></i> Mata Pelajaran</a></li>";
                }

                $cek=$this->model_app->umenu_akses("jadwal_pelajaran",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/jadwal_pelajaran'><i class='fa fa-circle-o'></i> Jadwal Pelajaran</a></li>";
                }

                $cek=$this->model_app->umenu_akses("bahan_tugas",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/bahan_tugas'><i class='fa fa-circle-o'></i> Bahan dan Tugas</a></li>";
                }

                $cek=$this->model_app->umenu_akses("kompetensi_dasar",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/kompetensi_dasar'><i class='fa fa-circle-o'></i> Kompetensi Dasar</a></li>";
                }

                $cek=$this->model_app->umenu_akses("penilaian_diri",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/penilaian_diri'><i class='fa fa-circle-o'></i> Penilaian Diri</a></li>";
                }

                $cek=$this->model_app->umenu_akses("penilaian_teman",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/penilaian_teman'><i class='fa fa-circle-o'></i> Penilaian Teman</a></li>";
                }

                $cek=$this->model_app->umenu_akses("jurnal_kbm",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/jurnal_kbm'><i class='fa fa-circle-o'></i> Jurnal KBM</a></li>";
                }
              ?>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fa fa-check-square-o"></i> <span>Kehadiran / Absensi</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
              <?php
                $cek=$this->model_app->umenu_akses("absensi_guru",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/absensi_guru'><i class='fa fa-circle-o'></i> Guru</a></li>";
                }

                $cek=$this->model_app->umenu_akses("absensi_siswa",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/absensi_siswa'><i class='fa fa-circle-o'></i> Siswa</a></li>";
                }
              ?>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fa fa-pencil-square-o"></i> <span>Proses Penilaian</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
              <?php 
                $cek=$this->model_app->umenu_akses("nilai_observasi",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/nilai_observasi'><i class='fa fa-circle-o'></i> Jurnal Guru</a></li>";
                }

                $cek=$this->model_app->umenu_akses("nilai_pengetahuan",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li class='treeview'>
                        <a href='".base_url()."$sekolah[keyword]/nilai_pengetahuan'><i class='fa fa-circle-o'></i> Pengetahuan
                          <span class='pull-right-container'>
                            <i class='fa fa-angle-left pull-right'></i>
                          </span>
                        </a>
                        <ul class='treeview-menu'>
                          <li><a href='".base_url()."$sekolah[keyword]/nilai_lisan'><i class='fa fa-circle-o'></i> Lisan</a></li>
                          <li><a href='".base_url()."$sekolah[keyword]/nilai_tertulis'><i class='fa fa-circle-o'></i> Tertulis</a></li>
                          <li><a href='".base_url()."$sekolah[keyword]/nilai_penugasan'><i class='fa fa-circle-o'></i> Penugasan</a></li>
                          <li><a href='".base_url()."$sekolah[keyword]/nilai_uts_kd'><i class='fa fa-circle-o'></i> UTS</a></li>
                          <li><a href='".base_url()."$sekolah[keyword]/nilai_pengetahuan'><i class='fa fa-circle-o'></i> Nilai Akhir</a></li>
                        </ul>
                      </li>";
                }

                $cek=$this->model_app->umenu_akses("nilai_keterampilan",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/nilai_keterampilan'><i class='fa fa-circle-o'></i> Keterampilan</a></li>";
                }

                $record_sikap = $this->model_app->jadwal_pelajaran_guru_sikap($thn['id_tahun_akademik'],1);
                if ($record_sikap->num_rows()>=1){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/spiritual_dan_sosial'><i class='fa fa-circle-o'></i> Spiritual dan Sosial</a></li>";
                }
              ?>
              </ul>
            </li>
            <?php 
                $cek=$this->model_app->umenu_akses("forum",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."$sekolah[keyword]/forum'><i class='fa fa-th-list'></i> <span>Forum Diskusi</span></a></li>";
                }

                $wali_kelas = $this->model_app->view_where('rb_kelas',array('id_guru'=>$this->session->id_session));
                if ($wali_kelas->num_rows()>=1){
                  $row = $wali_kelas->row_array();
                  echo "<li class='treeview'>
                  <a href='#'><i class='fa fa-list-ul'></i> <span>Menu Wali Kelas</span><i class='fa fa-angle-left pull-right'></i></a>
                  <ul class='treeview-menu'>";
                    
                    $cek=$this->model_app->umenu_akses("kegiatan_siswa",$this->session->id_session);
                    if($cek==1 OR $this->session->level=='admin'){
                      echo "<li><a href='".base_url()."$sekolah[keyword]/kegiatan_siswa'><i class='fa fa-circle-o'></i> Kegiatan Siswa</a></li>";
                    }

                    $cek=$this->model_app->umenu_akses("nilai_observasi_wakel",$this->session->id_session);
                    if($cek==1 OR $this->session->level=='admin'){
                      echo "<li><a href='".base_url()."$sekolah[keyword]/nilai_observasi_wakel'><i class='fa fa-circle-o'></i> Jurnal Wali Kelas</a></li>";
                    }

                    $cek=$this->model_app->umenu_akses("nilai_ekstrakurikuler",$this->session->id_session);
                    if($cek==1 OR $this->session->level=='admin'){
                      echo "<li><a href='".base_url()."$sekolah[keyword]/nilai_ekstrakurikuler?tahun=$thn[id_tahun_akademik]&kelas=$row[id_kelas]'><i class='fa fa-circle-o'></i> Ekstrakurikuler</a></li>";
                    }
                    
                    $cek=$this->model_app->umenu_akses("nilai_pkl",$this->session->id_session);
                    if($cek==1 OR $this->session->level=='admin'){
                      echo "<li><a href='".base_url()."$sekolah[keyword]/nilai_pkl?tahun=$thn[id_tahun_akademik]&kelas=$row[id_kelas]'><i class='fa fa-circle-o'></i> Prakter Kerja Lapangan</a></li>";
                    }

                    $cek=$this->model_app->umenu_akses("nilai_prestasi",$this->session->id_session);
                    if($cek==1 OR $this->session->level=='admin'){
                      echo "<li><a href='".base_url()."$sekolah[keyword]/nilai_prestasi?tahun=$thn[id_tahun_akademik]&kelas=$row[id_kelas]'><i class='fa fa-circle-o'></i> Prestasi Siswa</a></li>";
                    }

                    $cek=$this->model_app->umenu_akses("catatan_akademik",$this->session->id_session);
                    if($cek==1 OR $this->session->level=='admin'){
                      echo "<li><a href='".base_url()."$sekolah[keyword]/catatan_akademik?tahun=$thn[id_tahun_akademik]&kelas=$row[id_kelas]'><i class='fa fa-circle-o'></i> Catatan Akademik</a></li>";
                    }
                    
                    $cek=$this->model_app->umenu_akses("karakter",$this->session->id_session);
                    if($cek==1 OR $this->session->level=='admin'){
                      echo "<li><a href='".base_url()."$sekolah[keyword]/karakter?tahun=$thn[id_tahun_akademik]&kelas=$row[id_kelas]'><i class='fa fa-circle-o'></i> Perkembangan Karakter</a></li>";
                    }
                    
                    $cek=$this->model_app->umenu_akses("catatan_wakel",$this->session->id_session);
                    if($cek==1 OR $this->session->level=='admin'){
                      echo "<li><a href='".base_url()."$sekolah[keyword]/catatan_wakel?tahun=$thn[id_tahun_akademik]&kelas=$row[id_kelas]'><i class='fa fa-circle-o'></i> Ctt. Perkembangan Karakter</a></li>";
                    }
                    
                    $cek=$this->model_app->umenu_akses("nilai_borongan",$this->session->id_session);
                    if($cek==1 OR $this->session->level=='admin'){
                      echo "<li class='treeview'>
                            <a href='#'><i class='fa fa-circle-o'></i> Input Nilai Borongan (Raport)
                              <span class='pull-right-container'>
                                <i class='fa fa-angle-left pull-right'></i>
                              </span>
                            </a>
                            <ul class='treeview-menu'>
                            <li><a href='".base_url()."$sekolah[keyword]/absensi_borongan?tahun=$thn[id_tahun_akademik]&kelas=$row[id_kelas]'><i class='fa fa-circle-o'></i> Absensi Siswa</a></li>
                              <li><a href='".base_url()."$sekolah[keyword]/nilai_borongan_sikap?tahun=$thn[id_tahun_akademik]&kelas=$row[id_kelas]'><i class='fa fa-circle-o'></i> Spiritual dan Sosial</a></li>
                              <li><a href='".base_url()."$sekolah[keyword]/nilai_borongan?tahun=$thn[id_tahun_akademik]&kelas=$row[id_kelas]'><i class='fa fa-circle-o'></i> Pengetahuan & Keterampilan</a></li>
                            </ul>
                          </li>";
                    }

                    $cek=$this->model_app->umenu_akses("cetak_uts",$this->session->id_session);
                    if($cek==1 OR $this->session->level=='admin'){
                      echo "<li><a href='".base_url()."$sekolah[keyword]/cetak_uts?angkatan=&tahun=$thn[id_tahun_akademik]&kelas=$row[id_kelas]'><i class='fa fa-circle-o'></i> Raport UTS</a></li>";
                    }

                    $cek=$this->model_app->umenu_akses("cetak_semester",$this->session->id_session);
                    if($cek==1 OR $this->session->level=='admin'){
                      echo "<li><a href='".base_url()."$sekolah[keyword]/cetak_semester?angkatan=&tahun=$thn[id_tahun_akademik]&kelas=$row[id_kelas]'><i class='fa fa-circle-o'></i> Raport Akhir</a></li>";
                    }


                  echo "</ul>
                </li>";
                }

                $cek_piket = $this->model_app->view_where('rb_guru',array('id_guru'=>$this->session->id_session,'guru_piket'=>'Ya'))->num_rows();
                if ($cek_piket>=1){
                  echo "<li class='treeview'>
                    <a href='#'><i class='fa fa-th-large'></i> <span>Menu Guru Piket</span><i class='fa fa-angle-left pull-right'></i></a>
                    <ul class='treeview-menu'>";
                      $cek=$this->model_app->umenu_akses("absensi_siswa_harian",$this->session->id_session);
                      if($cek==1 OR $this->session->level=='admin'){
                        echo "<li><a href='".base_url()."$sekolah[keyword]/absensi_siswa_harian'><i class='fa fa-circle-o'></i> Siswa Harian</a></li>";
                      }

                      $cek=$this->model_app->umenu_akses("absensi_guru",$this->session->id_session);
                      if($cek==1 OR $this->session->level=='admin'){
                      echo "<li><a href='".base_url()."$sekolah[keyword]/absensi_guru'><i class='fa fa-circle-o'></i> Guru</a></li>";
                      }
                    echo "</ul>
                  </li>";
                }

                $cek_bk = $this->model_app->view_where('rb_guru',array('id_guru'=>$this->session->id_session,'guru_bk'=>'Ya'))->num_rows();
                if ($cek_bk>=1){
                  echo "<li class='treeview'>
                    <a href='#'><i class='fa fa-user-secret'></i> <span>Bimbingan Konseling</span><i class='fa fa-angle-left pull-right'></i></a>
                    <ul class='treeview-menu'>";
                      $cek=$this->model_app->umenu_akses("nilai_observasi_bk",$this->session->id_session);
                      if($cek==1 OR $this->session->level=='admin'){
                        echo "<li><a href='".base_url()."$sekolah[keyword]/nilai_observasi_bk'><i class='fa fa-circle-o'></i> Jurnal BK</a></li>";
                      }

                      $cek=$this->model_app->umenu_akses("jenis_pelanggaran",$this->session->id_session);
                      if($cek==1 OR $this->session->level=='admin'){
                        echo "<li><a href='".base_url()."$sekolah[keyword]/jenis_pelanggaran'><i class='fa fa-circle-o'></i> Jenis Pelanggaran</a></li>";
                      }

                      $cek=$this->model_app->umenu_akses("sanksi_pelanggaran",$this->session->id_session);
                      if($cek==1 OR $this->session->level=='admin'){
                        echo "<li><a href='".base_url()."$sekolah[keyword]/sanksi_pelanggaran'><i class='fa fa-circle-o'></i> Sanksi Pelanggaran</a></li>";
                      }

                      $cek=$this->model_app->umenu_akses("rekam_kasus",$this->session->id_session);
                      if($cek==1 OR $this->session->level=='admin'){
                        echo "<li><a href='".base_url()."$sekolah[keyword]/rekam_kasus'><i class='fa fa-circle-o'></i> Rekam Kasus</a></li>";
                      }

                      $cek=$this->model_app->umenu_akses("rekap_kasus",$this->session->id_session);
                      if($cek==1 OR $this->session->level=='admin'){
                        echo "<li><a href='".base_url()."$sekolah[keyword]/rekap_kasus'><i class='fa fa-circle-o'></i> Rekapitulasi Kasus</a></li>";
                      }
                    echo "</ul>
                  </li>";
                }

                $cek_bkk = $this->model_app->view_where('rb_guru',array('id_guru'=>$this->session->id_session,'guru_bkk'=>'Ya'))->num_rows();
                if ($cek_bkk>=1){
                  echo "<li class='treeview'>
                    <a href='#'><i class='fa fa-user-secret'></i> <span>Bursa Kerja Khusus</span><i class='fa fa-angle-left pull-right'></i></a>
                    <ul class='treeview-menu'>";
                      $cek=$this->model_app->umenu_akses("tracer_alumni",$this->session->id_session);
                      if($cek==1 OR $this->session->level=='admin'){
                        echo "<li><a href='".base_url()."/alumni/tracer_alumni'><i class='fa fa-circle-o'></i> Tracer Study</a></li>";
                    }
                      $cek=$this->model_app->umenu_akses("alumni_bkk",$this->session->id_session);
                      if($cek==1 OR $this->session->level=='admin'){
                        echo "<li><a href='".base_url()."alumni/alumni_bkk'><i class='fa fa-circle-o'></i> Mitra Industri</a></li>";
                    }
                      $cek=$this->model_app->umenu_akses("pengumuman",$this->session->id_session);
                      if($cek==1 OR $this->session->level=='admin'){
                        echo "<li><a href='".base_url()."alumni/pengumuman'><i class='fa fa-circle-o'></i> Pengumuman</a></li>";
                    }
                      echo "</ul>
                    </li>";
                  }

                echo "<li class='treeview'>
                  <a href='#'><i class='fa fa-th-large'></i> <span>Aplikasi Lainnya</span><i class='fa fa-angle-left pull-right'></i></a>
                  <ul class='treeview-menu'>";
                     if ($usr['laboratorium']=='Ya'){
                      echo "<li class='treeview'>
                        <a href='#''><i class='fa fa-user-secret'></i> <span>Laboratorium</span><i class='fa fa-angle-left pull-right'></i></a>
                        <ul class='treeview-menu'>";
                          $cek=$this->model_app->umenu_akses("labor_kasus",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."$sekolah[keyword]/labor_kasus'><i class='fa fa-circle-o'></i> Data Alat Rusak</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("laporan_laboratorium",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."smk/laporan_laboratorium'><i class='fa fa-circle-o'></i> Laporan Alat Rusak</a></li>";
                          }
                        echo "</ul>
                      </li>";
                    }

                    if ($usr['ppdb']=='Ya'){
                      echo "<li class='treeview'>
                        <a href='#''><i class='fa fa-user-secret'></i> <span>PPDB Online</span><i class='fa fa-angle-left pull-right'></i></a>
                        <ul class='treeview-menu'>";
                          $cek=$this->model_app->umenu_akses("menuwebsite",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."ppdb/menuwebsite'><i class='fa fa-circle-o'></i> Data Menu</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("halamanbaru",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."ppdb/halamanbaru'><i class='fa fa-circle-o'></i> Data Halaman</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("rekening",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."ppdb/rekening'><i class='fa fa-circle-o'></i> Data Rekening</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("jadwal_pendaftaran",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."ppdb/jadwal_pendaftaran'><i class='fa fa-circle-o'></i> Jadwal Pendaftaran</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("uang_pangkal",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."ppdb/uang_pangkal'><i class='fa fa-circle-o'></i> Uang Pangkal</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("logo_header",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."ppdb/logo_header'><i class='fa fa-circle-o'></i> Logo Header</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("banner",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."ppdb/banner'><i class='fa fa-circle-o'></i> Banner</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("pendaftaran",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."ppdb/pendaftaran'><i class='fa fa-circle-o'></i> Data Pendaftaran</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("informasi_sukses",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."ppdb/informasi_sukses'><i class='fa fa-circle-o'></i> Informasi Sukses</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("informasi_valid",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."ppdb/informasi_valid'><i class='fa fa-circle-o'></i> Informasi Valid</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("beban_biaya",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."ppdb/beban_biaya'><i class='fa fa-circle-o'></i> Beban Biaya</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("setting",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."ppdb/setting'><i class='fa fa-circle-o'></i> Setting</a></li>";
                          }
                        echo "</ul>
                      </li>";
                    }

                    if ($usr['pustaka']=='Ya'){
                      echo "<li class='treeview'>
                        <a href='#'><i class='fa fa-bank'></i> <span>Pustaka</span><i class='fa fa-angle-left pull-right'></i></a>
                        <ul class='treeview-menu'>";
                          $cek=$this->model_app->umenu_akses("buku_tamu",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."pustaka/buku_tamu'><i class='fa fa-circle-o'></i> Buku Tamu</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("kategori",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."pustaka/kategori'><i class='fa fa-circle-o'></i> Kategori</a></li>";
                          }

                      
                          $cek=$this->model_app->umenu_akses("buku",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."pustaka/rak_buku'><i class='fa fa-circle-o'></i> Rak Buku</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("buku",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."pustaka/ebook'><i class='fa fa-circle-o'></i> E-Book</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("kartu_pustaka",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."pustaka/kartu_pustaka'><i class='fa fa-circle-o'></i> Kartu Pustaka</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("setting",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."pustaka/setting'><i class='fa fa-circle-o'></i> Setting</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("transaksi_peminjaman",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."pustaka/transaksi_peminjaman'><i class='fa fa-circle-o'></i> Transaksi Peminjaman</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("transaksi_pengembalian",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."pustaka/transaksi_pengembalian'><i class='fa fa-circle-o'></i> Transaksi Pengembalian</a></li>";
                          }

                          echo "<li class='treeview'>
                            <a href='#'><i class='fa fa-circle-o'></i> Laporan<i class='fa fa-angle-left pull-right'></i></a>
                            <ul class='treeview-menu'>";
                                $cek=$this->model_app->umenu_akses("laporan_pengunjung_siswa",$this->session->id_session);
                                if($cek==1 OR $this->session->level=='admin'){
                                  echo "<li><a href='".base_url()."pustaka/laporan_pengunjung_siswa'><i class='fa fa-circle-o'></i> Pengunjung Siswa</a></li>";
                                }

                                $cek=$this->model_app->umenu_akses("laporan_pengunjung_lainnya",$this->session->id_session);
                                if($cek==1 OR $this->session->level=='admin'){
                                  echo "<li><a href='".base_url()."pustaka/laporan_pengunjung_lainnya'><i class='fa fa-circle-o'></i> Pengunjung Lainnya</a></li>";
                                }

                                $cek=$this->model_app->umenu_akses("katalog_laporan_buku",$this->session->id_session);
                                if($cek==1 OR $this->session->level=='admin'){
                                  echo "<li><a href='".base_url()."pustaka/katalog_laporan_buku'><i class='fa fa-circle-o'></i> Katalog Buku</a></li>";
                                }

                                $cek=$this->model_app->umenu_akses("peminjaman_pengembalian",$this->session->id_session);
                                if($cek==1 OR $this->session->level=='admin'){
                                  echo "<li><a href='".base_url()."pustaka/peminjaman_pengembalian'><i class='fa fa-circle-o'></i> Peminjaman / Pengembalian</a></li>";
                                }

                                $cek=$this->model_app->umenu_akses("buku_besar",$this->session->id_session);
                                if($cek==1 OR $this->session->level=='admin'){
                                  echo "<li><a href='".base_url()."pustaka/buku_besar'><i class='fa fa-circle-o'></i> Buku Besar</a></li>";
                                }

                                $cek=$this->model_app->umenu_akses("laporan_kondisi_buku",$this->session->id_session);
                                if($cek==1 OR $this->session->level=='admin'){
                                  echo "<li><a href='".base_url()."pustaka/laporan_kondisi_buku'><i class='fa fa-circle-o'></i> Kondisi Buku</a></li>";
                                }

                                $cek=$this->model_app->umenu_akses("rekap_kondisi_buku",$this->session->id_session);
                                if($cek==1 OR $this->session->level=='admin'){
                                  echo "<li><a href='".base_url()."pustaka/rekap_kondisi_buku'><i class='fa fa-circle-o'></i> Rekap Kondisi Buku</a></li>";
                                }

                                $cek=$this->model_app->umenu_akses("rekap_pengunjung_tahun",$this->session->id_session);
                                if($cek==1 OR $this->session->level=='admin'){
                                  echo "<li><a href='".base_url()."pustaka/rekap_pengunjung_tahun'><i class='fa fa-circle-o'></i> Rekap Pengunjung / Tahun</a></li>";
                                }
                            echo "</ul>
                          </li>
                        </ul>
                      </li>";
                    }

                    if ($usr['koperasi']=='Ya'){
                      echo "<li class='treeview'>
                        <a href='#'><i class='fa fa-shopping-cart'></i> <span>Koperasi</span><i class='fa fa-angle-left pull-right'></i></a>
                        <ul class='treeview-menu'>";
                          $cek=$this->model_app->umenu_akses("suppliers",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."koperasi/suppliers'><i class='fa fa-circle-o'></i> Suppliers</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("kategori",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."koperasi/kategori'><i class='fa fa-circle-o'></i> Kategori Barang</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("produk_jual",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."koperasi/produk/ya'><i class='fa fa-circle-o'></i> Produk Jual</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("produk_tidak_jual",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."koperasi/produk/tidak'><i class='fa fa-circle-o'></i> Produk Tidak Jual</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("transaksi_pembelian",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."koperasi/transaksi_pembelian'><i class='fa fa-circle-o'></i> Transaksi Pembelian</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("transaksi_penerimaan",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."koperasi/transaksi_penerimaan'><i class='fa fa-circle-o'></i> Transaksi Penerimaan</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("transaksi_penjualan",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."koperasi/transaksi_penjualan'><i class='fa fa-circle-o'></i> Transaksi Penjualan</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("laporan_penjualan",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."koperasi/laporan_penjualan'><i class='fa fa-circle-o'></i> Laporan Penjualan</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("laporan_penerimaan",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."koperasi/laporan_penerimaan'><i class='fa fa-circle-o'></i> Laporan Penerimaan</a></li>";
                          }
                        echo "</ul>
                      </li>";
                    }

                    if ($usr['finance']=='Ya'){
                      echo "<li class='treeview'>
                        <a href='#'><i class='fa fa-money'></i> <span>Keuangan</span><i class='fa fa-angle-left pull-right'></i></a>
                        <ul class='treeview-menu'>";
                          $cek=$this->model_app->umenu_akses("coa",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."keuangan/coa'><i class='fa fa-circle-o'></i> Setting COA</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("sub_coa",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."keuangan/sub_coa'><i class='fa fa-circle-o'></i> Setting Sub-COA</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("coa_koperasi",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."keuangan/coa_koperasi'><i class='fa fa-circle-o'></i> Setting COA Koperasi</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("jenis_biaya",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."keuangan/jenis_biaya'><i class='fa fa-circle-o'></i> Jenis Biaya</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("pembayaran_siswa",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."keuangan/pembayaran_siswa'><i class='fa fa-circle-o'></i> Pembayaran Siswa</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("pengeluaran",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                          echo "<li><a href='".base_url()."keuangan/pengeluaran'><i class='fa fa-circle-o'></i> Transaksi Pengeluaran</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("laporan_keuangan_kasir",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."keuangan/laporan_keuangan_kasir'><i class='fa fa-circle-o'></i> Laporan Keuangan kasir</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("kartu_ujian",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."keuangan/kartu_ujian'><i class='fa fa-circle-o'></i> Cetak Kartu Ujian</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("jurnal_keuangan",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."keuangan/jurnal_keuangan'><i class='fa fa-circle-o'></i> Jurnal Keuangan</a></li>";
                          }
                        echo "</ul>
                      </li>";
                    }

                    if ($usr['asset']=='Ya'){
                      echo "<li class='treeview'>
                        <a href='#'><i class='fa fa-user-secret'></i> <span>SIM Asset</span><i class='fa fa-angle-left pull-right'></i></a>
                        <ul class='treeview-menu'>";
                          $cek=$this->model_app->umenu_akses("suppliers",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."simaset/suppliers'><i class='fa fa-circle-o'></i> Data Suppliers</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("departemen",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."simaset/departemen'><i class='fa fa-circle-o'></i> Data Departemen</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("lokasi",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."simaset/lokasi'><i class='fa fa-circle-o'></i> Data Lokasi</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("kategori",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."simaset/kategori'><i class='fa fa-circle-o'></i> Data Kategori</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("barang",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."simaset/barang'><i class='fa fa-circle-o'></i> Data Barang</a></li>";
                          }

                          $cek=$this->model_app->umenu_akses("transaksi_pengadaan",$this->session->id_session);
                          if($cek==1 OR $this->session->level=='admin'){
                            echo "<li><a href='".base_url()."simaset/transaksi_pengadaan'><i class='fa fa-circle-o'></i> Transaksi Pengadaan</a></li>";
                          }
                        echo "</ul>
                      </li>";
                    }
                echo "</ul>
                </li>";
              ?>
          </ul>
        </section>