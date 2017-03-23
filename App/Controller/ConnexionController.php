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
        if ($user->identValid($req) == true) {
            header('location:/');
            return;
        }
        header('location:/connexion?error');
        return;
    }

    public function inscription(Request $req)
    {
        $user = new Users();
        if ($user->validPseudo($req) && $user->validPassword($req)) {
            $user = new Users();
            $user->saveUser($req);
            header('location:/connexion?valide=true');
        } else {
            header('location:/connexion?error');
        }
    }

    public function deco()
    {
        session_destroy();
        header('location:/');
    }

    public function forgot(Request $req)
    {
        $use = new Users();
        $use->resetPassword($req);
        return $this->view('view/connexion.php');
    }

    public function confirme($id, $hash)
    {
        $user = new Users();
        if ($user->confirme($id, $hash)) {
            header('location:/');
            return;
        } else {
            header('location:/connexion?error');
            return;
        }
    }

    public function changePass($id, $hash)
    {
        $user = new Users();
        if ($user->changePass($id, $hash)) {
            return $this->view('view/changePass.php', ['id' => $id, 'hash' => $hash]);
        } else {
            header('location:/connexion?error');
            return;
        }
    }

    public function resetPassword(Request $req)
    {
        $user = new Users();
        if ($user->newPassword($req)) {
            header('location:/connexion');
            return;
        } else {
            header('location:/connexion?error');
            return;
        }
    }
}
