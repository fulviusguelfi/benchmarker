<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['pre_controller'] = array(
        'class'    => 'Valid_Session',
        'function' => 'autorize',
        'filename' => 'Valid_Session.php',
        'filepath' => 'hooks',
//        'params'   => array('beer', 'wine', 'snacks')
);

//$hook['post_controller_constructor'] = array(
//        'class'    => 'Valid_Input_Information',
//        'function' => 'autorize',
//        'filename' => 'Valid_Input_Information.php',
//        'filepath' => 'hooks',
////        'params'   => array('beer', 'wine', 'snacks')
//);
