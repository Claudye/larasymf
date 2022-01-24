<?php
/**
 * Set data for home view
 *
 * @return \Simplecode\Protocole\Http\Response
 */
function index(){
    /***
     * Goto /views/home.php to edit a home view
     */
    return view('home.php',[
        'title'=>'Welcome !'
    ]);
}