<?php

namespace Apacz\MailBundle\Service;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\TwigBundle\TwigEngine;

class AbstractMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var TwigEngine
     */
    private $twig;

    /**
     * @var
     */
    private $from;

    private $subject;

    private $view;

    private $to;

    public $params = array();


    public function __construct(\Swift_Mailer $mailer,$from, TwigEngine $twig)
    {
        $this->mailer = $mailer;
        $this->from = $from;
        $this->twig = $twig;

    }

//    abstract function prepare();

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param mixed $view
     */
    public function setView($view)
    {
        $this->view = $view;
    }



    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }


    /**
     * @param mixed $to
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    public function send(){
//        $this->prepare();
        $message = \Swift_Message::newInstance()
            ->setSubject($this->getSubject())
            ->setFrom($this->from)
            ->setTo($this->getTo())
            ->setBody($this->twig->render(
                $this->view,$this->params),
                'text/html'
            );

        return $this->mailer->send($message);
    }

    public function __set($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }


}
