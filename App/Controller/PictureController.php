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

    public function index()
    {
        $img = $this->me->pictures(true)->order([["time", "DESC"]])->get();
        $this->view('view/takePicture.php', ['user' => $this->me, 'img' => $img]);
    }

    public function takePicture(Request $req)
    {
        if ($req->input('donnee')) {
            $pict = new Pictures();
            $pict->users_id = (int)$this->me->id_users;
            $pict->makePicture($req);
            echo json_encode(array('src'=>'src/imgsave/'.$pict->src.'.png', 'id' => $pict->id_pictures));
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Donnée incorrect"]);
        }
    }

    public function galerie()
    {
        $pictures = new Pictures();
        $pictures = $pictures->all();
        $pict = array('pictures' => $pictures, 'count' => count($pictures));
        $pict = (object)$pict;
        $this->view('view/galerie.php', ['pictures' => $pict, 'user' => $this->me]);
    }

    public function showAll()
    {
        $req = new Request;
        $pict = array('limit' => (int)$req->input('limit'), 'offset' => (int)$req->input('offset'));
        $picturesQuery = new Pictures();
        $pictures = $picturesQuery->all("desc", $req->input('limit'), $req->input('offset'));
        $pict['pictures'] = $pictures;
        $pict['count'] = $picturesQuery->count();
        $pict = (object)$pict;
        echo json_encode($pict);
    }

    public function picture($id)
    {
        $user = array();
        $picture = new Pictures();
        $picture = $picture->find($id);
        if (count($picture) == 1) {
            $user = $picture->users();
        }
        if (count($user) == 1) {
            $com = $picture->commentaires();
            $this->view('view/picture.php', ['user' => $this->me, 'usersPicture' => $user, 'picture' => $picture, 'commentaires' => $com]);
        } else {
            $this->galerie();
        }
    }
}
