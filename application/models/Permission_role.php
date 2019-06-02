<?php
/**
 * Description of role
 *
 * @author fulvi
 */
class Permission_role extends BM_Model{
    public const TABLE_NAME = 'permission_role';
    public const JOIN_TABLES = [
        ['table' => Permission::TABLE_NAME, 'on' => 'id'],
        ['table' => Role::TABLE_NAME, 'on' => 'id'],
    ];
}
