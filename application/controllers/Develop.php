<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Develop extends RestController {

    function __construct($config='rest'){
        parent::__construct($config);
        $this->load->database();
    }

    function index_get(){
        $today = strtotime(date('Y-m-d'));
        $data = array(
            'time' => $today . " || " . date('Y-m-d') . ' - ' . date('H:i:s'),
            'activePromo' => $this->activePromo($today),
            'nextPromo' => $this->nextPromo($today),
            'promos' => $this->db->get('tb_promo')->result()
        );

        $this->response($data, 200);
    }

    private function activePromo($date) {
        $today = date($date);
        $query = $this->db->query("SELECT * FROM tb_promo WHERE tanggal_mulai >= '$today' AND tanggal_akhir <= '$today'");
        // $this->db->where('tanggal_mulai >=', date($date));
        // $this->db->where('tanggal_akhir <=', date($date));
        return $query->result();
    }

    private function nextPromo($date) {
        $this->db->where('tanggal_mulai >=', date($date));
        return $this->db->get('tb_promo')->result();
    }

    function gtes_get(){
        $data = array(
            'data' => $this->db->get('tb_survey')->result()
        );
        $this->response($data, 200);
    }
}