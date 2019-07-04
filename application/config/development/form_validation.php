<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$config = array(
        'signup' => array(
                array(
                        'field' => 'first_name',
                        'label' => 'lang:First Name',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'last_name',
                        'label' => 'lang:Last Name',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'email',
                        'label' => 'lang:Email',
                        'rules' => 'required|valid_email'
                ),
                array(
                        'field' => 'passwd',
                        'label' => 'lang:Password',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'confirm_passwd',
                        'label' => 'lang:Confirm Password',
                        'rules' => 'required|matches[passwd]'
                ),
        ),
        'signup/modify' => array(
                array(
                        'field' => 'first_name',
                        'label' => 'lang:First Name',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'last_name',
                        'label' => 'lang:Last Name',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'email',
                        'label' => 'lang:Email',
                        'rules' => 'required|valid_email'
                ),
                array(
                        'field' => 'passwd',
                        'label' => 'lang:Password',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'confirm_passwd',
                        'label' => 'lang:Confirm Password',
                        'rules' => 'required|matches[passwd]'
                ),
        ),
);