<?php

namespace vietrue\filesystem\driver;

use League\Flysystem\AdapterInterface;
use League\Flysystem\Adapter\Local as LocalAdapter;

use League\Flysystem\FilesystemAdapter;
use OSS\OssClient;
use OSS\Core\OssException;
use vietrue\filesystem\adapter\OssAdapter;
use vietrue\filesystem\Driver;

class Aliyun extends Driver
{
    protected $config = [
        'accessId'     => '',
        'accessSecret' => '',
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
        return new OssAdapter($this->config['accessId'], $this->config['accessSecret'], $this->config['endpoint'], $this->config['bucket']);
    }

}