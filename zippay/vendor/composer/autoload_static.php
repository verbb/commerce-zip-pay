<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit75415645bb865b7a56ad8c9afe1564ac
{
    public static $prefixLengthsPsr4 = array (
        'z' => 
        array (
            'zipMoney\\' => 9,
        ),
        'O' => 
        array (
            'Omnipay\\ZipPay\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'zipMoney\\' => 
        array (
            0 => __DIR__ . '/..' . '/zipmoney/merchantapi-php/lib',
        ),
        'Omnipay\\ZipPay\\' => 
        array (
            0 => __DIR__ . '/../..' . '/ZipPay',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit75415645bb865b7a56ad8c9afe1564ac::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit75415645bb865b7a56ad8c9afe1564ac::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
