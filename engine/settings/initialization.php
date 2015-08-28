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

$paths         = array($doctrina_paths_entity_files);
$isDevMode     = false;
$config        = Setup::createAnnotationMetadataConfiguration($paths, true);
$entityManager = EntityManager::create($dbParams, $config);

# init Smarty
$smarty = new Smarty;

# init smarty templates dir
$smarty->setTemplateDir($smarty_template_dir);

# init smarty compile templates dir
$smarty->setCompileDir($smarty_compile_dir);
