<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Event extends RestController {
    
    function __construct($config='rest'){
        parent::__construct($config);
        $this->load->database();        
    }
    
    
    function index_get(){
        $id = $this->get('id');

        if (!empty($id)) {
            $data = $this->db->get_where('tb_event', array('id_event' => $id))->result();
        } else {
            $data = array(
                'activeEvent' => $this->activeEvent(),
                'nextEvent' => $this->nextEvent(),
            );
        }

        $this->response($data, 200);
    }

    function all_get(){
        $this->response(
            array( 'events' => $this->db->get('tb_event')->result() ),
            200
        );
    }

    private function activeEvent() {
        $query = $this->db->query(
            "SELECT * FROM tb_event WHERE tanggal_event = CURDATE()"
        );
        return $query->result();
    }

    private function nextEvent() {
        $query = $this->db->query(
            "SELECT * FROM tb_event WHERE tanggal_event > CURDATE()"
        );
        return $query->result();
    }
}