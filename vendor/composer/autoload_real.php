<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitb8ad79f9d34aef59ad3b8c3c99b97df6
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitb8ad79f9d34aef59ad3b8c3c99b97df6', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitb8ad79f9d34aef59ad3b8c3c99b97df6', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitb8ad79f9d34aef59ad3b8c3c99b97df6::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
