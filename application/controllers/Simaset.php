<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Simaset extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library("PHPExcel");
    }


    function suppliers(){
        cek_session_akses('suppliers',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('supplier','id_supplier','DESC');
        $this->template->load('administrator/template','administrator/mod_simaset/mod_suppliers/view',$data);
    }

    function tambah_suppliers(){
        cek_session_akses('suppliers',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('kd_supplier'=>$this->input->post('a'),
                            'nm_supplier'=>$this->input->post('b'),
                            'alamat'=>$this->input->post('c'),
                            'no_telepon'=>$this->input->post('d'));
            $this->model_app->insert('supplier',$data);
            redirect($this->uri->segment(1).'/suppliers');
        }else{
            $this->template->load('administrator/template','administrator/mod_simaset/mod_suppliers/tambah',$data);
        }
    }

    function edit_suppliers(){
        cek_session_akses('suppliers',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('kd_supplier'=>$this->input->post('a'),
                            'nm_supplier'=>$this->input->post('b'),
                            'alamat'=>$this->input->post('c'),
                            'no_telepon'=>$this->input->post('d'));
            $where = array('id_supplier' => $this->input->post('id'));
            $this->model_app->update('supplier', $data, $where);
            redirect($this->uri->segment(1).'/suppliers');
        }else{
            $edit = $this->model_app->view_where('supplier', array('id_supplier'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_simaset/mod_suppliers/edit',$data);
        }
    }

    function delete_suppliers(){
        cek_session_akses('suppliers',$this->session->id_session);
        $id = array('id_supplier' => $this->uri->segment(3));
        $this->model_app->delete('supplier',$id);
        redirect($this->uri->segment(1).'/suppliers');
    }


    function departemen(){
        cek_session_akses('departemen',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('departemen','id_departemen','DESC');
        $this->template->load('administrator/template','administrator/mod_simaset/mod_departemen/view',$data);
    }

    function tambah_departemen(){
        cek_session_akses('departemen',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('kd_departemen'=>$this->input->post('a'),
                            'nm_departemen'=>$this->input->post('b'),
                            'keterangan'=>$this->input->post('c'));
            $this->model_app->insert('departemen',$data);
            redirect($this->uri->segment(1).'/departemen');
        }else{
            $this->template->load('administrator/template','administrator/mod_simaset/mod_departemen/tambah',$data);
        }
    }

    function edit_departemen(){
        cek_session_akses('departemen',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('kd_departemen'=>$this->input->post('a'),
                            'nm_departemen'=>$this->input->post('b'),
                            'keterangan'=>$this->input->post('c'));
            $where = array('id_departemen' => $this->input->post('id'));
            $this->model_app->update('departemen', $data, $where);
            redirect($this->uri->segment(1).'/departemen');
        }else{
            $edit = $this->model_app->view_where('departemen', array('id_departemen'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_simaset/mod_departemen/edit',$data);
        }
    }

    function delete_departemen(){
        cek_session_akses('departemen',$this->session->id_session);
        $id = array('id_departemen' => $this->uri->segment(3));
        $this->model_app->delete('departemen',$id);
        redirect($this->uri->segment(1).'/departemen');
    }


    function lokasi(){
        cek_session_akses('lokasi',$this->session->id_session);
        $data['record'] = $this->db->query("SELECT * FROM lokasi a JOIN departemen b ON a.id_departemen=b.id_departemen ORDER BY a.id_lokasi DESC");
        $this->template->load('administrator/template','administrator/mod_simaset/mod_lokasi/view',$data);
    }

    function tambah_lokasi(){
        cek_session_akses('lokasi',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('kd_lokasi'=>$this->input->post('a'),
                            'nm_lokasi'=>$this->input->post('b'),
                            'id_departemen'=>$this->input->post('c'));
            $this->model_app->insert('lokasi',$data);
            redirect($this->uri->segment(1).'/lokasi');
        }else{
            $this->template->load('administrator/template','administrator/mod_simaset/mod_lokasi/tambah',$data);
        }
    }

    function edit_lokasi(){
        cek_session_akses('lokasi',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('kd_lokasi'=>$this->input->post('a'),
                            'nm_lokasi'=>$this->input->post('b'),
                            'id_departemen'=>$this->input->post('c'));
            $where = array('id_lokasi' => $this->input->post('id'));
            $this->model_app->update('lokasi', $data, $where);
            redirect($this->uri->segment(1).'/lokasi');
        }else{
            $edit = $this->model_app->view_where('lokasi', array('id_lokasi'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_simaset/mod_lokasi/edit',$data);
        }
    }

    function delete_lokasi(){
        cek_session_akses('lokasi',$this->session->id_session);
        $id = array('id_lokasi' => $this->uri->segment(3));
        $this->model_app->delete('lokasi',$id);
        redirect($this->uri->segment(1).'/lokasi');
    }


    function kategori(){
        cek_session_akses('kategori',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('kategori','id_kategori','DESC');
        $this->template->load('administrator/template','administrator/mod_simaset/mod_kategori/view',$data);
    }

    function tambah_kategori(){
        cek_session_akses('kategori',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array('kd_kategori'=>$this->input->post('a'),
                            'nm_kategori'=>$this->input->post('b'));
            $this->model_app->insert('kategori',$data);
            redirect($this->uri->segment(1).'/kategori');
        }else{
            $this->template->load('administrator/template','administrator/mod_simaset/mod_kategori/tambah',$data);
        }
    }

    function edit_kategori(){
        cek_session_akses('kategori',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array('kd_kategori'=>$this->input->post('a'),
                            'nm_kategori'=>$this->input->post('b'));
            $where = array('id_kategori' => $this->input->post('id'));
            $this->model_app->update('kategori', $data, $where);
            redirect($this->uri->segment(1).'/kategori');
        }else{
            $edit = $this->model_app->view_where('kategori', array('id_kategori'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_simaset/mod_kategori/edit',$data);
        }
    }

    function delete_kategori(){
        cek_session_akses('kategori',$this->session->id_session);
        $id = array('id_kategori' => $this->uri->segment(3));
        $this->model_app->delete('kategori',$id);
        redirect($this->uri->segment(1).'/kategori');
    }


    function barang(){
        cek_session_akses('barang',$this->session->id_session);
        if (isset($_GET['kategori']) AND $_GET['kategori']!='all'){
            $data['record'] = $this->model_app->view_where_ordering('barang',array('id_kategori'=>$this->input->get('kategori')),'id_barang','DESC');
        }else{
            $data['record'] = $this->model_app->view_ordering('barang','id_barang','DESC');
        }
        $this->template->load('administrator/template','administrator/mod_simaset/mod_barang/view',$data);
    }

    function tambah_barang(){
        cek_session_akses('barang',$this->session->id_session);
        if (isset($_POST['submit'])){
            $files = $_FILES;
            $cpt = count($_FILES['userfile']['name']);
            for($i=0; $i<$cpt; $i++){
                $_FILES['userfile']['name']= $files['userfile']['name'][$i];
                $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                $_FILES['userfile']['size']= $files['userfile']['size'][$i];
                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_options());
                $this->upload->do_upload();
                $fileName = $this->upload->data()['file_name'];
                $images[] = $fileName;
            }
            $fileName = implode(';',$images);
            $fileupload = str_replace(' ','_',$fileName);
            if ($fileName==''){
                $data = array('kd_barang'=>$this->input->post('a'),
                                'nm_barang'=>$this->input->post('b'),
                                'keterangan'=>$this->input->post('c'),
                                'merek'=>$this->input->post('d'),
                                'jumlah'=>$this->input->post('jumlah'),
                                'satuan'=>$this->input->post('e'),
                                'id_kategori'=>$this->input->post('f'));
            }else{
                $data = array('kd_barang'=>$this->input->post('a'),
                                'nm_barang'=>$this->input->post('b'),
                                'keterangan'=>$this->input->post('c'),
                                'merek'=>$this->input->post('d'),
                                'jumlah'=>$this->input->post('jumlah'),
                                'satuan'=>$this->input->post('e'),
                                'id_kategori'=>$this->input->post('f'),
                                'foto'=>$fileName);
            }
            $this->model_app->insert('barang',$data);
            redirect($this->uri->segment(1).'/barang');
        }else{
            $this->template->load('administrator/template','administrator/mod_simaset/mod_barang/tambah',$data);
        }
    }

    function edit_barang(){
        cek_session_akses('barang',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $files = $_FILES;
            $cpt = count($_FILES['userfile']['name']);
            for($i=0; $i<$cpt; $i++){
                $_FILES['userfile']['name']= $files['userfile']['name'][$i];
                $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                $_FILES['userfile']['size']= $files['userfile']['size'][$i];
                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_options());
                $this->upload->do_upload();
                $fileName = $this->upload->data()['file_name'];
                $images[] = $fileName;
            }
            $fileName = implode(';',$images);
            $fileupload = str_replace(' ','_',$fileName);
            if ($fileName==''){
                $data = array('kd_barang'=>$this->input->post('a'),
                                'nm_barang'=>$this->input->post('b'),
                                'keterangan'=>$this->input->post('c'),
                                'merek'=>$this->input->post('d'),
                                'jumlah'=>$this->input->post('jumlah'),
                                'satuan'=>$this->input->post('e'),
                                'id_kategori'=>$this->input->post('f'));
            }else{
                $data = array('kd_barang'=>$this->input->post('a'),
                                'nm_barang'=>$this->input->post('b'),
                                'keterangan'=>$this->input->post('c'),
                                'merek'=>$this->input->post('d'),
                                'jumlah'=>$this->input->post('jumlah'),
                                'satuan'=>$this->input->post('e'),
                                'id_kategori'=>$this->input->post('f'),
                                'foto'=>$fileName);
            }
            $where = array('id_barang' => $this->input->post('id'));
            $this->model_app->update('barang', $data, $where);
            redirect($this->uri->segment(1).'/barang');
        }else{
            $edit = $this->model_app->view_where('barang', array('id_barang'=>$id))->row_array();
            $data = array('s' => $edit);
            $this->template->load('administrator/template','administrator/mod_simaset/mod_barang/edit',$data);
        }
    }

    function delete_barang(){
        cek_session_akses('barang',$this->session->id_session);
        $id = array('id_barang' => $this->uri->segment(3));
        $this->model_app->delete('barang',$id);
        redirect($this->uri->segment(1).'/barang');
    }

    private function set_upload_options(){
        $config = array();
        $config['upload_path'] = 'asset/files/';
        $config['allowed_types'] = 'gif|jpg|png|zip|rar|pdf|doc|docx|ppt|pptx|xls|xlsx|txt|jpeg';
        $config['max_size'] = '30000'; // kb
        $config['encrypt_name'] = FALSE;
        $this->load->library('upload', $config);
      return $config;
    }

    function transaksi_pengadaan(){
        cek_session_akses('transaksi_pengadaan',$this->session->id_session);
        if (isset($_GET['selesai'])){
            $this->session->unset_userdata(array('pengadaan'));
            redirect($this->uri->segment(1).'/transaksi_pengadaan');
        }
        $data['record'] = $this->db->query("SELECT a.*, b.nm_supplier FROM `pengadaan` a JOIN supplier b ON a.id_supplier=b.id_supplier ORDER BY tgl_pengadaan DESC");
        $this->template->load('administrator/template','administrator/mod_simaset/pengadaan',$data);
    }

    function tambah_transaksi_pengadaan(){
        cek_session_akses('transaksi_pengadaan',$this->session->id_session);
        if (isset($_POST['submit'])){
            $files = $_FILES;
            $cpt = count($_FILES['userfile']['name']);
            for($i=0; $i<$cpt; $i++){
                $_FILES['userfile']['name']= $files['userfile']['name'][$i];
                $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                $_FILES['userfile']['size']= $files['userfile']['size'][$i];
                $this->load->library('upload');
                $this->upload->initialize($this->set_upload_options());
                $this->upload->do_upload();
                $fileName = $this->upload->data()['file_name'];
                $images[] = $fileName;
            }
            $fileName = implode(';',$images);
            $fileupload = str_replace(' ','_',$fileName);
            if ($fileName==''){
                $data = array('no_pengadaan'=>$this->input->post('a'),
                                'tgl_pengadaan'=>tgl_simpan($this->input->post('b')),
                                'id_supplier'=>$this->input->post('c'),
                                'jenis_pengadaan'=>$this->input->post('d'),
                                'keterangan'=>$this->input->post('e'),
                                'id_guru'=>$this->session->id_session);
            }else{
                $data = array('no_pengadaan'=>$this->input->post('a'),
                                'tgl_pengadaan'=>tgl_simpan($this->input->post('b')),
                                'id_supplier'=>$this->input->post('c'),
                                'jenis_pengadaan'=>$this->input->post('d'),
                                'keterangan'=>$this->input->post('e'),
                                'id_guru'=>$this->session->id_session,
                                'foto'=>$fileName);
            }
            $this->model_app->insert('pengadaan',$data);
            $this->session->set_userdata(array('pengadaan'=>$this->db->insert_id()));
            redirect($this->uri->segment(1).'/tambah_transaksi_pengadaan');
        }elseif (isset($_POST['submit1'])){
                $data = array('id_pengadaan'=>$this->session->pengadaan,
                                'id_barang'=>$this->input->post('bb'),
                                'deskripsi'=>$this->input->post('cc'),
                                'harga_beli'=>$this->input->post('dd'),
                                'jumlah'=>$this->input->post('ee'));
            $this->model_app->insert('pengadaan_item',$data);
            redirect($this->uri->segment(1).'/tambah_transaksi_pengadaan');
        }else{
            $this->template->load('administrator/template','administrator/mod_simaset/pengadaan_tambah',$data);
        }
    }

    function cetak_transaksi_pengadaan(){
        cek_session_akses('transaksi_pengadaan',$this->session->id_session);
        $this->load->view('administrator/mod_simaset/pengadaan_cetak',$data);
    }

    function delete_transaksi_pengadaan(){
        cek_session_akses('transaksi_pengadaan',$this->session->id_session);
        $id = array('id_pengadaan' => $this->uri->segment(3));
        $this->model_app->delete('pengadaan',$id);
        $this->model_app->delete('pengadaan_item',$id);
        redirect($this->uri->segment(1).'/transaksi_pengadaan');
    }
}
