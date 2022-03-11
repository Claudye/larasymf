<?php
/**
 * Fichier des helpers
 */

use Simplecode\Facades\Auth;
use Simplecode\Facades\Session;
use Simplecode\Configuration\Config;
use Simplecode\Translation\Translator;
use Simplecode\Protocole\Http\Response;
use Simplecode\Protocole\Routing\Route;
use Simplecode\Facades\Route as FacadesRoute;
use Simplecode\Protocole\Routing\Views\Render;
use Symfony\Component\HttpFoundation\InputBag;
use Simplecode\Protocole\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\ServerBag;
use Simplecode\Protocole\Routing\RouteCollection;
use Simplecode\Session\Session as SessionSession;

/**
 * Ajout
 *
 * @param string $uri l'url de la route
 * @param Closure|array $action le controlleur
 * @param array $options autre option
 * @param string|null $name le nom associé au route
 * @return Route
 */
function addRoute(string $uri, $action,array $options = []){
    return RouteCollection::add(new Route($uri,$action, $options));
 }

 /**
  * Renvoie une reponse
  *
  * @param string $view
  * @param array $data
  * @return \Simplecode\Protocole\Http\Response
  */
 function view (string $view, array $data =[]){
     return new Response((new Render())->render($view,$data));
 }
/**
 * Force la création d'une erreur et arrête la requete
 *
 * @param string $message
 * @param integer $statutCode
 * @return void
 */
 function abort(string $message, int $statutCode=404){
     view('errors/error.php',[
         'code'=>$statutCode,
         'message'=>$message
     ])->setStatusCode($statutCode)->send();
     exit;
 }
/**
 * Permet l'inclusion d'une vue
 *
 * @param string $fille
 * @throws Exception
 * @return string
 */
 function view_path(string $filename){
    if (file_exists($file=VIEWS_DIR.'/'. trim($filename,'/'))) {
        return $file;
    }
    throw new Exception("La vue $filename n'existe pas", 1);
 }
/**
 * Retourne l'asset du site
 *
 * @param string $asset
 * @return string
 */
 function asset(string $asset, string $prefix=null){
     if ($prefix) {
        return joinPath(ASSET_URL,$prefix,$asset);
     }
     return joinPath(ASSET_URL,$asset);
 }
/**
 * Retourne une valeur paramètre post ou gt
 *
 * @param string $key
 * @return string
 */
 function request(string $key){
    return isset($_REQUEST[$key]) ? htmlspecialchars($_REQUEST [$key]) : NULL ;
 }

 function dp($var){
    dump($var); exit;
 }
/**
 * Make a url
 *
 * @param string|null $url
 * @return string
 */
 function url(?string $url ="/"){
     
     return substr(trim($url),0,4)=='http' ? $url : APP_URL. '/' . trim($url,'/') ;
 }

 /**
  * Check route is active
  *
  * @param string $route
  * @param string $options
  * @return string|false
  */
 function routeActive(string $route,string $options ="active"){
    return url($route)==url($_SERVER['REQUEST_URI']) ? $options :null;
 }
/**
 * Undocumented function
 *
 * @param string $key
 * @return \Simplecode\Configuration\ConfigFluent|mixed
 */
 function config(string $key = NULL){
     return Config::get($key);
 }
/**
 * CSRF token
 *
 * @return string
 */
 function token(){
     return Session::token();
 }

 function strlimit(string $content, int $limit =120, string $end ="..."){
    if (strlen($content) > $limit) {
       return substr($content, 0 ,$limit) . $end;
    }

    return $content;
 }

 function redirect(string $url =null, int $statutCode = 302){
     return (new RedirectResponse(url($url),$statutCode));
 }

 function middleware(array $middlewares, Closure $routes){
        /**
         * @var Route[]
         */
        $routes = $routes();
        
        array_map(function(Route $route)use ($middlewares){
            return $route->middleware($middlewares);
        },$routes);
         return $routes;
 }

/**
     * Join file
     *
     * @param string ...$path
     * @return string
     */
    function joinPath(string ...$path){
        
        $num_args = func_num_args();
        $args = func_get_args();
        $path = trim($args[0],SEPERATOR);
       
        if( $num_args > 1 )
        {
            for ($i = 1; $i < $num_args; $i++)
            {
                $path .= SEPERATOR.trim($args[$i],SEPERATOR);
            }
        }
       
        return $path;
    }

    function error(string $key){
        if (Session::has('_error')) {
            $errors = Session::get('_error');
            if (array_key_exists($key,(array) $errors)) {
                return $errors [$key];
            }
        }
    
        $errors = _SESSION()->get('_form_errors');
        if ($key) {
            if (is_array($errors)) {
                if (array_key_exists($key, $errors)) {
                    return $errors [$key];
                }
            }
        }
        return null;
    }
function hasError(string $key){
    if (Session::has('_error')) {
        $errors = Session::get('_error');
        if (array_key_exists($key,$errors)) {
            return true;
        }
    }
    return false;
}
/**
 * Check if form is failed
 *
 * @return boolean
 */
function hasErrors(){
    return Session::has('_error');
}

function destroyError(){
    Session::remove('_error');
}
/**
 * Tanslate
 *
 * @param string $key
 * @return mixed
 */
function translate(string $key){
    return Translator::translate($key);
}

function lang()
{
    return Session::get('_lang');
}

function langues(){
    return Translator::accepts();
}
/**
 * Render view text
 *
 * @param string $view
 * @param array $data
 * @return string
 */
function view_render(string $view, array $data =[]){
   return (new Render())->render($view,$data);
}
/**
 * Get route url by name
 *
 * @param string $name
 * @return string
 */
function route(string $name, array $params = []){
    return url(FacadesRoute::get($name, $params));
}
/**
 * Undocumented function
 *
 * @return Components\Models\User
 */
function auth(){
	return Auth::auth();
}


function htmlchars(string $str){
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8') ;
}

if (!function_exists('back')) {
    /**
     * Redirecto to previous url
     *
     * @return Simplecode\Protocole\Http\RedirectResponse
     */
    function back(int $statutCode =302){
        return redirect(Session::previousUrl(), $statutCode);
    }
}

if (!function_exists('_SERVER')) {
    /**
     * Return server value
     *
     * @param string|null $key
     * @return ServerBag|string|null
     */
    function _SERVER(string $key=null){
        if (!$key) {
           return new ServerBag();
        }else {
            return (new ServerBag($_SERVER))->get($key) ;
        }
    }
}

if (!function_exists('_SESSION')) {
    /**
     * Return server value
     *
     * @param string|null $key
     * @return SessionSession|mixed
     */
    function _SESSION(string $key=null){
        if (!$key) {
           return new SessionSession();
        }else {
            return (new SessionSession)->get($key) ;
        }
    }
}
if (!function_exists('_GET')) {
    /**
     * Return server value
     *
     * @param string|null $key
     * @return InputBag|mixed
     */
    function _GET(string $key=null){
        if (!$key) {
           return new InputBag($_GET);
        }else {
            return (new InputBag($_GET))->get($key) ;
        }
    }
}



if (!function_exists('guard')) {
    function guard(string $guard){
        if ("admin"==$guard) {
            if (auth()) {
               return auth()->role=='admin';
            }
            return false;
        }

        throw new Exception("The guard $guard is not defined", 1);
        
    }
}

if (!function_exists('str_concat')) {
   /**
 * Concat string
 *
 * @param string ...$string
 * @return string
 */
function str_concat(string ...$string){
    $str = '';
    for ($i=0; $i < func_num_args() ; $i++) {
       $str.=func_get_args()[$i];
    }

    return $str;
}
}
/**
 * Affiche le token masqué par un input
 *
 * @return void
 */
function csrf_token(){
    echo '<input type="hidden" name="_token" value="'.token().'">';
}


/**
 * Return old value or null
 *
 * @param string|null $key
 * @return mixed|null
 */
function old(string $key=null){
    $errors = _SESSION()->get('_form');
    if ($key) {
        if (is_array($errors)) {
            if (array_key_exists($key, $errors)) {
                return $errors [$key];
            }
        }
    }
    return null;
}


