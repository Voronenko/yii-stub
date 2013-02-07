<?php
/**
 * YII Application Config File
 *
 * If module does not support auto patching, all modules and components have to be declared 
 *  before installing a new package via composer.
 * See also config.php, for composer installation and update "hooks"
 */

$applicationDirectory = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
$baseUrl = (dirname($_SERVER['SCRIPT_NAME']) != '/') ? dirname($_SERVER['SCRIPT_NAME']) : '';

$mainConfig = array(
    'basePath' => $applicationDirectory."/protected",
    'name' => 'YII nano application',
    'theme' => 'classic',  //uncomment to get theme support
    'language' => 'en', // default language, see also components.langHandler
    // preloading 'log' component
    'preload' => array(
        'log',
    ),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.controllers.*',
        'zii.widgets.*',
    ),
    'aliases' => array(
        // composer
        'vendor' => 'application.vendor',
        'bootstrap' => 'application.vendor.crisu83.yii-bootstrap',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'q',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
            ),
        ),
    ),
    // application components
    'components' => array(

        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),

        'themeManager' => array(
            'class' => 'CThemeManager',
            'basePath' => $applicationDirectory . '/themes',
            'baseUrl' => $baseUrl.'/themes',
        ),

  'urlManager' => array( 
    'urlFormat' => 'path',
    'showScriptName' => false,
    'rules' => array(              
                     '/' => '/view',
                     '//' => '/',
                     '/' => '/',

            ),

        )
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
        // global Phundament 3 parameters
    ),
);



$localConfigFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'local.php';
if (is_file($localConfigFile)) {
    return CMap::mergeArray($mainConfig, require($localConfigFile));
} else {
    return $mainConfig;
}