<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class MakeService extends GeneratorCommand
{
    /**
     * 控制台命令名称
     *
     * @var string
     */

    protected $name = 'make:service';

    /**
     * 控制台命令描述
     *
     * @var string
     */

    protected $description = 'Create a new service  class';

    /**
     * 生成类的类型
     *
     * @var string
     */

    protected $type = 'Services';

    /**
     * 获取生成器的存根文件
     *
     * @return string
     */

    protected function getStub(): string
    {
        return __DIR__ . '/Stubs/services.stub';
    }

    /**
     * 获取类的默认命名空间
     *
     * @param  string  $rootNamespace
     * @return string
     */

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Services';
    }
}
