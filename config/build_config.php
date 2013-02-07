<?php 
require_once("./main.php");
file_put_contents('compiled_config.php', '<?php /* this file was generated automatically. */return ' . var_export($mainConfig, true) . ';');