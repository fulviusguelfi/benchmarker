<?php

include_once 'Role.php';

/**
 * Description of role
 *
 * @author fulvi
 */
class User extends BM_Model {

    public const TABLE_NAME = 'user';
    public const JOIN_TABLES = [
        ['table' => Role::TABLE_NAME, 'on' => 'id']
    ];

    public function __construct() {
        parent::__construct();
        $this->load->library(['encryption', 'session']);
    }

    public function untokenize_user($token) {
        $this->encryption->initialize(['cipher' => 'aes-128']);
        $token = $this->encryption->decrypt(urldecode($token));
        $token = json_decode($token);
        if ($token->timestamp >= time()) {
            $id = 'user.id';
            return $token->$id;
        } else {
            show_error($this->lang->line('Your token has exipired. Try again ') . anchor('reset_password', $this->lang->line('Reset Password'), 500, $this->lang->line('Invalid Token')));
        }
    }

    public function send_mail_user($param) {
        if ($user = $this->__select_single_user_by_email($param)) {
            log_message('info', 'Sending Reset Password Email to: ' . $user['user.email']);
            $token = json_encode((object) [
                        'user.id' => $user['user.id'],
                        'timestamp' => time() + 3600,
            ]);
            $this->encryption->initialize(['cipher' => 'aes-128']);
            $token = urlencode($this->encryption->encrypt($token));
            $link = site_url('new_password') . '/' . $token;
            $message = $this->lang->line('Follow this link to reset password: ') . $link;
            return $this->__send_mail($user['user.email'], $this->lang->line('Reset Password'), $message);
        }
        log_message('error', 'Sending Reset Password Email ' . print_r($param, true));
        return $user; //false
    }

    public function is_valid_user($param) {
        if ($user = $this->__select_single_user_by_email($param)) {
            if ($this->__is_valid_password($param, $user)) {
                $this->__set_user_loged($param, $user);
                return true;
            }
        }
        return false;
    }

    private function __send_mail($to, $subject, $message) {
        $from = 'fulvius@gpmail.com.br';
        $config = [
            'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => $from,
            'smtp_pass' => 'ftg251074',
            'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
            'newline' => "\r\n",
            'mailtype' => 'text', // or html
            'smtp_timeout' => '4', //in seconds
            'priority' => '1', //in seconds
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        ];
        $this->load->library('email', $config);
//        $this->email->initialize($config);
        $this->email->from($from, 'CFG Soluções');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        return $this->email->send();
    }

    private function __is_valid_password(&$param, &$user) {
        $passwd = $param['passwd'];
        unset($param['passwd']);
        $this->encryption->initialize(['cipher' => 'aes-256']);
        return $this->encryption->decrypt($user['user.passwd']) === $passwd;
    }

    private function __set_user_loged(&$param, &$user) {
        $keep_signed = ($param['keep_signed'] ?? 0);
        unset($param['keep_signed']);
        if ($keep_signed === '1') {
            unset($user['user.passwd']);
            $this->session->set_userdata('loged_user', $user);
        }
    }

    private function __select_single_user_by_email($param) {
        if (empty($param) || empty($param['email'])) {
            log_message('error', $this->lang->line('Email was not supplied for user search ') . print_r($param, true));
            return false;
        }
        $user = $this->search($param, $this->count_all);
        return (count($user) === 1) ? $user[0] : false;
    }

}
