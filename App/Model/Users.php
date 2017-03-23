<?php
namespace App\Model;

use App\vendor\Request\Request;
use App\Lib\Mail;

/**
*
*/
class Users extends Model
{
    protected $table = 'users';
    protected $champs = array('id_users','pseudo', 'password', 'mail', 'valide', 'token', 'expire');

    public function pictures($option = false)
    {
        return $this->hasMany('App\Model\Pictures', 'users_id', $option);
    }

    public function saveUser(Request $req)
    {
        $this->pseudo = $req->input('pseudo');
        $this->mail = $req->input('mail');
        $this->password = $this->encryptPass($req->input('pass'));
        $this->save();
        $to        = $this->mail;
        $object    = 'Confirmez votre inscription sur Camagru';
        $message   = 'Pour confirmez votre inscription merci de clicker sur le lien suivant :<br/>
                     <a href="http://'.$_SERVER['HTTP_HOST'].'/confirme/'.$this->id_users.'/'.$this->encryptPass($this->pseudo.$this->password).'">Confirmer votre adresse mail</a>';
        $mail = new Mail($to, $object, $message);
        $mail->send();
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
        $user = $this->where([['pseudo', "=", $req->input('pseudo')],['password', '=', $this->encryptPass($req->input('pass'))],['valide', '=', 1]])
            ->whereOr([['mail', '=', $req->input('pseudo')]])
            ->where([['password', '=', $this->encryptPass($req->input('pass'))]])
            ->get();
        if ($user) {
            $this->createToken($user[0]);
            return true;
        }
        return false;
    }

    private function createToken(Users $user, $session = true)
    {
        $user->token = $user->encryptPass(time().rand(0, 10000).$user->pseudo.$user->mail.time());
        $user->expire + (7 * 24 * 60 * 60);
        $user->update();
        if ($session == true) {
            $_SESSION['token'] = $user->token;
        }
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

    public function confirme($id, $hash)
    {
        $user = $this->where([['id_users', '=', $id]])->get();
        if ($user) {
            $h = $this->encryptPass($user[0]->pseudo.$user[0]->password);
            if ($h == $hash) {
                $user[0]->valide = 1;
                $user[0]->update();
                $this->createToken($user[0]);
                return true;
            }
        }
        return false;
    }

    public function resetPassword($req)
    {
        if ($use = $this->where([['mail', '=', $req->input('email')]])->get()) {
            $use = $use[0];
            $use->createToken($use, false);
            $to        = $use->mail;
            $object    = 'Vous avez demandez à changer de mot de passe';
            $message   = 'Pour changer votre mot de passe merci de clicker sur le lien suivant :<br/>
                          <a href="http://'.$_SERVER['HTTP_HOST'].'/changepass/'.$use->id_users.'/'.$this->encryptPass($use->pseudo.$use->password.$use->token).'">Changer de mot de passe</a>';
            $mail = new Mail($to, $object, $message);
            $mail->send();
        }
    }

    public function changePass($id, $hash)
    {
        $user = $this->where([['id_users', '=', $id]])->get();
        if ($user) {
            $h = $this->encryptPass($user[0]->pseudo.$user[0]->password.$user[0]->token);
            if ($h == $hash) {
                return true;
            }
        }
        return false;
    }
    public function newPassword(Request $req)
    {
        $user = $this->where([['id_users', '=', $req->input('id')]])->get();
        if ($user) {
            $h = $this->encryptPass($user[0]->pseudo.$user[0]->password.$user[0]->token);
            if ($h == $req->input('hash') && $this->validPassword($req)) {
                $user[0]->password = $user[0]->encryptPass($req->input('pass'));
                $user[0]->update();
                return true;
            }
        }
        return false;
    }
}
