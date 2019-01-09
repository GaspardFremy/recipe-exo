<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita5736c4f7ada39b080085002428b169c
{
    public static $prefixLengthsPsr4 = array (
        'K' => 
        array (
            'Klein\\' => 6,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Klein\\' => 
        array (
            0 => __DIR__ . '/..' . '/klein/klein/src/Klein',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Klein\\AbstractResponse' => __DIR__ . '/..' . '/klein/klein/src/Klein/AbstractResponse.php',
        'Klein\\AbstractRouteFactory' => __DIR__ . '/..' . '/klein/klein/src/Klein/AbstractRouteFactory.php',
        'Klein\\App' => __DIR__ . '/..' . '/klein/klein/src/Klein/App.php',
        'Klein\\DataCollection\\DataCollection' => __DIR__ . '/..' . '/klein/klein/src/Klein/DataCollection/DataCollection.php',
        'Klein\\DataCollection\\HeaderDataCollection' => __DIR__ . '/..' . '/klein/klein/src/Klein/DataCollection/HeaderDataCollection.php',
        'Klein\\DataCollection\\ResponseCookieDataCollection' => __DIR__ . '/..' . '/klein/klein/src/Klein/DataCollection/ResponseCookieDataCollection.php',
        'Klein\\DataCollection\\RouteCollection' => __DIR__ . '/..' . '/klein/klein/src/Klein/DataCollection/RouteCollection.php',
        'Klein\\DataCollection\\ServerDataCollection' => __DIR__ . '/..' . '/klein/klein/src/Klein/DataCollection/ServerDataCollection.php',
        'Klein\\Exceptions\\DispatchHaltedException' => __DIR__ . '/..' . '/klein/klein/src/Klein/Exceptions/DispatchHaltedException.php',
        'Klein\\Exceptions\\DuplicateServiceException' => __DIR__ . '/..' . '/klein/klein/src/Klein/Exceptions/DuplicateServiceException.php',
        'Klein\\Exceptions\\HttpException' => __DIR__ . '/..' . '/klein/klein/src/Klein/Exceptions/HttpException.php',
        'Klein\\Exceptions\\HttpExceptionInterface' => __DIR__ . '/..' . '/klein/klein/src/Klein/Exceptions/HttpExceptionInterface.php',
        'Klein\\Exceptions\\KleinExceptionInterface' => __DIR__ . '/..' . '/klein/klein/src/Klein/Exceptions/KleinExceptionInterface.php',
        'Klein\\Exceptions\\LockedResponseException' => __DIR__ . '/..' . '/klein/klein/src/Klein/Exceptions/LockedResponseException.php',
        'Klein\\Exceptions\\RegularExpressionCompilationException' => __DIR__ . '/..' . '/klein/klein/src/Klein/Exceptions/RegularExpressionCompilationException.php',
        'Klein\\Exceptions\\ResponseAlreadySentException' => __DIR__ . '/..' . '/klein/klein/src/Klein/Exceptions/ResponseAlreadySentException.php',
        'Klein\\Exceptions\\RoutePathCompilationException' => __DIR__ . '/..' . '/klein/klein/src/Klein/Exceptions/RoutePathCompilationException.php',
        'Klein\\Exceptions\\UnhandledException' => __DIR__ . '/..' . '/klein/klein/src/Klein/Exceptions/UnhandledException.php',
        'Klein\\Exceptions\\UnknownServiceException' => __DIR__ . '/..' . '/klein/klein/src/Klein/Exceptions/UnknownServiceException.php',
        'Klein\\Exceptions\\ValidationException' => __DIR__ . '/..' . '/klein/klein/src/Klein/Exceptions/ValidationException.php',
        'Klein\\HttpStatus' => __DIR__ . '/..' . '/klein/klein/src/Klein/HttpStatus.php',
        'Klein\\Klein' => __DIR__ . '/..' . '/klein/klein/src/Klein/Klein.php',
        'Klein\\Request' => __DIR__ . '/..' . '/klein/klein/src/Klein/Request.php',
        'Klein\\Response' => __DIR__ . '/..' . '/klein/klein/src/Klein/Response.php',
        'Klein\\ResponseCookie' => __DIR__ . '/..' . '/klein/klein/src/Klein/ResponseCookie.php',
        'Klein\\Route' => __DIR__ . '/..' . '/klein/klein/src/Klein/Route.php',
        'Klein\\RouteFactory' => __DIR__ . '/..' . '/klein/klein/src/Klein/RouteFactory.php',
        'Klein\\ServiceProvider' => __DIR__ . '/..' . '/klein/klein/src/Klein/ServiceProvider.php',
        'Klein\\Validator' => __DIR__ . '/..' . '/klein/klein/src/Klein/Validator.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita5736c4f7ada39b080085002428b169c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita5736c4f7ada39b080085002428b169c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita5736c4f7ada39b080085002428b169c::$classMap;

        }, null, ClassLoader::class);
    }
}
