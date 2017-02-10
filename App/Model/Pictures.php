<?php
namespace App\Model;

use App\vendor\Request\Request;
/**
*
*/
class Pictures extends Model
{

    protected $table = 'pictures';
    protected $champs = array('src', 'vote', 'del', 'time', 'user_cam_id');
    protected $data;


    public function makePicture(Request $req)
    {
        $dataURL = $req->input('donnee');
        $parts = explode(',', $dataURL);
        $this->data = $parts[1];
        $this->data = str_replace(' ', '+', $this->data);
        $this->data = base64_decode($this->data);
        $this->src = sha1(time().rand(1,20000).$req->input('token').time());
        file_put_contents('src/imgsave/'.$this->src.'.png', $this->data);
        $this->savePicture();
    }

    public function savePicture()
    {
        $this->time = time();
        $save = $this->save();
        return $save;
    }
}
