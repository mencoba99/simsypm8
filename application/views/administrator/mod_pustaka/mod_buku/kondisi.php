<?php
echo "<div class='col-md-12'>
  <div class='box box-info'>
    <div class='box-header with-border'>
      <h3 class='box-title'>Kondisi Buku</h3>
      <a class='pull-right btn btn-primary btn-sm' href='#' data-toggle='modal' data-target='#kondisiBuku'>Tambahkan Data</a>
    </div>
  <div class='box-body'>
      <dl class='dl-horizontal'>
          <dt>Kode Buku</dt>   <dd style='border-bottom:1px solid #e3e3e3; color:red'>$s[kode_buku]</dd>
          <dt>Judul Buku</dt>  <dd style='border-bottom:1px solid #e3e3e3'>$s[judul]</dd>
          <dt>Pengarang</dt>   <dd style='border-bottom:1px solid #e3e3e3'>$s[pengarang]</dd>
          <dt>Penerbit</dt>    <dd style='border-bottom:1px solid #e3e3e3'>$s[penerbit]</dd>
          <dt>Tahun Terbit</dt><dd style='border-bottom:1px solid #e3e3e3'>$s[tahun_terbit]</dd>
      </dl>

    <div class='col-md-12'>
      <table id='example2' class='table table-bordered table-striped table-condensed'>
        <thead>
          <tr>
            <th style='width:40px'>No</th>
            <th>Kondisi</th>
            <th>Jumlah</th>
            <th>Waktu Input</th>
            <th style='width:40px'>Action</th>
          </tr>
        </thead>
        <tbody>";
        
        $no = 1;
        foreach ($tampil->result_array() as $r) {
        $ex = explode(' ',$r['waktu']);
        echo "<tr><td>$no</td>
                  <td>$r[kondisi]</td>
                  <td>$r[jumlah]</td>
                  <td>".tgl_view($ex[0])." ".$ex[1]."</td>
                  <td>
                  <center>
                    <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_kondisi_buku/$r[id_buku_kondisi]/".$this->uri->segment(3)."' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                  </center></td>
              </tr>";
          $no++;
          }

        echo "</tbody>
      </table>
    </div>
  </div>
</div>";
?>
<div class="modal fade" id="kondisiBuku" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Data Kondisi Buku</h4>
      </div>
      <div class="modal-body">
          <form action="<?php echo base_url().$this->uri->segment(1)."/kondisi_buku/".$this->uri->segment(3).""; ?>" class='form-horizontal' method='POST'>
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Kondisi</label>
            <div style='background:#fff;' class="input-group col-sm-8">
                <input type="text" class="form-control" name="a" required>
            </div>
          </div>

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Jumlah</label>
            <div style='background:#fff;' class="input-group col-sm-8">
                <input type="number" class="form-control" name="b" required>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" name='submit' class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>
