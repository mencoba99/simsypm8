
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
            <?php $usr = $this->model_app->view_where('rb_siswa', array('id_siswa'=> $this->session->id_session))->row_array();
                  if (trim($usr['foto'])=='' OR !file_exists("asset/foto_siswa/".$usr['foto'])){ $foto = 'blank.png'; }else{ $foto = $usr['foto']; } ?>
            <img style='height:45px' src="<?php echo base_url(); ?>/asset/foto_siswa/<?php echo $foto; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <?php
              if ($this->session->level2!=''){
                echo "<p style='margin-top:-10px'><small>Orang Tua <br>$usr[nama]</small></p>"; 
              }else{
                echo "<p>$usr[nama]</p>"; 
              }
              ?>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header" style='color:#fff; text-transform:uppercase;'>MENU <span class='uppercase'><?php if ($this->session->level2!=''){ echo "ORANG TUA "; } echo $this->session->level; ?></span></li>
            <li><a href="<?php echo base_url()."".$this->uri->segment(1); ?>/home"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            
            
            <li class="treeview">
              <a href="#"><i class="fa fa-wrench"></i> <span>Proses Akademik</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
              <?php
                $cek=$this->model_app->umenu_akses("kelompok_mapel",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/kelompok_mapel'><i class='fa fa-circle-o'></i> Kelompok Mapel</a></li>";
                }

                $cek=$this->model_app->umenu_akses("kelompok_mapel_sub",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/kelompok_mapel_sub'><i class='fa fa-circle-o'></i> Sub-Kelompok Mapel</a></li>";
                }

                $cek=$this->model_app->umenu_akses("mata_pelajaran",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/mata_pelajaran'><i class='fa fa-circle-o'></i> Mata Pelajaran</a></li>";
                }

                $cek=$this->model_app->umenu_akses("jadwal_pelajaran",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/jadwal_pelajaran'><i class='fa fa-circle-o'></i> Jadwal Pelajaran</a></li>";
                }

                $cek=$this->model_app->umenu_akses("bahan_tugas",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/bahan_tugas'><i class='fa fa-circle-o'></i> Bahan dan Tugas</a></li>";
                }

                $cek=$this->model_app->umenu_akses("kompetensi_dasar",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/kompetensi_dasar'><i class='fa fa-circle-o'></i> Kompetensi Dasar</a></li>";
                }

                // $cek=$this->model_app->umenu_akses("jurnal_kbm",$this->session->id_session);
                // if($cek==1 OR $this->session->level=='admin'){
                //   echo "<li><a href='".base_url()."".$this->uri->segment(1)."/jurnal_kbm'><i class='fa fa-circle-o'></i> Jurnal KBM</a></li>";
                // }

                // $cek=$this->model_app->umenu_akses("jurnal_kbm_rekap",$this->session->id_session);
                // if($cek==1 OR $this->session->level=='admin'){
                //   echo "<li><a href='".base_url()."".$this->uri->segment(1)."/jurnal_kbm_rekap'><i class='fa fa-circle-o'></i> Rekap Jurnal KBM</a></li>";
                // }

                // $cek=$this->model_app->umenu_akses("kegiatan_siswa",$this->session->id_session);
                // if($cek==1 OR $this->session->level=='admin'){
                //   echo "<li><a href='".base_url()."$sekolah[keyword]/kegiatan_siswa'><i class='fa fa-circle-o'></i> Kegiatan Siswa</a></li>";
                // }
              ?>
              </ul>
            </li>

            <li class="treeview">
              <a href="#"><i class="fa fa-th-large"></i> <span>Kehadiran</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
              <?php
                $cek=$this->model_app->umenu_akses("absensi_guru",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/absensi_guru'><i class='fa fa-circle-o'></i> Guru</a></li>";
                }

                $cek=$this->model_app->umenu_akses("absensi_siswa",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/absensi_siswa'><i class='fa fa-circle-o'></i> Siswa</a></li>";
                }
              ?>
              </ul>
            </li>

           <!--  <li class="treeview">
              <a href="#"><i class="fa fa-book"></i> <span>Proses Penilaian</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
              <?php 
                $cek=$this->model_app->umenu_akses("penilaian_diri",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/penilaian_diri'><i class='fa fa-circle-o'></i> Penilaian Diri</a></li>";
                }

                $cek=$this->model_app->umenu_akses("penilaian_teman",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/penilaian_teman'><i class='fa fa-circle-o'></i> Penilaian Teman</a></li>";
                }
                
                $cek=$this->model_app->umenu_akses("nilai_uts",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/nilai_uts'><i class='fa fa-circle-o'></i> Nilai UTS</a></li>";
                }

                $cek=$this->model_app->umenu_akses("nilai_ekstrakurikuler",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/nilai_ekstrakurikuler'><i class='fa fa-circle-o'></i> Ekstrakurikuler</a></li>";
                }

                $cek=$this->model_app->umenu_akses("nilai_prestasi",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/nilai_prestasi'><i class='fa fa-circle-o'></i> Prestasi</a></li>";
                }

                $cek=$this->model_app->umenu_akses("nilai_sikap",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/nilai_sikap'><i class='fa fa-circle-o'></i> Sikap</a></li>";
                }

                $cek=$this->model_app->umenu_akses("nilai_pengetahuan",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/nilai_pengetahuan'><i class='fa fa-circle-o'></i> Pengetahuan</a></li>";
                }

                $cek=$this->model_app->umenu_akses("nilai_keterampilan",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/nilai_keterampilan'><i class='fa fa-circle-o'></i> Keterampilan</a></li>";
                }
              ?>
              </ul>
            </li> -->
            <li class="treeview">
              <a href="#"><i class="fa fa-book"></i> <span>Laporan Nilai (Raport)</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
              <?php 
                $cek=$this->model_app->umenu_akses("cetak_uts",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/cetak_uts'><i class='fa fa-circle-o'></i> Raport UTS</a></li>";
                }

                $cek=$this->model_app->umenu_akses("cetak_semester",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/cetak_semester'><i class='fa fa-circle-o'></i> Raport Akhir</a></li>";
                }
              ?>
              </ul>
            </li>
            <?php 
                $cek=$this->model_app->umenu_akses("#",$this->session->id_session);
                if($cek==1 OR $this->session->level=='admin'){
                  echo "<li><a href='".base_url()."".$this->uri->segment(1)."/forum'><i class='fa fa-th-list'></i> <span>Forum Diskusi</span></a></li>";
                }
                
                $cek_kelas = $this->db->query("SELECT daftar_ulang FROM rb_kelas where id_kelas='".$this->session->id_kelas."'")->row_array();
                if ($cek_kelas['daftar_ulang']=='Y'){
                    $cek=$this->model_app->umenu_akses("daftar_ulang",$this->session->id_session);
                    if($cek==1 OR $this->session->level=='admin'){
                      echo "<li><a href='".base_url()."".$this->uri->segment(1)."/daftar_ulang'><i class='fa fa-th-list'></i> <span>Pendaftaran Ulang</span></a></li>";
                    }
                }
              ?>
          </ul>
        </section>