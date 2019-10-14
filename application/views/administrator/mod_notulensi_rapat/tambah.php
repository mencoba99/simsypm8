<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_notulensi_rapat',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th scope='row'>Tanggal Rapat</th><td><input type='text' class='form-control datepicker' name='tanggal'></td></tr>
                    <tr><th scope='row'>Topik Rapat</th><td><input type='text' class='form-control' name='topik_rapat'></td></tr>
                    <tr><th scope='row'>Agenda Rapat</th><td><input type='text' class='form-control' name='agenda_rapat'></td></tr>
                    <tr><th scope='row'>Ruang Rapat</th><td><input type='text' class='form-control' name='ruang_rapat'></td></tr>
                    <tr><th scope='row'>Pembahasan</th><td><textarea class='textarea form-control' name='pembahasan'></textarea></td></tr>
                    <tr><th scope='row'>Tindak Lanjut</th><td><textarea class='textarea form-control' name='tindak_lanjut'></textarea></td></tr>
                    <tr><th scope='row'>Peserta Rapat</th><td><textarea class='textarea form-control' name='peserta_rapat'></textarea></td></tr>
                    </td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/notulensi_rapat'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
