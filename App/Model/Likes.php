<?php
namespace App\Model;

use App\vendor\Request\Request;
use App\Model\Pictures;
use App\Model\Users;
use App\Lib\Mail;

/**
*
*/
class Likes extends Model
{
    protected $table = 'likes';
    protected $champs = array('id_likes', 'users_id', 'pictures_id');

    public function pictures($option = false)
    {
        return $this->belongsTo('App\Model\Pictures', 'id_pictures', $option);
    }

    public function addLikes(Users $me, Request $req)
    {
        $id_pict = (int)$req->input('id_picture');
        $like = $this->where([['users_id', '=', $me->id_users], ['pictures_id', '=', $id_pict]])->get();
        if (!$like) {
            $this->users_id = $me->id_users;
            $this->pictures_id = $id_pict;
            $this->save();
            $pict = $this->pictures();
            $pict->vote++;
            $pict->update();
            return ['vote' => $pict->vote];
        } else {
            return ['error' => '1'];
        }
    }
}
