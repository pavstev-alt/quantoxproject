<?php

namespace Quantox\Http\Controllers;

use Quantox\Http\Controllers\BaseController;
use Quantox\User\Manager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Controller extends BaseController
{
    public function home(ServerRequestInterface $request): ResponseInterface
    {
        $username = $this->isUserLoggedIn() ? $this->getCurrentUsername() : '';

        if ($username !== '') {
            $username = ", $username!";
        }

        return $this->renderView('home', [
            'username' => $username,
        ]);
    }

    public function login(): ResponseInterface
    {
        return $this->renderView('login');
    }

    public function register(): ResponseInterface
    {
        return $this->renderView('register');
    }

    public function results(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->isUserLoggedIn()) {
            return $this->redirect('/login');
        }

        $data = $request->params();

        $manager = new Manager();

        $users = $manager->get($data['query'] ?? '');

        return $this->renderView('results', [
            'users' => $users,
        ]);
    }
}
