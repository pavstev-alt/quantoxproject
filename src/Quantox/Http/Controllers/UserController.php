<?php

namespace Quantox\Http\Controllers;

use Quantox\Http\Controllers\BaseController;
use Quantox\User\Manager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends BaseController
{
    public function login(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->params();

        $userManager = new Manager();

        $loginSuccessful = $userManager->attemptLogin(
            $data['email'] ?? '',
            $data['password'] ?? ''
        );

        if ($loginSuccessful) {
            return $this->redirect('/');
        }

        return $this->renderView('login', [
            'errorMessage' => 'Incorrect email or password.',
        ]);
    }

    public function register(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->params();

        $userManager = new Manager();

        $errors = $userManager->validate($data);

        if (!empty($errors['email'])
            || !empty($errors['password'])
            || !empty($errors['name'])
        ) {
            return $this->renderView('register', [
                'errors' => $errors,
            ]);
        }

        $userManager->create($data);

        return $this->redirect('/');
    }
}
