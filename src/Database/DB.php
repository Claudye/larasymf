<?php

namespace Simplecode\Database;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class DB
{
    /**
     * Capsule
     *
     * @var Capsule
     */
    protected static $capsule ;
    public static function boot()
    {
        static::$capsule = new Capsule;
        
        $config = config('database');
        $default = config('database.default');
        static::$capsule->addConnection($config[$default]);

        static::$capsule->setEventDispatcher(new Dispatcher(new Container));
        // Make this Capsule instance available globally via static methods... (optional)
        static::$capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        static::$capsule->bootEloquent();
    }

    /**
     * \Illuminate\Database\Schema\Builder
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    public static function Schema(){
        return static::$capsule->schema();
    }

    /**
     * \Illuminate\Database\Schema\Builder
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function table(string $table){
        return static::$capsule->table($table);
    }
    
}
