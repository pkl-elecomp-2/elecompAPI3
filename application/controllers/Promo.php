<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Promo extends RestController {

    function __construct($config='rest'){
        parent::__construct($config);
        $this->load->database();        
    }

    function index_get(){
        $id = $this->get('id');

        if(!empty($id)){
            $data = $this->db->get_where('tb_promo', array('id_promo' => $id))->row_array();
        } else {
            $data = array(
                'activePromo' => $this->activePromo(),
                'nextPromo' => $this->nextPromo()
            );
        }

        $this->response($data, 200);
    }
    private function activePromo() {
        $query = $this->db->query(
            "SELECT * FROM tb_promo WHERE tanggal_mulai < CURDATE() AND tanggal_akhir >= CURDATE();"
        );
        return $query->result();
    }

    private function nextPromo() {
        $query = $this->db->query(
            "SELECT * FROM tb_promo WHERE tanggal_mulai > CURDATE()"
        );
        return $query->result();
    }
}