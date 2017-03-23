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
        $img = $this->me
            ->pictures(true)
            ->where([['del', '=', 0]])
            ->order([["time", "DESC"]])
            ->get();
        $this->view('view/takePicture.php', ['user' => $this->me, 'img' => $img]);
    }

    public function takePicture(Request $req)
    {
        if ($req->input('donnee')) {
            $pict = new Pictures();
            $pict->users_id = (int)$this->me->id_users;
            $type = $req->input("type");
            if ($type == 'gifTmp') {
                $pict->srcFolder = 'src/imgtmp/';
                $pict->save = false;
                $pict->id_pictures = null;
            } elseif ($type == 'gif'){
                $pict->createGif = true;
            }
            if ($pict->makePicture($req)) {
                echo json_encode(array('src'=>$pict->srcFolder.$pict->src.'.'.$pict->type, 'id' => $pict->id_pictures));
                return;
            }
        }
        echo json_encode(["error" => "Donnée incorrect"]);
        return;
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
        $pictures = $picturesQuery
            ->where([['del', '=', '0']])
            ->order([['id_pictures', 'DESC']])
            ->limit($req->input('limit'))
            ->offset((int)$req->input('offset'))
            ->get();

        $pict['pictures'] = $pictures;
        $pict['count'] = $picturesQuery->count(true)
            ->where([['del', '=', '0']])
            ->get();
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
            $com = $picture->commentaires(true)->order([["commentaires.time", "DESC"]])->get();
            $this->view('view/picture.php', ['user' => $this->me, 'usersPicture' => $user, 'picture' => $picture, 'commentaires' => $com]);
        } else {
            $this->galerie();
        }
    }

    public function delete($id)
    {
        $picture = $this->me->pictures(true)->where([['id_pictures', '=', $id]])->get();
        if (count($picture) == 1) {
            $picture[0]->del = true;
            $picture[0]->update();
            echo json_encode($picture[0]);
        } else {
            echo json_encode(array('error' => 'Une erreur s\'est produite !'));
        }
    }
}
