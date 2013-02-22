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
    'theme' => 'manage',  //uncomment to get theme support
    'language' => 'en', // default language, see also components.langHandler
    // preloading 'log' component
    'preload' => array(
        'log',
    ),
    'aliases' => array(
        // composer
        'vendor' => 'webroot.vendor',
        'bootstrap' => 'vendor.crisu83.yii-bootstrap',

        'cmf.helper' => 'vendor.voronenko.yii_helper',
        'cmf.editor' => 'vendor.voronenko.yii_helper.widgets.editortemplates'
    ),

    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.cmf.*',
        'application.cmf.interfaces.*',
        'application.controllers.*',
        'zii.widgets.*',
        'vendor.mishamx.yii-user.models.*', // User Model
        'vendor.crisu83.yii-rights.components.*', // RWebUser
    ),
    'modules' => array(

        'config' => array(
          'class' => 'vendor.voronenko.yii-config.YiiConfigModule'
        ),

        'page' => array(
            'class' => 'vendor.voronenko.yii-page.PageModule',
             
            'htmlmemooptions' => array(
                   'theme' => 'advanced',
                   'theme_advanced_buttons1' => 'styleselect,formatselect,bold,italic,underline,separator,justifyleft,justifycenter,justifyright,separator,numlist, bullist,outdent,indent,separator,separator,link,unlink,code',
                   'theme_advanced_buttons2' => 'sub,sup,separator,undo,redo,separator,cleanup,removeformat,charmap,separator,mceinsertstatic,separator,pastetext,pasteword,selectall,separator,fullscreen',
                   'theme_advanced_buttons3' => 'media,image, template',
                   'theme_advanced_toolbar_location' => 'top',
                   'theme_advanced_toolbar_align' => 'left',
                   'theme_advanced_statusbar_location' => 'bottom',
                   'paste_use_dialog' => 'true',
                   'theme_advanced_resizing' => 'true',
                   'theme_advanced_resize_horizontal' => 'true',

                   'theme_advanced_link_targets' => '',
                   'verify_css_classes' => 'false',
                   'invalid_elements' => 'font',
                   'paste_auto_cleanup_on_paste' => 'true',
                   'extended_valid_elements' => 'a[href|target|name|rel],map[name],area[shape|coords|href],object[classid|codebase|width|height|align],param[name|value],embed[quality|type|pluginspage|width|height|src|align],img[id|dir|lang|longdesc|usemap|style|class|src|onmouseover|onmouseout|border=0|alt|title|hspace|vspace|width|height|align|play|swliveconnect|loop|quality|scale|align|salign|wmode|bgcolor|base|flashvars]',
                   'plugins' => 'media,template,fullscreen,paste,advimage,advlink,searchreplace,paste,noneditable,contextmenu'
                    
 

                                 ) 
        ),


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

        'IOC'=>array(
            'class' => 'CMFIOC',
            'Components' => array(
                'IPageService'=>'PageServiceAR',
                //'IPageService'=>'PageServiceDUMMY',
            )
        ),


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

        'clientScript' => array(
            'packages' => array(
                'site' => array(
                    'depends' => array(
                        'jquery',
                        'jquery.tools',
                        'knockout',
                        'modernizr'
                    ),
                    'css' => array(
                        'css/style_min.css'
                    ),
                    'js' => array(
                    )
                ),
                'knockout' => array(
                    'baseUrl' => 'http://ajax.aspnetcdn.com/ajax/knockout/',
                    'js' => array('knockout-2.2.1.js')
                ),
                'modernizr' => array(
                    'js' => array(
                        'js/modernizr/modernizr.custom.87898.js'
                    )
                ),
                'jquery.tools' => array(
                    //'baseUrl' => 'http://cdn.jquerytools.org/1.2.7/full/',
                    //'baseUrl' => 'http://jquerytools.flowplayer.netdna-cdn.com/1.2.6/all/',
                    //'baseUrl' => 'http://jquerytools.flowplayer.netdna-cdn.com/1.2.6/all/',
                    //'js' => array('jquery.tools.min.js')
                    'js' => array('js/jquery.tools.min.js')
                ),
                'jquery' => array(
                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/jquery/',
                    'js' => array(
                        '1.8.2/jquery.min.js'
                    )
                ),

                'jquery.ui' => array(
                    'baseUrl' => 'http://code.jquery.com/ui/',
                    'js' => array(
                        '1.10.1/jquery-ui.js'
                     ),
                    'css' => array(
                        '1.10.1/themes/base/jquery-ui.css'
                    )
                ),



            ),
            'scriptMap' => array(
                'eliminatethisfile.js' => false,
                'replacewithexternalcdn.js' => 'http://your.cdn.address/replacewithexternalcdn.js'
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
        'projectname' => 'YII Stub',

    ),
);



