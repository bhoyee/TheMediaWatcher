<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit17505b6d14853550fd0216f19cacb96e
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit17505b6d14853550fd0216f19cacb96e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit17505b6d14853550fd0216f19cacb96e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit17505b6d14853550fd0216f19cacb96e::$classMap;

        }, null, ClassLoader::class);
    }
}