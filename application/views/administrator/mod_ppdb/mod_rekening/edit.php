<?php 
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Rekening</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_rekening',$attributes); 
          echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_rekening]'>
                    <tr><th width='120px' scope='row'>Nama Bank</th> <td><input type='text' class='form-control' name='a' value='".htmlentities($s['nama_bank'],ENT_QUOTES)."'> </td></tr>
                    <tr><th width='120px' scope='row'>Nama Pemilik</th> <td><input type='text' class='form-control' name='b' value='".htmlentities($s['nama_pemilik'],ENT_QUOTES)."'> </td></tr>
                    <tr><th width='120px' scope='row'>No Rekening</th> <td><input type='text' class='form-control' name='c' value='".htmlentities($s['no_rekening'],ENT_QUOTES)."'> </td></tr>
                  </tbody>
                  </table>
                </div>
              
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url().$this->uri->segment(1)."/halamanbaru'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                    
                  </div>
            </div></div></div>";
            echo form_close();