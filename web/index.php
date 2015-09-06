<?php
require_once("../vendor/autoload.php");

# db connect settings
require_once("../engine/settings/db_settings.php");

# engine settings
require_once("../engine/settings/settings.php");

# initialization all engine: classes, libs, modules
require_once("../engine/settings/initialization.php");




/*
$sql = "SHOW TABLES";


$tmp = $entityManager->getConnection()->prepare($sql);
$tmp->execute();
$result = $tmp->fetchAll();

$smarty->assign('param', '1111');

*/

/*
echo "<pre>";
print_r($routing);
echo "</pre>";*/

//require_once($routing->controller_file_path);

//$smarty->display('index.tpl');
?>