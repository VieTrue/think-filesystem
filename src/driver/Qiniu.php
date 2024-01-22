<?php

namespace vietrue\filesystem\driver;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemAdapter;
use Overtrue\Flysystem\Qiniu\QiniuAdapter;
use Overtrue\Flysystem\Qiniu\Plugins\FetchFile;
use vietrue\filesystem\Driver;

class Qiniu extends Driver
{
    protected $config = [
        'accessKey' => '',
        'secretKey' => '',
        'bucket'    => '',
        'domain'    => '',
        'throw'     => true,
    ];
    /**
     *
     * @return FilesystemAdapter
     */
    protected function createAdapter(): FilesystemAdapter
    {
        return new QiniuAdapter($this->config['accessKey'], $this->config['secretKey'], $this->config['bucket'], $this->config['domain']);
    }

}