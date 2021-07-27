<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RESTController;

class Artikel extends RESTController {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();        
    }

    /**
     * GET Function
     * /Artikel => GET all Artikel
     * /Artikel?id=1 => GET Artikel with id 1
     */
    function index_get(){
        $id = $this->get('id');
        
        // Get Artikel
        $data = array();
        if(!empty($id)){
            $data = array(
                'data' => $this->db->get_where('tb_artikel', array('id_artikel' => $id))->result()
            );
            $this->addView($id);
        } else {
            $data = array(
                'data' => $this->db->get('tb_artikel')->result()
            );
        }
        $this->response($data, 200);
    }

    private function addView($id){
        $this->db->set('artikel_dilihat', 'artikel_dilihat+1', FALSE);
        $this->db->where('id_artikel', $id);
        $this->db->update('tb_artikel');
    }

    /**
     * GET Function
     * /Artikel/comment => GET all comment of Artikel
     * /Artikel/comment?id=1 => GET comment of Artikel with id_artikel 1
     */
    function comment_get(){
        $id = $this->get('id');
        $data = (!empty($id)) ?
            array(
                'data' => $this->db->get_where('tb_komentar', array('id_artikel' => $id))->result()
            ) :
            array(
                'data' => $this->db->get('tb_komentar')->result()
            );

        $this->response($data, 200);
    }


    // Add Comment Function
    function comment_post(){
        $data = array(
            'id_komentar' => 0,
            'id_artikel' => $this->post('id_artikel'),
            'nama_komentar' => $this->post('nama_komentar'),
            'email_komentar' => $this->post('email_komentar'),
            'no_tlp' => $this->post('no_tlp'),
            'tanggal_komentar' => $this->post('tanggal_komentar'),
            'deskripsi_komentar' => $this->post('deskripsi_komentar')
        );

        $insert = $this->db->insert('tb_komentar', $data);

        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'Failed to Add'), 500);
        }
    }

    // DEV ONLY
    function dev_get(){
        $fields = $this->db->field_data('tb_artikel');
        foreach ($fields as $field) {
            echo "<p>" . $field->name . " || " . $field->type . " || " . $field->max_length . "</p>";
        }
    }
}