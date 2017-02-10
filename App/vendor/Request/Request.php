<?php
namespace App\vendor\Request;

/**
*
*/
class Request
{

    function __construct()
    {

    }

    public function controlInput($value)
    {
        $value =  stripslashes($value);
        $value =  addslashes($value);
        $value =  strip_tags($value);
        $value =  htmlspecialchars($value);
        return $value;
    }

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
