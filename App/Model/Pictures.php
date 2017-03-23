<?php
namespace App\Model;

use App\vendor\Request\Request;
use App\vendor\Gifencoder\Gifencoder;
/**
*
*/
class Pictures extends Model
{

    protected $table = 'pictures';
    protected $champs = array('id_pictures', 'src', 'vote', 'del', 'time', 'users_id', 'type');
    protected $data;
    public $srcFolder = 'src/imgsave/';
    public $save = true;
    public $createGif = false;

    public function users($option = false)
    {
        return $this->belongsTo('App\Model\Users', 'id_users', $option);
    }

    public function commentaires($option = false)
    {
        return $this->hasMany('App\Model\Commentaires', 'pictures_id', $option);
    }

    public function makePicture(Request $req)
    {
        if ($this->createGif == false) {
            $dataURL = $req->input('donnee');
            $parts = explode(',', $dataURL);
            $this->data = $parts[1];
            $this->data = str_replace(' ', '+', $this->data);
            $this->data = base64_decode($this->data);
        }
        $this->src = sha1(time().rand(1, 20000).$req->input('token').time());
        if ($this->createGif == false) {
            if ($this->createSup($req)) {
                if ($this->save == true) {
                    $this->savePicture();
                }
                return true;
            }
        } else {
            $gif = (array)json_decode($_POST['gif']);
            $this->makeGif($gif);
            $this->savePicture();
            return true;
        }
        return false;
    }


    public function createSup(Request $req)
    {
        $destination = imagecreatefrompng(str_replace(' ', '+', $_POST['donnee']));
        $i = 0;
        while ($req->input("src$i")) {
            $largeur_source = $req->input('width' . $i);
            $hauteur_source = $req->input('height' . $i);
            $src = substr($req->input('src' . $i), 1);
            if (($source = $this->createImg($src)) != null) {
                $newImg = $this->redimensionner($src, $source, $largeur_source, $hauteur_source);
                $largeur_destination = $req->input('width');
                $hauteur_destination = $req->input('height');
                $destination_x = $req->input('dataX' . $i);
                $destination_y =  $req->input('dataY' . $i);
                imagecopy($destination, $newImg, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);
            }
            $i++;
        }
        imagepng($destination, $this->srcFolder . $this->src . '.png');
        $this->type = 'png';
        return true;
    }

    public function createImg($src)
    {
        $mime = getimagesize($src);
        switch ($mime['mime']) {
            case 'image/png':
                $source = imagecreatefrompng($src);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($src);
                break;
            case 'image/jpeg':
                $source = imagecreatefromjpeg($src);
                break;
            case 'image/jpg':
                $source = imagecreatefromjpeg($src);
                break;
            default:
                $source = null;
                break;
        }
        return $source;
    }

    public function redimensionner($src, $imgTmp, $lar, $hau)
    {
        $TailleImageChoisie = getimagesize($src);
        $newImg = imagecreatetruecolor($lar, $hau);

        imagealphablending($newImg, false);
        imagesavealpha($newImg, true);
        imagecopyresampled($newImg, $imgTmp, 0, 0, 0, 0, $lar, $hau, $TailleImageChoisie[0], $TailleImageChoisie[1]);
        return $newImg;
    }

    public function savePicture()
    {
        $save = $this->save();
        return $save;
    }

    public function makeGif($imgTab = array())
    {
        foreach ($imgTab as $value) {
            $image = imagecreatefrompng($value);

            ob_start();
            imagegif($image);
            $frames[]=ob_get_contents();
            $framed[]=20;

            ob_end_clean();
        }
        $gif = new GIFEncoder($frames, $framed, 0, 2, 0, 0, 0, 'bin');
        file_put_contents($this->srcFolder . $this->src . '.gif', $gif->GetAnimation());
        $this->type = 'gif';
    }

    public function delete($src)
    {

    }
}
