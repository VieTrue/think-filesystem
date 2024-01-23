<?php

namespace Vietrue\Filesystem\Driver;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemAdapter;
use Vietrue\Flysystem\QiniuAdapter;
use Vietrue\Filesystem\Driver;

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