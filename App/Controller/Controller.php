<?php
namespace App\Controller;

/**
*
*/


function test()
{

}
class Controller
{

    function __construct()
    {

    }

    function view($view = "connexion", $param = array()){
        extract($param);
        include_once('view/layout/head.php');
    }
}
?>
