<?php
namespace Simplecode\Mail;

use Simplecode\Mail\MailerFluent;

class Mail {
    

    /**
     * Envoie de mail
     *
     * @return MailerFluent
     */
    public static function mail ():MailerFluent {
        $mail = new MailerFluent;
        return $mail;
    }
}