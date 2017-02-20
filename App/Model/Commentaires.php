<?php
namespace App\Model;

use App\vendor\Request\Request;

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

    public function create(Request $req, $user)
    {
        $this->commentaires = trim($req->input('commentaire'));
        $this->pictures_id = $req->input('id_picture');
        $this->users_id = $user->id_users;
        $newCome = $this->save();
        $user = $newCome->users()->pseudo;
        $ret = array('com' => $newCome, 'user' => $user);
        return $ret;
    }
}
