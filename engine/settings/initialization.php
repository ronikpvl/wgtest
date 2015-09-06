<?php
/**
 * Created by PhpStorm.
 * User: info_000
 * Date: 28.08.2015
 * Time: 0:00
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use \Smarty;


require_once($_SERVER['DOCUMENT_ROOT'] . "/engine/libs/Routing.php");
require_once($_SERVER['DOCUMENT_ROOT']."/engine/libs/Data.php");
require_once($_SERVER['DOCUMENT_ROOT']."/engine/libs/Controller.php");

$paths         = array($doctrina_paths_entity_files);
$isDevMode     = false;
$config        = Setup::createAnnotationMetadataConfiguration($paths, true);
$entityManager = EntityManager::create($dbParams, $config);

# init Smarty
$smarty     = new Smarty;

$routing    = new Routing($class_route_settings);

$data       = new Data();

$controller = new Controller($routing, $class_controller_settings);

# init smarty templates dir
$smarty->setTemplateDir($smarty_template_dir);

# init smarty compile templates dir
$smarty->setCompileDir($smarty_compile_dir);


