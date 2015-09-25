<?php
/**
 * Created by PhpStorm.
 * User: info_000
 * Date: 28.08.2015
 * Time: 0:02
 */

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'wg_db'
);

$doctrina_paths_entity_files = "/path/to/entity-files";

/*
// Настройки для класса Routing
$class_controller_settings = array(
                                'controller_directory_path'     => $_SERVER['DOCUMENT_ROOT'].'/application/controller/',
                                'controller_default'            => 'mainPage',
                                'controller_error'              => '404',
                                'action_default'                => 'indexAction',
                                'controller_property_file_path' => $_SERVER['DOCUMENT_ROOT'].'/application/settings/controller.json'
                            );

*/

$route_settings = array(
    'controller_directory_path'     => $_SERVER['DOCUMENT_ROOT'].'/application/controller/',
    'controller_prefix'             => 'Controller',
    'controller_default'            => 'Mainpage',
    'action_default'                => 'indexAction',
    'controller_error'              => '404',
    'controller_property_file_path' => $_SERVER['DOCUMENT_ROOT'].'/application/settings/controller.json',
    'route_template_file_path'      => $_SERVER['DOCUMENT_ROOT'].'/application/settings/route_template.json',
    'route_template_name_default'   => 'default'
);