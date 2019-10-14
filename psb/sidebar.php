          <form class="form-inline">
            <center>
              <div style='width:100%' class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="button">Go!</button>
                </span>
              </div>
            </center>
          </form><br>
          
          <?php 
          if ($_SESSION['level']=='Calon'){
              echo "<a class='btn btn-sm btn-success btn-block' href='index.php?view=pendaftaran_ulang'>Pendaftaran Ulang</a><br>";
          }
            $tampil = mysqli_query($koneksi, "SELECT * FROM rb_header_banner where jenis='psb_banner' ORDER BY id_header_banner DESC");
            while($r=mysqli_fetch_array($tampil)){
              echo "<center><i><small>Klik Untuk Lihat Gambar Besar</small></i></center><a target='_BLANK' href='../asset/banner/$r[gambar]'><img src='../asset/banner/$r[gambar]' style='width:100%'></a>";
            }
          ?>
          
