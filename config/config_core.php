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

$mainConfig = 
  array(
    'basePath' => $applicationDirectory."/protected",
    'name' => 'YII nano application',
    'theme' => 'classic',  //uncomment to get theme support
    'language' => 'en', // default language, see also components.langHandler
    // preloading 'log' component
    'preload' => array(
        'log',
    ),
    'aliases' => array(
        // composer
        'vendor' => 'webroot.vendor',
        'bootstrap' => 'vendor.crisu83.yii-bootstrap',
    ),

    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.controllers.*',
        'zii.widgets.*',
        'vendor.mishamx.yii-user.models.*', // User Model
        'vendor.crisu83.yii-rights.components.*', // RWebUser
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'config' => array(
          'class' => 'vendor.voronenko.yii-config.YiiConfigModule'
        ) , 

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'q',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'vendor.voronenko.yii_gii_migrate', // giix generators
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

        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=composer',
            'tablePrefix' => 'tbl_',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ),


'log'=>array(
  'class'=>'CLogRouter',
  'routes'=>array(
    array(
    'class'=>'CWebLogRoute',
        //
        // I include *trace* for the 
        // sake of the example, you can include
        // more levels separated by commas
    'levels'=>'trace',
        //
        // I include *vardump* but you
        // can include more separated by commas
    'categories'=>'vardump',
        //
        // This is self-explanatory right?
    'showInFireBug'=>false
)
)
),

  'urlManager' => array( 
    'urlFormat' => 'path',
    'showScriptName'=>true,
    'rules' => array(              
                     '/' => '/view',
                     '//' => '/',
                     '/' => '/',
                '<lang:[a-z]{2}>/pages/<view:\w+>' => 'site/page',
                // Yii
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                // general language and route handling
                '<lang:[a-z]{2}>' => '',
                '<lang:[a-z]{2}>/<_c>' => '<_c>',
                '<lang:[a-z]{2}>/<_c>/<_a>' => '<_c>/<_a>',
                '<lang:[a-z]{2}>/<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>',


            ),

        )
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',

    ),
);



