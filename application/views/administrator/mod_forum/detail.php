<?php
    echo "<div class='col-md-12'>
              <div class='box box-success'>
                <div class='box-header'>
                  <i class='fa fa-comments-o'></i>
                  <h3 class='box-title'>$topic[judul_topic] </h3> 
                  <a href='".base_url().$this->uri->segment(1)."/delete_topic_forum?kodejdwl=$r[kodejdwl]&id_topic=$r[id_forum_topic]' onclick=\"return confirm('Apakah anda Yakin Data ini Dihapus?')\"><i class='fa fa-remove pull-right'></i></a>
                </div>
                <div class='box-body chat' id='chat-box'>";
                  echo "<div class='item'>";
                  if (trim($topic['foto'])=='' OR !file_exists("asset/foto_pegawai/".$topic['foto'])){ $foto = 'blank.png'; }else{ $foto = $topic['foto']; } 
                      echo "<img src='".base_url()."asset/foto_pegawai/$foto' alt='user image' class='online forum'>";
                    echo "<p>
                      <a href='".base_url().$this->uri->segment(1)."/detail_guru/$topic[id_guru]' class='name'>
                        <small class='text-muted pull-right'><i class='fa fa-clock-o'></i> ".cek_terakhir($topic['waktu'])." lalu</small>
                      <b>$topic[nama_guru]</b> (Guru)</a>
                      $topic[isi_topic]</p>
                  </div>
              </div>
          </div>

          <div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-body chat' id='chat-box'>";
                $komentar = $this->db->query("SELECT * FROM rb_forum_komentar a 
                              LEFT JOIN rb_siswa b ON a.nisn_nip=b.nisn
                                where a.id_forum_topic='$_GET[id_topic]' 
                                  ORDER BY a.id_forum_komentar ASC");
                foreach ($komentar->result_array() as $k) {
                if ($k['nama']==''){
                    echo "<div class='item'>";
                    if (trim($topic['foto'])=='' OR !file_exists("asset/foto_pegawai/".$topic['foto'])){ $foto = 'blank.png'; }else{ $foto = $topic['foto']; } 
                        echo "<img src='".base_url()."asset/foto_pegawai/$foto' alt='user image' class='online forum'>";
                      echo "<p>
                            <small class='text-muted'><a href='".base_url().$this->uri->segment(1)."/delete_komentar_forum?kodejdwl=$topic[kodejdwl]&id_topic=$topic[id_forum_topic]&komentar=$k[id_forum_komentar]' onclick=\"return confirm('Apakah anda Yakin Data ini Dihapus?')\"><i style='margin-top:10px' class='fa fa-remove pull-right'></i></a> 
                            <span class='pull-right' style='margin-top:6px'><i class='fa fa-clock-o'></i> ".cek_terakhir($k['waktu_komentar'])." lalu</span>
                            <a href='".base_url().$this->uri->segment(1)."/detail_guru/$topic[id_guru]' class='name'><b>$topic[nama_guru]</b> (Guru)</a> Mengatakan :</small><br> $k[isi_komentar]</p>
                    </div>";
                }else{
                    echo "<div class='item'>";
                     if (trim($k['foto'])=='' OR !file_exists("asset/foto_siswa/".$k['foto'])){ $foto = 'blank.png'; }else{ $foto = $k['foto']; } 
                        echo "<img src='".base_url()."asset/foto_siswa/$foto' alt='user image' class='offline forum'>";
                      echo "<p>
                            <small class='text-muted'><a href='".base_url().$this->uri->segment(1)."/delete_komentar_forum?kodejdwl=$topic[kodejdwl]&id_topic=$topic[id_forum_topic]&komentar=$k[id_forum_komentar]'  onclick=\"return confirm('Apakah anda Yakin Data ini Dihapus?')\"><i style='margin-top:10px' class='fa fa-remove pull-right'></i></a> 
                            <span class='pull-right' style='margin-top:6px'><i class='fa fa-clock-o'></i> ".cek_terakhir($k['waktu_komentar'])." lalu</span>
                            <a href='".base_url().$this->uri->segment(1)."/detail_siswa/$k[id_siswa]' class='name'><b>$k[nama]</b> (Siswa)</a> Mengatakan : </small><br>$k[isi_komentar]</p>
                    </div>";
                }
              }
                
                echo "</div>";
                $attributes = array('class'=>'form-horizontal','role'=>'form');
                echo form_open_multipart($this->uri->segment(1).'/detail_topic_forum?kodejdwl='.$this->input->get('kodejdwl').'&id_topic='.$this->input->get('id_topic'),$attributes); 
                if ($this->session->level=='guru'){
                  $user = $topic['id_guru'];
                }elseif($this->session->level=='siswa'){
                  $user = $this->session->id_session;
                }else{
                  $user = $topic['id_guru'];
                }
                echo "<div class='box-footer'>
                  <div class='input-group'>
                    <input type='hidden' value='$user' name='users'>
                    <input class='form-control' name='a' placeholder='Tuliskan Komentar...'>
                    <div class='input-group-btn'>
                      <button type='submit' name='submit' class='btn btn-success'><i class='fa fa-send'></i></button>
                    </div>
                  </div>
                </div>
                </form>
              </div>
          </div>";