<?php
    echo "<div class='col-lg-12 col-xs-12'><div class='callout callout-danger'><b>PENTING</b> - Hubungi Operator Pada masing-masing Unit Jika ditemukan kendala atau jika ada yang diragukan.</div></div>
    <div class='col-md-5'>
          <div class='box box-success'>
            <div class='box-header'>
              <h3 class='box-title'>Selamat Datang di Halaman ".$this->session->level."</h3>
            </div>
            <div class='box-body'>
              <p>Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola data pada halaman ini, berikut informasi akun anda saat ini : </p>
              <dl class='dl-horizontal'>
                <dt>Email</dt>
                <dd>$users[email]</dd>

                <dt>Password</dt>
                <dd>***********</dd>

                <dt>NIP</dt>
                <dd>$users[nip]</dd>

                <dt>Nama Lengkap</dt>
                <dd>$users[nama_guru]</dd>

                <dt>Alamat Email</dt>
                <dd>$users[email]</dd>

                <dt>No. Telpon</dt>
                <dd>$users[hp]</dd>

                <dt>Level</dt>
                <dd>".$this->session->level."</dd>
              </dl>
              <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
                <h4><i class='icon fa fa-info'></i> Info Penting!</h4>
                Diharapkan informasi akun sesuai dengan identitas pada Kartu Pengenal anda, Untuk Mengubah informasi Profile anda klik <a href='".base_url().$this->uri->segment(1)."/edit_guru/".$this->session->id_session."'>disini</a>.
              </div>
            </div>
          </div>
        </div>

        <section class='col-lg-7 connectedSortable'>";
          include "home_app.php";
    echo "</section>";