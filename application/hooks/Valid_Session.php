<?php

/**
 * Description of Valid_Session
 *
 * @author fulvius
 */
class Valid_Session extends CI_Hooks {

    protected $SESS, $URI, $CFG;

    public function __construct() {
        parent::__construct();
        $this->CFG = & load_class('Config', 'core');
        $this->URI = & load_class('URI', 'core');
        $this->SESS = & load_class('Session', 'libraries/Session');
        log_message('info', 'Validating Session');
    }

    public function autorize() {
        if (!$this->__is_permited()) {
            header("Refresh:0;url=" . $this->CFG->base_url('login'));
        }
    }

    private function __is_permited() {
        return ($this->__home_access() || $this->__default_permited() || $this->__is_signed_redirection() || $this->SESS->has_userdata('loged_user'));
    }

    private function __home_access() {
        $home_access = ($this->URI->uri_string === '' && count($this->URI->segments) === 0 && $this->URI->rsegments[1] === 'welcome' && $this->URI->rsegments[2] === 'modify');
        log_message('info', 'Home Access: ' . $home_access);
        return $home_access;
    }

    private function __default_permited() {
        foreach ($this->__capture_segments() as $segment) {
            if($default_permited = in_array($segment, $this->CFG->item('default_permited'))){
                break;
            }
        }
        log_message('info', 'Default Permited: ' . $default_permited);
        return $default_permited;
    }

    private function __capture_segments() {
        $segments = [
            $this->URI->segment(1),
            $this->URI->rsegment(1),
        ];
        if(null !== $this->URI->segment(2)){
           $segments[] = $this->URI->slash_segment(1) . $this->URI->segment(2);
        }
        if(null !== $this->URI->rsegment(2)){
           $segments[] = $this->URI->slash_rsegment(1) . $this->URI->rsegment(2);
        }
        return $segments;
    }
    
    private function __is_signed_redirection() {
        $is_signed_redirection = ($this->SESS->flashdata('is_redirect') ?? false);
        log_message('info', 'Singed Autorized Redirection: ' . $is_signed_redirection);
        return $is_signed_redirection;
    }

}
