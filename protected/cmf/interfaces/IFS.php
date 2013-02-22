<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor.feoktistov
 * Date: 8/8/12
 * Time: 10:06 AM
 * To change this template use File | Settings | File Templates.
 */

/**
 * Interface for work with FS
 */

interface IFS {
    /**
     * Only for S3
     * @param string $sourceFile local file path
     * @param string $file filename in storage
     * @param string $contentType
     * @return bool
     */
    public function store($sourceFile, $file, $contentType);

    /**
     * @param $file
     * @return bool
     */
    public function unlink($file);

    /**
     * Move function
     * @param $file
     *
     */
    public function fileSize($file);

    /**
     * @param $file
     * @return bool
     */
    public function fileExists($file);

    public function glob($pattern);

    public function makeDir($dir);

    /**
     * @param $source string
     * @param $destination string
     * @return bool
     */
    public function copy($source, $destination);
    /**
     * @param $source string
     * @param $destination string
     * @return bool
     */
    public function move($source, $destination);

    public function delTree($dir);
    /*
     * function for
     * @param string $path URL in FS (e.g. http://domain.ua/upload/images/articles/2514.jpg or /upload/images/articles/2514.jpg)
     * @use $this->opt['awsMappingLocalPath'] Mapping local path (e.g. /upload/images/)
     * @use $this->opt['awsMappingS3Path'] Mapping S3 path (e.g. domain_upload/)
     * @use $this->opt['baseUrl'] base URL (e.g. http://domain.ua/)
     * @return string Path in S3 Bucket (e.g. domain_upload/articles/2514.jpg)
     */
    public function getPath($url);

    /*
     * function for
     * @param string $path URL in FS (e.g. http://domain.ua/upload/images/articles/2514.jpg or /upload/images/articles/2514.jpg)
     * @use function $this->getInternalPath Return the internal path for this URL with apply mapping
     * @return string Public HTTP/HTTPS path in S3 (e.g. http://domain_bucket.s3.amazonaws.com/domain_upload/articles/2514.jpg)
     */
    public function getUrl($path);


    /**
     * @param string $file
     * @return string
     */
    public function readString($file);

    /**
     * @param string $file
     * @param string $content
     * @param string|bool $contentType
     * @return bool
     */
    public function writeString($file, $content, $contentType);
}