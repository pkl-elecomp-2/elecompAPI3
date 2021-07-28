<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RESTController;

class Beranda extends RESTController {
    
    function __construct($config = 'rest'){
        parent::__construct($config);
        $this->load->database();
    }

    // GET /Beranda
    function index_get(){
        $data = array(
            'data' => $this->db->get('tb_slider')->result()
        );

        $this->response($data, 200);
    }

    // GET /Beranda/layanan
    function layanan_get(){
        $data = array(
            'data' => $this->db->get('tb_jenis_layanan')->result()
        );

        $this->response($data, 200);
    }
}