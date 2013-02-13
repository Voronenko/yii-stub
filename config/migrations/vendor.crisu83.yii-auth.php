<?php 
class m130213_182320_inityiinano extends EDbMigration 
{ 
    public function up() 
    {
        /** @var $configModule YIIConfigModule */
        $configModule = Yii::app()->getModule('config');
        if ($configModule == null) {
            throw new exception ("This migration requires YIIConfig module from https://github.com/Voronenko/yii-config");
        }

        echo 'congifuring yii-auth';
        //
        $yiiauthconfig = array (
            'aliases' =>
            array (
                'auth' => 'vendor.crisu83.yii-auth',
            ),
            'modules' =>
            array (
                'auth' => array(
                    'class'=>'auth.AuthModule'
                ),
            ),
            'components' =>
            array (
                'authManager' =>
                array (
                    'behaviors' =>
                    array (
                        'auth' =>
                        array (
                            'class' => 'auth.components.AuthBehavior',
                            'admins' =>
                            array (
                                'admin',
                                'foo',
                                'bar',
                            ),
                        ),
                    ),
                ),
                'user' =>
                array (
                    'class' => 'auth.components.AuthWebUser',
                ),
            ),
        );


        $configModule->registerConfigUpdate($yiiauthconfig,'congifuring yii-auth');

        $configModule->writeConfig();
        echo 'done';


    } 
     

    public function down() 
    { 
        echo "m130213_182320_inityiinano does not support migration down.\n"; 
        return false; 
         
        $this->execute(""); 
    } 

    /* 
    // Use safeUp/safeDown to do migration with transaction 
    public function safeUp() 
    { 
    } 

    public function safeDown() 
    { 
    } 
    */ 
} 