<?php

include_once 'permission_role.php';

/**
 * Description of role
 *
 * @author fulvi
 */
class permission extends BM_Model {

    public const TABLE_NAME = 'permission';
    public const JOIN_TABLES = [
        ['table' => permission_role::TABLE_NAME, 'on' => 'id_permission']
    ];

}
