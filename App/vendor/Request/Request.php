<?php
/**
 * Request file
 *
 * PHP Version 7.0
 *
 * @category Request
 * @package  Camagru
 * @author   Damien Altman <damien@tilkee.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/akoubayo/camagru
 */
namespace App\vendor\Request;

/**
 * Request class
 *
 * Description de la classe Request : TODO
 *
 * @category Request
 * @package  Camagru
 * @author   Damien Altman <damien@tilkee.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/akoubayo/camagru
 *
 * var request_uri
 * var request_method
 */
class Request
{

    /**
     * Constructeur (pas public ???) : TOFO
     *
     * Description de la function : TODO
     *
     * @return N/A Ne retourne rien ? : CHECK
     */
    function __construct()
    {

    }

    /**
     * Function : controlInput
     *
     * Description de la function : TODO
     *
     * @param string $value Description de request : TODO
     *
     * @return string $value Ne retourne rien ? : CHECK
     */
    public function controlInput($value)
    {
        $value =  stripslashes($value);
        $value =  addslashes($value);
        $value =  strip_tags($value);
        $value =  htmlspecialchars($value);
        return $value;
    }

    /**
     * Function : control
     *
     * Description de la function : TODO
     *
     * @param string $value Description de request : TODO
     *
     * @return string $value Ne retourne rien ? : CHECK
     */
    public static function control($value)
    {
        $value =  stripslashes($value);
        $value =  addslashes($value);
        $value =  strip_tags($value);
        $value =  htmlspecialchars($value);
        return $value;
    }

    /**
     * Function : input
     *
     * Description de la function : TODO
     *
     * @param string $name Description de request : TODO
     *
     * @return N/A $value ATTENTION au return de différent type ? : CHECK
     */
    public function input($name = '')
    {
        if (!empty($name)) {
            if (isset($_POST[$name]) && !empty($_POST[$name])) {
                return $this->controlInput($_POST[$name]);
            }
        } else {
            $ret = array();
            foreach ($_POST as $key => $value) {
                    $key = $this->controlInput($key);
                    $ret[$key] = $this->controlInput($value);
            }
            return $ret;
        }
        return false;
    }
}
