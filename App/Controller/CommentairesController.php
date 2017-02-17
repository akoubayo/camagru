<?php
namespace App\Controller;

use App\Model\Commentaires;
use App\vendor\Request\Request;
use App\Model\Users;
use App\Model\Pictures;

/**
*
*/
class CommentairesController extends Controller
{

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

    public function create(Request $req)
    {
        $com = trim($req->input('commentaire'));
        $picture = new Pictures;
        $picture = $picture->find((int)$req->input('id_picture'));
        if (!empty($com) && count($picture) == 1) {
            $commentaire = new Commentaires();
            $newCome = $commentaire->create($req, $this->me);
            echo json_encode($newCome);
        } else {
            echo json_encode(["error" => "Nous avons rencontré une erreur"]);
        }
    }
}
