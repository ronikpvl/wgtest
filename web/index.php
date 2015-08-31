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



56666666666666666654564

*/

/*
echo "<pre>";
print_r($_SERVER);
echo "</pre>";


echo "<pre>";
print_r($_GET);
echo "</pre>";





 // Получение всех GET данных
    function getData(){
        // Собираем все GET данные что пришли к нам через ЧПУ
        if ($this->url_parse[2]){
            foreach($this->url_parse as $key=>$val){
                if ($key > 1){
                    $this->get_data[] = $val;
                }
            }
        }

        // Собираем все данные через пришедшие через GET
        if (count($_GET) > 1){
            foreach($_GET as $key=>$val){
                if ($key != 'url'){
                    $this->get_data[] = $val;
                }
            }
        }
    }
*/
$smarty->display('index.tpl');
?>