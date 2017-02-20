<?php
namespace App\Controller;

use App\vendor\Request\Request;
use App\Model\Users;

/**
*
*/
class ConnexionController extends Controller
{
    public function index()
    {
        return $this->view('view/connexion.php');
    }

    public function connexion(Request $req)
    {
        $user = new Users();
        if ($use = $user->identValid($req)) {
            $use[0]->token = $use[0]->encryptPass(time().rand(0,10000).$use[0]->pseudo.$use[0]->mail.time());
            $use[0]->expire + (7 * 24 * 60 * 60);
            $use[0]->update();
            $_SESSION['token'] = $use[0]->token;
            header('location:/');
            return;
        }
        header('location:/connexion?error=connexion');
        return;
    }

    public function inscription(Request $req)
    {
        $user = new Users();
        if ($user->validPseudo($req) && $user->validMail($req) && $user->validPassword($req)) {
            $user = new Users();
            $user->saveUser($req);
            header('location:/connexion?valide=true');
        } else {
            header('location:/connexion?non=non');
        }
    }

    public function deco()
    {
        session_destroy();
        header('location:/');
    }

    public function forgot()
    {
        return $this->view('view/connexion.php');
    }
}
?>
