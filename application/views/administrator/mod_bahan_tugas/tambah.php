<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form','name'=>'vcode');
              echo form_open_multipart($this->uri->segment(1).'/tambah_jadwal_pelajaran',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th style='width:120px' scope='row'>Tahun Akademik</th>   <td><select class='form-control' name='a'> 
                                                <option value='0' selected>- Pilih Tahun Akademik -</option>"; 
                                                foreach ($tahun as $a){
                                                  if ($_GET['tahun']==$a['id_tahun_akademik']){
                                                    echo "<option value='$a[id_tahun_akademik]' selected>$a[nama_tahun]</option>";
                                                  }else{
                                                    echo "<option value='$a[id_tahun_akademik]'>$a[nama_tahun]</option>";
                                                  }
                                                }
                                                echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Kelas</th>   <td><select class='form-control' name='b'> 
                                                <option value='0' selected>- Pilih Kelas -</option>"; 
                                                foreach ($kelas as $a){
                                                  if ($_GET['kelas']==$a['id_kelas']){
                                                    echo "<option value='$a[id_kelas]' selected>$a[kode_kelas] - $a[nama_kelas]</option>";
                                                  }else{
                                                    echo "<option value='$a[id_kelas]'>$a[kode_kelas] - $a[nama_kelas]</option>";
                                                  }
                                                }
                                                echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Mata Pelajaran</th>   <td><select class='form-control' name='c'> 
                                                <option value='0' selected>- Pilih Mata Pelajaran -</option>"; 
                                                foreach ($mapel as $a){
                                                  echo "<option value='$a[id_mata_pelajaran]'>$a[namamatapelajaran]</option>";
                                                }
                                                echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Ruangan</th>   <td><select class='form-control' name='d'> 
                                                <option value='0' selected>- Pilih Ruangan -</option>"; 
                                                foreach ($ruangan as $a){
                                                  echo "<option value='$a[id_ruangan]'>$a[nama_gedung] - $a[nama_ruangan]</option>";
                                                }
                                                echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Guru</th>   <td><select class='form-control' name='e'> 
                                                <option value='0' selected>- Pilih Guru -</option>"; 
                                                foreach ($guru as $a){
                                                  echo "<option value='$a[id_guru]'>$a[nama_guru]</option>";
                                                }
                                                echo "</select>
                    </td></tr>
                    <tr><th scope='row'>Jadwal Paralel</th>  <td><input type='text' class='form-control' name='f'></td></tr>
                    <tr><th scope='row'>Jadwal Serial</th>  <td><input type='text' class='form-control' name='g'></td></tr>
                    <tr><th scope='row'>Jam Mulai</th>  <td><input type='text' class='form-control clockpicker' name='h' placeholder='hh:ii:ss' value='".date('H:i:s')."'></td></tr>
                    <tr><th scope='row'>Jam Selesai</th><td><input type='text' class='form-control clockpicker' name='i' placeholder='hh:ii:ss' value='".date('H:i:s')."'></td></tr>
                    <tr><th scope='row'>Hari</th>  <td><select class='form-control' name='j'>
                                                <option value='0' selected>- Pilih Hari -</option>";
                                                $hari = array('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu');
                                                for ($i=0; $i < 7 ; $i++) { 
                                                  echo "<option value='".$hari[$i]."'>".$hari[$i]."</option>";
                                                }
                    echo "</td></tr>
                    <tr><th scope='row'>Jurnal Sikap</th>                <td><input type='radio' name='sikap' value='Aktif' checked> Aktif
                                                                             <input type='radio' name='sikap' value='Nonaktif'> Non Aktif
                    <td><tr>

                    <tr><th scope='row'>Remedial</th>                <td><input type='radio' name='remedial' value='0' checked> < KKM
                                                                             <input type='radio' name='remedial' value='1'> >= KKM
                    <td><tr>
                    
                    <tr><th scope='row'>Aktif</th>                <td><input type='radio' name='k' value='Ya' checked> Ya
                                                                             <input type='radio' name='k' value='Tidak'> Tidak
                    </td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/jadwal_pelajaran'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
