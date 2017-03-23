<?php
namespace App\Model;

use App\vendor\Request\Request;
use App\Model\Pictures;
use App\Lib\Mail;

/**
*
*/
class Commentaires extends Model
{
    protected $table = 'commentaires';
    protected $champs = array('id_commentaires', 'commentaires', 'users_id', 'pictures_id', 'time');

    public function users($option = false)
    {
        return $this->belongsTo('App\Model\Users', 'id_users', $option);
    }

    public function create(Request $req, $user, Pictures $picture)
    {
        $this->commentaires = trim($req->input('commentaire'));
        $this->pictures_id = $req->input('id_picture');
        $this->users_id = $user->id_users;
        $newCome = $this->save();
        $user = $newCome->users()->pseudo;
        $ret = array('com' => $newCome, 'user' => $user);
        $picUser = $picture->users();
        $to        = $picUser->mail;
        $object    = $picUser->pseudo.', vous avez recu un nouveau commentaires';
        $message   = $user.' vient de commenter une de vos photos : <br/>
                      '.$this->commentaires;
        $mail = new Mail($to, $object, $message);
        $mail->send();
        return $ret;
    }
}
