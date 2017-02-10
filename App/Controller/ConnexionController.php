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
        return view('view/connexion.php');
    }

    public function connexion()
    {
        return view('view/connexion.php');
    }

    public function inscription(Request $req)
    {
        $user = new Users();
        $Checkuser = $user
        ->where([
                    ['pseudo', '=', $req->input('pseudo')],
                ])
        ->whereOr([
                    ['mail', '=', $req->input('mail')]
                ])->get();
        if ($Checkuser != false) {
            header('location:/connexion?non=non');
            echo 'oui';
            return;
        }
        $user = new Users();
        $user->saveUser($req);
        header('location:/connexion?oui=oui');
    }
}
?>
