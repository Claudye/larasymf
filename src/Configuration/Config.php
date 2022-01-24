<?php
namespace Simplecode\Configuration;

/**
 * @method static ConfigFluent get()
 */
class Config
{

    public const CONFIG_DIR = __DIR__ . '/../../config';
    
    public static $config;

    public static function __callStatic($name, $arguments)
    {
        $config = new ConfigFluent(Config::CONFIG_DIR);
         
        return $config->{$name}(...$arguments);
    }
    
}
