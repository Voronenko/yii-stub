<?php
class FSCacheSlot
{
    /** @var array|string */
    public $data;
    public $key;
    protected $_fs;
    public function __construct($name)
    {
        $this->key = 'protected/fsCache/' . $name;
        $this->_fs = Yii::app()->fileSystem;
    }
    public function load()
    {
        try {
            $raw = $this->_fs->readString($this->key);
        } catch (S3Exception $e) {
            Yii::log(
                'Error load cache: ' . $e->getMessage(),
                CLogger::LEVEL_ERROR
            );
            $raw = false;
        }

        if ($raw === false) {
            $this->data = false;
            return false;
        }
        $this->data = json_decode($raw, true);
        return true;
    }

    public function save()
    {
        $res = $this->_fs
            ->writeString($this->key, json_encode($this->data), false);

        return $res;
    }

    public function clean()
    {
        $this->_fs->unlink($this->key);
    }
}
