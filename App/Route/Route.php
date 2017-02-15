<?php
/**
 * Index file
 *
 * PHP Version 7.0
 *
 * @category Route
 * @package  Camagru
 * @author   Damien Altman <damien@tilkee.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/akoubayo/camagru
 */


namespace App\Route;

use App\vendor\Request\Request;

/**
 * Route class
 *
 * Description de la classe Route : TODO
 *
 * @category Route
 * @package  Camagru
 * @author   Damien Altman <damien@tilkee.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/akoubayo/camagru
 *
 * var request_uri
 * var request_method
 */
class Route
{
    private $_methode;
    private $_uri;

    /**
     * Constructeur
     *
     * Description de la function : TODO
     *
     * @return N/A Ne retourne rien ? : CHECK
     */
    public function __construct()
    {
        foreach ($_SERVER as $key => $value) {
            $key = strtolower($key);
            $this->$key = $value;
        }
    }

    /**
     * Function : _pushGet
     *
     * Description de la function : TODO
     *
     * @param TypeDeRequest $request Description de request : TODO
     * @param string        $tabUri  Description de request : TODO
     *
     * @return N/A Ne retourne rien ? : CHECK
     */
    private function _pushGet($request, $tabUri)
    {
        var_dump($tabUri);
        $explode = explode('?', $request);
        $explode = explode('/', $explode[0]);
        //var_dump($explode);
        foreach ($explode as $key => $value) {
            if ($key > 1) {
                echo $value;
                $_GET[$tabUri[$key - 2]] = $value;
            }
        }
    }

    /**
     * Function checkRoute
     *
     * Description de la function : TODO
     *
     * @param string $uri Description de request : TODO
     *
     * @return array An array of Ingredient objects
     */
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
                $this->_pushGet(substr($this->request_uri, $pos+1), $tabUri);
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Function get
     *
     * Description de la function : TODO
     *
     * @param string $uri           Description de request : TODO
     * @param string $call_function Description de request : TODO
     *
     * @return array An array of Ingredient objects
     */
    public function get($uri, $call_function)
    {
        if ($this->request_method == 'GET' && $this->checkRoute($uri)) {
            if ($this->request_uri == '/') {
                $call = explode('@', $call_function);
                $controller = new \App\Controller\PictureController();
                $func = $call[1];
                $controller->$func();
            } else {
                $call = explode('@', $call_function);
                $call[0] = '\App\Controller\\'.$call[0];
                $controller = new $call[0]();
                $call = $call[1];
                $controller->$call();
            }
        }
    }

    /**
     * Function post
     *
     * Description de la function : TODO
     *
     * @param string $uri           Description de request : TODO
     * @param string $call_function Description de request : TODO
     *
     * @return array An array of Ingredient objects
     */
    public function post($uri, $call_function)
    {
        if ($this->request_method == 'POST' && $this->checkRoute($uri)) {
            $call = explode('@', $call_function);
            $call[0] = '\App\Controller\\'.$call[0];
            $controller = new $call[0]();
            $call = $call[1];
            $controller->$call(new Request);
        }
    }
}
