<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of role
 *
 * @author fulvi
 */
class user extends BM_Model{
    public const TABLE_NAME = 'user';
    public const JOIN_TABLES = [
        ['table' => role::TABLE_NAME, 'on' => 'id']
    ];
}
