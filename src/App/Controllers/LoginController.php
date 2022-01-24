<?php
namespace Simplecode\App\Controllers;

use Simplecode\Auth\Auth;
use Simplecode\Auth\Login;
use Simplecode\Facades\Session;
use Simplecode\Protocole\Http\Request;
use Simplecode\Protocole\Routing\Controller;

class LoginController extends Controller{
    
    /**
     * Render view for connection
     *
     * @return \Simplecode\Protocole\Http\Response
     */
    public function login(){
        if (Session::exists(Auth::AUTHSSID)) {
            return redirect(config('auth.home'));
        }
        return view('auth/login.php',[
            'title'=>'Connexion'
        ]);
    }

    /**
     * Connect user
     *
     * @param Request $request
     * @return \Simplecode\Protocole\Http\Response
     */
    public function connect(Request $request){

        if (!$request->has('remember_token')) {
            $request->set("remember_token",false);
        }
        
        $userInfo = $request->all([
            config('auth.identifier'),config('auth.password'), config('auth.remember_token')
        ]);
        $user =Login::login($userInfo);
        
        if (null ==$user) {
            Session::set('_error', true);
           return redirect(config('auth.login'));
        }
        return redirect(config('auth.home'));
    }
    /**
     * Log out a user
     *
     * @return \Simplecode\Protocole\Http\Response
     */
    public function logout(){
        Session::remove(Auth::AUTHSSID);
        return redirect('/');
    }
}