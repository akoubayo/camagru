<?php
/**
 * Autoloader file
 *
 * PHP Version 7.0
 *
 * @category Autoloader
 * @package  Camagru
 * @author   Damien Altman <damien@tilkee.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/akoubayo/camagru
 */
namespace App\Autoloader;

/**
 * Autoloader class
 *
 * Description de la classe Route : TODO
 *
 * @category Autoloader
 * @package  Camagru
 * @author   Damien Altman <damien@tilkee.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/akoubayo/camagru
 *
 * var request_uri
 * var request_method
 */
class Autoloader
{

    /**
     * Function : register
     *
     * Description de la function : TODO
     *
     * @return N/A Ne retourne rien ? : CHECK
     */
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }


    /**
     * Function : autoload
     *
     * Inclue le fichier correspondant à notre classe
     *
     * @param string $class Le nom de la classe à charger
     *
     * @return N/A Ne retourne rien ? : CHECK
     */
    public static function autoload($class)
    {

        if (strpos($class, __NAMESPACE__ . '\\') === 0) {
            $class = str_replace(__NAMESPACE__ . '\\', '', $class);
            $class = str_replace('\\', '/', $class);
            if (file_exists('./' . $class . '.php'))
            require_once('./' . $class . '.php');
        } else {
            $class = str_replace('\\', '/', $class);
            if (file_exists('../' . $class . '.php'))
                require_once('../' . $class . '.php');
        }
    }
}

Autoloader::register();
