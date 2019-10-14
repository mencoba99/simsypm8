<?php

    echo "<div class='col-md-6'>
          <div class='box'>
            <div class='box-header'>
              <h3 class='box-title'>Selamat Datang di Halaman Kepala Sekolah</h3>
            </div>
            <div class='box-body'>
              <p>Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola Tulisan anda pada web ini, berikut informasi akun anda saat ini : </p>
              <dl class='dl-horizontal'>
                <dt>Username</dt>
                <dd>$users[username]</dd>

                <dt>Password</dt>
                <dd>***********</dd>

                <dt>Nama Lengkap</dt>
                <dd>$users[nama_lengkap]</dd>

                <dt>Alamat Email</dt>
                <dd>$users[email]</dd>

                <dt>No. Telpon</dt>
                <dd>$users[no_telpon]</dd>

              </dl>
              <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                <h4><i class='icon fa fa-info'></i> Info Penting!</h4>
                Diharapkan informasi akun sesuai dengan identitas pada Kartu Pengenal anda, Untuk Mengubah informasi Profil Kepala Sekolah Silahkan Hubungi Administrator</a>.
              </div>
            </div>
          </div>
        </div>

        <section class='col-lg-6 connectedSortable'>";
          include "home_grafik.php";
    echo "</section>";