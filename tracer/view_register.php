<?php
    echo "<div class='alert alert-success'>Masukkan Data anda yang sebenarnya,...</div>
            <div class='col-xs-12 col-md-12'>";
                if (isset($_GET['gagal'])){
                    echo "<div class='alert alert-danger'>Maaf Terjadi Kesalahan, anda Gagal Mendaftar,..</div>";
                }

                echo "<form action='' method='POST' id='formku' class='form-horizontal' role='form'>
                    <div class='form-group'>
                        <label for='inputEmail3' class='col-xs-3 col-sm-3 control-label'>Nama Lengkap</label>
                        <div class='col-xs-9 col-sm-9'>
                            <div style='background:#fff;' class='input-group col-sm-11'>
                                <input type='text' class='required form-control' name='a' placeholder='---------------------' autocomplete=off>
                            </div>
                        </div>
                    </div>
                    
                    <div class='form-group'>
                        <label for='inputEmail3' class='col-xs-3 col-sm-3 control-label'>NISN</label>
                        <div class='col-xs-9 col-sm-9'>
                            <div style='background:#fff;' class='input-group col-sm-11'>
                                <input type='number' class='required form-control' name='e' placeholder='***********' autocomplete='off'>
                            </div>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='inputEmail3' class='col-xs-3 col-sm-3 control-label'>Username / Email</label>
                        <div class='col-xs-9 col-sm-9'>
                            <div style='background:#fff;' class='input-group col-sm-11'>
                                <input type='text' class='required form-control' name='b' onkeyup=\"nospaces(this)\" autocomplete=off>
                            </div>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='inputEmail3' class='col-xs-3 col-sm-3 control-label'>No Telpon</label>
                        <div class='col-xs-9 col-sm-9'>
                            <div style='background:#fff;' class='input-group col-sm-11'>
                                <input type='number' class='required form-control' name='c' placeholder='08**********' onkeyup=\"nospaces(this)\" autocomplete=off>
                            </div>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='inputEmail3' class='col-xs-3 col-sm-3 control-label'>Password</label>
                        <div class='col-xs-9 col-sm-9'>
                            <div style='background:#fff;' class='input-group col-sm-11'>
                                <input type='password' class='required form-control' placeholder='*************' name='d' onkeyup=\"nospaces(this)\" autocomplete=off>
                            </div>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='inputEmail3' class='col-xs-3 col-sm-3 control-label'>Tahun Lulus</label>
                        <div class='col-xs-9 col-sm-9'>
                            <div style='background:#fff;' class='input-group col-sm-11'>
                                <input type='number' class='required form-control' name='f' placeholder='****' onkeyup=\"nospaces(this)\" autocomplete='off'>
                            </div>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='inputEmail3' class='col-xs-3 col-sm-3 control-label'>Alamat</label>
                        <div class='col-xs-9 col-sm-9'>
                            <div style='background:#fff;' class='input-group col-sm-11'>
                                <textarea class='required form-control' name='g'  autocomplete='off'></textarea>
                            </div>
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='inputEmail3' class='col-xs-3 col-sm-3 control-label'></label>
                        <div class='col-xs-9 col-sm-9'>
                        <div class='input-group col-sm-11'>
                            <input style='width:150px' class='btn btn-primary' type='submit' name='submit' value='Mendaftar'>
                        </div>
                        </div>
                    </div>
                    <br>
                </form>
            </div>
    
            <div style='clear:both'><br></div>";
            
            if (isset($_POST['submit'])) {
                $a=anti_injection($_POST['a']);
                $b=anti_injection($_POST['b']);
                $c=anti_injection($_POST['c']);
                $d=md5(anti_injection($_POST['d']));
                $e=anti_injection($_POST['e']);
                $f=anti_injection($_POST['f']);
                $g=anti_injection($_POST['g']);

                
                $calon = mysqli_query($koneksi, "INSERT INTO rb_humas_traceralumni VALUES ('','4','$a','$b','$d','$_SERVER[REMOTE_ADDR]', '$e', '$f', '$g', '','$c', ' ', '".date('Y-m-d H:i:s')."')");
                
                $id = mysqli_insert_id($koneksi);
                
                if ($calon){
                    $r = mysqli_fetch_array($calon);
                    $_SESSION['id']         = $id;
                    $_SESSION['level']      = 'Tracer';
                    echo "<script>document.location='index.php?view=profile';</script>";
                } else {
                    echo "<script>document.location='index.php?view=register&gagal';</script>";
                }
            }
?>



