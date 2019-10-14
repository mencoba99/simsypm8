<?php 
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data $rows[level]</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_manajemenuser',$attributes); 
              if ($rows['foto']==''){ $foto = 'users.gif'; }else{ $foto = $rows['foto']; }
          echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$rows[id_user]'>
                    <tr><th width='120px' scope='row'>Username</th>   <td><input type='text' class='form-control' name='a' value='$rows[username]' readonly='on'></td></tr>
                    <tr><th scope='row'>Password</th>                 <td><input type='password' class='form-control' name='b' onkeyup=\"nospaces(this)\">
                                                                          <small><i>Biarkan Kosong Jika Tidak diganti!</i></small></td></tr>
                    <tr><th scope='row'>Nama Lengkap</th>             <td><input type='text' class='form-control' name='c' value='$rows[nama_lengkap]'></td></tr>
                    <tr><th scope='row'>Alamat Email</th>             <td><input type='email' class='form-control' name='d' value='$rows[email]'></td></tr>
                    <tr><th scope='row'>No Telepon</th>               <td><input type='number' class='form-control' name='e' value='$rows[no_telpon]'></td></tr>
                    <tr><th scope='row'>Ganti Foto</th>               <td><input type='file' class='form-control' name='f'><hr style='margin:5px'>";
                                                                       if ($rows['foto'] != ''){ echo "<i style='color:red'>Foto Saat ini : </i><a target='_BLANK' href='".base_url()."asset/foto_user/$rows[foto]'>$rows[foto]</a>"; } echo "</td></tr></td></tr>";
                    if ($this->session->level == 'admin' AND $this->session->id_session!=$rows['id_user']){
                      echo "<tr><th scope='row'>Tambah Akses</th>     <td><div class='checkbox-scroll'>";
                                                                       foreach ($record as $row){
                                                                         echo "<span style='display:block'><input name='modul[]' type='checkbox' value='$row[id_modul]' /> $row[nama_modul]</span> ";
                                                                       }
                      echo "</div></td></tr>
                      <tr><th scope='row'>Hak Akses</th>              <td><div class='checkbox-scroll'>";
                                                                       foreach ($akses as $ro){
                                                                         echo "<span style='display:block'><a class='text-danger' href='".base_url().$this->uri->segment(1)."/delete_akses/$ro[id_umod]/".$this->uri->segment(3)."'><span class='glyphicon glyphicon-remove'></span></a> $ro[nama_modul]</span> ";
                                                                       }
                      echo "</div></td></tr>";
                    }
                  echo "</tbody>
                  </table></div>
              
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='index.php'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                    
                  </div>
            </div></div></div>";
            echo form_close();