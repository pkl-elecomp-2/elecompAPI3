<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Client extends RestController {
    function __construct($config='rest')
    {
        parent::__construct($config);
        $this->load->database();
    }

    // Login
    function index_get(){
        $username = $this->input->get('username');
        $password = $this->input->get('password');

        if (!empty($username) && !empty($password)) {
            $this->db->where('username', $username);
            $this->db->where('view_password', $password);
            $result = $this->db->get('tb_member')->result();

            if (count($result) > 0) {
                $this->response(array('status' => 'success', 'message' => 'Login success', 'data' => $result), 200);
            } else {
                $this->response(array('status' => 'failed', 'message' => 'Login failed'), 200);
            }
        } else {
            $this->response(array('status' => 'error', 'message' => 'Missing username or password'), 404);
        }
    }

    // Profil
    function profil_get(){
        $id = $this->input->get('id');
        $data = array(
            'data' => $this->db->get_where('tb_member', array('id_member' => $id))->result()
        );

        $this->response($data, 200);
    }

    // Ticket
    function ticket_get(){
        $data = array(
            'data' => $this->db->get('td_tiket')->result()
        );

        $this->response($data, 200);
    }

    function ticket_post(){
        $data = array(
            'id' => 0,
            'pesan' => $this->post('pesan'),
            'image' => $this->post('image'),
            'nama_user' => $this->post('nama_user')
        );
        $insert = $this->db->insert('td_tiket', $data);

        if ($insert) {
            $this->response(array('status' => 'success', 'message' => 'Tiket berhasil ditambahkan'), 200);
        } else {
            $this->response(array('status' => 'failed', 'message' => 'Tiket gagal ditambahkan'), 200);
        }
    }

    function survey_post(){
        $data = array(
            'id_survey' => 0,
            'nama' => $this->post('nama'),
            'no_tlp' => $this->post('no_tlp'),
            'email' => $this->post('email'),
            'deskripsi_survey' => $this->post('deskripsi_survey')
        );

        $insert = $this->db->insert('tb_survey', $data);
        
        if ($insert) {
            $this->response(array('status' => 'success', 'message' => 'Survey berhasil ditambahkan'), 200);
        } else {
            $this->response(array('status' => 'failed', 'message' => 'Survey gagal ditambahkan'), 200);
        }
    }
}