<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RESTController;

class Beranda extends RESTController {
    
    function __construct($config = 'rest'){
        parent::__construct($config);
        $this->load->database();
    }

    /*
    * GET /Beranda => Used for to get Banner Slider
    */
    function index_get(){
        $this->response(
            array(
                'data' => $this->db->get('tb_slider')->result()
            ), 200
        );
    }

    /*
    * GET /Beranda/layanan => Used for to get list of layanan
    */
    function layanan_get(){
        $this->response(
            array(
                'data' => $this->db->get('tb_jenis_layanan')->result()
            ), 200
        );
    }
}