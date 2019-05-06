<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of base
 *
 * @author fulvi
 */
class base extends CI_Controller {

    private const LINKS = [];

    var $data = [];

    public function __construct(): void {
        parent::__construct();
    }

    public function index() {
        $off_set = $this->input->segment(3, 0);
        if (empty($this->input->post())) {
            //lista
        } else {
            $data = array_merge($this->input->post(), $this->data);
            //busca
        }
    }

    public function modify() {
        $id = $this->input->segment(3, 0);
        if (empty($this->input->post())) {
            if ($id === 0) {
                //novo
            } else {
                //seleciona
                $this->data = array_merge(['hidden_filds' => ['id' => $id]], $this->data);
            }
            //show form
        } else {
            if (isset($this->input->post('id'))) {
                //altera
            } else {
                //cria
            }
            //apaga cache (index e modify)
            //show list
        }
    }

}
