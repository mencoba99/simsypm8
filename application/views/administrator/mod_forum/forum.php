<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Forum Diskusi</h3>
                  <a class='pull-right btn btn-primary btn-sm' href='".base_url().$this->uri->segment(1)."/tambah_forum/".$this->uri->segment(3)."'>Buat Topic Baru</a>
                </div>
              <div class='box-body'>

              <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Tahun Akademik</th> <td>$s[nama_tahun]</td></tr>
                    <tr><th scope='row'>Nama Kelas</th>                   <td>$s[nama_kelas]</td></tr>
                    <tr><th scope='row'>Mata Pelajaran</th>               <td>$s[namamatapelajaran]</td></tr>
                    <tr><th scope='row'>Guru</th>                         <td>$s[nama_guru]</td></tr>
                  </tbody>
              </table>
              <hr>
              <table id='example1' class='table table-condensed table-bordered table-striped'>
                      <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Judul Topic</th>
                        <th>Komentar</th>
                        <th>Waktu Posting</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>";
                    
                    $no = 1;
                    foreach ($forum as $r) {
                    $ko = $this->db->query("SELECT count(*) as total FROM rb_forum_komentar where id_forum_topic='$r[id_forum_topic]'")->row_array();
                    echo "<tr>
                            <td>$no</td>
                            <td>$r[judul_topic]</td>
                            <td>$ko[total] Balasan</td>
                            <td>$r[waktu] WIB</td>
                            <td style='width:140px'><a class='btn btn-success btn-xs' title='Lihat Detail' href='".base_url().$this->uri->segment(1)."/detail_topic_forum?kodejdwl=$r[kodejdwl]&id_topic=$r[id_forum_topic]'><span class='glyphicon glyphicon-th-list'></span> Lihat Balasan</a>
                                  <a class='btn btn-danger btn-xs' title='Delete Topic' href='".base_url().$this->uri->segment(1)."/delete_topic_forum?kodejdwl=$r[kodejdwl]&id_topic=$r[id_forum_topic]' onclick=\"return confirm('Apakah anda Yakin Data ini Dihapus?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </td>
                          </tr>";
                      $no++;
                      }
                    echo "</tbody>
                  </table>
            </div>";
            
