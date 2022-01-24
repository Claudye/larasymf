<?php

/**
 * Ici la définitions des routes du site
 * Si une route n'est pas définie ici alors une erreur 404 sera levée
 */

use App\Http\Controllers\HomeController;

return [
    /**
     * Got to ./app/Pages
     * You will find a file named home.php with a function named  index
     */
    addRoute('/', ['home', 'index']),
    
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

];
