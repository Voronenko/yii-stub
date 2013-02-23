<?php
/**
 * User: slavko
 * Date: 23.02.13
 * Time: 20:27
 */
interface IActiveForm
{
    function errorSummary($models,$header=null,$footer=null,$htmlOptions=array());
    public function error($model,$attribute,$htmlOptions=array(),$enableAjaxValidation=true,$enableClientValidation=true);



    public function labelEx($model,$attribute,$htmlOptions=array());
    public function textField($model,$attribute,$htmlOptions=array())    ;
    public function textArea($model,$attribute,$htmlOptions=array());
}
