<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of base
 *
 * @author fulvi
 */
class BM_Controler extends CI_Controller {

    public $links = [
        'modify'
    ];
    public $view_sequece = [
        'default/start_html_head',
        'default/head',
        'default/start_head_body',
        'default/nav_bar',
        'default/sub_nav_bar',
        'default/main',
        'default/extra',
        'default/footer',
        'default/javascript',
        'default/end_html_body',
    ];
    var $data = [];
    var $group_by, $order_by, $limit, $off_set;

    public function __construct() {
        parent::__construct();
        $this->lang->load('controller/' . static::class, $this->config->item('language'));
        $this->lang->load('controller/BM_Controller', $this->config->item('language'));
    }

//OVERIDE
    public function set_model($model) {
        $this->load->model($model, 'model');
    }

    protected function get_data($hook, $data): array {
        return $data;
    }

    public function show_list(array $data) {
        foreach ($this->view_sequece as $value) {
            $this->load->view($value, $data);
        }
    }

    public function show_form(array $data) {
        foreach ($this->view_sequece as $value) {
            $this->load->view($value, $data);
        }
    }

//OVERIDE

    public function index() {
        $this->off_set = $this->uri->segment(3, 0);
        $this->limit = ($this->input->post('limit') ?? $this->config->item('per_page'));
        $this->order_by = ($this->input->post('oreder_by', TRUE) ?? NULL);
        $this->group_by = ($this->input->post('group_by', TRUE) ?? NULL);
        if (empty($this->input->post())) {
            //lista
            $this->data = $this->get_data('lista', $this->data);
            if (isset($this->model)) {
                $this->data = array_merge($this->data, ['lista' => $this->model->list($this->limit, $this->off_set, $this->order_by, $this->group_by)]);
            } else {
                $this->data = array_merge($this->data, ['lista' => $this->lang->line('Model class was not seted, please use $this-set_model($model) to set it in __constructor method')]);
            }
        } else {
            //busca
            $this->data = array_merge($this->input->post(null, TRUE), $this->data);
            $this->data = $this->get_data('busca', $this->data);
            if (isset($this->model)) {
                $this->data = array_merge($this->data, ['busca' => $this->model->search($this->data, $this->limit, $this->off_set, $this->order_by, $this->group_by)]);
            } else {
                $this->data = array_merge($this->data, ['busca' => $this->lang->line('Model class was not seted, please use $this-set_model($model) to set it in __constructor method')]);
            }
        }
        $this->show_list($this->data);
    }

    public function modify() {
        if (empty($this->input->post())) {
            if ($this->uri->segment(3, false)) {
                $this->limit = 1;
                $this->off_set = 0;
                $this->order_by = NULL;
                $this->group_by = NULL;
                //seleciona
//                $this->data = array_merge(['hidden_filds' => ['id' => $this->uri->segment(3)]], $this->data);
                $this->data = $this->get_data('seleciona', $this->data);
                if (isset($this->model)) {
                    $this->data = array_merge($this->data, ['seleciona' => $this->model->search($this->uri->segment(3), $this->limit, $this->off_set, $this->order_by, $this->group_by)]);
                } else {
                    $this->data = array_merge($this->data, ['seleciona' => $this->lang->line('Model class was not seted, please use $this-set_model($model) to set it in __constructor method')]);
                }
                //show form
                $this->show_form($this->data);
            } else {
                
            }
        } else {
            if (($this->input->post('id', TRUE) ?? false)) {
                $this->data = array_merge($this->input->post(null, TRUE), $this->data);
                //altera
                $this->data = $this->get_data('altera', $this->data);
//                $this->model->upd
                if (isset($this->model)) {
                    $this->data = array_merge($this->data, ['altera' => $this->model->upd()]);
                } else {
                    $this->data = array_merge($this->data, ['altera' => '' /* $this->lang->line('') */]);
                }
            } else {
                $this->data = array_merge($this->input->post(null, TRUE), $this->data);
                //cria
                $this->data = $this->get_data('cria', $this->data);
//                $this->model->add
                if (isset($this->model)) {
                    $this->data = array_merge($this->data, ['cria' => $this->model->upd()]);
                } else {
                    $this->data = array_merge($this->data, ['cria' => '' /* $this->lang->line('') */]);
                }
            }
            //apaga cache (index e modify)
            $this->show_list($this->data);
        }
    }

    public function remove() {
        if (empty($this->input->post())) {
            if ($this->uri->segment(3, false)) {
                //remove
                $this->data = $this->get_data('remove', $this->data);
                if (isset($this->model)) {
                    $this->model->del($this->uri->segment(3));
                } else {
                    log_message('error', $this->lang->line('Model class was not seted, please use $this-set_model($model) to set it in __constructor method'));
                    show_error($this->lang->line('Model class was not seted!'));
                }
            }
        } else {
            $this->data = array_merge($this->input->post(null, TRUE), $this->data);
            //remove
            $this->data = $this->get_data('remove', $this->data);
            if (isset($this->model)) {
                $this->model->del($this->data);
            } else {
                log_message('error', $this->lang->line('Model class was not seted, please use $this-set_model($model) to set it in __constructor method'));
                show_error($this->lang->line('Model class was not seted!'));
            }
        }
    }

}
