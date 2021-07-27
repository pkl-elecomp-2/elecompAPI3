<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RESTController;

class Tentang extends RESTController {

    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    // GET /Tentang
    function index_get() {
        $data = array(
            'status' => 'success',
            'data' => $this->db->get('tb_tentang')->result()
        );

        $this->response($data, 200);
    }
}