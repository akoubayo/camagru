<?php
namespace App\Controller;

use App\Model\Users;
use App\vendor\Request\Request;
use App\Model\Pictures;

    /**
    *
    */
class PictureController extends Controller
{

    public function index()
    {
        if (isset($_SESSION['pseudo'])) {
            $user = new Users();
            $user = $user->where([["token", "=", Request::control($_SESSION['pseudo'])]])->get();
            if (count($user) != 1) {
                session_unset();
                session_destroy();
                header('location:/connexion?error=connexion');
            }
            $img = $user[0]->pictures(true)->order([["time", "DESC"]])->get();
            $this->view('view/takePicture.php', ['user' => $user[0], 'img' => $img]);
        } else {
            $this->view('view/connexion.php');
        }
    }

    public function takePicture(Request $req)
    {
        if ($req->input('donnee') && $req->input('token')) {
            $user = new Users();
            $user = $user->where([['token', '=', $req->input('token')]])->get();
            if (count($user) != 1) {
                http_response_code(400);
                echo json_encode(["error" => "Invalid token"]);
                return;
            }
            $pict = new Pictures();
            $pict->user_cam_id = (int)$user[0]->id_user_cam;
            $pict->makePicture($req);
            echo json_encode(array('src'=>'src/imgsave/'.$pict->src.'.png', 'id' => $pict->id_pictures));
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Donnée incorrect"]);
        }
    }
}
