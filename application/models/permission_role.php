<?php
/**
 * Description of role
 *
 * @author fulvi
 */
class permission_role extends BM_Model{
    public const TABLE_NAME = 'permission_role';
    public const JOIN_TABLES = [
        ['table' => permission::TABLE_NAME, 'on' => 'id'],
        ['table' => role::TABLE_NAME, 'on' => 'id'],
    ];
}
