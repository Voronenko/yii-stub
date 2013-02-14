<?php

class SiteController extends Controller
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



}



