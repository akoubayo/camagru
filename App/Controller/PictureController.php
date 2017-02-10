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
        if(isset($_SESSION['pseudo'])){
            $user = new Users();
            $user = $user->where([["token", "=", Request::control($_SESSION['pseudo'])]])->get();
            if (count($user) != 1) {
                session_unset();
                session_destroy();
                header('location:/connexion?error=connexion');
            }
            $this->view('view/takePicture.php',['user' => $user[0]]);
        }
        else {
            $view = 'view/connexion.php';
        }
    }

    public function takePicture(Request $req)
    {
        if ($req->input('donnee') && $req->input('token')) {
            $user = new Users();
            $user = $user->where([['token', '=', $req->input('token')]])->get();
            if(count($user) != 1) {
                http_response_code(400);
                echo json_encode(["error" => "Invalid token"]);
                return;
            }
            $pict = new Pictures();
            $dataURL = $req->input('donnee');
            $parts = explode(',', $dataURL);
            $data = $parts[1];
            $data = str_replace(' ', '+', $data);
            $data = base64_decode($data);
            $name = sha1(time().rand(1,20000).$req->input('token').time());
            file_put_contents('src/imgsave/'.$name.'.png', $data);

            echo json_encode(array('src'=>'src/imgsave/'.$name.'.png'));
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Donnée incorrect"]);
        }
    }
}
?>
