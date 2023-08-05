<?php

declare(strict_types=1);

namespace coffeforme\Service;

use coffeforme\Kernel\Session;

class UserSession
{
    private Session $session;
    public const USER_ID_SESSION_NAME = 'userId';

    public function __construct(Session $session)
    {
        $this->session = $session;


    }
    public function isLoggedin(): bool
    {
        return $this->session->doesExists(self::USER_ID_SESSION_NAME);
    }
    public function getName(): string
    {
        return $this->session->get('fullname');
    }
    public function setAuthentication(string|int $userId, string $email, string $fullname)
    {
        $this->session->sets([
            self::USER_ID_SESSION_NAME => $userId,
            'email' => $email,
            'fullname' => $fullname
        ]);
    }

    public function logout()
    {
        $this->session->destroy();
    }

    public function getId(): string
    {

        return $this->session->get(self::USER_ID_SESSION_NAME);
    }
}