<?php
class FSAssetManager extends CAssetManager
{
    public $published = array();
    protected $_baseUrl = null;
    protected $_basePath = null;
    public function getBaseUrl()
    {
        if ($this->_baseUrl === null) {
            $this->_baseUrl = rtrim(Yii::app()->fileSystem->getUrl(''), '/');
        }
        return $this->_baseUrl;
    }
    public function setBaseUrl($url)
    {
        $this->_baseUrl = rtrim($url, '/');
    }

    public function publish($path, $hashByName=false, $level=-1, $forceCopy=null)
    {
        $start = strlen($this->_basePath);
        if (substr($path, 0, $start) == $this->_basePath) {
            $path = substr($path, $start);
        }
        if (array_key_exists($path, $this->published)) {
            return $this->getBaseUrl() . '/' . $this->published[$path];
        } else {
            $result = parent::publish($path, $hashByName, $level, $forceCopy);
            return $result;

            throw new Exception('path has not published:' . var_export($path, true));
        }
    }
    public function getPublishedUrl($path, $hashByName=false)
    {
        return $this->publish($path, $hashByName);
    }
    public function init()
    {
        parent::init();
        $this->_basePath = dirname(Yii::app()->getBasePath());
    }
}
