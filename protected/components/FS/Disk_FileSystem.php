<?php
class Disk_FileSystem extends CApplicationComponent implements IFS
{
    public $basePath;

    private $_fsRoot = null;
    private $_fsRootUrl = null;
    public $newFileMode=0666;
    public $newDirMode=0777;

    protected function getRoot()
    {
        if ($this->_fsRoot === null) {
            $this->_fsRoot = Yii::getPathOfAlias('webroot') . $this->basePath;
        }

        return $this->_fsRoot;
    }

    protected function getRootUrl()
    {
        if ($this->_fsRootUrl === null) {
            $this->_fsRootUrl =
                Yii::app()->getBaseUrl(true) . $this->basePath;
        }

        return $this->_fsRootUrl;

    }

    public function store($source, $file, $contentType)
    {
        $newFile = $this->getRoot() . $file;
        $res = copy($source, $newFile);
        @chmod($newFile, $this->newFileMode);
        return $res;
    }


    public function unlink($file)
    {
        return unlink($this->getRoot() . $file);
    }


    public function fileSize($file)
    {
        return filesize($this->getRoot() . $file);
    }


    public function fileExists($file)
    {
        return file_exists($this->getRoot() . $file);
    }


    /**
     * Default glob function in S3 environment
     */
    public function glob($pattern)
    {
        //, GLOB_NOSORT, array('add_size' => true)
        $root = $this->getRoot();
        $rootLength = strlen($root);
        $files = glob($root . $pattern, GLOB_NOSORT);
        $resultFiles = array();

        foreach ($files as $filename) {
            if (is_file($filename)) {
                $file['filename'] = basename($filename);
                $file['path'] = substr($filename, $rootLength);
                $file['size'] = filesize($filename);
                $resultFiles[] = $file;
            }
        }

        return $resultFiles;
    }

    private function _makeDir($path)
    {
        if (is_dir($path)) {
            return true;
        }
        $parent = dirname($path);
        if($parent  == $path)
            throw new InvalidArgumentException();
        if(!$this->_makeDir($parent))
            return false;
        $res = mkdir($path);
        @chmod($path, $this->newDirMode);
        return $res;
    }

    public function makeDir($dir)
    {
        $path = $this->getRoot() . $dir;
        $res = $this->_makeDir($path);
        return $res;
    }


    public function getUrl($path)
    {
        return $this->getRootUrl() . $path;
    }

    public function getPath($path)
    {
        $root = $this->getRootUrl();
        if (substr($path, 0, strlen($root)) === $root) {
            return substr($path, strlen($root));
        } else {
            throw new InvalidArgumentException();
        }
    }

    private function _delTree($dir)
    {
        if (is_dir($dir)) {
            $files = glob($dir . '*', GLOB_MARK | GLOB_NOSORT);
            foreach ($files as $file) {
                self::_delTree($file);
            }
            rmdir($dir);
        } elseif (is_file($dir)) {
            unlink($dir);
        }
    }

    public function delTree($path)
    {
        $this->_delTree($this->getRoot() . $path . '/');
    }

    public function copy($source, $destination)
    {
        $newFile = $this->getRoot() . $destination;
        $res = copy(
            $this->getRoot() . $source,
            $newFile
        );
        @chmod($newFile, $this->newFileMode);
        return $res;
    }

    public function move($source, $destination)
    {
        return rename(
            $this->getRoot() . $source,
            $this->getRoot() . $destination
        );
    }

    /**
     * @param string $file
     * @return string
     */
    public function readString($file)
    {
        return file_get_contents($this->getRoot() . $file);
    }
    public function writeString($file, $content, $contentType)
    {
        return file_put_contents($this->getRoot() . $file, $content);
    }
}
