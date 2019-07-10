<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//include_once(APPPATH.'core/BM_Controller.php');

class Reset_password extends BM_Controler {

    protected $redirect_uri = 'login';

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
    }

    protected function form_common() {
        $this->bm_form_builder->assign_vars('user', null);
    }

    protected function cache_delete_db() {
        $this->db->cache_delete('reset_password', 'index');
        $this->db->cache_delete('reset_password', 'modify');
    }

    protected function get_data($hook, $data): array {
        $data = array_merge($data, ['page_title' => $this->lang->line('Reset Password')]);
        if ($hook === 'lista') {
            
        } elseif ($hook === 'busca') {
            
        } elseif ($hook === 'seleciona' || $hook === 'erro_seleciona') {
            $data = array_merge($data, [
                'form_title' => $this->lang->line('Reset Password'),
                'form_description' => $this->lang->line('Type your new password'),
            ]);
            $data['form_action'] = $this->uri->slash_rsegment(1) . $this->uri->slash_rsegment(2);
            
            //untokenize url
            if (!isset($data['id'])) {
                $this->load->model('user');
                try {
                    $id = $this->user->untokenize_user($this->uri->segment(2));
                } catch (Exception $exc) {
                    show_error($exc->getMessage());
                }
                $this->bm_form_builder->assign_vars('user', $id);
            } else {
                $this->bm_form_builder->assign_vars('user', $data['id']);
            }

            $this->bm_form_builder->exclude_form_values(['email', 'first_name', 'last_name', 'id_role', 'agree_terms']);
            $this->bm_form_builder->hide_form_values(['id']);
            $this->bm_form_builder->set_extra_for('passwd', ['placeholder' => $this->lang->line('Password'), 'class' => 'form-control login username-field']);
            $this->bm_form_builder->set_password_type('passwd');
            $this->bm_form_builder->set_value('passwd', '');
            $this->bm_form_builder->add_form_values('confirm_passwd');
            $this->bm_form_builder->set_password_type('confirm_passwd');
            $this->bm_form_builder->set_extra_for('confirm_passwd', ['placeholder' => $this->lang->line('Confirm Password'), 'class' => 'form-control']);
        } elseif ($hook === 'novo' || $hook === 'erro_novo') {
            $data = array_merge($data, [
                'form_title' => $this->lang->line('Reset Password'),
                'form_description' => $this->lang->line('If you are a registred member wil recive a email before send this form'),
            ]);

            $this->bm_form_builder->exclude_form_values(['passwd', 'first_name', 'last_name', 'id_role', 'id', 'agree_terms']);
            $this->bm_form_builder->set_extra_for('email', ['placeholder' => $this->lang->line('Email'), 'class' => 'form-control login username-field']);
        } elseif ($hook === 'altera') {
            unset($data['submit']);
            unset($data['page_title']);
            unset($data['confirm_passwd']);
            $this->load->model('user');
        } elseif ($hook === 'cria' || $hook === 'remove') {
            unset($data['submit']);
            unset($data['page_title']);
            $this->load->model('user');
            $data['mail_sent'] = $this->user->send_mail_user($data);
        }
        return parent::get_data($hook, $data);
    }

    public function show_list(array $data) {
        if (isset($data['mail_sent']) && $data['mail_sent']) {
            redirect($this->redirect_uri);
        } else {
            show_error($this->lang->line('The email couldn`t be sent. Try later please.'), 500, $this->lang->line('Email Server Error'));
        }
    }

    public function show_form(array $data) {
        if (!isset($data['mail_sent'])) {
            $this->view_sequece = array_replace($this->view_sequece, [array_search('default/head', $this->view_sequece) => 'login/head']);
            $this->view_sequece = array_replace($this->view_sequece, [array_search('default/javascript', $this->view_sequece) => 'login/javascript']);
            $this->view_sequece = array_replace($this->view_sequece, [array_search('default/nav_bar', $this->view_sequece) => 'reset_password/nav_bar']);
            $this->view_sequece = array_replace($this->view_sequece, [array_search('default/main', $this->view_sequece) => 'reset_password/form']);
        }
        parent::show_form($data);
    }

}
