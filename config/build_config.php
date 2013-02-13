<?php 
require_once("./main.php");
//file_put_contents('compiled_config.php', '<?php /* this file was generated automatically. */return ' . var_export($mainConfig, true) . ';');
$var = json_decode(json_encode($mainConfig, JSON_PRETTY_PRINT),true); 
file_put_contents('compiled_config.php', '<?php /* this file was generated automatically. */return ' . var_export($var, true) . ';');
;
file_put_contents('compiled_jsonconfig.php', '' . json_encode($mainConfig, JSON_PRETTY_PRINT) . '');