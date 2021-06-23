# laravel-baidu

百度 SDK for Laravel / Lumen， 基于 [larva/easybaidu](https://github.com/larvatecn/easybaidu)
拿 超哥的 laravel-wechat 改的。
## 安装

```shell
composer require "larva/laravel-baidu"
```

## 配置

### Laravel 应用

1. 在 `config/app.php` 注册 ServiceProvider 和 Facade (Laravel 5.5 + 无需手动注册)

```php
'providers' => [
    // ...
    Larva\LaravelBaidu\ServiceProvider::class,
],
'aliases' => [
    // ...
    'EasyBaidu' => Larva\LaravelBaidu\Facade::class,
],
```

2. 创建配置文件：

```shell
php artisan vendor:publish --provider="Larva\LaravelBaidu\ServiceProvider"
```

3. 修改应用根目录下的 `config/baidu.php` 中对应的参数即可。

4. 每个模块基本都支持多账号，默认为 `default`。

### Lumen 应用

1. 在 `bootstrap/app.php` 中 82 行左右：

```php
$app->register(Larva\LaravelBaidu\ServiceProvider::class);
```

2. 如果你习惯使用 `config/baidu.php` 来配置的话，将 `vendor/overtrue/laravel-baidu/config/baidu.php` 拷贝到`项目根目录/config`目录下。


##### 使用外观

```php

  $miniProgram = \EasyBaidu::miniProgram(); // 小程序
  
  // 均支持传入配置账号名称
  \EasyBaidu::miniProgram('foo'); // `foo` 为配置文件中的名称，默认为 `default`
  //...
```


## License

MIT
