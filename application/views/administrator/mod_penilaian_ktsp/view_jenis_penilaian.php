<?php 
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Jenis Penilaian dan Bobot</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/jenis_penilaian',$attributes); 
              $cek = $this->model_app->view_where('rb_jenis_penilaian_bobot',array('id_identitas_sekolah'=>$this->session->sekolah));
              echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_identitas_sekolah]'>
                    <tr><th width='180px' scope='row'>Bobot Lisan</th>   <td><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' class='form-control' name='a' value='$s[lisan]'></td></tr>
                    <tr><th scope='row'>Bobot Tertulis</th>              <td><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' class='form-control' name='b' value='$s[tertulis]'></td></tr>
                    <tr><th scope='row'>Bobot Penugasan</th>             <td><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' class='form-control' name='c' value='$s[penugasan]'></td></tr>
                    <tr><th scope='row'>Bobot Akhir Semester</th>        <td><input min='0' max='100' oninput=\"this.value = Math.abs(this.value)\" onKeyUp=\"if(this.value>100){this.value='100';}else if(this.value<0){this.value='0';}\" type='number' class='form-control' name='d' value='$s[akhir_semester]'></td></tr>
                    <tr><th scope='row'>Aktif </th>                    <td>"; if ($s['aktif']=='Y'){ echo "<input type='radio' name='f' value='Y' checked> Ya &nbsp; <input type='radio' name='f' value='N'> Tidak"; }else{ echo "<input type='radio' name='f' value='Y'> Ya &nbsp; <input type='radio' name='f' value='N' checked> Tidak"; } echo "</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                <button type='submit' name='submit' class='btn btn-info'>Proses</button>
              </div>";
              echo form_close();
            echo "</div>";
