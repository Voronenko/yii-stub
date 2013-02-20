<?php

/**
 * Note: YII stub application is based upon yii-rights module or it's fork.
 * Make sure module is installed
 */
class SiteController extends RController
{

    public $layout = '//layouts/main';
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }


    public function actionIndex()
    {
        /** @var $module AuthModule */
        $this->render('index');
    }


    public function actionSomeOtherAction()
    {
        /** @var $module AuthModule */
        $this->render('index');
    }



}



