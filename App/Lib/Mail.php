<?php
namespace App\Lib;

/**
*
*/
class Mail
{
    public $object = '';
    public $message = '';
    public $headers;
    public $to = '';

    function __construct($to = '',$object = '', $message = '', $from = 'damien.altman42@gmail.com', $reply = 'No-reply')
    {
        $this->to = $to;
        $this->headers  = 'From: '.$from."\r\n";
        $this->headers .= 'Reply-To:'.$reply."\r\n";
        $this->headers .= 'MIME-Version: 1.0' . "\r\n";
        $this->headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $this->object = $object;
        $this->message = $message;
    }

    public function send()
    {
        mail($this->to, $this->object, $this->message, $this->headers);
    }
}
