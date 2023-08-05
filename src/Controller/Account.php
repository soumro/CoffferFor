<?php

declare(strict_types=1);

namespace coffeforme\Controller;

use coffeforme\Kernel\Input;
use coffeforme\Kernel\PhpTemplate\View;
use coffeforme\Kernel\Session;
use coffeforme\Service\User as UserService;
use coffeforme\Service\UserSession as UserSessionService;
use coffeforme\Service\UserValidation;


class Account
{

    private UserSessionService $userSessionService;
    private UserValidation $userValidation;
    private UserService $userService;
    private bool $isLoggedIn;
    public function __construct()
    {
        $this->userSessionService = new UserSessionService(new Session());
        $this->userValidation = new UserValidation();
        $this->userService = new UserService();
        $this->isLoggedIn = $this->userSessionService->isLoggedin();

    }
    public function signUp(): void
    {
        $viewVariables = [];
        if (Input::postExists('signup_submit')) {



            $fullname = Input::post('fullname');
            $email = Input::post('email');
            $password = Input::post('password');

            if (isset($fullname, $email, $password)) {
                if (
                    $this->userValidation->isEmailValid($email) &&
                    $this->userValidation->isPasswordValid($password)
                ) {
                    if ($this->userService->doesAccountEmailExists($email)) {
                        $viewVariables[view::ERROR_MESSAGE_KEY] = 'Account Already Exists';
                    } else {
                        $user = [
                            'fullname' => $fullname,
                            'email' => $email,
                            'password' => $this->userService->hashPassword($password)
                        ];
                        if ($userId = $this->userService->create($user)) {

                            $this->userSessionService->setAuthentication($userId, $email, $fullname);
                            redirect('/');
                        } else {
                            $viewVariables[View::ERROR_MESSAGE_KEY] = 'An Error has Occured While creating Your Account, Please Try Again';
                        }
                    }

                } else {
                    $viewVariables[View::ERROR_MESSAGE_KEY] = 'Email/Password is not Valid';
                }
            } else {
                $viewVariables[View::ERROR_MESSAGE_KEY] = 'All Fields are Required';
            }
        }
        View::output('account/signup', 'Sign Up');
    }

    public function signIn(): void
    {
        $viewVariables = [];

        if (Input::postExists('signin_submit')) {
            $email = Input::post('email');
            $password = Input::post('password');

            $userDetails = $this->userService->getDetailsFromEmail($email);
            // var_dump($userDetails);
            $isLoginValid = !empty($userDetails->PASSWORD) && $this->userService->verifyPassword($password, $userDetails->PASSWORD);

            if ($isLoginValid) {
                $this->userSessionService->setAuthentication($userDetails->userID, $userDetails->email, $userDetails->fullname);
                redirect('/');
            } else {
                $viewVariables[View::ERROR_MESSAGE_KEY] = 'Incorrect login.';
            }
        }

        View::output('account/signin', 'Sign In', $viewVariables);
    }

    public function edit(): void
    {
        $viewVariables = [];
        $userId = $this->userSessionService->getId();
        $userDetails = $this->userService->getDetailsFromId($userId);

        $viewVariables += [
            'user' => $userDetails,
            'isLoggedIn' => $this->isLoggedIn
        ];
        // echo $userId;
        // var_dump($userDetails);

        if (Input::postExists('edit_submit')) {
            $name = Input::post('name');
            $email = Input::post('email');

            // echo $name;
            if (isset($email, $name)) {
                $hasEmailChanged = $email !== $userDetails->email;
                $hasNameChanged = $name !== $userDetails->fullname;
                if ($hasEmailChanged) {
                    if (!$this->userValidation->isEmailValid($email) || $this->userService->doesAccountEmailExists($email)) {
                        $viewVariables[View::SUCCESS_MESSAGE_KEY][] = 'The same email is incorrect or already exist.';
                    } else {
                        $this->userService->updateEmail($userId, $email);
                        $viewVariables[View::SUCCESS_MESSAGE_KEY][] = 'Your Email has been updated.';

                    }
                }

                if ($hasNameChanged) {
                    if (!$this->userValidation->isNameValid($name)) {
                        $viewVariables[View::SUCCESS_MESSAGE_KEY][] = 'The name is too shor are too long.';
                    } else {
                        $this->userService->updateName($userId, $name);
                        $viewVariables[View::SUCCESS_MESSAGE_KEY][] = 'Your Name has been updated.';
                    }
                } else {
                    $viewVariables[View::ERROR_MESSAGE_KEY] = 'The same already Exist or Incoorect';
                }
            } else {
                $viewVariables[View::ERROR_MESSAGE_KEY] = 'All fields are required.';
            }

        }


        View::output('account/edit', 'Edit Account', $viewVariables);
    }
    public function password(): void
    {
        $viewVariables = [
            'isLoggedIn' => $this->isLoggedIn
        ];
        $userId = $this->userSessionService->getId();
        if (Input::postExists('password_submit')) {

            $currentpassword = Input::postExists('current_password');
            $newpassword = Input::post('new_password');
            $confrimpassword = Input::post('confirm_password');

            if ($this->userService->getHashedPassword($userId)) {

                if ($newpassword === $confrimpassword) {
                    if ($this->userValidation->isPasswordValid($newpassword)) {
                        $hasedPassword = $this->userService->hashPassword($newpassword);
                        $this->userService->updatePassword($userId, $hasedPassword);
                        $viewVariables[View::SUCCESS_MESSAGE_KEY] = 'Password Successfully Updated.';
                    } else {
                        $viewVariables[View::ERROR_MESSAGE_KEY] = 'Password is weak';
                    }
                } else {
                    $viewVariables[View::ERROR_MESSAGE_KEY] = 'Password No Matched';
                }
            } else {
                $viewVariables[View::ERROR_MESSAGE_KEY] = 'Your current password is incorrect';
            }
        }
        View::output('account/password', 'Edit Password', $viewVariables);
    }
    public function logout()
    {
        $this->userSessionService->logout();
        //Redirect the user to index page
        redirect();
    }
}