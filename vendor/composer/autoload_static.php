<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit644b67c69a0f03bdf5d35e85b1f0f5ba
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'Hazesoft\\Backend\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Hazesoft\\Backend\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Hazesoft\\Backend\\Config\\Connection' => __DIR__ . '/../..' . '/src/Config/Connection.php',
        'Hazesoft\\Backend\\Controllers\\FormValidation' => __DIR__ . '/../..' . '/src/Controllers/FormValidation.php',
        'Hazesoft\\Backend\\Controllers\\Login' => __DIR__ . '/../..' . '/src/Controllers/Login.php',
        'Hazesoft\\Backend\\Controllers\\Product' => __DIR__ . '/../..' . '/src/Controllers/Product.php',
        'Hazesoft\\Backend\\Controllers\\Sanitization' => __DIR__ . '/../..' . '/src/Controllers/Sanitization.php',
        'Hazesoft\\Backend\\Models\\CheckUser' => __DIR__ . '/../..' . '/src/Models/CheckUser.php',
        'Hazesoft\\Backend\\Models\\InsertProduct' => __DIR__ . '/../..' . '/src/Models/InsertProduct.php',
        'Hazesoft\\Backend\\Models\\InsertUser' => __DIR__ . '/../..' . '/src/Models/InsertUser.php',
        'Hazesoft\\Backend\\Validations\\LoginValidation' => __DIR__ . '/../..' . '/src/Validations/LoginValidation.php',
        'Hazesoft\\Backend\\Validations\\ProductValidation' => __DIR__ . '/../..' . '/src/Validations/ProductValidation.php',
        'Hazesoft\\Backend\\Validations\\SignupValidation' => __DIR__ . '/../..' . '/src/Validations/SignupValidation.php',
        'Hazesoft\\Backend\\Validations\\Validation' => __DIR__ . '/../..' . '/src/Validations/Validation.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit644b67c69a0f03bdf5d35e85b1f0f5ba::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit644b67c69a0f03bdf5d35e85b1f0f5ba::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit644b67c69a0f03bdf5d35e85b1f0f5ba::$classMap;

        }, null, ClassLoader::class);
    }
}
