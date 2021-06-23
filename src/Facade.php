<?php

namespace Larva\Baidu;

use EasyBaidu\MiniProgram\Application;
use Illuminate\Support\Facades\Facade as LaravelFacade;

/**
 * Class Facade
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Facade extends LaravelFacade
{
    /**
     * 默认为 Server.
     *
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'baidu.mini_program';
    }

    /**
     * 获取小程序
     * @param string $name
     * @return Application
     */
    public static function miniProgram(string $name = ''): Application
    {
        return $name ? app('baidu.mini_program.'.$name) : app('baidu.mini_program');
    }
}
