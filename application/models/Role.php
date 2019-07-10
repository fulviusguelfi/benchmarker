<?php

/**
 * Description of role
 *
 * @author fulvi
 */
class Role extends BM_Model {

    public const TABLE_NAME = 'role';
    public const JOIN_TABLES = [];

    public function get_default_role_id() {
        $role = $this->search(['name' => $this->lang->line('Guest')]);
        if(count($role) == 0){
            show_error($this->lang->line('Guest role was not found in database'));
        }
        if (count($role) == 1) {
            return $role[0]['role.id'];
        }else{
            show_error($this->lang->line('So much roles Guest founded in database'));
        }
    }

}
