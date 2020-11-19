<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfb060108d13c7c4ca23bac7d20f8add0
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mijnkantoor\\NMBRS\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mijnkantoor\\NMBRS\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfb060108d13c7c4ca23bac7d20f8add0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfb060108d13c7c4ca23bac7d20f8add0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
