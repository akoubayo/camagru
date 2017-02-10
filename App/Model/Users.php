<?php
namespace App\Model;

use App\vendor\Request\Request;
/**
*
*/
class Users extends Model
{
    protected $table = 'user_cam';
    protected $champs = array('pseudo', 'password', 'mail', 'valide');

    public static function maClass()
    {
        return __CLASS__;
    }

    public function saveUser(Request $req)
    {
        $this->pseudo = $req->input('pseudo');
        $this->mail = $req->input('mail');
        $this->password = $req->input('pass');
        $this->save();
    }
}
