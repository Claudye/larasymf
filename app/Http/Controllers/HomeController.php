<?php
namespace Components\Http\Controllers;

use Simplecode\Protocole\Routing\Controller;
class HomeController extends Controller{
    public function home(){
       
        return view('home.php',[
           'title'=> translate('home.title')
        ]);
    }
}