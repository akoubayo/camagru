<?php
namespace App\Controller;

use App\Model\Likes;
use App\vendor\Request\Request;
use App\Model\Users;
use App\Model\Pictures;

/**
*
*/
class LikesController extends Controller
{
    public $me;

    public function __construct()
    {
        if (isset($_SESSION['token']) || isset($_SERVER['HTTP_BEABER'])) {
            $token = (isset($_SESSION['token'])) ? $_SESSION['token'] : $_SERVER['HTTP_BEABER'];
            $user = new Users();
            $u = $user->where([["token", "=", Request::control($token)]])->get();
            if (is_array($u) && count($u) == 1 && is_object($u[0])) {
                $this->me = $u[0];
            } else {
                header('location:/');
            }
        } else {
            header('location:/');
        }
    }

    public function addLikes(Request $req)
    {
        $like = new Likes();
        $ret = $like->addLikes($this->me, $req);
        echo json_encode($ret);
    }
}
