<?php
class S3_FileSystem extends CApplicationComponent
    implements IFS
{
    protected $_awsConnection = null;

    public $awsAccessKey;
    public $awsSecretKey;

    public $awsBucket;
    public $awsBucketDomain;
    public $awsPathRoot;

    public $newFilePermission; // ACL_PUBLIC_READ

    protected function _createConnection()
    {
        if ($this->_awsConnection == null) {
            $this->_awsConnection = new S3(
                $this->awsAccessKey, $this->awsSecretKey
            );
            S3::$useExceptions = true;
        }
        return $this->_awsConnection;
    }

    public function __construct()
    {
        Yii::import("ext.AWS.S3");

        //$this->_connection->disableBucketLogging
        //($this->awsDefaultBucket);
        $this->newFilePermission = S3::ACL_PUBLIC_READ;
    }

    /**
     * @param string $sourceFile local file path
     * @param string $file filename in storage
     * @param string|bool $contentType
     * @return bool
     */
    public function store($sourceFile, $file, $contentType)
    {
        $this->_createConnection();
        if ($contentType === false) {
            $contentType = 'binary/octet-stream';
            $permission = S3::ACL_PRIVATE;
        } else {
            $permission = $this->newFilePermission;
        }
        $res = S3::putObjectFile(
            $sourceFile,
            $this->awsBucket,
            $this->awsPathRoot . $file,
            $permission,
            array(),
            $contentType
        );

        return $res;
    }

    public function readString($file)
    {
        $this->_createConnection();
        try {
            $res = S3::getObject(
                $this->awsBucket,
                $this->awsPathRoot . $file
            );
        } catch (S3Exception $e) {
            if (strpos($e->getMessage(), '[NoSuchKey]') > 0)
                return false;
            else
                throw $e;
        }
        if ($res)
            return $res->body;
        else
            return false;
    }

    public function writeString($file, $content, $contentType)
    {
        $this->_createConnection();
        if ($contentType === false) {
            $contentType = 'binary/octet-stream';
            $permission = S3::ACL_PRIVATE;
        } else {
            $permission = $this->newFilePermission;
        }
        $res = S3::putObjectString(
            $content,
            $this->awsBucket,
            $this->awsPathRoot . $file,
            $permission,
            array(),
            $contentType
        );
        return $res;
    }

    /**
     * @param $file
     * @return bool
     */
    public function unlink($file)
    {
        return S3::deleteObject(
            $this->awsBucket,
            $this->awsPathRoot . $file
        );
    }

    public function fileSize($file)
    {
        $this->_createConnection();
        $info = S3::getObjectInfo(
            $this->awsBucket,
            $this->awsPathRoot . $file
        );

        return $info['size'];
    }

    public function fileExists($file)
    {
        $this->_createConnection();
        return (bool)s3::getObjectInfo(
            $this->awsBucket,
            $file
        );
    }

    public function glob($pattern)
    {
        $pattern = $this->awsPathRoot . $pattern;
        $rootLength = strlen($this->awsPathRoot);
        $filter = null;
        $cut = strpos($pattern, "*");
        if ($cut === false) {
            //$cut = false;
            $prefix = $pattern;
        } else {
            $prefix = substr($pattern, 0, $cut);
            $cut = true;
        }
        $this->_createConnection();
        $files = S3::getBucket(
            $this->awsBucket,
            $prefix
        );
        $result = array();
        foreach ($files as $file) {
            if (!$cut || fnmatch($pattern, $file['name'])) {
                $result[] = array(
                    'filename' => basename($file['name']),
                    'path' => substr($file['name'], $rootLength),
                    'size' => $file['size']
                );
            }
        }
        return $result;

    }

    public function makeDir($dir)
    {
        return true;
    }

    /**
     * @param $source string
     * @param $destination string
     * @return bool
     */
    public function copy($source, $destination)
    {
        $this->_createConnection();
        return S3::copyObject(
            $this->awsBucket,
            $this->awsPathRoot . $source,
            $this->awsBucket,
            $this->awsPathRoot . $destination,
            $this->newFilePermission
        ) !== false;
    }

    /**
     * @param $source string
     * @param $destination string
     * @return bool
     */
    public function move($source, $destination)
    {
        if ($this->copy($source, $destination)) {
           return $this->unlink($source);
        }
        return false;
    }

    public function delTree($dir)
    {
        $prefix = $this->awsPathRoot . $dir . '/';
        $this->_createConnection();
        $files = S3::getBucket(
            $this->awsBucket,
            $prefix
        );
        foreach ($files as $file) {
            S3::deleteObject(
                $this->awsBucket,
                $file['name']
            );
        }
    }

    public function getPath($url)
    {
        $cut = strlen($this->awsBucketDomain);
        if (substr($url, 0, $cut) === $this->awsBucketDomain)
            return substr($url, $cut);
        else
            throw new InvalidArgumentException();
    }

    public function getUrl($path)
    {
        return $this->awsBucketDomain . $path;
    }
}
