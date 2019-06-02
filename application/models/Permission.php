<?php
/**
 * Description of role
 *
 * @author fulvi
 */
class Permission extends BM_Model{
    public const TABLE_NAME = 'permission';
    public const JOIN_TABLES = [
//        ['table' => Permission_role::TABLE_NAME, 'on' => Permission_role::TABLE_NAME.'.id_permission = '.Permission::TABLE_NAME.'.id'],
//        ['table' => Role::TABLE_NAME, 'on' => Permission_role::TABLE_NAME.'.id_role = '.Role::TABLE_NAME.'.id'],
    ];
}
