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
    var $group_by, $order_by, $limit, $off_set, $model_name;

    public function __construct() {
        parent::__construct();
        $this->lang->load('controller/' . static::class, $this->config->item('language'));
        $this->lang->load('controller/BM_Controller', $this->config->item('language'));
        $this->load->library('form_validation');
        $this->load->helper(['url']);
    }

//OVERIDE
    public function set_model($model) {
        $this->model_name = $model;
        $this->load->model($model, 'model');
    }

    protected function get_data($hook, $data): array {
        return $data;
    }

    public function show_list(array $data) {
        //apaga cache (index e modify)
        if ((!empty($data['altera']) && $data['altera'] == true) || (!empty($data['cria']) && $data['cria'] == true) || (!empty($data['remove']) && $data['remove'] == true)) {
            $this->cache_delete_db();
            if ($this->session->has_userdata('last_list')) {
                redirect($this->session->userdata('last_list'));
            }
        }
        if (ENVIRONMENT === 'development') {
//            var_dump($data);
        }
        $this->session->set_userdata('last_list', $this->uri->uri_string());
        foreach ($this->view_sequece as $value) {
            $this->load->view($value, $data);
        }
    }

    public function show_form(array $data) {
        if (ENVIRONMENT === 'development') {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
        foreach ($this->view_sequece as $value) {
            $this->load->view($value, $data);
        }
    }

    protected function cache_delete_db() {
        
    }

    protected function form_common() {
        
    }

//OVERIDE

    public function index() {
        $this->off_set = $this->uri->rsegment(3, 0);
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
            //lista com busca
            $this->data = array_merge($this->input->post(null, TRUE), $this->data);
            $this->data = $this->get_data('lista', $this->data);
            if (isset($this->model)) {
                $this->data = array_merge($this->data, ['lista' => $this->model->search($this->data, $this->limit, $this->off_set, $this->order_by, $this->group_by)]);
            } else {
                $this->data = array_merge($this->data, ['lista' => $this->lang->line('Model class was not seted, please use $this-set_model($model) to set it in __constructor method')]);
            }
        }
        $this->show_list($this->data);
    }

    public function modify() {
        if (empty($this->input->post())) {
            $this->data = array_merge($this->data, ['form_action' => $this->uri->uri_string()]);
            if ($this->uri->rsegment(3, false)) {
                //seleciona
                $got_form = $this->form_common();
                $this->data = $this->get_data('seleciona', $this->data);
                $this->data = ($got_form !== false) ? array_merge($this->data, $this->bm_form_builder->build_form()) : $this->data;
                $this->show_form($this->data);
            } else {
                //novo init
                $got_form = $this->form_common();
                $this->data = $this->get_data('novo', $this->data);
                $this->data = ($got_form !== false) ? array_merge($this->data, $this->bm_form_builder->build_form()) : $this->data;
                $this->show_form($this->data);
            }
        } else {
            $form_validation_group = $this->uri->segment(1);
            if ($this->uri->segment(2, false) && $this->uri->rsegment(2) === $this->uri->segment(2)) {
                $form_validation_group = $this->uri->slash_segment(1) . $this->uri->segment(2);
            }
            $this->form_validation->run($form_validation_group);
            
            //push post in data
            $this->data = array_merge($this->input->post(null, TRUE), $this->data);
            
            if (count($this->form_validation->error_array()) > 0) {
                $this->data = array_merge($this->data, ['form_action' => $this->uri->uri_string()]);
                $this->data['form_erros'] = $this->form_validation->error_array();
                $got_form = $this->form_common();
                if (($this->input->post('id', TRUE) ?? false)) {
                    //seleciona
                    $this->data = $this->get_data('erro_seleciona', $this->data);
                } else {
                    //novo
                    $this->data = $this->get_data('erro_novo', $this->data);
                }
                $this->data = ($got_form !== false) ? array_merge($this->data, $this->bm_form_builder->build_form()) : $this->data;
                $this->show_form($this->data);
            } else {
                if (($this->input->post('id', TRUE) ?? false)) {
                    //altera
                    $this->data = $this->get_data('altera', $this->data);
                    if (isset($this->model)) {
                        $this->data = array_merge($this->data, ['altera' => $this->model->upd($this->data)]);
                    } else {
                        $this->data = array_merge($this->data, ['altera' => $this->lang->line('Model class was not seted, please use $this-set_model($model) to set it in __constructor method')]);
                    }
                } else {
                    //cria
                    $this->data = $this->get_data('cria', $this->data);
                    if (isset($this->model)) {
                        $this->data = array_merge($this->data, ['cria' => $this->model->add($this->data)]);
                    } else {
                        $this->data = array_merge($this->data, ['cria' => $this->lang->line('Model class was not seted, please use $this-set_model($model) to set it in __constructor method')]);
                    }
                }
                $this->show_list($this->data);
            }
        }
    }

    public function remove() {
        if (empty($this->input->post())) {
            if ($this->uri->rsegment(3, false)) {
                //remove
                $this->data = $this->get_data('remove', $this->data);
                if (isset($this->model)) {
                    $this->data = array_merge($this->data, ['remove' => $this->model->del($this->uri->rsegment(3))]);
                } else {
                    $this->data = array_merge($this->data, ['remove' => $this->lang->line('Model class was not seted, please use $this-set_model($model) to set it in __constructor method')]);
                    log_message('error', $this->lang->line('Model class was not seted, please use $this-set_model($model) to set it in __constructor method'));
                }
            }
        } else {
            $this->data = array_merge($this->input->post(null, TRUE), $this->data);
            //remove
            $this->data = $this->get_data('remove', $this->data);
            if (isset($this->model)) {
                $this->data = array_merge($this->data, ['remove' => $this->model->del($this->data)]);
            } else {
                $this->data = array_merge($this->data, ['remove' => $this->lang->line('Model class was not seted, please use $this-set_model($model) to set it in __constructor method')]);
                log_message('error', $this->lang->line('Model class was not seted, please use $this-set_model($model) to set it in __constructor method'));
            }
        }
        $this->show_list($this->data);
    }

}
