<?php
namespace App\Model;

use App\vendor\Request\Request;
/**
*
*/
class Users extends Model
{
    protected $table = 'user_cam';
    protected $champs = array('pseudo', 'password', 'mail', 'valide', 'token', 'expire');

    public function pictures($option = false)
    {
        return $this->hasMany('App\Model\Pictures', 'user_cam_id', $option);
    }

    public function saveUser(Request $req)
    {
        $this->pseudo = $req->input('pseudo');
        $this->mail = $req->input('mail');
        $this->password = $this->encryptPass($req->input('pass'));
        $this->save();
    }

    public function validPseudo(Request $req)
    {
        if ($req->input('pseudo') && $this->where([['pseudo','=',$req->input('pseudo')]])->get() == false) {
            return true;
        }
        return false;
    }

    public function validPassword(Request $req)
    {
        if (($pass = $req->input('pass')) && ($pass1 = $req->input('passTwo')) && ($len = strlen($pass)) < 50 && $len >= 8 && $pass === $pass1) {
            return true;
        }
        return false;
    }

    public function validMail(Request $req)
    {
        if ($req->input('mail') && $this->where([['mail','=',$req->input('mail')]])->get() == false) {
            return true;
        }
        return false;
    }

    public function identValid(Request $req)
    {
        $user = $this->where([['pseudo', "=", $req->input('pseudo')],['password', '=', $this->encryptPass($req->input('pass'))]])
            ->whereOr([['mail', '=', $req->input('pseudo')], ['password', '=', $this->encryptPass($req->input('pass'))]])
            ->get();
        return $user;
    }

    public function encryptPass($donnees)
    {
        $donnees .= 'cestpourtonbien'.$donnees;
        $donnees=  sha1($donnees);
        $donnees = strtolower($donnees);
        $search = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $replace = array('25-(5Y','327)àç(A','2_è(\'5E','DEDE&éà)ç585','8àçé&)74DDZ','K&éDZ&874','JHJ&&=)K4558','jZ&=àçDj874','zdZ&=)D457','zdzd&àa8zdDZ','zdZ&à&çZDDAASS478','48à&ç&ç7DEZS','DD&ç&çRAS7854','ZD&)&à574z','EF&)àçz874','jiHG85zsd','548ZDAd','KJ58ZS4','ZDZ458','51zdZZD','ZDZDqdsd87','SDsszDZ','4588EDFSQ','zefze58','hgezjyufze-25:;','dss584-è_');
        $donnees= str_replace($search, $replace, $donnees);
        $donnees=  sha1($donnees);
        return $donnees;
    }

}
