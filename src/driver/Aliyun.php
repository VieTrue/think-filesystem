<?php

namespace Vietrue\Filesystem\driver;

use League\Flysystem\FilesystemAdapter;
use Vietrue\Flysystem\OssAdapter;
use Vietrue\Filesystem\Driver;

class Aliyun extends Driver
{
    protected $config = [
        'accessId'     => '',
        'accessSecret' => '',
        'prefix'       => '',
        'is_cname'     => false,
        'endpoint'     => '',
        'bucket'       => '',
        'domain'       => '',
        'throw'        => true,
    ];

    /**
     *
     * @return FilesystemAdapter
     */
    protected function createAdapter(): FilesystemAdapter
    {
        return new OssAdapter($this->config['accessId'], $this->config['accessSecret'], $this->config['endpoint'], $this->config['bucket'], $this->config['is_cname'], $this->config['prefix']);
    }

}