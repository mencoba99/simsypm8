<?php
    echo "<div class='col-md-12'>";
            if ($this->session->flashdata('error') == TRUE) {
                echo "<div class='alert alert-danger'>".$this->session->flashdata('error') ."</div>";
            }
            
            echo "<div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data Siswa Magang</h3>
                </div>";

                echo "<div class='box-body'>";
                        echo "<form style='margin-right:5px; margin-top:0px' action='".base_url().$this->uri->segment(1)."/magang/".$this->uri->segment(3)."' method='GET'>
                            <table class='table table-condensed table-hover'>
                                <tbody>
                                    <tr>
                                        <th width='120px' scope='row'>Angkatan</th> 
                                        <td>
                                            <select name='angkatan' style='padding:4px; width:300px'>
                                            <option value='' selected>- Pilih -</option>";
                                                foreach ($angkatan as $k) {
                                                    if ($this->input->get('angkatan')==$k['angkatan']){
                                                        echo "<option value='$k[angkatan]' selected>Angkatan $k[angkatan]</option>";
                                                    }else{
                                                        echo "<option value='$k[angkatan]'>Angkatan $k[angkatan]</option>";
                                                    }
                                                }
                                        echo "</select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width='120px' scope='row'>Jurusan</th> 
                                        <td>
                                            <select name='jurusan' style='padding:4px; width:300px'>
                                                <option value=''>- Pilih -</option>";
                                                    foreach ($jurusan as $k) {
                                                        if ($_GET['jurusan'] == $k['id_jurusan']){
                                                            echo "<option value='$k[id_jurusan]' selected>$k[nama_jurusan]</option>";
                                                        } else {
                                                            echo "<option value='$k[id_jurusan]'>$k[nama_jurusan]</option>";
                                                        }
                                                    }
                                            echo "</select>
                                            <input type='submit' name='get' style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>";
                    echo "</div>
                
                    <div class='box-header'>
                        <h3 class='box-title'>Data Siswa Siap Magang</h3>
                    </div>

                    <div class='col-md-12'>";
                        $attributes = array('class'=>'form-horizontal','role'=>'form');
                        echo form_open_multipart($this->uri->segment(1).'/tambah_magang/'.$this->uri->segment(3), $attributes);
                        // $juml = $record->num_rows();
                        echo "<input type='hidden' name='jumblah' value='$juml'>";
                        echo "<table id='example1' class='table table-condensed table-bordered table-striped'>
                            <thead>
                                <tr>
                                    <th style='width: 30px'>No.</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Jurusan</th>
                                    <th>Tingkat Kelas</th>
                                    <th>Kelas</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>";
                                $no = 1;
                                foreach ($record->result_array() as $r) {
                                    echo "<tr>
                                        <td style='text-align: center;'>$no</td>
                                        <td>$r[nipd]</td>
                                        <td>$r[nama]</td>
                                        <td>$r[nama_jurusan]</td>
                                        <td>Kelas $r[kode_tingkat]</td>
                                        <td>$r[nama_kelas]</td>
                                        <td style='width:140px'>
                                            <input type='hidden' name='id_siswa".$no."' value='$r[id_siswa]'>
                                            <input type='hidden' name='nipd' value='$r[nipd]'>
                                            <input type='hidden' name='id_kelas' value='$r[id_kelas]'>
                                            <input type='hidden' name='id_jurusan' value='$r[id_jurusan]'>
                                            <input type='hidden' name='angkatan' value='$r[angkatan]'>
                                            <select class='form-control' name='daftar".$no."'>
                                                <option value='Belum'>Belum Magang</option>
                                                <option value='Daftar'>Daftarkan</option>
                                            </select>
                                        </td>
                                    </tr>";
                                $no++;
                                }
                            echo "</tbody>
                        </table>
                    </div>

                    <div class='box-footer'>
                            <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                            <a href='".base_url()."".$this->uri->segment(1)."/detail_alumni_bkk/".$this->uri->segment(3)."'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                    </div>";
              echo form_close();
            echo "</div>";
            
