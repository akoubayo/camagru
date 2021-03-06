<?php
namespace App\Autoloader;

class Autoloader
{
/**
 * Enregistre notre autoloader
 */
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Inclue le fichier correspondant à notre classe
     * @param $class string Le nom de la classe à charger
     */

    public static function autoload($class)
    {

        if (strpos($class, __NAMESPACE__ . '\\') === 0) {
            $class = str_replace(__NAMESPACE__ . '\\', '', $class);
            $class = str_replace('\\', '/', $class);
            if (file_exists('./' . $class . '.php')) {
                require_once('./' . $class . '.php');
            }
        } else {
            $class = str_replace('\\', '/', $class);
            if (file_exists('../' . $class . '.php')) {
                require_once('../' . $class . '.php');
            }
        }
    }
}

Autoloader::register();
