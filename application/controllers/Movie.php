<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Movie extends RestController {
    function __construct($config = 'rest'){
        parent::__construct($config);
        $this->load->database();
    }

    // CREATE
    function index_post(){
        $data = array(
            'id' => $this->post('id'),
            'title' => $this->post('title'),
            'release_date' => $this->post('release_date'),
            'poster' => $this->post('poster')
        );
        
        $insert = $this->db->insert('movies', $data);

        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    // READ
    function index_get(){
        $id = $this->get('id');
        if ($id == '') {
            $movies = $this->db->get('movies')->result();
        } else {
            $this->db->where('id', $id);
            $movies = $this->db->get('movies')->result(); 
        }
        $this->response($movies, 200);
    }

    // UPDATE
    function index_put(){
        $id = $this->put('id');

        $data = array(
            'id' => $this->put('id'),
            'title' => $this->put('title'),
            'release_date' => $this->put('release_date'),
            'poster' => $this->put('poster'),
        );
        $this->db->where('id', $id);
        $update = $this->db->update('movies', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    // DELETE
    function index_delete() {
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('movies');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        } 
    }
}