<?php

declare(strict_types=1);

namespace coffeforme\Controller;

use coffeforme\Kernel\PhpTemplate\View;
use coffeforme\Kernel\Session;
use coffeforme\Service\UserSession as UserSessionService;

class Base
{
    protected UserSessionService $userSessionService;
    protected bool $isLoggedIn;
    public function __construct()
    {
        $this->userSessionService = new UserSessionService(new Session);
        $this->isLoggedIn = $this->userSessionService->isLoggedin();

    }
    public function pageNotfound(): void
    {
        header('HTTP/1.1 404 Not Found');

        $viewVariables = [
            'isLoggedIn' => $this->isLoggedIn
        ];

        View::output('not-found', 'Page Not Found', $viewVariables);
    }
}