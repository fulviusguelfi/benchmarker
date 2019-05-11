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
class BM_Controler extends CI_Controller {

    private const LINKS = [];

    private $model;
    var $data = [];

    public function __construct(): void {
        parent::__construct();
        $this->load->model('base');
        $this->model = $this->base;
    }

    protected function get_model() {
        return $this->model;
    }

    public function index() {
        $off_set = $this->input->segment(3, 0);
        $limit = ($this->input->post('limit') ?? $this->config->item('per_page'));
        $order_by = ($this->input->post('oreder_by', TRUE) ?? NULL);
        $group_by = ($this->input->post('group_by', TRUE) ?? NULL);
        if (empty($this->input->post())) {
            //lista
            $this->data = array_merge($this->data, ['lista' => $this->model->list($limit, $off_set, $order_by, $group_by)]);
        } else {
            $this->data = array_merge($this->input->post(null, TRUE), $this->data);
            //busca
            $this->data = $this->get_data('busca', $this->data);
            $this->data = array_merge($this->data, ['busca' => $this->model->search($this->data, $limit, $off_set, $order_by, $group_by)]);
        }
    }

    protected function get_data($hook, $data): array {
//        to override
        //hooks [busca,]
    }

    public function modify() {
        if (empty($this->input->post())) {
            if ($this->input->segment(3, false)) {
                //seleciona
                $this->data = $this->get_data('seleciona', $this->data);
                $this->data = array_merge(['hidden_filds' => ['id' => $this->input->segment(3)]], $this->data);
//                $this->model->search
            }
            //show form
        } else {
            $id = ($this->input->post('id') ?? false);
            if ($id) {
                //altera
                $this->data = $this->get_data('altera', $this->data);
//                $this->model->upd
            } else {
                //cria
                $this->data = $this->get_data('cria', $this->data);
//                $this->model->add
            }
            //apaga cache (index e modify)
            //show list
        }
    }

}
