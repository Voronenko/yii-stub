<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout='//layouts/_default';


    public $pageWrapperCss = '';


    public $lang = null;

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu=array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs=array();
    /**
     * @property $menuItem string alias of selected menu item. This property will be assigned to {@link CMenu::items}.
     */
    public $menuItem='';

    protected function performAjaxValidation($model,$id)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']===$id)
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public $topMenuAction;


    public function userIsGuest()
    {
        return Yii::app()->user->isGuest;
    }

    public function filters()
    {
        return array(
            'accessControl',
        );
    }
    public function getContentUrl()
    {
        return Yii::app()->params["ContentUrl"];
    }

    public function getFS()
    {
        return Yii::app()->fileSystem;
    }

    /**
     * @param string $lang
     * @return bool|string
     */
    private function isLangSupported($lang)
    {
        $lang = strtolower($lang);
        if(in_array($lang, Yii::app()->params['languages']))
            return $lang;
        return false;
    }
/*    public function init()
    {
        parent::init();
        $app = Yii::app();
        $setSession = true;
        //  set def lang
        $lang = 'en';
        if (!(
            isset($_POST['_lang']) &&
                ($lang = $this->isLangSupported($_POST['_lang']))
        )) {
            if ($lang = $app->user->getState('_lang')) {
                $setSession = false;
            } else {
                $lang = substr(
                    Yii::app()->getRequest()->getPreferredLanguage(),
                    0,
                    2
                );
                if(!($lang = $this->isLangSupported($lang)))
                    $lang = 'en';
            }
        }
        $app->language = $lang;
        $this->lang = $lang;
        if($setSession)
            $app->user->setState('_lang', $lang);
    }*/



    public function disableWebLogRoutes()
    {
        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false;
            }
        }
    }

}