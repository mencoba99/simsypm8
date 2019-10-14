<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lab extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library("PHPExcel");
    }

    function lab(){
        cek_session_akses('lab',$this->session->id_session);
        $data['record'] = $this->model_app->view_ordering('rb_lab','id_lab','ASC');
        $this->template->load('administrator/template','administrator/mod_lab/view',$data);
    }

    function tambah_lab(){
        cek_session_akses('lab',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array(
                            'kode_lab'=>$this->input->post('a'),
                            'nama_lab'=>$this->input->post('b'),
                            'kapasitas'=>$this->input->post('c'));
            $this->model_app->insert('rb_lab',$data);
            redirect($this->uri->segment(1).'/lab');
        }else{            
            $this->template->load('administrator/template','administrator/mod_lab/tambah');
        }
    }


    function edit_lab(){
        cek_session_akses('lab',$this->session->id_session);
        $id = $this->uri->segment(3);
        if (isset($_POST['submit'])){
            $data = array(
                                'kode_lab'=>$this->input->post('a'),
                                'nama_lab'=>$this->input->post('b'),
                                'kapasitas'=>$this->input->post('c'),
                            );         
            $where = array('id_lab' => $this->input->post('id'),'id_identitas_sekolah'=>$this->session->sekolah);
            $this->model_app->update('rb_lab', $data, $where);
            redirect($this->uri->segment(1).'/lab');
        }else{
            $data['edit'] = $this->model_app->view_where('rb_lab', array('id_lab'=>$id))->row_array();
            $this->template->load('administrator/template','administrator/mod_lab/edit',$data);
        }
    }

    function delete_lab(){
        cek_session_akses('lab',$this->session->id_session);
        $id = array('id_lab' => $this->uri->segment(3));
        $this->model_app->delete('rb_lab',$id);
        $this->model_app->delete('rb_lab_asset',$id);
        redirect($this->uri->segment(1).'/lab');
    }

    function asset_lab(){
        cek_session_akses('lab',$this->session->id_session);
        $data['row'] = $this->model_app->view_where('rb_lab',array('id_lab'=>$_GET['id']))->row_array();
        $data['record'] = $this->model_app->view_where('rb_lab_asset',array('id_lab'=>$_GET['id']));
        $this->template->load('administrator/template','administrator/mod_lab/asset_lab/view',$data);
    }

    function tambah_asset_lab(){
        cek_session_akses('lab',$this->session->id_session);
        if (isset($_POST['submit'])){
            $data = array(
                            'id_lab'=>$this->input->post('id_lab'),
                            'kode_asset'=>$this->input->post('a'),
                            'nama_asset'=>$this->input->post('b'),
                            'qty'=>$this->input->post('c'),
                            'keterangan'=>$this->input->post('d'));
            $this->model_app->insert('rb_lab_asset',$data);
            redirect($this->uri->segment(1).'/asset_lab?id='.$this->input->post('id_lab'));
        }else{
            $this->template->load('administrator/template','administrator/mod_lab/asset_lab/tambah');
        }
    }
    
    function edit_asset_lab(){
        cek_session_akses('lab',$this->session->id_session);
        $id = $this->input->get('detail');
        if (isset($_POST['submit'])){
            $data = array(
                        'kode_asset'=>$this->input->post('a'),
                        'nama_asset'=>$this->input->post('b'),
                        'qty'=>$this->input->post('c'),
                        'keterangan'=>$this->input->post('d'),
                        );         
            $where = array('id_lab_asset' => $this->input->post('id_lab_asset'));
            $this->model_app->update('rb_lab_asset', $data, $where);
            redirect($this->uri->segment(1).'/asset_lab?id='.$this->input->post('id_lab'));
        }else{
            $data['edit'] = $this->model_app->view_where('rb_lab_asset', array('id_lab_asset'=>$id))->row_array();
            $this->template->load('administrator/template','administrator/mod_lab/asset_lab/edit',$data);
        }
    }


    function delete_lab_asset(){
        cek_session_akses('lab',$this->session->id_session);
        $id = array('id_lab_asset' => $this->uri->segment(3));
        $this->model_app->delete('rb_lab_asset',$id);
        redirect($this->uri->segment(1).'/asset_lab?id='.$this->uri->segment(4));
    }

}
