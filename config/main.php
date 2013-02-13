<?php
/**
 * YII Application Config File
 *
 * If module does not support auto patching, all modules and components have to be declared 
 *  before installing a new package via composer.
 * See also config.php, for composer installation and update "hooks"
 */

$coreconfigpath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config_core.php';
$localconfigpath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config_local.php';
$generatedconfigpath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config_generated.php';

require_once($coreconfigpath);
if (file_exists($localconfigpath)){
include_once($localconfigpath);
}

if (file_exists($generatedconfigpath)){
include_once($generatedconfigpath);
}

if (isset($config_local)) {
  $mainConfig = CMap::mergeArray($mainConfig, $config_local);
}

if (isset($config_generated)) {
  $config_generated = CMap::mergeArray($mainConfig, config_generated);
}

return $mainConfig;