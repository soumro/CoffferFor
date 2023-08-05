<?php

//use coffeforme\Kernel\Http\Router;
namespace coffeforme;

use coffeforme\Kernel\Http\Router;
use coffeforme\Kernel\PhpTemplate\ViewNotFound;
use coffeforme\Kernel\Session;
use coffeforme\Service\UserSession as UserSessionService;
use Exception;

$userSession = new UserSessionService(new Session());
// use coffeforme\Kernel\Http\Router;
try {

    Router::get('/', 'Homepage@index');
    Router::get('/about', 'Homepage@about');
    Router::getAndPost('/contact', 'Homepage@contact');

    if (!$userSession->isLoggedin()) {

        Router::getAndPost('/signup', 'Account@signUp');
        Router::getAndPost('/signin', 'Account@signIn');
    }
    if ($userSession->isLoggedin()) {


        Router::getAndPost('/account/edit', 'Account@edit');
        Router::getAndPost('/account/password', 'Account@password');
        Router::getAndPost('/payment', 'Payment@payment');
        Router::getAndPost('/item', 'Payment@item');
        Router::get('/payment/show', 'Payment@showItem');
        Router::get('/account/logout', 'Account@logout');
    }
    Router::end();
} catch (Exception $err) {
    echo $err->getMessage();
}