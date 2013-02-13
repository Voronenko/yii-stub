<?php

/**
 * Console Config File
 *
 *
 * Define composer hooks by the following name schema: <vendor>/<packageName>-<action>
 *
 */


function getModuleMigrationPaths(){
$result = array();
$modulesdir =  realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor') . DIRECTORY_SEPARATOR;

$a = new RegexIterator(
    new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($modulesdir), RecursiveIteratorIterator::SELF_FIRST
    ),
    '/migrations/',
    RegexIterator::MATCH
);

foreach ($a as $v) {
    if (!(is_dir($v))) continue;
    $module = substr($v,strlen($modulesdir),100);
    $module = 'vendor.'.str_replace(DIRECTORY_SEPARATOR,'.',$module);
    $parts = explode ('.', $module);
    $reverseparts = array_reverse($parts);
    $modulename = $reverseparts[1];
    $modulename = str_replace('yii-','',$modulename);
    $result[$modulename]=$module; 
}
return $result;
}





$mainConfig = require('main.php');
return array(
    'aliases' => array(
        'vendor' => 'application.vendor',
    ),
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console Application',
    'components' => $mainConfig['components'],
    'modules' => $mainConfig['modules'],
    'commandMap' => array(
        'database' => array(
            'class' => 'vendor.schmunk42.database-command.EDatabaseCommand',
        ),
        'migrate' => array(
// alias of the path where you extracted the zip file
            'class' => 'vendor.yiiext.migrate-command.EMigrateCommand',
            // this is the path where you want your core application migrations to be created
            'migrationPath' => 'application.migrations',
            // the name of the table created in your database to save versioning information
            'migrationTable' => 'migration',
            // the application migrations are in a pseudo-module called "core" by default
            'applicationModuleName' => 'core',
            // define all available modules (if you do not set this, modules will be set from yii app config)
            'modulePaths' => getModuleMigrationPaths(),
            // you can customize the modules migrations subdirectory which is used when you are using yii module config
            'migrationSubPath' => 'migrations',
            // here you can configure which modules should be active, you can disable a module by adding its name to this array
            'disabledModules' => array(
            ),
            // the name of the application component that should be used to connect to the database
            'connectionID' => 'db',
        // alias of the template file used to create new migrations
#'templateFile' => 'system.cli.migration_template',
        ),
        // composer "hooks", will be executed after package install or update
        'config' => array(
            'class' => 'vendor.voronenko.yii-config.commands.YiiConfigCommand',
        ),
    ),
    'params' => array(
        'composer.callbacks' => array(
            // args for Yii command runner
            'post-update' => array('yiic', 'migrate'),
            'post-install' => array('yiic', 'migrate'),
        ),
    )
);
