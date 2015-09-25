<?php
/**
 * Created by PhpStorm.
 * User: info_000
 * Date: 18.09.2015
 * Time: 0:53
 */

require_once($_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php");

require_once($_SERVER['DOCUMENT_ROOT']."/application/settings/settings.php");

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Composer\Autoload\ClassLoader;
use \Application\Libs\Data;
use \Application\Libs\Route;
use \Application\Libs\Controller;

$loader = new ClassLoader;

$loader->add('Application\Libs\Data',       $_SERVER['DOCUMENT_ROOT'].'');
$loader->add('Application\Libs\Route',      $_SERVER['DOCUMENT_ROOT'].'');
$loader->add('Application\Libs\Controller', $_SERVER['DOCUMENT_ROOT'].'');

$loader->register();

$paths      = array($doctrina_paths_entity_files);
$isDevMode  = false;
$config     = Setup::createAnnotationMetadataConfiguration($paths, true);
$db         = EntityManager::create($dbParams, $config);

$data       = new Data();
$route      = new Route();
$controller = new Controller();


$route->start($route_settings);