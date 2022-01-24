<?php
namespace App\Http\Controllers;

use Simplecode\Protocole\Routing\Controller;
class HomeController extends Controller{
    public function index(){
        return view('home.php',[
           'title'=> "Welcome !"
        ]);
    }
}