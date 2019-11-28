<?php

    echo "<div class='col-md-12'>
            <div class='box box-success'>
                <div class='box-header'>
                    <h3 class='box-title'>Data Mitra Industri</h3>
                    <a href='".base_url().$this->uri->segment(1)."/delete_alumni_bkk/$datarecord[id_bkk]' onclick=\"return confirm('Apakah anda Yakin Data ini Dihapus?')\"><i class='fa fa-remove pull-right'></i></a>
                </div>

                <div class='box-header'>
                    <h3 class='box-title><b style='margin-top: 15px;'>$datarecord[nama_instansi]</b> </h3>
                </div>
                

                <div class='box-body'>
                    <table class='table table-condensed table-hover'>
                        <tbody>
                            <tr>
                                <th width='200px' scope='row'>Nama Pemimpin Industri</th> 
                                <td>$datarecord[pimpinan_instansi]</td>
                            </tr>
                            <tr>
                                <th scope='row'>Penanggung Jawab</th>                         
                                <td>$datarecord[penanggung_jawab]</td>
                            </tr>
                            <tr>
                                <th scope='row'>Guru Pembimbing</th>                         
                                <td>$datarecord[pembimbing]</td>
                            </tr>
                            <tr>
                                <th scope='row'>No. Telepon</th>                   
                                <td>$datarecord[no_telp]</td>
                            </tr>
                            <tr>
                                <th scope='row'>Email</th>                 
                                <td>$datarecord[email]</td>
                            </tr>
                            <tr>
                                <th scope='row'>Alamat Instansi</th>                         
                                <td>$datarecord[alamat_instansi]</td>
                            </tr>
                            <tr>
                                <th scope='row'>Waktu Berangkat</th>                         
                                <td>$datarecord[berangkat]</td>
                            </tr>
                            <tr>
                                <th scope='row'>Waktu Kembali</th>                         
                                <td>$datarecord[kembali]</td>
                            </tr>
                            <tr>
                                <th scope='row'>Limit Pendaftar</th>                         
                                <td>$datarecord[limit_daftar]</td>
                            </tr>
                            <tr>
                                <th scope='row'>Status</th>                         
                                <td>$datarecord[status]</td>
                            </tr>
                            <tr>
                                <th scope='row'>Keterangan</th>                         
                                <td>$datarecord[keterangan]</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <hr>
                    
                    <h4>Data Pendaftar</h4>";

                    echo "<table id='example1' class='table table-condensed table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th style='width:40px'>No</th>
                                <th>Nama Siswa</th>
                                <th>NIPD</th>
                                <th>Angkatan</th>
                                <th>Jurusan</th>
                                <th>Kelas</th>
                                <th style='text-align: center;'>Action</th>
                            </tr>
                        </thead>
                        <tbody>";
                        
                            $no = 1;
                            foreach ($datas as $r) {
                            $ko = $this->db->query("SELECT count(*) as total FROM rb_forum_komentar where id_forum_topic='$r[id_forum_topic]'")->row_array();
                            echo "<tr>
                                    <td style='text-align: center;'>$no</td>
                                    <td>$r[nama_siswa]</td>
                                    <td>$r[nipd]</td>
                                    <td>$r[angkatan]</td>
                                    <td>$r[jurusan]</td>
                                    <td>$r[kelas]</td>
                                    <td style='width:140px; text-align: center'>
                                        <a class='btn btn-danger btn-xs' title='Hapus' href='".base_url().$this->uri->segment(1)."/delete_magang/".$this->uri->segment(3)."/$r[id_daftar_bkk]/$r[id_siswa]' onclick=\"return confirm('Apakah anda Yakin Data ini Dihapus?')\"><span class='glyphicon glyphicon-remove'></span></a>
                                    </td>
                                </tr>";
                            $no++;
                            }
                        echo "</tbody>
                    </table>
                    <a style='margin-right: 10px' class='btn btn-primary btn-sm' href='".base_url().$this->uri->segment(1)."/magang/$datarecord[id_bkk]'>Daftarkan Siswa</a>
                    <a style='margin-right: 10px' class='btn btn-sm' href='".base_url().$this->uri->segment(1)."/alumni_bkk'>Kembali</a>
                    </div>
        </div>";