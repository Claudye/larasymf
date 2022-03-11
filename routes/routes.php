<?php

/**
 * Here the definitions of the routes of the site
 * If a route is not defined here then a 404 error will be thrown
 */

use App\Http\Controllers\HomeController;

    /**
     * Got to ./app/Pages
     * You will find a file named home.php with a function named  index
     */
    addRoute('/', ['home', 'index']);
    
    /**
     * 
     * You can also use like this
     * 
     *
     */

    /**
     * Controller as POO
     * addRoute('/', [HomeController::class, 'index']),
     */

    /*
    * Controller as closure
    *
    addRoute('/', function(){
        // Find home.php in view
        return view('home.php'[
            'title'=>'Welcome !'
        ]);
    }),
    *
    */
