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
class Element extends BM_Model{
    public const TABLE_NAME = 'element';
    public const JOIN_TABLES = [
        ['table' => permission::TABLE_NAME, 'on' => 'id'],
    ];
}
