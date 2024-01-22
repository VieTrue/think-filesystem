<?php

namespace vietrue\filesystem;

class Service extends \think\Service
{
    public function register()
    {
        $this->app->bind(\think\Filesystem::class, Filesystem::class);
    }
}