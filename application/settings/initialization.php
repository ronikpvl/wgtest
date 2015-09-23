<?php
/**
 * Created by PhpStorm.
 * User: info_000
 * Date: 28.08.2015
 * Time: 0:00
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Composer\Autoload\ClassLoader;
use \Core\Libs\Route;

//$loader = new \Composer\Autoload\ClassLoader();

$loader = new ClassLoader;

$loader->add('Core\Libs\Route', $_SERVER['DOCUMENT_ROOT'].'');

$loader->register();


$route = new Route();





/*
print_r(__NAMESPACE__);

new Routing();

echo '1';



use \Core\Libs\Routing;
use \Core\Libs\Controller;


function spl_autoload($class){
    echo $class;
    $class = str_replace('\\', '/', $class);
    include $_SERVER['DOCUMENT_ROOT'] . '/' . $class . '.php';

    echo  $_SERVER['DOCUMENT_ROOT'] . '/' . $class . '.php';
}
*/
//new Routing;
//$controller = new Controller;

//$route->test();

//require_once($_SERVER['DOCUMENT_ROOT'] . "/engine/libs/Route.php");
//require_once($_SERVER['DOCUMENT_ROOT']."/engine/libs/Data.php");
//require_once($_SERVER['DOCUMENT_ROOT']."/engine/libs/Controller.php");
/*
$paths         = array($doctrina_paths_entity_files);
$isDevMode     = false;
$config        = Setup::createAnnotationMetadataConfiguration($paths, true);
$entityManager = EntityManager::create($dbParams, $config);

# init Smarty
$smarty     = new Smarty;

$routing    = new Routing($class_route_settings);

$data       = new Data();

$controller = new Controller($routing, $class_controller_settings);

# init smarty view dir
$smarty->setTemplateDir($smarty_template_dir);

# init smarty compile view dir
$smarty->setCompileDir($smarty_compile_dir);

*/
