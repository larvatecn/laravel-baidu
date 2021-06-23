<?php

namespace Larva\LaravelBaidu;

use EasyBaidu\MiniProgram\Application as MiniProgram;
use EasyBaidu\OfficialAccount\Application as OfficialAccount;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

/**
 * Class ServiceProvider.
 *
 * @author overtrue <i@overtrue.me>
 */
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Boot the provider.
     */
    public function boot()
    {
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/baidu.php');
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('baidu.php')], 'laravel-baidu');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('baidu');
        }
        $this->mergeConfigFrom($source, 'baidu');
    }

    /**
     * Register the provider.
     */
    public function register()
    {
        $this->setupConfig();
        $apps = [
            'official_account' => OfficialAccount::class,
            'mini_program' => MiniProgram::class,
        ];

        foreach ($apps as $name => $class) {
            if (empty(config('baidu.'.$name))) {
                continue;
            }

            if (!empty(config('baidu.'.$name.'.app_id'))) {
                $accounts = [
                    'default' => config('baidu.'.$name),
                ];
                config(['baidu.'.$name.'.default' => $accounts['default']]);
            } else {
                $accounts = config('baidu.'.$name);
            }

            foreach ($accounts as $account => $config) {
                $this->app->singleton("baidu.{$name}.{$account}", function ($laravelApp) use ($name, $account, $config, $class) {
                    $app = new $class(array_merge(config('baidu.defaults', []), $config));
                    if (config('baidu.defaults.use_laravel_cache')) {
                        $app['cache'] = $laravelApp['cache.store'];
                    }
                    $app['request'] = $laravelApp['request'];
                    return $app;
                });
            }
            $this->app->alias("baidu.{$name}.default", 'baidu.'.$name);
            $this->app->alias("baidu.{$name}.default", 'easybaidu.'.$name);
            $this->app->alias('baidu.'.$name, $class);
            $this->app->alias('easybaidu.'.$name, $class);
        }
    }
}
