<?php

namespace Quantox\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Quantox\Database\DbRepository;
use Quantox\Views\Renderer;
use Zend\Diactoros\Response as ZendResponse;
use Zend\Diactoros\Response\RedirectResponse as ZendRedirectResponse;

abstract class BaseController
{
    protected function renderView(string $fileName, array $data = []): ResponseInterface
    {
        $html = Renderer::render($fileName . '.html', $data);

        $response = new ZendResponse();
        $response->getBody()->write($html);

        return $response;

    }

    protected function isUserLoggedIn(): bool
    {
        if (isset($_SESSION['user_email'])) {
            return true;
        }

        return false;
    }

    protected function getCurrentUsername(): string
    {
        $email = $_SESSION['user_email'];

        $db = new DbRepository();

        $user = $db->get('users', [
            'email' => $email,
        ]);

        return $user['name'] ?? '';
    }

    protected function redirect(string $uri, int $status = 302): ResponseInterface
    {
        return new ZendRedirectResponse($uri, $status);
    }
}
