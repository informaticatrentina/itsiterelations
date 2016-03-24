<?php

$Module = array( 'name' => 'relations' );

$ViewList = array();

$ViewList['siteextensions'] = array(
    'script'			=>      'siteextensions.php',
    'params'			=> 	array('Format'),
    'unordered_params'		=> 	array(),
    'single_post_actions'	=> 	array(),
    'post_action_parameters'	=> 	array()
);

$ViewList['extensions'] = array(
    'script'			=>      'extensions.php',
    'params'			=> 	array('Format', 'Dependencies'),
    'unordered_params'		=> 	array(),
    'single_post_actions'	=> 	array(),
    'post_action_parameters'	=> 	array()
);

$FunctionList = array();
$FunctionList['extensions'] = array();
$FunctionList['siteextensions'] = array();
