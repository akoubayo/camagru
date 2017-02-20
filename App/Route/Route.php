<?php
namespace App\Route;

use App\vendor\Request\Request;
use App\Model\Users;

/**
* var request_uri
* var request_method
*/

class Route
{
    private $_methode;
    private $_uri;
    private $_param = array();
    private $_find_route = false;

    public function __construct()
    {
        foreach ($_SERVER as $key => $value) {
            $key = strtolower($key);
            $this->$key = $value;
        }
    }

    public function auth($next, $redirect, $function_call)
    {
        if (isset($_SESSION['token']) || isset($this->http_beaber)) {
            $token = (isset($_SESSION['token'])) ? $_SESSION['token'] : $this->http_beaber;
            $user = new Users();
            $u = $user->where([["token", "=", Request::control($token)]])->get();
            if (is_array($u) && count($u) == 1 && is_object($u[0])) {
                return $next($this);
            }
        }
    }

    private function getParam($uri)
    {
        $explode = explode('/', $uri);
        $explode1 = explode('/', $this->request_uri);
        foreach ($explode as $key => $value) {
            if (substr($value, 0, 1) == '{' && isset($explode1[$key])) {
                $this->_param[] = $explode1[$key];
            }
        }
    }

    private function pushGet($request, $tabUri)
    {
        $explode = explode('?', $request);
        $explode = explode('/', $explode[0]);
        foreach ($explode as $key => $value) {
            if ($key > 1) {
                $_GET[$tabUri[$key - 2]] = $value;
                echo 'tot';
                $this->_param[] = $value;
            }
        }
    }

    public function checkRoute($uri)
    {
        $pos = strpos($uri, '{');
        (!$pos) ? $pos = -1 : $pos--;
        if ($pos == -1) {
            if ($this->request_uri === $uri) {
                return true;
            } elseif (explode('?', $this->request_uri)[0] === $uri) {
                return true;
            }
        }
        $request = substr(explode('?', $this->request_uri)[0], 0, $pos);
        if ($request == substr($uri, 0, $pos)) {
            $tabUri = explode('}', str_replace(['{','/'], '', substr($uri, $pos+1)));
            $tabRequest = explode('/', substr($this->request_uri, $pos+1));
            if (count($tabUri) === count($tabRequest)+1) {
                $this->pushGet(substr($this->request_uri, $pos+1), $tabUri);
                return true;
            }
            return false;
        }
        return false;
    }
    public function get($uri, $call_function)
    {
        if ($this->_find_route == false && $this->request_method == 'GET' && $this->checkRoute($uri)) {
            $call = explode('@', $call_function);
            $call[0] = '\App\Controller\\'.$call[0];
            $controller = new $call[0]();
            $call = $call[1];
            $this->getParam($uri);
            call_user_func_array(array($controller, $call), $this->_param);
            $this->_find_route = true;
        }
        return;
    }

    public function post($uri, $call_function)
    {
        if ($this->_find_route == false && $this->request_method == 'POST' && $this->checkRoute($uri)) {
            $call = explode('@', $call_function);
            $call[0] = '\App\Controller\\'.$call[0];
            $controller = new $call[0]();
            $call = $call[1];
            $controller->$call(new Request);
            $this->_find_route = true;
        }
    }

    public function delete($uri, $call_function)
    {
        if ($this->_find_route == false && $this->request_method == 'DELETE' && $this->checkRoute($uri)) {
            $call = explode('@', $call_function);
            $call[0] = '\App\Controller\\'.$call[0];
            $controller = new $call[0]();
            $call = $call[1];
            $this->getParam($uri);
            call_user_func_array(array($controller, $call), $this->_param);
            $this->_find_route = true;
        }
    }

    public function defaultRoute($uri, $call_function)
    {
        if ($this->_find_route == false) {
            $this->request_uri = $uri;
            //$this->request_method = 'GET';
            $this->get($uri, $call_function);
        }
        $this->_find_route = true;
    }
}
