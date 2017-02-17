<?php
namespace App\Model;

use App\vendor\Request\Request;

/**
*
*/
class Pictures extends Model
{

    protected $table = 'pictures';
    protected $champs = array('src', 'vote', 'del', 'time', 'users_id');
    protected $data;

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
        $dataURL = $req->input('donnee');
        $parts = explode(',', $dataURL);
        $this->data = $parts[1];
        $this->data = str_replace(' ', '+', $this->data);
        $this->data = base64_decode($this->data);
        $this->src = sha1(time().rand(1, 20000).$req->input('token').time());
        $this->createSup($req);
        $this->savePicture();
    }


    public function createSup(Request $req)
    {
        $destination = imagecreatefrompng(str_replace(' ', '+', $_POST['donnee']));
        $i = 0;
        while ($req->input("src$i")) {
            $largeur_source = $req->input('width' . $i);
            $hauteur_source = $req->input('height' . $i);
            $src = substr($req->input('src' . $i), 1);
            $source = imagecreatefrompng($src);
            $newImg = $this->redimensionner($src, $source, $largeur_source, $hauteur_source);
            $largeur_destination = $req->input('width');
            $hauteur_destination = $req->input('height');
            $destination_x = $req->input('dataX' . $i);
            $destination_y =  $req->input('dataY' . $i);
            imagecopy($destination, $newImg, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);
            $i++;
        }
        imagepng($destination, 'src/imgsave/' . $this->src . '.png');
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
        $this->time = time();
        $save = $this->save();
        return $save;
    }

    public function makeGif($imgTab = array())
    {
        $text = "Hello World";
        foreach ($imgTab as $value) {
            $image = imagecreatefrompng('src/imgsave/' . $value . '.png');

            ob_start();
            imagegif($image);
            $frames[]=ob_get_contents();
            $framed[]=20;

            ob_end_clean();
        }

        $gif = new GIFEncoder($frames, $framed, 0, 2, 0, 0, 0, 'bin');
        file_put_contents('src/imgsave/gif.gif', $gif->GetAnimation());
    }
}
