<?php
/**
 * Idea based on code of  maryan.provashynskyy
 */
class CMFFormWidget extends CWidget
    implements IActiveForm
{
    /** @var CActiveForm */
    public $form;
    public $options;
    public $controlOptions = array('class' => 'span4');
    public $controlStart = '';
    public $controlEnd = '';
    public $action = '';
    public $labelPosition = 'normal'; // normal|placeholder
    public function init()
    {

        $options = array(
            'enctype' => 'multipart/form-data',
            'class'   => 'form-horizontal'
        );
        if (is_array($this->options)) {
            $options = array_merge($options, $this->options);
        }
        $this->form = $this->createWidget(
            'CActiveForm',
            array(
                'action' => $this->action,
                'htmlOptions' => $options
            )
        );
    }


    /**
     * @param CModel $model
     */
    public function showSummary($model)
    {
        if ($model->hasErrors()) {
            echo '<div class="alert alert-error">';
            echo CHtml::errorSummary($model);
            echo '</div>';
        }
    }

    /**
     * @param CModel|FileUploadBehavior $model
     * @param string                    $property
     * @param string                    $type
     * @param array                     $htmlOptions
     */
    public function field($model, $property, $type, $htmlOptions = array())
    {
        if ($type == 'hidden') {
            echo $this->form->hiddenField($model, $property, $htmlOptions);

            return;
        }
        $options = $htmlOptions + $this->controlOptions;
        ?>
    <div class="<?php
        if (isset($options['mainClass'])) {
            echo $options['mainClass'];
            unset($options['mainClass']);
        } else {
            echo 'control-group';
        }
        if ($model->hasErrors($property)) {
            $error = $model->getError($property);
            echo $error;
        }
        ?>">
        <?php

        switch ($this->labelPosition) {
            case 'normal':
                echo $this->form->labelEx($model, $property);
                break;
            case 'placeholder':
                $options['placeholder'] = $model->getAttributeLabel($property);
                break;
        }

        if ($model->isAttributeRequired($property)) {
            $options['required'] = 'required';
        }

        echo $this->controlStart;
        switch ($type) {
            case 'text':
            case 'email':
            case 'number':
            case 'password':
                echo $this->form->{$type . 'Field'}(
                    $model,
                    $property,
                    $options
                );
                break;
            case 'memo':
                echo $this->form->textArea(
                    $model,
                    $property,
                    $options
                );
                break;
            case 'file':
                $model->renderUploadField($property, null, false, $options);
                break;
            case 'files':
                $model->renderMultiUploadControl($property, false, $options);
                break;
            case 'readonly':
                echo CHtml::encode($model->{$property});
                break;
            case 'radio':
                $items = $options['items'];
                unset($options['items']);
                $html = '';
                foreach ($items as $key => $value) {
                    $html .= CHtml::tag(
                        'label',
                        array('class' => 'radio'),
                        $this->form->radioButton(
                            $model,
                            $property,
                            array('value' => $key, 'uncheckValue' => null)
                        ) . $value
                    );
                }
                if (array_key_exists('class', $options)) {
                    $options['class'] .= ' controls';
                } else {
                    $options['class'] = 'controls';
                }
                echo CHtml::tag('div', $options, $html);
                break;
            case 'checkbox':
                echo $this->form->checkBox($model, $property, $options);
                break;
            default:
                if (is_callable($type, true)) {
                    call_user_func($type, $model, $property, $options);
                }
        }
        echo $this->controlEnd;
        ?>
    </div>
    <?php
    }

    public function fieldWidgetFor(
        $model,
        $property,
        $widgetName,
        $optOptions = array()
    ) {
        $options = array(
            'model'       => $model,
            'attribute'    => $property,
        );

        $options = $mainConfig = CMap::mergeArray($options, $optOptions);

        $this->Widget(
            $widgetName,
            $options
        );
    }

    public function submit($title, $htmlOption = array())
    {
        echo CHtml::htmlButton(
            $title,
            $htmlOption + array('class' => 'btn', 'type' => 'submit')
        );
    }


    public function run()
    {
        $this->form->run();
        Yii::app()->clientScript->registerScript(
            'CMFForm.init',
            <<<JS
            // todo: custom code here
JS
            ,
            CClientScript::POS_READY
        );
    }


    /*  IActiveForm */
public    function errorSummary($models,$header=null,$footer=null,$htmlOptions=array()){
  return $this->form->errorSummary($models,$header,$footer, $htmlOptions);
}


    public function labelEx($model,$attribute,$htmlOptions=array())
    {
        return CHtml::activeLabelEx($model,$attribute,$htmlOptions);
    }


    public function textField($model,$attribute,$htmlOptions=array())
    {
        return CHtml::activeTextField($model,$attribute,$htmlOptions);
    }




    public function textArea($model,$attribute,$htmlOptions=array())
    {
        return CHtml::activeTextArea($model,$attribute,$htmlOptions);
    }



 public function error($model,$attribute,$htmlOptions=array(),$enableAjaxValidation=true,$enableClientValidation=true){
     return $this->form->error($model,$attribute,$htmlOptions, $enableAjaxValidation, $enableClientValidation);
 }




    /*  /IActiveForm */

}

