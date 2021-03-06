<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Develop extends RestController {

    function __construct($config='rest'){
        parent::__construct($config);
        $this->load->database();
    }

    function index_get(){
        $data = array(
            'activePromo' => $this->activePromo(),
            'nextPromo' => $this->nextPromo(),
            'promos' => $this->db->get('tb_promo')->result()
        );

        $this->response($data, 200);
    }

    private function activePromo() {
        $query = $this->db->query(
            "SELECT * FROM tb_promo WHERE tanggal_mulai < CURDATE() AND tanggal_akhir > CURDATE();"
        );
        return $query->result();
    }

    private function nextPromo() {
        $query = $this->db->query(
            "SELECT * FROM tb_promo WHERE tanggal_mulai > CURDATE()"
        );
        return $query->result();
    }

    function gtes_get(){
        $data = array(
            'data' => $this->db->get('tb_survey')->result()
        );
        $this->response($data, 200);
    }
}