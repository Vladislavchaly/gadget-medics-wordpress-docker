<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8d896f99531f81b5c208c1fb2dd757e0
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8d896f99531f81b5c208c1fb2dd757e0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8d896f99531f81b5c208c1fb2dd757e0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
