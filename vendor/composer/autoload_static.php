<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc306536c138888a33ab5b7203897edde
{
    public static $files = array (
        'a099cd12bb2d6b2f48efd2b7a6e34a59' => __DIR__ . '/..' . '/webdevstudios/cmb2/init.php',
    );

    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Madcoda\\Youtube\\' => 16,
        ),
        'C' => 
        array (
            'Cocur\\Slugify\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Madcoda\\Youtube\\' => 
        array (
            0 => __DIR__ . '/..' . '/madcoda/php-youtube-api/src',
        ),
        'Cocur\\Slugify\\' => 
        array (
            0 => __DIR__ . '/..' . '/cocur/slugify/src',
        ),
    );

    public static $classMap = array (
        'Madcoda\\compat' => __DIR__ . '/..' . '/madcoda/php-youtube-api/src/compat.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc306536c138888a33ab5b7203897edde::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc306536c138888a33ab5b7203897edde::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc306536c138888a33ab5b7203897edde::$classMap;

        }, null, ClassLoader::class);
    }
}
