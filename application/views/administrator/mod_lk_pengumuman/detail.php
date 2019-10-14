<?php
    echo "<div class='col-md-12'>
            <div class='box box-success'>
                <div class='box-header'>
                    <h3 class='box-title'>Data Pengumuman</h3>
                    <a href='".base_url().$this->uri->segment(1)."/delete_pengumuman/$datarecord[id]' onclick=\"return confirm('Apakah anda Yakin Data ini Dihapus?')\"><i class='fa fa-remove pull-right'></i></a>
                </div>
                
                <div class='box-body'>
                    <table class='table table-condensed table-hover'>
                        <tbody>
                            <tr>
                                <th width='200px' scope='row'>Judul Pengumuman</th> 
                                <td>$datarecord[judul]</td>
                            </tr>
                            <tr>
                                <th scope='row'>Penulis Pengumuman</th>
                                <td>$datarecord[penulis]</td>
                            </tr>
                            <tr>
                                <th scope='row'>Status</th>                         
                                <td>$datarecord[status]</td>
                            </tr>
                            <tr>
                                <th scope='row'>Waktu Input</th>                   
                                <td>".tgl_indo($datarecord['waktu_post'])."</td>
                            </tr>
                            <tr>
                                <th scope='row'>Deskripsi</th>                 
                                <td>$datarecord[deskripsi]</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href='".base_url()."".$this->uri->segment(1)."/pengumuman'><button type='button' class='btn btn-default pull-right'>Kembali</button></a>
                </div>
            </div>
        </div>";