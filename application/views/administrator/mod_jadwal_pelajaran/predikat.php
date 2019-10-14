<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Data Predikat / Grade Nilai</h3>
                  <a class='pull-right btn btn-success btn-sm' style='margin-left:3px' href='".base_url().$this->uri->segment(1)."/default_predikat_jadwal_pelajaran/".$this->uri->segment(3)."'>Set Default</a>
                  <a class='pull-right btn btn-primary btn-sm' href='".base_url().$this->uri->segment(1)."/tambah_predikat_jadwal_pelajaran/".$this->uri->segment(3)."'>Tambahkan Data</a>
                </div>
              <div class='box-body'>

              <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Kode Pelajaran</th> <td>$s[kode_pelajaran]</td></tr>
                    <tr><th scope='row'>Mata Pelajaran</th>               <td>$s[namamatapelajaran]</td></tr>
                  </tbody>
              </table>
              <hr>
              <table class='table table-bordered table-striped'>
                <thead>
                  <tr bgcolor=#e3e3e3>
                    <th>Dari Nilai</th>
                    <th>Sampai Nilai</th>
                    <th>Grade</th>
                    <th>Keterangan</th>
                    <th style='width:70px'>Action</th>
                  </tr>
                </thead>
                <tbody>";
                $no = 1;
                foreach ($predikat as $r){
                echo "<tr>
                          <td>$r[nilai_a]</td>
                          <td>$r[nilai_b]</td>
                          <td>$r[grade]</td>
                          <td>$r[keterangan]</td>
                          <td><center>
                            <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_predikat_jadwal_pelajaran/$r[id_predikat]/".$this->uri->segment(3)."'><span class='glyphicon glyphicon-edit'></span></a>
                            <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_predikat_jadwal_pelajaran/$r[id_predikat]/".$this->uri->segment(3)."' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                          </center></td>
                    </tr>";
                  $no++;
                  }
                echo "</tbody>
              </table>
            </div>";
            
