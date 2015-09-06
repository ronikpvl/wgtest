<?php
/**
 * Created by PhpStorm.
 * User: info_000
 * Date: 28.08.2015
 * Time: 0:02
 */


// Путь к шаблонам Smarty
$smarty_template_dir = "../engine/templates/";

// Путь к временным шаблонам Smarty
$smarty_compile_dir  = "../engine/templates_c/";

// Настройки для класса Routing

$class_controller_settings = array(
                                'controller_directory_path'     => $_SERVER['DOCUMENT_ROOT'].'/engine/controller/',
                                'controller_default'            => 'mainPage',
                                'controller_error'              => '404',
                                'action_default'                => 'indexAction',
                                'controller_property_file_path' => $_SERVER['DOCUMENT_ROOT'].'/engine/settings/controller.json'
                            );

$doctrina_paths_entity_files = "/path/to/entity-files";