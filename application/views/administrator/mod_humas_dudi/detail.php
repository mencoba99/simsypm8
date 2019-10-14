<?php
    echo "<div class='col-md-12'>
            <div class='box box-success'>
                <div class='box-header'>
                    <h3 class='box-title'>Data Tracer Alumni</h3>
                    <a href='".base_url().$this->uri->segment(1)."/delete_tracer_alumni/$datarecord[id_traceralumni]' onclick=\"return confirm('Apakah anda Yakin Data ini Dihapus?')\"><i class='fa fa-remove pull-right'></i></a>";
                echo "</div>

                <div class='box-header'>
                    <h3 class='box-title><b style='margin-top: 15px;'>$datarecord[nama]</b> </h3>
                </div>
                

                <div class='box-body'>
                    <table class='table table-condensed table-hover'>
                        <tbody>
                            <tr>
                                <th scope='row'>NISN</th>                   
                                <td>$datarecord[nisn]</td>
                            </tr>
                            <tr>
                                <th scope='row'>No. Telepon</th>                   
                                <td>$datarecord[no_hp]</td>
                            </tr>
                            <tr>
                                <th scope='row'>Email</th>                 
                                <td>$datarecord[email]</td>
                            </tr>
                            <tr>
                                <th scope='row'>Alamat</th>                         
                                <td>$datarecord[alamat]</td>
                            </tr>
                            <tr>
                                <th width='200px' scope='row'>Tahun Kelulusan</th> 
                                <td>$datarecord[tahun_lulus]</td>
                            </tr>
                            <tr>
                                <th width='200px' scope='row'>Status</th>";
                                if (empty($recs)) {
                                    echo "<td>Belum Bekerja<?td>";
                                } else {
                                    foreach ($recs as $rec) {
                                        if ($rec['tahun_keluar'] === '0') {
                                            echo "<td>Sudah Bekerja<?td>";
                                            break;
                                        } else {
                                            echo "<td>Belum Bekerja<?td>";
                                            break;
                                        }
                                    }   
                                } 
                                echo "</tr>
                            <tr>
                                <th scope='row'>Keterangan</th>                         
                                <td>$datarecord[keterangan]</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <hr>
                    
                    <h4>Riwayat Pekerjaan</h4>

                    <table id='example1' class='table table-condensed table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th style='width:20px'>No</th>
                                <th>Nama Instansi</th>
                                <th>Pimpinan Instansi</th>
                                <th>Alamat Instansi</th>
                                <th>Jabatan Pekerjaan</th>
                                <th>Tahun Masuk</th>
                                <th>Tahun Keluar</th>
                                <th>Gaji</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>";
                        
                            $no = 1;
                            foreach ($datas as $r) {
                            echo "<tr>
                                    <td style='text-align: center;'>$no</td>
                                    <td>$r[nama]</td>
                                    <td>$r[pimpinan]</td>
                                    <td>$r[alamat]</td>
                                    <td>$r[jabatan]</td>
                                    <td>$r[tahun_masuk]</td>";
                                    if ("$r[tahun_keluar]" === '0') {
                                        echo "<td>Sekarang</td>";
                                    } else {
                                        echo "<td>$r[tahun_keluar]</td>";
                                    }
                                    echo "<td>Rp. ".rupiah($r['gaji'])."</td>
                                    <td style='width:40px'>
                                        <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/ubah_riwayat_alumni/$r[id_riwayat]'><span class='glyphicon glyphicon-edit'></span></a>
                                        <a class='btn btn-danger btn-xs' title='Hapus' href='".base_url().$this->uri->segment(1)."/delete_riwayat_alumni/$r[id_riwayat]/$r[id_traceralumni]' onclick=\"return confirm('Apakah anda Yakin Data ini Dihapus?')\"><span class='glyphicon glyphicon-remove'></span></a>
                                    </td>
                                </tr>";
                            $no++;
                            }
                        echo "</tbody>
                    </table>";
                    if (empty($recs)) {
                        echo "<a style='margin-right: 10px' class='btn btn-primary btn-sm' href='".base_url().$this->uri->segment(1)."/riwayat_tracer_alumni/$datarecord[id_traceralumni]'>Tambahkan Data</a>";
                    } else {
                        foreach ($recs as $rec) {
                            if ($rec['tahun_keluar'] === '0') {
                                break;
                            } else {
                                echo "<a style='margin-right: 10px' class='btn btn-primary btn-sm' href='".base_url().$this->uri->segment(1)."/riwayat_tracer_alumni/$datarecord[id_traceralumni]'>Tambahkan Data</a>";
                                break;
                            }
                        }   
                    } 
                    echo "<a style='margin-right: 10px' class='btn btn-sm' href='".base_url().$this->uri->segment(1)."/tracer_alumni'>Kembali</a>";
        echo "</div></div>";