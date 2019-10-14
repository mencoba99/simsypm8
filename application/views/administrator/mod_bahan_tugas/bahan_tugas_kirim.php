<?php
$cek = $this->model_app->view_where('rb_elearning_jawab',array('id_elearning'=>$this->uri->segment(3), 'id_siswa'=>$this->session->id_session));
$row = $cek->row_array();
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Kirimkan Tugas</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form','name'=>'vcode');
              echo form_open_multipart($this->uri->segment(1).'/jawaban_bahan_tugas/'.$this->uri->segment(3).'/'.$this->uri->segment(4),$attributes); 
                echo "<div class='col-md-12'>";
                  if ($cek->num_rows()>=1){
                    echo "<div class='alert alert-danger'>Maaf, Anda sudah pernah mengirimkan tugas ini sebelumnya! Jika dikirimkan ulang maka data yang lama akan hilang.</div>";
                  }
                  echo "<table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th width='120px' scope='row'>File Tugas</th> <td><input type='file' name='a'>";
                    if ($row['file_tugas']!=''){ echo "File Sebelumnya : <a href='".base_url().$this->uri->segment(1)."/download/files/$row[file_tugas]'>$row[file_tugas]</a>"; }
                    echo "</td></tr>
                    <tr><th scope='row'>Keterangan</th>       <td><textarea class='form-control' style='height:120px' name='b'>$row[keterangan]</textarea></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Kirimkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/detail_bahan_tugas/".$this->uri->segment(3)."'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
