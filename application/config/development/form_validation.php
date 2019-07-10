<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$config = array(
        'singup' => array(
                array(
                        'field' => 'first_name',
                        'label' => 'lang:First_Name',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'last_name',
                        'label' => 'lang:Last_Name',
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
                        'field' => 'agree_terms',
                        'label' => 'lang:Agree_with_the_Terms_&_Conditions.',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'confirm_passwd',
                        'label' => 'lang:Confirm_Password',
                        'rules' => 'required|matches[passwd]'
                ),
        ),
        'reset_password' => array(
                array(
                        'field' => 'email',
                        'label' => 'lang:Email',
                        'rules' => 'required|valid_email'
                ),
        ),
        'reset_password/modify' => array(
                array(
                        'field' => 'passwd',
                        'label' => 'lang:Password',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'confirm_passwd',
                        'label' => 'lang:Confirm_Password',
                        'rules' => 'required|matches[passwd]'
                ),
        ),
);