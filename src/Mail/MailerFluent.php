<?php

namespace Simplecode\Mail;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Simplecode\Protocole\Http\Response;

class MailerFluent
{
    /**
     * Recepteur
     *
     * @var string
     */
    protected $to = '';

    /**
     * Expéditeur
     *
     * @var string
     */
    protected $from = '';

    /**
     * Sujet du message
     *
     * @var string
     */
    protected $subject = '';

    /**
     * E-mail de réponse
     *
     * @var string
     */
    protected $reply = '';

    /**
     * Contenue du message
     *
     * @var string
     */
    protected $message = '';

    /**
     * Le html pour la vue
     *
     * @var string
     */
    protected $view = '';

    /**
     * Le mailer
     * @var PHPMailer
     */
    public $mailer;

    /**
     * Les données de la vue
     * @return array
     */
    protected $data = [];


    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
    }

    /**
     * Recepteur du message
     *
     * @param string $email
     * @return MailerFluent
     */
    public function to(string $email, string $name = ''): MailerFluent
    {
        $this->to = $email;
        $this->data['to'] = $email;
        $this->mailer->addAddress($email, $name);
        return $this;
    }

    /**
     * L'expéditeur du message
     *
     * @param string $email
     * @param string $name
     * @return MailerFluent
     */
    public function from(string $email, string $name = ''): MailerFluent
    {
        $this->from = $email;
        $this->data['from'] = $email;
        $this->mailer->setFrom($email, $name);

        return $this;
    }


    /**
     * L'e-mail de réponse
     *
     * @param string $address
     * @param string $id
     * @return MailerFluent
     */
    public function replyTo(string $address, string $id = ''): MailerFluent
    {
        $this->mailer->addReplyTo($address, $id);
        $this->data['replyTo'] = $address;
        return $this;
    }


    /**
     * Les adresses cc
     *
     * @param string $cc
     * @return MailerFluent
     */
    public function cc(string $cc): MailerFluent
    {
        $this->mailer->addCC($cc);
        $this->data['cc'] = $cc;
        return $this;
    }

    /**
     * Les adresses bcc
     *
     * @param string $bcc
     * @return MailerFluent
     */
    public function bcc(string $bcc): MailerFluent
    {
        $this->mailer->addBCC($bcc);
        $this->data['bcc'] = $bcc;
        return $this;
    }


    /**
     * Attache un fichier au mail
     *
     * @param string $filename
     * @param string $optional
     * @return MailerFluent
     */
    public function attach(string $filename, string $optional = ""): MailerFluent
    {
        $this->mailer->addAttachment($filename, $optional);
        $this->data['attach'] = $$filename;
        return $this;
    }
    /**
     * Le sujet du message
     *
     * @param string $subject
     * @return MailerFluent
     */
    public function subject(string $subject): MailerFluent
    {
        $this->subject = $subject;
        $this->mailer->Subject = $subject;
        $this->data['subject'] = $subject;
        return $this;
    }

    /**
     * Le corps du message text/plain
     *
     * @param string $message
     * @return MailerFluent
     */
    public function message(string $message): MailerFluent
    {
        $this->message = $message;
        $this->data['message'] = $message;

        return $this;
    }

    /**
     *Le html à envoyer
     *
     * @param string $view
     * @param string $ext
     * @return MailerFluent
     */
    public function view(string $view, string $ext = 'php'): MailerFluent
    {
       
        $view = joinPath(VIEWS_DIR, $view);

        $this->mailer->isHTML(true);
        if (is_file($view)) {
            $this->view = $view;
        }
        return $this;
    }

    /**
     * Relie les données à la vue
     *
     * @param array $data
     * @return MailerFluent
     */
    public function bind(array $data): MailerFluent
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * Set smtp
     *
     * @return $this
     */
    public function smtp()
    {
        $this->mailer->isSMTP();

        return $this;
    }

    /**
     * Envoie le message
     *
     * @return boolean
     */
    public function send(): bool
    {
        $this->prepare();
        try {
           
            $this->mailer->Body = $this->message;
            
            return $this->mailer->send();
        } catch (Exception $e) {
           die($e);
        }
    }

    /**
     * Stimule le résulat sur le navigateur
     *
     * @return string
     */
    public function look()
    {    $this->prepare();
        try {
            //$this->varRequirement($this->message);
        } catch (\Exception $th) {
            die($th);
        }
        $response = new Response($this->message);

        return $response;
    }

    /**
     * Setup sendind to mailtrap
     *
     * @return $this
     */
    function config()
    {
        
        $this->mailer->Host = config('mailer.host');
        $this->mailer->Port = config('mailer.port');
        $this->mailer->Username= config("mailer.username");
        $this->mailer->Password = config('mailer.password');
        $this->mailer->SMTPAuth = config('mailer.auth');
        $this->smtp();
        return $this;
    }

    private function prepare(){
        
        $this->mailer->CharSet ="UTF-8" ;
        if ($this->view !='') {
            extract($this->data, EXTR_SKIP);
            
            ob_start();
            require $this->view;
            $this->message = ob_get_clean();
        }
    }
}
