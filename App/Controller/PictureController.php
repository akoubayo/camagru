<?php
namespace App\Controller;
    /**
    *
    */
class PictureController
{

    public function index()
    {
        if(isset($_SESSION['pseudo'])){
            $view = 'view/takePicture.php';
        }
        else {
            $view = 'view/connexion.php';
        }
        include_once('view/layout/head.php');
    }

    public function takePicture()
    {
        $dataURL = $_POST['donnee'];
        $parts = explode(',', $dataURL);
        $data = $parts[1];
        $data = str_replace(' ', '+', $data);
        $data = base64_decode($data);
        file_put_contents('src/imgsave/'.$_POST['name'].'.png', $data);
        echo json_encode(array('src'=>'src/imgsave/'.$_POST['name'].'.png'));
    }
}
?>
