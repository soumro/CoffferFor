<?php

declare(strict_types=1);

namespace coffeforme\Controller;

use coffeforme\Kernel\Input;
use coffeforme\Kernel\PhpTemplate\View;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\SendmailTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email as EmailMessage;

class Homepage extends Base
{
    // private bool $isLoggedIn;
    // private UserSessionService $userSessionService;
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn = $this->userSessionService->isLoggedin();
    }
    public function index(): void
    {
        $viewVariables = ['isLoggedIn' => $this->isLoggedIn];
        if ($this->userSessionService->isLoggedin()) {
            $viewVariables['name'] = $this->userSessionService->getName();
        }
        View::output('home/index', 'Homepage', $viewVariables);
    }

    public function edit(): void
    {
        echo 'Edit';
    }
    public function about(): void
    {
        $viewVariables = [
            'isLoggedIn' => $this->isLoggedIn,
            'siteName' => $_ENV['SITE_NAME'],
            'contactEmail' => $_ENV['ADMIN_EMAIL']
        ];

        View::output('home/about', 'About', $viewVariables);
    }

    public function contact(): void
    {
        $viewVariables = [
            'isLoggedIn' => $this->isLoggedIn
        ];
        if (Input::postExists('contact_submit')) {
            $name = Input::post('name');
            $email = Input::post('email');
            $message = Input::post('message');

            if (isset($name, $email, $message)) {
                try {
                    $transport = new SendmailTransport('/usr/sbin/sendmail -t');
                    $mailer = new Mailer($transport);
                    $emailMessage = new EmailMessage();
                    $emailMessage->from(new Address(escape($email), escape($name)));
                    $emailMessage->to(new Address($_ENV['ADMIN_EMAIL'], $_ENV['SITE_NAME']));
                    $emailMessage->subject('Contact Form');
                    $emailMessage->priority(EmailMessage::PRIORITY_NORMAL);
                    $emailMessage->text(escape($message));
                    $mailer->send($emailMessage);
                    $viewVariables[View::SUCCESS_MESSAGE_KEY] = 'Message Sent';
                } catch (TransportExceptionInterface $error) {
                    error_log($error->getMessage());
                    $viewVariables[View::ERROR_MESSAGE_KEY] = 'An Error Message Occured Try Again Later';
                }
            } else {
                $viewVariables[View::ERROR_MESSAGE_KEY] = 'All Fields are Required';
            }
        }
        View::output('home/contatc', 'Contact', $viewVariables);
    }
}