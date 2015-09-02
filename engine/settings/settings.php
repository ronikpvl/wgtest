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

$class_route_settings = array(
                                'path_directory_controller' => $_SERVER['DOCUMENT_ROOT'].'/engine/controller/',
                                'default_controller'        => 'mainpage',
                                'error_controller'          => '404'
                            );

$doctrina_paths_entity_files = "/path/to/entity-files";